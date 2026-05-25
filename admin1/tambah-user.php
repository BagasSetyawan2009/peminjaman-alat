<?php

session_start();

include '../config.php';
include '../db.php';

/*
========================================
CEK LOGIN ADMIN
========================================
*/

if(
    !isset($_SESSION['login']) ||
    !isset($_SESSION['admin'])
){
    header("Location: ../login.php");
    exit;
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>
        Tambah User
    </title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    >

</head>

<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card">

                <div class="card-header bg-primary text-white">

                    <h4>
                        Tambah User
                    </h4>

                </div>

                <div class="card-body">

                    <form
                        method="POST"
                        action="proses-tambah-user.php"
                    >

                        <!-- NAMA -->

                        <div class="mb-3">

                            <label>
                                Nama
                            </label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                required
                            >

                        </div>

                        <!-- USERNAME -->

                        <div class="mb-3">

                            <label>
                                Username
                            </label>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                required
                            >

                        </div>

                        <!-- PASSWORD -->

                        <div class="mb-3">

                            <label>
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required
                            >

                        </div>

                        <!-- LEVEL -->

                        <div class="mb-3">

                            <label>
                                Level
                            </label>

                            <select
                                name="level"
                                class="form-control"
                                required
                            >

                                <option value="">
                                    -- Pilih Level --
                                </option>

                                <option value="admin">
                                    Admin
                                </option>

                                <option value="petugas">
                                    Petugas
                                </option>

                                <option value="peminjam">
                                    Peminjam
                                </option>

                            </select>

                        </div>

                        <!-- BUTTON -->

                        <button
                            type="submit"
                            class="btn btn-success"
                        >

                            Simpan

                        </button>

                        <a
                            href="data-user.php"
                            class="btn btn-secondary"
                        >

                            Kembali

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>