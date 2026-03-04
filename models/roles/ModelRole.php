<?php

class ModelRole
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    // Obtenir tous les rôles
    public function getAllRoles($status = null)
    {
        try {
            $sql = 'SELECT * FROM roles';
            $params = [];

            if ($status !== null) {
                $sql .= ' WHERE etat_role = ?';
                $params[] = $status;
            }

            $sql .= ' ORDER BY libelle_role ASC';

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

    // Obtenir un rôle par ID
    public function getRoleById($id)
    {
        try {
            $sql = 'SELECT * FROM roles WHERE id_role = ?';
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

    // Obtenir un rôle par code
    public function getRoleByCode($code)
    {
        try {
            $sql = 'SELECT * FROM roles WHERE code_role = ?';
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

    // Ajouter un rôle
    public function addRole($data)
    {
        return $this->validator->create('roles', $data);
    }

    // Modifier un rôle
    public function updateRole($id, $data)
    {
        return $this->validator->update('roles', 'id_role', $id, $data);
    }

    // Supprimer un rôle
    public function deleteRole($id)
    {
        try {
            $sql = 'DELETE FROM roles WHERE id_role = ?';
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
