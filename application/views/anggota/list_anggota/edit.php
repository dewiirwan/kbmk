<style>
    .btn-outline-primary {
        color: #007bff;
        background-color: transparent;
        background-image: none;
        border-color: #007bff;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Update Biodata</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?= base_url() ?>">Home</a>
            </li>
            <li>
                <a href="<?= base_url('anggota/profil_anggota') ?>">Anggota</a>
            </li>
            <li class="active">
                <strong>
                    <a>Update Biodata</a>
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
                            <p style="margin-top: 10px; font-size:20px;">UPDATE BIODATA & FOTO</p>
                        </div>
                    </div>

                    <div class="form-horizontal">
                        <form class="form-horizontal" action="#" id="form_edit" method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="id_mhs" id="id_mhs">
                                <div class="form-group">
                                    <label for="nama_lengkap" class="col-sm-3 control-label">Nama Lengkap<span class="text-danger">*</span> :</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_lengkap_" class="form-control" id="nama_lengkap_" placeholder="Nama Lengkap">
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="npm" class="col-sm-3 control-label">NPM<span class="text-danger">*</span> :</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="npm_" class="form-control" id="npm_" placeholder="NPM">
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tempat Tanggal lahir<span class="text-danger">*</span> :</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="ttl_" class="form-control" id="ttl_" placeholder="Contoh: Bogor, 16 Mei 1996">
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Nomor Handphone<span class="text-danger">*</span> :</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="no_hp_" class="form-control" id="no_hp_" placeholder="Contoh: 08123456789">
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Alamat<span class="text-danger">*</span> :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="alamat_" name="alamat_" value="" placeholder="Masukkan Alamat Lengkap" required>
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">Email<span class="text-danger">*</span> :</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email_" class="form-control" id="email_" placeholder="Contoh: google@gmail.com" required="required">
                                        <span class="help-block text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <!-- <div class="input-group">
                                        <div class="input-group-prepend"> -->
                                    <label class="col-sm-3 control-label">Upload Foto <span class="text-danger">*</span> <br> <span class="text-danger">
                                            *) gambar wajib jpg, jpeg. <br>
                                            *) maks photo 500 KB.
                                        </span> :</label>
                                    <div class="col-sm-1" style="width:9.3333339%;">
                                        <button class="btn btn-sm btn-outline-primary" type="button" id="open-file">Pilih Gambar</button>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="image-label" disabled>
                                        <input type="file" accept="image/jpeg" class="custom-file-input" id="customFileUpload" name="input-b1" style="display: none;" accept="image/*">
                                    </div>
                                    <!-- </div> -->

                                    <!-- </div> -->
                                    <input type="hidden" name="error_gambar">
                                    <span class="help-block text-danger"></span>

                                    <img id="imgPreview" style="width: 55.8%;margin-left: 35.5%;border-radius: 5px;" />
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-window-close"></i> Batal</button> -->
                            <button type="submit" class="btn btn-primary" onclick="confirm_update()"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('js.php') ?>