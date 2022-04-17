<?php defined('BASEPATH') or exit('No direct script access allowed');

class List_pengurus extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->load->model('m_pengurus');
        $this->load->model('m_global');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        // $this->load->model('foto_model');
        $this->data['title'] = 'KBMK | List Pengurus';
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

        $this->data['isi'] = 'pengurus/list_pengurus/index';
        $this->data['id_group'] = $id_group->id_group;

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(1)) {
            $this->load->view('template_pengurus/wrapper', $this->data);
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
        $this->m_pengurus->user_log_pengurus($user->id_mhs, $KETERANGAN, $WAKTU);
    }

    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses Pengurus";
        $WAKTU = date('Y-m-d H:i:s');
        $this->m_pengurus->user_log_pengurus($user->id_mhs, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function cek_edit()
    {
        $id     = $this->input->post('id');

        $query['select'] = 'a.*';
        $query['table']  = 'pengurus a';
        $query['where']  = 'a.id_pengurus = ' . $id;

        if (isset($id)) {
            $cek                                = $this->m_global->getRow($query);
            echo json_encode($cek);
        } else {
            $this->session->set_flashdata('pesan_gagal', 'Id tidak boleh kosong');
            redirect('pengurus/list_pengurus');
        }
    }

    public function proses()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(1))) {
            $status                = true;
            $nama_lengkap             = $this->input->post('nama_lengkap');
            $npm        = $this->input->post('npm');
            $ttl                 = $this->input->post('ttl');
            $no_hp                 = $this->input->post('no_hp');
            $alamat                 = $this->input->post('alamat');
            $email             = $this->input->post('email');

            $this->_validate();
            if ($this->m_pengurus->cek_npm_pengurus($npm) == 'Data belum ada') {

                $data = array(
                    'nama'                => $nama_lengkap,
                    'npm'             => $npm,
                    'tempat_tgl_lahir'                     => $ttl,
                    'alamat'                         => $alamat,
                    'email'                         => $email,
                    'no_hp'               => $no_hp,
                );

                $KETERANGAN = "Simpan Pengurus: "
                    . "; " . $nama_lengkap
                    . "; " . $npm
                    . "; " . $ttl
                    . "; " . $no_hp
                    . "; " . $alamat
                    . "; " . $email;
                $this->user_log($KETERANGAN);
            } else {
                echo 'NIK Pengurus sudah terekam/ada sebelumnya';
            }
        } else {
            $this->logout();
        }

        $this->db->insert('pengurus', $data);
        echo json_encode(['status' => $status]);
    }

    public function update()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(1))) {
            $status                = true;
            $nama_lengkap             = $this->input->post('nama_lengkap_');
            $npm        = $this->input->post('npm_');
            $ttl                 = $this->input->post('ttl_');
            $no_hp                 = $this->input->post('no_hp_');
            $alamat                 = $this->input->post('alamat_');
            $email             = $this->input->post('email_');

            $id     = $this->input->post('id_pengurus');

            $query['select'] = 'a.*';
            $query['table']  = 'pengurus a';
            $query['where']  = 'a.id_pengurus = ' . $id;

            $cek                                = $this->m_global->getRow($query);

            $this->_validates();

            $data = array(
                'nama'                => $nama_lengkap,
                'npm'             => $npm,
                'tempat_tgl_lahir'                     => $ttl,
                'alamat'                         => $alamat,
                'email'                         => $email,
                'no_hp'               => $no_hp,
            );

            $KETERANGAN = "Ubah Data Pengurus: " . json_encode($cek) . " ---- " . $nama_lengkap . ";" . $npm . ";" . $ttl . ";" . $no_hp . ";" . $alamat . ";" . $email;

            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }

        $this->db->where('id_pengurus', $id);
        $this->db->update('pengurus', $data);
        echo json_encode(['status' => $status]);
    }

    private function _validate()
    {
        $data = [];

        $nama_lengkap             = $this->input->post('nama_lengkap');
        $npm        = $this->input->post('npm');
        $ttl                 = $this->input->post('ttl');
        $no_hp                 = $this->input->post('no_hp');
        $alamat                 = $this->input->post('alamat');
        $email             = $this->input->post('email');


        $data['error_class']  = [];
        $data['error_string'] = [];
        $data['status']       = true;

        if ($nama_lengkap == '') {
            $data['error_class']['nama_lengkap']  = 'is-invalid';
            $data['error_string']['nama_lengkap'] = 'Nama Lengkap tidak boleh kosong';
            $data['status']                         = false;
        }

        if ($npm == '') {
            $data['error_class']['npm']  = 'is-invalid';
            $data['error_string']['npm'] = 'NPM tidak boleh kosong';
            $data['status']                = false;
        }

        if ($ttl == '') {
            $data['error_class']['ttl']  = 'is-invalid';
            $data['error_string']['ttl'] = 'Tempat Tanggal Lahir tidak boleh kosong';
            $data['status']                = false;
        }

        if ($no_hp == '') {
            $data['error_class']['no_hp']  = 'is-invalid';
            $data['error_string']['no_hp'] = 'Nomor Handphone tidak boleh kosong';
            $data['status']                         = false;
        }

        if ($alamat == '') {
            $data['error_class']['alamat']  = 'is-invalid';
            $data['error_string']['alamat'] = 'Alamat tidak boleh kosong';
            $data['status']                              = false;
        }

        if ($email == '') {
            $data['error_class']['email']  = 'is-invalid';
            $data['error_string']['email'] = 'Email tidak boleh kosong';
            $data['status']                          = false;
        }

        if ($data['status'] == false) {
            echo json_encode($data);
            exit();
        }
    }

    private function _validates()
    {
        $data = [];

        $nama_lengkap             = $this->input->post('nama_lengkap_');
        $npm        = $this->input->post('npm_');
        $ttl                 = $this->input->post('ttl_');
        $no_hp                 = $this->input->post('no_hp_');
        $alamat                 = $this->input->post('alamat_');
        $email             = $this->input->post('email_');


        $data['error_class']  = [];
        $data['error_string'] = [];
        $data['status']       = true;

        if ($nama_lengkap == '') {
            $data['error_class']['nama_lengkap_']  = 'is-invalid';
            $data['error_string']['nama_lengkap_'] = 'Nama Lengkap tidak boleh kosong';
            $data['status']                         = false;
        }

        if ($npm == '') {
            $data['error_class']['npm_']  = 'is-invalid';
            $data['error_string']['npm_'] = 'NPM tidak boleh kosong';
            $data['status']                = false;
        }

        if ($ttl == '') {
            $data['error_class']['ttl_']  = 'is-invalid';
            $data['error_string']['ttl_'] = 'Tempat Tanggal Lahir tidak boleh kosong';
            $data['status']                = false;
        }

        if ($no_hp == '') {
            $data['error_class']['no_hp_']  = 'is-invalid';
            $data['error_string']['no_hp_'] = 'Nomor Handphone tidak boleh kosong';
            $data['status']                         = false;
        }

        if ($alamat == '') {
            $data['error_class']['alamat_']  = 'is-invalid';
            $data['error_string']['alamat_'] = 'Alamat tidak boleh kosong';
            $data['status']                              = false;
        }

        if ($email == '') {
            $data['error_class']['email_']  = 'is-invalid';
            $data['error_string']['email_'] = 'Email tidak boleh kosong';
            $data['status']                          = false;
        }

        if ($data['status'] == false) {
            echo json_encode($data);
            exit();
        }
    }

    public function hapus_pengurus()
    {
        $post   = $this->input->post();
        $where  = array('id_pengurus' => $post['id']);
        $status = true;

        $this->db->where($where);
        $this->db->delete('pengurus');

        echo json_encode(['status' => $status]);
    }
}
