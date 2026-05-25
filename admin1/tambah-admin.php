<?php
session_start();

include '../config.php';
include '../db.php';

/*
=========================
TRACE
=========================
*/
trace_event("OPEN PAGE admin/tambah-admin.php");

if(isset($_POST['tambah-admint'])){

    trace_event("POST form submitted");

    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $level    = $_POST['level'];
    $uid      = $_POST['uid'];

    trace_event("DATA INPUT | nama=$nama | username=$username | level=$level | uid=$uid");

    /*
    =========================
    CEK USER DUPLIKAT
    =========================
    */
    $cek = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");

    if(mysqli_num_rows($cek) > 0){

        trace_event("USERNAME DUPLIKAT: $username");

        echo "<script>
            alert('Username sudah digunakan!');
            window.location.href = 'tambah-admin.php';
        </script>";

        exit;
    }

    /*
    =========================
    INSERT USER
    =========================
    */
    $query_insert = mysqli_query($conn, "
        INSERT INTO user
        (nama, username, password, level, uid)
        VALUES
        (
            '$nama',
            '$username',
            '$password',
            '$level',
            '$uid'
        )
    ");

    trace_event("RUN QUERY INSERT USER");

    if($query_insert){

        trace_event("INSERT BERHASIL: $username");

        echo "<script>
            alert('Data Berhasil Ditambahkan!');
            window.location.href = 'data-user.php';
        </script>";

    }else{

        trace_event("INSERT GAGAL: ".mysqli_error($conn));

        echo "Gagal kirim data ke server! " . mysqli_error($conn);
    }
}
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tambah Admin & Petugas</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/scss/style.css">
</head>

<body>

<?php include 'sidebar.php'; ?>

<div id="right-panel" class="right-panel">

<?php include 'header.php'; ?>

<div class="content mt-3">

    <div class="col-lg-6 mx-auto">

        <div class="card">

            <div class="card-header">
                <strong>Tambah Admin & Petugas</strong>
            </div>

            <div class="card-body">

                <form method="POST">

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Level</label><br>

                        <label>
                            <input type="radio" name="level" value="admin" checked> Admin
                        </label>

                        <label style="margin-left:10px;">
                            <input type="radio" name="level" value="petugas"> Petugas
                        </label>
                        <label style="margin-left:10px;">
                            <input type="radio" name="level" value="peminjam"> Peminjam
                        </label>
                    </div>

                    <div class="form-group">
                        <label>UID</label><br>

                        <label>
                            <input type="radio" name="uid" value="2026" checked> 2026 (Admin)
                        </label>

                        <label style="margin-left:10px;">
                            <input type="radio" name="uid" value="2025"> 2025 (Petugas)
                        </label>
                         <label style="margin-left:10px;">
                            <input type="radio" name="uid" value="2027"> 2027 (Peminjam)
                        </label>
                    </div>

                    <button type="submit" name="tambah-admint" class="btn btn-success">
                        Tambah
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>