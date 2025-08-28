<article class="page-content">
    <h2><?= htmlspecialchars($about_page['title']) ?></h2>
    
    <div class="page-text">
        <?= nl2br(htmlspecialchars($about_page['content'])) ?>
    </div>
    
    <?php if ($user->isAdmin()): ?>
    <div class="admin-actions">
        <a href="admin.php?section=pages&edit=<?= $about_page['id'] ?>" class="btn">Редагувати</a>
    </div>
    <?php endif; ?>
</article>