<?php
	include 'config.php';
	include 'db.php';

	trace_event("OPEN FILE proses-kembalikan.php");

	

	if(isset($_GET['id'])){

		$id = $_GET['id'];
		trace_event("GET ID = $id");

		$sql1 = "SELECT * FROM tbl_pinjam WHERE id='$id'";
		trace_event("RUN SQL : $sql1");
		$query_search_pinjam = mysqli_query($conn,$sql1);

		$data_pinjam  		 = mysqli_fetch_array($query_search_pinjam);
		$nama_barang  		 = $data_pinjam['nama_barang'];
		$peminjam			 = $data_pinjam['peminjam'];
		$level				 = $data_pinjam['level'];
		$jml_barang			 = $data_pinjam['jml_barang'];
		$tgl_pinjam			 = $data_pinjam['tgl_pinjam'];
		$tgl_kembali		 = $data_pinjam['tgl_kembali'];
		$kembali			 = date('Y-m-d');

		$sql2 = "SELECT * FROM tbl_barang WHERE nama_barang = '$nama_barang'";
		trace_event("RUN SQL : $sql2");
		$query_search_barang = mysqli_query($conn,$sql2);

		$data_search_barang  = mysqli_fetch_array($query_search_barang);

		if($query_search_barang){		

			trace_event("BARANG FOUND : $nama_barang");

			$sql3 = "INSERT INTO tbl_req_kembali (nama_barang, peminjam, level, jml_barang, tgl_pinjam, tgl_kembali, kembali) VALUES ('$nama_barang', '$peminjam', '$level', '$jml_barang', '$tgl_pinjam', '$tgl_kembali', '$kembali')";
			trace_event("RUN SQL : $sql3");

			$query_request_kembali = mysqli_query($conn,$sql3);

			if($query_request_kembali){

				trace_event("INSERT tbl_req_kembali SUCCESS");

				$sql4 = "DELETE FROM tbl_pinjam WHERE id='$id'";
				trace_event("RUN SQL : $sql4");

				$query_delete_pinjam = mysqli_query($conn,$sql4);

				if($query_delete_pinjam){

					trace_event("DELETE tbl_pinjam SUCCESS ID=$id");

					echo "<script>alert('Berhasil Request Pengembalian Barang');</script>";
					header("location: barang-dipinjam.php?username=$peminjam");

				}else{

					trace_event("DELETE tbl_pinjam FAILED ID=$id");
					echo "Gagal Delete tbl_pinjam";

				}

			}else{

				trace_event("INSERT tbl_req_kembali FAILED");
				echo "Gagal Insert data ke tbl_req_kembali";

			}	

		}else{

			trace_event("SEARCH BARANG FAILED : $nama_barang");
			echo "Gagal Mencari Barang";

		}
	}
?>
