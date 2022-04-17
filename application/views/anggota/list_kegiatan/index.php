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
</style>
<div id="loading"></div>
<main class="mdl-layout__content ">

    <div class="mdl-grid ui-tables">

        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title" style="display: block;">
                    <h1 class="mdl-card__title-text">List Kegiatan</h1>
                </div>
                <div class="mdl-card__supporting-text no-padding">
                    <table class="mdl-data-table mdl-js-data-table bordered-table" id="tabel">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric">No</th>
                                <th class="mdl-data-table__cell--non-numeric">Nama Kegiatan</th>
                                <th class="mdl-data-table__cell--non-numeric">Tanggal Kegiatan</th>
                                <th class="mdl-data-table__cell--non-numeric">Nama Pengkhotbah</th>
                                <th class="mdl-data-table__cell--non-numeric">Waktu</th>
                                <th class="mdl-data-table__cell--non-numeric">Ketua Pelaksana</th>
                                <th class="mdl-data-table__cell--non-numeric">Bukti SWAB</th>
                                <th class="mdl-data-table__cell--non-numeric">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<?php include('js.php') ?>