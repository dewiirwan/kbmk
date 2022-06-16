<?php
class M_jadwal extends CI_Model
{
    function cek_nama_jadwal($id_kegiatan)
    {
        $hsl = $this->db->query("SELECT * FROM jadwal 
		WHERE id_kegiatan = '$id_kegiatan'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'id_jadwal' => $data->id_jadwal,
                    'id_kegiatan' => $data->id_kegiatan,
                    'id_mhs' => $data->id_mhs,
                    'no_urut' => $data->no_urut,
                    'kode_qr' => $data->kode_qr,
                    'jam_hadir' => $data->jam_hadir,
                );
            }
        } else {
            $hasil = "BELUM ADA JADWAL";
        }
        return $hasil;
    }

    function user_log_jadwal($ID_USER, $KETERANGAN, $WAKTU)
    {
        $hasil = $this->db->query("INSERT INTO user_log (id_user, waktu, keterangan, type) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU', 'jadwal')");
        return $hasil;
    }

    function get_detil($id_kegiatan)
    {
        $hasil = $this->db->query("SELECT * FROM jadwal 
		WHERE id_kegiatan = '$id_kegiatan'");
        return $hasil;
    }

    function get_detil_result($id_kegiatan)
    {
        $hasil = $this->db->query("SELECT * FROM jadwal 
		WHERE id_kegiatan = '$id_kegiatan'");
        return $hasil->result();
    }

    function list_jadwal_kegiatan()
    {
        $this->db->select('id_kegiatan, nama_kegiatan, tgl_kegiatan, jml_slot');
        $this->db->from('kegiatan');
        $result = $this->db->get();
        return $result;
    }
}
