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
        $this->load->view('master/data_pegawai_os');
        $this->load->view('general/footer');
    }

	function tab_pegawai_os() {
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
			$('#table_pegawai').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
    }

}
