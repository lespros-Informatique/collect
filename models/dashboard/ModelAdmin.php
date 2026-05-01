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
                SUM(CASE WHEN DATE(created_at_paiement) = :date_ AND statut_paiement = :pending THEN 1 ELSE 0 END) as today_paiements,
                SUM(CASE WHEN DATE(created_at_paiement) = :date_ AND statut_paiement = :pending THEN montant_paiement ELSE 0 END) as today_revenue
            FROM paiements
        ";
        $query = $pdo->prepare($sql);
        $query->execute(['date_' =>Validator::dateActuelle(),'pending' => STATUT[0]]);
        $stats = array_merge($stats, $query->fetch(PDO::FETCH_ASSOC));

        // ===== USERS =====
        $sql = "SELECT 
                SUM(CASE WHEN etat_user = :active THEN 1 ELSE 0 END) as active_users,
                SUM(CASE WHEN etat_user = :inactive THEN 1 ELSE 0 END) as inactive_users
            FROM users
        ";
        $query = $pdo->prepare($sql);
        $query->execute(['active' => STATUT[0],'inactive' => STATUT[1]]);
        $stats = array_merge($stats, $query->fetch(PDO::FETCH_ASSOC));

        // ===== INSCRIPTIONS =====
        $sql = "SELECT 
                COUNT(*) as total_inscriptions,
                SUM(CASE WHEN DATE(date_debut) = :date_ THEN 1 ELSE 0 END) as inscriptions_aujourdhui
            FROM inscriptions
            WHERE etat_inscription = :active
        ";
        $query = $pdo->prepare($sql);
        $query->execute(['date_' =>Validator::dateActuelle(),'active' => ETAT_INSCRIPTION[0]]);
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
            $query->execute(['active' => STATUT[0]]);
            $stats["total_$table"] = $query->fetchColumn();
        }

        // ===== VERSEMENTS =====
        $sql = "SELECT 
                SUM(CASE WHEN etat_versement = :encours THEN 1 ELSE 0 END) as versements_en_attente,
                SUM(CASE WHEN etat_versement = :valide THEN 1 ELSE 0 END) as versements_valides
            FROM versements
        ";
        $query = $pdo->prepare($sql);
        $query->execute(["encours" => STATUT[0],"valide" => STATUT[1]]);
        $stats = array_merge($stats, $query->fetch(PDO::FETCH_ASSOC));

        return $stats;

    } catch (Exception $e) {
        die('Erreur de récupération des statistiques: ' . $e->getMessage());
    }
}
}
