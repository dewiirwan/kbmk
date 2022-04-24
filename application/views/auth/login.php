<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title; ?></title>

    <link href="<?php echo base_url(); ?>assets/template/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/template/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/template/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/template/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold">Selamat Datang di Sistem Informasi Keluarga Besar Mahasiswa Khonghucu (SIKBMK)</h2>

                <p>
                    KBMK
                </p>

                <p>
                    adalah sistem informasi yang dikembangkan oleh Dewi Irwan untuk memberikan informasi mengenai kebaktian saat pandemi yang sesuai dengan protokol kesehatan.
                </p>

                <p>
                    <small>Silahkan hubungi administrator untuk dapat mengakses aplikasi ini.</small>
                </p>
                </br>
                </br>
                <!-- <a href="<?php echo base_url(); ?>">Kembali ke Home</a> -->

            </div>
            <div class="col-md-6">
                <?php if ($message != "") { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $message; ?>
                    </div>
                <?php
                } ?>

                <div class="ibox-content">
                    <?php echo form_open("auth/login"); ?>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>" placeholder="Email" autofocus>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" value="<?php echo set_value('password'); ?>" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                    <a href=<?php echo base_url(); ?>index.php/auth/lupa_password><small>Lupa Password</small></a>

                    <p class="text-muted text-center"><small>Belum punya akun?</small></p>
                    <a class="btn btn-sm btn-white btn-block" href="<?php echo base_url(); ?>index.php/auth/register">Buat akun baru</a>

                    <?php echo form_close(); ?>
                    <p class="m-t">
                        <small>Theme by Inspina | Engine by CodeIgniter | Webapps</small>
                    </p>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6">
                Copyright Dewi Irwan
            </div>
            <div class="col-md-6 text-right">
                <small>© 2021</small>
            </div>
        </div>
    </div>

</body>

</html>