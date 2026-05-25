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
    $query = "SELECT * FROM tbl_req_kembali ORDER BY id DESC";
} else {
    $query = "SELECT * FROM tbl_req_kembali ORDER BY id DESC LIMIT $start, $limit";
}

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Barang Kembali</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        .info { margin-bottom: 15px; }
        .info td { padding: 3px 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>

<body onload="window.print()">

<h2>LAPORAN KONFIRMASI BARANG KEMBALI</h2>

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
        <th>Peminjam</th>
        <th>Jabatan / Kelas</th>
        <th>Jumlah</th>
        <th>Tgl Pinjam</th>
        <th>Tgl Kembali</th>
    </tr>

    <?php
    $no = $start + 1;
    while ($row = mysqli_fetch_array($result)) {
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
        <td><?= htmlspecialchars($row['peminjam']) ?></td>
        <td><?= htmlspecialchars($row['level']) ?></td>
        <td><?= htmlspecialchars($row['jml_barang']) ?></td>
        <td><?= htmlspecialchars($row['tgl_pinjam']) ?></td>
        <td><?= htmlspecialchars($row['tgl_kembali']) ?></td>
    </tr>
    <?php } ?>
</table>

<div class="footer">
    Dicetak pada <?= date('d F Y H:i') ?>
</div>

</body>
</html>
