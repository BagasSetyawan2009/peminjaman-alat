# 🧹 Aplikasi Peminjaman Kebersihan Sekolah

![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple)
![jQuery](https://img.shields.io/badge/jQuery-Latest-green)
![Status](https://img.shields.io/badge/Status-Development-success)

---

## 🎶 Pengenalan

**Aplikasi Peminjaman Kebersihan Sekolah** adalah sistem berbasis web yang digunakan untuk mengelola proses peminjaman alat kebersihan di lingkungan sekolah. Aplikasi ini dibangun menggunakan **PHP**, **Bootstrap**, **Font Awesome**, dan **jQuery** agar tampil modern, ringan, dan mudah digunakan.

Aplikasi ini membantu petugas dan siswa dalam melakukan pencatatan peminjaman, pengembalian, serta pembuatan laporan secara otomatis.

---

## ✨ Fitur Utama

* 🔐 Login & Register
* 👥 Manajemen User
* 🧹 Manajemen Alat
* 🗂️ Manajemen Kategori
* 📦 Peminjaman & Pengembalian
* 📝 Log Aktivitas
* 🖨️ Cetak Laporan Semua Data
* ✅ Menyetujui Peminjaman
* 🔎 Monitoring Pengembalian
* 📋 Melihat Daftar Alat
* ✍️ Mengajukan Peminjaman
* 🔄 Mengembalikan Pinjaman
* 🚪 Logout

Semua fitur mendukung operasi **CRUD (Create, Read, Update, Delete)**.

---

## 👥 Data Account Default

### 🔑 Admin

* **Username:** admin
* **Password:** admin

### 🔑 Petugas

* **Username:** petugas
* **Password:** petugas

### 🔑 Peminjam

Data peminjam tidak disediakan secara default. Setiap peminjam wajib melakukan **registrasi terlebih dahulu** sebelum mengajukan peminjaman.

> ⚠️ Semua password menggunakan hash `md5()`.

---

## 🛠️ Persyaratan Sistem

* PHP **8.2+**
* Web Browser (Chrome, Brave, Firefox, Edge, Safari, Opera)
* Text Editor (VS Code, Notepad++, dll)
* XAMPP (Apache & MySQL / MariaDB)
* Koneksi Internet (Disarankan)

---

## 🚀 Cara Instalasi

1. Download atau clone repository ini.
2. Buat folder bernama `pinjam_barang_main`.
3. Letakkan folder di:

   ```
   C:/xampp/htdocs/
   ```
4. Buat database dengan nama:

   ```
   db_pinjam_barang
   ```
5. Import file database:

   ```
   Database/db_pinjam_barang.sql
   ```
6. Sesuaikan konfigurasi di file `koneksi.php` jika perlu.
7. Jalankan aplikasi melalui browser:

   ```
   http://localhost/pinjam_barang_main
   ```

---

## ☕ Referensi

* [Bootstrap](https://getbootstrap.com)
* [jQuery](https://jqueryui.com/)
* [Font Awesome](https://fontawesome.com)

---

## 📝 Rekap Fitur Aplikasi

* [x] Login
* [x] Register
* [x] Logout
* [x] Privileges
* [x] CRUD
* [x] Print Laporan
* [x] Dokumentasi

---

## 📄 License & Copyright

Copyright © 2026
**Arsyaandyou**

Permission is hereby granted to use this project for educational and non-commercial purposes.

You may modify and distribute this project with credit to the original author.
Commercial use is strictly prohibited without written permission from the author.

If you use this project, please include:

> Developed by arsyaandyou.id — Aplikasi Peminjaman Kebersihan Sekolah

---

✨ Terima kasih sudah menggunakan Aplikasi Peminjaman Kebersihan Sekolah. Semoga bermanfaat dan membantu proses administrasi di sekolah Anda.
