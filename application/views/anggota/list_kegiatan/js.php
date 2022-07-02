<script type="text/javascript" language="javascript">
    var dataTable;
    var BASE_URL = '<?php echo base_url(); ?>';
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
                    data.type = 'data_list_kegiatan_anggota';
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
                    'data': 'aksi',
                    'orderable': false
                },
            ],


        });

        function table_data() {
            dataTable.ajax.reload(null, true);
        }
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
        window.location.href = BASE_URL + 'anggota/list_kegiatan/detail/' + id_kegiatan;
    }

    function daftar(id_mhs, id_jadwal) {
        Swal.fire({
            title: 'Apakah anda yakin ingin daftar pada kegiatan ini',
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
                save(id_mhs, id_jadwal);
            }
        });
    }
    async function save(id_mhs, id_jadwal) {
        $("#loading").show();
        const param = new FormData();
        param.append('id_mhs', id_mhs);
        param.append('id_jadwal', id_jadwal)

        await fetch(SITE_URL + 'anggota/list_kegiatan/proses', {
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