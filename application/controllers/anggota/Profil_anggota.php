<?php defined('BASEPATH') or exit('No direct script access allowed');

class Profil_anggota extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->load->library('session');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->data['title'] = 'KBMK | List Anggota';

        $this->load->model('M_anggota');
        $this->load->model('M_foto');

        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Log the user out
     */
    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses Anggota";
        $WAKTU = date('Y-m-d H:i:s');
        $this->M_anggota->user_log_anggota($user->id_mhs, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->M_anggota->user_log_anggota($user->id_mhs, $KETERANGAN, $WAKTU);
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

        //get data tabel users untuk ditampilkan
        $user = $this->ion_auth->user()->row();
        $id_group = $this->db->query('SELECT id_group FROM users_groups WHERE id_user = ' . $user->id_user . '')->row();

        $this->data['USER_ID'] = $user->id_user;
        $this->data['id_mhs'] = $user->id_mhs;
        $this->data['role_user'] = 'anggota';
        $this->data['ip_address'] = $user->ip_address;
        $this->data['email'] = $user->email;
        $this->data['USER_ID'] = $user->id_user;
        date_default_timezone_set('Asia/Jakarta');
        $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

        $this->data['isi'] = 'anggota/list_anggota/index';
        $this->data['id_group'] = $id_group->id_group;


        $query_foto_user = $this->M_foto->get_data_by_id_mhs($user->id_mhs);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = base_url() . "assets/template/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['keterangan_2'];
        }

        if ($this->ion_auth->logged_in()) {
            //fungsi ini untuk mengirim data ke dropdown

            if ($this->ion_auth->in_group(2)) {
                $sess_data['id_mhs'] = $this->data['id_mhs'];

                $this->load->view('template/wrapper', $this->data);
            }
        } else {
            $this->logout();
        }
    }

    public function cek_edit()
    {
        $id     = $this->input->post('id');

        $query['select'] = 'a.*';
        $query['table']  = 'mahasiswa a';
        $query['where']  = 'a.id_mhs = ' . $id;

        if (isset($id)) {
            $cek                                = $this->m_global->getRow($query);
            echo json_encode($cek);
        } else {
            $this->session->set_flashdata('pesan_gagal', 'Id tidak boleh kosong');
            redirect('anggota/profil_anggota');
        }
    }


    public function edit()
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
        date_default_timezone_set('Asia/Jakarta');
        $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');
        $this->data['isi'] = 'anggota/list_anggota/edit';
        $this->data['id_group'] = $id_group->id_group;

        $query_foto_user = $this->M_foto->get_data_by_id_mhs($user->id_mhs);

        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = base_url() . "assets/template/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['keterangan_2'];
        }

        $this->data['id_mhs'] = $this->uri->segment(4);

        //Kueri data di tabel anggota
        $query_detil_anggota = $this->M_anggota->get_detil($this->data['id_mhs']);

        $query_detil_anggota_result = $this->M_anggota->get_detil_result($this->data['id_mhs']);
        $this->data['query_detil_anggota_result'] = $query_detil_anggota_result;

        if ($query_detil_anggota->num_rows() == 0) {
            // alihkan mereka ke halaman list anggota
            redirect('anggota/profil_anggota', 'refresh');
        }
        //Kueri data di tabel anggota file
        $query_file_id_mhs = $this->M_anggota->file_list_by_id_mhs($this->data['id_mhs']);

        //log
        $KETERANGAN = "Edit Profil Anggota: " . json_encode($query_detil_anggota_result) . " ---- " . json_encode($query_file_id_mhs);
        $this->user_log($KETERANGAN);

        $hasil_1 = $query_detil_anggota->row();
        $this->data['id_mhs'] = $hasil_1->id_mhs;
        $sess_data['id_mhs'] = $this->data['id_mhs'];
        $this->session->set_userdata($sess_data);

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->in_group(2)) {
            $sess_data['id_mhs'] = $this->data['id_mhs'];

            $this->load->view('template/wrapper', $this->data);
        } else {
            $this->logout();
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
        date_default_timezone_set('Asia/Jakarta');
        $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');
        $this->data['isi'] = 'anggota/list_anggota/detail';
        $this->data['id_group'] = $id_group->id_group;

        $query_foto_user = $this->M_foto->get_data_by_id_mhs($user->id_mhs);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = base_url() . "assets/template/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['keterangan_2'];
        }

        $this->data['id_mhs'] = $this->uri->segment(4);

        //Kueri data di tabel anggota
        $query_detil_anggota = $this->M_anggota->get_detil($this->data['id_mhs']);

        $query_detil_anggota_result = $this->M_anggota->get_detil_result($this->data['id_mhs']);
        $this->data['query_detil_anggota_result'] = $query_detil_anggota_result;

        if ($query_detil_anggota->num_rows() == 0) {
            // alihkan mereka ke halaman list anggota
            redirect('anggota/profil_anggota', 'refresh');
        }
        //Kueri data di tabel anggota file
        $query_file_id_mhs = $this->M_anggota->file_list_by_id_mhs($this->data['id_mhs']);

        //log
        $KETERANGAN = "Lihat Profil Anggota: " . json_encode($query_detil_anggota_result) . " ---- " . json_encode($query_file_id_mhs);
        $this->user_log($KETERANGAN);

        $hasil_1 = $query_detil_anggota->row();
        $this->data['id_mhs'] = $hasil_1->id_mhs;
        $sess_data['id_mhs'] = $this->data['id_mhs'];
        $this->session->set_userdata($sess_data);

        if ($query_file_id_mhs->num_rows() > 0) {

            $this->data['dokumen'] = $this->M_anggota->file_list_by_id_mhs_result($sess_data['id_mhs']);

            $hasil = $query_file_id_mhs->row();
            $DOK_FILE = $hasil->dok_file;
            $TANGGAL_UPLOAD = $hasil->tanggal_upload;

            if (file_exists($file = './assets/uploads/anggota/' . $DOK_FILE)) {
                $this->data['DOK_FILE'] = $DOK_FILE;
                $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                $this->data['FILE'] = "ADA";
            }
        } else {
            $this->data['FILE'] = "TIDAK ADA";
        }

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->in_group(2)) {
            $sess_data['id_mhs'] = $this->data['id_mhs'];

            $this->load->view('template/wrapper', $this->data);
        } else {
            $this->logout();
        }
    }

    function data_anggota()
    {

        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(1))) {

            $data = $this->M_anggota->list_anggota();
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data Anggota: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {

            $id_mhs = $this->input->get('id_mhs');

            $data = $this->M_anggota->anggota_data($id_mhs);
            echo json_encode($data);

            $KETERANGAN = "Melihat Data Anggota: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(1))) {
            $id_mhs = $this->input->get('id');

            $data = $this->M_anggota->get_data($id_mhs);
            echo json_encode($data);

            $KETERANGAN = "Get Data Anggota" . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {
            $id_mhs = $this->input->get('id');

            $data = $this->M_anggota->get_data($id_mhs);
            echo json_encode($data);

            $KETERANGAN = "Get Data Anggota" . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function proses_upload_file()
    {

        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login
            redirect('auth/login', 'refresh');
        }

        $id_mhs = $this->session->userdata('id_mhs');

        //jika mereka sudah login dan sebagai umat
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(1)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_" . $id_mhs . '_';
            $config['upload_path']   = './assets/uploads/anggota/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;
            $config['file_ext_tolower'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_file');
                $nama = $this->upload->data('file_name');
                $EKSTENSI = pathinfo($nama, PATHINFO_EXTENSION);

                $file_upload = $this->upload->data();

                $JENIS_FILE = $this->input->post('JENIS_FILE');
                $KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

                $KETERANGAN = './assets/uploads/anggota/' . $nama;
                $this->db->insert('log_file', array('id_pengirim' => $id_mhs, 'jenis_file' => $JENIS_FILE, 'ekstensi' => $EKSTENSI, 'dok_file' => $nama, 'tanggal_upload' => $WAKTU, 'keterangan_assets' => $KETERANGAN, 'keterangan_file' => $KETERANGAN_FILE, 'pengirim' => 'ANGGOTA'));
                echo ($JENIS_FILE);
            } else {
                redirect($_SERVER['REQUEST_URI'], 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_" . $id_mhs . '_';
            $config['upload_path']   = './assets/uploads/anggota/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;
            $config['file_ext_tolower'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_file');
                $nama = $this->upload->data('file_name');
                $EKSTENSI = pathinfo($nama, PATHINFO_EXTENSION);

                $file_upload = $this->upload->data();

                $JENIS_FILE = $this->input->post('JENIS_FILE');
                $KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

                $KETERANGAN = './assets/uploads/anggota/' . $nama;
                $this->db->insert('log_file', array('id_pengirim' => $id_mhs, 'jenis_file' => $JENIS_FILE, 'ekstensi' => $EKSTENSI, 'dok_file' => $nama, 'tanggal_upload' => $WAKTU, 'keterangan_assets' => $KETERANGAN, 'keterangan_file' => $KETERANGAN_FILE, 'pengirim' => 'ANGGOTA'));
                echo ($JENIS_FILE);
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
            $query_dok_file = $this->M_anggota->file_list_by_dok_file($this->data['DOK_FILE']);

            if ($query_dok_file->num_rows() > 0) {
                $hasil = $query_dok_file->row();
                $DOK_FILE = $hasil->dok_file;
                if (file_exists($file = './assets/uploads/anggota/' . $DOK_FILE)) {
                    unlink($file);
                }

                $this->M_anggota->hapus_data_by_dok_file($DOK_FILE);

                $id_mhs = $this->session->userdata('id_mhs');
                redirect('/anggota/profil_anggota/detail/' . $id_mhs, 'refresh');
            } else {
                $id_mhs = $this->session->userdata('id_mhs');
                redirect('/anggota/profil_anggota/detail/' . $id_mhs, 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
            //Query file BY DOK_FILE
            $query_dok_file = $this->M_anggota->file_list_by_dok_file($this->data['DOK_FILE']);

            if ($query_dok_file->num_rows() > 0) {
                $hasil = $query_dok_file->row();
                $DOK_FILE = $hasil->dok_file;
                if (file_exists($file = './assets/uploads/anggota/' . $DOK_FILE)) {
                    unlink($file);
                }

                $this->M_anggota->hapus_data_by_dok_file($DOK_FILE);

                $id_mhs = $this->session->userdata('id_mhs');
                redirect('/anggota/profil_anggota/detail/' . $id_mhs, 'refresh');
            } else {
                $id_mhs = $this->session->userdata('id_mhs');
                redirect('/anggota/profil_anggota/detail/' . $id_mhs, 'refresh');
            }
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function update()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
            $user = $this->ion_auth->user()->row();

            $status                = true;
            $nama_lengkap             = $this->input->post('nama_lengkap_');
            $npm        = $this->input->post('npm_');
            $ttl                 = $this->input->post('ttl_');
            $no_hp                 = $this->input->post('no_hp_');
            $alamat                 = $this->input->post('alamat_');
            $email             = $this->input->post('email_');

            $id     = $this->input->post('id_mhs');

            $query['select'] = 'a.*';
            $query['table']  = 'mahasiswa a';
            $query['where']  = 'a.id_mhs = ' . $id;

            $cek  = $this->m_global->getRow($query);

            if ($_FILES['input-b1']['name']) {
                $uploadPath = './assets/uploads/foto/';

                $_FILES['upload_File']['name']     = $_FILES['input-b1']['name'];
                $_FILES['upload_File']['type']     = $_FILES['input-b1']['type'];
                $_FILES['upload_File']['tmp_name'] = $_FILES['input-b1']['tmp_name'];
                $_FILES['upload_File']['error']    = $_FILES['input-b1']['error'];
                $_FILES['upload_File']['size']     = $_FILES['input-b1']['size'];

                $config['upload_path']             = $uploadPath;
                $config['file_name']               = "foto_profil" . "_" . $_POST['npm_'] . "_" . date("Ymd") . "_" . time();
                $config['allowed_types']           = 'jpg|jpeg';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (file_exists($files =  $cek->foto)) {
                    unlink($files);
                    // var_dump($files);

                    if ($this->upload->do_upload('upload_File')) {

                        $fileData = $this->upload->data();
                        $nama = 'assets/uploads/foto/' . $fileData['file_name'];
                    } else {
                        $status = 'input-b1' . $this->upload->display_errors();
                        $this->ajax(array('status' => false, 'message' => $status));
                        die;
                    }

                    // $foto = array(
                    //     'nama_foto' => $fileData['file_name'],
                    //     'tgl_upload' => date('Y-m-d'),
                    //     'keterangan' => 'FOTO PROFIL ' . $nama_lengkap,
                    //     'keterangan_2' => $nama
                    // );

                    // $this->db->where('id_mhs', $id);
                    // $this->db->update('foto', $foto);
                } else {
                    if ($this->upload->do_upload('upload_File')) {

                        $fileData = $this->upload->data();
                        $nama = 'assets/uploads/foto/' . $fileData['file_name'];
                    } else {
                        $status = 'input-b1' . $this->upload->display_errors();
                        $this->ajax(array('status' => false, 'message' => $status));
                        die;
                    }

                    // $foto = array(
                    //     'id_mhs' => $id,
                    //     'nama_foto' => $fileData['file_name'],
                    //     'tgl_upload' => date('Y-m-d'),
                    //     'keterangan' => 'FOTO PROFIL ' . $nama_lengkap,
                    //     'keterangan_2' => $nama
                    // );

                    // $this->db->insert('foto', $foto);
                }
            } else {
                $nama = $cek->foto;
            }

            $this->_validate();

            $data = array(
                'nama'                => $nama_lengkap,
                'npm'             => $npm,
                'tempat_tgl_lahir'                     => $ttl,
                'alamat'                         => $alamat,
                'email'                         => $email,
                'no_hp'               => $no_hp,
                'foto'             => $nama
            );

            $KETERANGAN = "Ubah Data Anggota: " . json_encode($cek) . " ---- " . $nama_lengkap . ";" . $npm . ";" . $ttl . ";" . $no_hp . ";" . $alamat . ";" . $email;

            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }

        $this->db->where('id_mhs', $id);
        $this->db->update('mahasiswa', $data);
        echo json_encode(['status' => $status]);
    }

    function hapus_anggota()
    {
        $post   = $this->input->post();
        $where  = array('id_mhs' => $post['id']);
        $status = true;

        $this->db->where($where);
        $this->db->delete('mahasiswa');

        echo json_encode(['status' => $status]);
    }

    private function _validate()
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
}
