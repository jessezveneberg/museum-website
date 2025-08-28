<?php
class Page {
    private $db;
    
    public function __construct(Database $db) {
        $this->db = $db;
    }
    
    public function getPages() {
        $result = $this->db->query("SELECT id, title, slug, content FROM pages ORDER BY title");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getPage($slug) {
        $stmt = $this->db->prepare("SELECT id, title, slug, content FROM pages WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function addPage($title, $slug, $content) {
        $stmt = $this->db->prepare("INSERT INTO pages (title, slug, content) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $slug, $content);
        return $stmt->execute();
    }
    
    public function updatePage($id, $title, $slug, $content) {
        $stmt = $this->db->prepare("UPDATE pages SET title = ?, slug = ?, content = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $slug, $content, $id);
        return $stmt->execute();
    }
    
    public function deletePage($id) {
        $stmt = $this->db->prepare("DELETE FROM pages WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>