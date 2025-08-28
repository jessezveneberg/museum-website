<h2>Керування сторінками</h2>

<?php if (isset($message)): ?>
<div class="message success"><?= $message ?></div>
<?php endif; ?>

<?php if (isset($error)): ?>
<div class="message error"><?= $error ?></div>
<?php endif; ?>

<div class="admin-tabs">
    <a href="#pages-list">Список сторінок</a>
    <a href="#add-page"><?= isset($_GET['edit']) ? 'Редагувати' : 'Додати' ?> сторінку</a>
</div>

<div id="pages-list" class="tab-content">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Назва</th>
                <th>URL</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pages as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= htmlspecialchars($item['title']) ?></td>
                <td><?= htmlspecialchars($item['slug']) ?></td>
                <td class="actions">
                    <a href="admin.php?section=pages&edit=<?= $item['id'] ?>" class="btn">Редагувати</a>
                    <form action="admin.php?section=pages" method="POST" class="delete-form">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <input type="submit" name="delete_page" value="Видалити" class="btn btn-danger">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="add-page" class="tab-content">
    <?php
    $edit_mode = isset($_GET['edit']);
    $current_page = $edit_mode ? $page->getPageById($_GET['edit']) : null;
    ?>
    
    <form action="admin.php?section=pages" method="POST">
        <?php if ($edit_mode): ?>
        <input type="hidden" name="id" value="<?= $current_page['id'] ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="title">Назва:</label>
            <input type="text" id="title" name="title" required 
                   value="<?= $edit_mode ? htmlspecialchars($current_page['title']) : '' ?>">
        </div>
        
        <div class="form-group">
            <label for="slug">URL-адреса:</label>
            <input type="text" id="slug" name="slug" required 
                   value="<?= $edit_mode ? htmlspecialchars($current_page['slug']) : '' ?>">
        </div>
        
        <div class="form-group">
            <label for="content">Зміст:</label>
            <textarea id="content" name="content" rows="15" required><?= 
                $edit_mode ? htmlspecialchars($current_page['content']) : '' ?></textarea>
        </div>
        
        <div class="form-group">
            <input type="submit" name="<?= $edit_mode ? 'edit_page' : 'add_page' ?>" 
                   value="<?= $edit_mode ? 'Оновити сторінку' : 'Додати сторінку' ?>" class="btn">
                   
            <?php if ($edit_mode): ?>
            <a href="admin.php?section=pages" class="btn">Скасувати</a>
            <?php endif; ?>
        </div>
    </form>
</div>