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
    "OPEN PAGE admin/edit-barang.php"
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
AMBIL DATA KATEGORI
========================================
*/

$query_kategori = mysqli_query(
    $conn,
    "
    SELECT *
    FROM kategori
    ORDER BY kategori ASC
    "
);

/*
========================================
PROSES EDIT BARANG
========================================
*/

if(isset($_POST['edit-barang'])){

    $id           = $_POST['id'];

    $nama_barang  = $_POST['nama_barang'];

    $stok_barang  = $_POST['stok_barang'];

    $kategori_id  = $_POST['kategori_id'];

    trace_event(
        "EDIT BARANG id=$id"
    );

    /*
    ========================================
    QUERY UPDATE DEFAULT
    ========================================
    */

    $sql = "
        UPDATE tbl_barang
        SET
            nama_barang='$nama_barang',
            stok_barang='$stok_barang',
            kategori_id='$kategori_id'
        WHERE id='$id'
    ";

    /*
    ========================================
    CEK UPLOAD GAMBAR
    ========================================
    */

    if(!empty($_FILES['gambar_barang']['name'])){

        $file_name = str_replace(
            " ",
            "_",
            $_FILES['gambar_barang']['name']
        );

        $file_size = $_FILES['gambar_barang']['size'];

        $file_type = $_FILES['gambar_barang']['type'];

        $tmp_name  = $_FILES['gambar_barang']['tmp_name'];

        $extension = strtolower(
            pathinfo(
                $file_name,
                PATHINFO_EXTENSION
            )
        );

        $max_size = 2000000;

        /*
        ========================================
        VALIDASI FILE
        ========================================
        */

        if(

            in_array(
                $extension,
                ['jpg','jpeg','png','gif']
            )

            &&

            in_array(
                $file_type,
                [
                    'image/jpeg',
                    'image/png',
                    'image/gif'
                ]
            )

            &&

            $file_size <= $max_size

        ){

            move_uploaded_file(
                $tmp_name,
                "../assets/img/uploads/".$file_name
            );

            /*
            ========================================
            UPDATE DENGAN GAMBAR
            ========================================
            */

            $sql = "
                UPDATE tbl_barang
                SET
                    nama_barang='$nama_barang',
                    stok_barang='$stok_barang',
                    kategori_id='$kategori_id',
                    gambar_barang='$file_name'
                WHERE id='$id'
            ";

        }

    }

    /*
    ========================================
    EKSEKUSI UPDATE
    ========================================
    */

    if(mysqli_query($conn, $sql)){

        trace_event(
            "UPDATE SUCCESS id=$id"
        );

        echo "
        <script>

            alert('Data barang berhasil diupdate');

            window.location='data-barang.php';

        </script>
        ";

        exit;

    }else{

        trace_event(
            "UPDATE FAILED : ".mysqli_error($conn)
        );

        echo "
        <script>

            alert('Gagal update data');

        </script>
        ";

    }

}

/*
========================================
AMBIL DATA BARANG
========================================
*/

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $query_barang = mysqli_query(
        $conn,
        "
        SELECT *
        FROM tbl_barang
        WHERE id='$id'
        "
    );

    $data_barang = mysqli_fetch_assoc(
        $query_barang
    );

    $nama_barang   = $data_barang['nama_barang'];

    $stok_barang   = $data_barang['stok_barang'];

    $gambar_barang = $data_barang['gambar_barang'];

    $kategori_id   = $data_barang['kategori_id'];

}

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
        Admin - Edit Barang
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

    <link rel="stylesheet" href="assets/scss/style.css">

</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div
        id="right-panel"
        class="right-panel"
    >

        <?php include 'header.php'; ?>

        <!-- BREADCRUMB -->

        <div class="breadcrumbs">

            <div class="col-sm-6">

                <div class="page-header float-left">

                    <div class="page-title">

                        <h1>
                            Edit Data Barang
                        </h1>

                    </div>

                </div>

            </div>

        </div>

        <!-- CONTENT -->

        <div class="content mt-3">

            <div class="animated fadeIn">

                <div class="row">

                    <div class="col-lg-3"></div>

                    <div class="col-lg-6">

                        <div class="card">

                            <div class="card-header">

                                <strong>
                                    Edit Barang
                                </strong>

                            </div>

                            <form
                                class="card-body card-block"
                                action=""
                                method="POST"
                                enctype="multipart/form-data"
                            >

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?php echo $id; ?>"
                                >

                                <!-- NAMA BARANG -->

                                <div class="form-group">

                                    <label>
                                        Nama Barang
                                    </label>

                                    <input
                                        type="text"
                                        name="nama_barang"
                                        class="form-control"
                                        value="<?php echo $nama_barang; ?>"
                                        required
                                    >

                                </div>

                                <!-- KATEGORI -->

                                <div class="form-group">

                                    <label>
                                        Kategori
                                    </label>

                                    <select
                                        name="kategori_id"
                                        class="form-control"
                                        required
                                    >

                                        <option value="">
                                            -- Pilih Kategori --
                                        </option>

                                        <?php
                                        while(
                                            $k = mysqli_fetch_assoc(
                                                $query_kategori
                                            )
                                        ){
                                        ?>

                                        <option
                                            value="<?php echo $k['id']; ?>"

                                            <?php
                                            if(
                                                $k['id'] ==
                                                $kategori_id
                                            ){
                                                echo "selected";
                                            }
                                            ?>
                                        >

                                            <?php
                                            echo $k['kategori'];
                                            ?>

                                        </option>

                                        <?php } ?>

                                    </select>

                                </div>

                                <!-- FOTO -->

                                <div class="form-group">

                                    <img
                                        src="../assets/img/uploads/<?php echo $gambar_barang; ?>"
                                        style="width:200px;"
                                    >

                                    <br><br>

                                    <label>
                                        Upload Foto Barang
                                    </label>

                                    <input
                                        type="file"
                                        name="gambar_barang"
                                        class="form-control"
                                    >

                                </div>

                                <!-- STOK -->

                                <div class="form-group">

                                    <label>
                                        Jumlah Barang
                                    </label>

                                    <input
                                        type="number"
                                        name="stok_barang"
                                        class="form-control"
                                        value="<?php echo $stok_barang; ?>"
                                        required
                                    >

                                </div>

                                <!-- KETERANGAN -->

                                <div class="form-group">

                                    <label>
                                        Keterangan Jurusan TKPI
                                    </label>

                                    <div class="alert alert-info">

                                        <b>
                                            Mesin dan Peralatan Bengkel
                                        </b>

                                        <br><br>

                                        Mesin Diesel dan Bensin Kapal,
                                        Mesin Las,
                                        Gerinda,
                                        Bor Tangan,
                                        Topeng Las,
                                        dan alat bengkel lainnya.

                                        <br><br>

                                        <b>
                                            Kelistrikan dan Otomasi
                                        </b>

                                        <br><br>

                                        Multimeter,
                                        Kabel,
                                        Sakelar,
                                        Motor Listrik,
                                        dan Generator.

                                        <br><br>

                                        <b>
                                            Refrigerasi
                                        </b>

                                        <br><br>

                                        Kompresor,
                                        Kondensor,
                                        Evaporator,
                                        dan alat pendingin.

                                        <br><br>

                                        <b>
                                            Navigasi dan Keselamatan
                                        </b>

                                        <br><br>

                                        Radio Komunikasi Kapal,
                                        APAR,
                                        dan alat keselamatan.

                                    </div>

                                </div>

                                <!-- BUTTON -->

                                <div class="form-group text-right">

                                    <button
                                        type="submit"
                                        name="edit-barang"
                                        class="btn btn-success"
                                    >

                                        <i class="fa fa-save"></i>

                                        Simpan Perubahan

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>