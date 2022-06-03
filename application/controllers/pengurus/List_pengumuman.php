<?php defined('BASEPATH') or exit('No direct script access allowed');

class List_pengumuman extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->load->model('m_pengumuman');
        $this->load->model('m_global');
        $this->load->model('M_foto');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        // $this->load->model('foto_model');
        $this->data['title'] = 'KBMK | List Pengumuman';
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

        $this->data['isi'] = 'pengurus/list_pengumuman/index';
        $this->data['id_group'] = $id_group->id_group;

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(1)) {
            $this->load->view('template/wrapper', $this->data);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->m_pengumuman->user_log_pengumuman($user->id_mhs, $KETERANGAN, $WAKTU);
    }

    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses Pengumuman";
        $WAKTU = date('Y-m-d H:i:s');
        $this->m_pengumuman->user_log_pengumuman($user->id_mhs, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function cek_edit()
    {
        $id     = $this->input->post('id');

        $query['select'] = 'a.*';
        $query['table']  = 'pengumuman a';
        $query['where']  = 'a.id_pengumuman = ' . $id;

        if (isset($id)) {
            $cek                                = $this->m_global->getRow($query);
            echo json_encode($cek);
        } else {
            $this->session->set_flashdata('pesan_gagal', 'Id tidak boleh kosong');
            redirect('pengurus/list_pengumuman');
        }
    }

    public function proses()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(1))) {
            $user = $this->ion_auth->user()->row();
            $status                = true;
            $judul             = $this->input->post('judul');
            $headline_berita        = $this->input->post('headline_berita');
            $isi_berita                 = $this->input->post('isi_berita');
            $tgl_posting                 = $this->input->post('tgl_posting');
            $keterangan                 = $this->input->post('keterangan');



            $this->_validate();
            if ($this->m_pengumuman->cek_judul_pengumuman($judul) == 'BELUM ADA PENGUMUMAN') {

                $data = array(
                    'judul'                => $judul,
                    'headline_berita'             => $headline_berita,
                    'isi_berita'                     => $isi_berita,
                    'tgl_posting'                         => $tgl_posting,
                    'keterangan'                         => $keterangan,
                );

                $KETERANGANS = "Simpan Pengumuman: "
                    . "; " . $judul
                    . "; " . $headline_berita
                    . "; " . $isi_berita
                    . "; " . $tgl_posting
                    . "; " . $keterangan;
                $this->user_log($KETERANGANS);
            } else {
                echo 'Nama Pengumuman sudah terekam/ada sebelumnya';
            }
        } else {
            $this->logout();
        }

        $this->db->insert('pengumuman', $data);
        echo json_encode(['status' => $status]);
    }

    public function update()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(1))) {
            $status                = true;
            $judul             = $this->input->post('judul_');
            $headline_berita        = $this->input->post('headline_berita_');
            $isi_berita                 = $this->input->post('isi_berita_');
            $tgl_posting                 = $this->input->post('tgl_posting_');
            $keterangan                 = $this->input->post('keterangan_');

            $id     = $this->input->post('id_pengumuman');

            $query['select'] = 'a.*';
            $query['table']  = 'pengumuman a';
            $query['where']  = 'a.id_pengumuman = ' . $id;

            $cek                                = $this->m_global->getRow($query);

            $this->_validates();

            $data = array(
                'judul'                => $judul,
                'headline_berita'             => $headline_berita,
                'isi_berita'                     => $isi_berita,
                'tgl_posting'                         => $tgl_posting,
                'keterangan'                         => $keterangan,
            );

            $KETERANGANS = "Ubah Data Pengumuman: " . json_encode($cek) . " ---- " . $judul . ";" . $headline_berita . ";" . $isi_berita . ";" . $tgl_posting . ";" . $keterangan;

            $this->user_log($KETERANGANS);
        } else {
            $this->logout();
        }

        $this->db->where('id_pengumuman', $id);
        $this->db->update('pengumuman', $data);
        echo json_encode(['status' => $status]);
    }

    private function _validate()
    {
        $data = [];

        $judul             = $this->input->post('judul');
        $headline_berita        = $this->input->post('headline_berita');
        $isi_berita                 = $this->input->post('isi_berita');
        $tgl_posting                 = $this->input->post('tgl_posting');
        $keterangan                 = $this->input->post('keterangan');


        $data['error_class']  = [];
        $data['error_string'] = [];
        $data['status']       = true;

        if ($judul == '') {
            $data['error_class']['judul']  = 'is-invalid';
            $data['error_string']['judul'] = 'Judul tidak boleh kosong';
            $data['status']                         = false;
        }

        if ($headline_berita == '') {
            $data['error_class']['headline_berita']  = 'is-invalid';
            $data['error_string']['headline_berita'] = 'Headline Berita tidak boleh kosong';
            $data['status']                = false;
        }

        if ($isi_berita == '') {
            $data['error_class']['isi_berita']  = 'is-invalid';
            $data['error_string']['isi_berita'] = 'Isi Berita tidak boleh kosong';
            $data['status']                = false;
        }

        if ($tgl_posting == '') {
            $data['error_class']['tgl_posting']  = 'is-invalid';
            $data['error_string']['tgl_posting'] = 'Tanggal Posting belum dipilih';
            $data['status']                         = false;
        }

        if ($keterangan == '') {
            $data['error_class']['keterangan']  = 'is-invalid';
            $data['error_string']['keterangan'] = 'Keterangan tidak boleh kosong';
            $data['status']                              = false;
        }

        if ($data['status'] == false) {
            echo json_encode($data);
            exit();
        }
    }

    private function _validates()
    {
        $data = [];

        $judul             = $this->input->post('judul_');
        $headline_berita        = $this->input->post('headline_berita_');
        $isi_berita                 = $this->input->post('isi_berita_');
        $tgl_posting                 = $this->input->post('tgl_posting_');
        $keterangan                 = $this->input->post('keterangan_');


        $data['error_class']  = [];
        $data['error_string'] = [];
        $data['status']       = true;

        if ($judul == '') {
            $data['error_class']['judul_']  = 'is-invalid';
            $data['error_string']['judul_'] = 'Judul tidak boleh kosong';
            $data['status']                         = false;
        }

        if ($headline_berita == '') {
            $data['error_class']['headline_berita_']  = 'is-invalid';
            $data['error_string']['headline_berita_'] = 'Headline Berita tidak boleh kosong';
            $data['status']                = false;
        }

        if ($isi_berita == '') {
            $data['error_class']['isi_berita_']  = 'is-invalid';
            $data['error_string']['isi_berita_'] = 'Isi Berita tidak boleh kosong';
            $data['status']                = false;
        }

        if ($tgl_posting == '') {
            $data['error_class']['tgl_posting_']  = 'is-invalid';
            $data['error_string']['tgl_posting_'] = 'Tanggal Posting belum dipilih';
            $data['status']                         = false;
        }

        if ($keterangan == '') {
            $data['error_class']['keterangan_']  = 'is-invalid';
            $data['error_string']['keterangan_'] = 'Keterangan tidak boleh kosong';
            $data['status']                              = false;
        }

        if ($data['status'] == false) {
            echo json_encode($data);
            exit();
        }
    }

    public function hapus_pengumuman()
    {
        $post   = $this->input->post();
        $where  = array('id_pengumuman' => $post['id']);
        $status = true;

        $this->db->where($where);
        $this->db->delete('pengumuman');

        echo json_encode(['status' => $status]);
    }

    public function detail()
    {
        //jika mereka belum login
        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login
            redirect('auth/login', 'refresh');
        }

        //get data tabel users untuk ditampilkan
        $user = $this->ion_auth->user()->row();
        $id_group = $this->db->query('SELECT id_group FROM users_groups WHERE id_user = ' . $user->id_user . '')->row();

        $this->data['USER_ID'] = $user->id_user;
        $this->data['id_pengumuman'] = $user->id_mhs;
        // $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
        $this->data['role_user'] = 'pengurus';
        $this->data['ip_address'] = $user->ip_address;
        $this->data['email'] = $user->email;
        date_default_timezone_set('Asia/Jakarta');
        $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');
        $this->data['isi'] = 'pengurus/list_pengumuman/detail';
        $this->data['id_group'] = $id_group->id_group;

        $query_foto_user = $this->M_foto->get_data_by_id_mhs($user->id_mhs);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        $this->data['id_pengumuman'] = $this->uri->segment(4);

        //Kueri data di tabel pengurus
        $query_detil_pengumuman = $this->m_pengumuman->get_detil($this->data['id_pengumuman']);

        $query_detil_pengumuman_result = $this->m_pengumuman->get_detil_result($this->data['id_pengumuman']);
        $this->data['query_detil_pengumuman_result'] = $query_detil_pengumuman_result;

        if ($query_detil_pengumuman->num_rows() == 0) {
            // alihkan mereka ke halaman list pengurus
            redirect('pengurus/list_pengumuman', 'refresh');
        }

        //log
        $KETERANGAN = "Lihat Profil Pengumuman: " . json_encode($query_detil_pengumuman_result);
        $this->user_log($KETERANGAN);

        $hasil_1 = $query_detil_pengumuman->row();
        $this->data['id_pengumuman'] = $hasil_1->id_pengumuman;
        $sess_data['id_pengumuman'] = $this->data['id_pengumuman'];
        $this->session->set_userdata($sess_data);

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->in_group(1)) {

            $this->load->view('template/wrapper', $this->data);
        } else {
            $this->logout();
        }
    }
}
