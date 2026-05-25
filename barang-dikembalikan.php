<?php
	if(isset($_GET['username'])){
		$username = $_GET['username'];
	}

	include 'db.php';
	trace_event("OPEN PAGE data_kembali.php username=$username");
?>
<!DOCTYPE html>
<html>

<head>
	<title>Peminjaman Alat kebersihan Sekolah</title>
	<link rel="stylesheet" type="text/css" href="tambahan/bootstrap-4.1.3/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="tambahan/bootstrap-4.1.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/register-style.css">
	<link rel="stylesheet" type="text/css" href="tambahan/font-awesome/css/font-awesome.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body style="background-image: url('') !important;">
	<div class="container">
		<div class='row'>
			<div class="col-md-2" style="padding-top: 20px;">
				<a href="index.php" class="btn btn-info btn-icon btn-sm">
					<i class="fa fa-arrow-left"></i>
				</a>
			</div>
			<div class="col-md-8 form-register-container">
				<h2>Data Barang Dikembalikan</h2>
				<table class="table table-bordered table-super-condensed">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Barang</th>
							<th>Jumlah Barang</th>
							<th>Tanggal Pinjam</th>
							<th>Tanggal Kembali</th>
							<th>Status pengembalian</th>

						</tr>
					</thead>
					<tbody>
						<?php
							include 'config.php';

							$sql = "SELECT * FROM tbl_transaksi WHERE peminjam='$username' ORDER BY id DESC";
							$query = db_query($conn,$sql);

							trace_event("RUN QUERY tbl_transaksi peminjam=$username");

							if(mysqli_num_rows($query) == 0){
								trace_event("RESULT EMPTY tbl_transaksi peminjam=$username");
								echo "<tr><td colspan='6'>belum ada data!</td></tr>";
							}else{
								trace_event("RESULT FOUND tbl_transaksi peminjam=$username");
								$no = 1;
								while ($data = mysqli_fetch_array($query)) {
						?>
						<tr>
							<td>
								<?php echo $no;?>
							</td>
							<td>
								<?php echo $data['nama_barang'];?>
							</td>
							<td>
								<?php echo $data['jml_barang'];?>
							</td>
							<td>
								<?php echo $data['tgl_pinjam'];?>
							</td>
							<td>
								<?php echo $data['tgl_kembali'];?>
							</td>
							<td>
								<?php 
									if($data['status_appr']=='Diterima'){
  									echo "<span class='badge badge-success'>Diterima</span>";
								}else{
    								echo "<span class='badge badge-warning'>Menunggu</span>";
								}
								?>
							</td>


						</tr>
						<?php
									$no++;
								}
							}
						?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="tambahan/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="tambahan/bootstrap-4.1.3/dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="tambahan/bootstrap-4.1.3/dist/js/bootstrap.min.js"></script>

</body>

</html>
