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
        // $this->load->model('Manajemen_user_model');
        // $this->load->model('Pegawai_model');

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
            $this->data['foto_user'] = "assets/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        if ($this->ion_auth->logged_in()) {
            //fungsi ini untuk mengirim data ke dropdown

            if ($this->ion_auth->in_group(2)) {
                $sess_data['id_mhs'] = $this->data['id_mhs'];

                $this->load->view('template_pengurus/wrapper', $this->data);
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
        $this->data['isi'] = 'anggota/list_anggota/detail';
        $this->data['id_group'] = $id_group->id_group;

        $query_foto_user = $this->M_foto->get_data_by_id_mhs($user->id_mhs);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
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

        $query_file_swab_id_mhs = $this->M_anggota->file_swab_list_by_id_mhs($this->data['id_mhs']);

        //log
        $KETERANGAN = "Lihat Profil Anggota: " . json_encode($query_detil_anggota_result) . " ---- " . json_encode($query_file_id_mhs) . " ---- " . json_encode($query_file_swab_id_mhs);
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

        if ($query_file_swab_id_mhs->num_rows() > 0) {

            $this->data['dokumen_swab'] = $this->M_anggota->file_swab_list_by_id_mhs_result($sess_data['id_mhs']);

            $hasil = $query_file_swab_id_mhs->row();
            $FILE_SWAB = $hasil->file_swab;
            $TANGGAL_UPLOAD = $hasil->tanggal_upload;

            if (file_exists($file = './assets/uploads/anggota/' . $FILE_SWAB)) {
                $this->data['FILE_SWAB'] = $FILE_SWAB;
                $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                $this->data['FILE_SWAB'] = "ADA";
            }
        } else {
            $this->data['FILE_SWAB'] = "TIDAK ADA";
        }

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->in_group(2)) {
            $sess_data['id_mhs'] = $this->data['id_mhs'];

            $this->load->view('template_pengurus/wrapper', $this->data);
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

    //Untuk proses upload file
    function proses_upload_file_swab()
    {

        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login
            redirect('auth/login', 'refresh');
        }

        $id_mhs = $this->session->userdata('id_mhs');

        //jika mereka sudah login dan sebagai umat
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(1)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_swab_" . $id_mhs . '_';
            $config['upload_path']   = './assets/upload_umat_file/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;
            $config['file_ext_tolower'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_file');
                $nama = $this->upload->data('file_name');
                $EKSTENSI = pathinfo($nama, PATHINFO_EXTENSION);

                $file_upload = $this->upload->data();

                $TANGGAL_SWAB = $this->input->post('TANGGAL_SWAB');
                $KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

                $KETERANGAN = './assets/upload_umat_file/' . $nama;
                $this->db->insert('bukti_swab', array('id_mhs' => $id_mhs, 'EKSTENSI' => $EKSTENSI, 'TANGGAL_SWAB' => $TANGGAL_SWAB, 'TANGGAL_UPLOAD' => $WAKTU, 'FILE_SWAB' => $nama, 'TOKEN' => $token,  'KETERANGAN' => $KETERANGAN, 'KETERANGAN_FILE' => $KETERANGAN_FILE));
            } else {
                redirect($_SERVER['REQUEST_URI'], 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_swab_" . $id_mhs . '_';
            $config['upload_path']   = './assets/upload_umat_file/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;
            $config['file_ext_tolower'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_file');
                $nama = $this->upload->data('file_name');
                $EKSTENSI = pathinfo($nama, PATHINFO_EXTENSION);

                $file_upload = $this->upload->data();

                $TANGGAL_SWAB = $this->input->post('TANGGAL_SWAB');
                $KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

                $KETERANGAN = './assets/upload_umat_file/' . $nama;
                $this->db->insert('bukti_swab', array('id_mhs' => $id_mhs, 'EKSTENSI' => $EKSTENSI, 'TANGGAL_SWAB' => $TANGGAL_SWAB, 'TANGGAL_UPLOAD' => $WAKTU, 'FILE_SWAB' => $nama, 'TOKEN' => $token,  'KETERANGAN' => $KETERANGAN, 'KETERANGAN_FILE' => $KETERANGAN_FILE));
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

    //Hapus file by button
    function hapus_file_swab()
    {
        //jika mereka belum login
        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login
            redirect('auth/login', 'refresh');
        }

        //get data dari parameter URL
        $this->data['FILE_SWAB'] = $this->uri->segment(3);

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(1)) {
            //Query file BY DOK_FILE
            $query_file_swab = $this->M_anggota->file_list_by_file_swab($this->data['FILE_SWAB']);

            if ($query_file_swab->num_rows() > 0) {
                $hasil = $query_file_swab->row();
                $FILE_SWAB = $hasil->FILE_SWAB;
                if (file_exists($file = './assets/upload_umat_file/' . $FILE_SWAB)) {
                    unlink($file);
                }

                $this->Umat_file_model->hapus_data_by_file_swab($FILE_SWAB);

                $id_mhs = $this->session->userdata('id_mhs');
                redirect('/Umat_detil/index/' . $id_mhs, 'refresh');
            } else {
                $id_mhs = $this->session->userdata('id_mhs');
                redirect('/Umat_detil/index/' . $id_mhs, 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
            //Query file BY DOK_FILE
            $query_file_swab = $this->Umat_file_model->file_list_by_file_swab($this->data['FILE_SWAB']);

            if ($query_file_swab->num_rows() > 0) {
                $hasil = $query_file_swab->row();
                $FILE_SWAB = $hasil->FILE_SWAB;
                if (file_exists($file = './assets/upload_umat_file/' . $FILE_SWAB)) {
                    unlink($file);
                }

                $this->Umat_file_model->hapus_data_by_file_swab($FILE_SWAB);

                $id_mhs = $this->session->userdata('id_mhs');
                redirect('/Umat_detil/index/' . $id_mhs, 'refresh');
            } else {
                $id_mhs = $this->session->userdata('id_mhs');
                redirect('/Umat_detil/index/' . $id_mhs, 'refresh');
            }
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function update_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(1)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('npm_2', 'NPM', 'trim|required|max_length[16]|min_length[16]|numeric');
            $this->form_validation->set_rules('nama_2', 'Nama Anggota', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('tempat_tgl_lahir_2', 'Tempat Tanggal Lahir', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('alamat_2', 'Alamat', 'trim|required');
            $this->form_validation->set_rules('email_2', 'Email', 'trim|required|max_length[100]|valid_email');
            $this->form_validation->set_rules('no_hp_2', 'No Handphone', 'trim|required|max_length[20]|numeric');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_mhs_2 = $this->input->post('id_mhs_2');
                $npm_2 = $this->input->post('npm_2');
                $nama_2 = $this->input->post('nama_2');
                $tempat_tgl_lahir_2 = $this->input->post('tempat_tgl_lahir_2');
                $alamat_2 = $this->input->post('alamat_2');
                $email_2 = $this->input->post('email_2');
                $no_hp_2 = $this->input->post('no_hp_2');

                //cek apakah input sama dengan eksisting
                $data = $this->M_anggota->get_data($id_mhs_2);

                if ($data['nama'] == $nama_2 || ($this->M_anggota->cek_nama_anggota($nama_2) == 'BELUM ADA NAMA ANGGOTA')) {
                    $data_awal = $this->M_anggota->get_data($id_mhs_2);

                    //log
                    $KETERANGAN = "Ubah Data Anggota: " . json_encode($data_awal) . " ---- " . $npm_2 . ";" . $nama_2 . ";" . $tempat_tgl_lahir_2 . ";" . $alamat_2 . ";" . $email_2 . ";" . $no_hp_2;
                    $this->user_log($KETERANGAN);

                    $data = $this->M_anggota->update_data($id_mhs_2, $npm_2, $nama_2, $tempat_tgl_lahir_2, $alamat_2, $email_2, $no_hp_2);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Anggota sudah ada sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NIK_2', 'NIK', 'trim|required|max_length[16]|min_length[16]|numeric');
            $this->form_validation->set_rules('NAMA_2', 'Nama Umat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TEMPAT_TANGGAL_LAHIR_2', 'Tempat Tanggal Lahir', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALAMAT_2', 'Alamat', 'trim|required');
            $this->form_validation->set_rules('EMAIL_2', 'Email', 'trim|required|max_length[100]|valid_email');
            $this->form_validation->set_rules('NO_HP_2', 'No Handphone', 'trim|required|max_length[20]|numeric');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_mhs_2 = $this->input->post('id_mhs_2');
                $NIK_2 = $this->input->post('NIK_2');
                $NAMA_2 = $this->input->post('NAMA_2');
                $TEMPAT_TANGGAL_LAHIR_2 = $this->input->post('TEMPAT_TANGGAL_LAHIR_2');
                $ALAMAT_2 = $this->input->post('ALAMAT_2');
                $EMAIL_2 = $this->input->post('EMAIL_2');
                $NO_HP_2 = $this->input->post('NO_HP_2');

                //cek apakah input sama dengan eksisting
                $data = $this->M_anggota->get_data($id_mhs_2);

                if ($data['NAMA'] == $NAMA_2 || ($this->M_anggota->cek_nama_umat($NAMA_2) == 'BELUM ADA NAMA UMAT')) {
                    $data_awal = $this->M_anggota->get_data($id_mhs_2);

                    //log
                    $KETERANGAN = "Ubah Data Umat: " . json_encode($data_awal) . " ---- " . $NIK_2 . ";" . $NAMA_2 . ";" . $TEMPAT_TANGGAL_LAHIR_2 . ";" . $ALAMAT_2 . ";" . $EMAIL_2 . ";" . $NO_HP_2;
                    $this->user_log($KETERANGAN);

                    $data = $this->M_anggota->update_data($id_mhs_2, $NIK_2, $NAMA_2, $TEMPAT_TANGGAL_LAHIR_2, $ALAMAT_2, $EMAIL_2, $NO_HP_2);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama umat sudah ada sebelumnya');
                }
            }
        } else {
            $this->logout();
        }
    }

    function hapus_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(1)) {
            $user = $this->ion_auth->user()->row();
            $ID_UMAT = $this->input->post('kode');
            $data = $this->M_anggota->get_data($ID_UMAT);

            //log
            $KETERANGAN = "Hapus Data Umat: " . json_encode($data);
            $this->user_log($KETERANGAN);

            $data = $this->M_anggota->hapus_data($ID_UMAT);
            echo json_encode($data);
        } else {
            $this->logout();
        }
    }
}
