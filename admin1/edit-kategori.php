<?php
include '../config.php';
include '../db.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM kategori WHERE id='$id'");
$d = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Kategori TKPI</title>
</head>
<body>

<h2>Edit Kategori Jurusan Teknik Kapal Penangkapan Ikan</h2>

<form method="POST">
    <label>Nama Kategori TKPI</label><br>
    <input type="text" name="nama_kategori" value="<?php echo $d['nama_kategori']; ?>"><br><br>

    <button type="submit" name="update">Update</button>
</form>

<?php
if (isset($_POST['update'])) {

    $nama = $_POST['nama_kategori'];

    mysqli_query($conn, "UPDATE kategori SET nama_kategori='$nama' WHERE id='$id'");

    echo "<script>alert('Kategori TKPI berhasil diupdate'); window.location='kategori.php';</script>";
}
?>

</body>
</html>