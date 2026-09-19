<?php
/**
 * Blog Admin API Backend
 * 
 * File ini menangani semua request dari Admin Panel
 * Request format: POST dengan JSON data
 */

header('Content-Type: application/json');

// Enable CORS untuk development (disable di production)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'blog_db';

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]);
    exit;
}

// Set charset
$conn->set_charset("utf8mb4");

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
        get_posts($conn);
        break;
    case 'add_post':
        add_post($conn, $data);
        break;
    case 'update_post':
        update_post($conn, $data);
        break;
    case 'delete_post':
        delete_post($conn, $data);
        break;

    // Media
    case 'get_media':
        get_media($conn);
        break;
    case 'upload_media':
        upload_media($conn);
        break;
    case 'delete_media':
        delete_media($conn, $data);
        break;

    // Settings
    case 'get_settings':
        get_settings($conn);
        break;
    case 'update_settings':
        update_settings($conn, $data);
        break;

    // Dashboard stats
    case 'get_stats':
        get_stats($conn);
        break;

    default:
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid action'
        ]);
}

// ============== FUNCTIONS ==============

// Get all posts
function get_posts($conn) {
    $query = "SELECT id, title, category, author, DATE_FORMAT(created_at, '%d %b %Y') as created_date, status FROM posts ORDER BY created_at DESC";
    $result = $conn->query($query);

    if (!$result) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Query failed']);
        return;
    }

    $posts = [];
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }

    echo json_encode([
        'success' => true,
        'data' => $posts
    ]);
}

// Add new post
function add_post($conn, $data) {
    $title = $conn->real_escape_string($data['title'] ?? '');
    $category = $conn->real_escape_string($data['category'] ?? '');
    $content = $conn->real_escape_string($data['content'] ?? '');
    $tags = $conn->real_escape_string($data['tags'] ?? '');
    $status = $conn->real_escape_string($data['status'] ?? 'draft');
    $author = 'Admin'; // Get from session in production

    $query = "INSERT INTO posts (title, category, content, tags, status, author, created_at) 
              VALUES ('$title', '$category', '$content', '$tags', '$status', '$author', NOW())";

    if ($conn->query($query)) {
        echo json_encode([
            'success' => true,
            'message' => 'Posting berhasil ditambahkan',
            'post_id' => $conn->insert_id
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add post: ' . $conn->error
        ]);
    }
}

// Update post
function update_post($conn, $data) {
    $id = intval($data['id'] ?? 0);
    $title = $conn->real_escape_string($data['title'] ?? '');
    $content = $conn->real_escape_string($data['content'] ?? '');
    $status = $conn->real_escape_string($data['status'] ?? 'draft');

    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid post ID']);
        return;
    }

    $query = "UPDATE posts SET title='$title', content='$content', status='$status' WHERE id=$id";

    if ($conn->query($query)) {
        echo json_encode([
            'success' => true,
            'message' => 'Posting berhasil diperbarui'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update post'
        ]);
    }
}

// Delete post
function delete_post($conn, $data) {
    $id = intval($data['id'] ?? 0);

    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid post ID']);
        return;
    }

    $query = "DELETE FROM posts WHERE id=$id";

    if ($conn->query($query)) {
        echo json_encode([
            'success' => true,
            'message' => 'Posting berhasil dihapus'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to delete post'
        ]);
    }
}

// Get all media
function get_media($conn) {
    $query = "SELECT id, filename, file_path, file_size, upload_date FROM media ORDER BY upload_date DESC LIMIT 100";
    $result = $conn->query($query);

    if (!$result) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Query failed']);
        return;
    }

    $media = [];
    while ($row = $result->fetch_assoc()) {
        $media[] = $row;
    }

    echo json_encode([
        'success' => true,
        'data' => $media
    ]);
}

// Upload media
function upload_media($conn) {
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
    $new_filename = time() . '_' . $filename;
    $file_path = $upload_dir . $new_filename;

    if (move_uploaded_file($file_tmp, $file_path)) {
        // Save to database
        $filename_db = $conn->real_escape_string($new_filename);
        $file_path_db = $conn->real_escape_string($file_path);

        $query = "INSERT INTO media (filename, file_path, file_size, upload_date) 
                  VALUES ('$filename_db', '$file_path_db', $file_size, NOW())";

        if ($conn->query($query)) {
            echo json_encode([
                'success' => true,
                'message' => 'File berhasil diupload',
                'file_path' => $file_path
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database save failed']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'File upload failed']);
    }
}

// Delete media
function delete_media($conn, $data) {
    $id = intval($data['id'] ?? 0);

    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid media ID']);
        return;
    }

    // Get file path
    $query = "SELECT file_path FROM media WHERE id=$id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    if (!$row) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Media not found']);
        return;
    }

    // Delete file
    if (file_exists($row['file_path'])) {
        unlink($row['file_path']);
    }

    // Delete from database
    $delete_query = "DELETE FROM media WHERE id=$id";

    if ($conn->query($delete_query)) {
        echo json_encode([
            'success' => true,
            'message' => 'Media berhasil dihapus'
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Delete failed']);
    }
}

// Get settings
function get_settings($conn) {
    $query = "SELECT setting_key, setting_value FROM settings";
    $result = $conn->query($query);

    if (!$result) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Query failed']);
        return;
    }

    $settings = [];
    while ($row = $result->fetch_assoc()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }

    echo json_encode([
        'success' => true,
        'data' => $settings
    ]);
}

// Update settings
function update_settings($conn, $data) {
    foreach ($data as $key => $value) {
        $key_db = $conn->real_escape_string($key);
        $value_db = $conn->real_escape_string($value);

        $check_query = "SELECT id FROM settings WHERE setting_key='$key_db'";
        $result = $conn->query($check_query);

        if ($result->num_rows > 0) {
            $update_query = "UPDATE settings SET setting_value='$value_db' WHERE setting_key='$key_db'";
            $conn->query($update_query);
        } else {
            $insert_query = "INSERT INTO settings (setting_key, setting_value) VALUES ('$key_db', '$value_db')";
            $conn->query($insert_query);
        }
    }

    echo json_encode([
        'success' => true,
        'message' => 'Pengaturan berhasil disimpan'
    ]);
}

// Get dashboard statistics
function get_stats($conn) {
    // Total posts
    $posts_query = "SELECT COUNT(*) as count FROM posts WHERE status='Dipublikasikan'";
    $posts_result = $conn->query($posts_query);
    $posts_count = $posts_result->fetch_assoc()['count'];

    // Total media
    $media_query = "SELECT COUNT(*) as count FROM media";
    $media_result = $conn->query($media_query);
    $media_count = $media_result->fetch_assoc()['count'];

    echo json_encode([
        'success' => true,
        'data' => [
            'posts' => $posts_count,
            'media' => $media_count,
            'visitors' => 1245,
            'comments' => 87
        ]
    ]);
}

$conn->close();
?>
