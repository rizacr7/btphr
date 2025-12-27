<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Os_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->db_hrd20 = $this->load->database("hrd20", TRUE);
	}
    
	function get_data_pegawaios($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.*,b.nm_unit,c.nm_bagian,d.nm_jab,e.ket_level ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.kd_unit", "b.nm_unit");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.no_peg desc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM mas_peg a 
		left join m_unit b on a.kd_unit = b.kd_unit 
		left join m_bagian c on b.kd_bagian = c.kd_bagian
		left join m_jabatan d on a.kd_jab = d.kd_jab
		left join level_maspeg e on a.kd_level = e.id_level
		where a.flag_keluar = 0 and a.kd_jab = '106'" . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db_hrd20->query($query);
    }

    function get_data_pengajuanos($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.*,b.nm_unit,c.nm_bagian,d.nm_jab,e.ket_level ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.kd_unit", "b.nm_unit");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.no_peg desc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM mas_peg_pengajuan a 
		left join m_unit b on a.kd_unit = b.kd_unit 
		left join m_bagian c on b.kd_bagian = c.kd_bagian
		left join m_jabatan d on a.kd_jab = d.kd_jab
		left join level_maspeg e on a.kd_level = e.id_level
		where a.is_del = 0 and a.kd_jab = '106' and a.approve_sdm = 0 " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db_hrd20->query($query);
    }

    function get_status_pajak(){
         return $this->db
            ->select('kode, keterangan')
            ->from('m_ptkp')   // ganti sesuai nama tabel
            ->order_by('keterangan', 'ASC')
            ->get()
            ->result();
    }

    function get_pegawai_os_by_id($id_pegawai){
        $querymaspeg = "select a.*,b.nm_unit,c.nm_statpeg,d.nm_jab,e.nm_job,DATE_FORMAT(a.tgl_masuk,'%d-%m-%Y') AS tgl_msk,DATE_FORMAT(a.tgl_dinas,'%d-%m-%Y') AS tgl_dns,DATE_FORMAT(a.tgl_lahir,'%d-%m-%Y') AS tgl_lhr,DATE_FORMAT(a.tgl_akhir,'%d-%m-%Y') AS tglakhir,DATE_FORMAT(a.tgl_kontrak,'%d-%m-%Y') AS tglkontrak,f.keterangan as ket_ptkp,g.ket_level,'P02' as kd_perusahaan from mas_peg a 
		left join m_unit b on a.kd_unit = b.kd_unit  
		left join m_statuspegawai c on a.status_peg = c.kd_statpeg
		left join m_jabatan d on a.kd_jab = d.kd_jab
		left join m_jobdesc e on a.kd_job = e.kd_job
		left join m_ptkp f on a.status_pajak = f.kode
		left join level_maspeg g on a.kd_level = g.id_level
		where a.id_pegawai = '".$id_pegawai."'";
        
        $query = $this->db_hrd20->query($querymaspeg);
        return $query->row_array();
    }

    function simpan_pegawai_os($data){

        return $this->db->insert('mas_peg_pengajuan', $data);
    }
}
?>