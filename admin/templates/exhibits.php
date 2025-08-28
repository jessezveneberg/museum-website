<h2>Керування експонатами</h2>

<?php if (isset($message)): ?>
<div class="message success"><?= $message ?></div>
<?php endif; ?>

<?php if (isset($error)): ?>
<div class="message error"><?= $error ?></div>
<?php endif; ?>

<div class="admin-tabs">
    <a href="#exhibits-list">Список експонатів</a>
    <a href="#add-exhibit"><?= isset($_GET['edit']) ? 'Редагувати' : 'Додати' ?> експонат</a>
</div>

<div id="exhibits-list" class="tab-content">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Назва</th>
                <th>Категорія</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($exhibits as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= htmlspecialchars($item['title']) ?></td>
                <td><?= htmlspecialchars($item['category']) ?></td>
                <td class="actions">
                    <a href="admin.php?section=exhibits&edit=<?= $item['id'] ?>" class="btn">Редагувати</a>
                    <form action="admin.php?section=exhibits" method="POST" class="delete-form">
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <input type="submit" name="delete_exhibit" value="Видалити" class="btn btn-danger">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="add-exhibit" class="tab-content">
    <?php
    $edit_mode = isset($_GET['edit']);
    $current_exhibit = $edit_mode ? $exhibit->getExhibit($_GET['edit']) : null;
    ?>
    
    <form action="admin.php?section=exhibits" method="POST" enctype="multipart/form-data">
        <?php if ($edit_mode): ?>
        <input type="hidden" name="id" value="<?= $current_exhibit['id'] ?>">
        <input type="hidden" name="existing_image" value="<?= $current_exhibit['image'] ?>">
        <?php endif; ?>
        
        <div class="form-group">
            <label for="title">Назва:</label>
            <input type="text" id="title" name="title" required 
                   value="<?= $edit_mode ? htmlspecialchars($current_exhibit['title']) : '' ?>">
        </div>
        
        <div class="form-group">
            <label for="description">Короткий опис:</label>
            <textarea id="description" name="description" rows="4" required><?= 
                $edit_mode ? htmlspecialchars($current_exhibit['description']) : '' ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="category">Категорія:</label>
            <input type="text" id="category" name="category" required 
                   value="<?= $edit_mode ? htmlspecialchars($current_exhibit['category']) : '' ?>">
        </div>
        
        <div class="form-group">
            <label for="full_text">Повний опис:</label>
            <textarea id="full_text" name="full_text" rows="10" required><?= 
                $edit_mode ? htmlspecialchars($current_exhibit['full_text']) : '' ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="image">Зображення:</label>
            <input type="file" id="image" name="image" accept="image/*">
            
            <?php if ($edit_mode && $current_exhibit['image']): ?>
            <div class="image-preview">
                <p>Поточне зображення:</p>
                <img src="<?= htmlspecialchars($current_exhibit['image']) ?>" alt="Current image" style="max-width: 200px;">
            </div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <input type="submit" name="<?= $edit_mode ? 'edit_exhibit' : 'add_exhibit' ?>" 
                   value="<?= $edit_mode ? 'Оновити експонат' : 'Додати експонат' ?>" class="btn">
                   
            <?php if ($edit_mode): ?>
            <a href="admin.php?section=exhibits" class="btn">Скасувати</a>
            <?php endif; ?>
        </div>
    </form>
</div>