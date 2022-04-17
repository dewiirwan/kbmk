<main class="mdl-layout__content ">

    <div class="mdl-grid ui-tables">

        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title" style="display: block;">
                    <h1 class="mdl-card__title-text">List Kegiatan</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url('index.php') ?>">Home</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('index.php/anggota/list_kegiatan') ?>">Kegiatan</a>
                        </li>
                        <li class="active">
                            <strong>
                                <a>Detail Kegiatan</a>
                            </strong>
                        </li>
                    </ol>
                </div>
                <div class="mdl-card__supporting-text no-padding">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="wrapper wrapper-content animated fadeInRight">

                                <!-- BAGIAN PROFIL -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="ibox float-e-margins">
                                            <div class="ibox-title">
                                                <h5>Detail Kegiatan</h5>
                                            </div>

                                            <?php foreach ($query_detil_kegiatan_result as $data_kegiatan) { ?>
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-5">
                                                            <dl class="dl-horizontal">

                                                                <dt>Nama Kegiatan:</dt>
                                                                <dd><?php echo $data_kegiatan->nama_kegiatan; ?></dd>
                                                                <dt>Tanggal Kegiatan:</dt>
                                                                <dd><?php echo $data_kegiatan->tgl_kegiatan; ?></dd>
                                                                <dt>Nama Pengkhotbah:</dt>
                                                                <dd><?php echo $data_kegiatan->pengkhotbah; ?></dd>
                                                            </dl>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <dl class="dl-horizontal">

                                                                <dt>Durasi:</dt>
                                                                <dd><?php echo $data_kegiatan->durasi; ?></dd>
                                                                <dt>Ketua Pelaksana:</dt>
                                                                <dd><?php echo $data_kegiatan->ketua_panitia; ?></dd>
                                                                <dt>Jumlah Slot:</dt>
                                                                <dd><?php echo $data_kegiatan->jml_slot; ?></dd>

                                                            </dl>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- BAGIAN PROFIL -->

                                <!-- BAGIAN DOWNLOAD FILE -->
                                <?php if ($FILE == "ADA") { ?>
                                    <div class="row">
                                        <div class="col-lg-9 animated fadeInRight">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <?php foreach ($dokumen as $kegiatan_file) { ?>

                                                        <div class="file-box">
                                                            <div class="file">
                                                                <a href="#">
                                                                    <span class="corner"></span>

                                                                    <?php if ($kegiatan_file->ekstensi == "jpg" || $kegiatan_file->ekstensi == "png" || $kegiatan_file->ekstensi == "jpeg" || $kegiatan_file->ekstensi == "bmp") {
                                                                        echo ("<div class='image'>
												<img alt='image' class='img-responsive' 
												src='" . base_url() . $kegiatan_file->keterangan_assets . "'></div>");
                                                                    } else {
                                                                        echo ("<div class='icon'>
												<i class='fa fa-file'></i>
												</div>");
                                                                    } ?>
                                                                    <div class="file-name">
                                                                        <a href="<?php echo base_url(); ?>assets/uploads/kegiatan/<?php echo $kegiatan_file->dok_file; ?>">Download file</a>
                                                                        <br />
                                                                        <small>Jenis file: <?php echo $kegiatan_file->jenis_file; ?></small>
                                                                        <br />
                                                                        <small>Keterangan file: <?php echo $kegiatan_file->keterangan_file; ?></small>
                                                                        <br />
                                                                        <small>Diupload: <?php echo $kegiatan_file->tanggal_upload; ?></small>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>

                                                    <?php } ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                <?php } else { ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox">
                                                <div class="ibox-title">
                                                    <h5>Download File Dokumen</h5>
                                                    <div class="ibox-tools">
                                                        <a class="collapse-link">
                                                            <i class="fa fa-chevron-up"></i>
                                                        </a>
                                                        <a class="fullscreen-link">
                                                            <i class="fa fa-expand"></i>
                                                        </a>
                                                        <a class="close-link">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="ibox-content">
                                                    Belum ada file dokumen. Silakan upload file dokumen.
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- BAGIAN DOWNLOAD FILE -->


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script> -->

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/pace/pace.min.js"></script>

<!-- DROPZONE -->
<script src="<?php echo base_url(); ?>assets/js/plugins/dropzone/dropzone.js"></script>