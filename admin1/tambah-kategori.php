<?php
    session_start();
	include '../config.php';
	if(isset($_POST['tambah-kategori'])){

		$kategori			= $_POST['nama_kategori'];
		$deskripsi 		    = $_POST['deskripsi'];

		$query_insert   = mysqli_query($conn,"INSERT INTO kategori (kategori, desc1) VALUES ('$kategori', '$deskripsi')");
        if($query_insert){
            echo "<script>alert('Data Berhasil Dikirim!');</script>";
            echo "<script>window.location.href = 'data-kategori.php';</script>";
        }else{
            echo "Gagal hapus data ke server!;";
        } 
    }
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Tambah Kategori</title>
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
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="assets/scss/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body>
    <?php
        include 'sidebar.php';
    ?>
    <div id="right-panel" class="right-panel">
        <?php
            include 'header.php'; 
        ?>
                <div class="breadcrumbs">
            <div class="col-sm-6">
                <div class="page-header float-left">
                    <div class="page-title" style="padding: 20px 0;">
                        <h1 style="display: unset;">Tambah Kategori</h1>
                        <a href="data-kategori.php" class="btn btn-info btn-sm" style="margin-left: 20px;">
                                <i class="fa fa-search"></i>
                                Lihat Data Kategori
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
                            <li class="active">Tambah Kategori</li>
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
                          <div class="card-header"><strong>Tambah Data Kategori </strong></div>
                          
                          <form class="card-body card-block" action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nama" class=" form-control-label">Nama Kategori</label>
                                <input type="text" id="nama" name="nama_kategori" placeholder="contoh: Pembersih Lantai" class="form-control"> 
                            </div>
                            <div class="form-group">
                                <label for="stok" class=" form-control-label">Deskripsi</label>
                                <input type="text" id="stok" name="deskripsi" placeholder="contoh: Khusus Untuk Pembersih Lantai" class="form-control"> 
                            </div>
                            <button type="submit" class="btn btn-success" name="tambah-kategori">
                                <i class="fa fa-check"></i>
                                Tambah
                            </button>
                        </form>
                      </div>

                </div>
            </div>
        </div>

    </div>

    
<script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>