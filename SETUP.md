# Setup Blog - Panduan Lengkap

Blog ini telah diintegrasikan dengan Admin Panel yang lengkap untuk mengelola posting, media, tampilan, dan berbagai fitur lainnya.

## 📋 Persyaratan

- **PHP** >= 7.4
- **MySQL** >= 5.7 atau **MariaDB**
- Server lokal (**XAMPP**, **WAMP**, **LAMP**, dll)
- Browser modern (Chrome, Firefox, Safari, Edge)

---

## 🚀 1. Setup Database

### Langkah 1: Buka phpMyAdmin
1. Jalankan XAMPP/WAMP/LAMP
2. Buka browser dan akses `http://localhost/phpmyadmin`
3. Login dengan username `root` (default tanpa password)

### Langkah 2: Import Database
1. Klik menu **"Import"** di phpMyAdmin
2. Pilih file `database-setup.sql` dari folder project
3. Klik **"Go"** untuk menjalankan script

**Atau via Command Line:**
```bash
mysql -u root -p < database-setup.sql
```

---

## ⚙️ 2. Konfigurasi Database

1. Buka file `config.php` di root folder project
2. Sesuaikan konfigurasi database:
   ```php
   define('DB_HOST', 'localhost');    // Host database
   define('DB_USER', 'root');         // Username database
   define('DB_PASS', '');             // Password database
   define('DB_NAME', 'blog_db');      // Nama database
   ```

3. Simpan file

---

## 📁 3. File Structure

```
Blog/
├── admin.html                    # Admin Panel (HTML standalone)
├── admin-styles.css              # CSS untuk Admin Panel
├── admin-script.js               # JavaScript untuk Admin Panel
├── api.php                       # Backend API untuk Admin Panel
├── config.php                    # Konfigurasi database
├── database-setup.sql            # Script SQL setup database
│
├── index.html                    # Halaman utama
├── about.html                    # Halaman tentang
├── contact.html                  # Halaman kontak
├── news.html                     # Halaman berita
│
├── styles.css                    # CSS utama
├── script.js                     # JavaScript utama
│
├── uploads/                      # Folder untuk upload media
│   └── media/                    # Subfolder untuk gambar
│
├── wp-content/themes/
│   └── smp-kristen-dorkas/
│       ├── admin.php             # Admin Panel (PHP - WordPress version)
│       ├── header.php            # Header template
│       ├── footer.php            # Footer template
│       ├── index.php             # Template utama
│       ├── single.php            # Template single post
│       └── ...
```

---

## 🔑 4. Login Admin Panel

### Akses Admin Panel:

**Versi HTML (Standalone):**
- URL: `http://localhost/Blog/admin.html`
- Username: `Admin` (default, tidak perlu login)
- Password: Langsung bisa masuk

**Versi PHP (WordPress):**
- URL: `http://localhost/Blog/wp-content/themes/smp-kristen-dorkas/admin.php`
- Memerlukan WordPress authentication

---

## 📝 5. Fitur Admin Panel

### Dashboard
Lihat statistik:
- Total posting
- Total pengunjung
- Komentar menunggu moderasi
- Total media

### 📝 Posting
- ✅ Tambah posting baru
- ✅ Edit posting
- ✅ Hapus posting
- ✅ Ubah status (Draft/Dipublikasikan)

### 🖼️ Media
- ✅ Upload foto/gambar
- ✅ Lihat semua media
- ✅ Hapus media

### 🎨 Penampilan
- ✅ Edit judul website
- ✅ Edit deskripsi
- ✅ Upload logo
- ✅ Ubah warna tema
- ✅ Pilih font

### 🧩 Widget
- ✅ Kelola widget sidebar
- ✅ Kelola widget footer

### 📋 Menu
- ✅ Buat menu
- ✅ Edit menu
- ✅ Hapus menu

### 👥 Pengguna
- ✅ Tambah pengguna
- ✅ Edit pengguna
- ✅ Ubah role

### ⚙️ Pengaturan
- ✅ Email admin
- ✅ Zona waktu
- ✅ Izinkan/moderasi komentar

### 🔍 SEO
- ✅ Meta deskripsi
- ✅ Keywords
- ✅ Google Analytics
- ✅ Sitemap & RSS

### 💾 Backup
- ✅ Buat backup data
- ✅ Download backup
- ✅ Restore data

---

## 🔗 6. Integrasi dengan Blog

### Link Admin di Halaman Utama

Admin link sudah ditambahkan di navigasi halaman utama (`index.html`):
```html
<a href="admin.html" class="admin-link">🔐 Admin</a>
```

Klik link tersebut untuk masuk ke Admin Panel.

---

## 🛠️ 7. API Backend

Semua fitur Admin Panel menggunakan **REST API** yang terletak di `api.php`.

### Endpoint Contoh:

**Get Posts:**
```
GET /api.php?action=get_posts
```

**Add Post:**
```
POST /api.php?action=add_post
Content-Type: application/json

{
    "title": "Judul Post",
    "category": "Tutorial",
    "content": "Isi konten...",
    "tags": "blog, tutorial",
    "status": "Dipublikasikan"
}
```

**Upload Media:**
```
POST /api.php?action=upload_media
Content-Type: multipart/form-data

file: [binary file data]
```

---

## 🔐 8. Keamanan

### Tips Keamanan:

1. **Ubah Password Default**
   - Di WordPress: Settings → General
   - Di MySQL: Ganti password user `root`

2. **Jangan expose `.env` atau password**
   - Tambahkan ke `.gitignore`

3. **Validasi Input**
   - Semua input di-sanitize di backend (`api.php`)

4. **HTTPS di Production**
   - Gunakan SSL certificate

5. **Database Backup Regular**
   - Backup database secara berkala
   - Gunakan fitur Backup di Admin Panel

---

## ❌ Troubleshooting

### Error: "Connection Failed"
- Pastikan MySQL sudah berjalan
- Cek konfigurasi di `config.php`
- Pastikan database sudah dibuat

### Error: "No Posts Found"
- Import `database-setup.sql` terlebih dahulu
- Cek koneksi database

### Media Upload Tidak Bekerja
- Pastikan folder `uploads/` ada (buat manual jika perlu)
- Set permission folder ke `755` atau `777`
- Cek max upload size di PHP settings

### Admin Panel Tidak Muncul
- Pastikan `admin.html`, `admin-styles.css`, dan `admin-script.js` ada
- Buka browser console (F12) untuk melihat error JavaScript

---

## 📚 7. File Dokumentasi

- `README.md` - Dokumentasi umum project
- `SETUP.md` - File ini (panduan setup)
- `database-setup.sql` - Script SQL database
- `config.php` - Konfigurasi database

---

## 🎉 Selesai!

Blog Anda sudah siap digunakan dengan Admin Panel yang lengkap.

### Langkah Selanjutnya:
1. ✅ Akses Admin Panel: `http://localhost/Blog/admin.html`
2. ✅ Tambahkan posting baru
3. ✅ Upload media/foto
4. ✅ Customize tampilan
5. ✅ Publish di web hosting

---

## 📞 Support

Jika ada pertanyaan atau masalah, silakan:
- Cek dokumentasi di atas
- Buka browser console (F12) untuk error messages
- Cek logs di server

---

**Happy Blogging! 🚀**
