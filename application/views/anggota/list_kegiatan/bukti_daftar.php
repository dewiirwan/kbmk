<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Bukti Daftar</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?= base_url() ?>">Home</a>
            </li>
            <li>
                <a href="<?= base_url('anggota/list_kegiatan') ?>">List Kegiatan</a>
            </li>
            <li class="active">
                <strong>
                    <a>Bukti Daftar</a>
                </strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <style>
        .container_iframe {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding-top: 56.25%;
            /* 16:9 Aspect Ratio (divide 9 by 16 = 0.5625) */
        }

        /* Then style the iframe to fit in the container div with full height and width */
        .responsive-iframe {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
        }
    </style>

    <!-- Identitas Form FPB -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?= $file_pdf; ?></h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="fullscreen-link">
                    <i class="fa fa-expand"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="container_iframe">
                <iframe class="responsive-iframe" src="<?= base_url('assets/PDF/') ?><?= $file_pdf; ?>"></iframe>
            </div>
            </br>
            <a href="<?= base_url('anggota/list_kegiatan') ?>" class="btn btn-info"> Kembali Ke Halaman List Kegiatan</a>
        </div>
    </div>
    <!-- End Identitas Form FPB -->
</div>


<!-- Mainly scripts -->
<script src="<?= base_url(); ?>assets/template/js/jquery-3.1.1.min.js"></script>
<script src="<?= base_url(); ?>assets/template/js/bootstrap.min.js"></script>
<script src="<?= base_url(); ?>assets/template/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?= base_url(); ?>assets/template/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?= base_url(); ?>assets/template/js/plugins/dataTables/datatables.min.js"></script>

<!-- TouchSpin -->
<script src="<?= base_url(); ?>assets/template/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?= base_url(); ?>assets/template/js/inspinia.js"></script>
<script src="<?= base_url(); ?>assets/template/js/plugins/pace/pace.min.js"></script>