<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Kegiatan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?= base_url() ?>">Home</a>
            </li>
            <li>
                <a href="<?= base_url('pengurus/list_kegiatan') ?>">Kegiatan</a>
            </li>
            <li class="active">
                <strong>
                    <a>Detail Kegiatan</a>
                </strong>
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInRight">

            <!-- BAGIAN Detail -->
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
                                            <dt>Deskripsi Kegiatan:</dt>
                                            <dd><?php echo $data_kegiatan->deskripsi; ?></dd>
                                            <dt>Tanggal Kegiatan:</dt>
                                            <dd><?php echo $data_kegiatan->tgl_kegiatan; ?></dd>
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
                                <?php foreach ($dokumen as $kegiatan) { ?>

                                    <div class="file-box">
                                        <div class="file">
                                            <a href="#">
                                                <span class="corner"></span>

                                                <?php if ($kegiatan->ekstensi == "jpg" || $kegiatan->ekstensi == "png" || $kegiatan->ekstensi == "jpeg" || $kegiatan->ekstensi == "bmp") {
                                                    echo ("<div class='image'>
												<img alt='image' class='img-responsive' 
												src='" . base_url() . $kegiatan->keterangan_assets . "'></div>");
                                                } else {
                                                    echo ("<div class='icon'>
												<i class='fa fa-file'></i>
												</div>");
                                                } ?>
                                                <div class="file-name">
                                                    <a href="<?= base_url(); ?>assets/uploads/kegiatan/<?= $kegiatan->dok_file; ?>">Download file</a>
                                                    <br />
                                                    <small>Jenis file: <?= $kegiatan->jenis_file; ?></small>
                                                    <br />
                                                    <small>Keterangan file: <?= $kegiatan->keterangan_file; ?></small>
                                                    <br />
                                                    <small>Diupload: <?= $kegiatan->tanggal_upload; ?></small>
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


        </div>
    </div>
</div>
</br>
</br>
</br>
<div class="footer">
    <div>
        <p><strong>&copy; <?php echo (date("Y")); ?> KBMK</strong><br /> Hak cipta dilindungi undang-undang.</p>
    </div>
</div>

</div>
</div>



<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script> -->

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/pace/pace.min.js"></script>

<!-- DROPZONE -->
<script src="<?php echo base_url(); ?>assets/js/plugins/dropzone/dropzone.js"></script>