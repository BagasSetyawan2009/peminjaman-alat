<?php
session_start();
include 'config.php';
include 'db.php';

/* DATA TETAP - TIDAK DIUBAH */
$selectedKategori = $_GET['kategori'] ?? 'all';
$search = $_GET['search'] ?? '';

$where = [];

if ($selectedKategori !== 'all') {
    $where[] = "b.kategori_id = '" . mysqli_real_escape_string($conn, $selectedKategori) . "'";
}

if (!empty($search)) {
    $where[] = "b.nama_barang LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}

$whereSql = count($where) ? "WHERE " . implode(" AND ", $where) : "";

$kategoriQuery = mysqli_query($conn,"SELECT * FROM kategori ORDER BY kategori ASC");

$sql = "
    SELECT b.*, k.kategori
    FROM tbl_barang b
    LEFT JOIN kategori k ON b.kategori_id = k.id
    $whereSql
    ORDER BY b.id ASC
";

$queryBarang = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Peminjaman Sekolah</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

<style>

/* DARK MODERN UI */
body{
    background:#0b1220;
    color:#fff;
    font-family:Segoe UI;
}

/* TOP BAR */
.topbar{
    background:#111827;
    padding:15px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    position:sticky;
    top:0;
    z-index:10;
}

/* TITLE */
.title{
    font-weight:bold;
    font-size:18px;
}

/* CARD */
.card{
    background:#111827;
    border:none;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.4);
}

/* FORM INPUT DEFAULT */
.form-control{
    background:#0f172a;
    border:none;
    color:#fff;
}

/* 🔥 INI YANG DIPERBAIKI (CARI BARANG JADI PUTIH) */
input[name="search"]{
    background:#ffffff !important;
    color:#000 !important;
    border:1px solid #ddd !important;
}

input[name="search"]::placeholder{
    color:#666;
}

/* BUTTON */
.btn{
    border-radius:10px;
}

/* PRODUCT CARD */
.product-card{
    background:#111827;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.4);
    transition:0.3s;
}

.product-card:hover{
    transform:scale(1.03);
}

/* IMAGE */
.product-card img{
    height:200px;
    width:100%;
    object-fit:cover;
}

/* TEXT */
.product-body{
    padding:15px;
}

.badge-dark{
    background:#1f2937;
}

</style>

</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <div class="title">📦 Peminjaman Alat Sekolah</div>

    <div>
        <?php if(isset($_SESSION['username'])){ ?>
            <span class="mr-2">Hi, <?= $_SESSION['username']; ?></span>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        <?php } else { ?>
            <a href="login.php" class="btn btn-warning btn-sm">Login</a>
        <?php } ?>
    </div>
</div>

<div class="container mt-4">

<!-- FILTER -->
<div class="card p-3 mb-4">
<form method="GET">
<div class="row">

    <div class="col-md-4">
        <label>Kategori</label>
        <select name="kategori" class="form-control">
            <option value="all">Semua</option>
            <?php while($k=mysqli_fetch_assoc($kategoriQuery)){ ?>
                <option value="<?= $k['id']; ?>" <?=($selectedKategori==$k['id'])?'selected':''?>>
                    <?= $k['kategori']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="col-md-6">
        <label>Cari Barang</label>
        <input type="text" name="search" class="form-control" value="<?= $search; ?>" placeholder="Cari barang...">
    </div>

    <div class="col-md-2 mt-4">
        <button class="btn btn-primary btn-block">Filter</button>
    </div>

</div>
</form>
</div>

<!-- LIST BARANG -->
<div class="row">

<?php while($d=mysqli_fetch_assoc($queryBarang)){ ?>

<div class="col-md-4 mb-4">

    <div class="product-card">

        <img src="assets/img/uploads/<?= $d['gambar_barang']; ?>">

        <div class="product-body">

            <h5><?= $d['nama_barang']; ?></h5>

            <span class="badge badge-dark">
                <?= $d['kategori']; ?>
            </span>

            <p class="mt-2">
                Stok: <b><?= $d['stok_barang']; ?></b>
            </p>

            <a href="proses-pinjam.php?id_barang=<?= $d['id']; ?>"
               class="btn btn-info btn-sm btn-block">
                Pinjam
            </a>

        </div>

    </div>

</div>

<?php } ?>

</div>

</div>

</body>
</html>