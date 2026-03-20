<?php

require_once '../config/Database.php';

require_once '../models/Validator.php';

require_once '../core/Router.php';

require_once '../models/home/ModelHome.php';

require_once '../models/users/ModelUser.php';

require_once '../models/dashboard/ModelAdmin.php';

require_once '../models/clients/ModelClient.php';

require_once '../models/roles/ModelRole.php';
require_once '../models/categories/ModelCategorie.php';
require_once '../models/choix/ModelChoix.php';
require_once '../models/inscriptions/ModelInscription.php';
require_once '../models/paiements/ModelPaiement.php';
require_once '../models/articles/ModelArticle.php';
require_once '../models/familles/ModelFamille.php';
require_once '../models/versements/ModelVersement.php';
require_once '../models/retraits/ModelRetrait.php';
require_once '../models/demandes/ModelDemande.php';


require_once '../controllers/home/HomeController.php';

require_once '../controllers/users/UserController.php';

require_once '../controllers/dashboard/DashboardController.php';

require_once '../controllers/commercial/CommercialController.php';
require_once '../controllers/kit/KitController.php';
require_once '../controllers/client/ClientController.php';
require_once '../controllers/admin/InscriptionController.php';
require_once '../controllers/admin/PaiementController.php';
require_once '../controllers/admin/VersementController.php';
require_once '../controllers/admin/RetraitController.php';
require_once '../controllers/admin/SettingsController.php';
require_once '../controllers/admin/FamilleController.php';
require_once '../controllers/admin/ArticleController.php';
require_once '../controllers/admin/DemandeController.php';
require_once '../controllers/entreprise/EntrepriseController.php';


