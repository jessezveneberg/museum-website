<h2>Новини музею</h2>

<?php if ($user->isAdmin()): ?>
<a href="admin.php?section=news" class="btn">Додати новину (Адмін)</a>
<?php endif; ?>

<div class="grid">
    <?php foreach ($news_items as $item): ?>
    <div class="card">
        <?php if ($item['image']): ?>
        <img src="assets/images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
        <?php endif; ?>
        <div class="card-content">
            <h3 class="card-title"><?= htmlspecialchars($item['title']) ?></h3>
            <p class="news-date"><?= date('d.m.Y', strtotime($item['created_at'])) ?></p>
            <p><?= substr(htmlspecialchars($item['content']), 0, 200) ?>...</p>
            <a href="index.php?page=news_item&id=<?= $item['id'] ?>" class="btn">Читати далі</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>