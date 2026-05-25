<?php
$conn = mysqli_connect("localhost", "root", "", "db_pinjam_barang");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
