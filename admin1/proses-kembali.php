<?php
    include '../config.php';
    include '../db.php';
    trace_event("OPEN PAGE admin/proses_kembali.php");

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        trace_event("GET id=".$id);

        $query_search_req_kembali = mysqli_query($conn,"SELECT * FROM tbl_req_kembali");
        trace_event("RUN QUERY SELECT * FROM tbl_req_kembali");

        $data_req_kembali = mysqli_fetch_array($query_search_req_kembali);
        trace_event("FETCH DATA req_kembali: nama_barang=".$data_req_kembali['nama_barang'].", peminjam=".$data_req_kembali['peminjam']);

        $nama_barang = $data_req_kembali['nama_barang'];
        $peminjam    = $data_req_kembali['peminjam'];
        $level       = $data_req_kembali['level'];
        $jml_barang  = $data_req_kembali['jml_barang'];
        $tgl_pinjam  = $data_req_kembali['tgl_pinjam'];
        $tgl_kembali = $data_req_kembali['tgl_kembali'];

        $query_search_barang = mysqli_query($conn,"SELECT * FROM tbl_barang WHERE nama_barang = '$nama_barang'");
        trace_event("RUN QUERY SELECT * FROM tbl_barang WHERE nama_barang='$nama_barang'");

        $data_search_barang = mysqli_fetch_array($query_search_barang);
        $stok_barang = $data_search_barang['stok_barang'] + $jml_barang;
        trace_event("CALCULATE stok_barang=".$stok_barang);

        // echo $stok_barang;

        if($data_search_barang){
            $update_stok = mysqli_query($conn,"UPDATE tbl_barang SET stok_barang = '$stok_barang' WHERE nama_barang = '$nama_barang'");
            trace_event("RUN UPDATE tbl_barang SET stok_barang=$stok_barang WHERE nama_barang='$nama_barang'");
            
            if($update_stok){
                trace_event("UPDATE tbl_barang BERHASIL");

                if(mysqli_query($conn,"INSERT INTO tbl_transaksi (nama_barang, peminjam, level, jml_barang, tgl_pinjam, tgl_kembali) VALUES ('$nama_barang', '$peminjam', '$level', '$jml_barang', '$tgl_pinjam', '$tgl_kembali')")){
                    trace_event("INSERT tbl_transaksi BERHASIL");

                    if(mysqli_query($conn,"DELETE FROM tbl_req_kembali WHERE id='$id'")){
                        trace_event("DELETE FROM tbl_req_kembali id=$id BERHASIL");

                        $konten = "Permintaan Pengembalian Barang Anda Telah di Terima. ".$jml_barang." buah ".$nama_barang.". Peminjam: ".$peminjam;

                        if(mysqli_query($conn,"INSERT INTO pemberitahuan (username, konten, status) VALUES ('$peminjam', '$konten', 'kembali')")){
                            trace_event("INSERT pemberitahuan BERHASIL untuk username=$peminjam");
                            echo "<script>alert('Berhasil Memproses Pengembalian Barang');</script>";
                            header('location: barang-dipinjam.php');
                        }else{
                            trace_event("GAGAL INSERT pemberitahuan: ".mysqli_error($conn));
                            echo "Gagal Menambah Pemberitahuan";
                        }
                    }else{
                        trace_event("GAGAL DELETE tbl_req_kembali: ".mysqli_error($conn));
                        echo "Gagal Hapus tbl_req_kembali";
                    }
                }else{
                    trace_event("GAGAL INSERT tbl_transaksi: ".mysqli_error($conn));
                    echo "Gagal insert ke tbl_transaksi";
                }
            }else{
                trace_event("GAGAL UPDATE tbl_barang: ".mysqli_error($conn));
                echo "Gagal Update Stok Barang";
            }
        }else{
            trace_event("GAGAL MENCARI barang: ".$nama_barang);
            echo "Gagal Mencari barang";
        }
    }
?>
