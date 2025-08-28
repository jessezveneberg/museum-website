<div class="login-form">
    <h2>Вхід до системи</h2>
    
    <?php if (isset($login_error)): ?>
    <div class="message error"><?= $login_error ?></div>
    <?php endif; ?>
    
    <form action="index.php?page=login" method="POST">
        <div class="form-group">
            <label for="username">Логін:</label>
            <input type="text" id="username" name="username" required>
        </div>
        
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="form-group">
            <button type="submit" name="login">Увійти</button>
        </div>
    </form>
</div>