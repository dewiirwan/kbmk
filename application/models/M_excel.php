<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_excel extends CI_model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function query($type)
    {
        switch ($type) {
            case 'data_hadir_anggota':
                $this->db->select('K.id_kegiatan, K.nama_kegiatan, K.tgl_kegiatan, U.nama as nama_anggota, U.npm, U.id_mhs, U.alamat, U.email, U.no_hp, J.no_urut, J.jam_hadir, J.id_jadwal');
                $this->db->from('kegiatan K');
                $this->db->join('jadwal J', 'K.id_kegiatan = J.id_kegiatan', 'LEFT OUTER');
                $this->db->join('mahasiswa U', 'U.id_mhs = J.id_mhs', 'LEFT OUTER');
                $this->db->where('J.jam_hadir !=', '');
                return $this->db->get()->result();
                break;

            case 'data_list_anggota':
                $this->db->select('a.id_mhs, a.npm, a.nama as nama_anggota, a.tempat_tgl_lahir, a.alamat, a.email, a.no_hp');
                $this->db->from('mahasiswa a');
                return $this->db->get()->result();
                break;

            case 'data_list_pengurus':
                $this->db->select('id_pengurus,npm,nama as nama_pengurus,tempat_tgl_lahir,alamat,email,no_hp');
                $this->db->from('pengurus');
                return $this->db->get()->result();
                break;

            case 'data_list_kegiatan':
                $this->db->select('*');
                $this->db->from('kegiatan');
                return $this->db->get()->result();
                break;

            case 'data_list_jadwal':
                $this->db->select('id_kegiatan, nama_kegiatan, tgl_kegiatan, durasi, ketua_panitia, jml_slot');
                $this->db->from('kegiatan');
                return $this->db->get()->result();
                break;

            case 'data_list_pengumuman':
                $this->db->select('*');
                $this->db->from('pengumuman');
                return $this->db->get()->result();
                break;

            case 'data_list_sertif':
                $user = $this->ion_auth->user()->row();
                $this->db->select('a.id_log_file, a.ekstensi, a.keterangan_file');
                $this->db->from('log_file a');
                $this->db->where('id_pengirim', $user->id_mhs);
                return $this->db->get()->result();
                break;

            case 'data_list_pengajuan':
                $user = $this->ion_auth->user()->row();
                $this->db->select('*');
                $this->db->from('form_pengajuan');
                $this->db->where('id_user', $user->id_user);
                return $this->db->get()->result();
                break;
            default:
                # code...
                break;
        }
    }
}
