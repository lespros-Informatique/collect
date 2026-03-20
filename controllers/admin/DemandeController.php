<?php

class DemandeController
{
    private $validator;
    private $demande;
    private $categorie;
    private $user;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->demande = new ModelDemande();
        $this->categorie = new ModelCategorie();
        $this->user = new ModelUser();
    }

    // Liste des demandes
    public function index()
    {
        $demandes = $this->demande->getAllDemandes();
        $categories = $this->categorie->getAllCategories(1);
        $users = $this->user->getUsers(1);
        $stats = $this->demande->getStatistiques();
        $validator = $this->validator;
        require_once '../views/demandes/list.php';
    }

    // Vue pour ajouter une demande
    public function add()
    {
        $categories = $this->categorie->getAllCategories(1);
        $users = $this->user->getUsers(1);
        $validator = $this->validator;
        require_once '../views/demandes/add.php';
    }

    // Créer une demande
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

            // Validation de la quantité
            if (!is_numeric($total_demande) || $total_demande < 1) {
                $msg = ['msg' => 'La quantité doit être un nombre positif!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            // Génération automatique du code demande
            $code_demande = $this->validator->generateCode('demandes', 'code_demande', 'DEM-', 6);

            // Date de création
            $created_at_demande = Validator::dateActuelle();

            // Préparation des données
            $data = [
                'code_demande' => $code_demande,
                'total_demande' => $total_demande,
                'created_at_demande' => $created_at_demande,
                'etat_demande' => 1, // En attente
                'gestionnaire_code' => null,
                'utilisateur_code' => $utilisateur_code,
                'categorie_code' => $categorie_code
            ];

            if ($this->demande->createDemande($data)) {
                $msg = [
                    'msg' => 'Demande créée avec succès!',
                    'status' => 1,
                    'code_demande' => $code_demande
                ];
            } else {
                $msg = ['msg' => 'Erreur lors de la création', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Détails d'une demande
    public function details($params)
    {
        $code = $this->validator->decrypter($params);
        $demande = $this->demande->getDemandeByCode($code);
        $validator = $this->validator;
        require_once '../views/demandes/details.php';
    }

    // Modifier une demande
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

            // Validation de la quantité
            if (!is_numeric($total_demande) || $total_demande < 1) {
                $msg = ['msg' => 'La quantité doit être un nombre positif!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            // Préparation des données
            $data = [
                'total_demande' => $total_demande,
                'etat_demande' => $etat_demande,
                'gestionnaire_code' => $gestionnaire_code,
                'categorie_code' => $categorie_code
            ];

            if ($this->demande->updateDemande($code_demande, $data)) {
                $msg = ['msg' => 'Demande modifiée avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Supprimer une demande
    public function delete()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            if (isset($code_demande) && $this->demande->getDemandeByCode($code_demande)) {
                if ($this->demande->deleteDemande($code_demande)) {
                    $msg = ['msg' => 'Demande supprimée avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de la suppression', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Demande introuvable!', 'status' => 0];
            }
        } else {
            $msg = ['msg' => 'Une erreur est survenue!', 'status' => 0];
        }
        echo json_encode($msg);
    }

    // Valider une demande (approuver)
    public function valider()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            
            if (isset($code_demande) && $this->demande->getDemandeByCode($code_demande)) {
                // Récupérer les infos de la demande pour le mouvement de stock
                $demande = $this->demande->getDemandeByCode($code_demande);
                
                // Créer le mouvement de stock (SORTIE)
                $code_stock = $this->validator->generateCode('stocks', 'code_stock', 'STK-', 6);
                $stockData = [
                    'code_stock' => $code_stock,
                    'type_mouvement' => 'SORTIE',
                    'quantite_stock' => $demande['total_demande'],
                    'date_mouvement' => Validator::dateActuelle(),
                    'demande_code' => $code_demande,
                    'user_code' => $_SESSION['user_code'] ?? null,
                    'categorie_code' => $demande['categorie_code'],
                    'commentaire' => 'Validation de la demande'
                ];
                
                $this->demande->createMouvementStock($stockData);
                
                // Valider la demande
                if ($this->demande->validerDemande($code_demande, $_SESSION['user_code'] ?? null)) {
                    $msg = ['msg' => 'Demande validée avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de la validation', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Demande introuvable!', 'status' => 0];
            }
        } else {
            $msg = ['msg' => 'Une erreur est survenue!', 'status' => 0];
        }
        echo json_encode($msg);
    }

    // Rejeter une demande
    public function rejeter()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            if (isset($code_demande) && $this->demande->getDemandeByCode($code_demande)) {
                if ($this->demande->rejeterDemande($code_demande, $_SESSION['user_code'] ?? null)) {
                    $msg = ['msg' => 'Demande rejetée!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors du rejet', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Demande introuvable!', 'status' => 0];
            }
        } else {
            $msg = ['msg' => 'Une erreur est survenue!', 'status' => 0];
        }
        echo json_encode($msg);
    }

    // Gestion des stocks - Entrée de stock
    public function entreeStock()
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

            // Génération du code stock
            $code_stock = $this->validator->generateCode('stocks', 'code_stock', 'STK-', 6);

            $data = [
                'code_stock' => $code_stock,
                'type_mouvement' => 'ENTREE',
                'quantite_stock' => $quantite,
                'date_mouvement' => Validator::dateActuelle(),
                'demande_code' => null,
                'user_code' => $_SESSION['user_code'] ?? null,
                'categorie_code' => $categorie_code,
                'commentaire' => $commentaire ?? 'Entrée de stock'
            ];

            if ($this->demande->createMouvementStock($data)) {
                $msg = ['msg' => 'Stock ajouté avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout du stock', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Retour de stock
    public function retourStock()
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

            // Génération du code stock
            $code_stock = $this->validator->generateCode('stocks', 'code_stock', 'STK-', 6);

            $data = [
                'code_stock' => $code_stock,
                'type_mouvement' => 'RETOUR',
                'quantite_stock' => $quantite,
                'date_mouvement' => Validator::dateActuelle(),
                'demande_code' => $demande_code ?? null,
                'user_code' => $_SESSION['user_code'] ?? null,
                'categorie_code' => $categorie_code,
                'commentaire' => $commentaire ?? 'Retour de stock'
            ];

            if ($this->demande->createMouvementStock($data)) {
                $msg = ['msg' => 'Retour de stock enregistré!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'enregistrement', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Historique des stocks
    public function stocks()
    {
        $categories = $this->categorie->getAllCategories(1);
        $historique = $this->demande->getHistoriqueStock();
        $validator = $this->validator;
        require_once '../views/demandes/stocks.php';
    }

    // Obtenir le stock par catégorie (pour AJAX)
    public function getStockByCategorie()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            $stock = $this->demande->getStockByCategorie($categorie_code);
            echo json_encode(['stock' => $stock]);
        }
    }
}
