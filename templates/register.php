<div class="register-form">
    <h2>Реєстрація</h2>
    
    <?php if (isset($register_error)): ?>
    <div class="message error"><?= $register_error ?></div>
    <?php endif; ?>
    
    <form action="index.php?page=register" method="POST">
        <div class="form-group">
            <label for="username">Логін:</label>
            <input type="text" id="username" name="username" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label for="password_confirm">Підтвердіть пароль:</label>
            <input type="password" id="password_confirm" name="password_confirm" required>
        </div>
        
        <div class="form-group">
            <label for="role">Роль:</label>
            <select id="role" name="role" <?= !$user->isAdmin() ? 'disabled' : '' ?>>
                <option value="user">Користувач</option>
                <?php if ($user->isAdmin()): ?>
                <option value="editor">Редактор</option>
                <option value="admin">Адміністратор</option>
                <?php endif; ?>
            </select>
            <?php if (!$user->isAdmin()): ?>
            <input type="hidden" name="role" value="user">
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <button type="submit" name="register">Зареєструватися</button>
        </div>
    </form>
    
    <p>Вже маєте акаунт? <a href="index.php?page=login">Увійти</a></p>
</div>