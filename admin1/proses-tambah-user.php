<?php

include '../koneksi.php';

$nama     = $_POST['nama'];
$username = $_POST['username'];
$password = md5($_POST['password']);
$level    = $_POST['level'];

$query = mysqli_query($koneksi, "
    INSERT INTO user
    VALUES (
        NULL,
        '$nama',
        '$username',
        '$password',
        '$level'
    )
");

if($query){

    echo "
    <script>
        alert('User berhasil ditambahkan');
        window.location='data-user.php';
    </script>
    ";

}else{

    echo "
    <script>
        alert('User gagal ditambahkan');
        window.location='tambah-user.php';
    </script>
    ";

}
?>