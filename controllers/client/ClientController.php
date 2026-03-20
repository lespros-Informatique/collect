<?php

class ClientController
{
    private $validator;
    private $client;
    private $inscription;
    private $paiement;
    private $user;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->client = new ModelClient();
        $this->inscription = new ModelInscription();
        $this->paiement = new ModelPaiement();
        $this->user = new ModelUser();
    }

    // Liste des clients
    public function index()
    {
        $clients = $this->client->getAllClients(1);
        $users = $this->user->getUsers(1);
        $validator = $this->validator;
        require_once '../views/clients/list.php';
    }

    // Détails d'un client
    public function details($code)
    {
        // Décrypter le code client
        $clientCode = $this->validator->decrypter($code);
        
        $client = $this->client->getClientByCode($clientCode);
        $inscriptions = [];
        $paiements = [];
        if ($client) {
            $inscriptions = $this->inscription->getInscriptionsByClient($clientCode) ?? [];
            $paiements = $this->paiement->getPaiementsByInscription($clientCode) ?? [];
        }
        require_once '../views/clients/details.php';
    }

    // Ajouter un client
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

            // Validation du téléphone
            if (!Validator::validNumber($telephone, 10)) {
                $msg = ['msg' => 'Le numéro de téléphone doit contenir 10 chiffres!', 'status' => 0];
                echo json_encode($msg);
                return;
            }
            // Vérification si le téléphone existe déjà
            if ($this->validator->verif('clients', 'telephone_client', $telephone)) {
                $msg = ['msg' => 'Ce numéro de téléphone existe déjà!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            // Génération automatique du code client
            $code_client = $this->validator->generateCode('clients', 'code_client', 'CLIENT-', 6);

            // Date de création
            $created_at_client = Validator::dateActuelle();

            // Préparation des données pour la méthode create du Validator
            $data = [
                'code_client' => $code_client,
                'user_code' => $user_code ?? null,
                'nom_client' => trim($nom),
                'telephone_client' => trim($telephone),
                'quartier_client' => $quartier ?? null,
                'zone_client' => $zone ?? null,
                'created_at_client' => $created_at_client,
                'etat_client' => 1
            ];

            if ($this->validator->create('clients', $data)) {
                $msg = [
                    'msg' => 'Client ajouté avec succès!',
                    'status' => 1,
                    'code_client' => $code_client
                ];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Modifier un client
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

            // Validation du téléphone
            if (!Validator::validNumber($telephone, 10)) {
                $msg = ['msg' => 'Le numéro de téléphone doit contenir 10 chiffres!', 'status' => 0];
                echo json_encode($msg);
                return;
            }
            // Vérification si le téléphone existe déjà pour un autre client
            if ($this->validator->_verif('clients', 'telephone_client', $telephone, 'id_client', $id)) {
                $msg = ['msg' => 'Ce numéro de téléphone est déjà utilisé!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            // Préparation des données pour la méthode update du Validator
            $data = [
                'nom_client' => trim($nom),
                'telephone_client' => trim($telephone),
                'quartier_client' => $quartier ?? null,
                'zone_client' => $zone ?? null,
                'etat_client' => $etat_client ?? 1
            ];

            if ($this->validator->update('clients', 'id_client', $id, $data)) {
                $msg = ['msg' => 'Client modifié avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Inscrire un client à un kit
    public function inscription()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST);

            if ($notEmpty === true) {
                extract($_POST);

                // Vérification si l'inscription existe déjà
                $existing = $this->inscription->getInscriptionsByClient($client_code);
                foreach ($existing as $inscr) {
                    if ($inscr['etat_inscription'] == 1 && $inscr['categorie_code'] == $categorie_code) {
                        $msg = ['msg' => 'Ce client est déjà inscrit à cette catégorie!', 'status' => 0];
                        echo json_encode($msg);
                        return;
                    }
                }

                // Génération du code inscription
                $code_inscription = $this->validator->generateCode('inscriptions', 'code_inscription', 'INS-', 6);

                // Dates
                $date_debut = Validator::dateActuelle();
                $date_fin = Validator::calculerDateFin($date_debut, 12);

                // Préparation des données pour la méthode create du Validator
                $data = [
                    'code_inscription' => $code_inscription,
                    'user_code' => $user_code,
                    'client_code' => $client_code,
                    'etat_inscription' => 1,
                    'type_inscription' => $type_inscription ?? 'annuel',
                    'date_debut' => $date_debut,
                    'date_fin' => $date_fin,
                    'categorie_code' => $categorie_code ?? null
                ];

                if ($this->validator->create('inscriptions', $data)) {
                    $msg = ['msg' => 'Inscription enregistrée avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de l\'inscription', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Voir les inscriptions d'un client
    public function inscriptions($code)
    {
        $inscriptions = $this->inscription->getInscriptionsByClient($code);
        echo json_encode($inscriptions);
    }

    // Voir les paiements d'un client
    public function paiements($code)
    {
        $paiements = $this->paiement->getPaiementsByInscription($code);
        echo json_encode($paiements);
    }

    // Supprimer un client
    public function delete()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            if (isset($id) && $this->client->getClientById($id)) {
                if ($this->client->deleteClient($id, $reason ?? 'Suppression')) {
                    $msg = ['msg' => 'Client supprimé avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de la suppression', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Client introuvable!', 'status' => 0];
            }
        } else {
            $msg = ['msg' => 'Une erreur est survenue!', 'status' => 0];
        }
        echo json_encode($msg);
    }
}
