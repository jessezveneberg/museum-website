<div class="admin-news">
    <h2><i class="fas fa-newspaper"></i> Управління новинами</h2>
    
    <?php display_flash_message(); ?>
    
    <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <div class="admin-tabs">
        <a href="#news-list" class="active">Список новин</a>
        <a href="#add-news"><?= isset($_GET['edit']) ? 'Редагувати' : 'Додати' ?> новину</a>
    </div>
    
    <div id="news-list" class="tab-content active">
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
                    <td><?= date('d.m.Y H:i', strtotime($item['created_at'])) ?></td>
                    <td class="actions">
                        <a href="admin.php?section=news&edit=<?= $item['id'] ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Редагувати
                        </a>
                        <form method="POST" action="admin.php?section=news" class="d-inline">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <button type="submit" name="delete_news" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Ви впевнені, що хочете видалити цю новину?')">
                                <i class="fas fa-trash"></i> Видалити
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div id="add-news" class="tab-content">
        <?php
        $edit_mode = isset($_GET['edit']);
        $current_news = $edit_mode ? $news->getNewsItem($_GET['edit']) : null;
        ?>
        
        <form method="POST" action="admin.php?section=news" enctype="multipart/form-data">
            <?php if ($edit_mode): ?>
            <input type="hidden" name="id" value="<?= $current_news['id'] ?>">
            <input type="hidden" name="existing_image" value="<?= $current_news['image'] ?>">
            <?php endif; ?>
            
            <div class="form-group">
                <label for="title">Заголовок:</label>
                <input type="text" id="title" name="title" class="form-control" required 
                       value="<?= $edit_mode ? htmlspecialchars($current_news['title']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="content">Зміст:</label>
                <textarea id="content" name="content" class="form-control" rows="10" required><?= 
                    $edit_mode ? htmlspecialchars($current_news['content']) : '' ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="image">Зображення:</label>
                <input type="file" id="image" name="image" class="form-control-file" accept="image/*">
                
                <?php if ($edit_mode && $current_news['image']): ?>
                <div class="mt-2">
                    <p>Поточне зображення:</p>
                    <img src="assets/images/news/<?= htmlspecialchars($current_news['image']) ?>" 
                         alt="Поточне зображення" style="max-width: 200px;">
                </div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <button type="submit" name="<?= $edit_mode ? 'edit_news' : 'add_news' ?>" class="btn btn-primary">
                    <?= $edit_mode ? 'Оновити новину' : 'Додати новину' ?>
                </button>
                
                <?php if ($edit_mode): ?>
                <a href="admin.php?section=news" class="btn btn-secondary">Скасувати</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<script>
// Переключення між вкладками
document.querySelectorAll('.admin-tabs a').forEach(tab => {
    tab.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Приховуємо всі вкладки
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });
        
        // Видаляємо активний клас у всіх вкладках
        document.querySelectorAll('.admin-tabs a').forEach(t => {
            t.classList.remove('active');
        });
        
        // Показуємо вибрану вкладку
        const target = this.getAttribute('href').substring(1);
        document.getElementById(target).classList.add('active');
        this.classList.add('active');
    });
});

// Автоматичне відкриття вкладки редагування при наявності параметра edit
<?php if (isset($_GET['edit'])): ?>
document.querySelector('.admin-tabs a[href="#add-news"]').click();
<?php endif; ?>
</script>