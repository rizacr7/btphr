<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Combo extends CI_Controller {

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

	public function get_supplier_select2()
	{
		$term = $this->input->get('term'); // ambil input dari Select2
		$this->db->like('nm_vendor', $term);
		$this->db->or_like('kd_vendor', $term);
		$query = $this->db->get('m_vendor'); // sesuaikan nama tabel

		$data = [];
		foreach ($query->result() as $row) {
			$data[] = [
				'id' => $row->kd_vendor, // value yang dikirim ke form
				'text' => $row->kd_vendor . ' - ' . $row->nm_vendor // teks yang tampil
			];
		}

		echo json_encode($data);
	}

	function get_kendaraan_select2()
	{
		$term = $this->input->get('term'); // ambil input dari Select2
		$this->db->like('nm_kendaraan', $term);
		$this->db->or_like('kd_kendaraan', $term);
		$query = $this->db->get('m_kendaraan'); // sesuaikan nama tabel

		$data = [];
		foreach ($query->result() as $row) {
			$data[] = [
				'id' => $row->kd_kendaraan, // value yang dikirim ke form
				'text' => $row->kd_kendaraan . ' - ' . $row->nm_kendaraan // teks yang tampil
			];
		}

		echo json_encode($data);
	}
}
