<?php

include 'connection.php';
include 'helper.php';

function create_user($form) {
    global $connection;

    $username = htmlspecialchars(strtolower(stripcslashes($form['username'])));
    $password = mysqli_escape_string($connection, $form['password']);
    $confirm_password = mysqli_escape_string($connection, $form['confirm_password']);
    $has_password = password_hash($password, PASSWORD_DEFAULT);

    if ($password != $confirm_password) {
        set_flash_message('password_error', 'Password tidak sesuai');
    }

    $mysql = $connection->query("INSERT INTO users (username, password) VALUES ('$username', '$has_password')");

    if ($connection->affected_rows > 0) {
        set_flash_message('register_success', 'Berhasil melakukan pendaftaran');
    } else {
        set_flash_message('register_failed', 'Gagal melakukan pendaftaran');
    }

    return $connection->affected_rows;

}

function tambah_data_petani($form) {
    global $connection;

    $kode_petani = htmlspecialchars(strtolower(stripcslashes($form['kode-petani'])));
    $nama_petani = htmlspecialchars(strtolower(stripcslashes($form['nama-petani'])));
    $alamat_petani = htmlspecialchars(strtolower(stripcslashes($form['alamat-petani'])));
    $tgl_permohonan = $form['tgl-permohonan'];
    $telpon = htmlspecialchars(strtolower(stripcslashes($form['telpon'])));
    $ktp = htmlspecialchars(strtolower(stripcslashes($form['ktp'])));

    $query = $connection->query("
        INSERT INTO data_petani 
            (kode_petani, nama_petani, alamat, no_telp, no_ktp, tgl_pemohonan)
        VALUES ('$kode_petani','$nama_petani', '$alamat_petani', '$telpon', '$ktp', '$tgl_permohonan')
        ");


    if ($connection->affected_rows > 0) {
        set_flash_message('success_tambah_petani', 'Berhasil menambahkan data petani');
    } else {
        set_flash_message('failed_tambah_petani', 'Gagal menambahkan data petani');
    }

}
?>