<script>
    $(function() {
        $('#tgl_posting').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: "dateToday"
        });
        $('#tgl_posting_').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: "dateToday"
        });
    });
</script>

<script type="text/javascript" language="javascript">
    var dataTable;
    var BASE_URL = '<?= base_url(); ?>';
    var SITE_URL = '<?= site_url(); ?>';

    $(".select2").each((_i, e) => {
        var $e = $(e);
        $e.select2({
            dropdownParent: $e.parent()
        });
    });
    $(document).ready(function() {
        dataTable = $('#tabel').DataTable({
            paginationType: 'full_numbers',
            processing: true,
            serverSide: true,
            filter: false,
            autoWidth: false,
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            ajax: {
                url: '<?php echo base_url('tables/ajax_list') ?>',
                type: 'POST',
                beforeSend: function() {
                    $("#loading").show();
                },
                data: function(data) {
                    data.filter = {

                    };
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
                    data.type = 'data_list_pengumuman';
                },
                complete: function(settings, json) {
                    $("#loading").hide();
                }
            },
            language: {
                sProcessing: 'Sedang memproses...',
                sLengthMenu: 'Tampilkan _MENU_ entri',
                sZeroRecords: 'Tidak ditemukan data yang sesuai',
                sInfo: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                sInfoEmpty: 'Menampilkan 0 sampai 0 dari 0 entri',
                sInfoFiltered: '(disaring dari _MAX_ entri keseluruhan)',
                sInfoPostFix: '',
                sSearch: 'Cari:',
                sUrl: '',
                oPaginate: {
                    sFirst: '<<',
                    sPrevious: '<',
                    sNext: '>',
                    sLast: '>>'
                }
            },
            order: [0, 'desc'],
            columns: [{
                    'data': 'no'
                },
                {
                    'data': 'headline_berita'
                },
                {
                    'data': 'isi_berita'
                },
                {
                    'data': 'tgl_posting'
                },
                {
                    'data': 'keterangan'
                },
                {
                    'data': 'aksi',
                    'orderable': false
                },
            ],


        });

        function table_data() {
            dataTable.ajax.reload(null, true);
        }
    });

    $('#m_edit').on('show.bs.modal', function(e) {
        var id = $(e.relatedTarget).data('href');
        console.log(id);

        $.ajax({
            url: '<?php echo site_url('pengurus/list_pengumuman/cek_edit'); ?>',
            type: 'POST',
            data: {
                id: id
            },
            success: function(data) {
                console.log(data);
                var myObj = JSON.parse(data);
                document.getElementById("id_pengumuman").value = id;
                document.getElementById("judul_").value = myObj.judul;
                document.getElementById("headline_berita_").value = myObj.headline_berita;
                document.getElementById("isi_berita_").value = myObj.isi_berita;
                document.getElementById("tgl_posting_").value = myObj.tgl_posting;
                document.getElementById("keterangan_").value = myObj.keterangan;
            }
        });
    });

    function refresh_page() {
        location.reload();
    }

    function towaktu(data) {
        var time = data.toString();

        if (time.length == 1) {
            var hrs = '0' + time;
        } else {
            var hrs = time;
        }
        return hrs + ":00";
    }

    function towaktuDes(data) {
        var time = data.toString();

        if (time.length == 1) {
            var hrs = '0' + time;
        } else {
            var hrs = time;
        }
        return hrs + ":00";
    }

    function detail(id_pengumuman) {
        window.location.href = BASE_URL + 'pengurus/list_pengumuman/detail/' + id_pengumuman;
    }

    function confirm_save() {
        Swal.fire({
            title: 'Apakah anda yakin akan menyimpan data ini',
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batal!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-warning ml-1',
            buttonsStyling: false,
        }).then(function(result) {

            if (result.value) {
                save();
            }
        });
    }
    async function save() {
        $("#loading").show();
        const param = new FormData($('#form_tambah')[0]);

        await fetch(SITE_URL + 'pengurus/list_pengumuman/proses', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: param,
            })
            .then(response => response.json())
            .then(response => {
                console.log(response.status);
                if (response.status === true) {
                    $('#m_tambah').modal('hide');
                    Swal.fire({
                        type: "success",
                        title: 'Berhasil!',
                        text: 'Data berhasil disimpan.',
                        confirmButtonClass: 'btn btn-success',
                        timer: 1500
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                } else if (response.status === false) {
                    Swal.fire({
                        type: "warning",
                        title: 'Gagal!',
                        text: 'Gagal menyimpan data.',
                        confirmButtonClass: 'btn btn-warning',
                        timer: 1500
                    });

                    $('[name="judul"]').addClass(response.error_class['judul']);
                    $('[name="judul"]').next().text(response.error_string['judul']);

                    $('[name="headline_berita"]').addClass(response.error_class['headline_berita']);
                    $('[name="headline_berita"]').next().text(response.error_string['headline_berita']);

                    $('[name="isi_berita"]').addClass(response.error_class['isi_berita']);
                    $('[name="isi_berita"]').next().text(response.error_string['isi_berita']);

                    $('[name="tgl_posting"]').addClass(response.error_class['tgl_posting']);
                    $('[name="tgl_posting"]').next().text(response.error_string['tgl_posting']);

                    $('[name="keterangan"]').addClass(response.error_class['keterangan']);
                    $('[name="keterangan"]').next().text(response.error_string['keterangan']);
                }
            })
            .catch((error) => {
                Swal.fire({
                    type: "error",
                    title: 'Kesalahan!',
                    text: 'Terjadi Kesalahan.',
                    confirmButtonClass: 'btn btn-danger',
                });
                console.error('Error:', error);
            })
            .finally(() => {
                $("#loading").hide();
            });
    }

    function confirm_update() {
        Swal.fire({
            title: 'Apakah anda yakin akan mengubah data ini',
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batal!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-warning ml-1',
            buttonsStyling: false,
        }).then(function(result) {

            if (result.value) {
                update();
            }
        });
    }
    async function update() {
        $("#loading").show();
        const param = new FormData($('#form_edit')[0]);

        await fetch(SITE_URL + 'pengurus/list_pengumuman/update', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: param,
            })
            .then(response => response.json())
            .then(response => {
                console.log(response.status);
                if (response.status === true) {
                    $('#m_edit').modal('hide');
                    Swal.fire({
                        type: "success",
                        title: 'Berhasil!',
                        text: 'Data berhasil diubah.',
                        confirmButtonClass: 'btn btn-success',
                        timer: 1500
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                } else if (response.status === false) {
                    Swal.fire({
                        type: "warning",
                        title: 'Gagal!',
                        text: 'Gagal mengubah data.',
                        confirmButtonClass: 'btn btn-warning',
                        timer: 1500
                    });

                    $('[name="judul_"]').addClass(response.error_class['judul_']);
                    $('[name="judul_"]').next().text(response.error_string['judul_']);

                    $('[name="headline_berita_"]').addClass(response.error_class['headline_berita_']);
                    $('[name="headline_berita_"]').next().text(response.error_string['headline_berita_']);

                    $('[name="isi_berita_"]').addClass(response.error_class['isi_berita_']);
                    $('[name="isi_berita_"]').next().text(response.error_string['isi_berita_']);

                    $('[name="tgl_posting_"]').addClass(response.error_class['tgl_posting_']);
                    $('[name="tgl_posting_"]').next().text(response.error_string['tgl_posting_']);

                    $('[name="keterangan_"]').addClass(response.error_class['keterangan_']);
                    $('[name="keterangan_"]').next().text(response.error_string['keterangan_']);
                }
            })
            .catch((error) => {
                Swal.fire({
                    type: "error",
                    title: 'Kesalahan!',
                    text: 'Terjadi Kesalahan.',
                    confirmButtonClass: 'btn btn-danger',
                });
                console.error('Error:', error);
            })
            .finally(() => {
                $("#loading").hide();
            });
    }

    function confirm_del(id) {
        var id_pengumuman = id;
        Swal.fire({
            title: 'Apakah anda yakin akan menghapus data ini',
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batal!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-warning ml-1',
            buttonsStyling: false,
        }).then(function(result) {

            if (result.value) {
                del(id_pengumuman);
            }
        });
    }
    async function del(id_pengumuman) {
        $("#loading").show();
        const param = new FormData();
        param.append('id', id_pengumuman);

        await fetch(SITE_URL + 'pengurus/list_pengumuman/hapus_pengumuman', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: param,
            })
            .then(response => response.json())
            .then(response => {
                if (response.status === true) {
                    Swal.fire({
                        type: "success",
                        title: 'Berhasil!',
                        text: 'Data berhasil dihapus.',
                        confirmButtonClass: 'btn btn-success',
                        timer: 1500
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                }
            })
            .catch((error) => {
                Swal.fire({
                    type: "error",
                    title: 'Kesalahan!',
                    text: 'Terjadi Kesalahan.',
                    confirmButtonClass: 'btn btn-danger',
                });
                console.error('Error:', error);
            })
            .finally(() => {
                $("#loading").hide();
            });
    }
</script>