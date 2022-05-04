<?php defined('BASEPATH') or exit('No direct script access allowed');

class Frontend extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language', 'file'));
        $this->load->model('m_pengumuman');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index()
    {
        $data = array(
            'title' => 'Aplikasi Sistem Informasi KBMK| Home Page',
            'pengumuman' => $this->m_pengumuman->pengumuman_list()
        );

        $this->load->view('frontend/index', $data);
    }
}
