<?php
session_start();
include '../config.php';

date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION['username'])) {
    die("Akses ditolak");
}

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;

$dicetak_oleh = $_SESSION['name'] ?? $_SESSION['username'];
$waktu_cetak  = date('d-m-Y H:i:s');

if ($limit == -1) {
    $query = "SELECT b.*, k.kategori AS nama_kategori 
              FROM tbl_barang b 
              LEFT JOIN kategori k ON b.kategori_id = k.id 
              ORDER BY b.id ASC";
} else {
    $query = "SELECT b.*, k.kategori AS nama_kategori 
              FROM tbl_barang b 
              LEFT JOIN kategori k ON b.kategori_id = k.id 
              ORDER BY b.id ASC LIMIT $start, $limit";
}

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Barang</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        .info { margin-bottom: 15px; }
        .info td { padding: 3px 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
        img { max-width: 100px; max-height: 80px; }
        .footer { margin-top: 20px; text-align: right; }
    </style>
</head>
<body onload="window.print()">

<h2>LAPORAN DATA BARANG</h2>

<table class="info">
    <tr>
        <td><strong>Dicetak Oleh</strong></td>
        <td><?= htmlspecialchars($dicetak_oleh) ?></td>
    </tr>
    <tr>
        <td><strong>Waktu Cetak</strong></td>
        <td><?= $waktu_cetak ?></td>
    </tr>
</table>

<table>
    <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th>Gambar</th>
        <th>Stok</th>
    </tr>

    <?php
    $no = $start + 1;
    while ($row = mysqli_fetch_array($result)) {
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
        <td><?= htmlspecialchars($row['nama_kategori'] ?? '-') ?></td>
        <td>
            <?php if(!empty($row['gambar_barang'])): ?>
                <img src="../assets/img/uploads/<?= $row['gambar_barang'] ?>" alt="<?= htmlspecialchars($row['nama_barang']) ?>">
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($row['stok_barang']) ?></td>
    </tr>
    <?php } ?>
</table>

<div class="footer">
    Dicetak pada <?= date('d F Y H:i') ?>
</div>

</body>
</html>
