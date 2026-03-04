-- ===================================================
-- EXEMPLE DE DONNÉES DE TEST POUR LE GPS LIVREUR
-- ===================================================

-- Créer un livreur de test
INSERT INTO users (code_user, nom, telephone, email, password, role, actif) VALUES 
('LIV-001', 'Ibrahim Traore', '+22507123456', 'ibrahim.traore@restaurant.com', '$2y$10$hashed_password', 'livreur', 1);

-- Créer quelques clients avec adresses détaillées
INSERT INTO clients (code_client, nom, telephone, adresse, email, password) VALUES 
('CLI-001', 'Jean Kouadio', '+22505234567', 'Cocody Riviera, Abidjan, Côte d''Ivoire', 'jean.kouadio@email.com', '$2y$10$hashed_password'),
('CLI-002', 'Marie Bah', '+22504345678', 'Plateau, Avenue Lamblin, Abidjan, Côte d''Ivoire', 'marie.bah@email.com', '$2y$10$hashed_password'),
('CLI-003', 'Paul Yapi', '+22503456789', 'Treichville, Marché central, Abidjan, Côte d''Ivoire', 'paul.yapi@email.com', '$2y$10$hashed_password');

-- Créer des commandes de test
INSERT INTO commandes (code_commande, client_id, total, frais_livraison, statut, paiement, adresse_livraison, instructions) VALUES 
('CMD-001', 2, 15000.00, 2000.00, 'en préparation', 'à la livraison', 'Cocody Riviera, Abidjan, Côte d''Ivoire', 'Sonner à l''interphone, apartment 12B'),
('CMD-002', 3, 8500.00, 1500.00, 'en préparation', 'à la livraison', 'Plateau, Avenue Lamblin, Abidjan, Côte d''Ivoire', 'Demander au réceptionniste'),
('CMD-003', 4, 22000.00, 2500.00, 'reçue', 'à la livraison', 'Treichville, Marché central, Abidjan, Côte d''Ivoire', 'Près du grand marché');

-- Ajouter des lignes de commande (plats)
INSERT INTO ligne_commande (commande_id, plat_id, quantite, prix_unitaire) VALUES 
(1, 1, 2, 5000.00), -- 2x Salade César
(1, 4, 3, 2000.00), -- 3x Coca-Cola
(2, 2, 1, 12000.00), -- 1x Pizza Margherita
(2, 4, 1, 2000.00), -- 1x Coca-Cola
(3, 2, 2, 12000.00); -- 2x Pizza Margherita

-- ===================================================
-- ASSIGNATION DE LIVRAISONS AUX LIVREURS
-- ===================================================

-- Assigner les commandes aux livreurs
-- Livreur ID: 1 (utilisateur admin) commence la livraison CMD-001
INSERT INTO suivi_livraison (commande_id, user_id, latitude, longitude, statut, mise_a_jour) VALUES 
(1, 1, 5.3600, -4.0083, 'en route', NOW());

-- Livreur ID: 1 prend la commande CMD-002
INSERT INTO suivi_livraison (commande_id, user_id, latitude, longitude, statut, mise_a_jour) VALUES 
(2, 1, 5.3150, -3.9950, 'en préparation', NOW());

-- Si vous avez un autre livreur (ID: 2), assigner CMD-003
-- INSERT INTO suivi_livraison (commande_id, user_id, latitude, longitude, statut, mise_a_jour) VALUES 
-- (3, 2, 5.2950, -3.9800, 'en préparation', NOW());

-- ===================================================
-- REQUÊTES POUR TESTER LE SYSTÈME
-- ===================================================

-- 1. Voir toutes les livraisons assignées
SELECT 
    c.code_commande,
    cl.nom as nom_client,
    cl.adresse as adresse_livraison,
    u.nom as nom_livreur,
    sl.statut,
    sl.latitude,
    sl.longitude,
    sl.mise_a_jour as derniere_position
FROM commandes c
JOIN clients cl ON c.client_id = cl.id_client
JOIN suivi_livraison sl ON c.id_commande = sl.commande_id
JOIN users u ON sl.user_id = u.id_user
WHERE c.statut IN ('en préparation', 'en route')
ORDER BY sl.mise_a_jour DESC;

-- 2. Voir la position actuelle de chaque livreur
SELECT 
    u.nom as nom_livreur,
    u.telephone,
    sl.latitude,
    sl.longitude,
    sl.mise_a_jour,
    COUNT(*) as nb_livraisons_en_cours
FROM users u
JOIN suivi_livraison sl ON u.id_user = sl.user_id
JOIN commandes c ON sl.commande_id = c.id_commande
WHERE u.role = 'livreur' AND c.statut IN ('en préparation', 'en route')
GROUP BY u.id_user;

-- 3. Mise à jour de position GPS (simulation)
-- Pour le livreur 1 (ID: 1), ajouter des positions de mouvement
INSERT INTO suivi_livraison (commande_id, user_id, latitude, longitude, statut, mise_a_jour) VALUES 
(1, 1, 5.3620, -4.0095, 'en route', NOW() + INTERVAL 5 MINUTE), -- Déplacement
(1, 1, 5.3640, -4.0110, 'en route', NOW() + INTERVAL 10 MINUTE), -- Plus proche du client
(2, 1, 5.3200, -3.9980, 'en préparation', NOW() + INTERVAL 15 MINUTE); -- Nouvelle position

-- 4. Historique GPS d'un livreur aujourd'hui
SELECT 
    c.code_commande,
    cl.nom as nom_client,
    sl.latitude,
    sl.longitude,
    sl.statut,
    sl.mise_a_jour
FROM suivi_livraison sl
JOIN commandes c ON sl.commande_id = c.id_commande
JOIN clients cl ON c.client_id = cl.id_client
WHERE sl.user_id = 1 AND DATE(sl.mise_a_jour) = CURDATE()
ORDER BY sl.mise_a_jour DESC;

-- ===================================================
-- NOTES IMPORTANTES
-- ===================================================

/*
COORDONNÉES EXEMPLES D'ABIDJAN :
- Plateau (centre ville): 5.3600, -4.0083
- Cocody: 5.3650, -4.0120
- Treichville: 5.2950, -3.9800
- Adjamé: 5.3500, -4.0200
- Yopougon: 5.3400, -4.0500

Les livreurs peuvent utiliser ces coordonnées comme points de référence
pour tester le système GPS en simulation.
*/