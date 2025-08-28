<?php
function buffer_start($level = 1) {
    if (ob_get_level() < $level) {
        ob_start();
    }
}

function buffer_end($level = 1) {
    while (ob_get_level() >= $level) {
        ob_end_flush();
    }
}

function json_response($data, $status_code = 200) {
    http_response_code($status_code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function upload_file($file, $target_dir = "assets/images/") {
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Перевірка чи файл є зображенням
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return ['success' => false, 'error' => 'Файл не є зображенням'];
    }
    
    // Перевірка розміру файлу (не більше 5MB)
    if ($file["size"] > 5000000) {
        return ['success' => false, 'error' => 'Файл занадто великий'];
    }
    
    // Дозволені формати
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        return ['success' => false, 'error' => 'Дозволені лише JPG, JPEG, PNG та GIF файли'];
    }
    
    // Генерація унікального імені файлу
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_path = $target_dir . $new_filename;
    
    if (move_uploaded_file($file["tmp_name"], $target_path)) {
        return ['success' => true, 'filename' => $new_filename];
    } else {
        return ['success' => false, 'error' => 'Помилка завантаження файлу'];
    }
}

// Генерація посилань з підтримкою SEO
function generate_seo_link($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    
    return $text ?: 'page';
}

// Валідація email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Генерація токену CSRF
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Перевірка CSRF токену
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Редирект з повідомленням
function redirect_with_message($url, $message, $type = 'success') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
    header("Location: $url");
    exit;
}

// Вивід flash-повідомлення
function display_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'success';
        echo "<div class='message $type'>$message</div>";
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
    }
}

// Пагінація
function paginate($total_items, $per_page = 10, $current_page = 1, $url = '') {
    $total_pages = ceil($total_items / $per_page);
    $pagination = [
        'total_items' => $total_items,
        'per_page' => $per_page,
        'current_page' => $current_page,
        'total_pages' => $total_pages,
        'offset' => ($current_page - 1) * $per_page
    ];
    
    if ($total_pages > 1) {
        $pagination['links'] = '';
        $query = parse_url($url, PHP_URL_QUERY);
        $url .= (strpos($url, '?') === false ? '?' : '&');
        
        if ($current_page > 1) {
            $prev = $current_page - 1;
            $pagination['links'] .= "<a href='{$url}page=$prev' class='btn'>&laquo; Попередня</a> ";
        }
        
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $current_page) {
                $pagination['links'] .= "<span class='btn active'>$i</span> ";
            } else {
                $pagination['links'] .= "<a href='{$url}page=$i' class='btn'>$i</a> ";
            }
        }
        
        if ($current_page < $total_pages) {
            $next = $current_page + 1;
            $pagination['links'] .= "<a href='{$url}page=$next' class='btn'>Наступна &raquo;</a>";
        }
    }
    
    return $pagination;
}

?>