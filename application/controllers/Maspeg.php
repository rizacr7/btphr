<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maspeg extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('master_model','pegawai');
		$this->load->model('func_global');
    }

	function get_nopeg(){
		$param = array();
		$param['tanggal'] = $this->func_global->tgl_dsql($_POST['tgl_masuk']);
		$param['status_peg'] = $_POST['status_peg'];
			
		$kodebukti = $this->master_model->get_nopegawai($param);
		echo $kodebukti;
	}

	public function simpanpegawai() {
		$username = $this->session->userdata('username');
		$data = $this->input->post();

		// Validasi backend (antisipasi bypass JS)
		if (empty($data['na_peg']) || empty($data['tgl_masuk']) || empty($data['alamat'])) {
		echo json_encode(['status' => false, 'message' => 'Data wajib diisi lengkap.']);
		return;
		}

		if (!empty($data['no_ktp']) && strlen($data['no_ktp']) != 16) {
		echo json_encode(['status' => false, 'message' => 'Nomor KTP harus 16 digit.']);
		return;
		}

		if (!empty($data['npwp']) && strlen($data['npwp']) != 16) {
		echo json_encode(['status' => false, 'message' => 'Nomor NPWP harus 16 digit.']);
		return;
		}

		$data = [
			'tgl_masuk'      => $this->func_global->tgl_dsql($this->input->post('tgl_masuk')),
			'na_peg'         => $this->input->post('na_peg'),
			'no_peg'         => $this->input->post('no_peg'),
			'status_peg'     => $this->input->post('status_peg'),
			'alamat'         => $this->input->post('alamat'),
			'alamat_dms'     => $this->input->post('alamat_dms'),
			'tmpt_lahir'     => $this->input->post('tmpt_lahir'),
			'tgl_lahir'      => $this->func_global->tgl_dsql($this->input->post('tgl_lahir')),
			'kd_leveljab'    => $this->input->post('kd_leveljab'),
			'kd_prsh'        => 'P01',
			'no_ktp'         => $this->input->post('no_ktp'),
			'sex'            => $this->input->post('jns_kel'),
			'pendidikan'     => $this->input->post('pendidikan'),
			'ket_pendidikan' => $this->input->post('ket_pendidikan'),
			'npwp'           => $this->input->post('npwp'),
			'no_rek'         => $this->input->post('no_rek'),
			'bank'           => $this->input->post('bank'),
			'no_hp'          => $this->input->post('no_hp'),
			'nm_ibu'         => $this->input->post('nm_ibu'),
			'agama'          => $this->input->post('agama'),
			'kawin'          => $this->input->post('kawin'),
			'kd_leveljab'    => $this->input->post('kd_leveljab'),
			'tgl_kontrak'    => $this->func_global->tgl_dsql($this->input->post('tgl_kontrak')),
			'tgl_akhir'      => $this->func_global->tgl_dsql($this->input->post('tgl_akhir_kontrak')),
			'status_pajak'   => $this->input->post('status_pajak'),
			'user'           => $username,
			'tgl_update'     => date('Y-m-d H:i:s')
		];


		// --- CEK DUPLIKAT NOMOR PEGAWAI ---
		$cek = $this->db->get_where('mas_peg', ['no_peg' => $data['no_peg']])->num_rows();
		if ($cek > 0) {
		echo json_encode(['status' => false, 'message' => 'Nomor Pegawai sudah terdaftar, gunakan nomor lain.']);
		return;
		}

		// Simpan ke database
		$this->db->insert('mas_peg', $data);
		echo json_encode(['status' => true, 'message' => 'Data berhasil disimpan.']);
	
	}

	public function get_data_pegawai() {
		$list = $this->pegawai->get_datatables();
		$data = [];
		$no = $_POST['start'];

		foreach ($list as $row) {
		$no++;
		$aksi = '
			<button class="btn btn-sm btn-warning" onclick="editPegawai(\''.$row->no_peg.'\')">Edit</button>
			<button class="btn btn-sm btn-danger" onclick="hapusPegawai(\''.$row->no_peg.'\')">Hapus</button>
		';

		$data[] = [
			$no,
			$row->no_peg,
			$row->na_peg,
			$row->nm_statuspeg,
			$row->nm_jab,
			$row->level,
			$row->tgl_masuk,
			$row->alamat,
			$row->no_ktp,
			$row->sex,
			$row->tmpt_lahir,
			$row->tgl_lahir,
			$row->no_hp,
			$aksi
		];
		}

		$output = [
		"draw" => $_POST['draw'],
		"recordsTotal" => $this->pegawai->count_all(),
		"recordsFiltered" => $this->pegawai->count_filtered(),
		"data" => $data,
		];
		echo json_encode($output);
	}

	public function delete($no_peg)
	{
		// Pastikan hanya bisa diakses lewat AJAX
		if ($this->input->is_ajax_request()) {

			$this->db->where('no_peg', $no_peg);
			$update = $this->db->update('mas_peg', [
				'is_del' => 1,
				'flag_keluar' => 1,
				'tgl_hapus' => date('Y-m-d H:i:s')
			]);

			if ($update) {
				$response = [
					'status' => true,
					'message' => 'Data pegawai berhasil dihapus.'
				];
			} else {
				$response = [
					'status' => false,
					'message' => 'Gagal menghapus data pegawai.'
				];
			}

			echo json_encode($response);
		} else {
			show_error('Akses tidak diizinkan', 403);
		}
	}
}
