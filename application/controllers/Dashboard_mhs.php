<?php defined('BASEPATH') or exit('No direct script access allowed');

class dashboard_mhs extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        // $this->load->model('foto_model');
        $this->load->model('m_kegiatan');
        $this->data['title'] = 'KBMK | Dashboard Anggota';
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
        $this->data['left_menu'] = "dashboard_anggota_aktif";
        $this->data['id_group']  = $id_group->id_group;

        $this->data['isi'] = 'anggota/dashboard';

        $this->data['pengumuman'] = $this->db->query('SELECT id_pengumuman, judul, isi_berita, tgl_posting FROM pengumuman')->result();
        // var_dump($this->data['pengumuman']);
        // die;

        // $query_foto_user = $this->foto_model->get_data_by_id_umat($user->ID_UMAT);
        // if ($query_foto_user == "BELUM ADA FOTO") {
        //     $this->data['foto_user'] = "assets/silsci/img/profile_small.jpg";
        // } else {
        //     $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        // }


        //jika mereka sudah login dan sebagai umat
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
            $this->load->view('template/wrapper', $this->data);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    public function detail($id_pengumuman)
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
        $this->data['left_menu'] = "detail_berita_aktif";
        $this->data['id_group']  = $id_group->id_group;

        $this->data['isi'] = 'anggota/detail_berita';

        $this->data['pengumuman'] = $this->db->query('SELECT id_pengumuman, judul, isi_berita, tgl_posting FROM pengumuman WHERE id_pengumuman = ' . $id_pengumuman . '')->row();
        // var_dump($this->data['pengumuman']);
        // die;

        // $query_foto_user = $this->foto_model->get_data_by_id_umat($user->ID_UMAT);
        // if ($query_foto_user == "BELUM ADA FOTO") {
        //     $this->data['foto_user'] = "assets/silsci/img/profile_small.jpg";
        // } else {
        //     $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        // }


        //jika mereka sudah login dan sebagai umat
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
            $this->load->view('template/wrapper', $this->data);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    /**
     * Log the user out
     */
    public function logout()
    {

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('auth/login', 'refresh');
    }
}
