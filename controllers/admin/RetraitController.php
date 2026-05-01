<?php



class RetraitController
{
    private $validator;
    private $retrait;
    private $user;
    private $inscription;
    private $choix;
    private $categorie;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->retrait = new ModelRetrait();
        $this->user = new ModelUser();
        $this->inscription = new ModelInscription();
        $this->choix = new ModelChoix();
        $this->categorie = new ModelCategorie();
    }

    // Liste des retraits
    public function index()
    {
        $retraits = $this->retrait->getAllRetraits(1);
        $inscriptions = $this->inscription->getAllInscriptions(ETAT[0]);
        $users = $this->user->getUsers(ETAT[1]);
        // $clients = $this->client->getAllClients(ETAT[1]);
        $categories = $this->categorie->getAllCategories(ETAT[1]);
        
        $validator = $this->validator;
        require_once '../views/retraits/list.php';
    }

    // Détails d'un retrait
    public function details($param)
    {
        $code = $this->validator->decrypter($param);
        $retrait = $this->retrait->getRetraitByCode($code);
        require_once '../views/retraits/details.php';
    }

    // Créer un retrait
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

            // Récupérer les détails de l'inscription
            $inscriptionData = $this->inscription->getInscriptionByCode($inscription);
            
            // Récupérer les choix de l'inscription
            $ligneChoix = []; // À implémenter selon la structure de la DB
            
            // Génération du code retrait
            $code_retrait = $this->validator->generateCode('retraits', 'code_retrait', 'RET-', 6);

            // Préparation des détails en JSON
            $details = json_encode([
                'inscription' => $inscription,
                'type' => $type ?? 'inscription'
            ]);

            // Préparation des données
            $data = [
                'code_retrait' => $code_retrait,
                'date_retrait' => date('Y-m-d H:i:s'),
                'user_code' => $_SESSION['user']['code_user'] ?? null,
                'inscription_code' => $inscription,
                'details' => $details,
                'type_retrait' => $type ?? 'inscription',
                'etat_retrait' => 1
            ];

            if ($this->retrait->addRetrait($data)) {
                $msg = ['msg' => 'Retrait ajouté avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de l\'ajout', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Modifier un retrait
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

            $details = json_encode([
                'inscription' => $inscription,
                'type' => $type ?? 'inscription'
            ]);

            $data = [
                'inscription_code' => $inscription,
                'details' => $details,
                'type_retrait' => $type ?? 'inscription',
                'etat_retrait' => $etat ?? 1
            ];

            if ($this->retrait->updateRetrait($id, $data)) {
                $msg = ['msg' => 'Retrait modifié avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }

    // Supprimer un retrait
    public function delete()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            if (isset($id) && $this->retrait->getRetraitById($id)) {
                $data = ['etat_retrait' => 0];
                if ($this->retrait->updateRetrait($id, $data)) {
                    $msg = ['msg' => 'Retrait supprimé avec succès!', 'status' => 1];
                } else {
                    $msg = ['msg' => 'Erreur lors de la suppression', 'status' => 0];
                }
            } else {
                $msg = ['msg' => 'Retrait introuvable!', 'status' => 0];
            }
        } else {
            $msg = ['msg' => 'Une erreur est survenue!', 'status' => 0];
        }
        echo json_encode($msg);
    }
}
