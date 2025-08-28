<?php
class Gallery {
    private $db;
    
    public function __construct(Database $db) {
        $this->db = $db;
    }
    
    public function getImages($limit = 12) {
        $stmt = $this->db->prepare("SELECT id, title, image_path, description, created_at FROM gallery ORDER BY created_at DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function addImage($title, $image_path, $description) {
        $stmt = $this->db->prepare("INSERT INTO gallery (title, image_path, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $image_path, $description);
        return $stmt->execute();
    }
    
    public function deleteImage($id) {
        $stmt = $this->db->prepare("DELETE FROM gallery WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>