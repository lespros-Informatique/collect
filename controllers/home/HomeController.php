<?php

class HomeController
{
    private $validator;
    private $home;
    private $user;
    private $admin;

    // // constructeur pour initialiser le validator ici, pour pouvoir l'utiliser dans toutes les méthodes de la classe AccueilController
    public function __construct()
    {
        $this->validator = new Validator();
        $this->home = new ModelHome();
        $this->user = new ModelUser();
        $this->admin = new ModelAdmin();
    }

    public function index() // la vue de la  connexion
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            // Récupérer les statistiques du dashboard
            $stats = $this->admin->getDashboardStats();
            
            // Map stats to variables for collectes management
            $totalClients = $stats['total_clients'] ?? 0;
            $totalInscriptions = $stats['total_inscriptions'] ?? 0;
            $totalCategories = $stats['total_categories'] ?? 0;
            $totalKits = $stats['total_kits'] ?? 0;
            $totalRetraits = $stats['total_retraits'] ?? 0;
            $totalPaiements = $stats['total_paiements'] ?? 0;
            $revenusAujourdhui = $stats['today_revenue'] ?? 0;
            $paiementsAujourdhui = $stats['today_paiements'] ?? 0;
            $inscriptionsAujourdhui = $stats['inscriptions_aujourdhui'] ?? 0;
            
            require_once '../views/dashboard/dashboard.php'; // On inclut la vue du dashboard
        } else {
            require_once '../views/users/connexion.php';
        }
    }

    public function home()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            // Récupérer les statistiques du dashboard
            $stats = $this->admin->getDashboardStats();
            
            // Map stats to variables for collectes management
            $totalClients = $stats['total_clients'] ?? 0;
            $totalInscriptions = $stats['total_inscriptions'] ?? 0;
            $totalCategories = $stats['total_categories'] ?? 0;
            $totalKits = $stats['total_kits'] ?? 0;
            $totalRetraits = $stats['total_retraits'] ?? 0;
            $totalPaiements = $stats['total_paiements'] ?? 0;
            $revenusAujourdhui = $stats['today_revenue'] ?? 0;
            $paiementsAujourdhui = $stats['today_paiements'] ?? 0;
            $inscriptionsAujourdhui = $stats['inscriptions_aujourdhui'] ?? 0;
            
            require_once '../views/dashboard/dashboard.php';
        } else {
            require_once '../views/users/connexion.php';
        }
    }

    public function settings()
    {
        require_once '../views/home/settings.php';
    }


    public function success()
    {
        require_once '../core/errors/success.php';
    }

    public function error()
    {
        require_once '../core/errors/error.php';
    }

}
