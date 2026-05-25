<?php
session_start();
include '../config.php';
include '../db.php';

trace_event("OPEN PAGE admin/tambah-barang.php");

$kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY kategori ASC");
trace_event("LOAD kategori dari database");

if(isset($_POST['tambah-barang'])){
    trace_event("POST form submitted");

    $nama_barang = $_POST['nama_barang'];
    $stok_barang = $_POST['stok_barang'];
    $kategori_id = $_POST['kategori_id'];

    trace_event("DATA INPUT | nama_barang=$nama_barang | stok_barang=$stok_barang | kategori_id=$kategori_id");

    $file_name = str_replace(" ","_",$_FILES['gambar_barang']['name']);
    $file_size = $_FILES['gambar_barang']['size'];
    $file_type = $_FILES['gambar_barang']['type'];
    $tmp_name  = $_FILES['gambar_barang']['tmp_name'];
    $max_size  = 2000000;
    $extension = substr($file_name, strpos($file_name, '.') + 1);

    if(isset($file_name) && !empty($file_name)){
        trace_event("File upload detected: $file_name, type: $file_type, size: $file_size");

        if(($extension == "jpg" || $extension == "jpeg" || $extension == "gif" || $extension == "png") 
            && ($file_type == "image/jpeg" || $file_type == "image/png" || $file_type=="image/gif") 
            && ($file_size <= $max_size)){

            trace_event("File valid: extension ok, size ok");

            $location = "../assets/img/uploads/";
            if (move_uploaded_file($tmp_name, $location.$file_name)) {
                trace_event("File berhasil di-upload ke $location$file_name");

                $query_insert = mysqli_query($conn,"INSERT INTO tbl_barang 
                    (nama_barang, gambar_barang, stok_barang, kategori_id) 
                    VALUES ('$nama_barang', '$file_name', '$stok_barang', '$kategori_id')");

                trace_event("RUN QUERY INSERT INTO tbl_barang");

                if($query_insert){
                    trace_event("INSERT tbl_barang BERHASIL: $nama_barang");
                    echo "<script>alert('Berhasil Ditambahkan');</script>";
                    echo "<script>window.location.href = 'data-barang.php';</script>";
                }else{
                    trace_event("GAGAL INSERT tbl_barang: ".mysqli_error($conn));
                    echo "<script>alert('Gagal Ditambahkan ke Database');</script>";
                }
            }else{
                trace_event("GAGAL upload file ke direktori $location");
                echo "<script>alert('Gagal Upload ke direktori');</script>";
            }
        }else{
            trace_event("File tidak sesuai format atau ukuran");
            echo "<script>alert('File tidak sesuai');</script>";
        }
    }else{
        trace_event("Tidak ada file yang di-upload");
    }
}
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Tambah Barang</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/scss/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>

<body>
<?php include 'sidebar.php'; ?>
<div id="right-panel" class="right-panel">
    <?php include 'header.php'; ?>
    <div class="breadcrumbs">
        <div class="col-sm-6">
            <div class="page-header float-left">
                <div class="page-title" style="padding: 20px 0;">
                    <h1 style="display: unset;">Tambah Barang</h1>
                    <a href="data-barang.php" class="btn btn-info btn-sm" style="margin-left: 20px;">
                        <i class="fa fa-search"></i>
                        Lihat Data Barang
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">Barang</a></li>
                        <li class="active">Tambah Barang</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header"><strong>Tambah Data Barang </strong></div>
                       <form class="card-body card-block"
    action=""
    method="POST"
    enctype="multipart/form-data">

    <!-- Nama Barang -->
    <div class="form-group">

        <label for="nama" class="form-control-label">
            Nama Barang
        </label>

        <input type="text"
            id="nama"
            name="nama_barang"
            placeholder="contoh: Mesin Diesel"
            class="form-control"
            required>

    </div>

    <!-- Kategori -->
    <div class="form-group">

        <label class="form-control-label">
            Kategori Barang
        </label>

        <select name="kategori_id"
            class="form-control"
            required>

            <option value="">
                -- Pilih Kategori TKPI --
            </option>

            <option value="1">
                Operasional Kapal Perikanan
            </option>

            <option value="2">
                Kelistrikan
            </option>

            <option value="3">
                Mesin Diesel dan Bensin Kapal
            </option>

            <option value="4">
                Mesin Las Listrik & Asetilin
            </option>

            <option value="5">
                Gerinda Tangan & Bor Tangan
            </option>

            <option value="6">
                Peralatan Bengkel Umum
            </option>

            <option value="7">
                Topeng Las & Kacamata Las
            </option>

            <option value="8">
                Multimeter / Avometer
            </option>

            <option value="9">
                Kabel, Sakelar, dan Fitting
            </option>

            <option value="10">
                Motor Listrik & Generator
            </option>

            <option value="11">
                Kompresor, Kondensor, dan Evaporator
            </option>

            <option value="12">
                Pipa Tembaga & Alat Flaring
            </option>

            <option value="13">
                Radio Komunikasi Kapal
            </option>

            <option value="14">
                Alat Pemadam Api Ringan (APAR)
            </option>

        </select>

    </div>

    <!-- Upload Gambar -->
    <div class="form-group">

        <label for="gambar"
            class="form-control-label">

            Upload Foto Barang

        </label>

        <input type="file"
            id="gambar"
            name="gambar_barang"
            class="form-control"
            required>

    </div>

    <!-- Jumlah Barang -->
    <div class="form-group">

        <label for="stok"
            class="form-control-label">

            Jumlah Barang

        </label>

        <input type="number"
            id="stok"
            name="stok_barang"
            placeholder="contoh: 10"
            class="form-control"
            required>

    </div>

    <!-- Tombol Simpan -->
    <div class="form-group text-right">

        <button type="submit"
            class="btn btn-success"
            name="tambah-barang">

            <i class="fa fa-save"></i>
            Simpan Barang

        </button>

    </div>

</form>