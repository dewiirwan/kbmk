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
                    data.type = 'data_list_anggota';
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
    });

    $('#m_edit').on('show.bs.modal', function(e) {
        var id = $(e.relatedTarget).data('href');

        $.ajax({
            url: '<?php echo site_url('anggota/profil_anggota/cek_edit'); ?>',
            type: 'POST',
            data: {
                id: id
            },
            success: function(data) {
                var myObj = JSON.parse(data);
                document.getElementById("id_mhs").value = id;
                document.getElementById("nama_lengkap_").value = myObj.nama;
                document.getElementById("npm_").value = myObj.npm;
                document.getElementById("ttl_").value = myObj.tempat_tgl_lahir;
                document.getElementById("no_hp_").value = myObj.no_hp;
                document.getElementById("alamat_").value = myObj.alamat;
                document.getElementById("email_").value = myObj.email;
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

    function detail(id_mhs) {
        window.location.href = BASE_URL + 'anggota/profil_anggota/detail/' + id_mhs;
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

        await fetch(SITE_URL + 'pengurus/list_pengurus/proses', {
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

                    $('[name="nama_lengkap"]').addClass(response.error_class['nama_lengkap']);
                    $('[name="nama_lengkap"]').next().text(response.error_string['nama_lengkap']);

                    $('[name="npm"]').addClass(response.error_class['npm']);
                    $('[name="npm"]').next().text(response.error_string['npm']);

                    $('[name="ttl"]').addClass(response.error_class['ttl']);
                    $('[name="ttl"]').next().text(response.error_string['ttl']);

                    $('[name="alamat"]').addClass(response.error_class['alamat']);
                    $('[name="alamat"]').next().text(response.error_string['alamat']);

                    $('[name="email"]').addClass(response.error_class['email']);
                    $('[name="email"]').next().text(response.error_string['email']);

                    $('[name="no_hp"]').addClass(response.error_class['no_hp']);
                    $('[name="no_hp"]').next().text(response.error_string['no_hp']);
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

        await fetch(SITE_URL + 'pengurus/list_pengurus/update', {
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

                    $('[name="nama_lengkap_"]').addClass(response.error_class['nama_lengkap_']);
                    $('[name="nama_lengkap_"]').next().text(response.error_string['nama_lengkap_']);

                    $('[name="npm_"]').addClass(response.error_class['npm_']);
                    $('[name="npm_"]').next().text(response.error_string['npm_']);

                    $('[name="ttl_"]').addClass(response.error_class['ttl_']);
                    $('[name="ttl_"]').next().text(response.error_string['ttl_']);

                    $('[name="alamat_"]').addClass(response.error_class['alamat_']);
                    $('[name="alamat_"]').next().text(response.error_string['alamat_']);

                    $('[name="email_"]').addClass(response.error_class['email_']);
                    $('[name="email_"]').next().text(response.error_string['email_']);

                    $('[name="no_hp_"]').addClass(response.error_class['no_hp_']);
                    $('[name="no_hp_"]').next().text(response.error_string['no_hp_']);

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
        var id_pengurus = id;
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
                del(id_pengurus);
            }
        });
    }
    async function del(id_pengurus) {
        $("#loading").show();
        const param = new FormData();
        param.append('id', id_pengurus);

        await fetch(SITE_URL + 'pengurus/list_pengurus/hapus_pengurus', {
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