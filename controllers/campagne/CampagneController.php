<?php

class CampagneController
{
    private $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    // List
    public function home()
    {
        require_once '../views/campagne/liste.php';
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
                'code_campagne' => $code,
                'libelle_campagne' => $libelle,
                'entreprise_code' => CODE_ENTREPRISE
            ];

            if ($this->validator->verif('campagnes', 'libelle_campagne', $libelle)) {
                $msg = ['msg' => 'Ce libellé de campagne existe déjà!', 'status' => 0];
            }elseif ($this->validator->create('campagnes', $data)) {
                $msg = [
                    'msg' => 'Campagne ajoutée avec succès!', 
                    'status' => 1,
                ];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }


}
