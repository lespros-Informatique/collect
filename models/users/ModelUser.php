<?php

class ModelUser
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    // Obtenir un utilisateur par ID
    public function getUserById($id)
    {
        try {
            $sql = 'SELECT * FROM users WHERE id_user = ?';
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

    // Obtenir un utilisateur par code
public function getUserByCode($code)
{
    try {
        $sql = 'SELECT * FROM users WHERE code_user = :code';
        $query = $this->pdo->getCon()->prepare($sql);
        $query->execute(["code" => $code]);

        $user = $query->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;

    } catch (\Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}

    // Obtenir un utilisateur par téléphone
    public function getUserByTelephone($telephone)
    {
        try {
            $sql = 'SELECT * FROM users WHERE telephone_user = ?';
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

    // Obtenir un utilisateur par email
    public function getUserByEmail($email)
    {
        try {
            $sql = 'SELECT * FROM users WHERE email_user = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$email]);
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir tous les utilisateurs
    public function getUsers($status = null)
    {
        try {
            $sql = 'SELECT u.*, r.libelle_role as role_name FROM users u LEFT JOIN roles r ON u.role_code = r.code_role';
            $params = [];

            if ($status !== null) {
                $sql .= ' WHERE u.etat_user = ?';
                $params[] = $status;
            }

            $sql .= ' ORDER BY u.nom_user ASC';

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

    // Obtenir les utilisateurs par rôle
    public function getUsersByRole($roleCode)
    {
        try {
            $sql = 'SELECT u.*, r.libelle_role as role_name FROM users u LEFT JOIN roles r ON u.role_code = r.code_role WHERE u.role_code = ? ORDER BY u.nom_user ASC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$roleCode]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Ajouter un utilisateur
    public function addUser($data)
    {
        return $this->validator->create('users', $data);
    }

    // Modifier un utilisateur
    public function updateUser($id, $data)
    {
        return $this->validator->update('users', 'id_user', $id, $data);
    }

    // Modifier le mot de passe
    public function updatePassword($data)
    {
        try {
            $sql = 'UPDATE users SET password_user = ? WHERE id_user = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            if ($query->execute($data)) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Basculer le statut (actif/inactif)
    public function toggleStatus($id)
    {
        try {
            $sql = 'UPDATE users SET etat_user = CASE WHEN etat_user = 0 THEN 1 ELSE 0 END WHERE id_user = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            if ($query->execute([$id])) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Supprimer (soft delete)
    public function deleteUser($id, $reason)
    {
        try {
            $sql = 'UPDATE users SET deleted_by = ?, deleted_why = ?, deleted_at = NOW() WHERE id_user = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$_SESSION['user']['id_user'] ?? null, $reason, $id]);
            return true;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
