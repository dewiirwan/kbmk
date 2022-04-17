<?php
class M_kegiatan extends CI_Model
{
    function cek_nama_kegiatan($NAMA_KEGIATAN)
    {
        $hsl = $this->db->query("SELECT * FROM kegiatan 
		WHERE nama_kegiatan = '$NAMA_KEGIATAN'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'id_kegiatan' => $data->id_kegiatan,
                    'nama_kegiatan' => $data->nama_kegiatan,
                    'deskripsi' => $data->deskripsi,
                    'tgl_kegiatan' => $data->tgl_kegiatan,
                    'pengkhotbah' => $data->pengkhotbah,
                    'durasi' => $data->durasi,
                    'ketua_panitia' => $data->ketua_panitia,
                    'jml_slot' => $data->jml_slot,
                    'butuh_swab' => $data->butuh_swab
                );
            }
        } else {
            $hasil = "BELUM ADA KEGIATAN";
        }
        return $hasil;
    }

    function user_log_kegiatan($ID_USER, $KETERANGAN, $WAKTU)
    {
        $hasil = $this->db->query("INSERT INTO user_log (id_user, waktu, keterangan, type) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU', 'KEGIATAN')");
        return $hasil;
    }
}
