<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Biodata</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?= base_url() ?>">Home</a>
            </li>
            <li>
                <a href="<?= base_url('pengurus/list_anggota') ?>">Anggota</a>
            </li>
            <li class="active">
                <strong>
                    <a>Biodata</a>
                </strong>
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInRight">

            <!-- BAGIAN PROFIL -->
            <div class="row">
                <div class="ibox float-e-margins">
                    <div class="ibox-title border-bottom white-bg page-heading">
                        <div class="col-lg-5">
                            <p style="margin-top: 10px; font-size:20px;">BIODATA & FOTO</p>
                        </div>
                    </div>

                    <div class="form-horizontal">
                        <form class="form-horizontal" action="#" id="form_edit" method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="id_mhs" id="id_mhs">
                                <div class="form-group">
                                    <label for="nama_lengkap" class="col-sm-3 control-label">Nama Lengkap :</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_lengkap_" class="form-control" id="nama_lengkap_" placeholder="Nama Lengkap" readonly>
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="npm" class="col-sm-3 control-label">NPM :</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="npm_" class="form-control" id="npm_" placeholder="NPM" readonly>
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tempat Tanggal lahir :</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="ttl_" class="form-control" id="ttl_" placeholder="Contoh: Bogor, 16 Mei 1996" readonly>
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Nomor Handphone :</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="no_hp_" class="form-control" id="no_hp_" placeholder="Contoh: 08123456789" readonly>
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Alamat :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="alamat_" name="alamat_" value="" placeholder="Masukkan Alamat Lengkap" required readonly>
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">Email :</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email_" class="form-control" id="email_" placeholder="Contoh: google@gmail.com" required="required" readonly>
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!-- <div class="input-group">
                                        <div class="input-group-prepend"> -->
                                    <label class="col-sm-3 control-label">Foto :</label>

                                    <img id="imgPreview" style="width: 55.8%;margin-left: 26.5%;border-radius: 5px;" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('js.php') ?>


<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script> -->

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/pace/pace.min.js"></script>

<!-- DROPZONE -->
<script src="<?php echo base_url(); ?>assets/js/plugins/dropzone/dropzone.js"></script>