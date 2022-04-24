<?php
class M_pengurus extends CI_Model
{
    function cek_npm_pengurus($npm)
    {
        $hsl = $this->db->query("SELECT npm FROM pengurus WHERE npm ='$npm'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'npm' => $data->npm
                );
            }
            return $hasil;
        } else {
            return 'Data belum ada';
        }
    }

    function user_log_pengurus($ID_USER, $KETERANGAN, $WAKTU)
    {
        $hasil = $this->db->query("INSERT INTO user_log (id_user, waktu, keterangan, type) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU', 'PENGURUS')");
        return $hasil;
    }

    function get_detil($id_pengurus)
    {
        $hasil = $this->db->query("SELECT * FROM pengurus 
		WHERE id_pengurus = '$id_pengurus'");
        return $hasil;
    }

    function get_detil_result($id_pengurus)
    {
        $hasil = $this->db->query("SELECT * FROM pengurus 
		WHERE id_pengurus = '$id_pengurus'");
        return $hasil->result();
    }

    function file_list_by_id_pengurus($id_pengurus)
    {
        $hasil = $this->db->query("SELECT * FROM log_file WHERE id_pengirim = '$id_pengurus' AND pengirim = 'PENGIRIM' ORDER BY tanggal_upload ASC");
        return $hasil;
    }

    function file_list_by_id_pengurus_result($id_pengurus)
    {
        $hasil = $this->db->query("SELECT * FROM log_file WHERE id_pengirim = '$id_pengurus' AND pengirim = 'PENGIRIM' ORDER BY tanggal_upload ASC");
        return $hasil->result();
    }

    function file_list_by_dok_file($DOK_FILE)
    {
        $hasil = $this->db->query("SELECT * FROM log_file WHERE dok_file = '$DOK_FILE' AND pengirim = 'PENGIRIM' ORDER BY tanggal_upload ASC");
        return $hasil;
    }

    function hapus_data_by_dok_file($DOK_FILE)
    {
        $hasil = $this->db->query("DELETE FROM log_file WHERE dok_file='$DOK_FILE' AND pengirim = 'PENGIRIM'");
        return $hasil;
    }
}
