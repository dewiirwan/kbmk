<?php
class M_sertif extends CI_Model
{
    function file_list_by_id_log_file($id_log_file)
    {
        $hasil = $this->db->query("SELECT * FROM log_file WHERE id_log_file = '$id_log_file' AND pengirim = 'ANGGOTA' ORDER BY tanggal_upload ASC");
        return $hasil;
    }

    function file_list_by_id_log_file_result($id_log_file)
    {
        $hasil = $this->db->query("SELECT * FROM log_file WHERE id_log_file = '$id_log_file' AND pengirim = 'ANGGOTA' ORDER BY tanggal_upload ASC");
        return $hasil->result();
    }

    function file_list_by_id_log_file_row($id_log_file)
    {
        $hasil = $this->db->query("SELECT * FROM log_file WHERE id_log_file = '$id_log_file' AND pengirim = 'ANGGOTA' ORDER BY tanggal_upload ASC");
        return $hasil->row();
    }
}
