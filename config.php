<?php
/**
 * Blog Configuration File
 * 
 * Edit file ini sesuai dengan konfigurasi database Anda
 */

// Database Configuration
define('DB_HOST', 'localhost');    // Database host (biasanya localhost)
define('DB_USER', 'root');         // Database username
define('DB_PASS', '');             // Database password (kosong untuk default)
define('DB_NAME', 'blog_db');      // Database name

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

// Error Reporting (disable di production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Asia/Jakarta');

?>
