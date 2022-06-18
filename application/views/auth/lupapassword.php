<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>KBMK Gunadarma | Lupa Password</title>

    <link href="<?= base_url(); ?>assets/template/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/template/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?= base_url(); ?>assets/template/css/animate.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/template/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <h3>Selamat Datang di KBMK</h3>
            </br>
            <p>Silakan masukkan email untuk mereset password</p>

            <?php if ($this->session->flashdata('sukses')) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <?php echo $this->session->flashdata('sukses') ?>
                </div>
            <?php
            } ?>

            <?php echo form_open("auth/lupa_password"); ?>
            <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>" placeholder="Email" autofocus>
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Reset Password</button>

            <a href=<?php echo base_url(); ?>index.php/auth/login><small>Login</small></a>
            <p class="text-muted text-center"><small>Belum punya akun?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="<?php echo base_url(); ?>index.php/auth/register">Buat akun baru</a>
            <?php echo form_close(); ?>
            <p class="m-t"> <small>KBMK &copy; 2022.</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url(); ?>assets/template/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/js/bootstrap.min.js"></script>

</body>

</html>