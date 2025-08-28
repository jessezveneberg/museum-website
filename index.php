<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

$page = new Page($db);
$news = new News($db);
$gallery = new Gallery($db);
$exhibit = new Exhibit($db);

// Обробка запитів
$requested_page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Буферизація вмісту
buffer_start();

switch ($requested_page) {
    case 'home':
        $latest_news = $news->getNews(3);
        $featured_exhibits = $exhibit->getExhibits(null, 4);
        include 'templates/home.php';
        break;
        
    case 'news':
        $news_items = $news->getNews();
        include 'templates/news.php';
        break;
        
    case 'news_item':
        if (isset($_GET['id'])) {
            $news_item = $news->getNewsItem($_GET['id']);
            if ($news_item) {
                include 'templates/news_item.php';
            } else {
                http_response_code(404);
                include 'templates/404.php';
            }
        } else {
            http_response_code(400);
            include 'templates/400.php';
        }
        break;
        
    case 'gallery':
        $images = $gallery->getImages();
        include 'templates/gallery.php';
        break;
        
    case 'exhibits':
        $categories = $exhibit->getCategories();
        $current_category = isset($_GET['category']) ? $_GET['category'] : null;
        $exhibits = $exhibit->getExhibits($current_category);
        include 'templates/exhibits.php';
        break;
        
    case 'exhibit':
        if (isset($_GET['id'])) {
            $exhibit_item = $exhibit->getExhibit($_GET['id']);
            if ($exhibit_item) {
                include 'templates/exhibit.php';
            } else {
                http_response_code(404);
                include 'templates/404.php';
            }
        } else {
            http_response_code(400);
            include 'templates/400.php';
        }
        break;
        
    case 'about':
        $about_page = $page->getPage('about');
        include 'templates/page.php';
        break;
        
    case 'login':
        include 'templates/login.php';
        break;
        
    case 'register':
        include 'templates/register.php';
        break;
        
    case 'profile':
        if ($user->isLoggedIn()) {
            $current_user = $user->getUserById($_SESSION['user_id']);
            include 'templates/profile.php';
        } else {
            header("Location: index.php?page=login");
            exit;
        }
        break;
        // В switch-блок додаємо обробку для сторінки експонату:
case 'exhibit':
    if (isset($_GET['id'])) {
        $exhibit_item = $exhibit->getExhibit($_GET['id']);
        if ($exhibit_item) {
            // Обробка коментарів
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['add_comment']) && $user->isLoggedIn()) {
                    $content = trim($_POST['content']);
                    if (!empty($content)) {
                        $comment->addComment($exhibit_item['id'], $_SESSION['user_id'], $content);
                        header("Location: index.php?page=exhibit&id=".$exhibit_item['id']);
                        exit;
                    }
                }
                elseif (isset($_POST['delete_comment']) && $user->isLoggedIn()) {
                    $comment_id = (int)$_POST['comment_id'];
                    $comment_data = $comment->getCommentById($comment_id);
                    
                    if ($comment_data && ($user->isAdmin() || $_SESSION['user_id'] == $comment_data['user_id'])) {
                        $comment->deleteComment($comment_id);
                        header("Location: index.php?page=exhibit&id=".$exhibit_item['id']);
                        exit;
                    }
                }
            }
            
            $comments = $comment->getCommentsByExhibit($exhibit_item['id']);
            include 'templates/exhibit.php';
        } else {
            http_response_code(404);
            include 'templates/404.php';
        }
    } else {
        http_response_code(400);
        include 'templates/400.php';
    }
    break;
    default:
        if ($custom_page = $page->getPage($requested_page)) {
            include 'templates/page.php';
        } else {
            http_response_code(404);
            include 'templates/404.php';
        }
}

buffer_end();
require_once 'includes/footer.php';
?>