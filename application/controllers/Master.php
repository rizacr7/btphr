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

	function mastervendor(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('master/mst_vendor');
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
				<th>Tj.Jabatan</th>
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
				<td style='text-align:right'>" . $this->func_global->duit($value['tj_jab']) . "</td>
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

	function tab_vendor(){
        echo "<table id='table_vendor' class='table table-bordered dt-responsive table-head-bg-primary table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>Kode Vendor</th>
				<th>Nama Vendor</th>
				<th>Alamat</th>
				<th>Telp</th>
				<th>NPWP</th>
				<th>Bank</th>
				<th>No.Rekening</th>
				<th>Atas Nama</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->master_model->get_data_vendor("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
            echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value['id_vendor'] . "</td>
				<td>" . $value['kd_vendor'] . "</td>
				<td>" . $value['nm_vendor'] . "</td>
				<td>" . $value['alamat'] . "</td>
				<td>" . $value['telp'] . "</td>
				<td>" . $value['npwp'] . "</td>
				<td>" . $value['bank'] . "</td>
				<td>" . $value['no_rek'] . "</td>
				<td>" . $value['atas_nama'] . "</td>
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
			$('#table_vendor').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
    }

	function simpan_jabatan() {
		$id_jab = $this->input->post('id_jab');
		$kd_jab = $this->input->post('kd_jab');
		$nm_jab = $this->input->post('nm_jab');
		$tj_jab = $this->input->post('tj_jab');
		
		$param = array(
			'kd_jab' => $kd_jab,
			'nm_jab' => $nm_jab,
			'tj_jab' => $tj_jab,
			'id_jab' => $id_jab
		);

		if ($id_jab == "") {
			//--cek kd jab ---
			$queryCek = "SELECT * FROM m_jabatan WHERE kd_jab = '$kd_jab'";
			$rdt = $this->db->query($queryCek)->num_rows();
			if($rdt == 0){
				// insert
				$this->master_model->insert_jabatan($param);
				echo "success";
			}
			else{
				echo "erorr";
			}
		} else {
			// update
			$this->master_model->update_jabatan($param);
			echo "Data Jabatan berhasil diupdate.";
		}
	}

	function hapus_kendaraan() {
		$id_kendaraan = $this->input->post('id_kendaraan');

		$this->db->where('id_kendaraan', $id_kendaraan);
		$this->db->delete('m_kendaraan');

		echo "Data Kendaraan berhasil dihapus.";
	}

	function simpan_vendor() {
		$id_vendor = $this->input->post('id_vendor');
		$nm_vendor = $this->input->post('nm_vendor');
		$alamat = $this->input->post('alamat');
		$telp = $this->input->post('telp');

		$bank = $this->input->post('bank');
		$atas_nama = $this->input->post('atas_nama');
		$no_rek = $this->input->post('no_rek');
		$npwp = $this->input->post('npwp');

		$param = array(
			'nm_vendor' => $nm_vendor,
			'alamat' => $alamat,
			'telp' => $telp,
			'bank' => $bank,
			'atas_nama' => $atas_nama,
			'no_rek' => $no_rek,
			'id_vendor' => $id_vendor,
			'npwp' => $npwp
		);

		if ($id_vendor == "") {
			// insert
			$this->master_model->insert_vendor($param);
			echo "Data Vendor berhasil ditambahkan.";
		} else {
			// update
			$this->master_model->update_vendor($param);
			echo "Data Vendor berhasil diupdate.";
		}
	}

	function ajaxdtvendor() {
		$id_vendor = $this->input->get('id_vendor');
		$data = $this->master_model->get_data_vendor("id_vendor = '$id_vendor'", "", "", 0, 0)->row();
		echo json_encode($data);
	}

	function hapus_vendor() {
		$id_vendor = $this->input->post('id_vendor');

		$this->db->where('id_vendor', $id_vendor);
		$this->db->delete('m_vendor');

		echo "Data Kendaraan berhasil dihapus.";
	}
}
