<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model  {

	var $table = 'mas_peg';
	var $column_order = ['no_peg','na_peg','status_peg','kd_unit','kd_jab','no_hp','tgl_masuk'];
	var $column_search = ['no_peg','na_peg','status_peg','kd_unit','kd_jab','no_hp'];
	var $order = ['tgl_update' => 'DESC'];
	
	public function __construct() {
        $this->load->database();
		$this->load->model('func_global');
		$this->db_hrd20 = $this->load->database("hrd20", TRUE);
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
	
	function get_data_statuspeg($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.* ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.nm_statuspeg", "a.kd_statuspeg");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.kd_statuspeg asc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM m_statuspeg a where a.is_del = 0 " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
    }

	function get_data_leveljabatan($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.*,b.nm_jab ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("b.nm_jab", "a.kd_jab", "a.kd_leveljab");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.kd_jab asc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM m_level_jabatan a left join m_jabatan b ON a.kd_jab = b.kd_jab where a.is_del = 0 " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
    }
	

	function insert_jabatan($param) {
		$tanggal = date("Y-m-d");

		$tanggal = date("Y-m-d");
		$kodebukti = $this->get_bukti_jab(array('tanggal' => $tanggal, 'kd' => 'J'));
		
		$data = array(
				'kd_jab' => $kodebukti,
				'nm_jab' => $param['nm_jab']
		);
		return $this->db->insert('m_jabatan', $data);
	}

	function update_jabatan($param) {
		$data = array(
			'nm_jab' => $param['nm_jab']
		);
		$this->db->where('id_jab', $param['id_jab']);
		return $this->db->update('m_jabatan',$data);
	}

	function get_bukti_jab($param) {
		$tanggal = $param['tanggal'];
		$kd = $param['kd'];

		$thn = substr($tanggal, 2, 2);
		$bln = substr($tanggal, 5, 2);

		$query = $this->db->query("SELECT IFNULL(MAX(SUBSTRING(kd_jab,2,2)),0) AS max_kode FROM m_jabatan WHERE kd_jab LIKE '$kd%'");
		$row = $query->row();
		$max_kode = $row->max_kode;
		$kode_baru = str_pad((int)$max_kode + 1, 2, "0", STR_PAD_LEFT);
		$kodebukti = $kd . $kode_baru;
		return $kodebukti;
	}


	function insert_statuspeg($param) {
		$tanggal = date("Y-m-d");

		$tanggal = date("Y-m-d");
		$kodebukti = $this->get_bukti_statuspeg(array('tanggal' => $tanggal, 'kd' => 'S'));
		
		$data = array(
			'kd_statuspeg' => $kodebukti,
			'nm_statuspeg' => $param['nm_statuspeg']
		);
		return $this->db->insert('m_statuspeg', $data);
	}

	function update_statuspeg($param) {
		$data = array(
			'nm_statuspeg' => $param['nm_statuspeg']
		);
		$this->db->where('id_statuspeg', $param['id_statuspeg']);
		return $this->db->update('m_statuspeg',$data);
	}

	function get_bukti_statuspeg($param) {
		$tanggal = $param['tanggal'];
		$kd = $param['kd'];

		$thn = substr($tanggal, 2, 2);
		$bln = substr($tanggal, 5, 2);

		$query = $this->db->query("SELECT IFNULL(MAX(SUBSTRING(kd_statuspeg,2,2)),0) AS max_kode FROM m_statuspeg WHERE kd_statuspeg LIKE '$kd%'");
		$row = $query->row();
		$max_kode = $row->max_kode;
		$kode_baru = str_pad((int)$max_kode + 1, 2, "0", STR_PAD_LEFT);
		$kodebukti = $kd . $kode_baru;
		return $kodebukti;
	}

	function insert_leveljab($param){
		$data = array(
			'kd_leveljab' => $param['kd_leveljab'],
			'kd_jab' => $param['kd_jab'],
			'level' => $param['level'],
			'gapok' => $param['gapok'],
			'tj_jabatan' => $param['tj_jabatan'],
			'tj_kinerja' => $param['tj_kinerja'],
			'tj_transport' => $param['tj_transport'],
			'tj_komunikasi' => $param['tj_komunikasi'],
			'tj_konsumsi' => $param['tj_konsumsi'],
			'tj_kinerja' => $param['tj_kinerja'],
			'tj_lembur' => $param['tj_lembur'],
			'tj_hr' => $param['tj_hr'],
			'tj_kehadiran' => $param['tj_kehadiran']
		);
		return $this->db->insert('m_level_jabatan', $data);
	}

	function update_leveljab($param){
		$data = array(
			'gapok' => $param['gapok'],
			'tj_jabatan' => $param['tj_jabatan'],
			'tj_kinerja' => $param['tj_kinerja'],
			'tj_transport' => $param['tj_transport'],
			'tj_komunikasi' => $param['tj_komunikasi'],
			'tj_konsumsi' => $param['tj_konsumsi'],
			'tj_kinerja' => $param['tj_kinerja'],
			'tj_lembur' => $param['tj_lembur'],
			'tj_hr' => $param['tj_hr'],
			'tj_kehadiran' => $param['tj_kehadiran']
		);
		$this->db->where('id_leveljab', $param['id_leveljab']);
		return $this->db->update('m_level_jabatan', $data);
	}

	function get_nopegawai($data){
		$status_peg = $data['status_peg'];
		$tanggal = $data['tanggal'];
		$str = explode("-", $tanggal);
		$thn = $str[0];
		$bln = $str[1];
		$day = $str[2];
		$tahun = substr($thn,2,2);

		$code = $bln;
		if($status_peg == "OS"){
			$code = "OS";
		}
		
		if($status_peg == "OS"){
			$kode = $code.$tahun;
			$sql = "SELECT MAX(no_peg) AS maxID FROM mas_peg_pengajuan WHERE no_peg like '$kode%'";
			$result = $this->db_hrd20->query($sql)->result();
		}
		else{
			$kode = $code.$tahun;
			$sql = "SELECT MAX(no_peg) AS maxID FROM mas_peg WHERE no_peg like '$kode%'";
			$result = $this->db->query($sql)->result();
		}

		$noUrut = (int) substr($result[0]->maxID, -3);
		$noUrut++;
		$newId = sprintf("%03s", $noUrut);
		$id= $kode.$newId;
		return $id;
	}


	private function _get_datatables_query() {
		$this->db->select('
		a.*,
		b.nm_statuspeg,
		c.level,
		d.nm_jab
		');
		$this->db->from('mas_peg a');
		$this->db->join('m_statuspeg b', 'a.status_peg = b.kd_statuspeg', 'left');
		$this->db->join('m_level_jabatan c', 'a.kd_leveljab = c.kd_leveljab', 'left');
		$this->db->join('m_jabatan d', 'c.kd_jab = d.kd_jab', 'left');
		$this->db->where('a.flag_keluar', 0);
		$this->db->where_not_in('a.status_peg', 'S04');
		// 🔍 pencarian global
		$i = 0;
		foreach ($this->column_search as $item) {
		if ($_POST['search']['value']) {
			if ($i === 0) {
			$this->db->group_start();
			$this->db->like($item, $_POST['search']['value']);
			} else {
			$this->db->or_like($item, $_POST['search']['value']);
			}
			if (count($this->column_search) - 1 == $i)
			$this->db->group_end();
		}
		$i++;
		}

		// 🔄 sorting
		if (isset($_POST['order'])) {
		$this->db->order_by(
			$this->column_order[$_POST['order'][0]['column']],
			$_POST['order'][0]['dir']
		);
		} else if (isset($this->order)) {
		$order = $this->order;
		$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables() {
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		return $this->db->get()->result();
	}

	function count_filtered() {
		$this->_get_datatables_query();
		return $this->db->get()->num_rows();
	}

	function count_all() {
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

}
