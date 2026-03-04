<?php
class UserController
{
    private $validator;
    private $user;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->user = new ModelUser();
    }

    public function decon()
    {
        require_once '../views/users/decon.php';
    }

    public function index()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            require_once '../views/home/home.php';
        } else {
            require_once '../views/users/connexion.php';
        }
    }

    public function details($details) // la vue de la connexion
    {
        try {
            $userId = $this->validator->decrypter($details);
            $userProfile = $this->user->getUserById($userId);

            if (!$userProfile) {
                // Redirect to user list if user not found
                header('Location: ' . RACINE . 'admin/users');
                exit();
            }
        } catch (Exception $e) {
            // Handle decryption error - redirect to user list
            header('Location: ' . RACINE . 'admin/users');
            exit();
        }

        require_once '../views/users/details.php';
    }

    public function edition($details)
    {
        try {
            $userId = $this->validator->decrypter($details);
            $userProfile = $this->user->getUserById($userId);

            if (!$userProfile) {
                header('Location: ' . RACINE . 'admin/users');
                exit();
            }
        } catch (Exception $e) {
            header('Location: ' . RACINE . 'admin/users');
            exit();
        }

        require_once '../views/users/edit.php';
    }

    public function profil()
    {
        // Get complete user profile data
        $userProfile = $this->user->getUserById(USER_ID);

        // Update session with additional user data if not already present
        if ($userProfile) {
            $_SESSION['user']['telephone'] = $userProfile['telephone_user'];
            $_SESSION['user']['email'] = $userProfile['email_user'];
            $_SESSION['user']['code_user'] = $userProfile['code_user'];
            $_SESSION['user']['quartier'] = $userProfile['quartier_user'];
            $_SESSION['user']['zone'] = $userProfile['zone_user'];
        }

        require_once '../views/users/profil.php';
    }

    public function list()
    {
        $users = $this->user->getUsers();
        require_once '../views/users/list.php';
    }

    public function connexion()
    {

        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST);

            if ($notEmpty === true) {
                extract($_POST);

                // Check if input is email or phone
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $user = $this->validator->getByElement('users', 'email_user', $email);
                } else {
                    $user = $this->validator->getByElement('users', 'telephone_user', $email);
                }
                // var_dump($user['password_user']);
                if (isset($user) && !empty($user) && Validator::verifyPassword($password, $user['password_user'])) {
                    if ($user['etat_user'] == 1) {
                        $_SESSION['user'] = [
                            'id_user' => $user['id_user'],
                            'nom' => $user['nom_user'],
                            'prenom' => $user['prenom_user'],
                            'email' => $user['email_user'] ?? $user['telephone_user'],
                            'telephone' => $user['telephone_user'],
                            'code_user' => $user['code_user'],
                            'role' => $user['role_code'],
                            'quartier' => $user['quartier_user'],
                            'zone' => $user['zone_user'],
                        ];

                        $msg = ['msg' => 'Bienvenue sur ' . APP_NAME . '!', 'status' => 1];
                    } else {
                        $msg = ['msg' => 'Ce compte utilisateur est inactif', 'status' => 0];
                    }
                } else {
                    $msg = ['msg' => 'Identifiants incorrects. Veuillez vérifier votre email/téléphone et mot de passe.', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    public function add()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Liste des champs obligatoires
            $requiredFields = ['nom_user', 'prenom_user', 'telephone_user', 'email_user', 'quartier_user', 'zone_user', 'role_code'];
            $notEmpty = Validator::validateRequiredFields($_POST, ['piece_user', 'photo_user']);

            if ($notEmpty === true) {
                extract($_POST);

                // Validation de l'email
                if (!Validator::isValidEmail($email_user)) {
                    $msg = ['msg' => 'Format d\'email invalide!', 'status' => 0];
                }
                // Validation du téléphone (8 à 15 chiffres)
                elseif (!Validator::validNumber($telephone_user, 10)) {
                    $msg = ['msg' => 'Le numéro de téléphone doit contenir 10 chiffres!', 'status' => 0];
                }
                // Vérification si l'email existe déjà
                elseif ($this->validator->verif('users', 'email_user', $email_user)) {
                    $msg = ['msg' => 'Cet email existe déjà!', 'status' => 0];
                }
                // Vérification si le téléphone existe déjà
                elseif ($this->validator->verif('users', 'telephone_user', $telephone_user)) {
                    $msg = ['msg' => 'Ce numéro de téléphone existe déjà!', 'status' => 0];
                } else {
                    // Génération automatique du code utilisateur
                    $code_user = $this->validator->generateCode('users', 'code_user', 'USER-', 6);

                    // Hash du mot de passe par défaut
                    $defaultPassword = 12345;
                    $password_user = Validator::hashPassword($defaultPassword);

                    // Date de création
                    $date_created_user = Validator::dateActuelle();

                    // Préparation des données pour la méthode create du Validator
                    $data = [
                        'code_user' => $code_user,
                        'nom_user' => trim($nom_user),
                        'prenom_user' => trim($prenom_user),
                        'telephone_user' => trim($telephone_user),
                        'email_user' => trim($email_user),
                        'password_user' => $password_user,
                        'quartier_user' => trim($quartier_user),
                        'zone_user' => trim($zone_user),
                        'piece_user' => $piece_user ?? null,
                        'photo_user' => $photo_user ?? null,
                        'date_created_user' => $date_created_user,
                        'user_code' => $code_user,
                        'etat_user' => 1,
                        'role_code' => $role_code ?? 'ROLE-COM-001'
                    ];

                    if ($this->validator->create('users', $data)) {
                        $msg = ['msg' => 'Utilisateur ajouté avec succès!', 'status' => 1];
                    } else {
                        $msg = ['msg' => 'Erreur lors de l\'ajout de l\'utilisateur', 'status' => 0];
                    }
                }
            } else {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST, ['piece_user', 'photo_user', 'etat_user']);

            if ($notEmpty === true) {
                extract($_POST);

                // Validation de l'email
                if (!Validator::isValidEmail($email_user)) {
                    $msg = ['msg' => 'Format d\'email invalide!', 'status' => 0];
                }
                // Validation du téléphone
                elseif (!Validator::validNumber($telephone_user, 10)) {
                    $msg = ['msg' => 'Le numéro de téléphone doit contenir 10 chiffres!', 'status' => 0];
                }
                // Vérification si l'email existe déjà (sauf pour l'utilisateur actuel)
                elseif ($this->validator->_verif('users', 'email_user', $email_user, 'id_user', $id_user)) {
                    $msg = ['msg' => 'Cet email est déjà utilisé par un autre utilisateur!', 'status' => 0];
                }
                // Vérification si le téléphone existe déjà (sauf pour l'utilisateur actuel)
                elseif ($this->validator->_verif('users', 'telephone_user', $telephone_user, 'id_user', $id_user)) {
                    $msg = ['msg' => 'Ce numéro de téléphone est déjà utilisé par un autre utilisateur!', 'status' => 0];
                } else {
                    // Préparation des données pour la méthode update du Validator
                    $data = [
                        'nom_user' => trim($nom_user),
                        'prenom_user' => trim($prenom_user),
                        'telephone_user' => trim($telephone_user),
                        'email_user' => trim($email_user),
                        'quartier_user' => trim($quartier_user),
                        'zone_user' => trim($zone_user),
                        'piece_user' => $piece_user ?? null,
                        'photo_user' => $photo_user ?? null,
                        'role_code' => $role_code ?? 'ROLE-COM-001',
                        'etat_user' => $etat_user ?? 1
                    ];

                    if ($this->validator->update('users', 'id_user', $id_user, $data)) {
                        $msg = ['msg' => 'Utilisateur modifié avec succès!', 'status' => 1];
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

    public function changer()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            if (isset($id) && $this->user->getUserById($id)) {
                if ($this->user->toggleStatus($id)) {
                    $msg = ['msg' => 'Statut modifié avec succès!', 'status' => 1, 'id' => $id, 'reload' => true];
                } else {
                    $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Utilisateur introuvable!', 'status' => 0];
            }
        } else {
            $msg = ['msg' => 'Une erreur est survenue!', 'status' => 0];
        }
        echo json_encode($msg);
    }

    public function editPassword()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notEmpty = Validator::validateRequiredFields($_POST);

            if ($notEmpty === true) {
                extract($_POST);

                $user = $this->user->getUserById(USER_ID);
                if (isset($user) && !empty($user) && password_verify($password, $user['password'])) {
                    $mdp = Validator::hashPassword($newPassword);
                    $data = [$mdp, USER_ID];
                    if ($this->user->updatePassword($data)) {
                        $msg = ['msg' => 'Mot de passe modifié avec succès!', 'status' => 1];
                    } else {
                        $msg = ['msg' => 'Erreur lors de la modification du mot de passe!', 'status' => 0];
                    }
                } else {
                    $msg = ['msg' => 'Ancien mot de passe incorrect!', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Veuillez renseigner tous les champs!', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }
}
