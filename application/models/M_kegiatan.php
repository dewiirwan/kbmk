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

    function get_detil($id_kegiatan)
    {
        $hasil = $this->db->query("SELECT * FROM kegiatan 
		WHERE id_kegiatan = '$id_kegiatan'");
        return $hasil;
    }

    function get_detil_result($id_kegiatan)
    {
        $hasil = $this->db->query("SELECT * FROM kegiatan 
		WHERE id_kegiatan = '$id_kegiatan'");
        return $hasil->result();
    }

    function file_list_by_id_kegiatan($id_kegiatan)
    {
        $hasil = $this->db->query("SELECT * FROM log_file WHERE id_pengirim = '$id_kegiatan' AND pengirim = 'KEGIATAN' ORDER BY tanggal_upload ASC");
        return $hasil;
    }

    function file_list_by_id_kegiatan_result($id_kegiatan)
    {
        $hasil = $this->db->query("SELECT * FROM log_file WHERE id_pengirim = '$id_kegiatan' AND pengirim = 'KEGIATAN' ORDER BY tanggal_upload ASC");
        return $hasil->result();
    }

    function file_list_by_dok_file($DOK_FILE)
    {
        $hasil = $this->db->query("SELECT * FROM log_file WHERE dok_file = '$DOK_FILE' AND pengirim = 'KEGIATAN' ORDER BY tanggal_upload ASC");
        return $hasil;
    }

    function hapus_data_by_dok_file($DOK_FILE)
    {
        $hasil = $this->db->query("DELETE FROM log_file WHERE dok_file='$DOK_FILE' AND pengirim = 'KEGIATAN'");
        return $hasil;
    }
}
