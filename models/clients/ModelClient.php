<?php

class ModelClient
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    // Obtenir tous les clients
    public function getAllClients($status = null)
    {
        try {
            $sql = 'SELECT * FROM clients';
            $params = [];

            if ($status !== null) {
                $sql .= ' WHERE etat_client = ?';
                $params[] = $status;
            }

            $sql .= ' ORDER BY created_at_client DESC';

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

    // Obtenir un client par ID
    public function getClientById($id)
    {
        try {
            $sql = 'SELECT * FROM clients WHERE id_client = ?';
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

    // Obtenir un client par code
    public function getClientByCode($code)
    {
        try {
            $sql = 'SELECT * FROM clients WHERE code_client = ?';
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

    // Obtenir un client par téléphone
    public function getClientByTelephone($telephone)
    {
        try {
            $sql = 'SELECT * FROM clients WHERE telephone_client = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$telephone]);
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les clients par commercial (user_code)
    public function getClientsByCommercial($userCode)
    {
        try {
            // Trouver les inscriptions de ce commercial
            $sql = 'SELECT c.* FROM clients c
                    INNER JOIN inscriptions i ON c.code_client = i.client_code
                    WHERE i.user_code = ?
                    ORDER BY c.created_at_client DESC';
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

    // Ajouter un client
    public function addClient($data)
    {
        return $this->validator->create('clients', $data);
    }

    // Modifier un client
    public function updateClient($id, $data)
    {
        return $this->validator->update('clients', 'id_client', $id, $data);
    }

    // Supprimer (soft delete)
    public function deleteClient($id, $reason)
    {
        try {
            $sql = 'UPDATE clients SET deleted_by = ?, deleted_why = ?, deleted_at = NOW(), etat_client = 0 WHERE id_client = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$_SESSION['user']['id_user'] ?? null, $reason, $id]);
            return true;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Compter le nombre de clients
    public function countClients($status = null)
    {
        try {
            $sql = 'SELECT COUNT(*) as total FROM clients';
            if ($status !== null) {
                $sql .= ' WHERE etat_client = ?';
                $query = $this->pdo->getCon()->prepare($sql);
                $query->execute([$status]);
            } else {
                $query = $this->pdo->getCon()->prepare($sql);
                $query->execute();
            }
            return $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Compter les clients créés par un utilisateur (via user_code)
    public function countClientsByUserCode($userCode)
    {
        try {
            $sql = 'SELECT COUNT(*) as total FROM clients WHERE user_code = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$userCode]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les clients créés par un utilisateur
    public function getClientsByUserCode($userCode)
    {
        try {
            $sql = 'SELECT * FROM clients WHERE user_code = ? ORDER BY created_at_client DESC';
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
}
