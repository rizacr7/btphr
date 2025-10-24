<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model  {
	
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
	 public function check_login($username, $password) {
        // Enkripsi password input pakai md5 sebelum dicocokkan
        $password_md5 = md5($password);

        $this->db->where('username', $username);
        $this->db->where('password', $password_md5);
        $query = $this->db->get('t_login');

        if ($query->num_rows() > 0) {
            return $query->row(); // user ditemukan
        } else {
            return false;
        }
    }

	function get_data_user($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.* ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.username", "a.nama");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.id_user asc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM t_login a where a.id_user is not null " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
    }

	function get_data_role($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.* ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.level");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.id_level asc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM m_level a where a.id_level is not null " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
    }

	function get_data_menu($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.*,b.judul_head ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.judul_sub", "b.judul_head");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.id_sub desc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM m_menu_sub a left join m_menu_head b on a.id_head = b.id_head where a.id_sub is not null " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
    }

	function get_data_aksesmenu($cari = "", $sort = "", $order = "", $offset = "0", $limit = "",$data, $numrows = 0){
		$level = $data['level'];
        $query_select = ($numrows) ? " count(*) numrows " : " a.*,b.judul_head,c.judul_sub ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("c.judul_sub", "b.judul_head");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.id_head asc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM m_akses a 
		LEFT JOIN m_menu_head b ON a.id_head = b.id_head 
		LEFT JOIN m_menu_sub c ON a.id_sub_menu = c.id_sub
		WHERE a.level = '$level' " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
	}
}
