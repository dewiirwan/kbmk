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
        get_detail(<?= @$id_mhs; ?>);
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
                    data.type = 'data_list_anggota_pengurus';
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
                    'data': 'npm'
                },
                {
                    'data': 'nama_anggota'
                },
                {
                    'data': 'ttl'
                },
                {
                    'data': 'alamat'
                },
                {
                    'data': 'email'
                },
                {
                    'data': 'no_hp'
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

                    };
                    data.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
                    data.type = 'data_list_hadir';
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
                    'data': 'npm'
                },
                {
                    'data': 'nama_anggota'
                },
                {
                    'data': 'alamat'
                },
                {
                    'data': 'email'
                },
                {
                    'data': 'no_hp'
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
                    'data': 'jam_hadir'
                },
                {
                    'data': 'aksi',
                    'orderable': false
                },
            ],


        });

        function table_datas() {
            dataTables.ajax.reload(null, true);
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

    function detail(id_anggota) {
        window.location.href = BASE_URL + 'pengurus/list_anggota/detail/' + id_anggota;
    }

    function detail_hadir(id_anggota) {
        window.location.href = BASE_URL + 'pengurus/list_data_hadir/detail/' + id_anggota;
    }

    function upload(id_anggota) {
        window.location.href = BASE_URL + 'pengurus/list_anggota/detail_upload/' + id_anggota;
    }

    function verif(id_mhs) {

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
            // console.log(result)
            if (result.value) {
                save(id_mhs);
            }
        });
    }
    async function save(id_mhs) {
        $("#loading").show();

        const param = new FormData();

        param.append('id_mhs', id_mhs);
        await fetch(SITE_URL + 'pengurus/list_anggota/verif', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: param,
            })
            .then(response => response.json())
            .then(response => {
                // console.log(response.status);
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
                } else if (response.status === false) {
                    Swal.fire({
                        type: "warning",
                        title: 'Gagal!',
                        text: 'Gagal verif data.',
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

    function get_detail(id_anggota) {
        $.ajax({
            url: '<?= base_url('pengurus/list_anggota/cek_detail'); ?>',
            type: 'POST',
            data: {
                id: id_anggota
            },
            success: function(data) {
                var myObj = JSON.parse(data);
                document.getElementById("id_mhs").value = id_anggota;
                document.getElementById("nama_lengkap_").value = myObj.nama;
                document.getElementById("npm_").value = myObj.npm;
                document.getElementById("ttl_").value = myObj.tempat_tgl_lahir;
                document.getElementById("no_hp_").value = myObj.no_hp;
                document.getElementById("alamat_").value = myObj.alamat;
                document.getElementById("email_").value = myObj.email;

                if (myObj.foto != null || myObj.foto != '') {
                    console.log('ASD');
                    var foto = myObj.foto;
                    var subs = foto.substring(43);
                    $('#imgPreview').attr('src', BASE_URL + myObj.foto);
                }

            }
        });
    }
</script>