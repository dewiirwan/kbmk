<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Informasi Lithang SEGAR Cilodong (SILSCI) | Registrasi Akun</title>


    <link href="<?php echo base_url(); ?>assets/template/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/template/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/template/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/template/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <h3>Selamat Datang di KBMK</h3>
            </br>
            <p>Silakan mendaftar untuk mendapatkan hak akses</p>
            <?php if ($message != "") { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <?php echo $message; ?>
                </div>
            <?php } ?>


            <?php echo form_open("auth/register"); ?>
            <div class="form-group">
                <input type="text" class="form-control" name="NIK" id="NIK" value="<?php echo set_value('NIK'); ?>" placeholder="Contoh : NIK" autofocus>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="NAMA" id="NAMA" value="<?php echo set_value('NAMA'); ?>" placeholder="Contoh: Nama" autofocus>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="TEMPAT_TANGGAL_LAHIR" id="TEMPAT_TANGGAL_LAHIR" value="<?php echo set_value('TEMPAT_TANGGAL_LAHIR'); ?>" placeholder="Contoh: JAKARTA, 15 DESEMBER 2001" autofocus>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="ALAMAT" id="ALAMAT" value="<?php echo set_value('ALAMAT'); ?>" placeholder="Contoh: Alamat" autofocus>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>" placeholder="Contoh: Email" autofocus>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="NO_HP" id="NO_HP" value="<?php echo set_value('NO_HP'); ?>" placeholder="Contoh: 082158685xxx" autofocus>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" value="<?php echo set_value('password'); ?>" placeholder="Contoh: Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password_confirm" id="password_confirm" value="<?php echo set_value('password_confirm'); ?>" placeholder="Contoh: Confirm Passowrd">
            </div>
            <div class="form-group">
                <div class="checkbox i-checks"><label> <input type="checkbox" id="terms"><i></i> Saya setuju tentang syarat dan ketentuan </label></div>
            </div>
            <button id="daftar" type="submit" class="btn btn-primary block full-width m-b" disabled>Register</button>


            <a class="btn btn-sm btn-white btn-block" href="<?php echo base_url(); ?>index.php/auth/login">Kembali ke halaman Login</a>
            <?php echo form_close(); ?>
            <p class="m-t"> <small>SILSCI &copy; 2021. Tema oleh Inspinia</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url(); ?>assets/template/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>

    <script>
        $('#terms').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#daftar').removeAttr('disabled'); //enable input

            } else {
                $('#daftar').attr('disabled', true); //disable input
            }
        });
    </script>
</body>

</html>