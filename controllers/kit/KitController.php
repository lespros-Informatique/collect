<?php

require_once '../models/Validator.php';
require_once '../models/inscriptions/ModelInscription.php';

class KitController
{
    private $validator;
    private $categorie;
    private $choix;
    private $article;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->categorie = new ModelCategorie();
        $this->choix = new ModelChoix();
        $this->article = new ModelArticle();
    }

    // Liste des kits (choix)
    public function index()
    {
        $choix = $this->choix->getAllChoix(1);
        $categories = $this->categorie->getAllCategories(1);
        require_once '../views/kits/list.php';
    }

    // Détails d'un kit
    public function details($param)
    {
        // Déchiffrer le code du kit
        $code = $this->validator->decrypter($param);
        $kit = $this->choix->getChoixByCode($code);
        if ($kit) { 
            $articles = $this->article->getArticlesByChoix($code);
            // Charger la catégorie
            if (!empty($kit['categorie_code'])) {
                $categorie = $this->categorie->getCategoryByCode($kit['categorie_code']);
            }
            // Charger les inscriptions utilisant ce kit
            $inscriptionModel = new ModelInscription();
            $inscriptions = $inscriptionModel->getInscriptionsByKit($code);
            $validator = $this->validator;
        }
        require_once '../views/kits/details.php';
    }

    // Ajouter un kit
    public function add()
    {
        extract($_POST);
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST, ['description']);

            if ($notEmpty !== true) {
                $msg = ['msg' => 'Veuillez renseigner les champs obligatoires!', 'status' => 0];
                echo json_encode($msg);
                return;
            }


               if ($this->validator->verifs(TABLES::CHOIX, "libelle_choix",'categorie_code', $libelle, $categorie)) {
                $msg = ['msg' => 'Le libellé de choix existe déjà dans cette catégorie!', 'status' => 0];
                echo json_encode($msg);
                return;
            }


            // Génération du code choix
            $code_choix = $this->validator->generateCode('choix', 'code_choix', 'CHOIX-KIT-', 6);

            // Traitement de l'image
            $imagePath = '';
            try {
                $imagePath = Validator::uploadImage('image', 'kits') ?? '';
            } catch (Exception $e) {
                $msg = ['msg' => 'Erreur lors de l\'upload de l\'image: ' . $e->getMessage(), 'status' => 0];
                echo json_encode($msg);
                return;
            }

            // Préparation des données pour la méthode create du Validator
            $data = [
                'code_choix' => $code_choix,
                'categorie_code' => $categorie,
                'libelle_choix' => trim($libelle),
                'description_choix' => $description ?? null,
                'cotisation_choix' => $cotisation,
                'img_choix' => $imagePath
            ];

            if ($this->validator->create('choix', $data)) {
                $msg = [
                    'msg' => 'Kit ajouté avec succès!', 
                    'status' => 1, 
                    'code_choix' => $code_choix,
                    'code_choix_encrypted' => $this->validator->crypter($code_choix)
                ];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Modifier un kit
    public function edit($param = null)
    {
        // Si soumission du formulaire (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $msg = [];
            $notEmpty = Validator::validateRequiredFields($_POST);

            if ($notEmpty !== true) {
                $msg = ['msg' => 'Veuillez renseigner les champs obligatoires!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            extract($_POST);

            // Préparation des données pour la méthode update du Validator
            $data = [
                'categorie_code' => $categorie,
                'libelle_choix' => trim($libelle),
                'description_choix' => $description ?? null,
                'cotisation_choix' => $cotisation,
                'etat_choix' => $etat_choix ?? 1
            ];

            // Traitement de l'image si nouvelle image uploadée
            if (!empty($_FILES['image']['name'])) {
                try {
                    $imagePath = Validator::uploadImage('image', 'kits');
                    if ($imagePath) {
                        $data['img_choix'] = $imagePath;
                    }
                } catch (Exception $e) {
                    // Ignorer les erreurs d'upload pour la modification
                }
            }

            if ($this->validator->update('choix', 'id_choix', $id, $data)) {
                $msg = ['msg' => 'Kit modifié avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
            }
            echo json_encode($msg);
            return;
        }
        
        // Affichage du formulaire (GET)
        if ($param !== null) {
            // Récupérer le kit à modifier
            $code = $this->validator->decrypter($param);
            $kit = $this->choix->getChoixByCode($code);
            $categories = $this->categorie->getAllCategories(1);
            
            if (!$kit) {
                echo "Kit introuvable!";
                return;
            }
        }
        
        require_once '../views/kits/edit.php';
    }

    // Supprimer un kit
    public function delete()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            if (isset($id) && $this->choix->getChoixById($id)) {
                if ($this->choix->deleteChoix($id, $reason ?? 'Suppression')) {
                    $msg = ['msg' => 'Kit supprimé avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de la suppression', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Kit introuvable!', 'status' => 0];
            }
        } else {
            $msg = ['msg' => 'Une erreur est survenue!', 'status' => 0];
        }
        echo json_encode($msg);
    }

    // Liste des catégories
    public function categories()
    {
        $categories = $this->categorie->getAllCategories(1);
        require_once '../views/categories/list.php';
    }

    // Ajouter une catégorie
    public function addCategory()
    {
        extract($_POST);

        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST,['description']);

            if ($notEmpty !== true) {
                $msg = ['msg' => 'Veuillez renseigner les champs obligatoires!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            if ($this->validator->verifs(TABLES::CATEGORIES, "libelle_categorie",'campagne_code', $libelle, CAMPAGNE_CODE)) {
                $msg = ['msg' => 'Le libellé de catégorie existe déjà dans cette campagne!', 'status' => 0];
                echo json_encode($msg);
                return;
            }


            // Génération du code catégorie
            $code_categorie = $this->validator->generateCode(TABLES::CATEGORIES, 'code_categorie', 'CAT-', 6);

            // Traitement de l'image
            $imagePath = '';
            try {
                $imagePath = Validator::uploadImage('image', TABLES::CATEGORIES) ?? '';
            } catch (Exception $e) {
                $msg = ['msg' => 'Erreur lors de l\'upload de l\'image: ' . $e->getMessage(), 'status' => 0];
                echo json_encode($msg);
                return;
            }

            // Préparation des données pour la méthode create du Validator
            $data = [
                'campagne_code' => CAMPAGNE_CODE,
                'code_categorie' => $code_categorie,
                'libelle_categorie' => trim($libelle),
                'description_categorie' => $description ?? null,
                'nombre_jour' => $nombre_jour ?? 365,
                'date_debut' => $date_debut,
                'date_fin' => $date_fin,
                'img_categorie' => $imagePath
            ];

            if ($this->validator->create(TABLES::CATEGORIES, $data)) {
                $msg = ['msg' => 'Catégorie ajoutée avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Liste des articles
    public function articles()
    {
        $articles = $this->article->getAllArticles(1);
        require_once '../views/articles/list.php';
    }

    // Ajouter un article
    public function addArticle()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST);

            if ($notEmpty === true) {
                extract($_POST);

                // Génération du code article
                $code_article = $this->validator->generateCode('articles', 'code_article', 'ART-', 6);

                // Préparation des données pour la méthode create du Validator
                $data = [
                    'code_article' => $code_article,
                    'libelle_article' => trim($libelle),
                    'etat_article' => 1,
                    'famille_id' => $famille_id,
                    'image_article' => null
                ];

                if ($this->validator->create('articles', $data)) {
                    $msg = ['msg' => 'Article ajouté avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Ajouter des articles à un kit
    public function addArticlesToKit($kitCode)
    {
        // Vérifier si le paramètre est crypté (contient des caractères spéciaux encodés)
        // Si c'est le cas, le décrypter ; sinon, utiliser directement
        if (strpos($kitCode, '%') !== false || strpos($kitCode, 'CHOIX-KIT-') === false) {
            $kitCode = $this->validator->decrypter($kitCode);
        }
        
        // Récupérer les informations du kit
        $kit = $this->choix->getChoixByCode($kitCode);
        
        // Récupérer tous les articles disponibles
        $articles = $this->article->getAllArticles(ETAT[1]);
        
        // Récupérer les articles déjà liés au kit
        $kitArticles = $this->article->getArticlesByChoix($kitCode);
        
        // Passer le code du kit à la vue
        $kitCode = $kitCode;
        
        require_once '../views/kits/articles.php';
    }

    // Sauvegarder les articles liés à un kit
    public function saveKitArticles()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            
            if (!isset($kit_code) || empty($kit_code)) {
                $msg = ['msg' => 'Kit non spécifié!', 'status' => 0];
                echo json_encode($msg);
                return;
            }
            
            if (!isset($articles) || empty($articles)) {
                $msg = ['msg' => 'Veuillez sélectionner au moins un article!', 'status' => 0];
                echo json_encode($msg);
                return;
            }
            
            try {
                // Ajouter les nouveaux articles (vérifie si l'article existe déjà)
                foreach ($articles as $article_code) {
                    // Vérifier si l'article est déjà lié au kit
                    $existingArticles = $this->article->getArticlesByChoix($kit_code);
                    $exists = false;
                    foreach ($existingArticles as $existing) {
                        if ($existing['code_article'] === $article_code) {
                            $exists = true;
                            break;
                        }
                    }
                    // Ajouter seulement si l'article n'existe pas déjà
                    if (!$exists) {
                        $this->choix->addArticleToKit($kit_code, $article_code);
                    }
                }
                
                $msg = ['msg' => 'Articles liés au kit avec succès!', 'status' => 1];
            } catch (Exception $e) {
                $msg = ['msg' => 'Erreur: ' . $e->getMessage(), 'status' => 0];
            }
            
            echo json_encode($msg);
        }
    }
}
