<?php
session_start();
include '../config.php';
include '../db.php';

if(!isset($_SESSION['level']) || $_SESSION['level'] != "admin"){
    header("location: ../index.php");
    exit;
}

/* FILTER */
$status = $_GET['status'] ?? 'all';
$user   = $_GET['user'] ?? '';

$where = [];

if($status != 'all'){
    $where[] = "p.status='$status'";
}

if(!empty($user)){
    $where[] = "p.username LIKE '%$user%'";
}

$whereSql = count($where) ? "WHERE ".implode(" AND ", $where) : "";

$data = mysqli_query($conn,"
    SELECT p.*, b.nama_barang, b.gambar_barang
    FROM tbl_pinjam p
    JOIN tbl_barang b ON p.id_barang = b.id
    $whereSql
    ORDER BY p.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Riwayat Peminjaman</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
body{
    background:#0f1115;
    color:#fff;
    font-family:Segoe UI;
}

/* SIDEBAR MINI TOP */
.topbar{
    background:#151a22;
    padding:15px;
    border-radius:12px;
    margin:15px;
}

/* CARD */
.card{
    background:#1b2230;
    border:none;
    border-radius:16px;
    color:#fff;
    margin-bottom:15px;
}

/* BADGE STATUS */
.badge-pending{background:#ffc107;color:#000;}
.badge-approved{background:#28a745;}
.badge-rejected{background:#dc3545;}

/* INPUT */
.form-control{
    background:#121826;
    border:none;
    color:#fff;
}
</style>

</head>

<body>

<div class="container-fluid">

<div class="topbar">
    <h4>📜 Riwayat Peminjaman</h4>
    <small>Admin Panel</small>
</div>

<!-- FILTER -->
<div class="card p-3">

<form method="GET">
<div class="row">

    <div class="col-md-4">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="all">Semua</option>
            <option value="pending" <?= $status=='pending'?'selected':''; ?>>Pending</option>
            <option value="approved" <?= $status=='approved'?'selected':''; ?>>Approved</option>
            <option value="rejected" <?= $status=='rejected'?'selected':''; ?>>Rejected</option>
        </select>
    </div>

    <div class="col-md-5">
        <label>User</label>
        <input type="text" name="user" class="form-control" placeholder="Cari username..." value="<?= $user; ?>">
    </div>

    <div class="col-md-3 mt-4">
        <button class="btn btn-primary btn-block">Filter</button>
    </div>

</div>
</form>

</div>

<!-- LIST RIWAYAT -->
<div class="row">

<?php while($d=mysqli_fetch_array($data)){ ?>

<div class="col-md-6">

<div class="card p-3">

    <div class="d-flex">
        <img src="../assets/img/uploads/<?= $d['gambar_barang']; ?>"
             style="width:80px;height:80px;object-fit:cover;border-radius:12px;margin-right:15px;">

        <div>
            <h5><?= $d['nama_barang']; ?></h5>
            <small>User: <?= $d['username']; ?></small><br>
            <small>Jumlah: <?= $d['jml_barang']; ?></small>
        </div>
    </div>

    <hr style="background:#333">

    <div class="d-flex justify-content-between">

        <span>
            Status:
            <?php if($d['status']=='pending'){ ?>
                <span class="badge badge-pending">Pending</span>
            <?php } elseif($d['status']=='approved'){ ?>
                <span class="badge badge-approved">Approved</span>
            <?php } else { ?>
                <span class="badge badge-rejected">Rejected</span>
            <?php } ?>
        </span>

        <small>#ID <?= $d['id']; ?></small>

    </div>

</div>

</div>

<?php } ?>

</div>

</div>

</body>
</html>