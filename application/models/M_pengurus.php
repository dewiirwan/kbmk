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
}
