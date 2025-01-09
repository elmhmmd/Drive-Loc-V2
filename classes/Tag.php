<?php

class Tag {
    private $tag_id;
    private $tag_name;
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function viewTags() {
        $query = "SELECT * from tags";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}