<?php

class Article {
    private $article_id;
    private $article_title;
    private $article_content;
    private $status;
    private $image;
    private $user_id;
    private $theme_id;
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    } 

    public function filterByTheme($theme_id) {
        $query = "SELECT a.* FROM articles a
                  JOIN themes t ON a.theme_id = t.theme_id
                  WHERE t.theme_id= ?";
        $stmt = $this->db_prepare($query);
        $stmt->execute([$theme_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function publishArticle($article_title, $article_content, $image, $user_id, $theme_id) {
        $query = "INSERT INTO articles (article_title, article_content, image, user_id, theme_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$article_title, $article_content, $image, $user_id, $theme_id]);
    }

    public function viewArticles() {
        $query = "SELECT * FROM articles";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}