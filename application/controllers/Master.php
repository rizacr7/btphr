<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {

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
        $this->load->model('master_model');
		$this->load->model('func_global');

		if($this->session->userdata('role') == ""){
			redirect('Welcome/index');
		}
    }

    function masterjabatan(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('master/mst_jabatan');
        $this->load->view('general/footer');
    }

	function masterstatuspegawai(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('master/mst_statuspegawai');
        $this->load->view('general/footer');
    }

	function masterleveljab(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('master/mst_leveljab');
        $this->load->view('general/footer');
    }

	function masterpegawai(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('master/mst_pegawai');
        $this->load->view('general/footer');
    }

	function datapegawai(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('master/data_pegawai');
        $this->load->view('general/footer');
    }

    function tab_jabatan(){
        echo "<table id='table_jabatan' class='table table-bordered dt-responsive table-head-bg-primary table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>Kode Jabatan</th>
				<th>Nama Jabatan</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->master_model->get_data_jabatan("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
            echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value['id_jab'] . "</td>
				<td>" . $value['kd_jab'] . "</td>
				<td>" . $value['nm_jab'] . "</td>
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
			$('#table_jabatan').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
    }

	function tab_statuspegawai(){
        echo "<table id='table_statuspeg' class='table table-bordered dt-responsive table-head-bg-primary table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>Kode Status</th>
				<th>Nama Status Pegawai</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->master_model->get_data_statuspeg("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
            echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value['id_statuspeg'] . "</td>
				<td>" . $value['kd_statuspeg'] . "</td>
				<td>" . $value['nm_statuspeg'] . "</td>
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
			$('#table_statuspeg').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
    }

	function tab_leveljab(){
        echo "<table id='table_leveljab' class='table table-bordered dt-responsive table-head-bg-primary table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>Kode Level Jabatan</th>
				<th>Jabatan</th>
				<th>Level</th>
				<th>Gapok</th>
				<th>Tj.Jabatan</th>
				<th>Tj.Komunikasi</th>
				<th>Tj.Transport</th>
				<th>Tj.Konsumsi</th>
				<th>Tj.Kinerja</th>
				<th>Tj.Lembur</th>
				<th>Tj.HR</th>
				<th>Tj.Kehadiran</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->master_model->get_data_leveljabatan("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
            echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value['id_leveljab'] . "</td>
				<td>" . $value['kd_leveljab'] . "</td>
				<td>" . $value['nm_jab'] . "</td>
				<td>" . $value['level'] . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['gapok']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_jabatan']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_komunikasi']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_transport']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_konsumsi']) . "</td>

				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_kinerja']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_lembur']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_hr']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_kehadiran']) . "</td>
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
			$('#table_leveljab').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
    }


	function simpan_jabatan() {
		$id_jab = $this->input->post('id_jab');
		$nm_jab = $this->input->post('nm_jab');

		$param = array(
			'nm_jab' => $nm_jab,
			'id_jab' => $id_jab
		);

		if ($id_jab == "") {
			//--cek kd jab ---
			$this->master_model->insert_jabatan($param);
			echo "success";
			
		} else {
			// update
			$this->master_model->update_jabatan($param);
			echo "success";
		}
	}

	function hapus_jabatan() {
		$id_jab = $this->input->post('id_jab');

		$this->db->where('id_jab', $id_jab);
		$this->db->delete('m_jabatan');

		echo "Data berhasil dihapus.";
	}


	function simpan_statuspeg() {
		$id_statuspeg = $this->input->post('id_statuspeg');
		$nm_statuspeg = $this->input->post('nm_statuspeg');

		$param = array(
			'nm_statuspeg' => $nm_statuspeg,
			'id_statuspeg' => $id_statuspeg
		);

		if ($id_statuspeg == "") {
			//--cek kd jab ---
			$this->master_model->insert_statuspeg($param);
			echo "success";
			
		} else {
			// update
			$this->master_model->update_statuspeg($param);
			echo "success";
		}
	}

	function hapus_statuspeg() {
		$id_statuspeg = $this->input->post('id_statuspeg');

		$this->db->where('id_statuspeg', $id_statuspeg);
		$this->db->delete('m_statuspeg');

		echo "Data berhasil dihapus.";
	}
	
	function simpan_leveljab(){
		$id_leveljab = $this->input->post('id_leveljab');
		$kd_jab = $this->input->post('kd_jab');
		$level = $this->input->post('level');
		$gapok = $this->input->post('gapok');

		$tj_jabatan = $this->input->post('tj_jabatan');
		$tj_transport = $this->input->post('tj_transport');
		$tj_komunikasi = $this->input->post('tj_komunikasi');
		$tj_konsumsi = $this->input->post('tj_konsumsi');

		$tj_kinerja = $this->input->post('tj_kinerja');
		$tj_lembur = $this->input->post('tj_lembur');
		$tj_hr = $this->input->post('tj_hr');
		$tj_kehadiran = $this->input->post('tj_kehadiran');

		if($id_leveljab == ""){
			$kd_leveljab = $kd_jab.".".$level;
			//--- insert data ---
			$cekData = "SELECT * FROM m_level_jabatan WHERE kd_leveljab = '$kd_leveljab' AND is_del = 0";
			$row = $this->db->query($cekData)->num_rows();
			if($row > 0){
				echo "400";
			}
			else{
				$param = array(
					'kd_leveljab' => $kd_leveljab,
					'kd_jab' => $kd_jab,
					'level' => $level,
					'gapok' => $this->func_global->rupiah($gapok),
					'tj_jabatan' => $this->func_global->rupiah($tj_jabatan),
					'tj_transport' => $this->func_global->rupiah($tj_transport),
					'tj_komunikasi' => $this->func_global->rupiah($tj_komunikasi),
					'tj_konsumsi' => $this->func_global->rupiah($tj_konsumsi),
					'tj_kinerja' => $this->func_global->rupiah($tj_kinerja),
					'tj_lembur' => $this->func_global->rupiah($tj_lembur),
					'tj_hr' => $this->func_global->rupiah($tj_hr),
					'tj_kehadiran' => $this->func_global->rupiah($tj_kehadiran),
				);
				$this->master_model->insert_leveljab($param);
				echo "success";
			}
		}
		else{
			//---update data --
			$param = array(
				'id_leveljab' => $id_leveljab,
				'gapok' => $this->func_global->rupiah($gapok),
				'tj_jabatan' => $this->func_global->rupiah($tj_jabatan),
				'tj_transport' => $this->func_global->rupiah($tj_transport),
				'tj_komunikasi' => $this->func_global->rupiah($tj_komunikasi),
				'tj_konsumsi' => $this->func_global->rupiah($tj_konsumsi),
				'tj_kinerja' => $this->func_global->rupiah($tj_kinerja),
				'tj_lembur' => $this->func_global->rupiah($tj_lembur),
				'tj_hr' => $this->func_global->rupiah($tj_hr),
				'tj_kehadiran' => $this->func_global->rupiah($tj_kehadiran),
			);
			$this->master_model->update_leveljab($param);
			echo "success";
		}

	}

	function ajaxdtleveljab() {
		$id_leveljab = $this->input->get('id_leveljab');
		$query = "SELECT a.*,b.nm_jab,
		REPLACE(FORMAT(a.gapok, 0), ',', '.')AS gaji,
		REPLACE(FORMAT(a.tj_jabatan, 0), ',', '.')AS tjjabatan,
		REPLACE(FORMAT(a.tj_komunikasi, 0), ',', '.')AS tjkomunikasi,
		REPLACE(FORMAT(a.tj_transport, 0), ',', '.')AS tjtransport,
		REPLACE(FORMAT(a.tj_konsumsi, 0), ',', '.')AS tjkonsumsi,
		REPLACE(FORMAT(a.`tj_kinerja`, 0), ',', '.')AS tjkinerja,
		REPLACE(FORMAT(a.tj_kehadiran, 0), ',', '.')AS tjkehadiran,
		REPLACE(FORMAT(a.tj_lembur, 0), ',', '.')AS tjlembur,
		REPLACE(FORMAT(a.tj_hr, 0), ',', '.')AS tjhr
		FROM m_level_jabatan a LEFT JOIN m_jabatan b ON a.kd_jab = b.kd_jab WHERE id_leveljab = '".$id_leveljab."'";
		$data = $this->db->query($query)->row();
		echo json_encode($data);
	}

	function hapus_leveljabatan(){
		$id_leveljab = $_POST['id_leveljab'];
		$today = date("Y-m-d");

		$data = array(
			'is_del' => 1,
			'tgl_hapus' => $today
		);
		$this->db->where('id_leveljab', $id_leveljab);
		$this->db->update('m_level_jabatan', $data);
		echo "success";
	}

}
