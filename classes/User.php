<?php
class User {
    private $db;
    
    public function __construct(Database $db) {
        $this->db = $db;
    }
    
    public function register($username, $email, $password, $role = 'user') {
        // Перевірка на спробу створити адміністратора
        if ($role === 'admin') {
            // Якщо поточний користувач не адмін
            if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
                return ['success' => false, 'error' => 'Тільки адміністратор може створювати інших адміністраторів'];
            }
            
            // Перевірка чи вже є адмін
            $stmt = $this->db->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                return ['success' => false, 'error' => 'Адміністратор вже існує'];
            }
        }
        
        // Валідація email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Невірний формат email'];
        }
        
        // Перевірка довжини пароля
        if (strlen($password) < 8) {
            return ['success' => false, 'error' => 'Пароль повинен містити щонайменше 8 символів'];
        }
        
        // Перевірка наявності користувача
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows > 0) {
            return ['success' => false, 'error' => 'Користувач з таким логіном або email вже існує'];
        }
        
        // Хешування пароля
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Створення користувача
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);
        
        if ($stmt->execute()) {
            return ['success' => true, 'user_id' => $stmt->insert_id];
        } else {
            return ['success' => false, 'error' => 'Помилка при реєстрації'];
        }
    }
    
    public function login($username, $password) {
        // Захист від SQL-ін'єкцій
        $username = $this->db->escape($username);
        
        $stmt = $this->db->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Оновлюємо сесію
                session_regenerate_id(true);
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['logged_in'] = true;
                $_SESSION['last_activity'] = time();
                
                return true;
            }
        }
        return false;
    }
    
    public function logout() {
        // Очищаємо всі змінні сесії
        $_SESSION = array();
        
        // Видаляємо куку сесії
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Знищуємо сесію
        session_destroy();
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    public function isAdmin() {
        return $this->isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    public function isEditor() {
        return $this->isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'editor';
    }
    
    public function getAllUsers() {
        $result = $this->db->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT id, username, email, role, created_at FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function updateUser($id, $username, $email, $role = null) {
        // Базовий запит
        $query = "UPDATE users SET username = ?, email = ?";
        $types = "ss";
        $params = [$username, $email];
        
        // Додаємо роль до запиту, якщо вказано
        if ($role !== null) {
            $query .= ", role = ?";
            $types .= "s";
            $params[] = $role;
        }
        
        $query .= " WHERE id = ?";
        $types .= "i";
        $params[] = $id;
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param($types, ...$params);
        
        return $stmt->execute();
    }
    
    public function deleteUser($id) {
        // Не можна видалити самого себе
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id) {
            return false;
        }
        
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    public function changePassword($id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $id);
        return $stmt->execute();
    }
}
?>