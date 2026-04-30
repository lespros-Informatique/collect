<?php
require_once __DIR__ . '/../../config/config.php';

class ModelInscription
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    // Obtenir toutes les inscriptions
    public function getAllInscriptions($status = ETAT[1])
    {
        try {
            $sql = 'SELECT * FROM inscriptions';
            $params = [];

            if ($status !== null) {
                $sql .= ' WHERE etat_inscription = ?';
                $params[] = $status;
            }

            $sql .= ' ORDER BY date_debut DESC';

            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute($params);

            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir une inscription par ID
    public function getInscriptionById($id)
    {
        try {
            $sql = 'SELECT * FROM inscriptions WHERE id_inscription = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$id]);
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir une inscription par code
    public function getInscriptionByCode($code)
    {
        try {
            $sql = 'SELECT * FROM inscriptions WHERE code_inscription = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$code]);
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les inscriptions par client
    public function getInscriptionsByClient($clientCode)
    {
        try {
            $sql = 'SELECT * FROM inscriptions WHERE client_code = ? ORDER BY date_debut DESC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$clientCode]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les inscriptions par commercial
    public function getInscriptionsByCommercial($userCode)
    {
        try {
            $sql = 'SELECT * FROM inscriptions WHERE user_code = ? ORDER BY date_debut DESC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$userCode]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les inscriptions par utilisateur (alias de getInscriptionsByCommercial)
    public function getInscriptionsByUser($userCode)
    {
        return $this->getInscriptionsByCommercial($userCode);
    }

    // Obtenir les kits d'une inscription (via ligne_choix)
    public function getChoixByInscription($inscriptionCode)
    {
        try {
            $sql = 'SELECT c.*, lc.code_ligne_choix, lc.created_at_ligne_choix
                    FROM ligne_choix lc
                    INNER JOIN choix c ON lc.choix_code = c.code_choix
                    WHERE lc.inscription_code = ? AND lc.etat_ligne_choix = 1
                    ORDER BY lc.created_at_ligne_choix ASC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$inscriptionCode]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les inscriptions par catégorie (via ligne_choix -> choix)
    public function getInscriptionsByCategory($categorieCode)
    {
        try {
            $sql = 'SELECT DISTINCT i.*, c.nom_client as client_nom, u.nom_user, u.prenom_user
                    FROM inscriptions i
                    LEFT JOIN clients c ON i.client_code = c.code_client
                    LEFT JOIN users u ON i.user_code = u.code_user
                    INNER JOIN ligne_choix lc ON i.code_inscription = lc.inscription_code AND lc.etat_ligne_choix = 1
                    INNER JOIN choix ch ON lc.choix_code = ch.code_choix
                    WHERE ch.categorie_code = ?
                    ORDER BY i.date_debut DESC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$categorieCode]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Ajouter une inscription
    public function addInscription($data)
    {
        return $this->validator->create('inscriptions', $data);
    }

    // Modifier une inscription
    public function updateInscription($id, $data)
    {
        return $this->validator->update('inscriptions', 'id_inscription', $id, $data);
    }

    // Supprimer une inscription (soft delete)
    public function deleteInscription($id, $reason)
    {
        try {
            $sql = 'UPDATE inscriptions SET deleted_by = ?, deleted_why = ?, deleted_at = NOW(), etat_inscription = 0 WHERE id_inscription = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$_SESSION['user']['id_user'] ?? null, $reason, $id]);
            return true;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Compter les inscriptions par commercial
    public function countInscriptionsByCommercial($userCode)
    {
        try {
            $sql = 'SELECT COUNT(*) as total FROM inscriptions WHERE user_code = ? AND etat_inscription = 1';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$userCode]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les paiements d'une inscription (tous)
    public function getPaiementsByInscription($inscriptionCode)
    {
        try {
            $sql = 'SELECT * FROM paiements WHERE inscription_code = ? AND etat_paiement = ? ORDER BY created_at_paiement DESC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$inscriptionCode, PAIEMENT_ETAT_ACTIF]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    

    // Obtenir les paiements validés d'une inscription (statut_paiement=1 ET etat_paiement=1)
    public function getPaiementsValidesByInscription($inscriptionCode)
    {
        try {
            $sql = 'SELECT * FROM paiements WHERE inscription_code = ? AND statut_paiement = ? AND etat_paiement = ? ORDER BY created_at_paiement DESC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$inscriptionCode, PAIEMENT_STATUT_VALIDE, PAIEMENT_ETAT_ACTIF]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir le montant total payé pour une inscription (paiements validés)
    public function getMontantPayeValide($inscriptionCode)
    {
        try {
            $sql = 'SELECT COALESCE(SUM(montant_paiement), 0) as total FROM paiements WHERE inscription_code = ? AND statut_paiement = ? AND etat_paiement = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$inscriptionCode, PAIEMENT_STATUT_VALIDE, PAIEMENT_ETAT_ACTIF]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir une catégorie par code
    public function getCategoryByCode($code)
    {
        try {
            $sql = 'SELECT * FROM categories WHERE code_categorie = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$code]);
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir le nombre de jours d'une inscription (via la catégorie)
    public function getNombreJourByInscription($inscriptionCode)
    {
        try {
            // D'abord trouver la catégorie via les choix de l'inscription
            $sql = 'SELECT c.nombre_jour FROM categories c
                    INNER JOIN choix ch ON ch.categorie_code = c.code_categorie
                    INNER JOIN ligne_choix lc ON lc.choix_code = ch.code_choix
                    WHERE lc.inscription_code = ?
                    LIMIT 1';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$inscriptionCode]);
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_ASSOC)['nombre_jour'] ?? 0;
            }
            return 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les inscriptions par kit (via ligne_choix)
    public function getInscriptionsByKit($kitCode)
    {
        try {
            $sql = 'SELECT i.*, c.nom_client 
                    FROM inscriptions i 
                    LEFT JOIN clients c ON i.client_code = c.code_client 
                    INNER JOIN ligne_choix lc ON i.code_inscription = lc.inscription_code
                    WHERE lc.choix_code = ? AND i.etat_inscription = 1 
                    ORDER BY i.date_debut DESC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$kitCode]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
