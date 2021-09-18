<?php
$user_id = $this->session->userdata('id');
$user = $this->user_model->user_detail($user_id);
$meta = $this->meta_model->get_meta();
?>


<nav class="site-header bg-white sticky-top py-1 shadow-sm">
    <div class="container py-2 d-flex justify-content-between align-items-center">
        <a style="text-decoration:none;" class="text-dark text-left" href="javascript:history.back()"><i style="font-size: 25px;" class="ri-arrow-left-line"></i></a>
        <span class="text-dark text-center font-weight-bold">
            <?php echo $title; ?>
        </span>
        <div style="color:transparent;"></div>
    </div>
</nav>

<?php

if (isset($errors_upload)) {
    echo '<div class="alert alert-warning">' . $error_upload . '</div>';
}
//Notifikasi
if ($this->session->flashdata('message')) {
    echo $this->session->flashdata('message');
    unset($_SESSION['message']);
}
?>
<div class="container my-3 pb-5">
    <div class="col-md-7 mx-auto my-3">

        <?php if ($user->saldo_driver <= 0) : ?>
            <div class="card bg-danger mb-3">
                <div class="card-body text-white">
                    <h3>Rp. <?php echo number_format($user->saldo_driver, 0, ",", ","); ?></h3>
                    <a class="text-white" href="<?php echo base_url('driver/topup/riwayat'); ?>">Riwayat Top Up Saldo</a>
                </div>

            </div>
        <?php else : ?>
            <div class="card bg-info mb-3">
                <div class="card-body text-white">
                    <h3>Rp. <?php echo number_format($user->saldo_driver, 0, ",", ","); ?></h3>
                    <a class="text-white" href="<?php echo base_url('driver/topup/riwayat'); ?>">Riwayat Top Up Saldo</a>
                </div>

            </div>
        <?php endif; ?>


        <div class="card bg-primary my-3">
            <div class="card-body text-white">
                <img width="20%" src="<?php echo base_url('assets/img/bank/' . $bank->bank_logo); ?>" class="img-fluid mb-2">
                <h5><?php echo $bank->bank_account; ?></h5>
                <h3><?php echo $bank->bank_number; ?></h3>
            </div>
        </div>


        <?php if ($my_topup == NULL) : ?>
        <?php else : ?>
            <div class="card table-responsive p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode Top Up</th>
                            <th>Nominal</th>
                            <!-- <th>Barcode</th> -->
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($my_topup as $my_topup) : ?>
                            <tr>
                                <td><?php echo $my_topup->code_topup; ?></td>
                                <td>Rp. <?php echo number_format($my_topup->nominal, 0, ",", "."); ?><br>
                                    <span class="badge badge-pill badge-danger"> <?php echo $my_topup->status_bayar; ?></span>
                                </td>
                                <td>
                                    <a href="<?php echo base_url('driver/topup/detail/' . $my_topup->id); ?>" class="btn btn-success btn-sm btn-block">Detail</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php if ($my_topup == NULL) : ?>
            <?php echo form_open_multipart('driver/topup', array('class' => 'needs-validation', 'novalidate' => 'novalidate')); ?>


            <h6>Silahkan Pilih Nominal Top Up</h6>
            <div class="row">
                <?php foreach ($nominal as $nominal) : ?>
                    <div class="col-md-4">
                        <div class="card my-2">
                            <div class="card-body">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="customRadio<?php echo $nominal->id; ?>" name="nominal" value="<?php echo $nominal->nilai_topup; ?>" required>
                                    <label for="customRadio<?php echo $nominal->id; ?>" class="custom-control-label">Rp. <?php echo number_format($nominal->nilai_topup, 0, ",", "."); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
            <div class="invalid-feedback">Silahkan Pilih Nominal Top Up.</div>


            <div class="col-12 mx-auto my-3">
                <h6>Silahkan Unggah Foto Bukti Transfer</h6>
                <div class="custom-file">
                    <input type='file' class="custom-file-input" id="customFile" name="foto_struk" required>
                    <label class="custom-file-label" for="customFile">Ambil Foto</label>
                </div>

                <br>
                <img class="img-fluid mt-4" id="gambar" src="#" alt="Ambil Foto" OnError=" $(this).hide();" />
                <div class="invalid-feedback">Silahkan Masukan Foto Stuk transfer.</div>
            </div>

            <button type="submit" class="btn btn-info btn-block">Lanjutkan</button>
            <?php echo form_close(); ?>
        <?php else : ?>
            <div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Transaksi Pending!</h5>Maaf Anda tidak dapat melakukan Top Up karena Masih Ada Top Up Pending, silahkan Batalkan Atau Konfirmasi Ke Admin melalui Whatsapp : <?php echo $meta->telepon; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#gambar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#customFile").change(function() {
        $('#gambar').show();
        readURL(this);
    });
</script>