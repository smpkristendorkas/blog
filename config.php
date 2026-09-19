<?php
/**
 * Blog Configuration File
 * 
 * Edit file ini sesuai dengan konfigurasi database Anda
 * PENTING: Sesuaikan nilai DB_USER, DB_PASS, dan DB_NAME dengan setup MySQL Anda
 */

// Database Configuration
define('DB_HOST', 'localhost');    // Database host (biasanya localhost)
define('DB_USER', 'root');         // Database username (default: root)
define('DB_PASS', '');             // Database password (kosong untuk default XAMPP/WAMP)
define('DB_NAME', 'blog_db');      // Database name

// Jika Anda menggunakan password untuk MySQL, ubah DB_PASS di atas
// Contoh: define('DB_PASS', 'password123');

// Site Configuration
define('SITE_TITLE', 'Blog Saya');
define('SITE_URL', 'http://localhost/Blog');
define('SITE_ADMIN_EMAIL', 'admin@blog.com');

// Upload Configuration
define('UPLOAD_DIR', 'uploads/');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB

// WordPress Configuration (uncomment jika menggunakan WordPress)
// define('WP_HOME', 'http://localhost/wordpress');
// define('WP_SITEURL', 'http://localhost/wordpress');
// define('WP_CONTENT_DIR', '/path/to/wp-content');

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Debug mode (set false di production)
define('DEBUG_MODE', true);

?>
