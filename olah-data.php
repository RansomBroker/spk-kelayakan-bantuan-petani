<?php
    session_start();
    include "function.php";

    if(!isset($_SESSION['login'])){
        redirect('login.php');
    }
    if (isset($_POST['data-petani'])) {
        if ($_POST['id'] != "") {
            update_data_petani($_POST);
        }

        if ($_POST['id'] = "") {
            tambah_data_petani($_POST);
        }
    }

    ambil_data_petani();
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <?php include "head.php"?>

    <title>Olah Data Petani</title>

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
                    <h1 class="h3 mb-0 text-gray-800">Olah Data Petani</h1>
                </div>

                <div class="card card-body">
                    <?php if (get_flash_name('success_tambah_petani') != ""):?>
                        <div class="alert alert-success">
                            <?= get_flash_message('success_tambah_petani')?>
                        </div>
                    <?php endif;?>
                    <?php if (get_flash_name('failed_tambah_petani') != ""):?>
                        <div class="alert alert-danger">
                            <?= get_flash_message('failed_tambah_petani')?>
                        </div>
                    <?php endif;?>
                    <form method="POST" id="form-petani">
                        <div class="card card-body">
                            <h5 class="card-title">Tambah Data Petani</h5>
                            <div class="row">
                                <input type="text" name="id" value="" class="d-none">
                                <div class="col-lg-3 col-12 mb-2">
                                    <label class="form-label">Kode Petani <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="kode-petani" required>
                                </div>
                                <div class="col-lg-4 col-12 mb-2">
                                    <label class="form-label">Nama Petani <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="nama-petani" required>
                                </div>
                                <div class="col-lg-4 col-12 mb-2">
                                    <label class="form-label">Alamat Petani<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="alamat-petani" required>
                                </div>
                                <div class="col-lg-4 col-12 mb-2">
                                    <label class="form-label">Tgl Permohonan <sup class="text-danger">*</sup></label>
                                    <input type="date" class="form-control" name="tgl-permohonan" required>
                                </div>
                                <div class="col-lg-4 col-12 mb-2">
                                    <label class="form-label">Nomor Telepon <sup class="text-danger">*</sup></label>
                                    <input type="tel" class="form-control" name="telpon" required>
                                </div>
                                <div class="col-lg-4 col-12 mb-2">
                                    <label class="form-label">Nomor KTP <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="ktp" required>
                                </div>
                            </div>
                            <div class="col-12 p-0 mt-2">
                                <div class="d-flex justify-content-start">
                                    <button type="submit" name="data-petani" class="btn-submit btn btn-primary mr-2">Submit</button>
                                    <button class="btn-reset btn btn-danger mx-2">Batal</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="card card-body my-3">
                        <h5 class="card-title">Data Petani</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="table-data-petani">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Kode Petani</th>
                                        <th>Nama Petani</th>
                                        <th>Alamat</th>
                                        <th>Tgl Permohonan</th>
                                        <th>No Telpon</th>
                                        <th>No KTP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (ambil_data_petani() as $data_petani):?>
                                        <tr data-id-petani="<?= $data_petani['id']?>">
                                            <td><a href="hapus-data-petani.php?id=<?=$data_petani['id']?>" class="btn btn-danger">Hapus</a></td>
                                            <td><?= $data_petani['kode_petani']?></td>
                                            <td><?= $data_petani['nama_petani']?></td>
                                            <td><?= $data_petani['alamat']?></td>
                                            <td><?= $data_petani['tgl_pemohonan']?></td>
                                            <td><?= $data_petani['no_telp']?></td>
                                            <td><?= $data_petani['no_telp']?></td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
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
            let tableDataPetani = $("#table-data-petani").DataTable();

            $("#table-data-petani tbody").on('click', 'tr', function () {
                let idPetani = $(this).attr('data-id-petani');
                if ($(this).hasClass('selected')) {
                    $('.btn-submit').text('Submit')
                    $('input[name=kode-petani]').prop('readonly', false);
                    $('#form-petani')[0].reset();
                    $(this).removeClass('selected bg-primary text-white');
                } else {
                    tableDataPetani.$('tr.selected').removeClass('selected bg-primary text-white');
                    $(this).addClass('selected bg-primary text-white');
                    $('.btn-submit').text('Simpan Edit Data')
                    $.ajax({
                        url: 'ambil-data-petani.php?id=' + idPetani,
                        method: 'GET',
                        success: function (response) {
                            let data = JSON.parse(response)
                            /* set data jadi isi dari value */
                            $('input[name=kode-petani]').prop('readonly', true);
                            $('input[name=id]').val(data.id);
                            $('input[name=kode-petani]').val(data.kode_petani.toUpperCase());
                            $('input[name=nama-petani]').val(data.nama_petani);
                            $('input[name=alamat-petani]').val(data.alamat);
                            $('input[name=tgl-permohonan]').val(data.tgl_pemohonan);
                            $('input[name=telpon]').val(data.no_telp);
                            $('input[name=ktp]').val(data.no_ktp);
                        }
                    })
                }
            })

            /* batal */
            $(".btn-reset").click(function (e) {
                e.preventDefault();
                $('.btn-submit').text('Simpan Edit Data')
                $('input[name=id]').val();
                $('input[name=kode-petani]').prop('readonly', false);
                if ($('#table-data-petani tbody tr').hasClass('selected')) {
                    $('#table-data-petani tbody tr').removeClass('selected bg-primary text-white');
                }
                $('#form-petani')[0].reset();
            })

            $("input[name=kode-petani]").on('keyup', function () {
                $(this).val($(this).val().toUpperCase())
            })
        })
    </script>
</body>

</html>