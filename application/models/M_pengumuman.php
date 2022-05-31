<?php
class M_pengumuman extends CI_Model
{

    function pengumuman_list()
    {
        $hasil = $this->db->query("SELECT *
		FROM pengumuman");
        return $hasil->result();
    }


    function hapus_data($id_pengumuman)
    {
        $hasil = $this->db->query("DELETE FROM pengumuman WHERE id_pengumuman='$id_pengumuman'");
        return $hasil;
    }



    function get_data($id_pengumuman)
    {
        $hsl = $this->db->query("SELECT * FROM pengumuman 
		WHERE id_pengumuman = '$id_pengumuman'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'id_pengumuman' => $data->id_pengumuman,
                    'judul' => $data->judul,
                    'headline_berita' => $data->headline_berita,
                    'isi_berita' => $data->isi_berita,
                    'tgl_posting' => $data->tgl_posting,
                    'keterangan' => $data->keterangan
                );
            }
        } else {
            $hasil = "BELUM ADA PENGUMUMAN";
        }
        return $hasil;
    }

    function get_detil($id_pengumuman)
    {
        $hasil = $this->db->query("SELECT * FROM pengumuman 
		WHERE id_pengumuman = '$id_pengumuman'");
        return $hasil;
    }

    function get_detil_result($id_pengumuman)
    {
        $hasil = $this->db->query("SELECT * FROM pengumuman 
		WHERE id_pengumuman = '$id_pengumuman'");
        return $hasil->result();
    }

    public function per_id($id_pengumuman)
    {
        $id = $this->db->select('*')
            ->from('pengumuman')
            ->where('id_pengumuman', $id_pengumuman)
            ->get();
        return $id;
    }

    function cek_judul_pengumuman($JUDUL)
    {
        $hsl = $this->db->query("SELECT * FROM pengumuman 
		WHERE judul = '$JUDUL'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'id_pengumuman' => $data->id_pengumuman,
                    'judul' => $data->judul,
                    'headline_berita' => $data->headline_berita,
                    'isi_berita' => $data->isi_berita,
                    'tgl_posting' => $data->tgl_posting,
                    'keterangan' => $data->keterangan
                );
            }
        } else {
            $hasil = "BELUM ADA PENGUMUMAN";
        }
        return $hasil;
    }


    function cek_npm_Pengumuman($npm)
    {
        $hsl = $this->db->query("SELECT npm FROM pengumuman WHERE npm ='$npm'");
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

    function update_data($id_pengumuman_2, $JUDUL_2, $HEADLINE_BERITA_2, $ISI_BERITA_2, $TANGGAL_POSTING_2, $KETERANGAN_2)
    {
        $hasil = $this->db->query("UPDATE pengumuman SET
					
                    judul='$JUDUL_2',
                    headline_berita='$HEADLINE_BERITA_2',
                    isi_berita='$ISI_BERITA_2',
                    tgl_posting='$TANGGAL_POSTING_2',
                    keterangan='$KETERANGAN_2'
		WHERE id_pengumuman='$id_pengumuman_2'");
        return $hasil;
    }

    function simpan_data(
        $JUDUL,
        $HEADLINE_BERITA,
        $ISI_BERITA,
        $TANGGAL_POSTING,
        $KETERANGAN
    ) {
        $hasil = $this->db->query("INSERT INTO pengumuman (
            
                    judul,
                    headline_berita,
                    isi_berita,
                    tgl_posting,
                    keterangan)
		VALUES(
			'$JUDUL',
			'$HEADLINE_BERITA',
			'$ISI_BERITA',
			'$TANGGAL_POSTING',
			'$KETERANGAN')");

        return $hasil;
    }


    function user_log_pengumuman($ID_USER, $KETERANGAN, $WAKTU)
    {
        $hasil = $this->db->query("INSERT INTO user_log (id_user, keterangan, waktu, type) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU','PENGUMUMAN')");
        return $hasil;
    }
}
