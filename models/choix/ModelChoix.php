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

    // Obtenir les articles d'un choix/kit via ligne_articles
    public function getArticlesByChoix($choixCode)
    {
        try {
            $sql = 'SELECT la.*, a.libelle_article, a.image_article, a.code_article 
                    FROM ligne_articles la 
                    INNER JOIN articles a ON la.article_code = a.code_article 
                    WHERE la.choix_code = ? AND la.etat_ligne_article = 1';
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

    // Obtenir les choix/kits d'une inscription via ligne_choix
    public function getChoixByInscription($inscriptionCode)
    {
        try {
            $sql = 'SELECT c.*, lc.code_ligne_choix, lc.created_at_ligne_choix
                    FROM ligne_choix lc
                    INNER JOIN choix c ON lc.choix_code = c.code_choix
                    WHERE lc.inscription_code = ? AND lc.etat_ligne_choix = 1
                    ORDER BY lc.created_at_ligne_choix ASC';
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

    // Vérifier si un article existe déjà pour un kit
    public function articleExistsInKit($kitCode, $articleCode)
    {
        try {
            $sql = 'SELECT id_ligne_article FROM ligne_articles WHERE choix_code = ? AND article_code = ? AND etat_ligne_article = 1';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$kitCode, $articleCode]);
            return $query->rowCount() > 0;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Ajouter un article à un kit (via ligne_articles)
    public function addArticleToKit($kitCode, $articleCode, $quantite = 1)
    {
        try {
            // Vérifier si l'article existe déjà pour ce kit
            if ($this->articleExistsInKit($kitCode, $articleCode)) {
                return true;
            }
            
            $code_ligne = $this->validator->generateCode('ligne_articles', 'code_ligne_article', 'LIG-ART-', 6);
            $data = [
                'code_ligne_article' => $code_ligne,
                'quantite_ligne_article' => $quantite,
                'article_code' => $articleCode,
                'choix_code' => $kitCode,
                'date_created' => date('Y-m-d H:i:s'),
                'etat_ligne_article' => 1
            ];
            return $this->validator->create('ligne_articles', $data);
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Supprimer tous les articles d'un kit (via ligne_articles)
    public function removeAllArticlesFromKit($kitCode)
    {
        try {
            $sql = 'UPDATE ligne_articles SET etat_ligne_article = 0, deleted_why = "Suppression lors de la mise à jour", deleted_at = NOW() WHERE choix_code = ?';
            $query = $this->pdo->getCon()->prepare($sql);
            $query->execute([$kitCode]);
            return true;
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
