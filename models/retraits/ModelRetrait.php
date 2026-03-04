<?php

class ModelRetrait
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    // Obtenir tous les retraits
    public function getAllRetraits($status = null)
    {
        try {
            $sql = 'SELECT * FROM retraits';
            $params = [];

            if ($status !== null) {
                $sql .= ' WHERE etat_retrait = ?';
                $params[] = $status;
            }

            $sql .= ' ORDER BY date_retrait DESC';

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

    // Obtenir un retrait par ID
    public function getRetraitById($id)
    {
        try {
            $sql = 'SELECT * FROM retraits WHERE id_retrait = ?';
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

    // Obtenir un retrait par code
    public function getRetraitByCode($code)
    {
        try {
            $sql = 'SELECT * FROM retraits WHERE code_retrait = ?';
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

    // Obtenir les retraits par inscription
    public function getRetraitsByInscription($inscriptionCode)
    {
        try {
            $sql = 'SELECT * FROM retraits WHERE inscription_code = ? ORDER BY date_retrait DESC';
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

    // Obtenir les retraits par utilisateur
    public function getRetraitsByUser($userCode)
    {
        try {
            $sql = 'SELECT * FROM retraits WHERE user_code = ? ORDER BY date_retrait DESC';
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

    // Ajouter un retrait
    public function addRetrait($data)
    {
        return $this->validator->create('retraits', $data);
    }

    // Modifier un retrait
    public function updateRetrait($id, $data)
    {
        return $this->validator->update('retraits', 'id_retrait', $id, $data);
    }

    // Compter les retraits
    public function countRetraits()
    {
        try {
            $sql = 'SELECT COUNT(*) as total FROM retraits WHERE etat_retrait = 1';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
