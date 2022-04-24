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
		$sort     = isset($_POST['columns'][$_POST['order'][0]['column']]['data']) ? strval($_POST['columns'][$_POST['order'][0]['column']]['data']) : 'nama';
		$order    = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
		$filter   = @$_POST['filter'];
		$no = $this->input->post('start');

		switch ($type) {
			case 'data_list_pengurus':
				$list = $this->m_table->get_datatables('data_list_pengurus', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;
					$l->ttl = $l->tempat_tgl_lahir;
					$l->aksi = "
					<div class='btn-group' role='group' aria-label='...'>
						<button type='button' class='btn btn-info' title='Detail Data' onclick='detail(" . $l->id_pengurus	. ")'>
							<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span>
						</button>
						<button type='button' class='btn btn-success' title='Edit Data' data-href='" . $l->id_pengurus	. "' data-toggle='modal' data-target='#m_edit'>
							<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
						</button>
						<button type='button' class='btn btn-danger' title='Delete Data' onclick='confirm_del(" . $l->id_pengurus . ")'>
							<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
						</button>
					</div>";

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
						<div class='btn-group' role='group' aria-label='...'>
							<button type='button' class='btn btn-info' title='Detail Data' onclick='detail(" . $l->id_user	. ")'>
								<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span>
							</button>
							<button type='button' class='btn btn-success' title='Edit Data' data-href='" . $l->id_mhs	. "' data-toggle='modal' data-target='#m_edit'>
								<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
							</button>
						</div>";

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
			case 'data_list_kegiatan':
				$list = $this->m_table->get_datatables('data_list_kegiatan', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;
					$l->aksi = "
						<div class='btn-group' role='group' aria-label='...'>
							<button type='button' class='btn btn-info' title='Detail Data' onclick='detail(" . $l->id_kegiatan	. ")'>
								<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span>
							</button>
							<button type='button' class='btn btn-success' title='Edit Data' data-href='" . $l->id_kegiatan	. "' data-toggle='modal' data-target='#m_edit'>
								<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>
							</button>
							<button type='button' class='btn btn-danger' title='Delete Data' onclick='confirm_del(" . $l->id_kegiatan . ")'>
								<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
							</button>
						</div>";

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
					$no++;
					$l->no = $no;
					$l->aksi = "
							<div class='btn-group' role='group' aria-label='...'>
								<button type='button' class='btn btn-info' title='Detail Data' onclick='detail(" . $l->id_kegiatan	. ")'>
									<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span>
								</button>
							</div>";

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
			case 'data_list_pengajuan':
				$list = $this->m_table->get_datatables('data_list_pengajuan', $sort, $order);
				foreach ($list as $l) {
					$no++;
					$l->no = $no;
					$l->aksi = "
								<div class='btn-group' role='group' aria-label='...'>
									<button type='button' class='btn btn-info' title='Detail Form' onclick='detail(" . $l->id_form	. ")'>
										<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span>
									</button>
									<button type='button' class='btn btn-danger' title='Delete Data' onclick='confirm_del(" . $l->id_form . ")'>
								<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
							</button>
								</div>";

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
