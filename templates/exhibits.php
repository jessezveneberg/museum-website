<h2>Наші експонати</h2>

<?php if ($user->isAdmin()): ?>
<a href="admin.php?section=exhibits" class="btn">Додати експонат (Адмін)</a>
<?php endif; ?>

<div class="exhibit-search">
    <form action="index.php?page=exhibits" method="GET">
        <input type="hidden" name="page" value="exhibits">
        <input type="text" name="query" placeholder="Пошук експонатів...">
        <button type="submit">Шукати</button>
    </form>
</div>

<div class="exhibit-categories">
    <a href="index.php?page=exhibits" <?= !isset($_GET['category']) ? 'class="active"' : '' ?>>Всі</a>
    <?php foreach ($categories as $cat): ?>
    <a href="index.php?page=exhibits&category=<?= urlencode($cat['category']) ?>" 
       <?= (isset($_GET['category']) && $_GET['category'] === $cat['category']) ? 'class="active"' : '' ?>>
        <?= htmlspecialchars($cat['category']) ?>
    </a>
    <?php endforeach; ?>
</div>

<div class="grid exhibit-results">
    <?php foreach ($exhibits as $item): ?>
    <div class="card">
        <?php if ($item['image']): ?>
        <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
        <?php endif; ?>
        <div class="card-content">
            <h3 class="card-title"><?= htmlspecialchars($item['title']) ?></h3>
            <p class="exhibit-category"><?= htmlspecialchars($item['category']) ?></p>
            <p><?= htmlspecialchars($item['description']) ?></p>
            <a href="index.php?page=exhibit&id=<?= $item['id'] ?>" class="btn">Детальніше</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>