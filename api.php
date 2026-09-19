<?php
/**
 * Blog Admin API Backend
 * 
 * File ini menangani semua request dari Admin Panel
 * Terhubung langsung ke database dan menangani CRUD operations
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Include database helper
require_once 'database.php';

// Get request data
$request_method = $_SERVER['REQUEST_METHOD'];
$request_data = file_get_contents('php://input');
$data = json_decode($request_data, true);

// Get action from query parameter
$action = isset($_GET['action']) ? $_GET['action'] : null;

// Route requests
switch ($action) {
    // Posts
    case 'get_posts':
        $posts = $db->getPosts();
        echo json_encode(['success' => true, 'data' => $posts]);
        break;
        
    case 'add_post':
        $result = $db->insertPost($data);
        http_response_code($result['success'] ? 201 : 500);
        echo json_encode($result + ['message' => $result['success'] ? 'Posting berhasil ditambahkan' : 'Gagal menambahkan posting']);
        break;
        
    case 'update_post':
        $id = $data['id'] ?? 0;
        $result = $db->updatePost($id, $data);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result + ['message' => $result['success'] ? 'Posting berhasil diperbarui' : 'Gagal memperbarui posting']);
        break;
        
    case 'delete_post':
        $id = $data['id'] ?? 0;
        $result = $db->deletePost($id);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result + ['message' => $result['success'] ? 'Posting berhasil dihapus' : 'Gagal menghapus posting']);
        break;

    // Media
    case 'get_media':
        $media = $db->getMedia();
        echo json_encode(['success' => true, 'data' => $media]);
        break;
        
    case 'upload_media':
        handleMediaUpload($db);
        break;
        
    case 'delete_media':
        $id = $data['id'] ?? 0;
        $result = $db->deleteMedia($id);
        http_response_code($result['success'] ? 200 : 500);
        echo json_encode($result + ['message' => $result['success'] ? 'Media berhasil dihapus' : 'Gagal menghapus media']);
        break;

    // Settings
    case 'get_settings':
        $settings = $db->getSettings();
        echo json_encode(['success' => true, 'data' => $settings]);
        break;
        
    case 'update_settings':
        foreach ($data as $key => $value) {
            $db->updateSetting($key, $value);
        }
        echo json_encode(['success' => true, 'message' => 'Pengaturan berhasil disimpan']);
        break;

    // Dashboard stats
    case 'get_stats':
        $stats = [
            'posts' => $db->getPostCount(),
            'media' => $db->getMediaCount(),
            'visitors' => 1245,
            'comments' => 87
        ];
        echo json_encode(['success' => true, 'data' => $stats]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

// ============== HELPER FUNCTIONS ==============

function handleMediaUpload($db) {
    if (!isset($_FILES['file'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'No file uploaded']);
        return;
    }

    $file = $_FILES['file'];
    $filename = basename($file['name']);
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];

    // Validate file
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file_tmp);
    finfo_close($finfo);

    if (!in_array($mime_type, $allowed_types)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid file type']);
        return;
    }

    // Create upload directory
    $upload_dir = 'uploads/media/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Save file
    $new_filename = time() . '_' . preg_replace('/[^a-z0-9._-]/i', '', $filename);
    $file_path = $upload_dir . $new_filename;

    if (move_uploaded_file($file_tmp, $file_path)) {
        $result = $db->insertMedia([
            'filename' => $new_filename,
            'file_path' => $file_path,
            'file_size' => $file_size
        ]);
        
        http_response_code($result['success'] ? 201 : 500);
        echo json_encode($result + ['file_path' => $file_path, 'message' => 'File berhasil diupload']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'File upload failed']);
    }
}
?>
