<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends CI_Controller {

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
        $this->load->model('approve_model');
		$this->load->model('func_global');

		if($this->session->userdata('role') == ""){
			redirect('Welcome/index');
		}
    }

    function approve_data(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('approval/approval_dt');
        $this->load->view('general/footer');
    }

	function tab_approve(){
		echo "<table id='table_app' class='table table-bordered dt-responsive table-head-bg-danger table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th>Jenis</th>
				<th>Tgl.Proses</th>
				<th>Status</th>
				<th>Tgl.Approve</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
		$param = array();
		$param['bulan']  = $_POST['bulan'];
		$param['tahun']  = $_POST['tahun'];
        $data = $this->approve_model->get_data_app("", "", "", 0, 0,$param);
        foreach ($data->result_array() as $key => $value) {
			$kdjenis = $value['kd_jenis'];

			if($value['flag_app'] == 0){
				$status = "<span class='badge badge-warning'>Pending</span>";
				$button = "<button class='btn btn-icon btn-round btn-info' onclick='approvedt($kdjenis)'><i class='fas fa-check-square'></i></button>";
			}
			else{
				$status = "<span class='badge badge-success'>Approved</span>";
				$button = "<button class='btn btn-icon btn-round btn-warning' onclick='bataldt($kdjenis)'><i class='fas fa-history'></i></button>";
			}
			
            echo "
			<tr>
				<td>" . $no . "</td>
				<td>" . $value['nm_dokumen'] . "</td>
				<td>" . $this->func_global->dsql_tgl($value['tgl_proses']) . "</td>
				<td>" . $status . "</td>
				<td>" . $this->func_global->dsql_tgl($value['tgl_approval']) . "</td>
				<td style='text-align:center'>$button</td>
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
			$('#table_app').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
	}

	function approve_doc(){
		$username = $this->session->userdata('username');

		$kdjenis = $_POST['kdjenis'];
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];

		$data = array(
			'flag_app'=>1,
			'tgl_approval'=>date("Y-m-d"),
			'user_id' => $username,
		);
		$this->db->where('bulan',$bulan);
		$this->db->where('tahun',$tahun);
		$this->db->where('kd_jenis',$kdjenis);
		$this->db->update('approval_sdm',$data);

		if($kdjenis == 1){
			//--gaji pegawai--
			$data = array(
				'flag_close'=>1,
				'tgl_close'=>date("Y-m-d"),
			);
			$this->db->where('bulan',$bulan);
			$this->db->where('tahun',$tahun);
			$this->db->update('t_gaji',$data);
		}

		echo 1;
	}

	function batal_doc(){
		$username = $this->session->userdata('username');

		$kdjenis = $_POST['kdjenis'];
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];

		$data = array(
			'flag_app'=>0,
			'tgl_approval'=>null,
			'user_id' => null,
		);
		$this->db->where('bulan',$bulan);
		$this->db->where('tahun',$tahun);
		$this->db->where('kd_jenis',$kdjenis);
		$this->db->update('approval_sdm',$data);

		if($kdjenis == 1){
			//--gaji pegawai--
			$data = array(
				'flag_close'=>0,
				'tgl_close'=>null,
			);
			$this->db->where('bulan',$bulan);
			$this->db->where('tahun',$tahun);
			$this->db->update('t_gaji',$data);
		}

		echo 1;
	}
}
