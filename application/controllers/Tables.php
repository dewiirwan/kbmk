<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");

class Tables extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('m_table');
		$this->load->model('m_global');
		$this->load->helper('tgl_indo');
	}

	public function ajax_list()
	{
		$type	= $this->input->post('type');
		$data 	= array();
		$start    = isset($_POST['start']) ? intval($_POST['start']) : 0;
		$length   = isset($_POST['length']) ? intval($_POST['length']) : 10;
		$sort     = isset($_POST['columns'][@$_POST['order'][0]['column']]['data']) ? strval(@$_POST['columns'][@$_POST['order'][0]['column']]['data']) : 'nama';
		$order    = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
		$filter   = @$_POST['filter'];
		$no = $this->input->post('start');

		switch ($type) {
			case 'data_list_hadir':
				$list = $this->m_table->get_datatables('data_list_hadir', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;
					$l->aksi = "
						<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Anggota' onclick='detail_hadir(" . $l->id_mhs	. ")'>
						<i class='fa fa-eye'></i> Lihat Detail
						</a>";

					$data[] = $l;
				}

				$output = array(
					"draw"              => $_POST['draw'],
					"recordsTotal"      => $this->m_table->count_all('data_list_hadir', $sort, $order),
					"recordsFiltered"   => $this->m_table->count_filtered('data_list_hadir', $sort, $order),
					"data"              => $data,
					'filter'            => $filter,
				);
				echo json_encode($output);
				break;
			case 'data_list_sertif_anggota':
				$list = $this->m_table->get_datatables('data_list_sertif_anggota', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;
					$l->aksi = "
						<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Sertifikat' onclick='detail(" . $l->id_log_file	. ")'>
						<i class='fa fa-eye'></i> Lihat Sertifikat
						</a>";

					$data[] = $l;
				}

				$output = array(
					"draw"              => $_POST['draw'],
					"recordsTotal"      => $this->m_table->count_all('data_list_sertif_anggota', $sort, $order),
					"recordsFiltered"   => $this->m_table->count_filtered('data_list_sertif_anggota', $sort, $order),
					"data"              => $data,
					'filter'            => $filter,
				);
				echo json_encode($output);
				break;
			case 'data_list_pengurus_anggota':
				$list = $this->m_table->get_datatables('data_list_pengurus', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;
					$l->aksi = "
					<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Pengurus' onclick='detail(" . $l->id_pengurus	. ")'>
					<i class='fa fa-eye'></i> Lihat Pengurus
					</a>";

					$data[] = $l;
				}

				$output = array(
					"draw"              => $_POST['draw'],
					"recordsTotal"      => $this->m_table->count_all('data_list_pengurus', $sort, $order),
					"recordsFiltered"   => $this->m_table->count_filtered('data_list_pengurus', $sort, $order),
					"data"              => $data,
					'filter'            => $filter,
				);
				echo json_encode($output);
				break;
			case 'data_list_pengurus':
				$list = $this->m_table->get_datatables('data_list_pengurus', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;
					$l->ttl = $l->tempat_tgl_lahir;
					$l->aksi = "
					<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Pengurus' onclick='detail(" . $l->id_pengurus	. ")'>
					<i class='fa fa-eye'></i> Lihat Pengurus
					</a>
					<a href='javascript:void(0)' class='btn btn-warning btn-xs block' title='Edit Pengurus' data-href='" . $l->id_pengurus	. "' data-toggle='modal' data-target='#m_edit'>
					<i class='fa fa-pencil'></i> Edit
					</a>
					<a href='javascript:void(0)' class='btn btn-danger btn-xs block' title='Hapus Pengurus' onclick='confirm_del(" . $l->id_pengurus . ")'>
					<i class='fa fa-trash'></i> Hapus
					</a>";

					$data[] = $l;
				}

				$output = array(
					"draw"              => $_POST['draw'],
					"recordsTotal"      => $this->m_table->count_all('data_list_pengurus', $sort, $order),
					"recordsFiltered"   => $this->m_table->count_filtered('data_list_pengurus', $sort, $order),
					"data"              => $data,
					'filter'            => $filter,
				);
				echo json_encode($output);
				break;
			case 'data_list_anggota':
				$list = $this->m_table->get_datatables('data_list_anggota', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;
					$l->ttl = $l->tempat_tgl_lahir;
					$l->aksi = "
					<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Anggota' onclick='detail(" . $l->id_mhs	. ")'>
					<i class='fa fa-eye'></i> Lihat Anggota
					</a>
					<a href='javascript:void(0)' class='btn btn-warning btn-xs block' title='Edit Anggota' onclick='edit(" . $l->id_mhs . ")'>
					<i class='fa fa-pencil'></i> Edit
					</a>";

					$data[] = $l;
				}

				$output = array(
					"draw"              => $_POST['draw'],
					"recordsTotal"      => $this->m_table->count_all('data_list_anggota', $sort, $order),
					"recordsFiltered"   => $this->m_table->count_filtered('data_list_anggota', $sort, $order),
					"data"              => $data,
					'filter'            => $filter,
				);
				echo json_encode($output);
				break;
			case 'data_list_anggota_pengurus':
				$list = $this->m_table->get_datatables('data_list_anggota_pengurus', $sort, $order);
				foreach ($list as $l) {
					$pengajuan = $this->db->query("SELECT status_verif FROM form_pengajuan WHERE id_mhs = '$l->id_mhs'")->row();
					$no++;
					$l->no = $no;
					$l->ttl = $l->tempat_tgl_lahir;

					if ($pengajuan  == null) {
						$l->aksi = "
						<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Anggota' onclick='detail(" . $l->id_mhs	. ")'>
						<i class='fa fa-eye'></i> Lihat Anggota
						</a>
						<a href='javascript:void(0)' class='btn btn-success btn-xs block' title='Upload Sertif' onclick='upload(" . $l->id_mhs	. ")'>
						<i class='fa fa-file'></i> Upload Sertif
						</a>";
					} else {
						if ($pengajuan->status_verif == '1') {
							$l->aksi = "
						<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Anggota' onclick='detail(" . $l->id_mhs	. ")'>
						<i class='fa fa-eye'></i> Lihat Anggota
						</a>
						<a href='javascript:void(0)' class='btn btn-success btn-xs block' title='Upload Sertif' onclick='upload(" . $l->id_mhs	. ")'>
						<i class='fa fa-file'></i> Upload Sertif
						</a>";
						} else {
							$l->aksi = "
							<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Anggota' onclick='detail(" . $l->id_mhs	. ")'>
							<i class='fa fa-eye'></i> Lihat Anggota
							</a>
							<a href='javascript:void(0)' class='btn btn-success btn-xs block' title='Upload Sertif' onclick='upload(" . $l->id_mhs	. ")'>
							<i class='fa fa-file'></i> Upload Sertif
							</a>
							<a href='javascript:void(0)' class='btn btn-success btn-xs block' title='Verifikasi Form Pengajuan' onclick='verif(" . $l->id_mhs	. ")'>
							<i class='fa fa-check'></i> Verif Form Pengajuan
							</a>";
						}
					}


					$data[] = $l;
				}

				$output = array(
					"draw"              => $_POST['draw'],
					"recordsTotal"      => $this->m_table->count_all('data_list_anggota_pengurus', $sort, $order),
					"recordsFiltered"   => $this->m_table->count_filtered('data_list_anggota_pengurus', $sort, $order),
					"data"              => $data,
					'filter'            => $filter,
				);
				echo json_encode($output);
				break;
			case 'data_list_jadwal_detail':
				$list = $this->m_table->get_datatables('data_list_jadwal_detail', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;
					if ($l->nama_mhs != null && $l->jam_hadir == null) {
						$l->aksi = "
						<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Verif Hadir' onclick='confirm_verif(" . $l->id_jadwal	. ")'>
						<i class='fa fa-check'></i> Verif Hadir
						</a>
						<a href='javascript:void(0)' class='btn btn-danger btn-xs block' title='Hapus Slot' onclick='confirm_del(" . $l->id_jadwal . ")'>
						<i class='fa fa-trash'></i> Hapus Slot
						</a>";
					} else if ($l->nama_mhs == null) {
						$l->aksi = "
							<a href='javascript:void(0)' class='btn btn-danger btn-xs block' title='Hapus Slot' onclick='confirm_del(" . $l->id_jadwal . ")'>
							<i class='fa fa-trash'></i> Hapus Slot
							</a>";
					} else if ($l->nama_mhs != null && $l->jam_hadir != null) {
						$l->aksi = "
							<a href='javascript:void(0)' class='btn btn-danger btn-xs block' title='Hapus Slot' onclick='confirm_del(" . $l->id_jadwal . ")'>
							<i class='fa fa-trash'></i> Hapus Slot
							</a>";
					}

					$data[] = $l;
				}

				$output = array(
					"draw"              => $_POST['draw'],
					"recordsTotal"      => $this->m_table->count_all('data_list_jadwal_detail', $sort, $order),
					"recordsFiltered"   => $this->m_table->count_filtered('data_list_jadwal_detail', $sort, $order),
					"data"              => $data,
					'filter'            => $filter,
				);
				echo json_encode($output);
				break;
			case 'data_list_jadwal_kegiatan':
				$list = $this->m_table->get_datatables('data_list_jadwal_kegiatan', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;
					$getIDKegiatan = $this->db->query('SELECT id_kegiatan FROM jadwal WHERE id_kegiatan = ' . $l->id_kegiatan . '')->row();
					if (@$getIDKegiatan->id_kegiatan != null) {
						$l->aksi = "
						<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Jadwal' onclick='detail(" . $l->id_kegiatan	. ")'>
						<i class='fa fa-eye'></i> Lihat Detail
						</a>
						<a href='javascript:void(0)' class='btn btn-danger btn-xs block' title='Reset Slot' onclick='confirm_reset(" . $l->id_kegiatan . ")'>
						<i class='fa fa-trash'></i> Reset Slot
						</a>";
					} else {
						$l->aksi = '';
					}


					$data[] = $l;
				}

				$output = array(
					"draw"              => $_POST['draw'],
					"recordsTotal"      => $this->m_table->count_all('data_list_jadwal_kegiatan', $sort, $order),
					"recordsFiltered"   => $this->m_table->count_filtered('data_list_jadwal_kegiatan', $sort, $order),
					"data"              => $data,
					'filter'            => $filter,
				);
				echo json_encode($output);
				break;
			case 'data_list_kegiatan':
				$list = $this->m_table->get_datatables('data_list_kegiatan', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;
					$l->aksi = "
					<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Kegiatan' onclick='detail(" . $l->id_kegiatan	. ")'>
					<i class='fa fa-eye'></i> Lihat Kegiatan
					</a>
					<a href='javascript:void(0)' class='btn btn-warning btn-xs block' title='Edit Kegiatan' data-href='" . $l->id_kegiatan	. "' data-toggle='modal' data-target='#m_edit'>
					<i class='fa fa-pencil'></i> Edit
					</a>
					<a href='javascript:void(0)' class='btn btn-danger btn-xs block' title='Hapus Kegiatan' onclick='confirm_del(" . $l->id_kegiatan . ")'>
					<i class='fa fa-trash'></i> Hapus
					</a>";

					$data[] = $l;
				}

				$output = array(
					"draw"              => $_POST['draw'],
					"recordsTotal"      => $this->m_table->count_all('data_list_kegiatan', $sort, $order),
					"recordsFiltered"   => $this->m_table->count_filtered('data_list_kegiatan', $sort, $order),
					"data"              => $data,
					'filter'            => $filter,
				);
				echo json_encode($output);
				break;
			case 'data_list_kegiatan_anggota':
				$list = $this->m_table->get_datatables('data_list_kegiatan_anggota', $sort, $order);
				foreach ($list as $l) {
					$id_mhs = $this->session->userdata('id_mhs');
					$cekDaftar = $this->db->query('SELECT j.* FROM jadwal as j WHERE j.id_mhs = ' . $id_mhs . ' AND j.id_kegiatan = ' . $l->id_kegiatan . '')->row();
					$getJadwal = $this->db->query('SELECT * FROM jadwal WHERE id_kegiatan = ' . $l->id_kegiatan . '')->row();
					$no++;
					$l->no = $no;

					if ($getJadwal) {
						if ($cekDaftar) {
							$l->aksi = "
							<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Data' onclick='detail(" . $l->id_kegiatan	. ")'>
							<i class='fa fa-eye'></i> Lihat Kegiatan
							</a>";
						} else {
							$l->aksi = "
						<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Data' onclick='detail(" . $l->id_kegiatan	. ")'>
						<i class='fa fa-eye'></i> Lihat Kegiatan
						</a>
						<a href='javascript:void(0)' class='btn btn-primary btn-xs block' title='Daftar Kegiatan' onclick='daftar(" . $id_mhs	. "," . @$getJadwal->id_jadwal . ")'>
						Daftar Kegiatan
						</a>";
						}
					} else {
						$l->aksi = "
							<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Data' onclick='detail(" . $l->id_kegiatan	. ")'>
							<i class='fa fa-eye'></i> Lihat Kegiatan
							</a>";
					}


					$data[] = $l;
				}

				$output = array(
					"draw"              => $_POST['draw'],
					"recordsTotal"      => $this->m_table->count_all('data_list_kegiatan_anggota', $sort, $order),
					"recordsFiltered"   => $this->m_table->count_filtered('data_list_kegiatan_anggota', $sort, $order),
					"data"              => $data,
					'filter'            => $filter,
				);
				echo json_encode($output);
				break;
			case 'data_list_pengumuman':
				$list = $this->m_table->get_datatables('data_list_pengumuman', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;
					$l->aksi = "
					<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Pengumuman' onclick='detail(" . $l->id_pengumuman	. ")'>
					<i class='fa fa-eye'></i> Lihat Pengumuman
					</a>
					<a href='javascript:void(0)' class='btn btn-warning btn-xs block' title='Edit Pengumuman' data-href='" . $l->id_pengumuman	. "' data-toggle='modal' data-target='#m_edit'>
					<i class='fa fa-pencil'></i> Edit
					</a>
					<a href='javascript:void(0)' class='btn btn-danger btn-xs block' title='Hapus Pengumuman' onclick='confirm_del(" . $l->id_pengumuman . ")'>
					<i class='fa fa-trash'></i> Hapus
					</a>";

					$data[] = $l;
				}

				$output = array(
					"draw"              => $_POST['draw'],
					"recordsTotal"      => $this->m_table->count_all('data_list_pengumuman', $sort, $order),
					"recordsFiltered"   => $this->m_table->count_filtered('data_list_pengumuman', $sort, $order),
					"data"              => $data,
					'filter'            => $filter,
				);
				echo json_encode($output);
				break;
			case 'data_list_pengajuan':
				$list = $this->m_table->get_datatables('data_list_pengajuan', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;
					$l->aksi = "
					<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Pengajuan' onclick='detail(" . $l->id_form	. ")'>
					<i class='fa fa-eye'></i> Lihat Pengajuan
					</a>
					<a href='javascript:void(0)' class='btn btn-danger btn-xs block' title='Hapus Pengajuan' onclick='confirm_del(" . $l->id_form . ")'>
					<i class='fa fa-trash'></i> Hapus
					</a>";

					$data[] = $l;
				}

				$output = array(
					"draw"              => $_POST['draw'],
					"recordsTotal"      => $this->m_table->count_all('data_list_pengajuan', $sort, $order),
					"recordsFiltered"   => $this->m_table->count_filtered('data_list_pengajuan', $sort, $order),
					"data"              => $data,
					'filter'            => $filter,
				);
				echo json_encode($output);
				break;
			default:
				break;
		}
	}
}
