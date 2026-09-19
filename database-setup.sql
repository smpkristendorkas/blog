-- Blog Database Setup SQL Script
-- Jalankan script ini di phpMyAdmin atau MySQL Editor

-- Create Database
CREATE DATABASE IF NOT EXISTS blog_db;
USE blog_db;

-- Posts Table
CREATE TABLE IF NOT EXISTS posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    category VARCHAR(100),
    tags VARCHAR(255),
    author VARCHAR(100),
    status VARCHAR(50) DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
);

-- Media Table
CREATE TABLE IF NOT EXISTS media (
    id INT PRIMARY KEY AUTO_INCREMENT,
    filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size INT,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_upload_date (upload_date)
);

-- Settings Table
CREATE TABLE IF NOT EXISTS settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value LONGTEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Users Table (optional, untuk multiple users)
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'author',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
);

-- Insert default settings
INSERT IGNORE INTO settings (setting_key, setting_value) VALUES
('site_title', 'Blog Saya'),
('site_description', 'Blog personal untuk berbagi tips, tutorial, dan pengalaman'),
('posts_per_page', '10'),
('timezone', 'Asia/Jakarta'),
('allow_comments', '1'),
('moderate_comments', '1'),
('admin_email', 'admin@blog.com'),
('theme_color', '#3498db'),
('font', 'Segoe UI'),
('show_sidebar', '1'),
('meta_description', 'Blog personal - tips, tutorial, dan pengalaman'),
('keywords', 'blog, tutorial, tips, web'),
('ga_id', ''),
('enable_sitemap', '1'),
('enable_rss', '1');

-- Insert sample post
INSERT IGNORE INTO posts (title, content, category, tags, author, status, created_at) VALUES
('Cara Membuat Blog Profesional', 
'Panduan lengkap membuat blog yang profesional dan menarik. Anda akan belajar tentang desain, konten, dan optimasi SEO.', 
'Tutorial', 
'blog, desain, web', 
'Admin', 
'Dipublikasikan',
NOW());

-- Insert sample user (password: admin123 - hashed with bcrypt)
INSERT IGNORE INTO users (username, email, password_hash, role) VALUES
('admin', 'admin@blog.com', '$2y$10$YjJhMDAwMDAwMDAwMDAwMC4wMDAwMDAwMDk2MTkzMDk3NWM1YzJmMjg=', 'administrator');
