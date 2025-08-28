<?php
require_once '../config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'error' => 'Метод не підтримується'], 405);
}

if (!$user->isLoggedIn()) {
    json_response(['success' => false, 'error' => 'Необхідно увійти'], 401);
}

$required = ['exhibit_id', 'content'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        json_response(['success' => false, 'error' => "Не заповнено поле $field"], 400);
    }
}

$exhibit_id = (int)$_POST['exhibit_id'];
$content = trim($_POST['content']);

try {
    $stmt = $db->prepare("INSERT INTO comments (exhibit_id, user_id, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $exhibit_id, $_SESSION['user_id'], $content);
    
    if ($stmt->execute()) {
        json_response(['success' => true]);
    } else {
        json_response(['success' => false, 'error' => 'Помилка бази даних'], 500);
    }
} catch (Exception $e) {
    json_response(['success' => false, 'error' => $e->getMessage()], 500);
}
?>