<?php
session_start();

include '../config.php';
include '../db.php';

trace_event("OPEN PAGE petugas/permintaan.php");

/*
========================================
CEK LOGIN
========================================
*/

if(!isset($_SESSION['username'])){
    trace_event("SESSION username tidak ditemukan");
    header("location: ../index.php");
    exit;
}

/*
========================================
PROSES PERSETUJUAN / PENOLAKAN
========================================
*/

if(isset($_GET['mode']) && isset($_GET['id'])){

    $id   = mysqli_real_escape_string($conn, $_GET['id']);
    $mode = $_GET['mode'];

    /*
    ========================================
    AMBIL DATA REQUEST
    ========================================
    */

    $ambil = mysqli_query($conn,"
        SELECT * FROM tbl_request
        WHERE id='$id'
    ");

    $dataRequest = mysqli_fetch_array($ambil);

    if($dataRequest){

        $nama_barang = $dataRequest['nama_barang'];
        $jumlah      = $dataRequest['jml_barang'];

        /*
        ========================================
        JIKA DISETUJUI
        ========================================
        */

        if($mode == "terima"){

            /*
            ========================================
            CEK STOK BARANG
            ========================================
            */

            $cekBarang = mysqli_query($conn,"
                SELECT * FROM tbl_barang
                WHERE nama_barang='$nama_barang'
            ");

            $barang = mysqli_fetch_array($cekBarang);

            if($barang){

                $stokSekarang = $barang['stok'];

                if($stokSekarang >= $jumlah){

                    /*
                    ========================================
                    KURANGI STOK
                    ========================================
                    */

                    $stokBaru = $stokSekarang - $jumlah;

                    mysqli_query($conn,"
                        UPDATE tbl_barang
                        SET stok='$stokBaru'
                        WHERE nama_barang='$nama_barang'
                    ");

                    /*
                    ========================================
                    UPDATE STATUS
                    ========================================
                    */

                    mysqli_query($conn,"
                        UPDATE tbl_request
                        SET status='Disetujui'
                        WHERE id='$id'
                    ");

                    trace_event("REQUEST DISETUJUI id=".$id);

                    echo "
                    <script>
                        alert('Peminjaman disetujui');
                        window.location='permintaan.php';
                    </script>
                    ";

                }else{

                    echo "
                    <script>
                        alert('Stok barang tidak mencukupi');
                        window.location='permintaan.php';
                    </script>
                    ";

                }

            }

        }

        /*
        ========================================
        JIKA DITOLAK
        ========================================
        */

        elseif($mode == "tolak"){

            mysqli_query($conn,"
                UPDATE tbl_request
                SET status='Ditolak'
                WHERE id='$id'
            ");

            trace_event("REQUEST DITOLAK id=".$id);

            echo "
            <script>
                alert('Peminjaman ditolak');
                window.location='permintaan.php';
            </script>
            ";
        }

    }

}
?>

<!doctype html>
<html class="no-js" lang="">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Petugas - Peminjaman Alat Kebersihan</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="assets/scss/style.css">

</head>

<body>

<?php include 'sidebar.php'; ?>

<div id="right-panel" class="right-panel">

<?php include 'header.php'; ?>

<div class="breadcrumbs">

    <div class="col-sm-4">

        <div class="page-header float-left">

            <div class="page-title">

                <h1>
                    Permintaan Peminjaman

                    <a href="permintaan.php"
                       class="btn btn-info btn-sm">

                        <i class="fa fa-refresh"></i>
                        Refresh

                    </a>

                </h1>

            </div>

        </div>

    </div>

</div>

<div class="content mt-3">

<div class="animated fadeIn">

<div class="row">

<div class="col-md-12">

<div class="card">

<div class="card-header">

    <strong class="card-title">
        Permintaan Peminjaman
    </strong>

</div>

<div class="card-body">

<table id="bootstrap-data-table"
       class="table table-striped table-bordered">

<thead>

<tr>

    <th>No</th>
    <th>Nama Barang</th>
    <th>Nama Peminjam</th>
    <th>Jabatan/Kelas</th>
    <th>Jumlah</th>
    <th>Tanggal Pinjam</th>
    <th>Tanggal Kembali</th>
    <th>Status</th>
    <th>Opsi</th>

</tr>

</thead>

<tbody>

<?php

$query = mysqli_query($conn,"
    SELECT * FROM tbl_request
    ORDER BY id DESC
");

if($query){

    $no = 1;

    while($data = mysqli_fetch_array($query)){

        $id            = $data['id'];
        $nama_barang   = $data['nama_barang'];
        $peminjam      = $data['peminjam'];
        $level         = $data['level'];
        $jml_barang    = $data['jml_barang'];
        $tgl_pinjam    = $data['tgl_pinjam'];
        $tgl_kembali   = $data['tgl_kembali'];

        /*
        ========================================
        STATUS
        ========================================
        */

        $status = isset($data['status'])
            ? $data['status']
            : 'Menunggu';

?>

<tr>

<td><?php echo $no++; ?></td>

<td><?php echo $nama_barang; ?></td>

<td><?php echo $peminjam; ?></td>

<td><?php echo $level; ?></td>

<td><?php echo $jml_barang; ?></td>

<td><?php echo $tgl_pinjam; ?></td>

<td><?php echo $tgl_kembali; ?></td>

<td>

<?php

if($status == "Menunggu"){

    echo '<span class="badge badge-warning">Menunggu</span>';

}elseif($status == "Disetujui"){

    echo '<span class="badge badge-success">Disetujui</span>';

}else{

    echo '<span class="badge badge-danger">Ditolak</span>';

}

?>

</td>

<td>

<?php if($status == "Menunggu"){ ?>

<div class="btn-group">

<a href="permintaan.php?mode=terima&id=<?php echo $id; ?>"
   class="btn btn-success btn-sm btn-terima">

    <i class="fa fa-check"></i>
    Terima

</a>

<a href="permintaan.php?mode=tolak&id=<?php echo $id; ?>"
   class="btn btn-danger btn-sm btn-tolak">

    <i class="fa fa-times"></i>
    Tolak

</a>

</div>

<?php }else{ ?>

<button class="btn btn-secondary btn-sm" disabled>
    Sudah Diproses
</button>

<?php } ?>

</td>

</tr>

<?php
    }
}else{
?>

<tr>

<td colspan="9">
    Data kosong
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/main.js"></script>

<script src="assets/js/lib/data-table/datatables.min.js"></script>
<script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>

<script>

$(document).ready(function () {

    $('#bootstrap-data-table').DataTable();

});

</script>

<script>

document.querySelectorAll('.btn-terima, .btn-tolak')
.forEach(function(btn){

    btn.addEventListener('click', function(e){

        if(this.classList.contains('disabled')){
            e.preventDefault();
            return false;
        }

        this.classList.add('disabled');

        this.innerHTML =
            '<i class="fa fa-spinner fa-spin"></i> Proses...';

    });

});

</script>

</body>
</html>