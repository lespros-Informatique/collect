<?php

class ModelRapport
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    // Obtenir tous les rapports
    public function getAllRapports($status = null)
    {
        try {
            $sql = 'SELECT * FROM rapports';
            $params = [];

            if ($status !== null) {
                $sql .= ' WHERE etat_versement = ?';
                $params[] = $status;
            }

            $sql .= ' ORDER BY date_created_versement DESC';

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

    // Obtenir un rapport par ID
    public function getRapportById($id)
    {
        try {
            $sql = 'SELECT * FROM rapports WHERE id_rapport = ?';
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

    // Obtenir un rapport par code
    public function getRapportByCode($code)
    {
        try {
            $sql = 'SELECT * FROM rapports WHERE code_rapport = ?';
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

    // Obtenir les rapports par utilisateur (commercial)
    public function getRapportsByUser($userCode)
    {
        try {
            $sql = 'SELECT * FROM rapports WHERE user_code = ? ORDER BY date_created_rapport DESC';
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

    // Obtenir les versements par rapport
    public function getVersementsByRapport($rapportCode)
    {
        try {
            $sql = 'SELECT * FROM versements WHERE rapport_code = ? ORDER BY date_created_versement DESC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$rapportCode]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Ajouter un versement
    public function addVersement($data)
    {
        return $this->validator->create(TABLES::VERSEMENTS, $data);
    }

    // Modifier un versement
    public function updateVersement($id, $data)
    {
        return $this->validator->update('versements', 'id_versement', $id, $data);
    }

    // Somme des versements par utilisateur
    public function getTotalVersementsByUser($userCode)
    {
        try {
            $sql = 'SELECT COALESCE(SUM(montant_versement), 0) as total FROM versements WHERE user_code = ? AND etat_versement = "Validé"';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$userCode]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Somme des versements par rapport
    public function getTotalVersementsByRapport($rapportCode)
    {
        try {
            $sql = 'SELECT COALESCE(SUM(montant_versement), 0) as total FROM versements WHERE rapport_code = ? AND etat_versement = "Validé"';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$rapportCode]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
