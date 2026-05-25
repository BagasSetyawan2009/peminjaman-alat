<?php

session_start();

include 'config.php';
include 'db.php';

/*
========================================
CEK KONEKSI DATABASE
========================================
*/

if(!$conn){

    die(
        "Koneksi database gagal : " .
        mysqli_connect_error()
    );

}

/*
========================================
PROSES LOGIN
========================================
*/

if(isset($_POST['login'])){

    /*
    ========================================
    AMBIL INPUT
    ========================================
    */

    $username = mysqli_real_escape_string(
        $conn,
        trim($_POST['username'])
    );

    $password = mysqli_real_escape_string(
        $conn,
        trim($_POST['password'])
    );

    /*
    ========================================
    VALIDASI INPUT
    ========================================
    */

    if(empty($username) || empty($password)){

        echo "
        <script>
            alert('Username dan Password wajib diisi!');
            window.location='login.php';
        </script>
        ";

        exit;

    }

    /*
    ========================================
    CEK USERNAME
    ========================================
    */

    $sql = "
        SELECT *
        FROM user
        WHERE username = '$username'
    ";

    $query = mysqli_query($conn, $sql);

    /*
    ========================================
    USER DITEMUKAN
    ========================================
    */

    if(mysqli_num_rows($query) > 0){

        $data = mysqli_fetch_assoc($query);

        /*
        ========================================
        CEK PASSWORD
        ========================================
        */

        if(md5($password) == $data['password']){

            /*
            ========================================
            BUAT SESSION LOGIN
            ========================================
            */

            $_SESSION['login']    = true;

            $_SESSION['uid']      = $data['uid'];

            $_SESSION['username'] = $data['username'];

            $_SESSION['nama']     = $data['nama'];

            $_SESSION['level']    = $data['level'];

            /*
            ========================================
            LOGIN ADMIN
            ========================================
            */

            if($data['level'] == 'admin'){

                $_SESSION['admin'] = true;

                echo "
                <script>
                    alert('Login Admin berhasil!');
                    window.location='admin/index.php';
                </script>
                ";

                exit;

            }

            /*
            ========================================
            LOGIN PETUGAS
            ========================================
            */

            elseif($data['level'] == 'petugas'){

                $_SESSION['petugas'] = true;

                echo "
                <script>
                    alert('Login Petugas berhasil!');
                    window.location='petugas/index.php';
                </script>
                ";

                exit;

            }

            /*
            ========================================
            LOGIN PEMINJAM
            ========================================
            */

            elseif($data['level'] == 'peminjam'){

                $_SESSION['peminjam'] = true;

                echo "
                <script>
                    alert('Login Peminjam berhasil!');
                    window.location='peminjam/index.php';
                </script>
                ";

                exit;

            }

            /*
            ========================================
            LEVEL TIDAK DITEMUKAN
            ========================================
            */

            else{

                echo "
                <script>
                    alert('Level user tidak ditemukan!');
                    window.location='login.php';
                </script>
                ";

                exit;

            }

        }

        /*
        ========================================
        PASSWORD SALAH
        ========================================
        */

        else{

            echo "
            <script>
                alert('Password salah!');
                window.location='login.php';
            </script>
            ";

            exit;

        }

    }

    /*
    ========================================
    USERNAME TIDAK ADA
    ========================================
    */

    else{

        echo "
        <script>
            alert('Username tidak ditemukan!');
            window.location='login.php';
        </script>
        ";

        exit;

    }

}

/*
========================================
JIKA FILE DIAKSES LANGSUNG
========================================
*/

else{

    header('Location: login.php');
    exit;

}

?>