<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

        $this->data['title'] = 'KBMK | Form Pengajuan';
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

        $this->data['isi'] = 'anggota/form_pengajuan/index';
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

            $nama_lengkap             = $this->input->post('nama_lengkap');
            $kelas             = $this->input->post('kelas');
            $npm        = $this->input->post('npm');
            $no_telp                 = $this->input->post('no_telp');
            $fakultas                 = $this->input->post('fakultas');
            $jurusan                 = $this->input->post('jurusan');
            $semester             = $this->input->post('semester');
            $tahun_angkatan                 = $this->input->post('tahun_angkatan');
            $region             = $this->input->post('region');


            $this->_validate();

            $this->sertifikat($nama_lengkap, $kelas, $npm, $no_telp, $fakultas, $jurusan, $semester, $tahun_angkatan, $region);
            $pdf_name = 'Pengajuan_Keikutsertaan_Pembelajaraan_Agama_Khonghucu_' . @$npm . '_' . time() . '.pdf';
            $data = array(
                'id_user'   => $user->id_user,
                'id_mhs'    => $user->id_mhs,
                'nama'                => $nama_lengkap,
                'kelas'             => $kelas,
                'npm'                     => $npm,
                'no_telp'                         => $no_telp,
                'fakultas'                         => $fakultas,
                'jurusan'               => $jurusan,
                'semester'            => $semester,
                'tahun_angkatan' => $tahun_angkatan,
                'region_kampus' => $region,
                'tujuan'        => 'Pengajuan Keikutsertaan Pembelajaran Agama Khonghucu',
                'file_pdf' => $pdf_name
            );

            $KETERANGAN = "Simpan Pengajuan: "
                . "; " . $nama_lengkap
                . "; " . $kelas
                . "; " . $npm
                . "; " . $no_telp
                . "; " . $fakultas
                . "; " . $jurusan
                . "; " . $semester
                . "; " . $tahun_angkatan
                . "; " . $region;
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }

        $insert = $this->db->insert('form_pengajuan', $data);
        echo json_encode(['status' => $status]);
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

        $this->data['id_group'] = $id_group->id_group;
        $this->data['id_form'] = $this->uri->segment(4);

        $query = $this->db->query("SELECT * FROM form_pengajuan WHERE id_form = '" . $this->data['id_form'] . "'");
        $row = $query->row();

        $this->data['isi'] = 'anggota/form_pengajuan/detail';
        $this->data['file_pdf'] = $row->file_pdf;

        //log
        $KETERANGAN = "Lihat Form Pengajuan: " . json_encode($query->result());
        $this->user_log($KETERANGAN);

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->in_group(2)) {
            // $sess_data['id_kegiatan'] = $this->data['id_kegiatan'];

            $this->load->view('template/wrapper', $this->data);
        } else {
            $this->logout();
        }
    }

    public function hapus()
    {
        $post   = $this->input->post();
        $where  = array('id_form' => $post['id']);
        $status = true;

        $query = $this->db->query("SELECT file_pdf FROM form_pengajuan WHERE id_form = '" . $post['id'] . "'");
        $row = $query->row();

        $hasil = $row->file_pdf;

        if ($hasil != null) {
            $this->db->where($where);
            $this->db->delete('form_pengajuan');
            $status = true;
        } else {
            $status = false;
        }


        echo json_encode(['status' => $status]);
    }

    private function _validate()
    {
        $data = [];

        $nama_lengkap             = $this->input->post('nama_lengkap');
        $kelas             = $this->input->post('kelas');
        $npm        = $this->input->post('npm');
        $no_telp                 = $this->input->post('no_telp');
        $fakultas                 = $this->input->post('fakultas');
        $jurusan                 = $this->input->post('jurusan');
        $semester             = $this->input->post('semester');
        $tahun_angkatan                 = $this->input->post('tahun_angkatan');
        $region             = $this->input->post('region');


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

        if ($fakultas == '') {
            $data['error_class']['fakultas']  = 'is-invalid';
            $data['error_string']['fakultas'] = 'Fakultas tidak boleh kosong';
            $data['status']                              = false;
        }

        if ($jurusan == '') {
            $data['error_class']['jurusan']  = 'is-invalid';
            $data['error_string']['jurusan'] = 'Jurusan tidak boleh kosong';
            $data['status']                          = false;
        }

        if ($semester == '') {
            $data['error_class']['semester']  = 'is-invalid';
            $data['error_string']['semester'] = 'Semester tidak boleh kosong';
            $data['status']                              = false;
        }

        if ($tahun_angkatan == '') {
            $data['error_class']['tahun_angkatan']  = 'is-invalid';
            $data['error_string']['tahun_angkatan'] = 'Tahun Angkatan tidak boleh kosong';
            $data['status']                          = false;
        }

        if ($region == '') {
            $data['error_class']['region']  = 'is-invalid';
            $data['error_string']['region'] = 'Region harus dipilih';
            $data['status']                          = false;
        }

        if ($data['status'] == false) {
            echo json_encode($data);
            exit();
        }
    }

    public function sertifikat($nama_lengkap, $kelas, $npm, $no_telp, $fakultas, $jurusan, $semester, $tahun_angkatan, $region)
    {
        require FCPATH . 'vendor/tcpdf/tcpdf.php';
        $pdf = new \TCPDF();


        $pdf->setPrintHeader(false);
        $pdf->SetAutoPageBreak(false, 0);

        // set image 1
        $pdf->AddPage('P');


        // -- set new background ---

        // get the current page break margin
        $bMargin = $pdf->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $pdf->getAutoPageBreak();
        // disable auto-page-break
        $pdf->SetAutoPageBreak(false, 0);
        // set bacground image
        // restore auto-page-break status
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $pdf->setPageMark();

        $html = '<p style="font-size:12;">PENGAJUAN KEIKUTSERTAAN PEMBELAJARAN</p><br>';
        $pdf->writeHTMLCell(0, 0, 10, 25, $html, 0, 0, 0, true, 'C');
        $html = '<p style="font-size:12;">AGAMA KHONGHUCU</p><br>';
        $pdf->writeHTMLCell(0, 0, 10, 32, $html, 0, 0, 0, true, 'C');
        $htmls = '<p style="font-size:12;">KBMK UNIVERSITAS GUNADARMA</p><br>';
        $pdf->writeHTMLCell(0, 0, 10, 39, $htmls, 0, 0, 0, true, 'C');

        $html = '<p style="font-size:12;">Kepada Yth.</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 60, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">Ketua Pengurus</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 65, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">Keluarga Besar Mahasiswa Khonghucu</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 70, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">Universitas Gunadarma</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 75, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">Dengan hormat, saya yang bertanda tangan dibawah ini : </p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 85, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">Nama</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 95, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">Kelas</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 102, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">NPM</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 109, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">No. Telp (WA)</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 116, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">Fakultas / Jurusan</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 123, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">Semester</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 130, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">Tahun Angkatan</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 137, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">Region Kampus</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 144, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">Dengan ini mengajukan diri untuk dapat mengikuti pembelajaran Agama Khonghucu pada</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 159, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">semester terkait dengan tujuan agar dapat memenuhi kewajiban nilai pendidikan agama</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 164, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">berdasarkan <b>KRS</b> yang telah diambil. Demikian surat pengajuan ini dibuat, atas perhatian dan</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 169, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">bantuannya saya ucapkan terimakasih.</p><br>';
        $pdf->writeHTMLCell(0, 0, 15, 174, $html, 0, 0, 0, true, 'L');


        $html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . $nama_lengkap . '</p><br>';
        $pdf->writeHTMLCell(0, 0, 55, 95, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . $kelas . '</p><br>';
        $pdf->writeHTMLCell(0, 0, 55, 102, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . $npm . '</p><br>';
        $pdf->writeHTMLCell(0, 0, 55, 109, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . $no_telp . '</p><br>';
        $pdf->writeHTMLCell(0, 0, 55, 116, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . $fakultas . ' / ' . $jurusan . '</p><br>';
        $pdf->writeHTMLCell(0, 0, 55, 123, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . $semester . '</p><br>';
        $pdf->writeHTMLCell(0, 0, 55, 130, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . $tahun_angkatan . '</p><br>';
        $pdf->writeHTMLCell(0, 0, 55, 137, $html, 0, 0, 0, true, 'L');

        $html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . $region . '</p><br>';
        $pdf->writeHTMLCell(0, 0, 55, 144, $html, 0, 0, 0, true, 'L');

        // $html = '<p style="font-size:12;">..............., ...... ...... ......</p><br>';
        // $pdf->writeHTMLCell(0, 0, 150, 220, $html, 0, 0, 0, true, 'L');

        // $html = '<p style="font-size:12;">Mahasiswa / Mahasiswi</p><br>';
        // $pdf->writeHTMLCell(0, 0, 150, 230, $html, 0, 0, 0, true, 'L');

        // $html = '<p style="font-size:12;">___________________</p><br>';
        // $pdf->writeHTMLCell(0, 0, 150, 260, $html, 0, 0, 0, true, 'L');

        // $table_footer = '<p style="font-size:10pt;"><b>Catatan</b><br>Sesuai dengan ketentuan perundang-undangan yang berlaku, sertifikat ini telah ditandatangani secara elektronik sehingga tidak diperlukan tanda tangan dan setempel basah</p>';
        // $pdf->writeHTMLCell(200, 0, 5, 250, $table_footer, 0, 0, 0, true, 'L');


        $pdf_name = 'Pengajuan_Keikutsertaan_Pembelajaraan_Agama_Khonghucu_' . $npm . '_' . time();
        // $pdf->Output('Laporan-Tcpdf-CodeIgniter.pdf');
        // $pdf->Output(FCPATH.'assets/file/pdf/'.$pdf_name.'.pdf');
        $pdf->Output(FCPATH . 'assets/PDF/' . $pdf_name . '.pdf', 'F');
        return $pdf_name . '.pdf';
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $hasil = $this->db->query("INSERT INTO user_log (id_user, waktu, keterangan, type) VALUES('$user->id_mhs', '$KETERANGAN', '$WAKTU', 'PENGAJUAN')");
        return $hasil;
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
