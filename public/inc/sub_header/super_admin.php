<?php

    // Fallback si pas de rôle défini
    require_once 'nav_admin.php';
    // Fallback si pas de rôle défini
    if(isset( $_SESSION['user']) && !empty( $_SESSION['user'])){ 
        require_once 'sidbar_admin.php'; 
    }else{
        require_once 'sidbar_entreprise.php'; 
    }
?>