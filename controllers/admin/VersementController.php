<?php

require_once '../models/Validator.php';
require_once '../models/versements/ModelVersement.php';
require_once '../models/users/ModelUser.php';

class VersementController
{
    private $validator;
    private $versement;
    private $user;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->versement = new ModelVersement();
        $this->user = new ModelUser();
    }

    // Liste des versements
    public function index()
    {
        $versements = $this->versement->getAllVersements();
        $users = $this->user->getUsers(1);
        require_once '../views/versements/list.php';
    }

    // Détails d'un versement
    public function details($param)
    {
        $code = $this->validator->decrypter($param);
        $versement = $this->versement->getVersementByCode($code);
        require_once '../views/versements/details.php';
    }

    // Créer un versement
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

            // Génération du code versement
            $code_versement = $this->validator->generateCode('versements', 'code_versement', 'VERS-', 6);

            // Préparation des données
            $data = [
                'code_versement' => $code_versement,
                'rapport_code' => $rapport_code ?? null,
                'user_code' => $utilisateur,
                'montant_versement' => $montant,
                'date_created_versement' => date('Y-m-d H:i:s'),
                'date_expires_versement' => $date_expiration,
                'reseau_versement' => $reseau ?? 'Wave',
                'statut_versement' => 'pending',
                'etat_versement' => 'En cours'
            ];

            if ($this->versement->addVersement($data)) {
                $msg = ['msg' => 'Versement ajouté avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Modifier un versement
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
                'montant_versement' => $montant,
                'date_expires_versement' => $date_expiration,
                'reseau_versement' => $reseau ?? 'Wave',
                'statut_versement' => $statut ?? 'pending',
                'etat_versement' => $etat ?? 'En cours'
            ];

            if ($this->versement->updateVersement($id, $data)) {
                $msg = ['msg' => 'Versement modifié avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }
}
