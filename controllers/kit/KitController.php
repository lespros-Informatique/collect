<?php

require_once '../models/Validator.php';

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
    public function details($code)
    {
        $kit = $this->choix->getChoixByCode($code);
        if ($kit) {
            $articles = $this->article->getArticlesByChoix($code);
        }
        require_once '../views/kits/details.php';
    }

    // Ajouter un kit
    public function add()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST);

            if ($notEmpty === true) {
                extract($_POST);

                // Génération du code choix
                $code_choix = $this->validator->generateCode('choix', 'code_choix', 'CHOIX-KIT-', 6);

                // Préparation des données pour la méthode create du Validator
                $data = [
                    'code_choix' => $code_choix,
                    'categorie_code' => $categorie_code,
                    'libelle_choix' => trim($libelle),
                    'description_choix' => $description ?? null,
                    'cotisation_choix' => $cotisation,
                    'img_choix' => null,
                    'etat_choix' => 1
                ];

                if ($this->validator->create('choix', $data)) {
                    $msg = ['msg' => 'Kit ajouté avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Modifier un kit
    public function edit()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST);

            if ($notEmpty === true) {
                extract($_POST);

                // Préparation des données pour la méthode update du Validator
                $data = [
                    'libelle_choix' => trim($libelle),
                    'description_choix' => $description ?? null,
                    'cotisation_choix' => $cotisation,
                    'img_choix' => null,
                    'etat_choix' => $etat_choix ?? 1
                ];

                if ($this->validator->update('choix', 'id_choix', $id, $data)) {
                    $msg = ['msg' => 'Kit modifié avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
            }
            echo json_encode($msg);
        }
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
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST);

            if ($notEmpty === true) {
                extract($_POST);

                // Génération du code catégorie
                $code_categorie = $this->validator->generateCode('categories', 'code_categorie', 'CAT-', 6);

                // Préparation des données pour la méthode create du Validator
                $data = [
                    'code_categorie' => $code_categorie,
                    'libelle_categorie' => trim($libelle),
                    'description_categorie' => $description ?? null,
                    'nombre_jour' => $nombre_jour ?? 365,
                    'date_debut' => $date_debut,
                    'date_fin' => $date_fin,
                    'img_categorie' => null,
                    'etat_categorie' => 1
                ];

                if ($this->validator->create('categories', $data)) {
                    $msg = ['msg' => 'Catégorie ajoutée avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
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
}
