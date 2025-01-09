<?php 

    class Theme {
        private $theme_id;
        private $db;

public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

public function viewThemes() {
	$query = "SELECT * FROM themes";
	$stmt = $this->db->prepare($query);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

public function addThemes($theme_name) {
    $query = "INSERT INTO themes (theme_name) VALUES (?)";
    $stmt = $this->db->prepare($query);
    return $stmt->execute([$theme_name]);
}

public function deleteThemes($id) {
    $query = "DELETE FROM themes WHERE themes_id = ?";
    $stmt = $this->db->prepare($query);
    return $stmt->execute([$id]);    
}

public function modifyThemes($id, $theme_name ) {
    $query = "UPDATE themes SET theme_name=? WHERE theme_id = ?";
    $stmt = $this->db->prepare($query);
    return $stmt->execute([$theme_name,$id]);
} 

}

