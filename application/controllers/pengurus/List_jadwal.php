<?php defined('BASEPATH') or exit('No direct script access allowed');

class List_jadwal extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->load->model('m_jadwal');
        $this->load->model('m_global');
        $this->load->model('M_foto');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        // $this->load->model('foto_model');
        $this->data['title'] = 'KBMK | List Jadwal';
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

        $this->data['isi'] = 'pengurus/list_jadwal/index';
        $this->data['id_group'] = $id_group->id_group;
        $this->data['Kegiatan_list_jadwal'] = $this->m_jadwal->Kegiatan_list_jadwal();

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
        $this->m_jadwal->user_log_jadwal($user->id_mhs, $KETERANGAN, $WAKTU);
    }

    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses Jadwal";
        $WAKTU = date('Y-m-d H:i:s');
        $this->m_jadwal->user_log_jadwal($user->id_mhs, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function cek_edit()
    {
        $id     = $this->input->post('id');

        $query['select'] = 'a.*';
        $query['table']  = 'jadwal a';
        $query['where']  = 'a.id_jadwal = ' . $id;

        if (isset($id)) {
            $cek                                = $this->m_global->getRow($query);
            echo json_encode($cek);
        } else {
            $this->session->set_flashdata('pesan_gagal', 'Id tidak boleh kosong');
            redirect('pengurus/list_jadwal');
        }
    }

    public function proses()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(1))) {
            $user = $this->ion_auth->user()->row();
            $status                = true;
            $nama_kegiatan             = $this->input->post('nama_kegiatan');
            $kapasitas_kegiatan        = $this->input->post('kapasitas_kegiatan');

            $this->_validate();
            if ($this->m_jadwal->cek_nama_jadwal($nama_kegiatan) == 'BELUM ADA JADWAL') {

                for ($x = 1; $x <= $kapasitas_kegiatan; $x++) {

                    $hasil = $this->db->query("INSERT INTO jadwal (
                        id_kegiatan,
                        no_urut)
                    VALUES(
                        '$nama_kegiatan',
                        '$x')");
                }

                $KETERANGAN = "Simpan Jadwal: "
                    . "; " . $nama_kegiatan
                    . "; " . $kapasitas_kegiatan;
                $this->user_log($KETERANGAN);
            } else {
                echo 'Jadwal sudah terekam/ada sebelumnya';
            }
        } else {
            $this->logout();
        }

        echo json_encode(['status' => $status]);
    }

    private function _validate()
    {
        $data = [];

        $nama_kegiatan             = $this->input->post('nama_kegiatan');
        $kapasitas_kegiatan        = $this->input->post('kapasitas_kegiatan');


        $data['error_class']  = [];
        $data['error_string'] = [];
        $data['status']       = true;

        if ($nama_kegiatan == '') {
            $data['error_class']['nama_kegiatan']  = 'is-invalid';
            $data['error_string']['nama_kegiatan'] = 'Nama Kegiatan tidak boleh kosong';
            $data['status']                         = false;
        }

        if ($kapasitas_kegiatan == '') {
            $data['error_class']['kapasitas_kegiatan']  = 'is-invalid';
            $data['error_string']['kapasitas_kegiatan'] = 'Kapasitas Kegiatan tidak boleh kosong';
            $data['status']                = false;
        }

        if ($data['status'] == false) {
            echo json_encode($data);
            exit();
        }
    }

    public function hapus_jadwal()
    {
        $post   = $this->input->post();
        $where  = array('id_jadwal' => $post['id']);
        $status = true;

        $this->db->where($where);
        $this->db->delete('jadwal');

        echo json_encode(['status' => $status]);
    }

    public function reset_slot()
    {
        $post   = $this->input->post();
        $where  = array('id_kegiatan' => $post['id']);
        $status = true;

        $this->db->where($where);
        $this->db->delete('jadwal');

        echo json_encode(['status' => $status]);
    }

    public function verif_hadir()
    {
        $post   = $this->input->post();
        $where  = array('id_jadwal' => $post['id']);
        $status = true;

        $data = array(
            'jam_hadir' => date('Y-m-d H:i:s')
        );

        $this->db->where($where);
        $this->db->update('jadwal', $data);

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
        $this->data['isi'] = 'pengurus/list_jadwal/detail';
        $this->data['id_group'] = $id_group->id_group;

        $query_foto_user = $this->M_foto->get_data_by_id_mhs($user->id_mhs);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        $this->data['id_kegiatan'] = $this->uri->segment(4);

        //Kueri data di tabel pengurus
        $query_detil_jadwal = $this->m_jadwal->get_detil($this->data['id_kegiatan']);

        $query_detil_jadwal_result = $this->m_jadwal->get_detil_result($this->data['id_kegiatan']);
        $this->data['query_detil_jadwal_result'] = $query_detil_jadwal_result;

        if ($query_detil_jadwal->num_rows() == 0) {
            // alihkan mereka ke halaman list pengurus
            redirect('pengurus/list_jadwal', 'refresh');
        }

        //log
        $KETERANGAN = "Lihat Jadwal Detil: " . json_encode($query_detil_jadwal_result);
        $this->user_log($KETERANGAN);

        $hasil_1 = $query_detil_jadwal->row();
        $this->data['id_kegiatan'] = $hasil_1->id_kegiatan;
        $sess_data['id_kegiatan'] = $this->data['id_kegiatan'];
        $this->session->set_userdata($sess_data);

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->in_group(1)) {

            $this->load->view('template/wrapper', $this->data);
        } else {
            $this->logout();
        }
    }
}
