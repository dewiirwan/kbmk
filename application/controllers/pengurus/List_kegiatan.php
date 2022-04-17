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
            $bukti_swab                 = $this->input->post('bukti_swab');
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
                    'butuh_swab' => $bukti_swab
                );

                $KETERANGAN = "Simpan Kegiatan: "
                    . "; " . $nama_kegiatan
                    . "; " . $tgl_kegiatan
                    . "; " . $pengkhotbah
                    . "; " . $durasi
                    . "; " . $ketuplak
                    . "; " . $kapasitas
                    . "; " . $deskripsi
                    . "; " . $bukti_swab
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
            $bukti_swab                 = $this->input->post('bukti_swab_');
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
                'butuh_swab' => $bukti_swab
            );

            $KETERANGAN = "Ubah Data Kegiatan: " . json_encode($cek) . " ---- " . $nama_kegiatan . ";" . $tgl_kegiatan . ";" . $pengkhotbah . ";" . $ketuplak . ";" . $kapasitas . ";" . $durasi . ";" . $deskripsi . ";" . $bukti_swab;

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
        $bukti_swab                 = $this->input->post('bukti_swab');
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

        if ($bukti_swab == '') {
            $data['error_class']['bukti_swab']  = 'is-invalid';
            $data['error_string']['bukti_swab'] = 'Bukti Swab harus dipilih';
            $data['status']                              = false;
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
        $bukti_swab                 = $this->input->post('bukti_swab_');
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

        if ($bukti_swab == '') {
            $data['error_class']['bukti_swab_']  = 'is-invalid';
            $data['error_string']['bukti_swab_'] = 'Bukti Swab harus dipilih';
            $data['status']                              = false;
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
}
