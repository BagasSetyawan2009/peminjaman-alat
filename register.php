<?php
	include 'config.php';
	include 'db.php';
	trace_event("OPEN PAGE register.php");

	if(isset($_POST['daftar'])){
		trace_event("SUBMIT REGISTER");

		$nama 		= $_POST['nama'];
		$username 	= $_POST['username'];
		$password 	= md5($_POST['password']);
		$level		= $_POST['level'];

		trace_event("REGISTER INPUT username=$username level=$level");

		//echo $nama." ".$username." ".$password." ".$level;
		if(mysqli_query($conn,"INSERT INTO user (nama, username, password, level) VALUES ('$nama', '$username', '$password', '$level')")){
			trace_event("REGISTER SUCCESS username=$username");

			echo "<script>alert('Berhasil Register');</script>";
			header("location: index.php");
		}else{
			trace_event("REGISTER FAILED username=$username error=".mysqli_error($conn));
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register | Peminjaman Alat kebersihan Sekolah</title>
	<link rel="stylesheet" type="text/css" href="tambahan/bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="tambahan/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="tambahan/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="assets/css/register-style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

</head>
<body  style="background-image: url('') !important;">
	<div class="container">
		<div class='row'>
			<div class="col-md-4"></div>
			<div class="col-md-4 form-register-container">
				<h2 class="">Registrasi Akun</h2>
				<form action="" method="post">
					<label>Nama</label>
					<input class="form-control" type="" name="nama" required>
					<label>Username</label>
					<input class="form-control" type="" name="username" required>
					<label>Password</label>
					<input class="form-control" type="password" name="password" required>
					<label>Kelas</label>
					<input class="form-control"type="" name="level" required><br>
					<input type="checkbox" name="" required> Saya setuju dengan <a href="#">syarat dan ketentuan</a>.
					<button type="submit" name="daftar" class="btn btn-success" style="margin-top: 20px;">DAFTAR</button>
					<a href="index.php" class="btn btn-danger" style="margin-top: 20px; float:right">BATAL</a>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="tambahan/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="tambahan/bootstrap/dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="tambahan/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
