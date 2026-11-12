GOGREEN — FRONTEND ASLI + BACKEND PHP/MYSQL

PENTING: Paket ini mempertahankan halaman frontend dari ZIP yang kamu kirim.
File HTML/CSS dan aset halaman lama tidak diganti dengan desain frontend paket backend.
Folder api/, config/, database.sql dan setup_admin.php ditambahkan untuk backend.

CARA INSTALL XAMPP
1. Ekstrak folder ini ke C:\xampp\htdocs\gogreen
2. Jalankan Apache dan MySQL dari XAMPP.
3. Buka http://localhost/phpmyadmin lalu Import database.sql.
4. Pastikan config/database.php memakai host 127.0.0.1, dbname gogreen,
   username root, password kosong (default XAMPP).
5. Buka http://localhost/gogreen/setup_admin.php untuk membuat admin.
6. Setelah admin berhasil dibuat, HAPUS setup_admin.php.
7. Buka http://localhost/gogreen/Login.html untuk login.

LOGIN
Login.html kini memakai api/auth/login.php. Register tersedia di Register.html.
Akun admin awal: admin@gogreen.local / AdminGoGreen123!
Ganti password admin setelah login.

STATUS INTEGRASI
- Autentikasi login dan register: sudah dihubungkan ke PHP session + MySQL.
- Endpoint laporan, pengumpulan, reward, dan admin: tersedia di folder api/.
- Halaman frontend lama selain login masih perlu disambungkan satu per satu ke endpoint.
  Tampilan/tautan halaman lama dipertahankan; jangan anggap tombol/angka contoh sebagai
  data database yang sudah dinamis sampai integrasi halaman tersebut selesai.
- Google OAuth tidak disediakan; tombol Google lama masih memerlukan konfigurasi OAuth
  provider dan callback tersendiri.
- Jalankan melalui http://localhost/gogreen/, jangan buka file HTML dengan double-click.
