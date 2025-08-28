<?php
require_once __DIR__ . '/../config.php';
$user = new User($db);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_TITLE; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1><?php echo SITE_TITLE; ?></h1>
            <nav>
                <ul>
                    <li><a href="index.php">Головна</a></li>
                    <li><a href="index.php?page=exhibits">Експонати</a></li>
                    <li><a href="index.php?page=gallery">Галерея</a></li>
                    <li><a href="index.php?page=news">Новини</a></li>
                    <li><a href="index.php?page=about">Про музей</a></li>
                    <?php if ($user->isLoggedIn()): ?>
                        <li><a href="admin.php">Адмінпанель</a></li>
                        <li><a href="index.php?action=logout">Вийти</a></li>
                    <?php else: ?>
                        <li><a href="index.php?page=login">Увійти</a></li>
                            <li><a href="index.php?page=register">Реєстрація</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">