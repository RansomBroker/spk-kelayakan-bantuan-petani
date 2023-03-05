<?php

include 'connection.php';

function create_user($form) {
    global $connection;

    $username = htmlspecialchars(strtolower(stripcslashes($form['username'])));
    $password = mysqli_escape_string($connection, $form['password']);
    $confirm_password = $password = mysqli_escape_string($connection, $form['confirm_password']);
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

function set_flash_message($name, $message) {

    // if exist then remove
    if (isset($_SESSION[$name])) {
        unset($_SESSION[$name]);
    }

    $_SESSION[$name] = $message;
}


function get_flash_name($name) {

    if (isset($_SESSION[$name])) {
        return $name;
    }
    return "";
}

function get_flash_message($name) {

    if (isset($_SESSION[$name])) {
        $message = $_SESSION[$name];
        unset($_SESSION[$name]);
        return $message;
    } else {
        return '';
    }
}


?>