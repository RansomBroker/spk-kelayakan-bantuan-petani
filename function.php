<?php

include 'connection.php';
include 'helper.php';

function create_user($form) {
    global $connection;

    $username = htmlspecialchars(strtolower(stripcslashes($form['username'])));
    $password = mysqli_escape_string($connection, $form['password']);
    $confirm_password =  mysqli_escape_string($connection, $form['confirm_password']);
    $confirm_password = mysqli_escape_string($connection, $form['confirm_password']);
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
function login($form) {
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

    redirect('olah-data.php?halaman=olah-data');

}

function ambil_data_petani() {
    global $connection;

    $data_petani = $connection->query("SELECT * FROM data_petani")->fetch_all(MYSQLI_ASSOC);

    return $data_petani;
}

function update_data_petani($form) {
    global $connection;

    $id = $form['id'];
    $kode_petani = htmlspecialchars(strtolower(stripcslashes($form['kode-petani'])));
    $nama_petani = htmlspecialchars(strtolower(stripcslashes($form['nama-petani'])));
    $alamat_petani = htmlspecialchars(strtolower(stripcslashes($form['alamat-petani'])));
    $tgl_permohonan = $form['tgl-permohonan'];
    $telpon = htmlspecialchars(strtolower(stripcslashes($form['telpon'])));
    $ktp = htmlspecialchars(strtolower(stripcslashes($form['ktp'])));

    $query = $connection->query("
        UPDATE data_petani 
        SET
            kode_petani = '$kode_petani',
            nama_petani = '$nama_petani',
            alamat = '$alamat_petani',
            tgl_pemohonan = '$tgl_permohonan',
            no_telp = '$telpon',
            no_ktp = '$ktp'
         WHERE id = '$id'
        ");

    if ($connection->affected_rows > 0) {
        set_flash_message('success_tambah_petani', 'Berhasil update data petani');
    } else {
        set_flash_message('failed_tambah_petani', 'Gagal update data petani');
    }

    redirect('olah-data.php?halaman=olah-data');
}
function setting($form){
    global $connection;

    $luas_lahan= htmlspecialchars(strtolower(stripcslashes($form['luas_lahan'])));
    $penghasilan= htmlspecialchars(strtolower(stripcslashes($form['penghasilan'])));
    $hasil_panen= htmlspecialchars(strtolower(stripcslashes($form['hasil_panen'])));
    $lama_usaha_tani= htmlspecialchars(strtolower(stripcslashes($form['lama_usaha_tani'])));
    $jmlh_anggota_keluarga = htmlspecialchars(strtolower(stripcslashes($form['jmlh_anggota_keluarga'])));

    $hasilhitung= $luas_lahan+$penghasilan+$hasil_panen+$lama_usaha_tani+$jmlh_anggota_keluarga;
    if($hasilhitung>1){
        set_flash_message('failed_settings', 'Jumlah Total tidak boleh lebih dari 1');
        return redirect('settings.php');
    }

    $mysql = $connection->query("SELECT *FROM settings");
    $result=$mysql;
    $row_cnt = $result->num_rows;

    if($row_cnt>0){
        $data_setinggs = $connection->query("SELECT * FROM settings")->fetch_assoc();
        $id = $data_setinggs['id'];
        $connection->query("
        UPDATE settings
        SET 
            luas_lahan='$luas_lahan',
            penghasilan='$penghasilan',
            hasil_panen='$hasil_panen',
            lama_usaha_tani='$lama_usaha_tani',
            jmlh_anggota_keluarga='$jmlh_anggota_keluarga'
        WHERE id = '$id'    
         ");
         return redirect('settings.php');
    }
    
    $mysql = $connection->query("INSERT INTO settings (luas_lahan, penghasilan,hasil_panen,lama_usaha_tani,jmlh_anggota_keluarga) VALUES ('$luas_lahan','$penghasilan', '$hasil_panen','$lama_usaha_tani', '$jmlh_anggota_keluarga')");
    return redirect('settings.php');
    
}
function savesetting(){
    global $connection;

    $data_setinggs = $connection->query("SELECT * FROM settings")->fetch_assoc();
    return $data_setinggs;
}

?>