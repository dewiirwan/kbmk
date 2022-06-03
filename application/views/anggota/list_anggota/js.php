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
        const newURL =
            window.location.protocol +
            "://" +
            window.location.host +
            "/" +
            window.location.pathname;
        const pathArray = window.location.pathname.split("/");
        const segment_4 = pathArray[4];
        get_edit(<?= $id_mhs; ?>);
    });

    $("#open-file").on("click", function() {
        $("#customFileUpload").trigger("click");
    });

    $('#customFileUpload').on('change', function(e) {

        if (this.files && this.files[0]) {
            $("#image-label").val(this.files[0].name);
            $('#imgPreview').attr('src', URL.createObjectURL(this.files[0]));
        }

    });
    $("#open-file_").on("click", function() {
        $("#customFileUpload_").trigger("click");
    });

    $('#customFileUpload_').on('change', function(e) {

        if (this.files && this.files[0]) {
            $("#image-label_").val(this.files[0].name);
            $('#imgPreviews').attr('src', URL.createObjectURL(this.files[0]));
        }

    });

    function get_edit(id_mhs) {
        $.ajax({
            url: '<?= base_url('anggota/profil_anggota/cek_edit'); ?>',
            type: 'POST',
            data: {
                id: id_mhs
            },
            success: function(data) {
                var myObj = JSON.parse(data);
                document.getElementById("id_mhs").value = id_mhs;
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
                    $('#image-label').val(subs);
                }

            }
        });
    }

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

        await fetch(SITE_URL + 'anggota/profil_anggota/update', {
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
</script>