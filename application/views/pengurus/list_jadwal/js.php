<script type="text/javascript" language="javascript">
    var dataTable;
    var dataTables;
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
                    data.type = 'data_list_jadwal_kegiatan';
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
                    'data': 'tgl_kegiatan'
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
                    'data': 'aksi',
                    'orderable': false
                },
            ],


        });

        function table_data() {
            dataTable.ajax.reload(null, true);
        }

        dataTables = $('#tabels').DataTable({
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
                        'id_kegiatan': $('#id_kegiatan').val(),
                        'nama': $('.filter_nama').val(),
                    };
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
                    data.type = 'data_list_jadwal_detail';
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
            order: [0, 'asc'],
            columns: [{
                    'data': 'no'
                },
                {
                    'data': 'nama_kegiatan'
                },
                {
                    'data': 'tgl_kegiatan'
                },
                {
                    'data': 'no_urut'
                },
                {
                    'data': 'nama_mhs'
                },
                {
                    'data': 'jam_hadir'
                },
                {
                    'data': 'aksi',
                    'orderable': false
                },
            ],


        });

        $(".filter_nama").keyup(function() {
            table_datas();
        });

        function table_datas() {
            dataTables.ajax.reload(null, true);
        }

        $('#btn_simpan').prop("disabled", true);

        $("#nama_kegiatan").on("change", function() {
            //Getting Value
            var selValue = $("#nama_kegiatan :selected").text();
            //Setting Value

            console.log($('#nama_kegiatan').val());

            var jumlah_maksimal = parseInt(selValue.split("Slot:").pop());

            if (selValue != "- Pilih Kegiatan -") {
                $('input.qty').prop("disabled", false);

                $('input.qty').change(function() {

                    // Loop through all input's and re-calculate the total
                    var total = 0;
                    $('input.qty').each(function() {
                        total += parseInt(this.value);
                    });

                    if (isNaN(total) == false) {
                        console.log("ya");
                        console.log(jumlah_maksimal);
                        console.log(total);
                        if (total <= jumlah_maksimal) {
                            $('#btn_simpan').prop("disabled", false);
                            $('#alert-msg').html('');
                        }
                        if (total > jumlah_maksimal) {
                            $('#btn_simpan').prop("disabled", true);
                            $('#alert-msg').html('<div class="alert alert-danger">Kapasitas tidak boleh melebihin slot kegiatan </div>');
                        }

                    }
                });


            } else {
                $('input.qty').prop("disabled", true);
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

    function detail(id_kegiatan) {
        window.location.href = BASE_URL + 'pengurus/list_jadwal/detail/' + id_kegiatan;
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

        await fetch(SITE_URL + 'pengurus/list_jadwal/proses', {
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

                    $('[name="kapasitas_kegiatan"]').addClass(response.error_class['kapasitas_kegiatan']);
                    $('[name="kapasitas_kegiatan"]').next().text(response.error_string['kapasitas_kegiatan']);
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
        var id_jadwal = id;
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
                del(id_jadwal);
            }
        });
    }
    async function del(id_jadwal) {
        $("#loading").show();
        const param = new FormData();
        param.append('id', id_jadwal);

        await fetch(SITE_URL + 'pengurus/list_jadwal/hapus_jadwal', {
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

    function confirm_reset(id) {
        var id_jadwal = id;
        Swal.fire({
            title: 'Apakah anda yakin akan reset slot data ini',
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
                reset(id_jadwal);
            }
        });
    }
    async function reset(id_jadwal) {
        $("#loading").show();
        const param = new FormData();
        param.append('id', id_jadwal);

        await fetch(SITE_URL + 'pengurus/list_jadwal/reset_slot', {
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
                        text: 'Data berhasil direset.',
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

    function confirm_verif(id) {
        var id_jadwal = id;
        Swal.fire({
            title: 'Apakah anda yakin akan verif data ini',
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
                verif(id_jadwal);
            }
        });
    }
    async function verif(id_jadwal) {
        $("#loading").show();
        const param = new FormData();
        param.append('id', id_jadwal);

        await fetch(SITE_URL + 'pengurus/list_jadwal/verif_hadir', {
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
                        text: 'Data berhasil diverif.',
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