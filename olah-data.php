<?php
    session_start();
    include "function.php";

    if (isset($_POST['data-petani'])) {
        tambah_data_petani($_POST);
    }
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
                    <form method="POST">
                        <div class="card card-body">
                            <h5 class="card-title">Tambah Data Petani</h5>
                            <div class="row">
                                <input type="hidden" name="id" value="">
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
                                    <button type="submit" name="data-petani" class="btn btn-primary mr-2">Submit</button>
                                    <button type="reset"  class="btn btn-danger mx-2">Batal</button>
                                </div>
                            </div>
                        </div>
                    </form>
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

</body>

</html>