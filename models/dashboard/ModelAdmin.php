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

    // public function getDashboardStats()
    // {
    //     try {
    //         $stats = [];

    //         // Total paiements aujourd'hui
    //         $sql = "SELECT COUNT(*) as total_paiements FROM paiements WHERE DATE(created_at_paiement) = CURDATE() AND etat_paiement = ".STATUS_ACTIVE;
    //         $query = $this->pdo->getCon()->prepare($sql);
    //         $query->execute();
    //         $stats['today_paiements'] = $query->fetch(PDO::FETCH_ASSOC)['total_paiements'] ?? 0;

    //         // Total revenus aujourd'hui (paiements validés)
    //         $sql = "SELECT COALESCE(SUM(montant_paiement), 0) as total_revenue FROM paiements WHERE DATE(created_at_paiement) = CURDATE() AND etat_paiement = ".STATUS_ACTIVE;
    //         $query = $this->pdo->getCon()->prepare($sql);
    //         $query->execute();
    //         $stats['today_revenue'] = $query->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;

    //         // Total inscriptions en attente
    //         $sql = "SELECT COUNT(*) as total_inscriptions FROM inscriptions WHERE etat_inscription = ".STATUS_ACTIVE;
    //         $query = $this->pdo->getCon()->prepare($sql);
    //         $query->execute();
    //         $stats['total_inscriptions'] = $query->fetch(PDO::FETCH_ASSOC)['total_inscriptions'] ?? 0;

    //         // Total choix/kits disponibles
    //         $sql = "SELECT COUNT(*) as total_kits FROM choix WHERE etat_choix = ".STATUS_ACTIVE;
    //         $query = $this->pdo->getCon()->prepare($sql);
    //         $query->execute();
    //         $stats['total_kits'] = $query->fetch(PDO::FETCH_ASSOC)['total_kits'] ?? 0;

    //         // Total utilisateurs actifs
    //         $sql = "SELECT COUNT(*) as active_users FROM users WHERE etat_user = ".STATUS_ACTIVE;
    //         $query = $this->pdo->getCon()->prepare($sql);
    //         $query->execute();
    //         $stats['active_users'] = $query->fetch(PDO::FETCH_ASSOC)['active_users'] ?? 0;

    //         // Total utilisateurs inactifs
    //         $sql = "SELECT COUNT(*) as inactive_users FROM users WHERE etat_user = 0";
    //         $query = $this->pdo->getCon()->prepare($sql);
    //         $query->execute();
    //         $stats['inactive_users'] = $query->fetch(PDO::FETCH_ASSOC)['inactive_users'] ?? 0;

    //         // Total clients
    //         $sql = "SELECT COUNT(*) as total_clients FROM clients WHERE etat_client = ".STATUS_ACTIVE;
    //         $query = $this->pdo->getCon()->prepare($sql);
    //         $query->execute();
    //         $stats['total_clients'] = $query->fetch(PDO::FETCH_ASSOC)['total_clients'] ?? 0;

    //         // Total paiements (tous)
    //         $sql = "SELECT COUNT(*) as total_paiements FROM paiements";
    //         $query = $this->pdo->getCon()->prepare($sql);
    //         $query->execute();
    //         $stats['total_paiements'] = $query->fetch(PDO::FETCH_ASSOC)['total_paiements'] ?? 0;

    //         // Total versements en attente
    //         $sql = "SELECT COUNT(*) as versements_en_attente FROM versements WHERE etat_versement = 'En cours'";
    //         $query = $this->pdo->getCon()->prepare($sql);
    //         $query->execute();
    //         $stats['versements_en_attente'] = $query->fetch(PDO::FETCH_ASSOC)['versements_en_attente'] ?? 0;

    //         // Total versements validés
    //         $sql = "SELECT COUNT(*) as versements_valides FROM versements WHERE etat_versement = 'Validé'";
    //         $query = $this->pdo->getCon()->prepare($sql);
    //         $query->execute();
    //         $stats['versements_valides'] = $query->fetch(PDO::FETCH_ASSOC)['versements_valides'] ?? 0;

    //         // Total catégories
    //         $sql = "SELECT COUNT(*) as total_categories FROM categories WHERE etat_categorie = ".STATUS_ACTIVE;
    //         $query = $this->pdo->getCon()->prepare($sql);
    //         $query->execute();
    //         $stats['total_categories'] = $query->fetch(PDO::FETCH_ASSOC)['total_categories'] ?? 0;

    //         // Total retraits
    //         $sql = "SELECT COUNT(*) as total_retraits FROM retraits WHERE etat_retrait = ".STATUS_ACTIVE;
    //         $query = $this->pdo->getCon()->prepare($sql);
    //         $query->execute();
    //         $stats['total_retraits'] = $query->fetch(PDO::FETCH_ASSOC)['total_retraits'] ?? 0;

    //         // Inscriptions aujourd'hui
    //         $sql = "SELECT COUNT(*) as inscriptions_aujourdhui FROM inscriptions WHERE DATE(date_debut) = CURDATE() AND etat_inscription = ".STATUS_ACTIVE;
    //         $query = $this->pdo->getCon()->prepare($sql);
    //         $query->execute();
    //         $stats['inscriptions_aujourdhui'] = $query->fetch(PDO::FETCH_ASSOC)['inscriptions_aujourdhui'] ?? 0;

    //         return $stats;
    //     } catch (Exception $e) {
    //         die('Erreur de récupération des statistiques: ' . $e->getMessage());
    //     }
    // }

    public function updateProfile($id, $data)
    {
        return $this->validator->update('users', 'id_user', $id, $data);
    }

    public function updatePassword($id, $password)
    {
        return $this->validator->update('users', 'id_user', $id, ['password_user' => $password]);
    }


    public function getDashboardStats()
{
    try {
        $stats = [];
        $pdo = $this->pdo->getCon();

        // ===== PAIEMENTS =====
        $sql = "SELECT 
                COUNT(*) as total_paiements,
                SUM(CASE WHEN DATE(created_at_paiement) = :date_ AND etat_paiement = :active THEN 1 ELSE 0 END) as today_paiements,
                SUM(CASE WHEN DATE(created_at_paiement) = :date_ AND etat_paiement = :active THEN montant_paiement ELSE 0 END) as today_revenue
            FROM paiements
        ";
        $query = $pdo->prepare($sql);
        $query->execute(['date_' =>Validator::dateActuelle(),'active' => STATUS_ACTIVE]);
        $stats = array_merge($stats, $query->fetch(PDO::FETCH_ASSOC));

        // ===== USERS =====
        $sql = "SELECT 
                SUM(CASE WHEN etat_user = :active THEN 1 ELSE 0 END) as active_users,
                SUM(CASE WHEN etat_user = :inactive THEN 1 ELSE 0 END) as inactive_users
            FROM users
        ";
        $query = $pdo->prepare($sql);
        $query->execute(['active' => STATUS_ACTIVE,'inactive' => STATUS_INACTIVE]);
        $stats = array_merge($stats, $query->fetch(PDO::FETCH_ASSOC));

        // ===== INSCRIPTIONS =====
        $sql = "SELECT 
                COUNT(*) as total_inscriptions,
                SUM(CASE WHEN DATE(date_debut) = :date_ THEN 1 ELSE 0 END) as inscriptions_aujourdhui
            FROM inscriptions
            WHERE etat_inscription = :active
        ";
        $query = $pdo->prepare($sql);
        $query->execute(['date_' =>Validator::dateActuelle(),'active' => STATUS_ACTIVE]);
        $stats = array_merge($stats, $query->fetch(PDO::FETCH_ASSOC));

        // ===== AUTRES TABLES SIMPLES =====
        $tables = [
            TABLES::CLIENTS => 'etat_client',
            TABLES::CHOIX => 'etat_choix',
            TABLES::CATEGORIES => 'etat_categorie',
            TABLES::RETRAITS => 'etat_retrait'
        ];

        foreach ($tables as $table => $field) {
            $sql = "SELECT COUNT(*) as total_$table FROM $table WHERE $field = :active";
            $query = $pdo->prepare($sql);
            $query->execute(['active' => STATUS_ACTIVE]);
            $stats["total_$table"] = $query->fetchColumn();
        }

        // ===== VERSEMENTS =====
        $sql = "SELECT 
                SUM(CASE WHEN etat_versement = :encours THEN 1 ELSE 0 END) as versements_en_attente,
                SUM(CASE WHEN etat_versement = :valide THEN 1 ELSE 0 END) as versements_valides
            FROM versements
        ";
        $query = $pdo->prepare($sql);
        $query->execute(["encours" => STATUS_ACTIVE,"valide" => STATUS_INACTIVE]);
        $stats = array_merge($stats, $query->fetch(PDO::FETCH_ASSOC));

        return $stats;

    } catch (Exception $e) {
        die('Erreur de récupération des statistiques: ' . $e->getMessage());
    }
}
}
