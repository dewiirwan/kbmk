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

        $this->data['isi'] = 'pengurus/list_kegiatan/index';
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

    public function cek_edit()
    {
        $id     = $this->input->post('id');

        $query['select'] = 'a.*';
        $query['table']  = 'kegiatan a';
        $query['where']  = 'a.id_kegiatan = ' . $id;

        if (isset($id)) {
            $cek                                = $this->m_global->getRow($query);
            echo json_encode($cek);
        } else {
            $this->session->set_flashdata('pesan_gagal', 'Id tidak boleh kosong');
            redirect('pengurus/list_kegiatan');
        }
    }

    public function proses()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(1))) {
            $user = $this->ion_auth->user()->row();
            $status                = true;
            $nama_kegiatan             = $this->input->post('nama_kegiatan');
            $tgl_kegiatan        = $this->input->post('tgl_kegiatan');
            $pengkhotbah                 = $this->input->post('pengkhotbah');
            $durasi                 = $this->input->post('durasi');
            $ketuplak                 = $this->input->post('ketuplak');
            $kapasitas             = $this->input->post('kapasitas');
            $deskripsi             = $this->input->post('deskripsi');
            $created_by = $user->id_user;



            $this->_validate();
            if ($this->m_kegiatan->cek_nama_kegiatan($nama_kegiatan) == 'BELUM ADA KEGIATAN') {

                $data = array(
                    'nama_kegiatan'                => $nama_kegiatan,
                    'tgl_kegiatan'             => $tgl_kegiatan,
                    'pengkhotbah'                     => $pengkhotbah,
                    'ketua_panitia'                         => $ketuplak,
                    'jml_slot'                         => $kapasitas,
                    'durasi'               => $durasi,
                    'created_by'            => $created_by,
                    'deskripsi' => $deskripsi,
                );

                $KETERANGAN = "Simpan Kegiatan: "
                    . "; " . $nama_kegiatan
                    . "; " . $tgl_kegiatan
                    . "; " . $pengkhotbah
                    . "; " . $durasi
                    . "; " . $ketuplak
                    . "; " . $kapasitas
                    . "; " . $deskripsi
                    . "; " . $created_by;
                $this->user_log($KETERANGAN);
            } else {
                echo 'Nama Kegiatan sudah terekam/ada sebelumnya';
            }
        } else {
            $this->logout();
        }

        $this->db->insert('kegiatan', $data);
        echo json_encode(['status' => $status]);
    }

    public function update()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(1))) {
            $status                = true;
            $nama_kegiatan             = $this->input->post('nama_kegiatan_');
            $tgl_kegiatan        = $this->input->post('tgl_kegiatan_');
            $pengkhotbah                 = $this->input->post('pengkhotbah_');
            $durasi                 = $this->input->post('durasi_');
            $ketuplak                 = $this->input->post('ketuplak_');
            $kapasitas             = $this->input->post('kapasitas_');
            $deskripsi             = $this->input->post('deskripsi_');

            $id     = $this->input->post('id_kegiatan');

            $query['select'] = 'a.*';
            $query['table']  = 'kegiatan a';
            $query['where']  = 'a.id_kegiatan = ' . $id;

            $cek                                = $this->m_global->getRow($query);

            $this->_validates();

            $data = array(
                'nama_kegiatan'                => $nama_kegiatan,
                'tgl_kegiatan'             => $tgl_kegiatan,
                'pengkhotbah'                     => $pengkhotbah,
                'ketua_panitia'                         => $ketuplak,
                'jml_slot'                         => $kapasitas,
                'durasi'               => $durasi,
                'deskripsi' => $deskripsi,
            );

            $KETERANGAN = "Ubah Data Kegiatan: " . json_encode($cek) . " ---- " . $nama_kegiatan . ";" . $tgl_kegiatan . ";" . $pengkhotbah . ";" . $ketuplak . ";" . $kapasitas . ";" . $durasi . ";" . $deskripsi;

            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }

        $this->db->where('id_kegiatan', $id);
        $this->db->update('kegiatan', $data);
        echo json_encode(['status' => $status]);
    }

    private function _validate()
    {
        $data = [];

        $nama_kegiatan             = $this->input->post('nama_kegiatan');
        $tgl_kegiatan        = $this->input->post('tgl_kegiatan');
        $pengkhotbah                 = $this->input->post('pengkhotbah');
        $durasi                 = $this->input->post('durasi');
        $ketuplak                 = $this->input->post('ketuplak');
        $kapasitas             = $this->input->post('kapasitas');
        $deskripsi             = $this->input->post('deskripsi');


        $data['error_class']  = [];
        $data['error_string'] = [];
        $data['status']       = true;

        if ($nama_kegiatan == '') {
            $data['error_class']['nama_kegiatan']  = 'is-invalid';
            $data['error_string']['nama_kegiatan'] = 'Nama Kegiatan tidak boleh kosong';
            $data['status']                         = false;
        }

        if ($tgl_kegiatan == '') {
            $data['error_class']['tgl_kegiatan']  = 'is-invalid';
            $data['error_string']['tgl_kegiatan'] = 'Tanggal Kegiatan tidak boleh kosong';
            $data['status']                = false;
        }

        if ($pengkhotbah == '') {
            $data['error_class']['pengkhotbah']  = 'is-invalid';
            $data['error_string']['pengkhotbah'] = 'Nama Pengkhotbah tidak boleh kosong';
            $data['status']                = false;
        }

        if ($durasi == '') {
            $data['error_class']['durasi']  = 'is-invalid';
            $data['error_string']['durasi'] = 'Durasi tidak boleh kosong';
            $data['status']                         = false;
        }

        if ($ketuplak == '') {
            $data['error_class']['ketuplak']  = 'is-invalid';
            $data['error_string']['ketuplak'] = 'Ketua Panitia tidak boleh kosong';
            $data['status']                              = false;
        }

        if ($kapasitas == '') {
            $data['error_class']['kapasitas']  = 'is-invalid';
            $data['error_string']['kapasitas'] = 'Jumlah Slot tidak boleh kosong';
            $data['status']                          = false;
        }

        if ($deskripsi == '') {
            $data['error_class']['deskripsi']  = 'is-invalid';
            $data['error_string']['deskripsi'] = 'Deskripsi tidak boleh kosong';
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

        $nama_kegiatan             = $this->input->post('nama_kegiatan_');
        $tgl_kegiatan        = $this->input->post('tgl_kegiatan_');
        $pengkhotbah                 = $this->input->post('pengkhotbah_');
        $durasi                 = $this->input->post('durasi_');
        $ketuplak                 = $this->input->post('ketuplak_');
        $kapasitas             = $this->input->post('kapasitas_');
        $deskripsi             = $this->input->post('deskripsi_');


        $data['error_class']  = [];
        $data['error_string'] = [];
        $data['status']       = true;

        if ($nama_kegiatan == '') {
            $data['error_class']['nama_kegiatan_']  = 'is-invalid';
            $data['error_string']['nama_kegiatan_'] = 'Nama Kegiatan tidak boleh kosong';
            $data['status']                         = false;
        }

        if ($tgl_kegiatan == '') {
            $data['error_class']['tgl_kegiatan_']  = 'is-invalid';
            $data['error_string']['tgl_kegiatan_'] = 'Tanggal Kegiatan tidak boleh kosong';
            $data['status']                = false;
        }

        if ($pengkhotbah == '') {
            $data['error_class']['pengkhotbah_']  = 'is-invalid';
            $data['error_string']['pengkhotbah_'] = 'Nama Pengkhotbah tidak boleh kosong';
            $data['status']                = false;
        }

        if ($durasi == '') {
            $data['error_class']['durasi_']  = 'is-invalid';
            $data['error_string']['durasi_'] = 'Durasi tidak boleh kosong';
            $data['status']                         = false;
        }

        if ($ketuplak == '') {
            $data['error_class']['ketuplak_']  = 'is-invalid';
            $data['error_string']['ketuplak_'] = 'Ketua Panitia tidak boleh kosong';
            $data['status']                              = false;
        }

        if ($kapasitas == '') {
            $data['error_class']['kapasitas_']  = 'is-invalid';
            $data['error_string']['kapasitas_'] = 'Jumlah Slot tidak boleh kosong';
            $data['status']                          = false;
        }

        if ($deskripsi == '') {
            $data['error_class']['deskripsi_']  = 'is-invalid';
            $data['error_string']['deskripsi_'] = 'Deskripsi tidak boleh kosong';
            $data['status']                          = false;
        }

        if ($data['status'] == false) {
            echo json_encode($data);
            exit();
        }
    }

    public function hapus_kegiatan()
    {
        $post   = $this->input->post();
        $where  = array('id_kegiatan' => $post['id']);
        $status = true;

        $this->db->where($where);
        $this->db->delete('kegiatan');

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
        $this->data['id_kegiatan'] = $user->id_mhs;
        // $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
        $this->data['role_user'] = 'pengurus';
        $this->data['ip_address'] = $user->ip_address;
        $this->data['email'] = $user->email;
        date_default_timezone_set('Asia/Jakarta');
        $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');
        $this->data['isi'] = 'pengurus/list_kegiatan/detail';
        $this->data['id_group'] = $id_group->id_group;

        $query_foto_user = $this->M_foto->get_data_by_id_mhs($user->id_mhs);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        $this->data['id_kegiatan'] = $this->uri->segment(4);

        //Kueri data di tabel pengurus
        $query_detil_kegiatan = $this->m_kegiatan->get_detil($this->data['id_kegiatan']);

        $query_detil_kegiatan_result = $this->m_kegiatan->get_detil_result($this->data['id_kegiatan']);
        $this->data['query_detil_kegiatan_result'] = $query_detil_kegiatan_result;

        if ($query_detil_kegiatan->num_rows() == 0) {
            // alihkan mereka ke halaman list pengurus
            redirect('pengurus/list_kegiatan', 'refresh');
        }
        //Kueri data di tabel kegiatan file
        $query_file_id_kegiatan = $this->m_kegiatan->file_list_by_id_kegiatan($this->data['id_kegiatan']);

        //log
        $KETERANGAN = "Lihat Profil Kegiatan: " . json_encode($query_detil_kegiatan_result) . " ---- " . json_encode($query_file_id_kegiatan);
        $this->user_log($KETERANGAN);

        $hasil_1 = $query_detil_kegiatan->row();
        $this->data['id_kegiatan'] = $hasil_1->id_kegiatan;
        $sess_data['id_kegiatan'] = $this->data['id_kegiatan'];
        $this->session->set_userdata($sess_data);

        if ($query_file_id_kegiatan->num_rows() > 0) {

            $this->data['dokumen'] = $this->m_kegiatan->file_list_by_id_kegiatan_result($this->data['id_kegiatan']);

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
        if ($this->ion_auth->in_group(1)) {

            $this->load->view('template/wrapper', $this->data);
        } else {
            $this->logout();
        }
    }

    //Untuk proses upload file
    function proses_upload_file()
    {

        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login
            redirect('auth/login', 'refresh');
        }

        $id_pengirim = $this->session->userdata('id_kegiatan');

        //jika mereka sudah login dan sebagai kegiatan
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(1)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_" . $id_pengirim . '_';
            $config['upload_path']   = './assets/uploads/kegiatan/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;
            $config['file_ext_tolower'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('userfile')) {
                $nama = $this->upload->data('file_name');
                $EKSTENSI = pathinfo($nama, PATHINFO_EXTENSION);

                $file_upload = $this->upload->data();

                $JENIS_FILE = $this->input->post('JENIS_FILE');
                $KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

                $KETERANGAN = './assets/uploads/kegiatan/' . $nama;
                $this->db->insert('log_file', array('id_pengirim' => $id_pengirim, 'jenis_file' => $JENIS_FILE, 'ekstensi' => $EKSTENSI, 'dok_file' => $nama, 'tanggal_upload' => $WAKTU, 'keterangan_assets' => $KETERANGAN, 'keterangan_file' => $KETERANGAN_FILE, 'pengirim' => 'KEGIATAN'));
            } else {
                redirect($_SERVER['REQUEST_URI'], 'refresh');
            }
        } else {
            $this->logout();
        }
    }
    //Hapus file by button
    function hapus_file()
    {
        //jika mereka belum login
        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login
            redirect('auth/login', 'refresh');
        }

        //get data dari parameter URL
        $this->data['DOK_FILE'] = $this->uri->segment(4);


        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(1)) {
            //Query file BY DOK_FILE
            $query_dok_file = $this->m_kegiatan->file_list_by_dok_file($this->data['DOK_FILE']);

            if ($query_dok_file->num_rows() > 0) {
                $hasil = $query_dok_file->row();
                $DOK_FILE = $hasil->dok_file;
                if (file_exists($file = './assets/uploads/kegiatan/' . $DOK_FILE)) {
                    unlink($file);
                }

                $this->m_kegiatan->hapus_data_by_dok_file($DOK_FILE);

                $id_kegiatan = $this->session->userdata('id_kegiatan');
                redirect('/pengurus/list_kegiatan/detail/' . $id_kegiatan, 'refresh');
            } else {
                $id_kegiatan = $this->session->userdata('id_kegiatan');
                redirect('/pengurus/list_kegiatan/detail/' . $id_kegiatan, 'refresh');
            }
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }
}
