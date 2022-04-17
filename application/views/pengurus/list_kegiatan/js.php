<script>
    $(function() {
        $('#tgl_kegiatan').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: "dateToday"
        });
        $('#tgl_kegiatan_').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: "dateToday"
        });
    });
</script>

<script type="text/javascript" language="javascript">
    var dataTable;
    var SITE_URL = '<?php echo site_url(); ?>';

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
                    data.type = 'data_list_kegiatan';
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
                    'data': 'nama_kegiatan'
                },
                {
                    'data': 'deskripsi'
                },
                {
                    'data': 'tgl_kegiatan'
                },
                {
                    'data': 'pengkhotbah'
                },
                {
                    'data': 'durasi'
                },
                {
                    'data': 'ketua_panitia'
                },
                {
                    'data': 'jml_slot'
                },
                {
                    'data': 'butuh_swab'
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
            url: '<?php echo site_url('pengurus/list_kegiatan/cek_edit'); ?>',
            type: 'POST',
            data: {
                id: id
            },
            success: function(data) {
                var myObj = JSON.parse(data);
                document.getElementById("id_kegiatan").value = id;
                document.getElementById("nama_kegiatan_").value = myObj.nama_kegiatan;
                document.getElementById("tgl_kegiatan_").value = myObj.tgl_kegiatan;
                document.getElementById("pengkhotbah_").value = myObj.pengkhotbah;
                document.getElementById("durasi_").value = myObj.durasi;
                document.getElementById("ketuplak_").value = myObj.ketua_panitia;
                document.getElementById("kapasitas_").value = myObj.jml_slot;
                document.getElementById("bukti_swab_").value = myObj.butuh_swab;
                document.getElementById("deskripsi_").value = myObj.deskripsi;
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

        await fetch(SITE_URL + 'pengurus/list_kegiatan/proses', {
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

                    $('[name="nama_kegiatan"]').addClass(response.error_class['nama_kegiatan']);
                    $('[name="nama_kegiatan"]').next().text(response.error_string['nama_kegiatan']);

                    $('[name="tgl_kegiatan"]').addClass(response.error_class['tgl_kegiatan']);
                    $('[name="tgl_kegiatan"]').next().text(response.error_string['tgl_kegiatan']);

                    $('[name="pengkhotbah"]').addClass(response.error_class['pengkhotbah']);
                    $('[name="pengkhotbah"]').next().text(response.error_string['pengkhotbah']);

                    $('[name="durasi"]').addClass(response.error_class['durasi']);
                    $('[name="durasi"]').next().text(response.error_string['durasi']);

                    $('[name="ketuplak"]').addClass(response.error_class['ketuplak']);
                    $('[name="ketuplak"]').next().text(response.error_string['ketuplak']);

                    $('[name="kapasitas"]').addClass(response.error_class['kapasitas']);
                    $('[name="kapasitas"]').next().text(response.error_string['kapasitas']);

                    $('[name="bukti_swab"]').addClass(response.error_class['bukti_swab']);
                    $('[name="bukti_swab"]').next().text(response.error_string['bukti_swab']);

                    $('[name="deskripsi"]').addClass(response.error_class['deskripsi']);
                    $('[name="deskripsi"]').next().text(response.error_string['deskripsi']);
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

        await fetch(SITE_URL + 'pengurus/list_kegiatan/update', {
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

                    $('[name="nama_kegiatan_"]').addClass(response.error_class['nama_kegiatan_']);
                    $('[name="nama_kegiatan_"]').next().text(response.error_string['nama_kegiatan_']);

                    $('[name="tgl_kegiatan_"]').addClass(response.error_class['tgl_kegiatan_']);
                    $('[name="tgl_kegiatan_"]').next().text(response.error_string['tgl_kegiatan_']);

                    $('[name="pengkhotbah_"]').addClass(response.error_class['pengkhotbah_']);
                    $('[name="pengkhotbah_"]').next().text(response.error_string['pengkhotbah_']);

                    $('[name="durasi_"]').addClass(response.error_class['durasi_']);
                    $('[name="durasi_"]').next().text(response.error_string['durasi_']);

                    $('[name="ketuplak_"]').addClass(response.error_class['ketuplak_']);
                    $('[name="ketuplak_"]').next().text(response.error_string['ketuplak_']);

                    $('[name="kapasitas_"]').addClass(response.error_class['kapasitas_']);
                    $('[name="kapasitas_"]').next().text(response.error_string['kapasitas_']);

                    $('[name="bukti_swab_"]').addClass(response.error_class['bukti_swab_']);
                    $('[name="bukti_swab_"]').next().text(response.error_string['bukti_swab_']);

                    $('[name="deskripsi_"]').addClass(response.error_class['deskripsi_']);
                    $('[name="deskripsi_"]').next().text(response.error_string['deskripsi_']);
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
        var id_kegiatan = id;
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
                del(id_kegiatan);
            }
        });
    }
    async function del(id_kegiatan) {
        $("#loading").show();
        const param = new FormData();
        param.append('id', id_kegiatan);

        await fetch(SITE_URL + 'pengurus/list_kegiatan/hapus_kegiatan', {
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