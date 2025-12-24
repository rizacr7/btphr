<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Umr_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->db_hrd20 = $this->load->database("hrd20", TRUE);
	}
    
	function get_data_umr($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.*,b.nm_unit ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.kd_unit", "b.nm_unit");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.id_umr desc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM m_umr a left join m_unit b on a.kd_unit = b.kd_unit where a.is_del = 0 " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db_hrd20->query($query);
    }

    function get_data_coef($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.*,b.nm_unit,c.ket_level ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.kd_unit", "b.nm_unit","c.ket_level");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.id_coef desc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "SELECT " . $query_select . " FROM m_level_coef a 
        left join m_unit b on a.kd_unit = b.kd_unit 
        left join level_maspeg c on a.id_level = c.id_level
        WHERE a.kd_unit <> '' " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db_hrd20->query($query);
    }
}
?>