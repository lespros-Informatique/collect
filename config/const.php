<?php require_once 'config.php'; ?>

<?php
// Chemins du projet
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('ROOT_REMOVE_IMG', $_SERVER['DOCUMENT_ROOT'] . "/collect");
define('RACINE', 'http://localhost/collect/');
// define('RACINE', 'https://collect.dndcorporations.com/');
// define('RACINE', 'https://collect.kassanngroup.com/');


define('RACINE_PUBLIC', '/collect/public/');

// Informations utilisateur connecté
define('USER_ID', $_SESSION['user']['id_user'] ?? null);
define('USER_NAME', $_SESSION['user']['nom'] ?? null);
define('USER_EMAIL', $_SESSION['user']['email'] ?? null);
define('USER_ROLE', $_SESSION['user']['role'] ?? null);
define('USER_PHONE', $_SESSION['user']['telephone'] ?? null);
define('SIGN', USER_ROLE);
define('ROLE_ADMIN', "code-admin");
define('ROLE_COMPTABLE', "code-comptable");
define('ROLE_SUPERVISEUR', "code-code-superviseur");
define('ROLE_COMMERCIAL', "code-commercial");

// Additional user constants for profile view
define('ROLE', $_SESSION['user']['role'] ?? 'Utilisateur');

define('USER_ICON', '<i class="fa fa-user-circle fa-2x"></i>');

// Titre de l'application
define('TITLE', 'Collect - Gestion de Collectes');
define('APP_NAME', 'Collect');
define('LOGO', RACINE.'assets/logo/logo.avif');

class TABLES
{
   

    // Utilisateurs & rôles
    public const USERS                       = 'users';
    public const ROLES                       = 'roles';

    // Clients
    public const CLIENTS                     = 'clients';

    // Autres tables de la base existante
    public const ARTICLES                     = 'articles';
    public const CATEGORIES                   = 'categories';
    public const CHOIX                        = 'choix';
    public const DEMANDES                     = 'demandes';
    public const FAMILLES                     = 'familles';
    public const INSCRIPTIONS                 = 'inscriptions';
    public const LIGNE_ARTICLES               = 'ligne_articles';
    public const LIGNE_ARTICLE_INSCRIPTIONS  = 'ligne_article_inscriptions';
    public const LIGNE_CHOIX                  = 'ligne_choix';
    public const PAIEMENTS                    = 'paiements';
    public const RAPPORTS                     = 'rapports';
    public const RETRAITS                     = 'retraits';
    public const STOCKS                       = 'stocks';
    public const VERSEMENTS                   = 'versements';
}
