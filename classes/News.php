<?php
class News {
    private $db;
    
    public function __construct(Database $db) {
        $this->db = $db;
    }
    
    public function getNews($limit = 5) {
        $stmt = $this->db->prepare("SELECT id, title, content, image, created_at FROM news ORDER BY created_at DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getNewsItem($id) {
        $stmt = $this->db->prepare("SELECT id, title, content, image, created_at FROM news WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function addNews($title, $content, $image = null) {
        $stmt = $this->db->prepare("INSERT INTO news (title, content, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $image);
        return $stmt->execute();
    }
    
    public function updateNews($id, $title, $content, $image = null) {
        $stmt = $this->db->prepare("UPDATE news SET title = ?, content = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $content, $image, $id);
        return $stmt->execute();
    }
    
    public function deleteNews($id) {
        $stmt = $this->db->prepare("DELETE FROM news WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>