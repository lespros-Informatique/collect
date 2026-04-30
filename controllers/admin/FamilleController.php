<?php

require_once '../models/Validator.php';
require_once '../models/familles/ModelFamille.php';

class FamilleController
{
    private $validator;
    private $famille;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->famille = new ModelFamille();
    }

    // Liste des familles
    public function index()
    {
        $familles = $this->famille->getAllFamilles(ETAT[1]);
        require_once '../views/familles/list.php';
    }

    // Créer une famille
    public function create()
    {
        extract($_POST);
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST, ['description']);

            if ($notEmpty !== true) {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            if ($this->validator->verif(TABLES::FAMILLES, "libelle_famille", $libelle)) {
                $msg = ['msg' => 'Le libellé de famille existe déjà!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            // Génération du code famille
            $code_famille = $this->validator->generateCode(TABLES::FAMILLES, 'code_famille', 'FAM-', 6);

            // Préparation des données
            $data = [
                'code_famille' => $code_famille,
                'libelle_famille' => trim($libelle),
                'description_famille' => $description ?? null,
                'created_at_famille' => $this->validator->dateActuelle(),
                'etat_famille' => ETAT[1]
            ];

            if ($this->famille->addFamille($data)) {
                $msg = ['msg' => 'Famille ajoutée avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Modifier une famille
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
                'libelle_famille' => trim($libelle),
                'description_famille' => $description ?? null,
                'etat_famille' => $etat ?? ETAT[1]
            ];

            if ($this->famille->updateFamille($id, $data)) {
                $msg = ['msg' => 'Famille modifiée avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Supprimer une famille
    public function delete()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            if (isset($id) && $this->famille->getFamilleById($id)) {
                if ($this->famille->deleteFamille($id)) {
                    $msg = ['msg' => 'Famille supprimée avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de la suppression', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Famille introuvable!', 'status' => 0];
            }
        } else {
            $msg = ['msg' => 'Une erreur est survenue!', 'status' => 0];
        }
        echo json_encode($msg);
    }
}
