<section class="hero">
    <h2>Ласкаво просимо до нашого музею!</h2>
    <p>Відкрийте для себе багату культуру та історію через наші унікальні експонати.</p>
    <a href="index.php?page=exhibits" class="btn">Переглянути експонати</a>
</section>

<section class="latest-news">
    <h2>Останні новини</h2>
    <div class="grid">
        <?php foreach ($latest_news as $item): ?>
        <div class="card">
            <?php if ($item['image']): ?>
            <img src="assets/images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
            <?php endif; ?>
            <div class="card-content">
                <h3 class="card-title"><?= htmlspecialchars($item['title']) ?></h3>
                <p><?= substr(htmlspecialchars($item['content']), 0, 100) ?>...</p>
                <a href="index.php?page=news_item&id=<?= $item['id'] ?>" class="btn">Детальніше</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="featured-exhibits">
    <h2>Рекомендовані експонати</h2>
    <div class="grid">
        <?php foreach ($featured_exhibits as $exhibit): ?>
        <div class="card">
            <?php if ($exhibit['image']): ?>
            <img src="<?= htmlspecialchars($exhibit['image']) ?>" alt="<?= htmlspecialchars($exhibit['title']) ?>">
            <?php endif; ?>
            <div class="card-content">
                <h3 class="card-title"><?= htmlspecialchars($exhibit['title']) ?></h3>
                <p><?= htmlspecialchars($exhibit['description']) ?></p>
                <a href="index.php?page=exhibit&id=<?= $exhibit['id'] ?>" class="btn">Детальніше</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>