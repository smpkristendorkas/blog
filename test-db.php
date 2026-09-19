<?php
/**
 * Database Test Helper
 * 
 * File ini membantu Anda test koneksi database
 * Akses: http://localhost/Blog/test-db.php
 */

header('Content-Type: text/html; charset=utf-8');

// Cek apakah config.php ada
if (!file_exists('config.php')) {
    die('<h1>❌ Error: config.php tidak ditemukan</h1><p><a href="SETUP.md">Lihat panduan setup</a></p>');
}

require_once 'config.php';

echo '<h1>🧪 Blog Database Test</h1>';
echo '<hr>';

// Test 1: Cek PHP Version
echo '<h2>1. PHP Version</h2>';
echo '<p>✅ PHP ' . phpversion() . '</p>';

// Test 2: Cek MySQLi Extension
echo '<h2>2. MySQLi Extension</h2>';
if (extension_loaded('mysqli')) {
    echo '<p>✅ MySQLi extension terinstall</p>';
} else {
    echo '<p>❌ MySQLi extension tidak terinstall</p>';
}

// Test 3: Cek Config File
echo '<h2>3. Configuration</h2>';
echo '<table border="1" cellpadding="10">';
echo '<tr><td><strong>DB_HOST</strong></td><td>' . DB_HOST . '</td></tr>';
echo '<tr><td><strong>DB_USER</strong></td><td>' . DB_USER . '</td></tr>';
echo '<tr><td><strong>DB_PASS</strong></td><td>' . (DB_PASS ? '***' : '(kosong)') . '</td></tr>';
echo '<tr><td><strong>DB_NAME</strong></td><td>' . DB_NAME . '</td></tr>';
echo '</table>';

// Test 4: Try Database Connection
echo '<h2>4. Database Connection</h2>';
$conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    echo '<p>❌ Koneksi gagal: ' . $conn->connect_error . '</p>';
    echo '<p><strong>Tips perbaikan:</strong></p>';
    echo '<ul>';
    echo '<li>Pastikan MySQL server sudah berjalan (XAMPP/WAMP)</li>';
    echo '<li>Pastikan database <code>' . DB_NAME . '</code> sudah dibuat</li>';
    echo '<li>Periksa username dan password di config.php</li>';
    echo '<li>Cek file database-setup.sql - import ke MySQL</li>';
    echo '</ul>';
} else {
    echo '<p>✅ Koneksi berhasil!</p>';
    
    // Test 5: Check Database Tables
    echo '<h2>5. Database Tables</h2>';
    $result = $conn->query("SHOW TABLES");
    
    if ($result) {
        $tables = [];
        while ($row = $result->fetch_row()) {
            $tables[] = $row[0];
        }
        
        if (count($tables) > 0) {
            echo '<p>✅ Tabel ditemukan:</p>';
            echo '<ul>';
            foreach ($tables as $table) {
                echo '<li><code>' . $table . '</code></li>';
            }
            echo '</ul>';
        } else {
            echo '<p>❌ Tidak ada tabel di database</p>';
            echo '<p><strong>Solusi:</strong> Import file <code>database-setup.sql</code> ke MySQL</p>';
        }
    }
    
    // Test 6: Check Sample Data
    echo '<h2>6. Sample Data</h2>';
    
    $posts_result = $conn->query("SELECT COUNT(*) as count FROM posts");
    if ($posts_result) {
        $row = $posts_result->fetch_assoc();
        echo '<p>📝 Posts: ' . $row['count'] . ' baris</p>';
    }
    
    $media_result = $conn->query("SELECT COUNT(*) as count FROM media");
    if ($media_result) {
        $row = $media_result->fetch_assoc();
        echo '<p>🖼️ Media: ' . $row['count'] . ' baris</p>';
    }
    
    $settings_result = $conn->query("SELECT COUNT(*) as count FROM settings");
    if ($settings_result) {
        $row = $settings_result->fetch_assoc();
        echo '<p>⚙️ Settings: ' . $row['count'] . ' baris</p>';
    }
    
    $conn->close();
}

// Test 7: API Test
echo '<h2>7. API Test</h2>';
echo '<p>Test endpoints:</p>';
echo '<ul>';
echo '<li><a href="api.php?action=get_stats" target="_blank">api.php?action=get_stats</a> (Admin API - Stats)</li>';
echo '<li><a href="blog-api.php?action=get_posts&limit=5" target="_blank">blog-api.php?action=get_posts&limit=5</a> (Public API - Posts)</li>';
echo '<li><a href="blog-api.php?action=get_settings" target="_blank">blog-api.php?action=get_settings</a> (Settings)</li>';
echo '</ul>';

// Test 8: File Permissions
echo '<h2>8. File Permissions</h2>';
$dirs_to_check = [
    'uploads' => 'Folder uploads (untuk media)',
    'uploads/media' => 'Folder uploads/media (untuk gambar)',
];

foreach ($dirs_to_check as $dir => $label) {
    if (!file_exists($dir)) {
        echo '<p>⚠️ ' . $label . ' (<code>' . $dir . '</code>) - Tidak ada (akan dibuat auto saat upload)</p>';
    } else {
        $perms = substr(sprintf('%o', fileperms($dir)), -4);
        echo '<p>✅ ' . $label . ' - Permissions: ' . $perms . '</p>';
    }
}

echo '<hr>';
echo '<p><strong>📖 Dokumentasi:</strong> <a href="SETUP.md">SETUP.md</a></p>';
?>
