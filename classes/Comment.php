<?php
class Comment {
    private $db;
    
    public function __construct(Database $db) {
        $this->db = $db;
    }
    
    public function addComment($exhibit_id, $user_id, $content) {
        $stmt = $this->db->prepare("INSERT INTO comments (exhibit_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $exhibit_id, $user_id, $content);
        return $stmt->execute();
    }
    
    public function getCommentsByExhibit($exhibit_id, $limit = 100) {
        $stmt = $this->db->prepare("
            SELECT c.*, u.username 
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.exhibit_id = ?
            ORDER BY c.created_at DESC
            LIMIT ?
        ");
        $stmt->bind_param("ii", $exhibit_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function deleteComment($comment_id) {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->bind_param("i", $comment_id);
        return $stmt->execute();
    }
    
    public function getCommentById($comment_id) {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->bind_param("i", $comment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }public function getAllComments($limit = 100) {
    $result = $this->db->query("
        SELECT c.*, u.username, e.title AS exhibit_title 
        FROM comments c
        JOIN users u ON c.user_id = u.id
        JOIN exhibits e ON c.exhibit_id = e.id
        ORDER BY c.created_at DESC
        LIMIT $limit
    ");
    return $result->fetch_all(MYSQLI_ASSOC);
}
}
?>