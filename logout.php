<?php
session_start();
include 'config.php';

$uid     = $_SESSION['uid'] ?? 0;
$halaman = basename($_SERVER['PHP_SELF']);

if ($uid) {
    mysqli_query($conn, "
        UPDATE user_log 
        SET 
            action  = 'offline',
            appname = '$halaman',
            tanggal = NOW()
        WHERE uid = '$uid'
    ");
}

session_destroy();
header("location: index.php");
exit;
?>
