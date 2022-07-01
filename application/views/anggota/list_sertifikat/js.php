<script type="text/javascript" language="javascript">
    var dataTable;
    var BASE_URL = '<?php echo base_url(); ?>';
    var SITE_URL = '<?php echo site_url(); ?>';

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
                    data.type = 'data_list_sertif_anggota';
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
                    'data': 'keterangan_file'
                },
                {
                    'data': 'ekstensi'
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

    function detail(id_sertif) {
        window.location.href = BASE_URL + 'anggota/list_sertif/detail/' + id_sertif;
    }
</script>