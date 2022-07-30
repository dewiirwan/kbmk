<?php defined('BASEPATH') or exit('No direct script access allowed');

class Konsultasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

        $this->data['title'] = 'KBMK | Form Konsultasi';
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

        $this->data['isi'] = 'anggota/form_konsultasi/index';
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

    public function proses()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {

            $status                = true;
            $user = $this->ion_auth->user()->row();

            $nama_lengkap   = $this->input->post('nama_lengkap');
            $kelas          = $this->input->post('kelas');
            $npm            = $this->input->post('npm');
            $no_telp        = $this->input->post('no_telp');
            $tujuan        = $this->input->post('tujuan');


            $this->_validate();

            $data = array(
                'id_mhs'      => $user->id_mhs,
                'nama'        => $nama_lengkap,
                'kelas'       => $kelas,
                'npm'         => $npm,
                'no_whatsapp' => $no_telp,
                'tujuan'      => $tujuan,
                'create_date' => date('Y-m-d H:i:s')
            );

            $KETERANGAN = "Simpan Konsultasi: "
                . "; " . $nama_lengkap
                . "; " . $kelas
                . "; " . $npm
                . "; " . $no_telp
                . "; " . $tujuan;
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }

        $insert = $this->db->insert('t_konsultasi', $data);
        echo json_encode(['status' => $status]);
    }

    public function hapus()
    {
        $post   = $this->input->post();
        $where  = array('id_konsultasi' => $post['id']);
        $status = true;

        $this->db->where($where);
        $this->db->delete('t_konsultasi');


        echo json_encode(['status' => $status]);
    }

    private function _validate()
    {
        $data = [];

        $nama_lengkap = $this->input->post('nama_lengkap');
        $kelas        = $this->input->post('kelas');
        $npm          = $this->input->post('npm');
        $no_telp      = $this->input->post('no_telp');
        $tujuan       = $this->input->post('tujuan');


        $data['error_class']  = [];
        $data['error_string'] = [];
        $data['status']       = true;

        if ($nama_lengkap == '') {
            $data['error_class']['nama_lengkap']  = 'is-invalid';
            $data['error_string']['nama_lengkap'] = 'Nama Lengkap tidak boleh kosong';
            $data['status']                         = false;
        }

        if ($kelas == '') {
            $data['error_class']['kelas']  = 'is-invalid';
            $data['error_string']['kelas'] = 'Kelas tidak boleh kosong';
            $data['status']                = false;
        }

        if ($npm == '') {
            $data['error_class']['npm']  = 'is-invalid';
            $data['error_string']['npm'] = 'NPM tidak boleh kosong';
            $data['status']                = false;
        }

        if ($no_telp == '') {
            $data['error_class']['no_telp']  = 'is-invalid';
            $data['error_string']['no_telp'] = 'Nomor Telepon tidak boleh kosong';
            $data['status']                         = false;
        }

        if ($tujuan == '') {
            $data['error_class']['tujuan']  = 'is-invalid';
            $data['error_string']['tujuan'] = 'Tujuan Belum dipilih';
            $data['status']                         = false;
        }

        if ($data['status'] == false) {
            echo json_encode($data);
            exit();
        }
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $hasil = $this->db->query("INSERT INTO user_log (id_user, waktu, keterangan, type) VALUES('$user->id_mhs', '$KETERANGAN', '$WAKTU', 'KONSULTASI')");
        return $hasil;
    }

    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses Konsultasi";
        $WAKTU = date('Y-m-d H:i:s');
        $this->m_kegiatan->user_log_kegiatan($user->id_mhs, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }
}
