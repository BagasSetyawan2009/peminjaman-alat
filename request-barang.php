<?php
	include 'config.php';
	include 'db.php';
	trace_event("OPEN PAGE request-barang.php");

	if(isset($_POST['request-pinjam'])){
		trace_event("SUBMIT REQUEST PINJAM");

		$username			= $_POST['username'];
		$nama_peminjam 		= $_POST['nama_peminjam'];
		$level		 		= $_POST['level'];
		$nama_barang 		= $_POST['nama_barang'];
		$jml_barang 		= $_POST['jml_barang'];
		$tgl_pinjam 		= $_POST['tgl_pinjam'];
		$tgl_kembali 		= $_POST['tgl_kembali'];

		trace_event("REQUEST DATA user=$username barang=$nama_barang jumlah=$jml_barang");

		$query_insert_req   = mysqli_query($conn,"INSERT INTO tbl_request (nama_barang, peminjam, level, jml_barang, tgl_pinjam, tgl_kembali) VALUES ('$nama_barang', '$username', '$level', '$jml_barang', '$tgl_pinjam', '$tgl_kembali')");

		if($query_insert_req){
			trace_event("REQUEST INSERT SUCCESS user=$username barang=$nama_barang");
?>
<!DOCTYPE html>
<html>

<head>
	<title>Request berhasil | Peminjaman Alat kebersihan Sekolah</title>
	<link rel="stylesheet" type="text/css" href="tambahan/bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="tambahan/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="tambahan/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="assets/css/register-style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

</head>

<body style="background-image: url('') !important;">
	<div class="container">
		<div class='row'>
			<div class="col-md-3"></div>
			<div class="col-md-6 form-register-container">
				<div class="alert alert-success" style="text-transform: capitalize;">
					Anda Berhasil mengirim permintaan peminjaman barang. Harap tunggu konfirmasi dari admin. Silahkan
					Cek Menu <a href="pemberitahuan.php?username=<?php echo $username;?>">Pemberitahuan</a>
				</div>
				<table class="table table-bordered table-super-condensed">
					<tbody>
						<tr>
							<td>username</td>
							<td>
								<?php echo $username?>
							</td>
						</tr>
						<tr>
							<td>perminjam</td>
							<td>
								<?php echo $nama_peminjam?>
							</td>
						</tr>
						<tr>
							<td>Kelas/Jabatan</td>
							<td>
								<?php echo $level?>
							</td>
						</tr>
						<tr>
							<td>nama barang</td>
							<td>
								<?php echo $nama_barang?>
							</td>
						</tr>
						<tr>
							<td>jumlah barang</td>
							<td>
								<?php echo $jml_barang?>
							</td>
						</tr>
						<tr>
							<td>Tgl pinjam</td>
							<td>
								<?php echo $tgl_pinjam;?>
							</td>
						</tr>
						<tr>
							<td>Tgl kembali</td>
							<td>
								<?php echo $tgl_kembali?>
							</td>
						</tr>
					</tbody>
				</table>
				<a href="index.php" class="btn btn-success btn-req">KEMBALI</a>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="tambahan/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="tambahan/bootstrap/dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="tambahan/bootstrap/dist/js/bootstrap.min.js"></script>

	<script>
		document.querySelectorAll('.btn-req').forEach(function (btn) {
			btn.addEventListener('click', function (e) {
				if (this.classList.contains('disabled')) {
					e.preventDefault();
					return false;
				}

				this.classList.add('disabled');
				this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Proses...';
			});
		});
	</script>

</body>

</html>
<?php
		}else{
			trace_event("REQUEST INSERT FAILED user=$username error=".mysqli_error($conn));
			echo "Gagal mengirim permintaan";
		}
	}
?>
