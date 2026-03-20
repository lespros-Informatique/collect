<?php

require_once '../models/Validator.php';
require_once '../models/articles/ModelArticle.php';
require_once '../models/familles/ModelFamille.php';

class ArticleController
{
    private $validator;
    private $article;
    private $famille;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->article = new ModelArticle();
        $this->famille = new ModelFamille();
    }

    // Liste des articles
    public function index()
    {
        $articles = $this->article->getAllArticles(STATUS_ACTIVE);
        $familles = $this->famille->getAllFamilles(STATUS_ACTIVE);
        require_once '../views/articles/list.php';
    }

    // Créer un article
    public function create()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST);

            if ($notEmpty !== true) {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            extract($_POST);

            // Génération du code article
            $code_article = $this->validator->generateCode('articles', 'code_article', 'ART-', 6);

            // Traitement de l'image
            $imagePath = '';
            try {
                $imagePath = Validator::uploadImage('image', 'articles') ?? '';
            } catch (Exception $e) {
                $msg = ['msg' => 'Erreur lors de l\'upload de l\'image: ' . $e->getMessage(), 'status' => 0];
                echo json_encode($msg);
                return;
            }

            // Préparation des données
            $data = [
                'code_article' => $code_article,
                'libelle_article' => trim($libelle),
                'etat_article' => 1,
                'famille_code' => $famille,
                'image_article' => $imagePath
            ];

            if ($this->validator->create('articles', $data)) {
                $msg = ['msg' => 'Article ajouté avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Modifier un article
    public function edit()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST);

            if ($notEmpty !== true) {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            extract($_POST);

            $data = [
                'libelle_article' => trim($libelle),
                'famille_code' => $famille,
                'etat_article' => $etat ?? 1
            ];

            if ($this->article->updateArticle($id, $data)) {
                $msg = ['msg' => 'Article modifié avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Supprimer un article
    public function delete()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            if (isset($id) && $this->article->getArticleById($id)) {
                if ($this->article->deleteArticle($id)) {
                    $msg = ['msg' => 'Article supprimé avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de la suppression', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Article introuvable!', 'status' => 0];
            }
        } else {
            $msg = ['msg' => 'Une erreur est survenue!', 'status' => 0];
        }
        echo json_encode($msg);
    }
}
