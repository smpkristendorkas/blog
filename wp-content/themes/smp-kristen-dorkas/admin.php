<?php
/**
 * Admin Panel - Blog Management
 * 
 * Template file untuk WordPress theme SMP Kristen Dorkas
 * Pastikan Anda login sebagai admin sebelum mengakses halaman ini
 */

// Check if user is logged in and is admin
// Uncomment jika menggunakan WordPress:
// if (!is_user_logged_in() || !current_user_can('manage_options')) {
//     wp_redirect(home_url());
//     exit;
// }

// Get theme directory
$theme_dir = get_template_directory();
$theme_url = get_template_directory_uri();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Blog</title>
    <link rel="stylesheet" href="<?php echo $theme_url; ?>/admin-styles.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">📊 Admin Panel</div>
        <ul class="nav-menu">
            <li><a href="#" class="nav-link active" data-section="dashboard">📈 Dashboard</a></li>
            <li><a href="#" class="nav-link" data-section="posts">📝 Posting</a></li>
            <li><a href="#" class="nav-link" data-section="media">🖼️ Foto & Media</a></li>
            <li><a href="#" class="nav-link" data-section="appearance">🎨 Penampilan</a></li>
            <li><a href="#" class="nav-link" data-section="widgets">🧩 Widget</a></li>
            <li><a href="#" class="nav-link" data-section="menu">📋 Menu</a></li>
            <li><a href="#" class="nav-link" data-section="users">👥 Pengguna</a></li>
            <li><a href="#" class="nav-link" data-section="settings">⚙️ Pengaturan</a></li>
            <li><a href="#" class="nav-link" data-section="seo">🔍 SEO</a></li>
            <li><a href="#" class="nav-link" data-section="backup">💾 Backup</a></li>
        </ul>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Header -->
        <div class="header">
            <h1 id="page-title">Dashboard</h1>
            <div class="user-info">
                <div class="user-avatar">👤</div>
                <span><?php echo isset($_SERVER['REMOTE_USER']) ? htmlspecialchars($_SERVER['REMOTE_USER']) : 'Admin'; ?></span>
                <button class="logout-btn">Logout</button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content">
            <!-- Dashboard Section -->
            <div id="dashboard" class="section active">
                <div class="dashboard-grid">
                    <div class="card">
                        <h3>📝 Total Posting</h3>
                        <div class="card-value" id="post-count">24</div>
                        <div class="card-label">Artikel dipublikasikan</div>
                    </div>
                    <div class="card">
                        <h3>👥 Total Pengunjung</h3>
                        <div class="card-value" id="visitor-count">1,245</div>
                        <div class="card-label">Bulan ini</div>
                    </div>
                    <div class="card">
                        <h3>💬 Komentar</h3>
                        <div class="card-value" id="comment-count">87</div>
                        <div class="card-label">Menunggu verifikasi</div>
                    </div>
                    <div class="card">
                        <h3>🖼️ Media</h3>
                        <div class="card-value" id="media-count">156</div>
                        <div class="card-label">Foto & Gambar</div>
                    </div>
                </div>
            </div>

            <!-- Posts Section -->
            <div id="posts" class="section">
                <button class="btn btn-primary" onclick="showForm('postForm')">+ Posting Baru</button>
                
                <div id="postList">
                    <table>
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="post-table-body">
                            <tr>
                                <td>Cara Membuat Blog Profesional</td>
                                <td>Admin</td>
                                <td>15 Sept 2026</td>
                                <td><span style="background-color: #27ae60; color: white; padding: 5px 10px; border-radius: 3px;">Dipublikasikan</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Edit</button>
                                    <button class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="postForm" style="display: none; margin-top: 30px; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2>Posting Baru</h2>
                    <hr style="margin: 20px 0;">
                    <form id="addPostForm">
                        <div class="form-group">
                            <label>Judul Posting</label>
                            <input type="text" name="title" placeholder="Masukkan judul posting" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category">
                                <option>-- Pilih Kategori --</option>
                                <option>Tutorial</option>
                                <option>Tips & Trik</option>
                                <option>Berita</option>
                                <option>Review</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Konten</label>
                            <textarea name="content" placeholder="Tulis konten posting di sini..."></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Tag</label>
                                <input type="text" name="tags" placeholder="Pisahkan dengan koma">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status">
                                    <option>Draft</option>
                                    <option selected>Dipublikasikan</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan Posting</button>
                        <button type="button" class="btn btn-secondary" onclick="hideForm('postForm')">Batal</button>
                    </form>
                </div>
            </div>

            <!-- Media Section -->
            <div id="media" class="section">
                <button class="btn btn-primary" onclick="document.getElementById('fileInput').click()">+ Upload Foto</button>
                <input type="file" id="fileInput" style="display: none;" accept="image/*" multiple>

                <div id="media-gallery" style="margin-top: 20px; display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px;">
                    <div style="background-color: white; padding: 10px; border-radius: 8px; text-align: center;">
                        <div style="width: 100%; height: 150px; background-color: #ecf0f1; border-radius: 5px; margin-bottom: 10px; display: flex; align-items: center; justify-content: center;">📷</div>
                        <small>Foto 1.jpg</small>
                        <div style="margin-top: 10px;">
                            <button class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appearance Section -->
            <div id="appearance" class="section">
                <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2>Pengaturan Penampilan</h2>
                    <hr style="margin: 20px 0;">
                    <form id="appearanceForm">
                        <div class="form-group">
                            <label>Judul Website</label>
                            <input type="text" name="site_title" value="Blog Saya" placeholder="Masukkan judul website">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Website</label>
                            <textarea name="site_description" placeholder="Deskripsi singkat tentang website Anda">Blog personal untuk berbagi tips, tutorial, dan pengalaman</textarea>
                        </div>
                        <div class="form-group">
                            <label>Logo Website</label>
                            <input type="file" name="logo" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label>Warna Tema Utama</label>
                            <input type="color" name="theme_color" value="#3498db">
                        </div>
                        <div class="form-group">
                            <label>Font Utama</label>
                            <select name="font">
                                <option selected>Segoe UI</option>
                                <option>Arial</option>
                                <option>Georgia</option>
                                <option>Times New Roman</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="show_sidebar" checked> Tampilkan Sidebar
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </form>
                </div>
            </div>

            <!-- Widgets Section -->
            <div id="widgets" class="section">
                <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2>Kelola Widget</h2>
                    <hr style="margin: 20px 0;">
                    
                    <div class="tabs">
                        <button class="tab-btn active" onclick="switchTab(event, 'sidebar-widgets')">Widget Sidebar</button>
                        <button class="tab-btn" onclick="switchTab(event, 'footer-widgets')">Widget Footer</button>
                    </div>

                    <div id="sidebar-widgets" class="tab-content active">
                        <h3>Widget yang Tersedia</h3>
                        <table style="margin-top: 15px;">
                            <thead>
                                <tr>
                                    <th>Widget</th>
                                    <th>Posisi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Recent Posts</td>
                                    <td>Sidebar</td>
                                    <td><input type="checkbox" checked></td>
                                    <td><button class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Edit</button></td>
                                </tr>
                                <tr>
                                    <td>Categories</td>
                                    <td>Sidebar</td>
                                    <td><input type="checkbox" checked></td>
                                    <td><button class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Edit</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="footer-widgets" class="tab-content">
                        <h3>Widget Footer yang Tersedia</h3>
                        <table style="margin-top: 15px;">
                            <thead>
                                <tr>
                                    <th>Widget</th>
                                    <th>Kolom</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>About Us</td>
                                    <td>Kolom 1</td>
                                    <td><input type="checkbox" checked></td>
                                    <td><button class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Edit</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Menu Section -->
            <div id="menu" class="section">
                <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2>Kelola Menu</h2>
                    <hr style="margin: 20px 0;">
                    <button class="btn btn-primary" onclick="showForm('menuForm')">+ Menu Baru</button>
                    
                    <table style="margin-top: 20px;">
                        <thead>
                            <tr>
                                <th>Nama Menu</th>
                                <th>Lokasi</th>
                                <th>Item</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Menu Utama</td>
                                <td>Header</td>
                                <td>5 item</td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Edit</button>
                                    <button class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div id="menuForm" style="display: none; margin-top: 30px;">
                        <h3>Tambah Menu Baru</h3>
                        <div class="form-group">
                            <label>Nama Menu</label>
                            <input type="text" placeholder="Masukkan nama menu">
                        </div>
                        <div class="form-group">
                            <label>Lokasi Menu</label>
                            <select>
                                <option>Header</option>
                                <option>Footer</option>
                                <option>Sidebar</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Buat Menu</button>
                        <button type="button" class="btn btn-secondary" onclick="hideForm('menuForm')">Batal</button>
                    </div>
                </div>
            </div>

            <!-- Users Section -->
            <div id="users" class="section">
                <button class="btn btn-primary" onclick="showForm('userForm')">+ Pengguna Baru</button>
                
                <table style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Admin</td>
                            <td>admin@blog.com</td>
                            <td>Administrator</td>
                            <td><span style="background-color: #27ae60; color: white; padding: 5px 10px; border-radius: 3px;">Aktif</span></td>
                            <td>
                                <button class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Edit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div id="userForm" style="display: none; margin-top: 30px; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2>Pengguna Baru</h2>
                    <hr style="margin: 20px 0;">
                    <form id="addUserForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="full_name" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="Masukkan email" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" placeholder="Masukkan password" required>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select name="role">
                                    <option>Editor</option>
                                    <option>Author</option>
                                    <option>Contributor</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Tambah Pengguna</button>
                        <button type="button" class="btn btn-secondary" onclick="hideForm('userForm')">Batal</button>
                    </form>
                </div>
            </div>

            <!-- Settings Section -->
            <div id="settings" class="section">
                <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2>Pengaturan Umum</h2>
                    <hr style="margin: 20px 0;">
                    <form id="settingsForm">
                        <div class="form-group">
                            <label>Email Admin</label>
                            <input type="email" name="admin_email" value="admin@blog.com">
                        </div>
                        <div class="form-group">
                            <label>Jumlah Posting per Halaman</label>
                            <input type="number" name="posts_per_page" value="10">
                        </div>
                        <div class="form-group">
                            <label>Zona Waktu</label>
                            <select name="timezone">
                                <option selected>Asia/Jakarta (UTC+7)</option>
                                <option>Asia/Surabaya (UTC+7)</option>
                                <option>Asia/Pontianak (UTC+7)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="allow_comments" checked> Izinkan Komentar
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="moderate_comments" checked> Moderasi Komentar
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan Pengaturan</button>
                    </form>
                </div>
            </div>

            <!-- SEO Section -->
            <div id="seo" class="section">
                <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2>Pengaturan SEO</h2>
                    <hr style="margin: 20px 0;">
                    <form id="seoForm">
                        <div class="form-group">
                            <label>Meta Deskripsi Website</label>
                            <textarea name="meta_description" placeholder="Deskripsi singkat untuk search engine"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Kata Kunci (Keywords)</label>
                            <textarea name="keywords" placeholder="Pisahkan dengan koma"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Google Analytics ID</label>
                            <input type="text" name="ga_id" placeholder="GA-XXXXXXXXX">
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="enable_sitemap" checked> Aktifkan XML Sitemap
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="enable_rss" checked> Aktifkan RSS Feed
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan SEO Settings</button>
                    </form>
                </div>
            </div>

            <!-- Backup Section -->
            <div id="backup" class="section">
                <div style="background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h2>Backup & Restore</h2>
                    <hr style="margin: 20px 0;">
                    
                    <h3>Buat Backup</h3>
                    <p style="color: #7f8c8d; margin-bottom: 15px;">Backup semua data website Anda</p>
                    <button type="button" class="btn btn-primary" id="backupBtn">📥 Backup Sekarang</button>

                    <hr style="margin: 30px 0;">

                    <h3>Backup Terbaru</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Ukuran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>16 Sept 2026 - 10:30</td>
                                <td>25 MB</td>
                                <td><span style="background-color: #27ae60; color: white; padding: 5px 10px; border-radius: 3px;">Selesai</span></td>
                                <td>
                                    <button class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Download</button>
                                    <button class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;">Restore</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo $theme_url; ?>/admin-script.js"></script>
</body>
</html>
