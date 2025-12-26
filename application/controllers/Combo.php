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
		$this->db_hrd20 = $this->load->database("hrd20", TRUE);
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
		$this->db->where('a.is_del','0');
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

	function get_ppu_select2()
	{
		$term = $this->input->get('term'); // ambil input dari Select2
		$this->db->like('jns_ppu', $term);
		$query = $this->db->get('m_jnsppu'); // sesuaikan nama tabel

		$data = [];
		foreach ($query->result() as $row) {
			$data[] = [
				'id' => $row->id_ppu, // value yang dikirim ke form
				'text' => $row->jns_ppu // teks yang tampil
			];
		}

		echo json_encode($data);
	}

	function combo_unit(){
        $value         = isset($_REQUEST['value']) ? $_REQUEST['value'] : "";
        $q             = isset($_REQUEST['q']) ? $_REQUEST['q'] : $value;
        $cari['value'] = $q;
		
		$sql = "select * from m_unit where is_del = 0 and (kd_unit like '$q%' or nm_unit like '%$q%')";
		$data = $this->db_hrd20->query($sql)->result_array();

        foreach ($data as $key => $value) {
            $value['id']   = $value['kd_unit'];
            $value['text'] = $value['kd_unit']."|".$value['nm_unit'];

            $arrData['results'][] = $value;
        }

        echo json_encode($arrData);
	}

	function combo_level(){
        $value         = isset($_REQUEST['value']) ? $_REQUEST['value'] : "";
        $q             = isset($_REQUEST['q']) ? $_REQUEST['q'] : $value;
        $cari['value'] = $q;
		
		$sql = "select * from level_maspeg where id_level is not null and ket_level like '%$q%'";
		$data = $this->db_hrd20->query($sql)->result_array();

        foreach ($data as $key => $value) {
            $value['id']   = $value['id_level'];
            $value['text'] = $value['id_level']."|".$value['ket_level'];

            $arrData['results'][] = $value;
        }

        echo json_encode($arrData);
	}

	function combo_level_btp(){
        $value         = isset($_REQUEST['value']) ? $_REQUEST['value'] : "";
        $q             = isset($_REQUEST['q']) ? $_REQUEST['q'] : $value;
        $cari['value'] = $q;
		
		$sql = "SELECT b.`id_level`,b.`ket_level` FROM mas_peg a 
		LEFT JOIN level_maspeg b ON a.`kd_level` = b.`id_level` 
		WHERE a.`kd_jab` = '106' AND a.`kd_level` <> 0 AND b.ket_level like '%$q%' GROUP BY a.`kd_level`";
		$data = $this->db_hrd20->query($sql)->result_array();
        foreach ($data as $key => $value) {
            $value['id']   = $value['id_level'];
            $value['text'] = $value['id_level']."|".$value['ket_level'];

            $arrData['results'][] = $value;
        }

        echo json_encode($arrData);
	}

	function combo_pajak(){
        $value         = isset($_REQUEST['value']) ? $_REQUEST['value'] : "";
        $q             = isset($_REQUEST['q']) ? $_REQUEST['q'] : $value;
        $cari['value'] = $q;
		
		$sql = "select * from m_ptkp where kode is not null";
		$data = $this->db->query($sql)->result_array();

        foreach ($data as $key => $value) {
            $value['id']   = $value['kode'];
            $value['text'] = $value['kode']."|".$value['keterangan'];

            $arrData['results'][] = $value;
        }

        echo json_encode($arrData);
	}
}
