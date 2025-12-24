<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Umr extends CI_Controller {

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
		$this->load->model('umr_model');
		$this->load->model('func_global');
		$this->db_hrd20 = $this->load->database("hrd20", TRUE);

		if($this->session->userdata('role') == ""){
			redirect('Welcome/index');
		}
    }

    function masterumr(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('master/mst_umr');
        $this->load->view('general/footer');
    }

	function masterlevelcoef(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('master/mst_level_coef');
        $this->load->view('general/footer');
    }

	function tab_umr() {
        echo "<table id='table_umr' class='table table-bordered dt-responsive table-head-bg-primary table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>Kode Unit</th>
				<th>Nama Unit</th>
				<th>Tahun</th>
				<th>UMR</th>
				<th>Gaji OS</th>
				<th>Ko-Efisien</th>
				<th>Aktif</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->umr_model->get_data_umr("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
			if($value['aktif'] == '1'){
				$label_aktif = "<span class='badge badge-success'>Aktif</span>";
			}
			else{
				$label_aktif = "<span class='badge badge-danger'>Non Aktif</span>";
			}

            echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value['id_umr'] . "</td>
				<td>" . $value['kd_unit'] . "</td>
				<td>" . $value['nm_unit'] . "</td>
				<td>" . $value['tahun'] . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['jm_umr']) . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['gaji_os']) . "</td>
				<td>" . $value['coef'] . "</td>
				<td>" . $label_aktif . "</td>
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
			$('#table_umr').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
    }

	function ajaxdtumr(){
		$id_umr = $_GET['id_umr'];
		$query = "select a.*,b.nm_unit from m_umr a left join m_unit b on a.kd_unit = b.kd_unit where a.id_umr = '$id_umr'";
		$result = $this->db_hrd20->query($query)->row();
		echo json_encode($result);
	}
	
	function hapusumr(){
		$id_umr = $_POST['id_umr'];
		$query = "update m_umr set is_del = 1,aktif=0,tgl_hapus=NOW() where id_umr = '$id_umr'";
		$this->db_hrd20->query($query);
		echo 1;
	}
	
	function aktifumr(){
		$id_umr = $_POST['id_umr'];
		
		$cekdt = "select * from m_umr where id_umr = '$id_umr'";
		$rdt = $this->db_hrd20->query($cekdt)->result();
		$kd_unit = $rdt[0]->kd_unit;
		
		$update = "update m_umr set aktif = 0 where kd_unit = '$kd_unit'";
		$this->db_hrd20->query($update);
		
		$aktifdt = "update m_umr set aktif = 1 where id_umr = '$id_umr'";
		$this->db_hrd20->query($aktifdt);
		
		echo 1;
	}
	
	function ins_umr(){
		$userid = $this->session->userdata('username');

		$id_umr = $_POST['id_umr'];
		$kd_unit = $_POST['kd_unit'];
		$tahun = $_POST['tahun'];
		$jm_umr = $this->func_global->rupiah($_POST['jm_umr']);
		$coef = $this->func_global->rupiah($_POST['coef']);
		$gaji_os = $this->func_global->rupiah($_POST['gaji_os']);
		
		if($id_umr == ''){
			// --- non aktif ---
			$update = "update m_umr set aktif = 0 where kd_unit = '$kd_unit'";
			$this->db_hrd20->query($update);
			
			$ins = "insert into m_umr set kd_unit = '$kd_unit',tahun='$tahun',jm_umr='$jm_umr',gaji_os='$gaji_os',coef='$coef',aktif=1,user='$userid'";
			$this->db_hrd20->query($ins);
			echo 1;
		}
		else{
			//---insert log umr ----
			$queryumr = "select * from m_umr where id_umr = '$id_umr'";
			$val = $this->db_hrd20->query($queryumr)->result();
			$insumr = "insert into log_umr set tahun='".$val[0]->tahun."',jm_umr='".$val[0]->jm_umr."',gaji_os='".$val[0]->gaji_os."',coef='".$val[0]->coef."',kd_unit = '".$val[0]->kd_unit."',tgl_update=NOW(),user='$userid'";
			$this->db_hrd20->query($insumr);

			$update = "update m_umr set tahun='$tahun',jm_umr='$jm_umr',gaji_os='$gaji_os',coef='$coef',kd_unit = '$kd_unit',tgl_update=NOW(),user='$userid' where id_umr = '$id_umr'";
			$this->db_hrd20->query($update);
			echo 3;
		}
	}

	
	function excel_umr(){
		$file = "data_umr.xls";
		
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		
		echo"
		<table>
			<thead>
				<tr>
					<th colspan='8'>DATA UMR KOPERASI WARGA SEMEN GRESIK</th>
				</tr>
			</thead>
		</table><p></p>";


		echo "<table border='1'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th>Kode Unit</th>
				<th>Nama Unit</th>
				<th>Tahun</th>
				<th>UMR</th>
				<th>Gaji OS</th>
				<th>Aktif</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->umr_model->get_data_umr("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
			if($value['aktif'] == '1'){
				$label_aktif = "aktif";
			}
			else{
				$label_aktif = "tdk.aktif";
			}

            echo "<tr>
				<td>" . $no . "</td>
				<td>" . $value['kd_unit'] . "</td>
				<td>" . $value['nm_unit'] . "</td>
				<td>" . $value['tahun'] . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['jm_umr']) . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['gaji_os']) . "</td>
				<td>" . $label_aktif . "</td>
			</tr>";
            $no++;
        }

	}

	//---level coef---
	function tab_coef() {
        echo "<table id='table_coef' class='table table-bordered dt-responsive table-head-bg-primary table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>Kode Unit</th>
				<th>Nama Unit</th>
				<th>Level</th>
				<th>Ko-Efisien (%)</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->umr_model->get_data_coef("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {

            echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value['id_coef'] . "</td>
				<td>" . $value['kd_unit'] . "</td>
				<td>" . $value['nm_unit'] . "</td>
				<td>" . $value['ket_level'] . "</td>
				<td>" . $value['coef_level'] . "</td>
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
			$('#table_coef').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
    }

	function ajaxdtcoef(){
		$id_coef = $_GET['id_coef'];
		$query = "SELECT a.*,b.nm_unit,c.ket_level FROM m_level_coef a 
        left join m_unit b on a.kd_unit = b.kd_unit 
        left join level_maspeg c on a.id_level = c.id_level 
		where a.id_coef = '$id_coef'";
		$result = $this->db_hrd20->query($query)->row();
		echo json_encode($result);
	}
	
	function hapuscoef(){
		$id_coef = $_POST['id_coef'];
		$query = "DELETE FROM m_level_coef where id_coef = '$id_coef'";
		$this->db_hrd20->query($query);
		echo 1;
	}

	function ins_coef_level(){
		$userid = $this->session->userdata('username');

		$id_coef = $_POST['id_coef'];
		$kd_unit = $_POST['kd_unit'];
		$id_level = $_POST['id_level'];
		$coef = $this->func_global->rupiah($_POST['coef']);
		
		if($id_coef == ''){
			//---cek data ---
			$qCek = "SELECT COUNT(*) as dtcoef FROM m_level_coef WHERE kd_unit = '$kd_unit' AND id_level = '$id_level'";
			$rdt = $this->db_hrd20->query($qCek)->result();
			if($rdt[0]->dtcoef == 0){
				$data = array(
					'kd_unit' => $kd_unit,
					'id_level' => $id_level,
					'coef_level' => $coef,
					'userid' => $userid,
					);
				$this->db_hrd20->insert('m_level_coef',$data);
				echo 1;
			}
			else{
				echo 2;
			}
		}
		else{
			$update = "update m_level_coef set coef_level='$coef',kd_unit = '$kd_unit',id_level='$id_level',tgl_update=NOW(),userid='$userid' where id_coef = '$id_coef'";
			$this->db_hrd20->query($update);
			echo 3;
		}
	}

}
