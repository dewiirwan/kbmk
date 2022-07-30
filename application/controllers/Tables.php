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
		$this->load->model('m_excel');
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
					$konsultasi = $this->db->query("SELECT tgl_konsultasi FROM t_konsultasi WHERE id_mhs = '$l->id_mhs'")->row();
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

					if ($konsultasi  == null) {
						$l->aksi = "
						<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Anggota' onclick='detail(" . $l->id_mhs	. ")'>
						<i class='fa fa-eye'></i> Lihat Anggota
						</a>
						<a href='javascript:void(0)' class='btn btn-success btn-xs block' title='Upload Sertif' onclick='upload(" . $l->id_mhs	. ")'>
						<i class='fa fa-file'></i> Upload Sertif
						</a>";
					} else {
						if ($konsultasi->tgl_konsultasi != null) {
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
							<a href='javascript:void(0)' class='btn btn-success btn-xs block' title='Verifikasi Konsultasi' onclick='konsultasi(" . $l->id_mhs	. ")'>
							<i class='fa fa-check'></i> Verif Konsultasi
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
					$user = $this->ion_auth->user()->row();

					$id_mhs = $user->id_mhs;
					$cekDaftar = $this->db->query('SELECT j.* FROM jadwal as j WHERE j.id_mhs = ' . $id_mhs . ' AND j.id_kegiatan = ' . $l->id_kegiatan . '')->row();
					$getJadwal = $this->db->query('SELECT * FROM jadwal WHERE id_kegiatan = ' . $l->id_kegiatan . '')->row();
					$no++;
					$l->no = $no;

					if ($getJadwal) {
						// var_dump($cekDaftar);die;
						if ($cekDaftar) {
							$l->aksi = "
							<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Detail Data' onclick='detail(" . $l->id_kegiatan	. ")'>
							<i class='fa fa-eye'></i> Lihat Kegiatan
							</a>
							<a href='javascript:void(0)' class='btn btn-info btn-xs block' title='Bukti Daftar' onclick='bukti_daftar(" . $id_mhs	. ")'>
							<i class='fa fa-eye'></i> Bukti Daftar
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
			case 'data_list_konsultasi':
				$list = $this->m_table->get_datatables('data_list_konsultasi', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;

					if ($l->tgl_konsultasi != null) {
						$l->aksi = "";
					} else {
						$l->aksi = "
					<a href='javascript:void(0)' class='btn btn-danger btn-xs block' title='Hapus Konsultasi' onclick='confirm_del(" . $l->id_konsultasi . ")'>
					<i class='fa fa-trash'></i> Hapus
					</a>";
					}


					$data[] = $l;
				}

				$output = array(
					"draw"              => $_POST['draw'],
					"recordsTotal"      => $this->m_table->count_all('data_list_konsultasi', $sort, $order),
					"recordsFiltered"   => $this->m_table->count_filtered('data_list_konsultasi', $sort, $order),
					"data"              => $data,
					'filter'            => $filter,
				);
				echo json_encode($output);
				break;
			default:
				break;
		}
	}

	public function ajax_print()
	{
		$type	= $this->input->post('type');
		switch ($type) {
			case 'data_hadir_anggota':
				// var_dump(phpinfo());
				// die;
				$this->load->library('excel');

				$styleArray = array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					)
				);
				$this->excel->createSheet();

				$this->excel->setActiveSheetIndex(1)->setCellValue('A2', 'DATA HADIR ANGGOTA');
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setSize(16);
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A2:I2');
				$this->excel->getActiveSheet(1)->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$this->excel->getActiveSheet(1)->getColumnDimension('A')->setWidth(5);
				$this->excel->getActiveSheet(1)->getColumnDimension('B')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('C')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('D')->setWidth(35);
				$this->excel->getActiveSheet(1)->getColumnDimension('E')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('F')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('G')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('H')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('I')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('J')->setWidth(25);

				$this->excel->setActiveSheetIndex(1)->setCellValue('A5', 'NO');
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A5:A5');
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('B5', 'NPM');
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('B5:B5');
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('C5', 'NANA ANGGOTA');
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('C5:C5');
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('D5', 'ALAMAT');
				$this->excel->setActiveSheetIndex(1)->getStyle('D5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('D5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('D5:D5');
				$this->excel->getActiveSheet(1)->getStyle('D5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('D5:D5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('E5', 'EMAIL');
				$this->excel->setActiveSheetIndex(1)->getStyle('E5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('E5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('E5:E5');
				$this->excel->getActiveSheet(1)->getStyle('E5:E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('E5:E5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('F5', 'NO HANDPHONE');
				$this->excel->setActiveSheetIndex(1)->getStyle('F5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('F5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('F5:F5');
				$this->excel->getActiveSheet(1)->getStyle('F5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('F5:F5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('G5', 'NAMA KEGIATAN');
				$this->excel->setActiveSheetIndex(1)->getStyle('G5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('G5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('G5:G5');
				$this->excel->getActiveSheet(1)->getStyle('G5:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('G5:G5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('H5', 'TANGGAL KEGIATAN');
				$this->excel->setActiveSheetIndex(1)->getStyle('H5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('H5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('H5:H5');
				$this->excel->getActiveSheet(1)->getStyle('H5:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('H5:H5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('I5', 'NOMOR URUT');
				$this->excel->setActiveSheetIndex(1)->getStyle('I5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('I5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('I5:I5');
				$this->excel->getActiveSheet(1)->getStyle('I5:I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('I5:I5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('J5', 'WAKTU HADIR');
				$this->excel->setActiveSheetIndex(1)->getStyle('J5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('J5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('J5:J5');
				$this->excel->getActiveSheet(1)->getStyle('J5:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('J5:J5')->applyFromArray($styleArray);


				$cek 	= $this->m_excel->query($type);

				$i = 6;
				if (!empty($cek)) {
					$no = 1;
					foreach ($cek as $data) {
						$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, $no++);
						$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':A' . $i);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('B' . $i, $data->npm);
						$this->excel->setActiveSheetIndex(1)->getStyle('B' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('B' . $i . ':B' . $i);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('C' . $i, $data->nama_anggota);
						$this->excel->setActiveSheetIndex(1)->getStyle('C' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('C' . $i . ':C' . $i);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('D' . $i, $data->alamat);
						$this->excel->setActiveSheetIndex(1)->getStyle('D' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('D' . $i . ':D' . $i);
						$this->excel->getActiveSheet(1)->getStyle('D' . $i . ':D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('D' . $i . ':D' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('E' . $i, $data->email);
						$this->excel->setActiveSheetIndex(1)->getStyle('E' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('E' . $i . ':E' . $i);
						$this->excel->getActiveSheet(1)->getStyle('E' . $i . ':E' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('F' . $i, $data->no_hp);
						$this->excel->setActiveSheetIndex(1)->getStyle('F' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('F' . $i . ':F' . $i);
						$this->excel->getActiveSheet(1)->getStyle('F' . $i . ':F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('F' . $i . ':F' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('G' . $i, $data->nama_kegiatan);
						$this->excel->setActiveSheetIndex(1)->getStyle('G' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('G' . $i . ':G' . $i);
						$this->excel->getActiveSheet(1)->getStyle('G' . $i . ':G' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('G' . $i . ':G' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('H' . $i, $data->tgl_kegiatan);
						$this->excel->setActiveSheetIndex(1)->getStyle('H' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('H' . $i . ':H' . $i);
						$this->excel->getActiveSheet(1)->getStyle('H' . $i . ':H' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('H' . $i . ':H' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('I' . $i, $data->no_urut);
						$this->excel->setActiveSheetIndex(1)->getStyle('I' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('I' . $i . ':I' . $i);
						$this->excel->getActiveSheet(1)->getStyle('I' . $i . ':I' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('I' . $i . ':I' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('J' . $i, $data->jam_hadir);
						$this->excel->setActiveSheetIndex(1)->getStyle('J' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('J' . $i . ':J' . $i);
						$this->excel->getActiveSheet(1)->getStyle('J' . $i . ':J' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('J' . $i . ':J' . $i)->applyFromArray($styleArray);



						$i++;
					}
				} else {
					$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, "Data Tidak Ditemukan");
					$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
					$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':J' . $i);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':J' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':J' . $i)->applyFromArray($styleArray);
				}


				$sheet = $this->excel->getIndex(
					$this->excel->getSheetByName('Worksheet')
				);
				$this->excel->removeSheetByIndex($sheet);
				$this->excel->setActiveSheetIndex(0);
				$filename = "LAPORAN_DATA_HADIR_ANGGOTA" . '_' . time() . ".xls";
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				ob_end_clean();
				ob_start();
				$objWriter->save('php://output');

				break;

			case 'data_list_anggota':

				$this->load->library('excel');

				$styleArray = array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					)
				);
				$this->excel->createSheet();

				$this->excel->setActiveSheetIndex(1)->setCellValue('A2', 'DATA LIST ANGGOTA');
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setSize(16);
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A2:I2');
				$this->excel->getActiveSheet(1)->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$this->excel->getActiveSheet(1)->getColumnDimension('A')->setWidth(5);
				$this->excel->getActiveSheet(1)->getColumnDimension('B')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('C')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('D')->setWidth(35);
				$this->excel->getActiveSheet(1)->getColumnDimension('E')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('F')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('G')->setWidth(25);

				$this->excel->setActiveSheetIndex(1)->setCellValue('A5', 'NO');
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A5:A5');
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('B5', 'NPM');
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('B5:B5');
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('C5', 'NANA ANGGOTA');
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('C5:C5');
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('D5', 'TEMPAT TANGGAL LAHIR');
				$this->excel->setActiveSheetIndex(1)->getStyle('D5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('D5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('D5:D5');
				$this->excel->getActiveSheet(1)->getStyle('D5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('D5:D5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('E5', 'ALAMAT');
				$this->excel->setActiveSheetIndex(1)->getStyle('E5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('E5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('E5:E5');
				$this->excel->getActiveSheet(1)->getStyle('E5:E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('E5:E5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('F5', 'EMAIL');
				$this->excel->setActiveSheetIndex(1)->getStyle('F5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('F5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('F5:F5');
				$this->excel->getActiveSheet(1)->getStyle('F5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('F5:F5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('G5', 'NO HANDPHONE');
				$this->excel->setActiveSheetIndex(1)->getStyle('G5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('G5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('G5:G5');
				$this->excel->getActiveSheet(1)->getStyle('G5:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('G5:G5')->applyFromArray($styleArray);


				$cek 	= $this->m_excel->query($type);

				$i = 6;
				if (!empty($cek)) {
					$no = 1;
					foreach ($cek as $data) {
						$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, $no++);
						$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':A' . $i);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('B' . $i, $data->npm);
						$this->excel->setActiveSheetIndex(1)->getStyle('B' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('B' . $i . ':B' . $i);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('C' . $i, $data->nama_anggota);
						$this->excel->setActiveSheetIndex(1)->getStyle('C' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('C' . $i . ':C' . $i);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('D' . $i, $data->tempat_tgl_lahir);
						$this->excel->setActiveSheetIndex(1)->getStyle('D' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('D' . $i . ':D' . $i);
						$this->excel->getActiveSheet(1)->getStyle('D' . $i . ':D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('D' . $i . ':D' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('E' . $i, $data->alamat);
						$this->excel->setActiveSheetIndex(1)->getStyle('E' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('E' . $i . ':E' . $i);
						$this->excel->getActiveSheet(1)->getStyle('E' . $i . ':E' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('F' . $i, $data->email);
						$this->excel->setActiveSheetIndex(1)->getStyle('F' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('F' . $i . ':F' . $i);
						$this->excel->getActiveSheet(1)->getStyle('F' . $i . ':F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('F' . $i . ':F' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('G' . $i, $data->no_hp);
						$this->excel->setActiveSheetIndex(1)->getStyle('G' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('G' . $i . ':G' . $i);
						$this->excel->getActiveSheet(1)->getStyle('G' . $i . ':G' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('G' . $i . ':G' . $i)->applyFromArray($styleArray);



						$i++;
					}
				} else {
					$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, "Data Tidak Ditemukan");
					$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
					$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':G' . $i);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':G' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':G' . $i)->applyFromArray($styleArray);
				}


				$sheet = $this->excel->getIndex(
					$this->excel->getSheetByName('Worksheet')
				);
				$this->excel->removeSheetByIndex($sheet);
				$this->excel->setActiveSheetIndex(0);
				$filename = "LAPORAN_DATA_LIST_ANGGOTA" . '_' . time() . ".xls";
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				ob_end_clean();
				ob_start();
				$objWriter->save('php://output');

				break;

			case 'data_list_pengurus':

				$this->load->library('excel');

				$styleArray = array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					)
				);
				$this->excel->createSheet();

				$this->excel->setActiveSheetIndex(1)->setCellValue('A2', 'DATA LIST PENGURUS');
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setSize(16);
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A2:I2');
				$this->excel->getActiveSheet(1)->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$this->excel->getActiveSheet(1)->getColumnDimension('A')->setWidth(5);
				$this->excel->getActiveSheet(1)->getColumnDimension('B')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('C')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('D')->setWidth(35);
				$this->excel->getActiveSheet(1)->getColumnDimension('E')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('F')->setWidth(25);

				$this->excel->setActiveSheetIndex(1)->setCellValue('A5', 'NO');
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A5:A5');
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('B5', 'NAMA LENGKAP');
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('B5:B5');
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('C5', 'TEMPAT TANGGAL LAHIR');
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('C5:C5');
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('D5', 'ALAMAT');
				$this->excel->setActiveSheetIndex(1)->getStyle('D5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('D5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('D5:D5');
				$this->excel->getActiveSheet(1)->getStyle('D5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('D5:D5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('E5', 'EMAIL');
				$this->excel->setActiveSheetIndex(1)->getStyle('E5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('E5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('E5:E5');
				$this->excel->getActiveSheet(1)->getStyle('E5:E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('E5:E5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('F5', 'NOMOR TELEPON');
				$this->excel->setActiveSheetIndex(1)->getStyle('F5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('F5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('F5:F5');
				$this->excel->getActiveSheet(1)->getStyle('F5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('F5:F5')->applyFromArray($styleArray);


				$cek 	= $this->m_excel->query($type);

				$i = 6;
				if (!empty($cek)) {
					$no = 1;
					foreach ($cek as $data) {
						$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, $no++);
						$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':A' . $i);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('B' . $i, $data->nama_pengurus);
						$this->excel->setActiveSheetIndex(1)->getStyle('B' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('B' . $i . ':B' . $i);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('C' . $i, $data->tempat_tgl_lahir);
						$this->excel->setActiveSheetIndex(1)->getStyle('C' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('C' . $i . ':C' . $i);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('D' . $i, $data->alamat);
						$this->excel->setActiveSheetIndex(1)->getStyle('D' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('D' . $i . ':D' . $i);
						$this->excel->getActiveSheet(1)->getStyle('D' . $i . ':D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('D' . $i . ':D' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('E' . $i, $data->email);
						$this->excel->setActiveSheetIndex(1)->getStyle('E' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('E' . $i . ':E' . $i);
						$this->excel->getActiveSheet(1)->getStyle('E' . $i . ':E' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('F' . $i, $data->no_hp);
						$this->excel->setActiveSheetIndex(1)->getStyle('F' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('F' . $i . ':F' . $i);
						$this->excel->getActiveSheet(1)->getStyle('F' . $i . ':F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('F' . $i . ':F' . $i)->applyFromArray($styleArray);



						$i++;
					}
				} else {
					$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, "Data Tidak Ditemukan");
					$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
					$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':F' . $i);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':F' . $i)->applyFromArray($styleArray);
				}


				$sheet = $this->excel->getIndex(
					$this->excel->getSheetByName('Worksheet')
				);
				$this->excel->removeSheetByIndex($sheet);
				$this->excel->setActiveSheetIndex(0);
				$filename = "LAPORAN_DATA_LIST_PENGURUS" . '_' . time() . ".xls";
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				ob_end_clean();
				ob_start();
				$objWriter->save('php://output');

				break;

			case 'data_list_kegiatan':

				$this->load->library('excel');

				$styleArray = array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					)
				);
				$this->excel->createSheet();

				$this->excel->setActiveSheetIndex(1)->setCellValue('A2', 'DATA LIST KEGIATAN');
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setSize(16);
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A2:I2');
				$this->excel->getActiveSheet(1)->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$this->excel->getActiveSheet(1)->getColumnDimension('A')->setWidth(5);
				$this->excel->getActiveSheet(1)->getColumnDimension('B')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('C')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('D')->setWidth(35);
				$this->excel->getActiveSheet(1)->getColumnDimension('E')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('F')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('G')->setWidth(25);

				$this->excel->setActiveSheetIndex(1)->setCellValue('A5', 'NO');
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A5:A5');
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('B5', 'NAMA KEGIATAN');
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('B5:B5');
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('C5', 'DESKRIPSI');
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('C5:C5');
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('D5', 'TANGGAL KEGIATAN');
				$this->excel->setActiveSheetIndex(1)->getStyle('D5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('D5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('D5:D5');
				$this->excel->getActiveSheet(1)->getStyle('D5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('D5:D5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('E5', 'WAKTU');
				$this->excel->setActiveSheetIndex(1)->getStyle('E5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('E5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('E5:E5');
				$this->excel->getActiveSheet(1)->getStyle('E5:E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('E5:E5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('F5', 'KETUA PELAKSANA');
				$this->excel->setActiveSheetIndex(1)->getStyle('F5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('F5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('F5:F5');
				$this->excel->getActiveSheet(1)->getStyle('F5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('F5:F5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('G5', 'KAPASITAS');
				$this->excel->setActiveSheetIndex(1)->getStyle('G5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('G5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('G5:G5');
				$this->excel->getActiveSheet(1)->getStyle('G5:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('G5:G5')->applyFromArray($styleArray);


				$cek 	= $this->m_excel->query($type);

				$i = 6;
				if (!empty($cek)) {
					$no = 1;
					foreach ($cek as $data) {
						$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, $no++);
						$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':A' . $i);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('B' . $i, $data->nama_kegiatan);
						$this->excel->setActiveSheetIndex(1)->getStyle('B' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('B' . $i . ':B' . $i);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('C' . $i, $data->deskripsi);
						$this->excel->setActiveSheetIndex(1)->getStyle('C' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('C' . $i . ':C' . $i);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('D' . $i, $data->tgl_kegiatan);
						$this->excel->setActiveSheetIndex(1)->getStyle('D' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('D' . $i . ':D' . $i);
						$this->excel->getActiveSheet(1)->getStyle('D' . $i . ':D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('D' . $i . ':D' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('E' . $i, $data->durasi);
						$this->excel->setActiveSheetIndex(1)->getStyle('E' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('E' . $i . ':E' . $i);
						$this->excel->getActiveSheet(1)->getStyle('E' . $i . ':E' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('F' . $i, $data->ketua_panitia);
						$this->excel->setActiveSheetIndex(1)->getStyle('F' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('F' . $i . ':F' . $i);
						$this->excel->getActiveSheet(1)->getStyle('F' . $i . ':F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('F' . $i . ':F' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('G' . $i, $data->jml_slot);
						$this->excel->setActiveSheetIndex(1)->getStyle('G' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('G' . $i . ':G' . $i);
						$this->excel->getActiveSheet(1)->getStyle('G' . $i . ':G' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('G' . $i . ':G' . $i)->applyFromArray($styleArray);



						$i++;
					}
				} else {
					$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, "Data Tidak Ditemukan");
					$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
					$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':G' . $i);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':G' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':G' . $i)->applyFromArray($styleArray);
				}


				$sheet = $this->excel->getIndex(
					$this->excel->getSheetByName('Worksheet')
				);
				$this->excel->removeSheetByIndex($sheet);
				$this->excel->setActiveSheetIndex(0);
				$filename = "LAPORAN_DATA_LIST_KEGIATAN" . '_' . time() . ".xls";
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				ob_end_clean();
				ob_start();
				$objWriter->save('php://output');

				break;

			case 'data_list_jadwal':

				$this->load->library('excel');

				$styleArray = array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					)
				);
				$this->excel->createSheet();

				$this->excel->setActiveSheetIndex(1)->setCellValue('A2', 'DATA LIST JADWAL');
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setSize(16);
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A2:I2');
				$this->excel->getActiveSheet(1)->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$this->excel->getActiveSheet(1)->getColumnDimension('A')->setWidth(5);
				$this->excel->getActiveSheet(1)->getColumnDimension('B')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('C')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('D')->setWidth(35);
				$this->excel->getActiveSheet(1)->getColumnDimension('E')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('F')->setWidth(25);

				$this->excel->setActiveSheetIndex(1)->setCellValue('A5', 'NO');
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A5:A5');
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('B5', 'NAMA KEGIATAN');
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('B5:B5');
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('C5', 'TANGGAL KEGIATAN');
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('C5:C5');
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('D5', 'WAKTU');
				$this->excel->setActiveSheetIndex(1)->getStyle('D5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('D5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('D5:D5');
				$this->excel->getActiveSheet(1)->getStyle('D5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('D5:D5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('E5', 'KETUA PELAKSANA');
				$this->excel->setActiveSheetIndex(1)->getStyle('E5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('E5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('E5:E5');
				$this->excel->getActiveSheet(1)->getStyle('E5:E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('E5:E5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('F5', 'KAPASITAS TERSEDIA');
				$this->excel->setActiveSheetIndex(1)->getStyle('F5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('F5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('F5:F5');
				$this->excel->getActiveSheet(1)->getStyle('F5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('F5:F5')->applyFromArray($styleArray);


				$cek 	= $this->m_excel->query($type);

				$i = 6;
				if (!empty($cek)) {
					$no = 1;
					foreach ($cek as $data) {
						$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, $no++);
						$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':A' . $i);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('B' . $i, $data->nama_kegiatan);
						$this->excel->setActiveSheetIndex(1)->getStyle('B' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('B' . $i . ':B' . $i);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('C' . $i, $data->tgl_kegiatan);
						$this->excel->setActiveSheetIndex(1)->getStyle('C' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('C' . $i . ':C' . $i);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('D' . $i, $data->durasi);
						$this->excel->setActiveSheetIndex(1)->getStyle('D' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('D' . $i . ':D' . $i);
						$this->excel->getActiveSheet(1)->getStyle('D' . $i . ':D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('D' . $i . ':D' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('E' . $i, $data->ketua_panitia);
						$this->excel->setActiveSheetIndex(1)->getStyle('E' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('E' . $i . ':E' . $i);
						$this->excel->getActiveSheet(1)->getStyle('E' . $i . ':E' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('F' . $i, $data->jml_slot);
						$this->excel->setActiveSheetIndex(1)->getStyle('F' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('F' . $i . ':F' . $i);
						$this->excel->getActiveSheet(1)->getStyle('F' . $i . ':F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('F' . $i . ':F' . $i)->applyFromArray($styleArray);



						$i++;
					}
				} else {
					$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, "Data Tidak Ditemukan");
					$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
					$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':F' . $i);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':F' . $i)->applyFromArray($styleArray);
				}


				$sheet = $this->excel->getIndex(
					$this->excel->getSheetByName('Worksheet')
				);
				$this->excel->removeSheetByIndex($sheet);
				$this->excel->setActiveSheetIndex(0);
				$filename = "LAPORAN_DATA_LIST_JADWAL" . '_' . time() . ".xls";
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				ob_end_clean();
				ob_start();
				$objWriter->save('php://output');

				break;

			case 'data_list_pengumuman':

				$this->load->library('excel');

				$styleArray = array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					)
				);
				$this->excel->createSheet();

				$this->excel->setActiveSheetIndex(1)->setCellValue('A2', 'DATA LIST PENGUMUMAN');
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setSize(16);
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A2:I2');
				$this->excel->getActiveSheet(1)->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$this->excel->getActiveSheet(1)->getColumnDimension('A')->setWidth(5);
				$this->excel->getActiveSheet(1)->getColumnDimension('B')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('C')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('D')->setWidth(35);
				$this->excel->getActiveSheet(1)->getColumnDimension('E')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('F')->setWidth(25);

				$this->excel->setActiveSheetIndex(1)->setCellValue('A5', 'NO');
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A5:A5');
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('B5', 'JUDUL');
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('B5:B5');
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('C5', 'HEADLINE BERITA');
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('C5:C5');
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('D5', 'ISI BERITA');
				$this->excel->setActiveSheetIndex(1)->getStyle('D5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('D5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('D5:D5');
				$this->excel->getActiveSheet(1)->getStyle('D5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('D5:D5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('E5', 'TANGGAL POSTING');
				$this->excel->setActiveSheetIndex(1)->getStyle('E5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('E5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('E5:E5');
				$this->excel->getActiveSheet(1)->getStyle('E5:E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('E5:E5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('F5', 'KETERANGAN');
				$this->excel->setActiveSheetIndex(1)->getStyle('F5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('F5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('F5:F5');
				$this->excel->getActiveSheet(1)->getStyle('F5:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('F5:F5')->applyFromArray($styleArray);


				$cek 	= $this->m_excel->query($type);

				$i = 6;
				if (!empty($cek)) {
					$no = 1;
					foreach ($cek as $data) {
						$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, $no++);
						$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':A' . $i);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('B' . $i, $data->judul);
						$this->excel->setActiveSheetIndex(1)->getStyle('B' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('B' . $i . ':B' . $i);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('C' . $i, $data->headline_berita);
						$this->excel->setActiveSheetIndex(1)->getStyle('C' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('C' . $i . ':C' . $i);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('D' . $i, $data->isi_berita);
						$this->excel->setActiveSheetIndex(1)->getStyle('D' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('D' . $i . ':D' . $i);
						$this->excel->getActiveSheet(1)->getStyle('D' . $i . ':D' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('D' . $i . ':D' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('E' . $i, $data->tgl_posting);
						$this->excel->setActiveSheetIndex(1)->getStyle('E' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('E' . $i . ':E' . $i);
						$this->excel->getActiveSheet(1)->getStyle('E' . $i . ':E' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('F' . $i, $data->keterangan);
						$this->excel->setActiveSheetIndex(1)->getStyle('F' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('F' . $i . ':F' . $i);
						$this->excel->getActiveSheet(1)->getStyle('F' . $i . ':F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('F' . $i . ':F' . $i)->applyFromArray($styleArray);



						$i++;
					}
				} else {
					$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, "Data Tidak Ditemukan");
					$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
					$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':F' . $i);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':F' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':F' . $i)->applyFromArray($styleArray);
				}


				$sheet = $this->excel->getIndex(
					$this->excel->getSheetByName('Worksheet')
				);
				$this->excel->removeSheetByIndex($sheet);
				$this->excel->setActiveSheetIndex(0);
				$filename = "LAPORAN_DATA_LIST_PENGUMUMAN" . '_' . time() . ".xls";
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				ob_end_clean();
				ob_start();
				$objWriter->save('php://output');

				break;

			case 'data_list_sertif':

				$this->load->library('excel');

				$styleArray = array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					)
				);
				$this->excel->createSheet();

				$this->excel->setActiveSheetIndex(1)->setCellValue('A2', 'DATA LIST SERTIFIKAT');
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setSize(16);
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A2:I2');
				$this->excel->getActiveSheet(1)->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$this->excel->getActiveSheet(1)->getColumnDimension('A')->setWidth(5);
				$this->excel->getActiveSheet(1)->getColumnDimension('B')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('C')->setWidth(25);

				$this->excel->setActiveSheetIndex(1)->setCellValue('A5', 'NO');
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A5:A5');
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('B5', 'KETERANGAN FILE');
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('B5:B5');
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('C5', 'EKSTENSI');
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('C5:C5');
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->applyFromArray($styleArray);


				$cek 	= $this->m_excel->query($type);

				$i = 6;
				if (!empty($cek)) {
					$no = 1;
					foreach ($cek as $data) {
						$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, $no++);
						$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':A' . $i);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('B' . $i, $data->keterangan_file);
						$this->excel->setActiveSheetIndex(1)->getStyle('B' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('B' . $i . ':B' . $i);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('C' . $i, $data->ekstensi);
						$this->excel->setActiveSheetIndex(1)->getStyle('C' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('C' . $i . ':C' . $i);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->applyFromArray($styleArray);



						$i++;
					}
				} else {
					$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, "Data Tidak Ditemukan");
					$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
					$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':C' . $i);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':C' . $i)->applyFromArray($styleArray);
				}


				$sheet = $this->excel->getIndex(
					$this->excel->getSheetByName('Worksheet')
				);
				$this->excel->removeSheetByIndex($sheet);
				$this->excel->setActiveSheetIndex(0);
				$filename = "LAPORAN_DATA_LIST_SERTIFIKAT" . '_' . time() . ".xls";
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				ob_end_clean();
				ob_start();
				$objWriter->save('php://output');

				break;

			case 'data_list_pengajuan':

				$this->load->library('excel');

				$styleArray = array(
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					)
				);
				$this->excel->createSheet();

				$this->excel->setActiveSheetIndex(1)->setCellValue('A2', 'DATA LIST PENGAJUAN FORM NILAI');
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setSize(16);
				$this->excel->setActiveSheetIndex(1)->getStyle('A2')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A2:I2');
				$this->excel->getActiveSheet(1)->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$this->excel->getActiveSheet(1)->getColumnDimension('A')->setWidth(5);
				$this->excel->getActiveSheet(1)->getColumnDimension('B')->setWidth(25);
				$this->excel->getActiveSheet(1)->getColumnDimension('C')->setWidth(25);

				$this->excel->setActiveSheetIndex(1)->setCellValue('A5', 'NO');
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('A5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('A5:A5');
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('A5:A5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('B5', 'TUJUAN');
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('B5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('B5:B5');
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('B5:B5')->applyFromArray($styleArray);

				$this->excel->setActiveSheetIndex(1)->setCellValue('C5', 'TANGGAL PENGAJUAN');
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setSize(12);
				$this->excel->setActiveSheetIndex(1)->getStyle('C5')->getFont()->setBold(true);
				$this->excel->setActiveSheetIndex(1)->mergeCells('C5:C5');
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet(1)->getStyle('C5:C5')->applyFromArray($styleArray);


				$cek 	= $this->m_excel->query($type);

				$i = 6;
				if (!empty($cek)) {
					$no = 1;
					foreach ($cek as $data) {
						$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, $no++);
						$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':A' . $i);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':A' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('B' . $i, $data->tujuan);
						$this->excel->setActiveSheetIndex(1)->getStyle('B' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('B' . $i . ':B' . $i);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('B' . $i . ':B' . $i)->applyFromArray($styleArray);

						$this->excel->setActiveSheetIndex(1)->setCellValue('C' . $i, $data->cdd);
						$this->excel->setActiveSheetIndex(1)->getStyle('C' . $i)->getFont()->setSize(12);
						$this->excel->setActiveSheetIndex(1)->mergeCells('C' . $i . ':C' . $i);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$this->excel->getActiveSheet(1)->getStyle('C' . $i . ':C' . $i)->applyFromArray($styleArray);



						$i++;
					}
				} else {
					$this->excel->setActiveSheetIndex(1)->setCellValue('A' . $i, "Data Tidak Ditemukan");
					$this->excel->setActiveSheetIndex(1)->getStyle('A' . $i)->getFont()->setSize(12);
					$this->excel->setActiveSheetIndex(1)->mergeCells('A' . $i . ':C' . $i);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':C' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excel->getActiveSheet(1)->getStyle('A' . $i . ':C' . $i)->applyFromArray($styleArray);
				}


				$sheet = $this->excel->getIndex(
					$this->excel->getSheetByName('Worksheet')
				);
				$this->excel->removeSheetByIndex($sheet);
				$this->excel->setActiveSheetIndex(0);
				$filename = "LAPORAN_DATA_LIST_PENGAJUAN_FORM_NILAI" . '_' . time() . ".xls";
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
				header('Cache-Control: max-age=0');
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
				//force user to download the Excel file without writing it to server's HD
				ob_end_clean();
				ob_start();
				$objWriter->save('php://output');

				break;
			default:
				# code...
				break;
		}
	}
}
