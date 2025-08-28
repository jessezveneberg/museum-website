<article class="exhibit-detail">
    <div class="exhibit-image-container">
        <?php if ($exhibit_item['image']): ?>
        <img src="<?= htmlspecialchars($exhibit_item['image']) ?>" alt="<?= htmlspecialchars($exhibit_item['title']) ?>" class="exhibit-image">
        <?php endif; ?>
    </div>
    
    <div class="exhibit-info">
        <h2><?= htmlspecialchars($exhibit_item['title']) ?></h2>
        <div class="exhibit-meta">
            <span class="category"><?= htmlspecialchars($exhibit_item['category']) ?></span>
            <span class="date">Додано: <?= date('d.m.Y', strtotime($exhibit_item['created_at'])) ?></span>
        </div>
        
        <div class="exhibit-fulltext">
            <?= nl2br(htmlspecialchars($exhibit_item['full_text'])) ?>
        </div>
        
        <?php if ($user->isAdmin()): ?>
        <div class="admin-actions">
            <a href="admin.php?section=exhibits&edit=<?= $exhibit_item['id'] ?>" class="btn">Редагувати</a>
            <form action="admin.php?section=exhibits" method="POST" class="delete-form">
                <input type="hidden" name="id" value="<?= $exhibit_item['id'] ?>">
                <input type="submit" name="delete_exhibit" value="Видалити" class="btn btn-danger">
            </form>
        </div>
        <?php endif; ?>
    </div>
</article>

<section class="comments-section">
    <h3>Коментарі</h3>
    
    <?php if (!empty($comments)): ?>
    <div class="comments-list">
        <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <div class="comment-header">
                <strong><?= htmlspecialchars($comment['username']) ?></strong>
                <span><?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?></span>
            </div>
            <div class="comment-content"><?= htmlspecialchars($comment['content']) ?></div>
            
            <?php if ($user->isAdmin() || ($user->isLoggedIn() && $_SESSION['user_id'] == $comment['user_id'])): ?>
            <form method="POST" action="index.php?page=exhibit&id=<?= $exhibit_item['id'] ?>" class="delete-comment-form">
                <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                <button type="submit" name="delete_comment" class="btn btn-sm btn-danger">
                    Видалити
                </button>
            </form>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p>Ще немає коментарів. Будьте першим!</p>
    <?php endif; ?>
    
    <?php if ($user->isLoggedIn()): ?>
    <form class="comment-form" method="POST" action="index.php?page=exhibit&id=<?= $exhibit_item['id'] ?>">
        <div class="form-group">
            <label for="comment">Додати коментар:</label>
            <textarea id="comment" name="content" required rows="4"></textarea>
        </div>
        <button type="submit" name="add_comment" class="btn">Надіслати</button>
    </form>
    <?php else: ?>
    <p>Будь ласка, <a href="index.php?page=login">увійдіть</a>, щоб залишити коментар.</p>
    <?php endif; ?>
</section>

<a href="index.php?page=exhibits" class="btn">Назад до експонатів</a>