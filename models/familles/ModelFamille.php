<?php

class ModelFamille
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    // Obtenir toutes les familles
    public function getAllFamilles($status = null)
    {
        try {
            $sql = 'SELECT * FROM familles';
            $params = [];

            if ($status !== null) {
                $sql .= ' WHERE etat_famille = ?';
                $params[] = $status;
            }

            $sql .= ' ORDER BY libelle_famille ASC';

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

    // Obtenir une famille par ID
    public function getFamilleById($id)
    {
        try {
            $sql = 'SELECT * FROM familles WHERE id_famille = ?';
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

    // Obtenir une famille par code
    public function getFamilleByCode($code)
    {
        try {
            $sql = 'SELECT * FROM familles WHERE code_famille = ?';
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

    // Ajouter une famille
    public function addFamille($data)
    {
        return $this->validator->create('familles', $data);
    }

    // Modifier une famille
    public function updateFamille($id, $data)
    {
        return $this->validator->update('familles', 'id_famille', $id, $data);
    }

    // Supprimer une famille
    public function deleteFamille($id)
    {
        try {
            $sql = 'UPDATE familles SET etat_famille = 0 WHERE id_famille = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            if ($query->execute([$id])) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
