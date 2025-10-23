<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model  {
	
	public function __construct() {
        $this->load->database();
		$this->load->model('func_global');
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
	 
	 
	function get_bukti_spk($param) {
		$tanggal = $this->func_global->tgl_dsql($param['tgl_spk']);
		$kd = $param['kd'];

		$thn = substr($tanggal, 2, 2);
		$bln = substr($tanggal, 5, 2);

		$query = $this->db->query("SELECT IFNULL(MAX(SUBSTRING(no_bukti_spk,8,4)),0) AS max_kode FROM t_spk WHERE SUBSTRING(no_bukti_spk,6,2)='$thn' AND SUBSTRING(no_bukti_spk,4,2)='$bln' AND no_bukti_spk LIKE '$kd%'");
		
		$row = $query->row();
		$max_kode = $row->max_kode;
		$kode_baru = str_pad((int)$max_kode + 1, 4, "0", STR_PAD_LEFT);
		$kodebukti = $kd . $bln .$thn. $kode_baru;
		return $kodebukti;
	}

	function get_data_spk($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.*,b.nm_vendor ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("b.nm_vendor", "a.no_ref_spk");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.tgl_spk desc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM t_spk a left join m_vendor b on a.kd_vendor = b.kd_vendor where a.is_del = 0 " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
    }

	function header_spk($param) {
		$no_bukti_spk = $param['bukti'];	
		$query = $this->db->query("SELECT a.*,b.nm_vendor FROM t_spk a left join m_vendor b on a.kd_vendor = b.kd_vendor WHERE a.no_bukti_spk = '$no_bukti_spk'");
		return $query->result();
	}

	function get_spk_detail($no_bukti_spk){
		$query = $this->db->query("SELECT a.*,b.nm_kendaraan FROM t_spk_detail a left join m_kendaraan b on a.kd_kendaraan = b.kd_kendaraan WHERE a.no_bukti_spk = '$no_bukti_spk'");
		return $query->result();
	}

	function get_data_sewa($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.*,b.`nm_kendaraan`,d.`nm_vendor` ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.nopol", "a.nm_vendor");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by c.tgl_spk desc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM t_spk_detail a 
		LEFT JOIN m_kendaraan b ON a.`kd_kendaraan` = b.`kd_kendaraan`
		LEFT JOIN t_spk c ON a.`no_bukti_spk` = c.`no_bukti_spk`
		LEFT JOIN m_vendor d ON c.`kd_vendor` = d.`kd_vendor`
		WHERE c.`is_del` = 0 AND c.`flag_spk` = 1 " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
    }
}
