<?php

require_once '../models/Validator.php';

class CommercialController
{
    private $validator;
    private $user;
    private $client;
    private $inscription;
    private $paiement;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->user = new ModelUser();
        $this->client = new ModelClient();
        $this->inscription = new ModelInscription();
        $this->paiement = new ModelPaiement();
    }

    // Liste des commerciaux
    public function index()
    {
        $users = $this->user->getUsersByRole('ROLE-COM-001');
        $roles = new ModelRole();
        $allRoles = $roles->getAllRoles();
        require_once '../views/commercials/list.php';
    }

    // Ajouter un commercial
    public function add()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST);

            if ($notEmpty === true) {
                extract($_POST);

                // Validation de l'email
                if (!empty($email) && !Validator::isValidEmail($email)) {
                    $msg = ['msg' => 'Format d\'email invalide!', 'status' => 0];
                }
                // Validation du téléphone
                elseif (!Validator::validNumber($telephone, 10)) {
                    $msg = ['msg' => 'Le numéro de téléphone doit contenir 10 chiffres!', 'status' => 0];
                }
                // Vérification si le téléphone existe déjà
                elseif ($this->validator->verif('users', 'telephone_user', $telephone)) {
                    $msg = ['msg' => 'Ce numéro de téléphone existe déjà!', 'status' => 0];
                }
                // Vérification si l'email existe déjà
                elseif (!empty($email) && $this->validator->verif('users', 'email_user', $email)) {
                    $msg = ['msg' => 'Cet email existe déjà!', 'status' => 0];
                } else {
                    // Génération automatique du code utilisateur
                    $code_user = $this->validator->generateCode('users', 'code_user', 'USER-COM-', 6);

                    // Hash du mot de passe par défaut
                    $defaultPassword = 12345;
                    $password_user = Validator::hashPassword($defaultPassword);

                    // Date de création
                    $date_created_user = Validator::dateActuelle();

                    // Préparation des données pour la méthode create du Validator
                    $data = [
                        'code_user' => $code_user,
                        'nom_user' => trim($nom),
                        'prenom_user' => trim($prenom),
                        'telephone_user' => trim($telephone),
                        'email_user' => $email ?? null,
                        'password_user' => $password_user,
                        'quartier_user' => $quartier ?? null,
                        'zone_user' => $zone ?? null,
                        'date_created_user' => $date_created_user,
                        'user_code' => $code_user,
                        'etat_user' => 1,
                        'role_code' => $role ?? 'ROLE-COM-001'
                    ];

                    if ($this->validator->create('users', $data)) {
                        $msg = ['msg' => 'Commercial ajouté avec succès!', 'status' => 1];
                    } else {
                        $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
                    }
                }
            } else {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Modifier un commercial
    public function edit()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST);

            if ($notEmpty === true) {
                extract($_POST);

                // Validation de l'email
                if (!empty($email) && !Validator::isValidEmail($email)) {
                    $msg = ['msg' => 'Format d\'email invalide!', 'status' => 0];
                }
                // Validation du téléphone
                elseif (!Validator::validNumber($telephone, 10)) {
                    $msg = ['msg' => 'Le numéro de téléphone doit contenir 10 chiffres!', 'status' => 0];
                }
                // Vérification si le téléphone existe déjà pour un autre utilisateur
                elseif ($this->validator->_verif('users', 'telephone_user', $telephone, 'id_user', $id)) {
                    $msg = ['msg' => 'Ce numéro de téléphone est déjà utilisé!', 'status' => 0];
                }
                // Vérification si l'email existe déjà pour un autre utilisateur
                elseif (!empty($email) && $this->validator->_verif('users', 'email_user', $email, 'id_user', $id)) {
                    $msg = ['msg' => 'Cet email est déjà utilisé!', 'status' => 0];
                } else {
                    // Préparation des données pour la méthode update du Validator
                    $data = [
                        'nom_user' => trim($nom),
                        'prenom_user' => trim($prenom),
                        'telephone_user' => trim($telephone),
                        'email_user' => $email ?? null,
                        'quartier_user' => $quartier ?? null,
                        'zone_user' => $zone ?? null,
                        'role_code' => $role ?? 'ROLE-COM-001',
                        'etat_user' => $etat_user ?? 1
                    ];

                    if ($this->validator->update('users', 'id_user', $id, $data)) {
                        $msg = ['msg' => 'Commercial modifié avec succès!', 'status' => 1];
                    } else {
                        $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
                    }
                }
            } else {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Voir les clients d'un commercial
    public function mesClients()
    {
        $code = $_SESSION['user']['code_user'] ?? null;
        if ($code) {
            $clients = $this->client->getClientsByCommercial($code);
        } else {
            $clients = [];
        }
        require_once '../views/commercials/mes_clients.php';
    }

    // Enregistrer un paiement
    public function addPaiement()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST);

            if ($notEmpty === true) {
                extract($_POST);

                // Génération du code paiement
                $code_paiement = $this->validator->generateCode('paiements', 'code_paiement', 'PAY-', 6);

                // Date de création
                $created_at_paiement = Validator::dateActuelle();

                // Préparation des données pour la méthode create du Validator
                $data = [
                    'code_paiement' => $code_paiement,
                    'versement_code' => null,
                    'user_code' => $_SESSION['user']['code_user'],
                    'inscription_code' => $inscription_code,
                    'montant_paiement' => $montant,
                    'telephone_paiement' => $telephone,
                    'reseau_paiement' => $reseau ?? 'ESPECES',
                    'nombre_jour_paye' => 1,
                    'created_at_paiement' => $created_at_paiement,
                    'type_paiement' => 'manuel',
                    'statut_paiement' => 1,
                    'etat_paiement' => 0
                ];

                if ($this->validator->create('paiements', $data)) {
                    $msg = ['msg' => 'Paiement enregistré avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de l\'enregistrement', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Voir mes paiements
    public function mesPaiements()
    {
        $code = $_SESSION['user']['code_user'] ?? null;
        if ($code) {
            $paiements = $this->paiement->getPaiementsByCommercial($code);
        } else {
            $paiements = [];
        }
        require_once '../views/commercials/mes_paiements.php';
    }
}
