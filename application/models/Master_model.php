<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model  {
	
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

	  function get_data_jabatan($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.* ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.nm_jab", "a.kd_jab");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.kd_jab asc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM m_jabatan a where a.is_del = 0 " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
    }
	 
	 function get_data_kendaraan($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.* ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.nm_kendaraan", "a.kd_kendaraan");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.id_kendaraan desc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM m_kendaraan a where a.id_kendaraan is not null " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
    }

	 function get_data_vendor($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.* ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.nm_vendor", "a.kd_vendor");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.id_vendor desc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM m_vendor a where a.id_vendor is not null " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
    }

	function insert_jabatan($param) {
		$tanggal = date("Y-m-d");
		
		$data = array(
				'kd_jab' => $param['kd_jab'],
				'nm_jab' => $param['nm_jab'],
				'tj_jab' => $this->func_global->rupiah($param['tj_jab'])
		);
		return $this->db->insert('m_jabatan', $data);
	}

	function update_jabatan($param) {
		$data = array(
				'kd_jab' => $param['kd_jab'],
				'nm_jab' => $param['nm_jab'],
				'tj_jab' => $this->func_global->rupiah($param['tj_jab'])
		);
		$this->db->where('id_jab', $param['id_jab']);
		return $this->db->update('m_jabatan',$data);
	}

	function insert_vendor($param) {
		$bank = $param['bank'];
		$atas_nama = $param['atas_nama'];
		$no_rek = $param['no_rek'];
		$npwp = $param['npwp'];

		$tanggal = date("Y-m-d");
		$kodebukti = $this->get_bukti_vendor(array('tanggal' => $tanggal, 'kd' => 'S'));

		$data = array(
				'kd_vendor' => $kodebukti,
				'nm_vendor' => $param['nm_vendor'],
				'alamat' => $param['alamat'],
				'telp' => $param['telp'],
				'bank' => $bank,
				'atas_nama' => $atas_nama,
				'no_rek' => $no_rek,
				'npwp' => $npwp
		);
		return $this->db->insert('m_vendor', $data);
	}

	function update_vendor($param) {
		$bank = $param['bank'];
		$atas_nama = $param['atas_nama'];
		$no_rek = $param['no_rek'];
		$npwp = $param['npwp'];

		$data = array(
				'nm_vendor' => $param['nm_vendor'],
				'alamat' => $param['alamat'],
				'telp' => $param['telp'],
				'bank' => $bank,
				'atas_nama' => $atas_nama,
				'no_rek' => $no_rek,
				'npwp' => $npwp
		);
		$this->db->where('id_vendor', $param['id_vendor']);
		return $this->db->update('m_vendor',$data);
	}

	function get_bukti_vendor($param) {
		$tanggal = $param['tanggal'];
		$kd = $param['kd'];

		$thn = substr($tanggal, 2, 2);
		$bln = substr($tanggal, 5, 2);

		$query = $this->db->query("SELECT IFNULL(MAX(SUBSTRING(kd_vendor,6,4)),0) AS max_kode FROM m_vendor WHERE kd_vendor LIKE '$kd%'");
		$row = $query->row();
		$max_kode = $row->max_kode;
		$kode_baru = str_pad((int)$max_kode + 1, 4, "0", STR_PAD_LEFT);
		$kodebukti = $kd . $thn . $bln . $kode_baru;
		return $kodebukti;
	}

	function generate_kode_kendaraan($param) {
		$tanggal = $param['tanggal'];
		$kd = $param['kd'];

		$thn = substr($tanggal, 2, 2);
		$bln = substr($tanggal, 5, 2);

		$query = $this->db->query("SELECT IFNULL(MAX(SUBSTRING(kd_kendaraan,4,4)),0) AS max_kode FROM m_kendaraan WHERE kd_kendaraan LIKE '$kd%'");
		$row = $query->row();
		$max_kode = $row->max_kode;
		$kode_baru = str_pad((int)$max_kode + 1, 4, "0", STR_PAD_LEFT);
		$kodebukti = $kd . $thn . $kode_baru;
		return $kodebukti;
	}

	function get_supplier_select2($searchTerm) {
		$this->db->select('kd_vendor as id, nm_vendor as text');
		$this->db->from('m_vendor');
		$this->db->like('nm_vendor', $searchTerm);
		$this->db->or_like('kd_vendor', $searchTerm);
		$this->db->limit(10);
		$query = $this->db->get();
		return $query->result();
	}
}
