<?php defined('BASEPATH') or exit('No direct script access allowed');

class List_kegiatan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->load->model('m_kegiatan');
        $this->load->model('M_anggota');
        $this->load->model('m_global');
        $this->load->model('M_foto');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        // $this->load->model('foto_model');
        $this->data['title'] = 'KBMK | List Kegiatan';
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index()
    {
        //jika mereka belum login
        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login  
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();
        $id_group = $this->db->query('SELECT id_group FROM users_groups WHERE id_user = ' . $user->id_user . '')->row();
        $this->data['ip_address'] = $user->ip_address;
        $this->data['email'] = $user->email;
        $this->data['user_id'] = $user->id_user;
        date_default_timezone_set('Asia/Jakarta');
        $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

        $this->data['isi'] = 'anggota/list_kegiatan/index';
        $this->data['id_group'] = $id_group->id_group;

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
            $this->load->view('template/wrapper', $this->data);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    public function detail()
    {
        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login
            redirect('auth/login', 'refresh');
        }

        //get data tabel users untuk ditampilkan
        $user = $this->ion_auth->user()->row();
        $id_group = $this->db->query('SELECT id_group FROM users_groups WHERE id_user = ' . $user->id_user . '')->row();

        $this->data['USER_ID'] = $user->id_user;
        $this->data['id_mhs'] = $user->id_mhs;
        // $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
        $this->data['role_user'] = 'anggota';
        $this->data['ip_address'] = $user->ip_address;
        $this->data['email'] = $user->email;
        $this->data['USER_ID'] = $user->id_user;
        date_default_timezone_set('Asia/Jakarta');
        $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');
        $this->data['isi'] = 'anggota/list_kegiatan/detail';
        $this->data['id_group'] = $id_group->id_group;

        $query_foto_user = $this->M_foto->get_data_by_id_mhs($user->id_mhs);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        $this->data['id_kegiatan'] = $this->uri->segment(4);

        //Kueri data di tabel kegiatan
        $query_detil_kegiatan = $this->m_kegiatan->get_detil($this->data['id_kegiatan']);

        $query_detil_kegiatan_result = $this->m_kegiatan->get_detil_result($this->data['id_kegiatan']);
        $this->data['query_detil_kegiatan_result'] = $query_detil_kegiatan_result;

        if ($query_detil_kegiatan->num_rows() == 0) {
            // alihkan mereka ke halaman list anggota
            redirect('anggota/list_kegiatan', 'refresh');
        }
        //Kueri data di tabel anggota file
        $query_file_id_kegiatan = $this->m_kegiatan->file_list_by_id_kegiatan($this->data['id_kegiatan']);

        //log
        $KETERANGAN = "Lihat Profil Kegiatan: " . json_encode($query_detil_kegiatan_result) . " ---- " . json_encode($query_file_id_kegiatan);
        $this->user_log($KETERANGAN);

        $hasil_1 = $query_detil_kegiatan->row();
        $this->data['id_kegiatan'] = $hasil_1->id_kegiatan;
        $sess_data['id_kegiatan'] = $this->data['id_kegiatan'];
        $this->session->set_userdata($sess_data);

        if ($query_file_id_kegiatan->num_rows() > 0) {

            $this->data['dokumen'] = $this->m_kegiatan->file_list_by_id_kegiatan_result($sess_data['id_kegiatan']);

            $hasil = $query_file_id_kegiatan->row();
            $DOK_FILE = $hasil->dok_file;
            $TANGGAL_UPLOAD = $hasil->tanggal_upload;

            if (file_exists($file = './assets/uploads/kegiatan/' . $DOK_FILE)) {
                $this->data['DOK_FILE'] = $DOK_FILE;
                $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                $this->data['FILE'] = "ADA";
            }
        } else {
            $this->data['FILE'] = "TIDAK ADA";
        }

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->in_group(2)) {
            $sess_data['id_kegiatan'] = $this->data['id_kegiatan'];

            $this->load->view('template/wrapper', $this->data);
        } else {
            $this->logout();
        }
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->m_kegiatan->user_log_kegiatan($user->id_mhs, $KETERANGAN, $WAKTU);
    }

    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses Kegiatan";
        $WAKTU = date('Y-m-d H:i:s');
        $this->m_kegiatan->user_log_kegiatan($user->id_mhs, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }
}
