<?php
require_once __DIR__ . '/../config.php';
$user = new User($db);

// Обробка виходу
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $user->logout();
    header("Location: index.php");
    exit;
}

// Обробка логіну
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if ($user->login($username, $password)) {
        header("Location: " . ($user->isAdmin() ? 'admin.php' : 'index.php'));
        exit;
    } else {
        $login_error = "Невірний логін або пароль";
    }
}

// Обробка реєстрації
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $password_confirm = trim($_POST['password_confirm']);
    $role = isset($_POST['role']) ? trim($_POST['role']) : 'user';
    
    // Якщо не адмін намагається вибрати роль
    if (!$user->isAdmin() && $role !== 'user') {
        $register_error = "Ви можете зареєструватися тільки як користувач";
    } elseif ($password !== $password_confirm) {
        $register_error = "Паролі не співпадають";
    } else {
        $result = $user->register($username, $email, $password, $role);
        
        if ($result['success']) {
            $_SESSION['flash_message'] = 'Реєстрація успішна! Тепер ви можете увійти.';
            $_SESSION['flash_type'] = 'success';
            header("Location: index.php?page=login");
            exit;
        } else {
            $register_error = $result['error'];
        }
    }
}
?>