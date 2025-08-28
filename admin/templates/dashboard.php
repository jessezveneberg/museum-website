<!DOCTYPE html>
<html lang="en">
<head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width= , initial-scale=1.0">
    <title>Панель адміністратора</title>
</head>
<body>
    <div class="admin-header">
    <h2>Панель адміністратора</h2>
    <p>Ласкаво просимо, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
</div>

<div class="admin-stats">
    <div class="stat-card">
        <h3>Новини</h3>
        <p><?= count($news->getNews(100)) ?></p>
        <a href="admin.php?section=news" class="btn">Керування</a>
    </div>
    
    <div class="stat-card">
        <h3>Експонати</h3>
        <p><?= count($exhibit->getExhibits()) ?></p>
        <a href="admin.php?section=exhibits" class="btn">Керування</a>
    </div>
    
    <div class="stat-card">
        <h3>Галерея</h3>
        <p><?= count($gallery->getImages(100)) ?></p>
        <a href="admin.php?section=gallery" class="btn">Керування</a>
    </div>
    
    <div class="stat-card">
        <h3>Сторінки</h3>
        <p><?= count($page->getPages()) ?></p>
        <a href="admin.php?section=pages" class="btn">Керування</a>
    </div>
</div>

 
</body>
</html>
