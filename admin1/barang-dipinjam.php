<?php
    session_start();
    include '../config.php';
    include '../db.php';
    trace_event("OPEN PAGE admin/barang-dipinjam.php");
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Peminjaman Alat kebersihan Sekolah</title>
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
    <link rel="stylesheet" href="assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="assets/scss/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

</head>
<body>
        
    <?php
        include 'sidebar.php';
        trace_event("LOAD sidebar.php");
    ?>

    <div id="right-panel" class="right-panel">

        <?php
            include 'header.php';
            trace_event("LOAD header.php");
        ?>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Barang Dipinjam 
                            <a href="barang-dipinjam.php" class="btn btn-info btn-sm">
                                <i class="fa fa-refresh"></i>
                                Refresh
                            </a>
                        </h1>

                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Peminjaman</a></li>
                            <li class="active">Barang Dipinjam</li>
                        </ol>
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
                            <strong class="card-title">Barang Dipinjam</strong>
                                <a href="javascript:void(0);" onclick="cetakLaporan()" class="btn btn-success btn-sm disabled"
                                    style="margin-left: 20px;">
                                    <i class="fa fa-print"></i>
                                    Cetak Laporan
                                </a>
                        </div>
                        <div class="card-body">
                  <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Nama Barang</th>
                        <th>Nama Peminjam</th>
                        <th>Jabatan/Kelas</th>
                        <th>Jumlah Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Keteragan</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php

                            trace_event("RUN QUERY tbl_pinjam (ADMIN)");

                            $query = mysqli_query($conn,"SELECT * FROM tbl_pinjam ORDER BY  id DESC ");

                            if(!$query){
                                trace_event("QUERY FAILED tbl_pinjam : ".mysqli_error($conn));
                            }

                            if($query){
                                trace_event("QUERY SUCCESS tbl_pinjam rows=".mysqli_num_rows($query));
                                $no = 1;
                                while ($data=mysqli_fetch_array($query)) {
                                    $id          = $data['id'];
                                    $nama_barang = $data['nama_barang'];
                                    $peminjam    = $data['peminjam'];
                                    $level       = $data['level'];
                                    $jml_barang  = $data['jml_barang'];
                                    $tgl_pinjam  = $data['tgl_pinjam'];
                                    $tgl_kembali = $data['tgl_kembali'];

                                    trace_event("FETCH tbl_pinjam id=$id peminjam=$peminjam barang=$nama_barang");
                            ?>
                                <tr>
                                    <td><?php echo $no;?></td>
                                    <td><?php echo $nama_barang;?></td>
                                    <td><?php echo $peminjam;?></td>
                                    <td><?php echo $level?></td>
                                    <td><?php echo $jml_barang;?></td>
                                    <td><?php echo $tgl_pinjam;?></td>
                                    <td><?php echo $tgl_kembali;?></td>
                                    <td>
                                        <span class="badge badge-warning">
                                            Dipinjam
                                        </span>
                                    </td>

                                </tr>
                        <?php   
                                    $no++;
                                }
                            }else{
                                trace_event("RESULT EMPTY tbl_pinjam (ADMIN)");
                        ?>      
                                <tr>
                                    <td colspan="7">Data Kosong</td>
                                </tr>                        
                        <?php
                            }
                        ?>
                      
                    </tbody>
                </table>
                        </div>
                    </div>
                </div>


                </div>
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->

    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>


    <script src="assets/js/lib/data-table/datatables.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/jszip.min.js"></script>
    <script src="assets/js/lib/data-table/pdfmake.min.js"></script>
    <script src="assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="assets/js/lib/data-table/datatables-init.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        } );
    </script>
    <script>
        function cetakLaporan() {
            var table = $('#bootstrap-data-table').DataTable();
            var length = table.page.len();
            var page = table.page.info().page;
            var start = page * length;
            window.open('cetak_barang_dipinjam.php?limit=' + length + '&start=' + start, '_blank');
        }

    </script>

</body>
</html>
