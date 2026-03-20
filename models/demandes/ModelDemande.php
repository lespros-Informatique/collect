<?php

class ModelDemande
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    // Obtenir toutes les demandes
    public function getAllDemandes($etat = null)
    {
        try {
            $sql = 'SELECT * FROM demandes';
            $params = [];

            if ($etat !== null) {
                $sql .= ' WHERE etat_demande = ?';
                $params[] = $etat;
            }

            $sql .= ' ORDER BY id_demande DESC';

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

    // Obtenir une demande par son code
    public function getDemandeByCode($code_demande)
    {
        try {
            $sql = 'SELECT * FROM demandes WHERE code_demande = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$code_demande]);
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les demandes par utilisateur
    public function getDemandesByUser($user_code)
    {
        try {
            $sql = 'SELECT * FROM demandes WHERE utilisateur_code = ? ORDER BY id_demande DESC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$user_code]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Créer une demande
    public function createDemande($data)
    {
        return $this->validator->create('demandes', $data);
    }

    // Modifier une demande
    public function updateDemande($code_demande, $data)
    {
        return $this->validator->update('demandes', 'code_demande', $code_demande, $data);
    }

    // Supprimer une demande (soft delete)
    public function deleteDemande($code_demande)
    {
        try {
            $sql = 'UPDATE demandes SET etat_demande = 0 WHERE code_demande = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$code_demande]);
            return true;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir le stock actuel pour une catégorie
    public function getStockByCategorie($categorie_code)
    {
        try {
            $sql = "SELECT 
                    COALESCE(SUM(CASE WHEN type_mouvement = 'ENTREE' THEN quantite_stock ELSE 0 END), 0) -
                    COALESCE(SUM(CASE WHEN type_mouvement = 'SORTIE' THEN quantite_stock ELSE 0 END), 0) +
                    COALESCE(SUM(CASE WHEN type_mouvement = 'RETOUR' THEN quantite_stock ELSE 0 END), 0) as stock_total
                    FROM stocks 
                    WHERE categorie_code = ?";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$categorie_code]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['stock_total'] ?? 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir l'historique des mouvements de stock
    public function getHistoriqueStock($categorie_code = null)
    {
        try {
            $sql = "SELECT s.*, u.nom_user, u.prenom_user, c.libelle_categorie 
                    FROM stocks s 
                    LEFT JOIN users u ON s.user_code = u.code_user 
                    LEFT JOIN categories c ON s.categorie_code = c.code_categorie";
            
            $params = [];
            if ($categorie_code) {
                $sql .= " WHERE s.categorie_code = ?";
                $params[] = $categorie_code;
            }
            
            $sql .= " ORDER BY s.date_mouvement DESC";
            
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

    // Créer un mouvement de stock
    public function createMouvementStock($data)
    {
        return $this->validator->create('stocks', $data);
    }

    // Valider une demande (mettre à jour l'état)
    public function validerDemande($code_demande, $gestionnaire_code)
    {
        try {
            $sql = "UPDATE demandes SET etat_demande = 2, gestionnaire_code = ? WHERE code_demande = ?";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$gestionnaire_code, $code_demande]);
            return true;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Rejeter une demande
    public function rejeterDemande($code_demande, $gestionnaire_code)
    {
        try {
            $sql = "UPDATE demandes SET etat_demande = 3, gestionnaire_code = ? WHERE code_demande = ?";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$gestionnaire_code, $code_demande]);
            return true;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les statistiques des demandes
    public function getStatistiques()
    {
        try {
            $stats = [];
            
            // Total des demandes
            $sql = "SELECT COUNT(*) as total FROM demandes";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['total'] = $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            
            // Demandes en attente
            $sql = "SELECT COUNT(*) as total FROM demandes WHERE etat_demande = 1";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['en_attente'] = $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            
            // Demandes validées
            $sql = "SELECT COUNT(*) as total FROM demandes WHERE etat_demande = 2";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['validees'] = $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            
            // Demandes rejetees
            $sql = "SELECT COUNT(*) as total FROM demandes WHERE etat_demande = 3";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['rejetees'] = $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            
            return $stats;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
