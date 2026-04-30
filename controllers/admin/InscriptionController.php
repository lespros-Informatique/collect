<?php

require_once '../models/Validator.php';
require_once '../models/inscriptions/ModelInscription.php';
require_once '../models/users/ModelUser.php';
require_once '../models/clients/ModelClient.php';
require_once '../models/choix/ModelChoix.php';
require_once '../models/categories/ModelCategorie.php';
require_once '../models/articles/ModelArticle.php';
require_once '../models/paiements/ModelPaiement.php';

class InscriptionController
{
    private $validator;
    private $inscription;
    private $user;
    private $client;
    private $choix;
    private $categorie;
    private $article;
    private $paiement;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->inscription = new ModelInscription();
        $this->user = new ModelUser();
        $this->client = new ModelClient();
        $this->choix = new ModelChoix();
        $this->categorie = new ModelCategorie();
        $this->article = new ModelArticle();
        $this->paiement = new ModelPaiement();
    }

    // Liste des inscriptions
    public function index()
    {


    $userCode = $_POST['user_code'] ?? null;
        $categorieCode = $_POST['categorie_code'] ?? null;
        
        if ($userCode && $categorieCode) {
            $inscriptions = $this->inscription->getInscriptionsByCommercial($userCode);
            $inscriptions = array_filter($inscriptions, function($i) use ($categorieCode) {
                $choix = $this->inscription->getChoixByInscription($i['code_inscription']);
                foreach ($choix as $c) {
                    if ($c['categorie_code'] == $categorieCode) return true;
                }
                return false;
            });
        } elseif ($userCode) {
            $inscriptions = $this->inscription->getInscriptionsByCommercial($userCode);
        } elseif ($categorieCode) {
            $inscriptions = $this->inscription->getInscriptionsByCategory($categorieCode);
        } else {
            $inscriptions = $this->inscription->getAllInscriptions();
        }
        


        // $inscriptions = $this->inscription->getAllInscriptions(1);
        $users = $this->user->getUsers(ETAT[1]);
        // $clients = $this->client->getAllClients(ETAT[1]);
        $categories = $this->categorie->getAllCategories(ETAT[1]);
        
        $validator = $this->validator;
        require_once '../views/inscriptions/list.php';
    }

    // Page de choix du kit pour un client
    public function choix($clientCode)
    {
 
        $plainCode = $this->validator->decrypter($clientCode);
        
        $client = $this->client->getClientByCode($plainCode);
        $categories = $this->categorie->getAllCategories(ETAT[1]);
        $choixList = $this->choix->getAllChoix(ETAT[1]);
        $users = $this->user->getUsers(ETAT[1]);
        // Passer tous les articles pour le select dans le modal
        // $articles = $this->article->getAllArticles(ETAT[1]);
        $clientCode = $plainCode;
        require_once '../views/inscriptions/choix.php';
    }

    // Détails d'une inscription
    public function details($param)
    {
        $code = $this->validator->decrypter($param);
        $inscription = $this->inscription->getInscriptionByCode($code);
        
        // Récupérer les données liées
        $client = [];
        $user = [];
        $kits = [];
        $paiements = [];
        
        if ($inscription) {
            // Client
            $client = $this->client->getClientByCode($inscription['client_code']) ?? [];
            
            // Utilisateur (commercial)
            $user = $this->user->getUserByCode($inscription['user_code']) ?? [];
            
            // Kits (via ligne_choix)
            $kits = $this->choix->getChoixByInscription($code) ?? [];
            $nombreJourPeriode = $this->inscription->getNombreJourByInscription($code);
            
            // Paiements (via ModelInscription)
            $paiements = $this->inscription->getPaiementsByInscription($code) ?? [];
            $totalPayer = $this->choix->getTotalChoixAndJoursByInscription($code);
            $totalPaye = $this->inscription->getMontantPayeValide($code);
            
            // $totalCotisation = $this->choix->getTotalChoixByInscription($code)['total'] ?? 0;
        }
        
        require_once '../views/inscriptions/details.php';
    }

    // Créer une inscription
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

            // Génération du code inscription
            $code_inscription = $this->validator->generateCode('inscriptions', 'code_inscription', 'INS-', 6);

            // Préparation des données
            $data = [
                'code_inscription' => $code_inscription,
                'user_code' => $utilisateur,
                'client_code' => $client,
                'type_inscription' => $type,
                'date_debut' => $date_debut,
                'date_fin' => $date_fin,
                'etat_inscription' => 1
            ];

            if ($this->inscription->addInscription($data)) {
                $msg = ['msg' => 'Inscription ajoutée avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Modifier une inscription
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
                'user_code' => $utilisateur,
                'client_code' => $client,
                'type_inscription' => $type,
                'date_debut' => $date_debut,
                'date_fin' => $date_fin,
                'etat_inscription' => $etat ?? 1
            ];

            if ($this->inscription->updateInscription($id, $data)) {
                $msg = ['msg' => 'Inscription modifiée avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Supprimer une inscription
    public function delete()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            if (isset($id) && $this->inscription->getInscriptionById($id)) {
                if ($this->inscription->deleteInscription($id, $reason ?? 'Suppression')) {
                    $msg = ['msg' => 'Inscription supprimée avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de la suppression', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Inscription introuvable!', 'status' => 0];
            }
        } else {
            $msg = ['msg' => 'Une erreur est survenue!', 'status' => 0];
        }
        echo json_encode($msg);
    }

    // Sauvegarder l'inscription avec le choix du kit
    public function save()
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

            // Vérifier si le client existe
            $client = $this->client->getClientByCode($client_code);
            if (!$client) {
                $msg = ['msg' => 'Client introuvable!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            // Vérifier si le choix existe
            $kit = $this->choix->getChoixByCode($choix_code);
            if (!$kit) {
                $msg = ['msg' => 'Kit introuvable!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            // Génération du code inscription
            $code_inscription = $this->validator->generateCode('inscriptions', 'code_inscription', 'INS-', 6);

            // Dates
            $date_debut = Validator::dateActuelle();
            $nombreMois = ($type_inscription === 'mensuel') ? 1 : 12;
            $date_fin = Validator::calculerDateFin($date_debut, $nombreMois);

            // Préparation des données (SANS categorie_code car cette colonne n'existe pas dans la table inscriptions)
            $data = [
                'code_inscription' => $code_inscription,
                'user_code' => $user_code,
                'client_code' => $client_code,
                'type_inscription' => $type_inscription,
                'date_debut' => $date_debut,
                'date_fin' => $date_fin,
                'etat_inscription' => 1
            ];

            if ($this->inscription->addInscription($data)) {
                // Ajouter le choix dans ligne_choix
                $code_ligne_choix = $this->validator->generateCode('ligne_choix', 'code_ligne_choix', 'LIG-CHOIX-', 6);
                $ligneChoixData = [
                    'code_ligne_choix' => $code_ligne_choix,
                    'created_at_ligne_choix' => Validator::dateActuelle(),
                    'inscription_code' => $code_inscription,
                    'choix_code' => $choix_code,
                    'etat_ligne_choix' => 1
                ];
                $this->validator->create('ligne_choix', $ligneChoixData);

                $msg = ['msg' => 'Inscription enregistrée avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'inscription', 'status' => 0];
            }
        } else {
            $msg = ['msg' => 'Méthode non autorisée', 'status' => 0];
        }
        echo json_encode($msg);
    }

    // Obtenir les articles d'un kit (pour preview AJAX)
    public function getArticlesByKit()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $choix_code = $_POST['choix_code'] ?? '';
            
            if (empty($choix_code)) {
                $msg = ['msg' => 'Code kit requis!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            $articles = $this->choix->getArticlesByChoix($choix_code);
            $msg = ['status' => 1, 'articles' => $articles];
        } else {
            $msg = ['msg' => 'Méthode non autorisée', 'status' => 0];
        }
        echo json_encode($msg);
    }

    // Sauvegarder l'inscription avec plusieurs kits
    public function saveMultiple()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier les champs obligatoires
            $requiredFields = ['client_code', 'type_inscription', 'user_code'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $msg = ['msg' => 'Veuillez renseigner tous les champs obligatoires!', 'status' => 0];
                    echo json_encode($msg);
                    return;
                }
            }

            $client_code = $_POST['client_code'];
            $type_inscription = $_POST['type_inscription'];
            $user_code = $_POST['user_code'];
            $kits = $_POST['kits'] ?? [];

            if (empty($kits)) {
                $msg = ['msg' => 'Veuillez sélectionner au moins un kit!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            // Vérifier si le client existe
            $client = $this->client->getClientByCode($client_code);
            if (!$client) {
                $msg = ['msg' => 'Client introuvable!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            // Génération du code inscription
            $code_inscription = $this->validator->generateCode('inscriptions', 'code_inscription', 'INS-', 6);

            // Dates
            $date_debut = Validator::dateActuelle();
            $nombreMois = ($type_inscription === 'mensuel') ? 1 : 12;
            $date_fin = Validator::calculerDateFin($date_debut, $nombreMois);

            // Préparation des données d'inscription (SANS categorie_code car cette colonne n'existe pas dans la table inscriptions)
            $data = [
                'code_inscription' => $code_inscription,
                'user_code' => $user_code,
                'client_code' => $client_code,
                'type_inscription' => $type_inscription,
                'date_debut' => $date_debut,
                'date_fin' => $date_fin,
                'etat_inscription' => 1
            ];

            if ($this->inscription->addInscription($data)) {
                // Ajouter chaque kit dans ligne_choix
                foreach ($kits as $choix_code) {
                    $kit = $this->choix->getChoixByCode($choix_code);
                    if ($kit) {
                        $code_ligne_choix = $this->validator->generateCode('ligne_choix', 'code_ligne_choix', 'LIG-CHOIX-', 6);
                        $ligneChoixData = [
                            'code_ligne_choix' => $code_ligne_choix,
                            'created_at_ligne_choix' => Validator::dateActuelle(),
                            'inscription_code' => $code_inscription,
                            'choix_code' => $choix_code,
                            'etat_ligne_choix' => 1
                        ];
                        $this->validator->create('ligne_choix', $ligneChoixData);
                    }
                }

                $msg = ['msg' => 'Inscription enregistrée avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'inscription', 'status' => 0];
            }
        } else {
            $msg = ['msg' => 'Méthode non autorisée', 'status' => 0];
        }
        echo json_encode($msg);
    }
}
