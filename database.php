<?php
/**
 * Database Connection Helper
 * 
 * File ini menyediakan koneksi dan fungsi-fungsi database
 * yang dapat digunakan di seluruh aplikasi
 */

require_once 'config.php';

class Database {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($this->conn->connect_error) {
            die(json_encode([
                'success' => false,
                'message' => 'Database connection failed: ' . $this->conn->connect_error
            ]));
        }
        
        $this->conn->set_charset("utf8mb4");
    }

    public function getConnection() {
        return $this->conn;
    }

    public function close() {
        $this->conn->close();
    }

    // Get all posts
    public function getPosts($limit = null, $offset = 0, $status = 'Dipublikasikan') {
        $query = "SELECT id, title, content, category, DATE_FORMAT(created_at, '%d %b %Y') as created_date, author, status 
                  FROM posts 
                  WHERE status='$status' 
                  ORDER BY created_at DESC";
        
        if ($limit) {
            $query .= " LIMIT $limit OFFSET $offset";
        }
        
        $result = $this->conn->query($query);
        return $this->resultToArray($result);
    }

    // Get single post
    public function getPost($id) {
        $id = intval($id);
        $query = "SELECT id, title, content, category, tags, DATE_FORMAT(created_at, '%d %b %Y') as created_date, author 
                  FROM posts 
                  WHERE id=$id AND status='Dipublikasikan'";
        
        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    // Insert post
    public function insertPost($data) {
        $title = $this->conn->real_escape_string($data['title'] ?? '');
        $content = $this->conn->real_escape_string($data['content'] ?? '');
        $category = $this->conn->real_escape_string($data['category'] ?? '');
        $tags = $this->conn->real_escape_string($data['tags'] ?? '');
        $status = $this->conn->real_escape_string($data['status'] ?? 'draft');
        $author = $this->conn->real_escape_string($data['author'] ?? 'Admin');

        $query = "INSERT INTO posts (title, content, category, tags, status, author, created_at) 
                  VALUES ('$title', '$content', '$category', '$tags', '$status', '$author', NOW())";
        
        if ($this->conn->query($query)) {
            return ['success' => true, 'id' => $this->conn->insert_id];
        }
        return ['success' => false, 'error' => $this->conn->error];
    }

    // Update post
    public function updatePost($id, $data) {
        $id = intval($id);
        $title = $this->conn->real_escape_string($data['title'] ?? '');
        $content = $this->conn->real_escape_string($data['content'] ?? '');
        $status = $this->conn->real_escape_string($data['status'] ?? 'draft');

        $query = "UPDATE posts SET title='$title', content='$content', status='$status', updated_at=NOW() WHERE id=$id";
        
        return $this->conn->query($query) ? ['success' => true] : ['success' => false, 'error' => $this->conn->error];
    }

    // Delete post
    public function deletePost($id) {
        $id = intval($id);
        $query = "DELETE FROM posts WHERE id=$id";
        
        return $this->conn->query($query) ? ['success' => true] : ['success' => false, 'error' => $this->conn->error];
    }

    // Get post count
    public function getPostCount($status = 'Dipublikasikan') {
        $query = "SELECT COUNT(*) as count FROM posts WHERE status='$status'";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    // Get media
    public function getMedia($limit = null) {
        $query = "SELECT id, filename, file_path, file_size, DATE_FORMAT(upload_date, '%d %b %Y') as upload_date FROM media ORDER BY upload_date DESC";
        
        if ($limit) {
            $query .= " LIMIT $limit";
        }
        
        $result = $this->conn->query($query);
        return $this->resultToArray($result);
    }

    // Insert media
    public function insertMedia($data) {
        $filename = $this->conn->real_escape_string($data['filename']);
        $file_path = $this->conn->real_escape_string($data['file_path']);
        $file_size = intval($data['file_size'] ?? 0);

        $query = "INSERT INTO media (filename, file_path, file_size, upload_date) 
                  VALUES ('$filename', '$file_path', $file_size, NOW())";
        
        if ($this->conn->query($query)) {
            return ['success' => true, 'id' => $this->conn->insert_id];
        }
        return ['success' => false, 'error' => $this->conn->error];
    }

    // Delete media
    public function deleteMedia($id) {
        $id = intval($id);
        
        // Get file path
        $query = "SELECT file_path FROM media WHERE id=$id";
        $result = $this->conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $file_path = $row['file_path'];
            
            // Delete file
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            
            // Delete from database
            $delete_query = "DELETE FROM media WHERE id=$id";
            return $this->conn->query($delete_query) ? ['success' => true] : ['success' => false];
        }
        
        return ['success' => false, 'message' => 'Media not found'];
    }

    // Get media count
    public function getMediaCount() {
        $query = "SELECT COUNT(*) as count FROM media";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    // Get setting
    public function getSetting($key, $default = null) {
        $key = $this->conn->real_escape_string($key);
        $query = "SELECT setting_value FROM settings WHERE setting_key='$key'";
        $result = $this->conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['setting_value'];
        }
        
        return $default;
    }

    // Get all settings
    public function getSettings() {
        $query = "SELECT setting_key, setting_value FROM settings";
        $result = $this->conn->query($query);
        
        $settings = [];
        while ($row = $result->fetch_assoc()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        return $settings;
    }

    // Update setting
    public function updateSetting($key, $value) {
        $key = $this->conn->real_escape_string($key);
        $value = $this->conn->real_escape_string($value);

        $check_query = "SELECT id FROM settings WHERE setting_key='$key'";
        $result = $this->conn->query($check_query);

        if ($result->num_rows > 0) {
            $update_query = "UPDATE settings SET setting_value='$value' WHERE setting_key='$key'";
            return $this->conn->query($update_query) ? ['success' => true] : ['success' => false];
        } else {
            $insert_query = "INSERT INTO settings (setting_key, setting_value) VALUES ('$key', '$value')";
            return $this->conn->query($insert_query) ? ['success' => true] : ['success' => false];
        }
    }

    // Helper: Convert result to array
    private function resultToArray($result) {
        if (!$result) {
            return [];
        }
        
        $array = [];
        while ($row = $result->fetch_assoc()) {
            $array[] = $row;
        }
        
        return $array;
    }
}

// Create global database instance
$db = new Database();
?>
