<?php

class SuccursaleController
{
    private $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    // List
    public function home()
    {
        require_once '../views/succursales/liste.php';
    }

    // Ajout
    public function add()
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

            // Préparation des données pour la méthode create du Validator
            $data = [
                'code_succursale' => $code,
                'libelle_succursale' => $libelle,
                'entreprise_code' => CODE_ENTREPRISE
            ];

            if ($this->validator->verif('succursales', 'libelle_succursale', $libelle)) {
                $msg = ['msg' => 'Ce libellé de succursale existe déjà!', 'status' => 0];
            }elseif ($this->validator->create('succursales', $data)) {
                $msg = [
                    'msg' => 'Succursale ajoutée avec succès!', 
                    'status' => 1,
                ];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }


}
