<?php

class ModelArticle
{
    private $pdo;
    private $validator;

    public function __construct()
    {
        $this->pdo = new Database();
        $this->validator = new Validator();
    }

    // Obtenir tous les articles
    public function getAllArticles($status = null)
    {
        try {
            // Vérifier si la colonne famille_code existe
            $pdo = new Database();
            $conn = $pdo->getCon();
            
            // Vérifier si la colonne famille_code existe dans la table articles
            $columns = $conn->query('SHOW COLUMNS FROM articles LIKE "famille_code"')->fetchAll();
            
            if (count($columns) > 0) {
                // La colonne existe, utiliser la jointure
                $sql = 'SELECT a.*, f.libelle_famille FROM articles a
                        LEFT JOIN familles f ON a.famille_code = f.code_famille';
                $params = [];

                if ($status !== null) {
                    $sql .= ' WHERE a.etat_article = ?';
                    $params[] = $status;
                }

                $sql .= ' ORDER BY a.libelle_article ASC';
            } else {
                // La colonne n'existe pas, utiliser une requête simple
                $sql = 'SELECT * FROM articles';
                $params = [];

                if ($status !== null) {
                    $sql .= ' WHERE etat_article = ?';
                    $params[] = $status;
                }

                $sql .= ' ORDER BY libelle_article ASC';
            }

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

    // Obtenir un article par ID
    public function getArticleById($id)
    {
        try {
            $sql = 'SELECT * FROM articles WHERE id_article = ?';
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

    // Obtenir un article par code
    public function getArticleByCode($code)
    {
        try {
            $sql = 'SELECT * FROM articles WHERE code_article = ?';
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

    // Obtenir les articles par famille
    public function getArticlesByFamille($familleCode)
    {
        try {
            $sql = 'SELECT * FROM articles WHERE famille_code = ? AND etat_article = 1 ORDER BY libelle_article ASC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$familleCode]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Obtenir les articles par choix (kit)
    public function getArticlesByChoix($choixCode)
    {
        try {
            $sql = 'SELECT a.* FROM articles a
                    INNER JOIN ligne_articles la ON a.code_article = la.article_code
                    WHERE la.choix_code = ? AND la.etat_ligne_article = 1
                    ORDER BY a.libelle_article ASC';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$choixCode]);
            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Ajouter un article
    public function addArticle($data)
    {
        return $this->validator->create('articles', $data);
    }

    // Modifier un article
    public function updateArticle($id, $data)
    {
        return $this->validator->update('articles', 'id_article', $id, $data);
    }

    // Supprimer un article
    public function deleteArticle($id)
    {
        try {
            $sql = 'UPDATE articles SET etat_article = 0 WHERE id_article = ?';
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
