<?php

class ModelInscription
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    // Obtenir toutes les inscriptions
    public function getAllInscriptions($status = null)
    {
        try {
            $sql = 'SELECT * FROM inscriptions';
            $params = [];

            if ($status !== null) {
                $sql .= ' WHERE etat_inscription = ?';
                $params[] = $status;
            }

            $sql .= ' ORDER BY date_debut DESC';

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

    // Obtenir une inscription par ID
    public function getInscriptionById($id)
    {
        try {
            $sql = 'SELECT * FROM inscriptions WHERE id_inscription = ?';
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

    // Obtenir une inscription par code
    public function getInscriptionByCode($code)
    {
        try {
            $sql = 'SELECT * FROM inscriptions WHERE code_inscription = ?';
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

    // Obtenir les inscriptions par client
    public function getInscriptionsByClient($clientCode)
    {
        try {
            $sql = 'SELECT * FROM inscriptions WHERE client_code = ? ORDER BY date_debut DESC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$clientCode]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les inscriptions par commercial
    public function getInscriptionsByCommercial($userCode)
    {
        try {
            $sql = 'SELECT * FROM inscriptions WHERE user_code = ? ORDER BY date_debut DESC';
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

    // Obtenir les inscriptions par catégorie
    public function getInscriptionsByCategory($categorieCode)
    {
        try {
            $sql = 'SELECT * FROM inscriptions WHERE categorie_code = ? ORDER BY date_debut DESC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$categorieCode]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Ajouter une inscription
    public function addInscription($data)
    {
        return $this->validator->create('inscriptions', $data);
    }

    // Modifier une inscription
    public function updateInscription($id, $data)
    {
        return $this->validator->update('inscriptions', 'id_inscription', $id, $data);
    }

    // Supprimer une inscription (soft delete)
    public function deleteInscription($id, $reason)
    {
        try {
            $sql = 'UPDATE inscriptions SET deleted_by = ?, deleted_why = ?, deleted_at = NOW(), etat_inscription = 0 WHERE id_inscription = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$_SESSION['user']['id_user'] ?? null, $reason, $id]);
            return true;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Compter les inscriptions par commercial
    public function countInscriptionsByCommercial($userCode)
    {
        try {
            $sql = 'SELECT COUNT(*) as total FROM inscriptions WHERE user_code = ? AND etat_inscription = 1';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$userCode]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
