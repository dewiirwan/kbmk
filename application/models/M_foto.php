<?php
class M_foto extends CI_Model
{

    function get_data_by_id_mhs($id_mhs)
    {
        $hsl = $this->db->query("SELECT * FROM foto WHERE id_mhs='$id_mhs'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'id_foto' => $data->id_foto,
                    'id_mhs' => $data->id_mhs,
                    'nama_foto' => $data->nama_foto,
                    'token' => $data->token,
                    'tgl_upload' => $data->tgl_upload,
                    'keterangan' => $data->keterangan,
                    'keterangan_2' => $data->keterangan_2
                );
            }
        } else {
            $hasil = "BELUM ADA FOTO";
        }
        return $hasil;
    }
}
