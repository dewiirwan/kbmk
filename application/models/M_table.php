<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_table extends CI_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($type = null, $sort = null, $order = null)
    {
        switch ($type) {
            case 'data_list_pengurus':
                $this->db->select('id_pengurus,npm,nama as nama_pengurus,tempat_tgl_lahir,alamat,email,no_hp');
                $this->db->from('pengurus');
                if ($_POST['order'][0]['column'] == 0) {
                    $this->db->order_by('id_pengurus', $order);
                } else {
                    $this->db->order_by($sort, $order);
                }

                $filter   = @$_POST['filter'];
                break;
            case 'data_list_anggota':
                $this->db->select('a.id_mhs, a.npm, a.nama as nama_anggota, a.tempat_tgl_lahir, a.alamat, a.email, a.no_hp, b.id_user');
                $this->db->from('mahasiswa a');
                $this->db->join('users b', 'a.id_mhs = b.id_mhs');
                if ($_POST['order'][0]['column'] == 0) {
                    $this->db->order_by('id_mhs', $order);
                } else {
                    $this->db->order_by($sort, $order);
                }

                $filter   = @$_POST['filter'];
                break;
            case 'data_list_anggota_pengurus':
                $this->db->select('a.id_mhs, a.npm, a.nama as nama_anggota, a.tempat_tgl_lahir, a.alamat, a.email, a.no_hp');
                $this->db->from('mahasiswa a');
                if ($_POST['order'][0]['column'] == 0) {
                    $this->db->order_by('id_mhs', $order);
                } else {
                    $this->db->order_by($sort, $order);
                }

                $filter   = @$_POST['filter'];
                break;
            case 'data_list_jadwal_detail':
                $this->db->select('K.id_kegiatan, K.nama_kegiatan, U.nama as nama_mhs, K.tgl_kegiatan, J.no_urut, J.kode_qr, J.jam_hadir, J.id_jadwal');
                $this->db->from('kegiatan K');
                $this->db->join('jadwal J', 'K.id_kegiatan = J.id_kegiatan', 'LEFT');
                $this->db->join('mahasiswa U', 'U.id_mhs = J.id_mhs', 'LEFT');
                if ($_POST['order'][0]['column'] == 0) {
                    $this->db->order_by('id_jadwal', $order);
                } else {
                    $this->db->order_by($sort, $order);
                }

                $filter   = @$_POST['filter'];
                break;
            case 'data_list_jadwal_kegiatan':
                $this->db->select('id_kegiatan, nama_kegiatan, tgl_kegiatan, durasi, ketua_panitia, jml_slot');
                $this->db->from('kegiatan');
                if ($_POST['order'][0]['column'] == 0) {
                    $this->db->order_by('id_kegiatan', $order);
                } else {
                    $this->db->order_by($sort, $order);
                }

                $filter   = @$_POST['filter'];
                break;
            case 'data_list_kegiatan':
                $this->db->select('*');
                $this->db->from('kegiatan');
                if ($_POST['order'][0]['column'] == 0) {
                    $this->db->order_by('id_kegiatan', $order);
                } else {
                    $this->db->order_by($sort, $order);
                }

                $filter   = @$_POST['filter'];
                break;
            case 'data_list_kegiatan_anggota':
                $this->db->select('*');
                $this->db->from('kegiatan');
                if ($_POST['order'][0]['column'] == 0) {
                    $this->db->order_by('id_kegiatan', $order);
                } else {
                    $this->db->order_by($sort, $order);
                }

                $filter   = @$_POST['filter'];
                break;
            case 'data_list_pengajuan':
                $this->db->select('*');
                $this->db->from('form_pengajuan');
                if ($_POST['order'][0]['column'] == 0) {
                    $this->db->order_by('id_form', $order);
                } else {
                    $this->db->order_by($sort, $order);
                }

                $filter   = @$_POST['filter'];
                break;
            case 'data_list_pengumuman':
                $this->db->select('*');
                $this->db->from('pengumuman');
                if ($_POST['order'][0]['column'] == 0) {
                    $this->db->order_by('id_pengumuman', $order);
                } else {
                    $this->db->order_by($sort, $order);
                }

                $filter   = @$_POST['filter'];
                break;

            default:
                # code...
                break;
        }
    }

    function get_datatables($type = null, $sort = null, $order = null)
    {
        $this->_get_datatables_query($type, $sort, $order);

        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($type = null)
    {
        $this->_get_datatables_query($type);

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($type = null)
    {
        $this->_get_datatables_query($type);
        $db_results = $this->db->get();
        $results = $db_results->result();
        $num_rows = $db_results->num_rows();
        return $num_rows;
    }
}
