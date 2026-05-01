<?php

require_once '../models/Validator.php';
require_once '../models/versements/ModelVersement.php';
require_once '../models/users/ModelUser.php';
require_once '../models/paiements/ModelPaiement.php';

class VersementController
{
    private $validator;
    private $versement;
    private $user;
    private $paiement;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->versement = new ModelVersement();
        $this->paiement = new ModelPaiement();
        $this->user = new ModelUser();
    }

    // Liste des versements
    public function index()
    {
        $paiements = $this->versement->getPaiementsByCommercialInvalide();
        $users = $this->user->getUsers(1);
        $paiementsInvalides = $this->paiement->getSumPaiementsByCommercialInvalide(USER_CODE);
        require_once '../views/versements/list.php';
    }

    // Détails d'un versement
    public function details($param)
    {
        $params = explode('separator', $this->validator->decrypter($param));
        $code = $params[0];
        $statut = $params[1];
        $paiements = $this->validator->getAllByElement(TABLES::PAIEMENTS, 'versement_code', $code);
        require_once '../views/versements/details.php';
    }

    // Créer un versement
    public function create()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST,['description']);

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
                'user_code' => USER_CODE,
                'montant_versement' => $montant,
                'date_created_versement' => date('Y-m-d H:i:s'),
                'reseau_versement' => $reseau ?? 'ESPACE'
            ];
            // Démarrer une transaction pour assurer l'intégrité des données
            $this->validator->safeBeginTransaction();

            try {
            if ($this->versement->addVersement($data)) {
                // update paiement where versement_code = $code_versement
                $dataUpdatePaiement = [
                    'statut_paiement' => ETAT[1],
                    'versement_code' => $code_versement
                ];
                $updated = $this->validator->update2(TABLES::PAIEMENTS, ['statut_paiement' => STATUT[0],'user_code' => USER_CODE], $dataUpdatePaiement);
                if ($updated) {
                    
                    $msg = ['msg' => 'Versement ajouté avec succès!', 'status' => 1];
                    $this->validator->safeCommit();
                }else{
                    $this->validator->safeRollBack();
                    $msg = ['msg' => 'Erreur lors de la mise à jour du paiement', 'status' => 0];
                }
                $this->validator->safeRollBack();
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
                $this->validator->safeRollBack();
            }
            echo json_encode($msg);
            } catch (Exception $e) {
                $this->validator->safeRollBack();
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
                echo json_encode($msg);
            }
        }
    }

    // Modifier un versement
    public function edit()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST,['description']);

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
