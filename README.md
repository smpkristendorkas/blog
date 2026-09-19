# Blog SMP Kristen Dorkas

Situs statis sederhana untuk SMP Kristen Dorkas.

Cara menjalankan secara lokal:

- Buka folder proyek dan buka `index.html` di browser.
- Untuk pengembangan, gunakan extension "Live Server" di VS Code atau jalankan server sederhana:

```powershell
# di Windows PowerShell
python -m http.server 8000
# lalu buka http://localhost:8000
```

File penting:
- index.html — beranda
- about.html — halaman tentang
- news.html — berita
- contact.html — kontak
- styles.css — styling
- script.js — interaksi kecil menu

Versi WordPress:
- Folder tema WordPress siap pakai berada di `wp-content/themes/smp-kristen-dorkas/`
- Salin folder tersebut ke folder `wp-content/themes` di instalasi WordPress Anda
- Aktifkan tema di dashboard WordPress: Appearance > Themes

Tema ini menyesuaikan desain dari situs statis menjadi tema WordPress dengan:
- header/footer dinamis
- menu WordPress
- halaman depan (front-page.php)
- halaman artikel dan halaman umum
- slider hero dan layout blog responsif

Ingin saya tambahkan versi yang lebih lengkap untuk halaman profil sekolah, galeri, atau form kontak WordPress?