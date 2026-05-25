<?php

session_start();

include 'config.php';
include 'db.php';

/*
========================================
PROSES LOGIN
========================================
*/

if(isset($_POST['login'])){

    $username = mysqli_real_escape_string(
        $conn,
        $_POST['username']
    );

    $password = md5(
        mysqli_real_escape_string(
            $conn,
            $_POST['password']
        )
    );

    /*
    ========================================
    CEK USERNAME
    ========================================
    */

    $sql = "
        SELECT *
        FROM user
        WHERE username='$username'
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

        if($password == $data['password']){

            /*
            ========================================
            SESSION LOGIN
            ========================================
            */

            $_SESSION['username'] = $data['username'];

            $_SESSION['name'] = $data['nama'];

            $_SESSION['uid'] = $data['uid'];

            $_SESSION['level'] = $data['level'];

            /*
            ========================================
            TRACE LOGIN
            ========================================
            */

            trace_event(
                $conn,
                "LOGIN SUCCESS username=".$username
            );

            /*
            ========================================
            REDIRECT BERDASARKAN LEVEL
            ========================================
            */

            if($data['level'] == 'admin'){

                header(
                    'Location: admin/index.php'
                );

            }

            elseif($data['level'] == 'petugas'){

                header(
                    'Location: petugas/index.php'
                );

            }

            elseif($data['level'] == 'peminjam'){

                header(
                    'Location: peminjam/index.php'
                );

            }

            else{

                echo "
                <script>

                alert('Level user tidak ditemukan');

                window.location='login.php';

                </script>
                ";

            }

        }else{

            trace_event(
                $conn,
                "LOGIN FAILED password salah"
            );

            echo "
            <script>

            alert('Password salah');

            window.history.back();

            </script>
            ";

        }

    }else{

        trace_event(
            $conn,
            "LOGIN FAILED username tidak ditemukan"
        );

        echo "
        <script>

        alert('Username tidak ditemukan');

        window.history.back();

        </script>
        ";

    }

}

?>