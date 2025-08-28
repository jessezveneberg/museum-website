<h2>Фотогалерея</h2>

<?php if ($user->isAdmin()): ?>
<a href="admin.php?section=gallery" class="btn">Додати фото (Адмін)</a>
<?php endif; ?>

<div class="gallery">
    <?php foreach ($images as $image): ?>
    <div class="gallery-item">
        <img src="<?= htmlspecialchars($image['image_path']) ?>" alt="<?= htmlspecialchars($image['title']) ?>">
        <div class="gallery-caption">
            <h3><?= htmlspecialchars($image['title']) ?></h3>
            <?php if ($image['description']): ?>
            <p><?= htmlspecialchars($image['description']) ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>