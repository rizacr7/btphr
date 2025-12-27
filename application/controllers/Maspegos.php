<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maspegos extends CI_Controller {

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
        $this->load->model('os_model');
		$this->load->model('func_global');
		$this->db_hrd20 = $this->load->database("hrd20", TRUE);

		if($this->session->userdata('role') == ""){
			redirect('Welcome/index');
		}
    }

    function pegawaios(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
		$data['status_pajak'] = $this->os_model->get_status_pajak();
        $this->load->view('master/data_pegawai_os',$data);
        $this->load->view('general/footer');
    }

	function pengajuanos(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('approval/approval_os');
        $this->load->view('general/footer');
    }


	function tab_pegawai_os() {
        echo "<table id='table_pegawai_os' class='table table-bordered dt-responsive table-head-bg-primary table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>No.Pegawai</th>
				<th>Nama Pegawai</th>
				<th>Bagian</th>
				<th>Unit</th>
				<th>Alamat</th>
				<th>No.KTP</th>
				<th>Jabatan</th>
				<th>Jenis Kelamin</th>
				<th>Tgl.Masuk</th>
				<th>Tgl.Lahir</th>
				<th>Level</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->os_model->get_data_pegawaios("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
            echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value['id_pegawai'] . "</td>
				<td>" . $value['no_peg'] . "</td>
				<td>" . $value['na_peg'] . "</td>
				<td>" . $value['nm_bagian'] . "</td>
				<td>" . $value['nm_unit'] . "</td>
				<td>" . $value['alamat'] . "</td>
				<td>" . $value['no_ktp'] . "</td>
				<td>" . $value['nm_jab'] . "</td>
				<td>" . $value['sex'] . "</td>
				<td>" . $value['tgl_masuk'] . "</td>
				<td>" . $value['tgl_lahir'] . "</td>
				<td>" . $value['ket_level'] . "</td>
			</tr>";
            $no++;
        }

        echo "</tbody>
		</table>
		<style>
			.selected td {
				background-color: #c6ccdcff; !important;
			}
		</style>
		<script>
			$('#table_pegawai_os').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
    }

	function tab_pengajuan_os() {
        echo "<table id='table_pegawai' class='table table-bordered dt-responsive table-head-bg-primary table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>No.Pegawai</th>
				<th>Nama Pegawai</th>
				<th>Bagian</th>
				<th>Unit</th>
				<th>Alamat</th>
				<th>No.KTP</th>
				<th>Jabatan</th>
				<th>Jenis Kelamin</th>
				<th>Tgl.Masuk</th>
				<th>Tgl.Lahir</th>
				<th>Level</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->os_model->get_data_pengajuanos("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
            echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value['id_pegawai'] . "</td>
				<td>" . $value['no_peg'] . "</td>
				<td>" . $value['na_peg'] . "</td>
				<td>" . $value['nm_bagian'] . "</td>
				<td>" . $value['nm_unit'] . "</td>
				<td>" . $value['alamat'] . "</td>
				<td>" . $value['no_ktp'] . "</td>
				<td>" . $value['nm_jab'] . "</td>
				<td>" . $value['sex'] . "</td>
				<td>" . $value['tgl_masuk'] . "</td>
				<td>" . $value['tgl_lahir'] . "</td>
				<td>" . $value['ket_level'] . "</td>
			</tr>";
            $no++;
        }

        echo "</tbody>
		</table>
		<style>
			.selected td {
				background-color: #c6ccdcff; !important;
			}
		</style>
		<script>
			$('#table_pegawai').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
    }

	function get_pegawai_os(){
		$id_pegawai = $this->input->post('id_pegawai');
		$data_pegawai = $this->os_model->get_pegawai_os_by_id($id_pegawai);

		echo json_encode($data_pegawai);
	}
	function simpan_data_os() {
		$username = $this->session->userdata('username');
		$data = $this->input->post();

		// Validasi backend (antisipasi bypass JS)
		if (empty($data['no_peg']) || empty($data['na_peg']) || empty($data['tgl_masuk'])) {
			echo json_encode(['status' => false, 'message' => 'Data wajib diisi lengkap.']);
			return;
		}

		if ($data['id_pegawai'] == '') {
			$insert_data = [
				'no_peg'      => $this->input->post('no_peg'),
				'na_peg'      => $this->input->post('na_peg'),
				'tgl_masuk'   => $this->func_global->tgl_dsql($this->input->post('tgl_masuk')),
				'alamat'      => $this->input->post('alamat'),
				'no_ktp'      => $this->input->post('no_ktp'),
				'kd_level'    => $this->input->post('kd_level'),
				'kd_perusahaan' => $this->input->post('kd_perusahaan'),
				'kd_unit'     => $this->input->post('kd_unit'),
				'tgl_lahir'   => $this->func_global->tgl_dsql($this->input->post('tgl_lahir')),
				'tmpt_lahir'  => $this->input->post('tmpt_lahir'),
				'sex'     => $this->input->post('jns_kel'),
				'status_pajak' => $this->input->post('status_pajak'),
				'email'       => $this->input->post('email'),
				'no_rek'       => $this->input->post('no_rek'),
				'pendidikan'       => $this->input->post('pendidikan'),
				'ket_pendidikan'       => $this->input->post('ket_pendidikan'),
				'kd_jab'       => '106',
				'kd_golongan'  => '000',
				'status_peg'   => '07',
				'tgl_kontrak' => $this->func_global->tgl_dsql($this->input->post('tgl_kontrak')),
				'tgl_akhir' => $this->func_global->tgl_dsql($this->input->post('tgl_akhir_kontrak')),
				'npwp'        => $this->input->post('npwp'),
				'tgl_update'   => date("Y-m-d H:i:s")
			];
            // Simpan data baru
            $result = $this->os_model->simpan_pegawai_os($insert_data);
        } else {
			$insert_data = [
				'no_peg'      => $this->input->post('no_peg'),
				'na_peg'      => $this->input->post('na_peg'),
				'tgl_masuk'   => $this->func_global->tgl_dsql($this->input->post('tgl_masuk')),
				'alamat'      => $this->input->post('alamat'),
				'no_ktp'      => $this->input->post('no_ktp'),
				'kd_level'    => $this->input->post('kd_level'),
				'kd_unit'     => $this->input->post('kd_unit'),
				'tgl_lahir'   => $this->func_global->tgl_dsql($this->input->post('tgl_lahir')),
				'tmpt_lahir'  => $this->input->post('tmpt_lahir'),
				'sex'     => $this->input->post('jns_kel'),
				'status_pajak' => $this->input->post('status_pajak'),
				'email'       => $this->input->post('email'),
				'no_rek'       => $this->input->post('no_rek'),
				'pendidikan'       => $this->input->post('pendidikan'),
				'ket_pendidikan'       => $this->input->post('ket_pendidikan'),
				'kd_jab'       => '106',
				'kd_golongan'  => '000',
				'status_peg'   => '07',
				'tgl_kontrak' => $this->func_global->tgl_dsql($this->input->post('tgl_kontrak')),
				'tgl_akhir' => $this->func_global->tgl_dsql($this->input->post('tgl_akhir_kontrak')),
				'npwp'        => $this->input->post('npwp'),
				'tgl_update'   => date("Y-m-d H:i:s")
			];
            // Update data
            $result = $this->update_pegawai_os($data['id_pegawai'], $insert_data);
        }

        if ($result) {
			echo 1;
		} else {
			echo 2;
		}		
    }

	function update_pegawai_os($id_pegawai, $data) {
		$this->db_hrd20->where('id_pegawai', $id_pegawai);
		return $this->db_hrd20->update('mas_peg', $data);
	}

	function hapus_pengajuan_os() {
		$id_pegawai = $this->input->post('id_pegawai');

		// Hapus data dari database
		$this->db_hrd20->where('id_pegawai', $id_pegawai);
		$this->db_hrd20->update('mas_peg_pengajuan', ['is_del' => 1]);

		echo json_encode(['status' => true, 'message' => 'Data berhasil dihapus.']);
	}
}