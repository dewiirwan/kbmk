<main class="mdl-layout__content ">

    <div class="mdl-grid ui-tables">

        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title" style="display: block;">
                    <h1 class="mdl-card__title-text">List Anggota</h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url('index.php') ?>">Home</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('index.php/anggota/profil_anggota') ?>">Anggota</a>
                        </li>
                        <li class="active">
                            <strong>
                                <a>Profil Anggota</a>
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
                                                <h5>Profil Anggota</h5>
                                            </div>

                                            <?php foreach ($query_detil_anggota_result as $data_anggota) { ?>
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-lg-5">
                                                            <dl class="dl-horizontal">

                                                                <dt>NPM:</dt>
                                                                <dd><?php echo $data_anggota->npm; ?></dd>
                                                                <dt>Nama:</dt>
                                                                <dd><?php echo $data_anggota->nama; ?></dd>
                                                                <dt>Tempat Tanggal Lahir:</dt>
                                                                <dd><?php echo $data_anggota->tempat_tgl_lahir; ?></dd>
                                                            </dl>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <dl class="dl-horizontal">

                                                                <dt>Alamat:</dt>
                                                                <dd><?php echo $data_anggota->alamat; ?></dd>
                                                                <dt>Email:</dt>
                                                                <dd><?php echo $data_anggota->email; ?></dd>
                                                                <dt>Nomor Handphone:</dt>
                                                                <dd><?php echo $data_anggota->no_hp; ?></dd>

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
                                                    <?php foreach ($dokumen as $anggota_file) { ?>

                                                        <div class="file-box">
                                                            <div class="file">
                                                                <a href="#">
                                                                    <span class="corner"></span>

                                                                    <?php if ($anggota_file->ekstensi == "jpg" || $anggota_file->ekstensi == "png" || $anggota_file->ekstensi == "jpeg" || $anggota_file->ekstensi == "bmp") {
                                                                        echo ("<div class='image'>
												<img alt='image' class='img-responsive' 
												src='" . base_url() . $anggota_file->keterangan_assets . "'></div>");
                                                                    } else {
                                                                        echo ("<div class='icon'>
												<i class='fa fa-file'></i>
												</div>");
                                                                    } ?>
                                                                    <div class="file-name">
                                                                        <a href="<?php echo base_url(); ?>assets/uploads/anggota/<?php echo $anggota_file->dok_file; ?>">Download file</a>
                                                                        <br />
                                                                        <small>Jenis file: <?php echo $anggota_file->jenis_file; ?></small>
                                                                        <br />
                                                                        <small>Keterangan file: <?php echo $anggota_file->keterangan_file; ?></small>
                                                                        <br />
                                                                        <small>Diupload: <?php echo $anggota_file->tanggal_upload; ?></small>
                                                                    </div>
                                                                    <input type="button" class="btn btn-block btn-outline btn-danger" onclick="location.href='<?php echo base_url(); ?>index.php/anggota/profil_anggota/hapus_file/<?php echo $anggota_file->dok_file; ?>';" value="Hapus" />

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
                                                    File dokumen yang Anda upload akan digunakan untuk keperluan umat, dengan ketentuan sebagai berikut:
                                                <ul class="sortable-list connectList agile-list" id="ketentuan">
                                                    <li class="warning-element" id="task1">
                                                        1. File dokumen yang diupload harus merupakan data milik umat.
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
                                                        <select name="JENIS_FILE" id="JENIS_FILE" style="color: black;">
                                                            <option value='Belum didefinisikan'>- Pilih Jenis File Dokumen -</option>
                                                            <option value='KTP'>KTP</option>
                                                            <option value='Foto'>Foto</option>
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
        url: "<?php echo base_url('index.php/anggota/profil_anggota/proses_upload_file') ?>",
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
                    url: "<?php echo base_url('index.php/anggota/profil_anggota/proses_upload_file') ?>",
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
        c.append("token", a.token); //Mempersiapkan token untuk masing masing npwp
    });


    //Event ketika data dihapus
    file_upload.on("removedfile", function(a) {
        var token = a.token;
        $.ajax({
            type: "post",
            data: {
                token: token
            },
            url: "<?php echo base_url('index.php/anggota/profil_anggota/remove_file') ?>",
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