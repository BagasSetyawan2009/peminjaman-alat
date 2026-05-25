<?php
session_start();
include '../config.php';
include '../db.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM tbl_pinjam WHERE id='$id'
"));

$id_barang = $data['id_barang'];
$jml = $data['jml_barang'];

/* update status */
mysqli_query($conn,"
    UPDATE tbl_pinjam SET status='approved'
    WHERE id='$id'
");

/* kurangi stok */
mysqli_query($conn,"
    UPDATE tbl_barang 
    SET stok_barang = stok_barang - $jml
    WHERE id='$id_barang'
");

header("location: permintaan.php");
?>