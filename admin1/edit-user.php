<?php
session_start();
include '../config.php';
include '../db.php';

trace_event("OPEN PAGE admin/edit-user.php");

if (isset($_POST['edit-user'])) {

    $id          = $_POST['id'];
    $nama        = $_POST['nama'];
    $username    = $_POST['username'];
    $level_radio = $_POST['level_radio'] ?? '';
    $level_text  = $_POST['level_text'] ?? '';

    if ($level_radio === 'admin') {
        $level_final = 'admin';
        $uid = 2026;
    } elseif ($level_radio === 'petugas') {
        $level_final = 'petugas';
        $uid = 2025;
    } else {
        $level_final = $level_text;
        $uid = 0;
    }

    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $sql = "UPDATE user SET
                    nama='$nama',
                    username='$username',
                    password='$password',
                    level='$level_final',
                    uid='$uid'
                WHERE id='$id'";
    } else {
        $sql = "UPDATE user SET
                    nama='$nama',
                    username='$username',
                    level='$level_final',
                    uid='$uid'
                WHERE id='$id'";
    }

    trace_event("REQUEST UPDATE user id=$id nama=$nama username=$username level=$level_final uid=$uid");

    $update = mysqli_query($conn, $sql);

    if ($update) {
        trace_event("UPDATE SUCCESS user id=$id");
        echo "<script>alert('Berhasil Update User!');</script>";
        echo "<script>window.location.href = 'data-user.php';</script>";
        exit;
    } else {
        trace_event("UPDATE FAILED user id=$id : ".mysqli_error($conn));
        echo "Gagal update data: " . mysqli_error($conn);
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM user WHERE id='$id'");
    trace_event("RUN QUERY SELECT user id=$id");
    $data  = mysqli_fetch_array($query);
    trace_event("FETCH DATA user id=$id");

    $nama     = $data['nama'];
    $username = $data['username'];
    $level    = $data['level'];
    $uid      = $data['uid'];

    if ($level === 'admin') {
        $level_radio = 'admin';
        $level_text  = '';
    } elseif ($level === 'petugas') {
        $level_radio = 'petugas';
        $level_text  = '';
    } else {
        $level_radio = 'other';
        $level_text  = $level;
    }
} else {
    trace_event("NO ID PARAMETER, REDIRECT TO data-user.php");
    header("Location: data-user.php");
    exit;
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
    <title>Admin - Edit User</title>
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
        trace_event("LOAD sidebar.php");
    ?>
    <div id="right-panel" class="right-panel">
        <?php
            include 'header.php'; 
            trace_event("LOAD header.php");
        ?>
        <div class="breadcrumbs">
            <div class="col-sm-6">
                <div class="page-header float-left">
                    <div class="page-title" style="padding: 20px 0;">
                        <h1 style="display: unset;">Edit Data User</h1>
                        <a href="data-user.php" class="btn btn-info btn-sm" style="margin-left: 20px;">
                            <i class="fa fa-arrow-left"></i>
                            Kembali
                        </a>
                    </div>


                </div>
            </div>
            <div class="col-sm-6">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">User</a></li>
                            <li class="active">Edit Data</li>
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
                            <div class="card-header">
                                <strong>Update Data Admin & Petugas </strong>
                            </div>
                            <form method="POST" class="card-body">

                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <div class="mb-3">
                                    <label>Nama</label>
                                    <input type="text" name="nama" value="<?php echo $nama; ?>" class="form-control"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label>Username</label>
                                    <input type="text" name="username" value="<?php echo $username; ?>"
                                        class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                </div>

                                <div class="mb-3">
                                    <label>Level</label><br>
                                    <small class="text-muted">Pilih Admin & Petugas, Diisi Jika BUKAN Admin & Petugas</small><br>
                                    <label class="form-check-label">
                                        <input type="radio" name="level_radio" value="admin" <?php if($level==='admin' )
                                            echo 'checked' ; ?>>
                                        Admin
                                    </label>

                                    <label class="form-check-label" style="margin-left:20px;">
                                        <input type="radio" name="level_radio" value="petugas" <?php
                                            if($level==='petugas' ) echo 'checked' ; ?>>
                                        Petugas
                                    </label>

                                    <?php if($level !== 'admin' && $level !== 'petugas'): ?>
                                    <input type="text" name="level_text" value="<?php echo $level; ?>"
                                        placeholder="Masukkan level" class="form-control form-control-sm mt-2"
                                        style="width:200px; display:inline-block; margin-left:10px;">
                                    <?php else: ?>
                                    <input type="text" name="level_text" value=""
                                        class="form-control form-control-sm mt-2"
                                        style="width:200px; display:inline-block; margin-left:10px;"
                                        placeholder="Masukkan level">
                                    <?php endif; ?>

                                </div>

                                <div class="mb-3">
                                    <label>UID</label><br>
                                    <small class="text-muted">Pilih UID Jika Admin = 2026 | Petugas = 2025</small><br>
                                    <label>
                                        <input type="radio" name="uid" value="2026" <?php if($uid=='2026' )
                                            echo 'checked' ; ?>> 2026
                                    </label>
                                    &nbsp;&nbsp;
                                    <label>
                                        <input type="radio" name="uid" value="2025" <?php if($uid=='2025' )
                                            echo 'checked' ; ?>> 2025
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-success" name="edit-user">Simpan Perubahan</button>
                                <a href="data-user.php" class="btn btn-secondary">Kembali</a>

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
