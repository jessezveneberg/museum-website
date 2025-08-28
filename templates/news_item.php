<article class="news-item">
    <h2><?= htmlspecialchars($news_item['title']) ?></h2>
    <p class="news-date">Опубліковано: <?= date('d.m.Y H:i', strtotime($news_item['created_at'])) ?></p>
    
    <?php if ($news_item['image']): ?>
    <img src="assets/images/<?= htmlspecialchars($news_item['image']) ?>" alt="<?= htmlspecialchars($news_item['title']) ?>" class="news-image">
    <?php endif; ?>
    
    <div class="news-content">
        <?= nl2br(htmlspecialchars($news_item['content'])) ?>
    </div>
    
    <?php if ($user->isAdmin()): ?>
    <div class="admin-actions">
        <a href="admin.php?section=news&edit=<?= $news_item['id'] ?>" class="btn">Редагувати</a>
        <form action="admin.php?section=news" method="POST" class="delete-form">
            <input type="hidden" name="id" value="<?= $news_item['id'] ?>">
            <input type="submit" name="delete_news" value="Видалити" class="btn btn-danger">
        </form>
    </div>
    <?php endif; ?>
    
    <a href="index.php?page=news" class="btn">Назад до новин</a>
</article>