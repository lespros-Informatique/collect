<?php

class ModelChoix
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    // Obtenir tous les choix/kits
    public function getAllChoix($status = null)
    {
        try {
            $sql = 'SELECT * FROM choix';
            $params = [];

            if ($status !== null) {
                $sql .= ' WHERE etat_choix = ?';
                $params[] = $status;
            }

            $sql .= ' ORDER BY libelle_choix ASC';

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

    // Obtenir un choix par ID
    public function getChoixById($id)
    {
        try {
            $sql = 'SELECT * FROM choix WHERE id_choix = ?';
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

    // Obtenir un choix par code
    public function getChoixByCode($code)
    {
        try {
            $sql = 'SELECT * FROM choix WHERE code_choix = ?';
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

    // Obtenir les choix par catégorie
    public function getChoixByCategory($categorieCode)
    {
        try {
            $sql = 'SELECT * FROM choix WHERE categorie_code = ? AND etat_choix = 1 ORDER BY libelle_choix ASC';
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

    // Ajouter un choix
    public function addChoix($data)
    {
        return $this->validator->create('choix', $data);
    }

    // Modifier un choix
    public function updateChoix($id, $data)
    {
        return $this->validator->update('choix', 'id_choix', $id, $data);
    }

    // Supprimer un choix (soft delete)
    public function deleteChoix($id, $reason)
    {
        try {
            $sql = 'UPDATE choix SET deleted_by = ?, deleted_why = ?, deleted_at = NOW(), etat_choix = 0 WHERE id_choix = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$_SESSION['user']['id_user'] ?? null, $reason, $id]);
            return true;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
