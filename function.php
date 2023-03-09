<?php

include 'connection.php';
include 'helper.php';

function create_user($form) {
    global $connection;

    $username = htmlspecialchars(strtolower(stripcslashes($form['username'])));
    $password = mysqli_escape_string($connection, $form['password']);
    $confirm_password =  mysqli_escape_string($connection, $form['confirm_password']);
    $has_password = password_hash($password, PASSWORD_DEFAULT);


    if ($password != $confirm_password) {
        set_flash_message('password_error', 'Password tidak sesuai');
        return;
    }

    $mysql = $connection->query("INSERT INTO users (username, password) VALUES ('$username', '$has_password')");

    if ($connection->affected_rows > 0) {
        set_flash_message('register_success', 'Berhasil melakukan pendaftaran');
        redirect('login.php');
    } else {
        set_flash_message('register_failed', 'Gagal melakukan pendaftaran');
    }
}
function login($form){
    global $connection;


    $username = $form['username'];
	$password = $form['password'];
	$check_username_query = "SELECT * FROM users WHERE username = '$username'";
	$check_username_result = mysqli_query($connection, $check_username_query);
	$username_in_db = mysqli_fetch_assoc($check_username_result);
    
	if ($username== $username_in_db['username']){
		if (password_verify($password, $username_in_db['password'])){
            $_SESSION['login']=true;
			header('Location:index.php');
			exit;
		}
	}
}  
?>