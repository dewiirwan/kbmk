<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?php echo $title; ?></title>

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>assets/template/css/animate.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/template/css/style.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>assets/template/css/skins.less" rel="styles.less">

  <!-- dataTables style -->
  <link href="<?php echo base_url(); ?>assets/template/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/template/dataTableBaru/dataTables.checkboxes.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/js/plugins/notifications/sweetalert.css') ?>">

  <!-- jQuery 3 -->
  <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- DataTables -->
  <script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo base_url('assets/js/plugins/notifications/sweet_alert.min.js'); ?>"></script>

</head>

<body class="md-skin">
  <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
          <li class="nav-header">
            <div class="dropdown profile-element"> <span>
                <img alt="image" class="img-circle" src="" />
              </span>
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $email; ?></strong>
                  </span> <span class="text-muted text-xs block">Administrator <b class="caret"></b></span> </span> </a>
              <ul class="dropdown-menu animated fadeInRight m-t-xs">
                <li><a href="#">Terakhir login:
                    </br><?php echo $last_login; ?></a></li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url(); ?>index.php/log_aktivitas">Log Aktivitas</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url(); ?>index.php/auth/logout">Logout</a></li>
              </ul>
            </div>