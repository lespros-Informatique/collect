<?php

require_once '../models/Validator.php';
require_once '../models/dashboard/ModelAdmin.php';

class DashboardController
{
    private $validator;
    private $admin;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->admin = new ModelAdmin();
    }

    public function index()
    {
        $stats = $this->admin->getDashboardStats();
        
        // Map stats to variables for collectes management
        $totalClients = $stats['total_clients'] ?? 0;
        $totalInscriptions = $stats['total_inscriptions'] ?? 0;
        $totalPaiements = $stats['total_paiements'] ?? 0;
        $revenusAujourdhui = $stats['today_revenue'] ?? 0;
        $paiementsAujourdhui = $stats['today_paiements'] ?? 0;
        
        require_once '../views/dashboard/dashboard.php';
    }
}