<?php

require_once '../models/Validator.php';
require_once '../models/roles/ModelRole.php';
require_once '../models/categories/ModelCategorie.php';

class SettingsController
{
    private $validator;
    private $role;
    private $categorie;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->role = new ModelRole();
        $this->categorie = new ModelCategorie();
    }

    // Page des paramètres
    public function index()
    {
        $roles = $this->role->getAllRoles();
        $categories = $this->categorie->getAllCategories(1);
        require_once '../views/settings/settings.php';
    }

    // Mettre à jour les paramètres de l'entreprise
    public function update()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ici vous pouvez ajouter la logique pour sauvegarder les paramètres
            // Pour le moment, nous simulons une sauvegarde
            $msg = ['msg' => 'Paramètres sauvegardés avec succès!', 'status' => 1];
            echo json_encode($msg);
        }
    }

    // Mettre à jour les préférences
    public function updatePreferences()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ici vous pouvez ajouter la logique pour sauvegarder les préférences
            $msg = ['msg' => 'Préférences sauvegardées avec succès!', 'status' => 1];
            echo json_encode($msg);
        }
    }

    // Ajouter un rôle
    public function addRole()
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

            // Génération du code rôle
            $code_role = $this->validator->generateCode('roles', 'code_role', 'ROLE-', 6);

            // Préparation des données
            $data = [
                'code_role' => $code_role,
                'libelle_role' => $libelle,
                'etat_role' => 1
            ];

            if ($this->role->addRole($data)) {
                $msg = ['msg' => 'Rôle ajouté avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Modifier un rôle
    public function editRole()
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
                'libelle_role' => $libelle,
                'etat_role' => $etat ?? 1
            ];

            if ($this->role->updateRole($id, $data)) {
                $msg = ['msg' => 'Rôle modifié avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }
}
