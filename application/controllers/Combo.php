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

	public function get_jabatan_select2()
	{
		$term = $this->input->get('term'); // ambil input dari Select2
		$this->db->like('nm_jab', $term);
		$this->db->or_like('kd_jab', $term);
		$query = $this->db->get('m_jabatan'); // sesuaikan nama tabel

		$data = [];
		foreach ($query->result() as $row) {
			$data[] = [
				'id' => $row->kd_jab, // value yang dikirim ke form
				'text' => $row->kd_jab . ' - ' . $row->nm_jab // teks yang tampil
			];
		}
		echo json_encode($data);
	}

	public function get_statuspeg_select2()
	{
		$term = $this->input->get('term'); // ambil input dari Select2
		$this->db->like('nm_statuspeg', $term);
		$this->db->or_like('kd_statuspeg', $term);
		$query = $this->db->get('m_statuspeg'); // sesuaikan nama tabel

		$data = [];
		foreach ($query->result() as $row) {
			$data[] = [
				'id' => $row->kd_statuspeg, // value yang dikirim ke form
				'text' => $row->kd_statuspeg . ' - ' . $row->nm_statuspeg // teks yang tampil
			];
		}

		echo json_encode($data);
	}

	public function get_ptkp_select2()
	{
		$term = $this->input->get('term'); // ambil input dari Select2
		$this->db->like('kode', $term);
		$this->db->or_like('keterangan', $term);
		$query = $this->db->get('m_ptkp'); // sesuaikan nama tabel

		$data = [];
		foreach ($query->result() as $row) {
			$data[] = [
				'id' => $row->kode, // value yang dikirim ke form
				'text' => $row->kode . ' - ' . $row->keterangan // teks yang tampil
			];
		}

		echo json_encode($data);
	}

	function get_leveljab_select2()
	{
		$term = $this->input->get('term'); // ambil input dari Select2
		$this->db->select('a.*, b.nm_jab');
		$this->db->from('m_level_jabatan a');
		$this->db->join('m_jabatan b', 'a.kd_jab = b.kd_jab', 'left');
		$this->db->group_start();
		$this->db->like('b.nm_jab', $term);
		$this->db->or_like('a.kd_leveljab', $term);
		$this->db->group_end();
		$query = $this->db->get();// sesuaikan nama tabel

		$data = [];
		foreach ($query->result() as $row) {
			$data[] = [
				'id' => $row->kd_leveljab, // value yang dikirim ke form
				'text' => $row->nm_jab . ' - Level ' . $row->level // teks yang tampil
			];
		}

		echo json_encode($data);
	}

	function get_role_select2()
	{
		$term = $this->input->get('term'); // ambil input dari Select2
		$this->db->like('level', $term);
		$query = $this->db->get('m_level'); // sesuaikan nama tabel

		$data = [];
		foreach ($query->result() as $row) {
			$data[] = [
				'id' => $row->level, // value yang dikirim ke form
				'text' => $row->level // teks yang tampil
			];
		}

		echo json_encode($data);
	}

	function get_header_select2()
	{
		$term = $this->input->get('term'); // ambil input dari Select2
		$this->db->like('judul_head', $term);
		$query = $this->db->get('m_menu_head'); // sesuaikan nama tabel

		$data = [];
		foreach ($query->result() as $row) {
			$data[] = [
				'id' => $row->id_head, // value yang dikirim ke form
				'text' => $row->judul_head // teks yang tampil
			];
		}

		echo json_encode($data);
	}

	function get_menu_select2(){
		$term = $this->input->get('term'); // ambil input dari Select2
		$this->db->like('judul_sub', $term);
		$query = $this->db->get('m_menu_sub'); // sesuaikan nama tabel

		$data = [];
		foreach ($query->result() as $row) {
			$data[] = [
				'id' => $row->id_sub, // value yang dikirim ke form
				'text' => $row->judul_sub // teks yang tampil
			];
		}

		echo json_encode($data);
	}
}
