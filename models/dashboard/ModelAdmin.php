<?php

class ModelAdmin
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    public function getDashboardStats()
    {
        try {
            $stats = [];

            // Total paiements aujourd'hui
            $sql = "SELECT COUNT(*) as total_paiements FROM paiements WHERE DATE(created_at_paiement) = CURDATE() AND etat_paiement = 1";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['today_paiements'] = $query->fetch(PDO::FETCH_ASSOC)['total_paiements'] ?? 0;

            // Total revenus aujourd'hui (paiements validés)
            $sql = "SELECT COALESCE(SUM(montant_paiement), 0) as total_revenue FROM paiements WHERE DATE(created_at_paiement) = CURDATE() AND etat_paiement = 1";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['today_revenue'] = $query->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;

            // Total inscriptions en attente
            $sql = "SELECT COUNT(*) as total_inscriptions FROM inscriptions WHERE etat_inscription = 1";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['total_inscriptions'] = $query->fetch(PDO::FETCH_ASSOC)['total_inscriptions'] ?? 0;

            // Total choix/kits disponibles
            $sql = "SELECT COUNT(*) as total_kits FROM choix WHERE etat_choix = 1";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['total_kits'] = $query->fetch(PDO::FETCH_ASSOC)['total_kits'] ?? 0;

            // Total utilisateurs actifs
            $sql = "SELECT COUNT(*) as active_users FROM users WHERE etat_user = 1";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['active_users'] = $query->fetch(PDO::FETCH_ASSOC)['active_users'] ?? 0;

            // Total utilisateurs inactifs
            $sql = "SELECT COUNT(*) as inactive_users FROM users WHERE etat_user = 0";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['inactive_users'] = $query->fetch(PDO::FETCH_ASSOC)['inactive_users'] ?? 0;

            // Total clients
            $sql = "SELECT COUNT(*) as total_clients FROM clients WHERE etat_client = 1";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['total_clients'] = $query->fetch(PDO::FETCH_ASSOC)['total_clients'] ?? 0;

            // Total paiements (tous)
            $sql = "SELECT COUNT(*) as total_paiements FROM paiements";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['total_paiements'] = $query->fetch(PDO::FETCH_ASSOC)['total_paiements'] ?? 0;

            // Total versements en attente
            $sql = "SELECT COUNT(*) as versements_en_attente FROM versements WHERE etat_versement = 'En cours'";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['versements_en_attente'] = $query->fetch(PDO::FETCH_ASSOC)['versements_en_attente'] ?? 0;

            // Total versements validés
            $sql = "SELECT COUNT(*) as versements_valides FROM versements WHERE etat_versement = 'Validé'";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['versements_valides'] = $query->fetch(PDO::FETCH_ASSOC)['versements_valides'] ?? 0;

            // Total catégories
            $sql = "SELECT COUNT(*) as total_categories FROM categories WHERE etat_categorie = 1";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['total_categories'] = $query->fetch(PDO::FETCH_ASSOC)['total_categories'] ?? 0;

            // Total retraits
            $sql = "SELECT COUNT(*) as total_retraits FROM retraits WHERE etat_retrait = 1";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['total_retraits'] = $query->fetch(PDO::FETCH_ASSOC)['total_retraits'] ?? 0;

            // Inscriptions aujourd'hui
            $sql = "SELECT COUNT(*) as inscriptions_aujourdhui FROM inscriptions WHERE DATE(date_debut) = CURDATE() AND etat_inscription = 1";
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            $stats['inscriptions_aujourdhui'] = $query->fetch(PDO::FETCH_ASSOC)['inscriptions_aujourdhui'] ?? 0;

            return $stats;
        } catch (Exception $e) {
            die('Erreur de récupération des statistiques: ' . $e->getMessage());
        }
    }

    public function updateProfile($id, $data)
    {
        return $this->validator->update('users', 'id_user', $id, $data);
    }

    public function updatePassword($id, $password)
    {
        return $this->validator->update('users', 'id_user', $id, ['password_user' => $password]);
    }
}
