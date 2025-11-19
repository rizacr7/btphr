<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approve_model extends CI_Model  {
	
	public function __construct() {
        $this->load->database();
    }
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

	function get_data_app($cari = "", $sort = "", $order = "", $offset = "0", $limit = "",$data, $numrows = 0) {
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];

        $query_select = ($numrows) ? " count(*) numrows " : " a.* ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.nm_dokumen");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.tgl_proses asc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM approval_sdm a 
		WHERE a.bulan = $bulan AND a.tahun = $tahun " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
    }

}
