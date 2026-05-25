<?php
	include '../config.php';
	include '../db.php';
	trace_event("OPEN PAGE admin/proses_request.php");

	if(isset($_GET['mode']) && !empty($_GET['mode'])){
		$id = $_GET['id'];
		trace_event("GET id=".$id." | mode=".$_GET['mode']);

		$search_request = mysqli_query($conn,"SELECT * FROM tbl_request WHERE id='$id'");
		trace_event("RUN QUERY SELECT * FROM tbl_request WHERE id='$id'");

		$data_request = mysqli_fetch_array($search_request);
		trace_event("FETCH DATA tbl_request: nama_barang=".$data_request['nama_barang'].", peminjam=".$data_request['peminjam']);

		$id_request 		   = $data_request['id'];
		$nama_barang_request = $data_request['nama_barang'];
		$peminjam_request 	   = $data_request['peminjam'];
		$level_request		   = $data_request['level'];
		$jml_barang_request   = $data_request['jml_barang'];
		$tgl_pinjam_request   = $data_request['tgl_pinjam'];
		$tgl_kembali_request  = $data_request['tgl_kembali'];
		
		if($_GET['mode'] == "terima"){
			trace_event("MODE TERIMA");

			$query_search_barang = mysqli_query($conn,"SELECT * FROM tbl_barang WHERE nama_barang = '$nama_barang_request'");
			trace_event("RUN QUERY SELECT * FROM tbl_barang WHERE nama_barang='$nama_barang_request'");

			$data_search_barang  = mysqli_fetch_array($query_search_barang);
			$stok_barang 		  = $data_search_barang['stok_barang'] - $jml_barang_request;
			trace_event("CALCULATE stok_barang=".$stok_barang);

			if($data_search_barang){
				$update_stok = mysqli_query($conn,"UPDATE tbl_barang SET stok_barang = '$stok_barang' WHERE nama_barang = '$nama_barang_request'");
				trace_event("UPDATE tbl_barang SET stok_barang=$stok_barang WHERE nama_barang='$nama_barang_request'");

				if($update_stok){
					trace_event("UPDATE tbl_barang BERHASIL");

					if(mysqli_query($conn,"INSERT INTO tbl_pinjam (nama_barang, peminjam, level, jml_barang, tgl_pinjam, tgl_kembali) VALUES ('$nama_barang_request', '$peminjam_request', '$level_request', '$jml_barang_request', '$tgl_pinjam_request', '$tgl_kembali_request')")){
						trace_event("INSERT tbl_pinjam BERHASIL");

						if(mysqli_query($conn,"DELETE FROM tbl_request WHERE id = '$id_request'")){
							trace_event("DELETE tbl_request id=$id_request BERHASIL");

							$konten = "Permintaan Peminjaman Barang Anda Telah di Terima. ".$jml_barang_request." buah ".$nama_barang_request.". Peminjam: ".$peminjam_request.". Silahkan ke bagian Logistik untuk mengambil barang";

							if(mysqli_query($conn,"INSERT INTO pemberitahuan (username, konten, status) VALUES ('$peminjam_request', '$konten', 'terima')")){
								trace_event("INSERT pemberitahuan BERHASIL untuk username=$peminjam_request");
								echo "<script>alert('Berhasil Menerima Permintaan');</script>";
								echo "<script>window.history.back();</script>";
							}else{
								trace_event("GAGAL INSERT pemberitahuan: ".mysqli_error($conn));
								echo "Gagal Menambah Pemberitahuan";
							}						
						}else{
							trace_event("GAGAL DELETE tbl_request id=$id_request: ".mysqli_error($conn));
							echo "Gagal Menghapus dari tbl_request";
						}
					}else{
						trace_event("GAGAL INSERT tbl_pinjam: ".mysqli_error($conn));
						echo "Gagal menambah ke tbl_pinjam";
					}
				}else{
					trace_event("GAGAL UPDATE tbl_barang: ".mysqli_error($conn));
					echo "Tidak bisa update data barang";
				}
			}else{
				trace_event("GAGAL MENCARI tbl_barang: ".$nama_barang_request);
				echo "tidak bisa mencari barang";
			}

		}else if($_GET['mode'] == "tolak"){
			trace_event("MODE TOLAK");

			if(mysqli_query($conn,"DELETE FROM tbl_request WHERE id = '$id_request'")){
				trace_event("DELETE tbl_request id=$id_request BERHASIL");

				$konten = "Maaf! Permintaan Peminjaman Barang Anda di Tolak. ".$jml_barang_request." buah ".$nama_barang_request.". Username: ".$peminjam_request;

				if(mysqli_query($conn,"INSERT INTO pemberitahuan (username, konten, status) VALUES ('$peminjam_request', '$konten', 'tolak')")){
					trace_event("INSERT pemberitahuan BERHASIL untuk username=$peminjam_request");
					echo "<script>alert('Berhasil Menolak Permintaan');</script>";
					echo "<script>window.history.back();</script>";
				}else{
					trace_event("GAGAL INSERT pemberitahuan: ".mysqli_error($conn));
					echo "Gagal Menambah Pemberitahuan";
				}			
			}else{
				trace_event("GAGAL DELETE tbl_request id=$id_request: ".mysqli_error($conn));
				echo "Gagal Menghapus dari tbl_request";
			}	
		}
	}
?>
