<?php

class ModelCategorie
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    // Obtenir toutes les catégories
    public function getAllCategories($status = null)
    {
        try {
            $sql = 'SELECT * FROM categories';
            $params = [];

            if ($status !== null) {
                $sql .= ' WHERE etat_categorie = ?';
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

    // Obtenir une catégorie par ID
    public function getCategoryById($id)
    {
        try {
            $sql = 'SELECT * FROM categories WHERE id_categorie = ?';
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

    // Obtenir une catégorie par code
    public function getCategoryByCode($code)
    {
        try {
            $sql = 'SELECT * FROM categories WHERE code_categorie = ?';
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

    // Obtenir la catégorie active (en cours)
    public function getActiveCategory()
    {
        try {
            $sql = 'SELECT * FROM categories WHERE etat_categorie = 1 AND NOW() BETWEEN date_debut AND date_fin LIMIT 1';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Ajouter une catégorie
    public function addCategory($data)
    {
        return $this->validator->create('categories', $data);
    }

    // Modifier une catégorie
    public function updateCategory($id, $data)
    {
        return $this->validator->update('categories', 'id_categorie', $id, $data);
    }

    // Supprimer une catégorie
    public function deleteCategory($id)
    {
        try {
            $sql = 'UPDATE categories SET etat_categorie = 0 WHERE id_categorie = ?';
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
