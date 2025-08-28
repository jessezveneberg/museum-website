<h2>Керування галереєю</h2>

<?php if (isset($message)): ?>
<div class="message success"><?= $message ?></div>
<?php endif; ?>

<?php if (isset($error)): ?>
<div class="message error"><?= $error ?></div>
<?php endif; ?>

<div class="admin-tabs">
    <a href="#gallery-list">Список зображень</a>
    <a href="#add-image">Додати зображення</a>
</div>

<div id="gallery-list" class="tab-content">
    <div class="gallery">
        <?php foreach ($images as $image): ?>
        <div class="gallery-item">
            <img src="<?= htmlspecialchars($image['image_path']) ?>" alt="<?= htmlspecialchars($image['title']) ?>">
            <div class="gallery-actions">
                <form action="admin.php?section=gallery" method="POST" class="delete-form">
                    <input type="hidden" name="id" value="<?= $image['id'] ?>">
                    <input type="submit" name="delete_image" value="Видалити" class="btn btn-danger">
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="add-image" class="tab-content">
    <form action="admin.php?section=gallery" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Назва:</label>
            <input type="text" id="title" name="title" required>
        </div>
        
        <div class="form-group">
            <label for="description">Опис:</label>
            <textarea id="description" name="description" rows="4"></textarea>
        </div>
        
        <div class="form-group">
            <label for="image">Зображення:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            <div class="image-preview"></div>
        </div>
        
        <div class="form-group">
            <input type="submit" name="add_image" value="Додати" class="btn">
        </div>
    </form>
</div>