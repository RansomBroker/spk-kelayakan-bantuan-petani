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

    /* cehcek apakah ada kode petani yg sama ? */
    $data_petani = $connection->query("SELECT * FROM data_petani WHERE kode_petani  LIKE  '%$kode_petani%'")->num_rows;
    if ($data_petani > 0 ) {
        set_flash_message('failed_tambah_petani', 'Gagal menambahkan data petani. Duplikat Kode Petani');
        return redirect('olah-data.php?halaman=olah-data');
    }
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

    return redirect('olah-data.php?halaman=olah-data');

}

function ambil_data_petani() {
    global $connection;

    $data_petani = $connection->query("SELECT * FROM data_petani")->fetch_all(MYSQLI_ASSOC);

    return $data_petani;
}

function ambil_data_alternatif() {
    global $connection;

    $data_alternatif = $connection->query("
        SELECT
            *
        FROM
            data_petani
        INNER JOIN
            data_kriteria
        ON 
            data_petani.id = data_kriteria.id_petani
	")->fetch_all(MYSQLI_ASSOC);

    return $data_alternatif;
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
    }else{
        set_flash_message('success_settings', 'Berhasil Di Simpan');
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

function tambah_data_alternatif($form) {
    global $connection;

    $luas_lahan= htmlspecialchars(strtolower(stripcslashes($form['luas-lahan'])));
    $penghasilan= htmlspecialchars(strtolower(stripcslashes($form['penghasilan'])));
    $hasil_panen= htmlspecialchars(strtolower(stripcslashes($form['hasil-panen'])));
    $lama_usaha_tani= htmlspecialchars(strtolower(stripcslashes($form['lama-usaha-tani'])));
    $jmlh_anggota_keluarga = htmlspecialchars(strtolower(stripcslashes($form['jumlah-anggota-keluarga'])));
    $id_petani = htmlspecialchars(strtolower(stripcslashes($form['id-petani'])));

    if ($luas_lahan > 5 || $penghasilan > 5 || $hasil_panen > 5 || $lama_usaha_tani > 5 || $jmlh_anggota_keluarga > 5 ) {
        set_flash_message('failed_alternatif', 'Form Input Alternatif Tidak boleh dari 5');
        redirect('olah-data.php?halaman=olah-data');
    }

    $connection->query("
        INSERT INTO data_kriteria 
            (id_petani,luas_lahan, penghasilan, hasil_panen, lama_usaha_tani, jmlh_anggota_keluarga)
        VALUES 
            ('$id_petani' ,'$luas_lahan', '$penghasilan', '$hasil_panen', '$lama_usaha_tani', '$jmlh_anggota_keluarga')
    ");

    if ($connection->affected_rows > 0) {
        set_flash_message('success_alternatif', 'Berhasil tambah data alternatif');
    } else {
        set_flash_message('failed_alternatif', 'Gagal tambah data alternatif');
    }

    redirect('olah-data.php?halaman=olah-data');

}

function update_data_alternatif($form) {
    global $connection;

    $luas_lahan= htmlspecialchars(strtolower(stripcslashes($form['luas-lahan'])));
    $penghasilan= htmlspecialchars(strtolower(stripcslashes($form['penghasilan'])));
    $hasil_panen= htmlspecialchars(strtolower(stripcslashes($form['hasil-panen'])));
    $lama_usaha_tani= htmlspecialchars(strtolower(stripcslashes($form['lama-usaha-tani'])));
    $jmlh_anggota_keluarga = htmlspecialchars(strtolower(stripcslashes($form['jumlah-anggota-keluarga'])));
    $id_alternatif = htmlspecialchars(strtolower(stripcslashes($form['id-alternatif'])));

    if ($luas_lahan > 5 || $penghasilan > 5 || $hasil_panen > 5 || $lama_usaha_tani > 5 || $jmlh_anggota_keluarga > 5 ) {
        set_flash_message('failed_alternatif', 'Form Input Alternatif Tidak boleh dari 5');
        redirect('olah-data.php?halaman=olah-data');
    }

    $connection->query("
        UPDATE data_kriteria 
        SET
            luas_lahan = '$luas_lahan',
            penghasilan = '$penghasilan',
            hasil_panen = '$hasil_panen',
            lama_usaha_tani = '$lama_usaha_tani',
            jmlh_anggota_keluarga = '$jmlh_anggota_keluarga'
        WHERE id = '$id_alternatif'
        ");

    if ($connection->affected_rows > 0) {
        set_flash_message('success_alternatif', 'Berhasil update data alternatif');
    } else {
        set_flash_message('failed_alternatif', 'Gagal update data alternatif');
    }

    redirect('olah-data.php?halaman=olah-data');
}
?>