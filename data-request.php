<?php

if(isset($_GET['username'])){
    $username = $_GET['username'];
}

include 'db.php';

trace_event("OPEN PAGE data-request.php username=$username");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Data Permintaan Peminjaman</title>

    <link rel="stylesheet"
        type="text/css"
        href="tambahan/bootstrap-4.1.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
        type="text/css"
        href="tambahan/font-awesome/css/font-awesome.css">

    <meta name="viewport"
        content="width=device-width, initial-scale=1">

</head>

<body style="background:#f5f5f5;">

<div class="container mt-5">

    <div class="row">

        <div class="col-md-12">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <h4>
                        Data Permintaan Peminjaman
                    </h4>

                </div>

                <div class="card-body">

                    <a href="index.php"
                        class="btn btn-info btn-sm mb-3">

                        <i class="fa fa-arrow-left"></i>
                        Kembali

                    </a>

                    <table class="table table-bordered table-striped">

                        <thead class="thead-dark">

                            <tr>

                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php

                        $no = 1;

                        $query = mysqli_query(
                            $conn,
                            "SELECT * FROM peminjaman ORDER BY id DESC"
                        );

                        while($d = mysqli_fetch_assoc($query)){

                        ?>

                        <tr>

                            <td>
                                <?php echo $no++; ?>
                            </td>

                            <td>
                                <?php echo $d['nama_barang']; ?>
                            </td>

                            <td>
                                <?php echo $d['jumlah_barang']; ?>
                            </td>

                            <td>
                                <?php echo $d['tgl_pinjam']; ?>
                            </td>

                            <td>
                                <?php echo $d['tgl_kembali']; ?>
                            </td>

                            <td>

                                <?php
                                if($d['status'] == 'Disetujui'){
                                    echo "<span class='badge badge-success'>Disetujui</span>";
                                }elseif($d['status'] == 'Ditolak'){
                                    echo "<span class='badge badge-danger'>Ditolak</span>";
                                }else{
                                    echo "<span class='badge badge-warning'>Menunggu</span>";
                                }
                                ?>

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

<script src="tambahan/jquery/dist/jquery.min.js"></script>

<script src="tambahan/bootstrap-4.1.3/dist/js/bootstrap.min.js"></script>

</body>
</html>