<?php
class M_global extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function filterisasi($data)
    {
        $list_block = array(
            '<?php'         => '',
            '<?'            => '',
            '?>'            => '',
            'php_info()'    => '',
            'echo'          => '',
            '</script>'     => '',
            '</script>'     => ''
        );
        return strtr($data, $list_block);
    }

    function cek_masuk_admin($nama_petugas = '', $sandi = '')
    {
        $this->db->select("*");
        $this->db->from("admin");
        $this->db->where("nama_petugas", $nama_petugas);
        $this->db->where("sandi", $sandi);
        $query = $this->db->get();
        if ($query->num_rows() > 0) return $query->row_array();
        else return null;
    }

    function cek_masuk_perusahaan($nama_petugas = '', $sandi = '')
    {
        $this->db->select("*");
        $this->db->from("perusahaan");
        $this->db->where("nama_petugas = '" . $nama_petugas . "' and (sandi = '" . $sandi . "' or sandi_simulasi = '" . $sandi . "')  ");
        // $this->db->where("nama_petugas", $nama_petugas);
        // $this->db->where("sandi", $sandi);
        // $this->db->or_where("sandi_simulasi", $sandi);
        $query = $this->db->get();
        if ($query->num_rows() > 0) return $query->row_array();
        else return null;
    }

    function query_data_lowongan($id_perusahaan = '')
    {
        $this->db->select("*");
        $this->db->from("lowongan,perusahaan");
        $this->db->where("lowongan.id_perusahaan = perusahaan.id_perusahaan");
        $this->db->where("perusahaan.id_perusahaan", $id_perusahaan);
        $this->db->where("lowongan.aktif", "1");
        $query = $this->db->get();
        if ($query->num_rows() > 0) return $query->result_array();
        else return null;
    }

    function query_data_pengaturan_nonvirtual()
    {
        $this->db->select("*");
        $this->db->from("pengaturan");
        $this->db->order_by("aktif", "asc");
        $this->db->order_by("tanggal_mulai", "desc");
        $this->db->where("jenis_jobfair", "nonvirtual");
        $query = $this->db->get();
        if ($query->num_rows() > 0) return $query->result_array();
        else return null;
    }

    function query_data_perusahaan($id_perusahaan = '')
    {
        $this->db->select("*");
        $this->db->from("perusahaan");
        $this->db->where("id_perusahaan", $id_perusahaan);
        $query = $this->db->get();
        if ($query->num_rows() > 0) return $query->row_array();
        else return null;
    }

    function cek_jumlah_pelamar($id_lowongan = '')
    {
        $this->db->select("*");
        $this->db->from("lamaran");
        $this->db->where("id_lowongan", $id_lowongan);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function jml_pengguna_per_domisili($domisili = '')
    {
        $this->db->select("id_pengguna");
        $this->db->from("pengguna");
        $this->db->where("domisili", $domisili);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function jml_pengguna()
    {
        $this->db->select("id_pengguna");
        $this->db->from("pengguna");
        $query = $this->db->get();
        return $query->num_rows();
    }

    function jml_hadir($id_pengaturan)
    {
        $this->db->select("id_pendaftaran");
        $this->db->from("pendaftaran");
        if ($id_pengaturan != "all")
            $this->db->where("id_pengaturan", $id_pengaturan);
        $this->db->where("tanggal_hadir !=", null);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function jml_lamaran($id_pengaturan)
    {
        $this->db->select("id_lamaran");
        $this->db->from("lamaran, lowongan");
        $this->db->where("lowongan.id_lowongan = lamaran.id_lowongan");
        if ($id_pengaturan != "all")
            $this->db->where("lowongan.id_pengaturan", $id_pengaturan);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function jml_pelamar_domisili($id_pengaturan, $domisili)
    {
        $this->db->select("id_lamaran");
        $this->db->from("lamaran, lowongan, pengguna");
        $this->db->where("lowongan.id_lowongan = lamaran.id_lowongan and lamaran.id_pengguna = pengguna.id_pengguna");
        if ($id_pengaturan != "all")
            $this->db->where("lowongan.id_pengaturan", $id_pengaturan);

        if ($domisili != "")
            $this->db->where("pengguna.domisili", $domisili);

        $this->db->group_by('pengguna.nik');

        $query = $this->db->get();
        return $query->num_rows();
    }

    function jml_lamaran_status($id_pengaturan, $status)
    {
        $this->db->select("id_lamaran");
        $this->db->from("lamaran, lowongan");
        $this->db->where("lowongan.id_lowongan = lamaran.id_lowongan");
        if ($id_pengaturan != "all")
            $this->db->where("lowongan.id_pengaturan", $id_pengaturan);
        // $this->db->where("status !=", 'Masih Proses');
        if ($status == 'Sudah Proses')
            $this->db->where("lamaran.status in ('Tahap Seleksi Administrasi','Tahap Psikotes','Tahap Interview HRD','Tahap Interview User','Medical Check-up','Diterima','Tidak Diterima')");
        else
            $this->db->where("lamaran.status", $status);

        $query = $this->db->get();
        return $query->num_rows();
    }

    function jml_perusahaan($id_pengaturan)
    {
        $this->db->select("lowongan.id_perusahaan");
        $this->db->from("perusahaan, lowongan");
        $this->db->where("lowongan.id_perusahaan = perusahaan.id_perusahaan");
        if ($id_pengaturan != "all")
            $this->db->where("lowongan.id_pengaturan", $id_pengaturan);
        $this->db->group_by("lowongan.id_perusahaan");
        $query = $this->db->get();
        return $query->num_rows();
    }

    function jml_lowongan($id_pengaturan)
    {
        $this->db->select("id_lowongan");
        $this->db->from("lowongan");
        $this->db->join('perusahaan', 'lowongan.id_perusahaan = perusahaan.id_perusahaan');
        $this->db->join('pengaturan', 'lowongan.id_pengaturan = pengaturan.id_pengaturan');

        if ($id_pengaturan != "all")
            $this->db->where("lowongan.id_pengaturan", $id_pengaturan);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function jml_daftar_diri($id_pengaturan, $domisili)
    {
        $this->db->select("pendaftaran.id_pengguna");
        $this->db->from("pendaftaran, pengguna");
        $this->db->where("pendaftaran.id_pengguna = pengguna.id_pengguna");
        if ($id_pengaturan != "all")
            $this->db->where("pendaftaran.id_pengaturan", $id_pengaturan);
        $this->db->where("pengguna.domisili", $domisili);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function jml_formasi($id_pengaturan)
    {
        $this->db->select("SUM(kuota) as 'jml'");
        $this->db->from("lowongan");
        $this->db->join('perusahaan', 'lowongan.id_perusahaan = perusahaan.id_perusahaan');
        $this->db->join('pengaturan', 'lowongan.id_pengaturan = pengaturan.id_pengaturan');

        if ($id_pengaturan != "all")
            $this->db->where("lowongan.id_pengaturan", $id_pengaturan);
        $query = $this->db->get();
        if ($query->num_rows() > 0) return $query->row_array();
        else return 0;
    }

    function query_data_semua_perusahaan()
    {
        $this->db->select("*");
        $this->db->from("perusahaan");
        $this->db->order_by("nama_perusahaan", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) return $query->result_array();
        else return null;
    }

    function query_data_pengaturan()
    {
        $this->db->select("*");
        $this->db->from("pengaturan");
        $this->db->order_by("aktif", "asc");
        $this->db->order_by("tanggal_mulai", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) return $query->result_array();
        else return null;
    }

    function query_data_pengaturan_perperusahaan($kode_perusahaan)
    {
        $this->db->select("pengaturan.*");
        $this->db->from("pengaturan,lowongan");
        $this->db->where("pengaturan.id_pengaturan = lowongan.id_pengaturan");
        $this->db->where("lowongan.id_perusahaan", $kode_perusahaan);
        $this->db->group_by("pengaturan.id_pengaturan");
        $this->db->order_by("pengaturan.aktif", "asc");
        $this->db->order_by("pengaturan.tanggal_mulai", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) return $query->result_array();
        else return null;
    }

    function query_data_barang($ket = '')
    {
        $this->db->select("*");
        $this->db->from("barang");
        if ($ket == "penjualan")
            $this->db->where("stok_awal != 0");
        $this->db->order_by("nama_barang", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) return $query->result_array();
        else return null;
    }

    function query_cari_lowongan($id_pengaturan, $id_perusahaan)
    {
        $this->db->select("*");
        $this->db->from("lowongan");
        $this->db->where("id_pengaturan", $id_pengaturan);
        $this->db->where("id_perusahaan", $id_perusahaan);
        $this->db->order_by("posisi", "asc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) return $query->result_array();
        else return null;
    }

    function query_detail_lowongan($id_lowongan)
    {
        $this->db->select("*");
        $this->db->from("lowongan");
        $this->db->where("id_lowongan", $id_lowongan);
        $query = $this->db->get();
        if ($query->num_rows() > 0) return $query->row_array();
        else return null;
    }

    function tampil_tampil_data_row($select)
    {
        $query = $this->db->query($select);
        if ($query->num_rows() > 0) return $query->row_array();
        else return null;
    }

    function query_tambah($tabel, $data)
    {
        $this->db->insert($tabel, $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    function query_tambah_wilayah($tabel, $data)
    {
        $this->db->insert($tabel, $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    function databerkas($nik)
    {
        $this->db->select('*');
        $this->db->from('jejak_penting_pelamar a');
        $this->db->where('a.id_jejak', $nik);
        $this->db->order_by('a.id_jejak DESC');
        return  $this->db->get()->row();
    }

    function query_edit($tabel, $data, $where)
    {
        $query = $this->db->update($tabel, $data, $where);
        $aff_rows_activate = $this->db->affected_rows();
        return $aff_rows_activate;
    }

    function query_hapus($tabel, $data)
    {
        $this->db->delete($tabel, $data);
    }

    function generate_kode($panjang)
    {
        $karakter = 'ACDEFGHJKLMNPQRSTUVWXYZ2345679';
        $string = '';
        for ($i = 0; $i <= $panjang; $i++) {
            //for ($a = 0; $a < 5; $a++) {
            $pos = rand(0, strlen($karakter) - 1);
            $string .= $karakter{
            $pos};
            //}
            //$string .= "-";
        }
        return substr($string, 0, -1);
    }

    public function insert($table, $data)
    {
        $this->db->insert($table, $data);
        return true;
    }

    public function insert_id($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update($table, $where, $data)
    {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
        return true;
    }

    public function delete($table, $where)
    {
        $this->db->delete($table, $where);
        return true;
    }

    public function getData($value = '')
    {
        $this->db->select($value['select']);
        $this->db->from($value['table']);

        if (isset($value['where'])) {
            $this->db->where($value['where']);
        }

        if (isset($value['where_in'])) {
            $this->db->where_in($value['where_in']);
        }

        if (isset($value['join'])) {
            foreach ($value['join'] as $join) {
                $this->db->join($join['0'], $join['1'], 'left');
            }
        }

        if (isset($value['group'])) {
            $this->db->group_by($value['group']);
        }

        if (isset($value['limit'])) {
            $this->db->limit($value['limit']);
        }
        if (isset($value['having'])) {
            $this->db->having($value['having']);
        }
        if (isset($value['order'])) {
            $this->db->order_by($value['order']);
        }

        $result = $this->db->get()->result();
        return $result;
    }

    public function getRow($value = '')
    {
        $this->db->select($value['select']);
        $this->db->from($value['table']);

        if (isset($value['where'])) {
            $this->db->where($value['where']);
        }

        if (isset($value['join'])) {
            foreach ($value['join'] as $join) {
                $this->db->join($join['0'], $join['1'], 'left');
            }
        }

        if (isset($value['group'])) {
            $this->db->group_by($value['group']);
        }

        if (isset($value['limit'])) {
            $this->db->limit($value['limit']);
        }
        if (isset($value['order'])) {
            $this->db->order_by($value['order']);
        }

        $result = $this->db->get()->row();
        return $result;
    }

    public function getNum($value = '')
    {
        $this->db->select($value['select']);
        $this->db->from($value['table']);

        if (isset($value['where'])) {
            $this->db->where($value['where']);
        }

        if (isset($value['join'])) {
            foreach ($value['join'] as $join) {
                $this->db->join($join['0'], $join['1'], 'left');
            }
        }

        if (isset($value['group'])) {
            $this->db->group_by($value['group']);
        }

        if (isset($value['limit'])) {
            $this->db->limit($value['limit']);
        }
        if (isset($value['order'])) {
            $this->db->order_by($value['order']);
        }

        $result = $this->db->get()->num_rows();
        return $result;
    }

    public function insert_multiple($table, $data)
    {
        $this->db->insert_batch($table, $data);
    }

    public function getID($value = '')
    {
        if (isset($value['select'])) {
            $this->db->select($value['select']);
        }
        $this->db->from($value['table']);

        if (isset($value['where'])) {
            $this->db->where($value['where']);
        }

        $result = $this->db->get()->row();
        return $result;
    }

    public function getFetch($value = '')
    {
        $this->db->where('id_kecamatan', $value['where']);
        $result = $this->db->get($value['table']);
        $output = '<option value="0">-- Pilih Kelurahan --</option>';
        $array = array();

        foreach ($result->result_array() as $row) {

            $this->db->select('*');
            $this->db->from('m_syarat_wilayah a');
            $this->db->where('a.nama_kel', $row['nama']);
            $draft = $this->db->get()->result_array();

            foreach ($draft as $rows) {
                $this->db->select('*');
                $this->db->from('t_syarat_wilayah a');
                // $this->db->where('a.id_syarat_wilayah', $rows['id']);
                $drafts = $this->db->get()->result_array();
                foreach ($drafts as $rowss) {
                    $array[$rowss['id_syarat_wilayah']] = $rowss;
                }
                if (array_key_exists($rows['id'], $array)) {
                    $output .= "<option value='" . $row['id_kelurahan'] . "' disabled>" . $row['nama'] . "</option>";
                } else {
                    $output .= "<option value='" . $row['id_kelurahan'] . "'>" . $row['nama'] . "</option>";
                }
            }
        }
        return $output;
    }

    public function getFetch_edit($value = '')
    {
        $this->db->where('id_kecamatan', $value['where']);
        $result = $this->db->get($value['table']);
        $output = '<option value="0">-- Pilih Kelurahan --</option>';
        $array = array();

        foreach ($result->result_array() as $row) {

            $this->db->select('*');
            $this->db->from('m_syarat_wilayah a');
            $this->db->where('a.nama_kel', $row['nama']);
            $draft = $this->db->get()->result_array();

            foreach ($draft as $rows) {
                $this->db->select('*');
                $this->db->from('t_syarat_wilayah a');
                // $this->db->where('a.id_syarat_wilayah', $rows['id']);
                $drafts = $this->db->get()->result_array();
                foreach ($drafts as $rowss) {
                    $array[$rowss['id_syarat_wilayah']] = $rowss;
                }
                if (array_key_exists($rows['id'], $array)) {
                    $output .= "<option value='" . $row['id_kelurahan'] . "' selected>" . $row['nama'] . "</option>";
                } else {
                    $output .= "<option value='" . $row['id_kelurahan'] . "'>" . $row['nama'] . "</option>";
                }
            }
        }
        return $output;
    }

    public function getKel($value = '')
    {
        if (isset($value['select'])) {
            $this->db->select($value['select']);
        }
        $this->db->where_in('id_kelurahan', $value['where']);
        $this->db->from($value['table']);

        $result = $this->db->get()->result();
        return $result;
    }

    public function getWil($value = '')
    {
        if (isset($value['select'])) {
            $this->db->select($value['select']);
        }
        $this->db->where_in('nama_kel', $value['where']);
        $this->db->from($value['table']);

        $result = $this->db->get()->result();
        return $result;
    }
}
