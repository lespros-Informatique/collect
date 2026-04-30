<?php

require_once '../models/Validator.php';
require_once '../models/paiements/ModelPaiement.php';
require_once '../models/users/ModelUser.php';
require_once '../models/inscriptions/ModelInscription.php';
require_once __DIR__ . '/../../config/config.php';

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
        $users = $this->user->getUsers(1);
        require_once '../views/paiements/list.php';
    }

    // Récupérer les inscriptions par utilisateur
    public function getInscriptionsByUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            $userCode = $_POST['user_code'] ?? null;
            
            if ($userCode) {
                $inscriptions = $this->inscription->getInscriptionsByUser($userCode);
                echo json_encode($inscriptions);
            } else {
                echo json_encode([]);
            }
        }
    }

    // Récupérer les détails d'une inscription (kits, montant total, etc.)
    public function getInscriptionDetails()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            extract($_POST);
            $inscriptionCode = $_POST['inscription_code'] ?? null;
            
            if ($inscriptionCode) {
                $inscription = $this->inscription->getInscriptionByCode($inscriptionCode);
                $choix = $this->inscription->getChoixByInscription($inscriptionCode);
                
                // Calculer le montant total des kits
                $montantTotal = 0;
                foreach ($choix as $kit) {
                    $montantTotal += $kit['cotisation_choix'] ?? 0;
                }
                
                // Utiliser les méthodes réutilisables du modèle
                // Déjà payé = somme des paiements validés (statut=VALIDE ET etat=ACTIF)
                $montantPaye = $this->inscription->getMontantPayeValide($inscriptionCode);
                
                // Obtenir le nombre de jours de la catégorie
                $nombreJour = $this->inscription->getNombreJourByInscription($inscriptionCode);
                
                // Calculer le montant total pour la période complète (total kits × nombre_jour)
                $montantTotalPeriode = $montantTotal * $nombreJour;
                
                // Reste à payer = total période - déjà payé
                $resteAPayer = $montantTotalPeriode - $montantPaye;
                
                $result = [
                    'inscription' => $inscription,
                    'kits' => $choix,
                    'montant_total' => $montantTotal,
                    'montant_total_periode' => $montantTotalPeriode,
                    'montant_paye' => $montantPaye,
                    'reste_a_payer' => $resteAPayer,
                    'nombre_jour' => $nombreJour
                ];
                
                echo json_encode($result);
            } else {
                echo json_encode(null);
            }
        }
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
            // Validation des champs obligatoires
            if (empty($_POST['inscription']) || empty($_POST['montant']) || empty($_POST['nombre_jour'])) {
                $msg = ['msg' => 'Veuillez remplir tous les champs obligatoires!', 'status' => 0];
                echo json_encode($msg);
                return;
            }

            extract($_POST);

            // ========== VALIDATIONS DE SÉCURITÉ ==========
            
            // 1. Vérifier que l'inscription existe
            $inscription = $this->inscription->getInscriptionByCode($inscription);
            if (!$inscription) {
                $msg = ['msg' => 'Inscription introuvable!', 'status' => 0];
                echo json_encode($msg);
                return;
            }
            
            // 2. Vérifier que l'inscription est active
            if ($inscription['etat_inscription'] != STATUS_ACTIVE) {
                $msg = ['msg' => 'Cette inscription n\'est plus active!', 'status' => 0];
                echo json_encode($msg);
                return;
            }
            
            // 3. Vérifier que le montant est positif
            $montant = floatval($montant);
            if ($montant <= 0) {
                $msg = ['msg' => 'Le montant doit être supérieur à 0!', 'status' => 0];
                echo json_encode($msg);
                return;
            }
            
            // 4. Vérifier que le nombre de jours est positif
            $nombre_jour = intval($nombre_jour);
            if ($nombre_jour <= 0) {
                $msg = ['msg' => 'Le nombre de jours doit être supérieur à 0!', 'status' => 0];
                echo json_encode($msg);
                return;
            }
            
            // 5. Obtenir les détails financiers de l'inscription
            $choix = $this->inscription->getChoixByInscription($inscription['code_inscription']);
            
            // Calculer le total des kits
            $montantTotalKits = 0;
            foreach ($choix as $kit) {
                $montantTotalKits += floatval($kit['cotisation_choix'] ?? 0);
            }
            
            if ($montantTotalKits <= 0) {
                $msg = ['msg' => 'Aucun kit trouvé pour cette inscription!', 'status' => 0];
                echo json_encode($msg);
                return;
            }
            
            // Obtenir le nombre de jours de la catégorie
            $nombreJourPeriode = $this->inscription->getNombreJourByInscription($inscription['code_inscription']);
            
            if ($nombreJourPeriode <= 0) {
                $msg = ['msg' => 'Période de la catégorie non définie!', 'status' => 0];
                echo json_encode($msg);
                return;
            }
            
            // 6. Vérifier que le nombre de jours ne dépasse pas la période
            if ($nombre_jour > $nombreJourPeriode) {
                $msg = ['msg' => 'Le nombre de jours ne peut pas dépasser la période de la catégorie (' . $nombreJourPeriode . ' jours)!', 'status' => 0];
                echo json_encode($msg);
                return;
            }
            
            // 7. Calculer le montant total pour la période
            $montantTotalPeriode = $montantTotalKits * $nombreJourPeriode;
            
            // 8. Obtenir le montant déjà payé (paiements validés uniquement)
            $montantPaye = $this->inscription->getMontantPayeValide($inscription['code_inscription']);
            
            // 9. Calculer le reste à payer
            $resteAPayer = $montantTotalPeriode - $montantPaye;
            
            // 10. Vérifier que le paiement ne dépasse pas le reste à payer
            if ($montant > $resteAPayer) {
                $msg = ['msg' => 'Le montant de ' . number_format($montant, 0, ',', ' ') . ' F dépasse le reste à payer (' . number_format($resteAPayer, 0, ',', ' ') . ' F)!', 'status' => 0];
                echo json_encode($msg);
                return;
            }
            
            // 11. Vérifier que le montant correspond au nombre de jours saisis
            $montantCalcule = $montantTotalKits * $nombre_jour;
            if ($montant != $montantCalcule) {
                $msg = ['msg' => 'Le montant doit être de ' . number_format($montantCalcule, 0, ',', ' ') . ' F pour ' . $nombre_jour . ' jour(s)!', 'status' => 0];
                echo json_encode($msg);
                return;
            }
            
            // ========== FIN DES VALIDATIONS ==========

            // Génération du code paiement
            $code_paiement = $this->validator->generateCode('paiements', 'code_paiement', 'PAY-', 6);

            // Préparation des données
            $data = [
                'code_paiement' => $code_paiement,
                'versement_code' => $versement_code ?? null,
                'user_code' => $user_code ?? $_SESSION['user']['code_user'] ?? null,
                'inscription_code' => $inscription['code_inscription'],
                'montant_paiement' => $montant,
                'telephone_paiement' => $telephone ?? null,
                'reseau_paiement' => $reseau ?? 'ESPECES',
                'nombre_jour_paye' => $nombre_jour,
                'created_at_paiement' => Validator::dateActuelle(),
                'type_paiement' => $type ?? 'manuel',
                'statut_paiement' => PAIEMENT_STATUT_EN_ATTENTE,
                'etat_paiement' => PAIEMENT_ETAT_ACTIF
            ];

            if ($this->paiement->addPaiement($data)) {
                // ========== VÉRIFICATION SI INSCRIPTION SOLDEE ==========
                // Recalculer le montant déjà payé après ce nouveau paiement
                $montantPayeApres = $this->inscription->getMontantPayeValide($inscription['code_inscription']);
                $resteApres = $montantTotalPeriode - $montantPayeApres;
                
                // Si le reste à payer est à 0 ou moins, marquer l'inscription comme soldée
                if ($resteApres <= 0) {
                    $this->inscription->updateInscription($inscription['id_inscription'], [
                        'etat_inscription' => INSCRIPTION_ETAT_SOLDE
                    ]);
                }
                // ========== FIN VÉRIFICATION ==========
                
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
