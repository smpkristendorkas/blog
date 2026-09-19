<?php
/**
 * Blog Frontend API
 * 
 * API ini menyediakan data untuk halaman blog (index.html, news.html, dll)
 * Menampilkan postingan yang dipublikasikan dari database
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'database.php';

$action = isset($_GET['action']) ? $_GET['action'] : null;

switch ($action) {
    case 'get_posts':
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $offset = ($page - 1) * $limit;
        
        $posts = $db->getPosts($limit, $offset, 'Dipublikasikan');
        echo json_encode(['success' => true, 'data' => $posts]);
        break;

    case 'get_post':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $post = $db->getPost($id);
        echo json_encode(['success' => true, 'data' => $post]);
        break;

    case 'get_post_count':
        $count = $db->getPostCount('Dipublikasikan');
        echo json_encode(['success' => true, 'count' => $count]);
        break;

    case 'get_media':
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 100;
        $media = $db->getMedia($limit);
        echo json_encode(['success' => true, 'data' => $media]);
        break;

    case 'get_settings':
        $settings = $db->getSettings();
        echo json_encode(['success' => true, 'data' => $settings]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>
