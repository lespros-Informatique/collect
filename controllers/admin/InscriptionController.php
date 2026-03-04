<?php

require_once '../models/Validator.php';
require_once '../models/inscriptions/ModelInscription.php';
require_once '../models/users/ModelUser.php';
require_once '../models/clients/ModelClient.php';

class InscriptionController
{
    private $validator;
    private $inscription;
    private $user;
    private $client;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->inscription = new ModelInscription();
        $this->user = new ModelUser();
        $this->client = new ModelClient();
    }

    // Liste des inscriptions
    public function index()
    {
        $inscriptions = $this->inscription->getAllInscriptions(1);
        $users = $this->user->getUsers(1);
        $clients = $this->client->getAllClients(1);
        require_once '../views/inscriptions/list.php';
    }

    // Détails d'une inscription
    public function details($param)
    {
        $code = $this->validator->decrypter($param);
        $inscription = $this->inscription->getInscriptionByCode($code);
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
}
