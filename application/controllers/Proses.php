<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proses extends CI_Controller {

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
        $this->load->model('proses_model');
		$this->load->model('func_global');

		if($this->session->userdata('role') == ""){
			redirect('Welcome/index');
		}
    }

    function prosesgaji(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('proses/proses_gaji');
        $this->load->view('general/footer');
    }

	function proses_gajipegawai(){
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];

		$blnnow = date("m");
		$thnnow = date("Y");

		$cekdt = "select * from t_gaji where bulan = '$bulan' and tahun = '$tahun' and flag_close = 0";
		$rdt = $this->db->query($cekdt)->num_rows();
		if($rdt >= 0){
			if($bulan == $blnnow && $tahun == $thnnow){
			
				$reset = "delete from t_gaji where bulan = '$bulan' and tahun = '$tahun'";
				$this->db->query($reset);

				$param = array();
				$param['bulan'] = $bulan;
				$param['tahun'] = $tahun;
				$resultgaji = $this->proses_model->prosesgaji($param);

				echo 1;

			}
			else{
				echo 2;
			}
		}
	}

}
