<?php
class Exhibit {
    private $db;
    
    public function __construct(Database $db) {
        $this->db = $db;
    }
    
    public function getExhibits($category = null) {
        if ($category) {
            $stmt = $this->db->prepare("SELECT id, title, description, category, image, created_at FROM exhibits WHERE category = ? ORDER BY title");
            $stmt->bind_param("s", $category);
        } else {
            $stmt = $this->db->prepare("SELECT id, title, description, category, image, created_at FROM exhibits ORDER BY title");
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getExhibit($id) {
        $stmt = $this->db->prepare("SELECT id, title, description, category, image, full_text, created_at FROM exhibits WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function addExhibit($title, $description, $category, $image, $full_text) {
        $stmt = $this->db->prepare("INSERT INTO exhibits (title, description, category, image, full_text) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $description, $category, $image, $full_text);
        return $stmt->execute();
    }
    
    public function updateExhibit($id, $title, $description, $category, $image, $full_text) {
        $stmt = $this->db->prepare("UPDATE exhibits SET title = ?, description = ?, category = ?, image = ?, full_text = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $title, $description, $category, $image, $full_text, $id);
        return $stmt->execute();
    }
    
    public function deleteExhibit($id) {
        $stmt = $this->db->prepare("DELETE FROM exhibits WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    public function getCategories() {
        $result = $this->db->query("SELECT DISTINCT category FROM exhibits");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>