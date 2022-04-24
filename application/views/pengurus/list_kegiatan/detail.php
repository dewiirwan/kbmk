<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Profil Kegiatan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?= base_url() ?>">Home</a>
            </li>
            <li>
                <a href="<?= base_url('pengurus/list_kegiatan') ?>">Kegiatan</a>
            </li>
            <li class="active">
                <strong>
                    <a>Profil Kegiatan</a>
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
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Profil Kegiatan</h5>
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
                                                <input type="button" class="btn btn-block btn-outline btn-danger" onclick="location.href='<?= base_url(); ?>index.php/pengurus/list_kegiatan/hapus_file/<?= $kegiatan->dok_file; ?>';" value="Hapus" />

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

            <div class="alert alert-info alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                Silakan upload file dokumen sesuai dengan ketentuan .
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Upload File Dokumen</h5>
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
                            <p>
                                File dokumen yang Anda upload akan digunakan untuk keperluan pengurus, dengan ketentuan sebagai berikut:
                            <ul class="sortable-list connectList agile-list" id="ketentuan">
                                <li class="warning-element" id="task1">
                                    1. File dokumen yang diupload harus merupakan data milik pengurus.
                                </li>
                                <li class="danger-element" id="task2">
                                    2. Ukuran dokumen yang diterima sistem maksimal 5 Mega Bytes (5 MB).
                                </li>
                                <li class="success-element" id="task4">
                                    3. Ekstensi/tipe file yang diterima sistem adalah .PDF dan .JPEG/.JPG/.BMP.
                                </li>

                                <li class="warning-element" id="task1">
                                    4. Pilih jenis File Dokumen sebelum melakukan upload.
                                    </br>

                                </li>

                            </ul>
                            </p>


                            <form action="#" class="dropzone" id="dropzoneForm">

                                </br>
                                <div class="col-xs-9">
                                    <select name="JENIS_FILE" id="JENIS_FILE">
                                        <option value='Belum didefinisikan'>- Pilih Jenis File Dokumen -</option>
                                        <option value='Foto Lokasi'>Foto Lokasi</option>
                                        <option value='Foto Kegiatan'>Foto Kegiatan</option>
                                        <option value='Foto Panitia'>Foto Panitia</option>
                                        <option value='Dokumen Lainnya'>Dokumen Lainnya</option>
                                    </select>
                                    </br>
                                    <input name="KETERANGAN_FILE" id="KETERANGAN_FILE" class="form-control" type="text" placeholder="Keterangan File Dokumen" required>

                                </div>
                                </br>
                                </br>
                                </br>
                                </br>
                                </br>
                                </br>
                                </br>
                                </br>
                                <div class="fallback">
                                    <input name="file" type="file" multiple />
                                </div>
                            </form>

                            <div>
                                </br>
                                <button class="btn btn-primary" name="btn_upload" id="btn_upload"><i class="fa fa-save"></i> Upload</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            </br>
            </br></br>


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

<!-- Page-Level Scripts -->
<script>
    Dropzone.autoDiscover = false;

    Dropzone.options.dropzoneForm = {
        paramName: "file", // The name that will be used to transfer the file
        autoProcessQueue: false,
        maxFilesize: 5, // MB
        maxFiles: 1,
        dictDefaultMessage: "<strong>Letakkan file di sini atau klik untuk memuat file. </strong></br> (Pastikan file yang Anda upload sesuai dengan ketentuan)",
        dictFileTooBig: "Maaf ukuran file tidak sesuai ketentuan."
    };



    var file_upload = new Dropzone(".dropzone", {
        url: "<?= base_url('pengurus/list_kegiatan/proses_upload_file') ?>",
        maxFilesize: 5,
        method: "post",
        acceptedFiles: "image/jpeg,image/png,image/jpg,image/bmp,application/pdf",
        paramName: "userfile",
        dictInvalidFileType: "Maaf ekstensi/tipe file tidak sesuai ketentuan.",
        addRemoveLinks: true,
        init: function() {
            var myDropzone = this;

            // Update selector to match your button
            $("#btn_upload").click(function(e) {
                e.preventDefault();
                myDropzone.processQueue();
                var form_data = {
                    JENIS_FILE: $('#JENIS_FILE').val(),
                    KETERANGAN_FILE: $('#KETERANGAN_FILE').val()
                };
                $.ajax({
                    url: "<?= base_url('pengurus/list_kegiatan/proses_upload_file') ?>",
                    type: 'POST',
                    data: form_data,
                    success: function(data) {
                        if (data != '') {
                            console.log("waduh");
                        } else {
                            console.log("waduh 2");
                        }
                    }
                });
            });


            this.on("success", function(file, responseText) {
                location.reload();;
            });
        }
    });


    //Event ketika Memulai mengupload
    file_upload.on("sending", function(a, b, c) {
        a.token = Math.random();
        c.append("token_npwp", a.token); //Mempersiapkan token untuk masing masing npwp
    });


    //Event ketika data dihapus
    file_upload.on("removedfile", function(a) {
        var token = a.token;
        $.ajax({
            type: "post",
            data: {
                token: token
            },
            url: "<?php echo base_url('pengurus/list_kegiatan/remove_file') ?>",
            cache: false,
            dataType: 'json',
            success: function() {
                console.log("Data terhapus");
            },
            error: function() {
                console.log("Error");
            }
        });
    });
</script>
</body>

</html>