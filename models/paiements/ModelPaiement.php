<?php

class ModelPaiement
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    // Obtenir tous les paiements
    public function getAllPaiements($status = null)
    {
        try {
            $sql = 'SELECT * FROM paiements';
            $params = [];

            if ($status !== null) {
                $sql .= ' WHERE statut_paiement = ?';
                $params[] = $status;
            }

            $sql .= ' ORDER BY created_at_paiement DESC';

            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute($params);

            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir un paiement par ID
    public function getPaiementById($id)
    {
        try {
            $sql = 'SELECT * FROM paiements WHERE id_paiement = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$id]);
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir un paiement par code
    public function getPaiementByCode($code)
    {
        try {
            $sql = 'SELECT * FROM paiements WHERE code_paiement = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$code]);
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les paiements par inscription
    public function getPaiementsByInscription($inscriptionCode)
    {
        try {
            $sql = 'SELECT * FROM paiements WHERE inscription_code = ? ORDER BY created_at_paiement DESC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$inscriptionCode]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les paiements par commercial (user_code)
    public function getPaiementsByCommercialInvalide($userCode)
    {
        try {
            $sql = 'SELECT * FROM paiements WHERE user_code = :user_code AND statut_paiement = :statut';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([':user_code' => $userCode, ':statut' => STATUT[0]]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les paiements par commercial (user_code)
    public function getSumPaiementsByCommercialInvalide($userCode)
    {
        try {
            $sql = 'SELECT SUM(montant_paiement) as total FROM paiements WHERE user_code = :user_code AND statut_paiement = :statut';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([':user_code' => $userCode, ':statut' => STATUT[0]]);
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
            }
            return 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    // Obtenir les paiements par commercial (user_code)
    public function getPaiementsByCommercial($userCode)
    {
        try {
            $sql = 'SELECT * FROM paiements WHERE user_code = ? ORDER BY created_at_paiement DESC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$userCode]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les paiements par date
    public function getPaiementsByDate($date)
    {
        try {
            $sql = 'SELECT * FROM paiements WHERE DATE(created_at_paiement) = ? ORDER BY created_at_paiement DESC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$date]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Ajouter un paiement
    public function addPaiement($data)
    {
        return $this->validator->create(TABLES::PAIEMENTS, $data);
    }

    // Modifier un paiement
    public function updatePaiement($id, $data)
    {
        return $this->validator->update(TABLES::PAIEMENTS, 'id_paiement', $id, $data);
    }

    // Supprimer un paiement (soft delete)
    public function deletePaiement($id, $reason)
    {
        try {
            $sql = 'UPDATE paiements SET deleted_by = ?, deleted_why = ?, deleted_at = NOW(), statut_paiement = :statut WHERE id_paiement = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$_SESSION['user']['id_user'] ?? null, $reason, ':statut' => STATUT[0], $id]);
            return true;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Somme des paiements par inscription
    public function getTotalPaiementsByInscription($inscriptionCode)
    {
        try {
            $sql = 'SELECT COALESCE(SUM(montant_paiement), 0) as total FROM paiements WHERE inscription_code = ? AND statut_paiement = :statut';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$inscriptionCode, ':statut' => STATUT[1]]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Somme des paiements par commercial
    public function getTotalPaiementsByCommercial($userCode)
    {
        try {
            $sql = 'SELECT COALESCE(SUM(montant_paiement), 0) as total FROM paiements WHERE user_code = ? AND statut_paiement = :statut';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$userCode, ':statut' => STATUT[1]]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Compter les paiements par inscription
    public function countPaiementsByInscription($inscriptionCode)
    {
        try {
            $sql = 'SELECT COUNT(*) as total FROM paiements WHERE inscription_code = ? AND statut_paiement = :statut';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$inscriptionCode, ':statut' => STATUT[1]]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
