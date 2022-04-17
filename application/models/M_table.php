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
