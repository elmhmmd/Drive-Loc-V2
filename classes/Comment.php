<?php

    class Comment {
        private $comment_id;
        private $db;
        private $comment_content;
        private $article_id;
        private $user_id;

        public function __construct() {
            $this->db = Database::getInstance()->getConnection(); 
        }

        public function ViewArticleComments ($article_id) {
        $query = "SELECT * FROM comments WHERE article_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$article_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function ViewComments() {
            $query = "SELECT * FROM comments";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

}



    
