<?php
require_once '../config.php';
header('Content-Type: application/json');

if (!isset($_GET['exhibit_id']) || !is_numeric($_GET['exhibit_id'])) {
    json_response(['success' => false, 'error' => 'Не вказано ID експонату'], 400);
}

$exhibit_id = (int)$_GET['exhibit_id'];

try {
    $stmt = $db->prepare("SELECT c.id, c.content, c.created_at, u.username 
                          FROM comments c 
                          JOIN users u ON c.user_id = u.id 
                          WHERE c.exhibit_id = ? 
                          ORDER BY c.created_at DESC");
    $stmt->bind_param("i", $exhibit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
    
    json_response(['success' => true, 'data' => $comments]);
} catch (Exception $e) {
    json_response(['success' => false, 'error' => $e->getMessage()], 500);
}
?>