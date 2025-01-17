<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title; ?></title>

    <link href="<?= base_url(); ?>assets/template/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/template/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?= base_url(); ?>assets/template/css/animate.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/template/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold">Sistem Informasi KBMK Universitas Gunadarma</h2>

                <!-- <p>
                    KBMK Gunadarma
                </p> -->

                <p>
                   <br>
                    KBMK Gunadarma adalah wadah yang digunakan untuk memberikan informasi mengenai pembelajaran agama khonghucu dan kegiatan yang terkait di Universitas Gunadarma.
                    
                </p>

                <p>
                    <small>Silahkan hubungi administrator untuk dapat mengakses aplikasi ini.</small>
                </p>
                </br>
                </br>
                <a href="<?= base_url(); ?>">Kembali ke Home</a>

            </div>
            <div class="col-md-6">
                <?php if ($message != "" || $this->session->flashdata('sukses')) { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?= $message; ?>
                        <?php echo $this->session->flashdata('sukses') ?>
                    </div>
                <?php
                } ?>

                <div class="ibox-content">
                    <?= form_open("auth/login"); ?>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" value="<?= set_value('email'); ?>" placeholder="Email" autofocus>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" value="<?= set_value('password'); ?>" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                    <a href="<?= base_url(); ?>auth/lupa_password"><small>Lupa Password</small></a>

                    <p class="text-muted text-center"><small>Belum punya akun?</small></p>
                    <a class="btn btn-sm btn-white btn-block" href="<?= base_url(); ?>auth/register">Buat akun baru</a>

                    <?= form_close(); ?>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6">
                Copyright KBMK
            </div>
            <div class="col-md-6 text-right">
                <small>© 2022</small>
            </div>
        </div>
    </div>

</body>

</html>