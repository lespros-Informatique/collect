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


// Ajout des routes


$route->addRoute('/', [$homeController, 'index']); // Page de connexion

$route->addRoute('/home', [$homeController, 'home']); // Vue d'accueil


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


// User management routes (using UserController)
$route->addRoute('/admin/users', [$userController, 'list']); // Liste des utilisateurs
$route->addRoute('/admin/users/add', [$userController, 'add']); // Ajouter un utilisateur
$route->addRoute('/admin/users/edit', [$userController, 'edit']); // Editer un utilisateur
$route->addRoute('/admin/users/changer', [$userController, 'changer']); // Changer statut utilisateur

// Client management routes
$route->addRoute('/admin/clients', [$clientController, 'index']); // Liste des clients
$route->addRoute('/admin/clients/details/{params}', [$clientController, 'details']); // Détails client

// Kit/Categorie management routes
$route->addRoute('/admin/kits', [$kitController, 'index']); // Liste des kits
$route->addRoute('/admin/kits/add', [$kitController, 'add']); // Ajouter un kit
$route->addRoute('/admin/kits/edit', [$kitController, 'edit']); // Modifier un kit
$route->addRoute('/admin/kits/delete', [$kitController, 'delete']); // Supprimer un kit
$route->addRoute('/admin/kits/details/{params}', [$kitController, 'details']); // Détails kit

$route->addRoute('/admin/categories', [$kitController, 'categories']); // Liste des catégories
$route->addRoute('/admin/categories/add', [$kitController, 'addCategory']); // Ajouter une catégorie

$route->addRoute('/admin/articles', [$kitController, 'articles']); // Liste des articles
$route->addRoute('/admin/articles/add', [$kitController, 'addArticle']); // Ajouter un article

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
