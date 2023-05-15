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
		} else{
            set_flash_massage('register_success','Username atau password tidak ditemukan');
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
    $v= htmlspecialchars(strtolower(stripcslashes($form['v'])));
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
            jmlh_anggota_keluarga='$jmlh_anggota_keluarga',
            v= '$v'
        WHERE id = '$id'    
         ");
         return redirect('settings.php');
    }
    
    $mysql = $connection->query("INSERT INTO settings (luas_lahan, penghasilan,hasil_panen,lama_usaha_tani,jmlh_anggota_keluarga,v) VALUES ('$luas_lahan','$penghasilan', '$hasil_panen','$lama_usaha_tani', '$jmlh_anggota_keluarga','$v')");
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

function proses_vikor() {
    global $connection;
    try {
        $connection->query("DELETE FROM hasil");
        // 1. ambil semua data kriteria dari db
        $data_settings = $connection->query("SELECT * FROM settings")->fetch_all(MYSQLI_ASSOC);
        $data_petani = $connection->query("
        SELECT
            *
        FROM
            data_petani
        INNER JOIN
            data_kriteria
        ON 
            data_petani.id = data_kriteria.id_petani
	")->fetch_all(MYSQLI_ASSOC);

        $v = $data_settings[0]['v'];

        // 2. ambil nilai max dan min di setiap data
        $max = [
            'max_luas_lahan' => max(array_column($data_petani, 'luas_lahan')),
            'max_penghasilan' => max(array_column($data_petani, 'penghasilan')),
            'max_lama_usaha_tani' => max(array_column($data_petani, 'lama_usaha_tani')),
            'max_hasil_panen' => max(array_column($data_petani, 'hasil_panen')),
            'max_jmlh_anggota_keluarga' => max(array_column($data_petani, 'jmlh_anggota_keluarga'))
        ];

        $min = [
            'min_luas_lahan' => min(array_column($data_petani, 'luas_lahan')),
            'min_penghasilan' => min(array_column($data_petani, 'penghasilan')),
            'min_lama_usaha_tani' => min(array_column($data_petani, 'lama_usaha_tani')),
            'min_hasil_panen' => min(array_column($data_petani, 'hasil_panen')),
            'min_jmlh_anggota_keluarga' => min(array_column($data_petani, 'jmlh_anggota_keluarga'))
        ];


        $matrix_normal = array();
        foreach ($data_petani as $data) {
            $luas_lahan = ($max['max_luas_lahan'] - $data['luas_lahan']) / ($max['max_luas_lahan'] - $min['min_luas_lahan']);
            $penghasilan = ($max['max_penghasilan'] - $data['penghasilan']) / ($max['max_penghasilan'] - $min['min_penghasilan']);
            $hasil_panen = ($max['max_hasil_panen'] - $data['hasil_panen']) / ($max['max_hasil_panen'] - $min['min_hasil_panen']);
            $lama_usaha_tani = ($max['max_lama_usaha_tani'] - $data['lama_usaha_tani']) / ($max['max_lama_usaha_tani'] - $min['min_lama_usaha_tani']);
            $jmlh_anggota_keluarga = ($max['max_jmlh_anggota_keluarga'] - $data['jmlh_anggota_keluarga']) / ($max['max_jmlh_anggota_keluarga'] - $min['min_jmlh_anggota_keluarga']);
            $matrix_normal[] = [
                'matrix_normal_luas_lahan' => $luas_lahan,
                'matrix_normal_penghasilan' => $penghasilan,
                'matrix_normal_hasil_panen' => $hasil_panen,
                'matrix_normal_lama_usaha_tani' => $lama_usaha_tani,
                'matrix_normal_jmlh_anggota_keluarga' => $jmlh_anggota_keluarga,
                'id_petani' => $data['id_petani']
            ];
        }

        // 2. normalisasi bobot
        $bobot_normal = array();
        foreach ($matrix_normal as $matrix) {
            foreach ($data_settings as $setting) {
                $bobot_normal_luas_lahan = $matrix['matrix_normal_luas_lahan'] * $setting['luas_lahan'];
                $bobot_normal_penghasilan = $matrix['matrix_normal_penghasilan'] * $setting['penghasilan'];
                $bobot_normal_hasil_panen = $matrix['matrix_normal_hasil_panen'] * $setting['hasil_panen'];
                $bobot_normal_lama_usaha_tani = $matrix['matrix_normal_lama_usaha_tani'] * $setting['lama_usaha_tani'];
                $bobot_normal_jmlh_anggota_keluarga = $matrix['matrix_normal_jmlh_anggota_keluarga'] * $setting['jmlh_anggota_keluarga'];
                $bobot_normal[] = [
                    'bobot_normal_luas_lahan' => $bobot_normal_luas_lahan,
                    'bobot_normal_penghasilan' => $bobot_normal_penghasilan,
                    'bobot_normal_hasil_panen' => $bobot_normal_hasil_panen,
                    'bobot_normal_lama_usaha_tani' => $bobot_normal_lama_usaha_tani,
                    'bobot_normal_jmlh_anggota_keluarga' => $bobot_normal_jmlh_anggota_keluarga,
                    'total_bobot_normal' => $bobot_normal_luas_lahan + $bobot_normal_penghasilan + $bobot_normal_hasil_panen + $bobot_normal_lama_usaha_tani + $bobot_normal_jmlh_anggota_keluarga,
                    'id_petani' => $matrix['id_petani']
                ];
            }
        }

        // 3. cari nilai min max  bobot normal
        $bobot_max = array();
        $i = 0;
        foreach ($bobot_normal as $bobot) {
            $bobot_max[] = max($bobot['bobot_normal_luas_lahan'], $bobot['bobot_normal_penghasilan'], $bobot['bobot_normal_hasil_panen'], $bobot['bobot_normal_lama_usaha_tani'], $bobot['bobot_normal_jmlh_anggota_keluarga'] );
            $i++;
        }

        $Rplus = max($bobot_max);
        $Rmin = min($bobot_max);
        $Splus = max(array_column($bobot_normal, 'total_bobot_normal'));
        $Smin = min(array_column($bobot_normal, 'total_bobot_normal'));


        $nilai_alternatif = array();
        // 4. menghitung nilai alternatif V = 0.5
        $i= 0;
        foreach ($bobot_normal as $bobot) {
            $nilai_akhir = round((($v *(($bobot['total_bobot_normal']-$Smin)/($Splus-$Smin))) + ((1-$v)*($bobot_max[$i]-$Rmin))/($Rplus-$Rmin)), 4);
            $nilai_alternatif[] =  [
                'nilai_akhir' => $nilai_akhir,
                'status' =>  $nilai_akhir <= 0.5 ? "Layak" : "Tidak Layak",
                'id_petani' => $bobot['id_petani']
            ];
            $i++;
        }

        /* update data */
        $data_hasil = $connection->query("SELECT * FROM hasil")->num_rows;

        if ($data_hasil > 0) {
            // jika terdapat data maka hapus
            $connection->query("DELETE FROM hasil");
            $total_data = count($nilai_alternatif);
            $i = 0;
            foreach ($nilai_alternatif as $alternatif) {
                $id_petani = $alternatif['id_petani'];
                $nilai_akhir = $alternatif['nilai_akhir'];
                $status = $alternatif['status'];
                $connection->query("INSERT INTO hasil (id_petani, nilai_akhir, status) VALUES ('$id_petani', '$nilai_akhir', '$status')");
                $i += $connection->affected_rows;
            }
            if ($i == $total_data) {
                set_flash_message('success_kalkulasi', 'Berhasil update data alternatif');
            }
            return redirect('index.php');
        } else {
            // jika tabel kosong
            $total_data = count($nilai_alternatif);
            $i = 0;
            foreach ($nilai_alternatif as $alternatif) {
                $id_petani = $alternatif['id_petani'];
                $nilai_akhir = $alternatif['nilai_akhir'];
                $status = $alternatif['status'];
                $connection->query("INSERT INTO hasil (id_petani, nilai_akhir, status) VALUES ('$id_petani', '$nilai_akhir', '$status')");
                $i += $connection->affected_rows;
            }
            if ($i == $total_data) {
                set_flash_message('success_kalkulasi', 'Berhasil kalkulasi');
            }
        }
    }catch (Throwable $e) {
        set_flash_message("failed_kalkulasi", "Gagal menentukan nilai max dan min");
    }
    return redirect('index.php');
}

function ambil_data_hasil_alternatif() {
    global $connection;
    $data_hasil_alternatif = $connection->query("
    SELECT
	    *
    FROM
	    data_petani
	INNER JOIN
	    hasil
	ON 
		data_petani.id = hasil.id_petani
	")->fetch_all(MYSQLI_ASSOC);

    return $data_hasil_alternatif;
}

?>