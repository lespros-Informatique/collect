-- ===================================================
-- SYSTÈME GPS LIVREUR - GUIDE D'UTILISATION
-- ===================================================

-- Le système GPS fonctionne avec la table `suivi_livraison` qui stocke :
-- 1. Position GPS du livreur en temps réel
-- 2. Historique complet des déplacements
-- 3. Liaison avec les commandes et livreurs

-- ===================================================
-- EXEMPLE D'UTILISATION PRATIQUE
-- ===================================================

-- 1. QUAND UN LIVREUR COMMENCE UNE LIVRAISON
INSERT INTO suivi_livraison (commande_id, user_id, latitude, longitude, statut, mise_a_jour)
VALUES (1, 2, 5.3600, -4.0083, 'en route', NOW());
-- Commande ID: 1, Livreur ID: 2, Position: Abidjan Plateau

-- 2. MISE À JOUR AUTOMATIQUE DE LA POSITION (toutes les 30 secondes)
UPDATE suivi_livraison 
SET latitude = 5.3650, longitude = -4.0120, mise_a_jour = NOW()
WHERE commande_id = 1 AND user_id = 2;

-- 3. MISE À JOUR AVEC ON DUPLICATE KEY (recommandé)
INSERT INTO suivi_livraison (commande_id, user_id, latitude, longitude, statut, mise_a_jour)
VALUES (1, 2, 5.3700, -4.0150, 'en route', NOW())
ON DUPLICATE KEY UPDATE
latitude = VALUES(latitude), 
longitude = VALUES(longitude), 
mise_a_jour = NOW();

-- ===================================================
-- REQUÊTES UTILES POUR LES LIVREURS
-- ===================================================

-- Obtenir la dernière position d'un livreur
SELECT sl.*, c.code_commande, u.nom as nom_livreur
FROM suivi_livraison sl
JOIN commandes c ON sl.commande_id = c.id_commande
JOIN users u ON sl.user_id = u.id_user
WHERE sl.user_id = 2
ORDER BY sl.mise_a_jour DESC
LIMIT 1;

-- Historique complet des positions d'un livreur aujourd'hui
SELECT sl.*, c.code_commande
FROM suivi_livraison sl
JOIN commandes c ON sl.commande_id = c.id_commande
WHERE sl.user_id = 2 
AND DATE(sl.mise_a_jour) = CURDATE()
ORDER BY sl.mise_a_jour DESC;

-- Toutes les positions GPS de toutes les livraisons en cours
SELECT sl.*, c.code_commande, u.nom as nom_livreur, cl.nom as nom_client
FROM suivi_livraison sl
JOIN commandes c ON sl.commande_id = c.id_commande
JOIN users u ON sl.user_id = u.id_user
JOIN clients cl ON c.client_id = cl.id_client
WHERE c.statut = 'en route'
ORDER BY sl.mise_a_jour DESC;

-- ===================================================
-- GÉOLOCALISATION DEPUIS UNE ADRESSE
-- ===================================================

-- Pour convertir une adresse en coordonnées GPS, vous pouvez :
-- 1. Utiliser l'API Google Maps Geocoding
-- 2. Utiliser OpenStreetMap Nominatim (gratuit)
-- 3. Demander la permission GPS au client

-- Exemple d'adresse à convertir :
-- "Plateau, Abidjan, Côte d'Ivoire"
-- Résultat probable : 5.3600, -4.0083

-- ===================================================
-- INTÉGRATION JAVASCRIPT
-- ===================================================

/*
// Code JavaScript pour envoyer la position GPS
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        // Envoyer la position au serveur
        $.ajax({
            url: '/livreur/update-position',
            method: 'POST',
            data: {
                commandeId: 1,
                latitude: position.coords.latitude,
                longitude: position.coords.longitude
            },
            success: function(response) {
                console.log('Position GPS mise à jour');
            }
        });
    });
}
*/