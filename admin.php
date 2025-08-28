<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

// Проверка авторизации и прав администратора
if (!$user->isLoggedIn() || !$user->isAdmin()) {
    header("Location: index.php?page=login");
    exit;
}

require_once 'includes/header.php';

// Инициализация классов
$page = new Page($db);
$news = new News($db);
$gallery = new Gallery($db);
$exhibit = new Exhibit($db);

// Определение текущего раздела
$admin_section = isset($_GET['section']) ? $_GET['section'] : 'dashboard';

// Включение буферизации вывода
buffer_start();

// Обработка всех разделов админки
switch ($admin_section) {
    case 'dashboard':
        include 'admin/templates/dashboard.php';
        break;
        
    case 'news':
        // Обработка действий с новостями
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['add_news'])) {
                $title = trim($_POST['title']);
                $content = trim($_POST['content']);
                $image = null;
                
                if (!empty($_FILES['image']['name'])) {
                    $upload = upload_file($_FILES['image'], 'assets/images/news/');
                    if ($upload['success']) {
                        $image = $upload['filename'];
                    }
                }
                
                if ($news->addNews($title, $content, $image)) {
                    $_SESSION['flash_message'] = 'Новину успішно додано!';
                    $_SESSION['flash_type'] = 'success';
                    header("Location: admin.php?section=news");
                    exit;
                } else {
                    $error = "Помилка при додаванні новини";
                }
            } 
            elseif (isset($_POST['edit_news'])) {
                $id = (int)$_POST['id'];
                $title = trim($_POST['title']);
                $content = trim($_POST['content']);
                $image = trim($_POST['existing_image']);
                
                if (!empty($_FILES['image']['name'])) {
                    $upload = upload_file($_FILES['image'], 'assets/images/news/');
                    if ($upload['success']) {
                        $image = $upload['filename'];
                    }
                }
                
                if ($news->updateNews($id, $title, $content, $image)) {
                    $_SESSION['flash_message'] = 'Новину успішно оновлено!';
                    $_SESSION['flash_type'] = 'success';
                    header("Location: admin.php?section=news");
                    exit;
                } else {
                    $error = "Помилка при оновленні новини";
                }
            } 
            elseif (isset($_POST['delete_news'])) {
                $id = (int)$_POST['id'];
                if ($news->deleteNews($id)) {
                    $_SESSION['flash_message'] = 'Новину успішно видалено!';
                    $_SESSION['flash_type'] = 'success';
                    header("Location: admin.php?section=news");
                    exit;
                } else {
                    $error = "Помилка при видаленні новини";
                }
            }
        }
        
        $news_items = $news->getNews(100);
        include 'admin/templates/news.php';
        break;
        
    case 'gallery':
        // Обработка действий с галереей
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['add_image'])) {
                $title = trim($_POST['title']);
                $description = trim($_POST['description']);
                
                if (!empty($_FILES['image']['name'])) {
                    $upload = upload_file($_FILES['image'], 'assets/images/gallery/');
                    if ($upload['success']) {
                        if ($gallery->addImage($title, 'assets/images/gallery/' . $upload['filename'], $description)) {
                            $_SESSION['flash_message'] = 'Зображення успішно додано!';
                            $_SESSION['flash_type'] = 'success';
                            header("Location: admin.php?section=gallery");
                            exit;
                        } else {
                            $error = "Помилка при додаванні зображення";
                        }
                    } else {
                        $error = $upload['error'];
                    }
                } else {
                    $error = "Будь ласка, виберіть файл";
                }
            } 
            elseif (isset($_POST['delete_image'])) {
                $id = (int)$_POST['id'];
                if ($gallery->deleteImage($id)) {
                    $_SESSION['flash_message'] = 'Зображення успішно видалено!';
                    $_SESSION['flash_type'] = 'success';
                    header("Location: admin.php?section=gallery");
                    exit;
                } else {
                    $error = "Помилка при видаленні зображення";
                }
            }
        }
        
        $images = $gallery->getImages(100);
        include 'admin/templates/gallery.php';
        break;
        
    case 'exhibits':
        // Обработка действий с экспонатами
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['add_exhibit'])) {
                $title = trim($_POST['title']);
                $description = trim($_POST['description']);
                $category = trim($_POST['category']);
                $full_text = trim($_POST['full_text']);
                $image = null;
                
                if (!empty($_FILES['image']['name'])) {
                    $upload = upload_file($_FILES['image'], 'assets/images/exhibits/');
                    if ($upload['success']) {
                        $image = 'assets/images/exhibits/' . $upload['filename'];
                    }
                }
                
                if ($exhibit->addExhibit($title, $description, $category, $image, $full_text)) {
                    $_SESSION['flash_message'] = 'Експонат успішно додано!';
                    $_SESSION['flash_type'] = 'success';
                    header("Location: admin.php?section=exhibits");
                    exit;
                } else {
                    $error = "Помилка при додаванні експоната";
                }
            } 
            elseif (isset($_POST['edit_exhibit'])) {
                $id = (int)$_POST['id'];
                $title = trim($_POST['title']);
                $description = trim($_POST['description']);
                $category = trim($_POST['category']);
                $full_text = trim($_POST['full_text']);
                $image = trim($_POST['existing_image']);
                
                if (!empty($_FILES['image']['name'])) {
                    $upload = upload_file($_FILES['image'], 'assets/images/exhibits/');
                    if ($upload['success']) {
                        $image = 'assets/images/exhibits/' . $upload['filename'];
                    }
                }
                
                if ($exhibit->updateExhibit($id, $title, $description, $category, $image, $full_text)) {
                    $_SESSION['flash_message'] = 'Експонат успішно оновлено!';
                    $_SESSION['flash_type'] = 'success';
                    header("Location: admin.php?section=exhibits");
                    exit;
                } else {
                    $error = "Помилка при оновленні експоната";
                }
            } 
            elseif (isset($_POST['delete_exhibit'])) {
                $id = (int)$_POST['id'];
                if ($exhibit->deleteExhibit($id)) {
                    $_SESSION['flash_message'] = 'Експонат успішно видалено!';
                    $_SESSION['flash_type'] = 'success';
                    header("Location: admin.php?section=exhibits");
                    exit;
                } else {
                    $error = "Помилка при видаленні експоната";
                }
            }
        }
        
        $exhibits = $exhibit->getExhibits();
        $categories = $exhibit->getCategories();
        include 'admin/templates/exhibits.php';
        break;
        
    case 'pages':
        // Обработка действий со страницами
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['add_page'])) {
                $title = trim($_POST['title']);
                $slug = trim($_POST['slug']);
                $content = trim($_POST['content']);
                
                if ($page->addPage($title, $slug, $content)) {
                    $_SESSION['flash_message'] = 'Сторінку успішно додано!';
                    $_SESSION['flash_type'] = 'success';
                    header("Location: admin.php?section=pages");
                    exit;
                } else {
                    $error = "Помилка при додаванні сторінки";
                }
            } 
            elseif (isset($_POST['edit_page'])) {
                $id = (int)$_POST['id'];
                $title = trim($_POST['title']);
                $slug = trim($_POST['slug']);
                $content = trim($_POST['content']);
                
                if ($page->updatePage($id, $title, $slug, $content)) {
                    $_SESSION['flash_message'] = 'Сторінку успішно оновлено!';
                    $_SESSION['flash_type'] = 'success';
                    header("Location: admin.php?section=pages");
                    exit;
                } else {
                    $error = "Помилка при оновленні сторінки";
                }
            } 
            elseif (isset($_POST['delete_page'])) {
                $id = (int)$_POST['id'];
                if ($page->deletePage($id)) {
                    $_SESSION['flash_message'] = 'Сторінку успішно видалено!';
                    $_SESSION['flash_type'] = 'success';
                    header("Location: admin.php?section=pages");
                    exit;
                } else {
                    $error = "Помилка при видаленні сторінки";
                }
            }
        }
        
        $pages = $page->getPages();
        include 'admin/templates/pages.php';
        break;
        
    case 'users':
        // Просмотр пользователей
        $users = $user->getAllUsers();
        include 'admin/templates/users.php';
        break;
        // Додати в switch-блок:
case 'comments':
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment'])) {
        $id = (int)$_POST['id'];
        if ($comment->deleteComment($id)) {
            $_SESSION['flash_message'] = 'Коментар успішно видалено!';
            $_SESSION['flash_type'] = 'success';
            header("Location: admin.php?section=comments");
            exit;
        } else {
            $error = "Помилка при видаленні коментаря";
        }
    }
    
    $comments = $comment->getAllComments();
    include 'admin/templates/comments.php';
    break;
    default:
        // Страница 404 для несуществующих разделов
        http_response_code(404);
        include 'admin/templates/404.php';
}

// Завершение буферизации и вывод футера
buffer_end();
require_once 'includes/footer.php';
?>