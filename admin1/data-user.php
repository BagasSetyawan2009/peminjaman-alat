<?php

session_start();

include '../config.php';
include '../db.php';

/*
========================================
TRACE HALAMAN
========================================
*/

trace_event(
    "OPEN PAGE admin/data-user.php"
);

/*
========================================
CEK LOGIN ADMIN
========================================
*/

if(
    !isset($_SESSION['login']) ||
    !isset($_SESSION['admin'])
){

    header(
        "Location: ../login.php"
    );

    exit;
}

/*
========================================
HAPUS USER
========================================
*/

if(

    isset($_GET['opsi']) &&

    $_GET['opsi'] == 'hapus' &&

    isset($_GET['id'])

){

    $id = $_GET['id'];

    trace_event(
        "DELETE USER id=$id"
    );

    $hapus = mysqli_query(
        $conn,
        "
        DELETE FROM user
        WHERE id='$id'
        "
    );

    if($hapus){

        trace_event(
            "DELETE SUCCESS id=$id"
        );

        echo "
        <script>

            alert('Data user berhasil dihapus');

            window.location='data-user.php';

        </script>
        ";

        exit;

    }else{

        trace_event(
            "DELETE FAILED : ".mysqli_error($conn)
        );

        echo "
        <script>

            alert('Gagal hapus user');

        </script>
        ";

    }

}

/*
========================================
AMBIL DATA USER
========================================
*/

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM user
    ORDER BY id ASC
    "
);

?>

<!doctype html>

<html class="no-js" lang="">

<head>

    <meta charset="utf-8">

    <meta
        http-equiv="X-UA-Compatible"
        content="IE=edge"
    >

    <title>
        Admin - Data User
    </title>

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <link rel="stylesheet" href="assets/css/normalize.css">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <link rel="stylesheet" href="assets/css/themify-icons.css">

    <link rel="stylesheet" href="assets/css/flag-icon.min.css">

    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">

    <link
        rel="stylesheet"
        href="assets/css/lib/datatable/dataTables.bootstrap.min.css"
    >

    <link
        rel="stylesheet"
        href="assets/scss/style.css"
    >

</head>

<body>

    <!-- SIDEBAR -->

    <?php include 'sidebar.php'; ?>

    <!-- RIGHT PANEL -->

    <div
        id="right-panel"
        class="right-panel"
    >

        <!-- HEADER -->

        <?php include 'header.php'; ?>

        <!-- BREADCRUMB -->

        <div class="breadcrumbs">

            <div class="col-sm-6">

                <div class="page-header float-left">

                    <div class="page-title">

                        <h1>

                            Data User

                            <a
                                href="data-user.php"
                                class="btn btn-info btn-sm"
                            >

                                <i class="fa fa-refresh"></i>

                                Refresh

                            </a>

                            <a
                                href="tambah-user.php"
                                class="btn btn-primary btn-sm"
                            >

                                <i class="fa fa-plus"></i>

                                Tambah User

                            </a>

                        </h1>

                    </div>

                </div>

            </div>

            <div class="col-sm-6">

                <div class="page-header float-right">

                    <div class="page-title">

                        <ol class="breadcrumb text-right">

                            <li>
                                <a href="#">
                                    Dashboard
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    User
                                </a>
                            </li>

                            <li class="active">
                                Data User
                            </li>

                        </ol>

                    </div>

                </div>

            </div>

        </div>

        <!-- CONTENT -->

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <strong class="card-title">

                                    Data User

                                </strong>

                                <a
                                    href="tambah-admin.php"
                                    class="btn btn-success btn-sm"
                                    style="margin-left:20px;"
                                >

                                    <i class="fa fa-plus"></i>

                                    Tambah Admin & Petugas

                                </a>

                                <a
                                    href="javascript:void(0);"
                                    onclick="cetakLaporan()"
                                    class="btn btn-warning btn-sm"
                                    style="margin-left:20px;"
                                >

                                    <i class="fa fa-print"></i>

                                    Cetak Laporan

                                </a>

                            </div>

                            <div class="card-body">

                                <table
                                    id="bootstrap-data-table"
                                    class="table table-striped table-bordered"
                                >

                                    <thead>

                                        <tr>

                                            <th>No</th>

                                            <th>Nama</th>

                                            <th>Username</th>

                                            <th>Level</th>

                                            <th>Opsi</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php

                                        $no = 1;

                                        while(
                                            $data =
                                            mysqli_fetch_assoc($query)
                                        ){

                                        ?>

                                        <tr>

                                            <td>

                                                <?php
                                                echo $no++;
                                                ?>

                                            </td>

                                            <td>

                                                <?php
                                                echo $data['nama'];
                                                ?>

                                            </td>

                                            <td>

                                                <?php
                                                echo $data['username'];
                                                ?>

                                            </td>

                                            <td>

                                                <?php
                                                echo ucfirst(
                                                    $data['level']
                                                );
                                                ?>

                                            </td>

                                            <td>

                                                <!-- EDIT -->

                                                <a
                                                    href="edit-user.php?id=<?php echo $data['id']; ?>"
                                                    class="btn btn-info btn-sm"
                                                >

                                                    <i class="fa fa-pencil"></i>

                                                    Edit

                                                </a>

                                                <!-- HAPUS -->

                                                <a
                                                    href="?opsi=hapus&id=<?php echo $data['id']; ?>"
                                                    class="btn btn-danger btn-sm"

                                                    onclick="
                                                    return confirm(
                                                    'Yakin hapus user ini?'
                                                    )
                                                    "
                                                >

                                                    <i class="fa fa-trash"></i>

                                                    Hapus

                                                </a>

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

    <!-- JS -->

    <script src="assets/js/vendor/jquery-2.1.4.min.js"></script>

    <script src="assets/js/popper.min.js"></script>

    <script src="assets/js/plugins.js"></script>

    <script src="assets/js/main.js"></script>

    <script src="assets/js/lib/data-table/datatables.min.js"></script>

    <script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>

    <script src="assets/js/lib/data-table/datatables-init.js"></script>

    <!-- DATATABLE -->

    <script>

        $(document).ready(function(){

            $('#bootstrap-data-table').DataTable();

        });

    </script>

    <!-- CETAK -->

    <script>

        function cetakLaporan(){

            window.open(
                'cetak_data_user.php',
                '_blank'
            );

        }

    </script>

</body>

</html>