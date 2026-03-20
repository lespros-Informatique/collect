<?php

require_once '../core/PrincipalRoute.php';

// Instanciation de la base de données
$route = new Router();

// Instanciation des contrôleurs
$homeController = new HomeController();
$userController = new UserController();
$dashboardController = new DashboardController();
$clientController = new ClientController();
$kitController = new KitController();
$commercialController = new CommercialController();
$inscriptionController = new InscriptionController();
$paiementController = new PaiementController();
$versementController = new VersementController();
$retraitController = new RetraitController();
$settingsController = new SettingsController();
$familleController = new FamilleController();
$articleController = new ArticleController();
$demandeController = new DemandeController();

$entrepriseController = new EntrepriseController();


// Ajout des routes


$route->addRoute('/', [$homeController, 'index']); // Page de connexion

$route->addRoute('/home', [$homeController, 'home']); // Vue d'accueil

$route->addRoute('/entreprise', [$entrepriseController, 'home']); // Vue d'accueil


$route->addRoute('/home/settings', [$homeController, 'settings']); // Vue de settings

$route->addRoute('/home/success', [$homeController, 'success']); // Vue d'accueil

$route->addRoute('/home/error', [$homeController, 'error']); // Vue d'accueil



$route->addRoute('/user/profil', [$userController, 'profil']); // Vue de profil

$route->addRoute('/user/decon', [$userController, 'decon']); // Vue & backend deconnexion
$route->addRoute('/user/details/{param}', [$userController, 'details']); // Vue & backend deconnexion
$route->addRoute('/user/edition/{param}', [$userController, 'edition']); // Vue & backend deconnexion

$route->addRoute('/userController/connexion', [$userController, 'connexion']); // Backend connexion
$route->addRoute('/userController/add', [$userController, 'add']); // Backend connexion
$route->addRoute('/userController/edit', [$userController, 'edit']); // Backend connexion
$route->addRoute('/userController/changer', [$userController, 'changer']); // Backend connexion

$route->addRoute('/userController/editPassword', [$userController, 'editPassword']); // Backend modification mot de passe
// Admin routes
$route->addRoute('/admin', [$dashboardController, 'index']); // Dashboard admin

// Inscriptions management routes
$route->addRoute('/admin/inscriptions', [$inscriptionController, 'index']); // Liste des inscriptions
$route->addRoute('/admin/inscriptions/choix/{param}', [$inscriptionController, 'choix']); // Choisir un kit pour un client
$route->addRoute('/admin/inscriptions/create', [$inscriptionController, 'create']); // Créer inscription
$route->addRoute('/admin/inscriptions/save', [$inscriptionController, 'save']); // Sauvegarder inscription avec choix
$route->addRoute('/admin/inscriptions/edit', [$inscriptionController, 'edit']); // Modifier inscription
$route->addRoute('/admin/inscriptions/getArticlesByKit', [$inscriptionController, 'getArticlesByKit']); // Obtenir les articles d'un kit
$route->addRoute('/admin/inscriptions/saveMultiple', [$inscriptionController, 'saveMultiple']); // Sauvegarder inscription avec plusieurs kits
$route->addRoute('/admin/inscriptions/delete', [$inscriptionController, 'delete']); // Supprimer inscription
$route->addRoute('/admin/inscriptions/details/{params}', [$inscriptionController, 'details']); // Détails inscription

// Paiements management routes
$route->addRoute('/admin/paiements', [$paiementController, 'index']); // Liste des paiements
$route->addRoute('/admin/paiements/create', [$paiementController, 'create']); // Créer paiement
$route->addRoute('/admin/paiements/edit', [$paiementController, 'edit']); // Modifier paiement
$route->addRoute('/admin/paiements/delete', [$paiementController, 'delete']); // Supprimer paiement
$route->addRoute('/admin/paiements/details/{params}', [$paiementController, 'details']); // Détails paiement
$route->addRoute('/admin/paiements/getInscriptionsByUser', [$paiementController, 'getInscriptionsByUser']); // Récupérer inscriptions par utilisateur
$route->addRoute('/admin/paiements/getInscriptionDetails', [$paiementController, 'getInscriptionDetails']); // Récupérer détails inscription

// Versements management routes
$route->addRoute('/admin/versements', [$versementController, 'index']); // Liste des versements
$route->addRoute('/admin/versements/create', [$versementController, 'create']); // Créer versement
$route->addRoute('/admin/versements/edit', [$versementController, 'edit']); // Modifier versement
$route->addRoute('/admin/versements/details/{params}', [$versementController, 'details']); // Détails versement

// Retraits management routes
$route->addRoute('/admin/retraits', [$retraitController, 'index']); // Liste des retraits
$route->addRoute('/admin/retraits/create', [$retraitController, 'create']); // Créer retrait
$route->addRoute('/admin/retraits/edit', [$retraitController, 'edit']); // Modifier retrait
$route->addRoute('/admin/retraits/delete', [$retraitController, 'delete']); // Supprimer retrait
$route->addRoute('/admin/retraits/details/{params}', [$retraitController, 'details']); // Détails retrait

// Settings management routes
$route->addRoute('/admin/settings', [$settingsController, 'index']); // Page des paramètres
$route->addRoute('/admin/settings/update', [$settingsController, 'update']); // Mettre à jour les paramètres
$route->addRoute('/admin/settings/updatePreferences', [$settingsController, 'updatePreferences']); // Mettre à jour les préférences
$route->addRoute('/admin/settings/addRole', [$settingsController, 'addRole']); // Ajouter un rôle
$route->addRoute('/admin/settings/editRole', [$settingsController, 'editRole']); // Modifier un rôle

// Familles management routes
$route->addRoute('/admin/familles', [$familleController, 'index']); // Liste des familles
$route->addRoute('/admin/familles/create', [$familleController, 'create']); // Créer famille
$route->addRoute('/admin/familles/edit', [$familleController, 'edit']); // Modifier famille
$route->addRoute('/admin/familles/delete', [$familleController, 'delete']); // Supprimer famille

// Articles management routes
$route->addRoute('/admin/articles', [$articleController, 'index']); // Liste des articles
$route->addRoute('/admin/articles/create', [$articleController, 'create']); // Créer article
$route->addRoute('/admin/articles/edit', [$articleController, 'edit']); // Modifier article
$route->addRoute('/admin/articles/delete', [$articleController, 'delete']); // Supprimer article

// Demandes management routes
$route->addRoute('/admin/demandes', [$demandeController, 'index']); // Liste des demandes
$route->addRoute('/admin/demandes/add', [$demandeController, 'add']); // Ajouter une demande
$route->addRoute('/admin/demandes/create', [$demandeController, 'create']); // Créer demande
$route->addRoute('/admin/demandes/edit', [$demandeController, 'edit']); // Modifier demande
$route->addRoute('/admin/demandes/delete', [$demandeController, 'delete']); // Supprimer demande
$route->addRoute('/admin/demandes/details/{params}', [$demandeController, 'details']); // Détails demande
$route->addRoute('/admin/demandes/stocks', [$demandeController, 'stocks']); // Gestion des stocks

// Demandes controller routes
$route->addRoute('/demandeController/create', [$demandeController, 'create']); // Créer demande (AJAX)
$route->addRoute('/demandeController/valider', [$demandeController, 'valider']); // Valider demande (AJAX)
$route->addRoute('/demandeController/rejeter', [$demandeController, 'rejeter']); // Rejeter demande (AJAX)
$route->addRoute('/demandeController/entreeStock', [$demandeController, 'entreeStock']); // Entrée stock (AJAX)
$route->addRoute('/demandeController/retourStock', [$demandeController, 'retourStock']); // Retour stock (AJAX)
$route->addRoute('/demandeController/getStockByCategorie', [$demandeController, 'getStockByCategorie']); // Get stock (AJAX)

// User management routes (using UserController)
$route->addRoute('/admin/users', [$userController, 'list']); // Liste des utilisateurs
$route->addRoute('/admin/users/add', [$userController, 'add']); // Ajouter un utilisateur
$route->addRoute('/admin/users/edit', [$userController, 'edit']); // Editer un utilisateur
$route->addRoute('/admin/users/changer', [$userController, 'changer']); // Changer statut utilisateur

// Client management routes
$route->addRoute('/admin/clients', [$clientController, 'index']); // Liste des clients
$route->addRoute('/admin/clients/create', [$clientController, 'add']); // Créer un client
$route->addRoute('/admin/clients/details/{params}', [$clientController, 'details']); // Détails client

// Kit/Categorie management routes
$route->addRoute('/admin/kits', [$kitController, 'index']); // Liste des kits
$route->addRoute('/admin/kits/add', [$kitController, 'add']); // Ajouter un kit
$route->addRoute('/admin/kits/edit', [$kitController, 'edit']); // Modifier un kit (POST pour soumission formulaire)
$route->addRoute('/admin/kits/edit/{params}', [$kitController, 'edit']); // Modifier un kit (GET pour affichage formulaire)
$route->addRoute('/admin/kits/delete', [$kitController, 'delete']); // Supprimer un kit
$route->addRoute('/admin/kits/details/{params}', [$kitController, 'details']); // Détails kit
$route->addRoute('/admin/kits/articles/{params}', [$kitController, 'addArticlesToKit']); // Ajouter des articles au kit
$route->addRoute('/admin/kits/saveArticles', [$kitController, 'saveKitArticles']); // Sauvegarder les articles du kit

$route->addRoute('/admin/categories', [$kitController, 'categories']); // Liste des catégories
$route->addRoute('/admin/categories/add', [$kitController, 'addCategory']); // Ajouter une catégorie

// Commercial management routes
$route->addRoute('/admin/commercial', [$commercialController, 'index']); // Liste des commerciaux
$route->addRoute('/admin/commercial/add', [$commercialController, 'add']); // Ajouter un commercial
$route->addRoute('/admin/commercial/edit', [$commercialController, 'edit']); // Modifier un commercial
$route->addRoute('/admin/commercial/mes-clients', [$commercialController, 'mesClients']); // Mes clients
$route->addRoute('/admin/commercial/mes-paiements', [$commercialController, 'mesPaiements']); // Mes paiements

// Paiement routes
$route->addRoute('/commercial/paiement/add', [$commercialController, 'addPaiement']); // Enregistrer paiement

// Client inscription routes
$route->addRoute('/client/inscription', [$clientController, 'inscription']); // Inscrire client
$route->addRoute('/client/inscriptions/{params}', [$clientController, 'inscriptions']); // Liste inscriptions
$route->addRoute('/client/paiements/{params}', [$clientController, 'paiements']); // Liste paiements

// Client delete route
$route->addRoute('/client/delete', [$clientController, 'delete']); // Supprimer client

// Client edit route
$route->addRoute('/client/edit', [$clientController, 'edit']); // Modifier client

// Exécution du router

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (strpos($url, '/collect/public') === 0) {
    $url = str_replace('/collect/public', '', $url);
} elseif (strpos($url, '/collect') === 0) {
    $url = str_replace('/collect', '', $url);
}
// echo 'URL traitée : ' . $url . '<br>'; // Débogage pour vérifier l'URL après retrait du préfixe

$route->run($url);
