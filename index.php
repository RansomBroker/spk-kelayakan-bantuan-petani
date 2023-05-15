<?php
session_start();
include "function.php";
if(!isset($_SESSION['login'])){
    redirect('login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include "head.php"?>

    <title>SPK</title>

    <?php include "css.php"?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    <?php include "sidebar.php";?>    

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                
                <?php include "navbar.php";?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <?php if (get_flash_name('success_kalkulasi') != ""):?>
                        <div class="alert alert-success">
                            <?= get_flash_message('success_kalkulasi')?>
                        </div>
                    <?php endif;?>
                    <?php if (get_flash_name('failed_kalkulasi') != ""):?>
                        <div class="alert alert-danger">
                            <?= get_flash_message('failed_kalkulasi')?>
                        </div>
                    <?php endif;?>

                    <div class="card card-body my-3">
                        <h5 class="card-title">Data Alternatif</h5>
                        <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" id="table-data-alternatif">
                                    <thead>
                                    <tr>
                                        <th>Kode Petani</th>
                                        <th>Nama Petani</th>
                                        <th>Luas Lahan</th>
                                        <th>Penghasilan</th>
                                        <th>Hasil Panen</th>
                                        <th>Lama Usaha</th>
                                        <th>Jmlh Anggota Keluarga</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach (ambil_data_alternatif() as $data_alternatif):?>
                                        <tr data-id-petani="<?= $data_alternatif['id']?>">
                                            <td><?= $data_alternatif['kode_petani']?></td>
                                            <td><?= $data_alternatif['nama_petani']?></td>
                                            <td><?= $data_alternatif['luas_lahan']?></td>
                                            <td><?= $data_alternatif['penghasilan']?></td>
                                            <td><?= $data_alternatif['hasil_panen']?></td>
                                            <td><?= $data_alternatif['lama_usaha_tani']?></td>
                                            <td><?= $data_alternatif['jmlh_anggota_keluarga']?></td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                    <div class="col-12  mt-2">
                        <div class="d-flex justify-content-center">
                            <a href="proses-vikor.php"class=" btn btn-primary mr-2">Proses Vikor</a>

                        </div>
                    </div>
                    <div class="card card-body my-3">
                        <h5 class="card-title">Data Alternatif</h5>
                        <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" id="table-data-hasil-alternatif">
                                    <thead>
                                    <tr>
                                        <th>Kode Petani</th>
                                        <th>Nama Petani</th>
                                        <th>Nilai Hasil</th>
                                        <th>Keterangan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach (ambil_data_hasil_alternatif() as $data_alternatif):?>
                                        <tr data-id-petani="<?= $data_alternatif['id']?>">
                                            <td><?= $data_alternatif['kode_petani']?></td>
                                            <td><?= $data_alternatif['nama_petani']?></td>
                                            <td><?= $data_alternatif['nilai_akhir']?></td>
                                            <td><?= $data_alternatif['status']?></td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>


        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php include "js.php"?>
    <script>
        $(document).ready(function () {
            let tableDataAlternatif = $("#table-data-alternatif").DataTable();
            let tableDataHasilAlternatif = $("#table-data-hasil-alternatif").DataTable();      
        })
    </script>

</body>

</html>