<?php
session_start();
include '../config.php';
include '../db.php';

$id = $_GET['id'];

mysqli_query($conn,"
    UPDATE tbl_pinjam SET status='rejected'
    WHERE id='$id'
");

header("location: permintaan.php");
?>