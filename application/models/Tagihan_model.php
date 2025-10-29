<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_model extends CI_Model  {
	
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

	 function get_bukti($data){
		$kd = $data['kd'];
		$tanggal = $data['tanggal'];
		$str = explode("-", $tanggal);
		$thn = $str[0];
		$bln = $str[1];
		$day = $str[2];
		$tahun = substr($thn,2,2);
		
		if($kd == 'HS'){
			$code = 'HS';
			$kode = $code.$bln.$tahun;
			$sql = "SELECT MAX(no_bukti_bi) AS maxID FROM t_bi_sewa WHERE no_bukti_bi like '$kode%'";
		}
		
		$result = $this->db->query($sql)->result();
		$noUrut = (int) substr($result[0]->maxID, -4);
		$noUrut++;
		$newId = sprintf("%04s", $noUrut);
		$id= $kode.$newId;
		return $id;
	}
	 
	 function get_data_invoice($cari = "", $sort = "", $order = "", $offset = "0", $limit = "", $numrows = 0) {
        $query_select = ($numrows) ? " count(*) numrows " : " a.*,b.nm_vendor";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.no_bukti_bi,b.nm_vendor,a.no_ref_spk");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }

        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.tgl_bi desc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";
		
		$query = "select " . $query_select . " FROM t_bi_sewa a 
		LEFT JOIN m_vendor b ON a.kd_vendor = b.kd_vendor
		WHERE a.no_bukti_bi is not null
		" . $query_where . " " . $query_sort . " " . $query_limit;	
		
        return $this->db->query($query);
    }

	function insert_hutang_sewa($data){
		$kd_vendor = $data['kd_vendor'];
		$tanggal = $data['tanggal'];	
		$no_bukti_bi = $data['no_bukti_bi'];
		$tgl_jth_tempo = $data['tgl_jth_tempo'];
		$jns_pph = $data['jns_pph'];

		$qHutang = "SELECT SUM(hrg_satuan) AS jmHutang,SUM(dpp) AS dpp,SUM(ppn)AS ppn,SUM(pph) AS pph FROM t_bi_sewa_detail WHERE no_bukti_bi = '$no_bukti_bi'";
		$rdt = $this->db->query($qHutang)->result();

		$jmHutang = $rdt[0]->jmHutang;;
		$dpp = $rdt[0]->dpp;
		$ppn = $rdt[0]->ppn;
		$pph = $rdt[0]->pph;

		//--- cek jika tidak ada hutang ---
		$qhutang = "SELECT COUNT(*) AS cek FROM t_hutang WHERE no_bukti_bi = '$no_bukti_bi'";
		$chutang = $this->db->query($qhutang)->result();
		if($chutang[0]->cek > 0){
			$data_hutang = array(
				'jmlh_hutang' => $jmHutang,
				'dpp' => $dpp,
				'ppn' => $ppn,
				'pph' => $pph,
			);
			$this->db->where('no_bukti_bi', $no_bukti_bi);
			$this->db->update('t_hutang', $data_hutang);
		}
		else{
			$data_hutang = array(
				'kd_vendor' => $kd_vendor,
				'tgl_bi' => $tanggal,
				'no_bukti_bi' => $no_bukti_bi,
				'jmlh_hutang' => $jmHutang,
				'tgl_jth_tempo' => $tgl_jth_tempo,
				'jns_pph' => $jns_pph,
				'dpp' => $dpp,
				'ppn' => $ppn,
				'pph' => $pph,
			);
			$this->db->insert('t_hutang', $data_hutang);
		}
	}
}
