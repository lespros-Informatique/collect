<?php

require_once '../models/Validator.php';
require_once '../models/paiements/ModelPaiement.php';
require_once '../models/users/ModelUser.php';
require_once '../models/inscriptions/ModelInscription.php';

class PaiementController
{
    private $validator;
    private $paiement;
    private $user;
    private $inscription;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->paiement = new ModelPaiement();
        $this->user = new ModelUser();
        $this->inscription = new ModelInscription();
    }

    // Liste des paiements
    public function index()
    {
        $paiements = $this->paiement->getAllPaiements(1);
        $inscriptions = $this->inscription->getAllInscriptions(1);
        require_once '../views/paiements/list.php';
    }

    // Détails d'un paiement
    public function details($param)
    {
        $code = $this->validator->decrypter($param);
        $paiement = $this->paiement->getPaiementByCode($code);
        require_once '../views/paiements/details.php';
    }

    // Créer un paiement
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

            // Génération du code paiement
            $code_paiement = $this->validator->generateCode('paiements', 'code_paiement', 'PAY-', 6);

            // Préparation des données
            $data = [
                'code_paiement' => $code_paiement,
                'versement_code' => $versement_code ?? null,
                'user_code' => $_SESSION['user']['code_user'] ?? null,
                'inscription_code' => $inscription,
                'montant_paiement' => $montant,
                'telephone_paiement' => $telephone ?? null,
                'reseau_paiement' => $reseau ?? 'ESPECES',
                'nombre_jour_paye' => $nombre_jour,
                'created_at_paiement' => date('Y-m-d H:i:s'),
                'type_paiement' => $type ?? 'manuel',
                'statut_paiement' => 1,
                'etat_paiement' => 0
            ];

            if ($this->paiement->addPaiement($data)) {
                $msg = ['msg' => 'Paiement ajouté avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Modifier un paiement
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
                'inscription_code' => $inscription,
                'montant_paiement' => $montant,
                'telephone_paiement' => $telephone ?? null,
                'reseau_paiement' => $reseau ?? 'ESPECES',
                'nombre_jour_paye' => $nombre_jour,
                'type_paiement' => $type ?? 'manuel',
                'statut_paiement' => $statut ?? 1,
                'etat_paiement' => $etat ?? 0
            ];

            if ($this->paiement->updatePaiement($id, $data)) {
                $msg = ['msg' => 'Paiement modifié avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Supprimer un paiement
    public function delete()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            if (isset($id) && $this->paiement->getPaiementById($id)) {
                if ($this->paiement->deletePaiement($id, $reason ?? 'Suppression')) {
                    $msg = ['msg' => 'Paiement supprimé avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de la suppression', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Paiement introuvable!', 'status' => 0];
            }
        } else {
            $msg = ['msg' => 'Une erreur est survenue!', 'status' => 0];
        }
        echo json_encode($msg);
    }
}
