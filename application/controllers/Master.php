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
    }

    function masterkendaraan(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('master/mst_kendaraan');
        $this->load->view('general/footer');
    }

	function mastervendor(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('master/mst_vendor');
        $this->load->view('general/footer');
    }


    function tab_kendaraan(){
        echo "<table id='table_kendaraan' class='table table-bordered dt-responsive' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>Kode Kendaraan</th>
				<th>Nama Kendaraan</th>
				<th>Jenis</th>
				<th>Bahan Bakar</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->master_model->get_data_kendaraan("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
            echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value['id_kendaraan'] . "</td>
				<td>" . $value['kd_kendaraan'] . "</td>
				<td>" . $value['nm_kendaraan'] . "</td>
				<td>" . $value['jns_kend'] . "</td>
				<td>" . $value['bbm'] . "</td>
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
			$('#table_kendaraan').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
    }

	function tab_vendor(){
        echo "<table id='table_vendor' class='table table-striped table-bordered' width='100%'>
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

	function simpan_kendaraan() {
		$id_kendaraan = $this->input->post('id_kendaraan');
		$kd_kendaraan = $this->input->post('kd_kendaraan');
		$nm_kendaraan = $this->input->post('nm_kendaraan');
		$jns_kend = $this->input->post('jns_kend');
		$bbm = $this->input->post('bbm');

		// buatkan kd_kendaraan generate otomatis
		$kd_kendaraan = "K" . str_pad($this->master_model->get_data_kendaraan("", "id_kendaraan", "desc", 0, 1, 0)->num_rows() + 1, 4, "0", STR_PAD_LEFT);

		$param = array(
			'kd_kendaraan' => $kd_kendaraan,
			'nm_kendaraan' => $nm_kendaraan,
			'jns_kend' => $jns_kend,
			'bbm' => $bbm,
			'id_kendaraan' => $id_kendaraan
		);

		if ($id_kendaraan == "") {
			// insert
			$this->master_model->insert_kendaraan($param);
			echo "Data Kendaraan berhasil ditambahkan.";
		} else {
			// update
			$this->master_model->update_kendaraan($param);
			echo "Data Kendaraan berhasil diupdate.";
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
