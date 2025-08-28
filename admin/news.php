<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
     
<div class="admin-tabs">
    <a href="#news-list">Список новин</a>
    <a href="#add-news"><?= isset($_GET['edit']) ? 'Редагувати' : 'Додати' ?> новину</a>
</div>

<div id="news-list" class="tab-content">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Дата</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($news_items as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= htmlspecialchars($item['title']) ?></td>
                <td><?= date('d.m.Y', strtotime($item['created_at'])) ?></td>
                <td class="actions">
                    <a href="admin.php?section=news&edit=<?= $item['id'] ?>" class="btn">Редагувати</a>
                    <form action="admin.php?section=news" method="POST" class="delete-form">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <input type="submit" name="delete_news" value="Видалити" class="btn btn-danger">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<h2>Керування новинами</h2>

<div id="add-news" class="tab-content">
    <?php
    $edit_mode = isset($_GET['edit']);
    $current_news = $edit_mode ? $news->getNewsItem($_GET['edit']) : null;
    ?>
    
    <form action="admin.php?section=news" method="POST" enctype="multipart/form-data">
        <?php if ($edit_mode): ?>
        <input type="hidden" name="id" value="<?= $current_news['id'] ?>">
        <input type="hidden" name="existing_image" value="<?= $current_news['image'] ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="title">Заголовок:</label>
            <input type="text" id="title" name="title" required 
                   value="<?= $edit_mode ? htmlspecialchars($current_news['title']) : '' ?>">
        </div>
        
        <div class="form-group">
            <label for="content">Зміст:</label>
            <textarea id="content" name="content" rows="10" required><?= 
                $edit_mode ? htmlspecialchars($current_news['content']) : '' ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="image">Зображення:</label>
            <input type="file" id="image" name="image" accept="image/*">
            
            <?php if ($edit_mode && $current_news['image']): ?>
            <div class="image-preview">
                <p>Поточне зображення:</p>
                <img src="assets/images/<?= htmlspecialchars($current_news['image']) ?>" alt="Current image" style="max-width: 200px;">
            </div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <input type="submit" name="<?= $edit_mode ? 'edit_news' : 'add_news' ?>" 
                   value="<?= $edit_mode ? 'Оновити новину' : 'Додати новину' ?>" class="btn">
                   
            <?php if ($edit_mode): ?>
            <a href="admin.php?section=news" class="btn">Скасувати</a>
            <?php endif; ?>
        </div>
    </form>
</div>
</body>
</html>

<?php if (isset($message)): ?>
<div class="message success"><?= $message ?></div>
<?php endif; ?>

<?php if (isset($error)): ?>
<div class="message error"><?= $error ?></div>
<?php endif; ?>
 
 