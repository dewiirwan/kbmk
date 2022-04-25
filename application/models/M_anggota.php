<?php
class M_anggota extends CI_Model
{

    function list_anggota()
    {
        $hasil = $this->db->query("SELECT *
		FROM anggota");
        return $hasil->result();
    }

    function anggota_data($id_mhs)
    {
        $hasil = $this->db->query("SELECT *
		FROM mahasiswa WHERE id_mhs='$id_mhs'");
        return $hasil->result();
    }

    function hapus_data($id_mhs)
    {
        $hasil = $this->db->query("DELETE FROM mahasiswa WHERE id_mhs='$id_mhs'");
        return $hasil;
    }

    function get_data($id_mhs)
    {
        $hsl = $this->db->query("SELECT * FROM mahasiswa 
		WHERE id_mhs = '$id_mhs'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'id_mhs' => $data->id_mhs,
                    'npm' => $data->npm,
                    'nama' => $data->nama,
                    'tempat_tgl_lahir' => $data->tempat_tgl_lahir,
                    'alamat' => $data->alamat,
                    'email' => $data->email,
                    'no_hp' => $data->no_hp
                );
            }
        } else {
            $hasil = "BELUM ADA ANGGOTA";
        }
        return $hasil;
    }

    function get_detil($id_mhs)
    {
        $hasil = $this->db->query("SELECT * FROM mahasiswa 
		WHERE id_mhs = '$id_mhs'");
        return $hasil;
    }

    function get_detil_result($id_mhs)
    {
        $hasil = $this->db->query("SELECT * FROM mahasiswa 
		WHERE id_mhs = '$id_mhs'");
        return $hasil->result();
    }

    function cek_npm_anggota($npm)
    {
        $hsl = $this->db->query("SELECT * FROM mahasiswa 
		WHERE npm = '$npm'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'id_mhs' => $data->id_mhs,
                    'npm' => $data->npm,
                    'nama' => $data->nama,
                    'tempat_tgl_lahir' => $data->tempat_tgl_lahir,
                    'alamat' => $data->alamat,
                    'email' => $data->email,
                    'no_hp' => $data->no_hp,
                );
            }
        } else {
            $hasil = "BELUM ADA NPM ANGGOTA";
        }
        return $hasil;
    }

    function cek_nama_anggota($NAMA)
    {
        $hsl = $this->db->query("SELECT * FROM mahasiswa 
		WHERE nama = '$NAMA'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'id_mhs' => $data->id_mhs,
                    'npm' => $data->npm,
                    'nama' => $data->nama,
                    'tempat_tgl_lahir' => $data->tempat_tgl_lahir,
                    'alamat' => $data->alamat,
                    'email' => $data->email,
                    'no_hp' => $data->no_hp
                );
            }
        } else {
            $hasil = "BELUM ADA NAMA ANGGOTA";
        }
        return $hasil;
    }

    function user_log_anggota($ID_USER, $KETERANGAN, $WAKTU)
    {
        $hasil = $this->db->query("INSERT INTO user_log (id_user, keterangan, waktu, type) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU','ANGGOTA')");
        return $hasil;
    }

    function file_list_by_id_mhs($id_mhs)
    {
        $hasil = $this->db->query("SELECT * FROM log_file WHERE id_pengirim = '$id_mhs' AND pengirim = 'ANGGOTA' ORDER BY tanggal_upload ASC");
        return $hasil;
    }

    function file_list_by_id_mhs_result($id_mhs)
    {
        $hasil = $this->db->query("SELECT * FROM log_file WHERE id_pengirim = '$id_mhs' AND pengirim = 'ANGGOTA' ORDER BY tanggal_upload ASC");
        return $hasil->result();
    }

    function file_list_by_dok_file($DOK_FILE)
    {
        $hasil = $this->db->query("SELECT * FROM log_file WHERE dok_file = '$DOK_FILE' AND pengirim = 'ANGGOTA' ORDER BY tanggal_upload ASC");
        return $hasil;
    }

    function hapus_data_by_dok_file($DOK_FILE)
    {
        $hasil = $this->db->query("DELETE FROM log_file WHERE dok_file='$DOK_FILE' AND pengirim = 'ANGGOTA'");
        return $hasil;
    }

    function simpan_data(
        $NIK,
        $NAMA,
        $TEMPAT_TANGGAL_LAHIR,
        $ALAMAT,
        $EMAIL,
        $NO_HP
    ) {
        $hasil = $this->db->query("INSERT INTO mahasiswa (
			npm,
			nama,
			tempat_tgl_lahir,
			alamat,
			email,
			no_hp)
		VALUES(
			'$NIK',
			'$NAMA',
			'$TEMPAT_TANGGAL_LAHIR',
			'$ALAMAT',
			'$EMAIL',
			'$NO_HP')");

        return $hasil;
    }

    function simpan_data_registrasi(
        $NIK,
        $EMAIL
    ) {
        $hasil = $this->db->query("INSERT INTO mahasiswa (
			npm,
			email)
		VALUES(
			'$NIK',
			'$EMAIL')");

        return $hasil;
    }
}
