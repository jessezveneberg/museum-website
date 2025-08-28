<div class="admin-comments">
    <h2><i class="fas fa-comments"></i> Управління коментарями</h2>
    
    <?php display_flash_message(); ?>
    
    <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Експонат</th>
                <th>Користувач</th>
                <th>Коментар</th>
                <th>Дата</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment): ?>
            <tr>
                <td><?= $comment['id'] ?></td>
                <td>
                    <a href="index.php?page=exhibit&id=<?= $comment['exhibit_id'] ?>">
                        <?= htmlspecialchars($comment['exhibit_title']) ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($comment['username']) ?></td>
                <td><?= htmlspecialchars(substr($comment['content'], 0, 50)) ?>...</td>
                <td><?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?></td>
                <td class="actions">
                    <form method="POST" action="admin.php?section=comments">
                        <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                        <button type="submit" name="delete_comment" class="btn btn-sm btn-danger" 
                                onclick="return confirm('Ви впевнені, що хочете видалити цей коментар?')">
                            <i class="fas fa-trash"></i> Видалити
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>