<?php


class RapportController
{
    private $validator;
    private $rapport;
    private $user;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->rapport = new ModelRapport();
        $this->user = new ModelUser();
    }

    // Liste des versements
    public function index()
    {
       $rapports = $this->validator->getAllByElement(TABLES::RAPPORTS, 'user_code', USER_CODE);
        require_once '../views/rapports/list.php';
    }
    public function make_rapport()
    {
        $versements = $this->validator->getAllByElement(TABLES::VERSEMENTS, 'statut_versement', STATUT[0]);
        require_once '../views/rapports/make_rapport.php';
    }

    // Détails d'un versement
    public function details($param)
    {
        $code = $this->validator->decrypter($param);
        $params = explode('separator', $this->validator->decrypter($param));
        $code = $params[0];
        $statut = $params[1];
        $versements = $this->validator->getAllByElement(TABLES::VERSEMENTS, 'rapport_code', $code);
        require_once '../views/rapports/details.php';
    }

    // Mes rapports
    public function mesRapports()
    {
        $rapports = $this->validator->getAllByElement(TABLES::RAPPORTS, 'user_code', USER_CODE);
        require_once '../views/rapports/mes-rapports.php';
    }

    // Créer un versement
    public function create()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_create_rapport'])) {
            extract($_POST);

            // Génération du code rapport
            $code_rapport = $this->validator->generateCode('rapports', 'code_rapport', 'RAP-', 6);

            // Préparation des données
            $data = [
                'code_rapport' => $code_rapport,
                'user_code' => USER_CODE,
                'date_created_rapport' => Validator::dateActuelle()
            ];
            // Démarrer une transaction pour assurer l'intégrité des données
            $this->validator->safeBeginTransaction();

            try {
            if ($this->validator->create(TABLES::RAPPORTS, $data)) {
                // update versement where versement_code = $code_versement
                $dataUpdatePaiement = [
                    'statut_versement' => STATUT[1],
                    'rapport_code' => $code_rapport
                ];
                $updated = $this->validator->update2(TABLES::VERSEMENTS, ['statut_versement' => STATUT[0],'user_code' => USER_CODE], $dataUpdatePaiement);
                if ($updated) {
                    
                    $msg = ['msg' => 'Rapport ajouté avec succès!', 'status' => 1];
                    $this->validator->safeCommit();
                }else{
                    $this->validator->safeRollBack();
                    $msg = ['msg' => 'Erreur lors de la mise à jour du versement', 'status' => 0];
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

    // valider un rapport
    public function valider()
    {
        $msg = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_valider_rapport'])) {
            extract($_POST);

                // update rapport where rapport_code = $code_rapport
                $dataUpdatePaiement = [
                    'statut_rapport' => STATUT[1],
                    'valide_par_user_code' => USER_CODE,
                    'date_valide_rapport' => Validator::dateActuelle()
                ];
                $updated = $this->validator->update(TABLES::RAPPORTS, 'code_rapport', $code, $dataUpdatePaiement);
                if ($updated) {
                    
                    $msg = ['msg' => 'Rapport validé avec succès!', 'status' => 1];
                }else{
                    $msg = ['msg' => 'Erreur lors de la validation du rapport', 'status' => 0];
                }

                echo json_encode($msg);

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
                'montant_rapport' => $montant,
                'date_expires_rapport' => $date_expiration,
                'reseau_rapport' => $reseau ?? 'Wave',
                'statut_rapport' => $statut ?? 'pending',
                'etat_rapport' => $etat ?? 'En cours'
            ];

            if ($this->validator->update2(TABLES::RAPPORTS, ['id' => $id], $data)) {
                $msg = ['msg' => 'Rapport modifié avec succès!', 'status' => 1];
            } else {
                $msg = ['msg' => 'Erreur lors de la modification', 'status' => 0];
            }
            echo json_encode($msg);
        }
    }
}
