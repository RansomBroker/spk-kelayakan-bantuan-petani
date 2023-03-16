<?php
session_start();
    include "function.php";
    
    if (isset($_POST['setinggs'])) {
        setting($_POST);
    }

    $data_setinggs = savesetting();
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
                    <h1 class="h3 mb-0 text-gray-800">Setting Kriteria </h1>
                </div>

                <div class="card card-body">
                    <?php if (get_flash_name('failed_settings') != ""):?>
                        <div class="alert alert-danger">
                            <?= get_flash_message('failed_settings')?>
                        </div>
                    <?php endif;?>
                    <?php if (get_flash_name('success_settings') != ""):?>
                        <div class="alert alert-success">
                            <?= get_flash_message('success_settings')?>
                        </div>
                    <?php endif;?>
                    <form method="POST" id>
                        <div class="card card-body">
                            <h5 class="card-title">Atur Nilai Kriteria</h5>
                            <div class="row">
                                <input type="hidden" name="id" value="">
                                <div class="col-lg-3 col-12 mb-2">
                                    <label class="form-label">Luas Lahan  <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control desimal-input" name="luas_lahan" value='<?= $data_setinggs == NULL ? '': $data_setinggs['luas_lahan']?>' required>
                                </div>
                                <div class="col-lg-4 col-12 mb-2">
                                    <label class="form-label">Penghasilan <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control desimal-input" name="penghasilan" value='<?= $data_setinggs == NULL ? '': $data_setinggs['penghasilan']?>' required>
                                </div>
                                <div class="col-lg-4 col-12 mb-2">
                                    <label class="form-label">Hasil Panen<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control desimal-input" name="hasil_panen" value='<?= $data_setinggs == NULL ? '': $data_setinggs['hasil_panen']?>' required>
                                </div>
                                <div class="col-lg-3 col-12 mb-2">
                                    <label class="form-label">Lama Usaha Tani <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control desimal-input" name="lama_usaha_tani" value='<?= $data_setinggs == NULL ? '': $data_setinggs['lama_usaha_tani']?>' required>
                                </div>
                                <div class="col-lg-4 col-12 mb-2">
                                    <label class="form-label">Jumlah Anggota Keluarga <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control desimal-input" name="jmlh_anggota_keluarga" value='<?= $data_setinggs == NULL ? '': $data_setinggs['jmlh_anggota_keluarga']?>' required>
                                </div>
                            </div>
                            <div class="col-12 p-0 mt-2">
                                <div class="d-flex justify-content-start">
                                    <button type="submit" name="setinggs" class="btn btn-primary mr-2">Simpan</button>
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
    <script>
       $(document).on('keyup', '.desimal-input', function(e) {
        let value = $(this).val();
        let decimalsign="0.";

        if(value.length <1){
            $(this).val(decimalsign+value)
        }else if (value.length === 1){
            $(this).val(decimalsign+value)
        }else{
            $(this).val(value)
        };

        var regex = /[^\d.]|\.(?=.*\.)/;
        var subst = "";
        var str    = $(this).val();
        var result = str.replace(regex, subst);
        $(this).val(result);

            });
    </script>
</body>
</html>