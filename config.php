<?php
// Конфігурація сайту
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'museum_db');
define('SITE_TITLE', 'Музей української культури');

// Початкова сесія
session_start();

// Автозавантаження класів
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.php';
});

// Підключення до бази даних
try {
    $db = new Database();
} catch (Exception $e) {
    die("Помилка підключення до бази даних: " . $e->getMessage());
}
?>