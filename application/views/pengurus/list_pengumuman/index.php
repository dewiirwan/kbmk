<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/bower_components/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet">

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<!-- bootstrap 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
	wish to resize images before upload. This must be loaded before fileinput.min.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/js/plugins/piexif.min.js" type="text/javascript"></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
	This must be loaded before fileinput.min.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/js/plugins/sortable.min.js" type="text/javascript"></script>
<!-- purify.min.js is only needed if you wish to purify HTML content in your preview for 
	HTML files. This must be loaded before fileinput.min.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/js/plugins/purify.min.js" type="text/javascript"></script>
<!-- popper.min.js below is needed if you use bootstrap 4.x. You can also use the bootstrap js 
	3.3.x versions without popper.min.js. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<!-- the main fileinput plugin file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.9/js/fileinput.min.js"></script>
<link href="<?php echo base_url('assets/select2/select2.min.css') ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/select2/select2.min.js') ?>"></script>
<!-- plugin select2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .help-block {
        color: #a94442;
    }

    #loading {
        position: fixed;
        z-index: 2000;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(255, 255, 255, .8) url("<?php echo base_url(); ?>assets/img/loading.gif") 50% 50% no-repeat;
        background-size: 250px;
    }

    .swal2-container {
        display: grid;
        position: fixed;
        z-index: 2060;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        box-sizing: border-box;
        grid-template-areas: "top-start     top            top-end""center-start  center         center-end""bottom-start  bottom-center  bottom-end";
        grid-template-rows: minmax(-webkit-min-content, auto) minmax(-webkit-min-content, auto) minmax(-webkit-min-content, auto);
        grid-template-rows: minmax(min-content, auto) minmax(min-content, auto) minmax(min-content, auto);
        height: 100%;
        padding: .625em;
        overflow-x: hidden;
        transition: background-color .1s;
        -webkit-overflow-scrolling: touch
    }

    .btn-app:hover {
        background: #f4f4f4;
        color: #444;
        border-color: #aaa;
    }

    .btn.focus,
    .btn:focus,
    .btn:hover {
        color: #333;
        text-decoration: none;
    }

    .btn-app {
        border-radius: 3px;
        position: relative;
        padding: 15px 5px;
        margin: 0 0 10px 10px;
        min-width: 80px;
        height: 60px;
        text-align: center;
        color: #666;
        border: 1px solid #ddd;
        background-color: #f4f4f4;
        font-size: 12px;
    }

    .btn-app>.fa,
    .btn-app>.glyphicon,
    .btn-app>.ion {
        font-size: 20px;
        display: block;
    }
</style>
<div id="loading"></div>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Pengumuman</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?= base_url() ?>">Home</a>
            </li>
            <li>
                <a href="<?= base_url('pengurus/list_pengumuman') ?>">Pengumuman</a>
            </li>
            <li class="active">
                <strong>
                    <a>List Pengumuman</a>
                </strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-primary pull-left" data-toggle="modal" data-target="#m_tambah">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah
                        </button>
                    </div>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <?php
                        $attributes = array('target' => '_blank', 'id' => 'myformExcel');
                        echo form_open(base_url('tables/ajax_print/'), $attributes);
                        ?>
                        <input type="hidden" name="type" value="data_list_pengumuman">
                        <button type="submit" style="float: right; margin-right: 20px; position: relative;top: 0px;" class="btn btn-app">
                            <i class="fa fa-print"></i> Excel
                        </button>
                        <?php
                        echo form_close();
                        ?>
                        <table class="table table-striped table-bordered table-hover" id="tabel">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Headline</th>
                                    <th>Isi Berita</th>
                                    <th>Tanggal Posting</th>
                                    <th>Keterangan</th>
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</br>

<div class="footer">
    <div>
        <p><strong>&copy; <?php echo (date("Y")); ?> KBMK</strong><br /> Hak cipta dilindungi undang-undang.</p>
    </div>
</div>

<?php include('modal.php') ?>
<?php include('js.php') ?>