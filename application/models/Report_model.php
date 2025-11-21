<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model  {
	
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

	function get_data_bpjskesehatan($data){
		$query = "SELECT a.no_peg,c.na_peg,b.* FROM t_gaji a 
		LEFT JOIN bpjs_kesehatan b ON a.no_peg = b.no_peg AND b.bulan = ".$data['bulan']." and b.tahun = ".$data['tahun']."
		LEFT JOIN mas_peg c ON a.no_peg = c.no_peg
		WHERE a.bulan = ".$data['bulan']." and a.tahun = ".$data['tahun']."";
		return $this->db->query($query);
	}

	function get_data_bpjstk($data){
		$query = "SELECT a.no_peg,c.na_peg,b.* FROM t_gaji a 
		LEFT JOIN bpjs_tk b ON a.no_peg = b.no_peg AND b.bulan = ".$data['bulan']." and b.tahun = ".$data['tahun']."
		LEFT JOIN mas_peg c ON a.no_peg = c.no_peg
		WHERE a.bulan = ".$data['bulan']." and a.tahun = ".$data['tahun']."";
		return $this->db->query($query);
	}

	function get_data_bpjsjp($data){
		$query = "SELECT a.no_peg,c.na_peg,b.* FROM t_gaji a 
		LEFT JOIN bpjs_jp b ON a.no_peg = b.no_peg AND b.bulan = ".$data['bulan']." and b.tahun = ".$data['tahun']."
		LEFT JOIN mas_peg c ON a.no_peg = c.no_peg
		WHERE a.bulan = ".$data['bulan']." and a.tahun = ".$data['tahun']."";
		return $this->db->query($query);
	}

	function get_saldohutang($data){
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];

		$query =  $this->db->query("select a.*,b.nm_vendor from t_saldo_hutang a left join m_vendor b on a.kd_vendor = b.kd_vendor where bulan = $bulan and tahun = $tahun ");
		
        return $query->result();
	}

	function sinkron_saldo_hutang($data){
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];
		 
		if($bulan == 1){
			$bln_lalu = 12;
			$thn = $tahun - 1;
		}
		else{
			$bln_lalu = $bulan-1;
			$thn = $tahun;
		}
		
		$del = "delete from t_saldo_hutang where bulan = $bulan and tahun = $tahun";
		$result_del = $this->db->query($del);
		
		$cek_vendor = "select * from m_vendor";
		$result = $this->db->query($cek_vendor);
		$i	= 0;
    	$rows   = array(); 
		foreach ($result->result() as $r) {
			$rows[$i]['kd_vendor'] = $r->kd_vendor;
			
			$cek_awal = "select * from t_saldo_hutang where bulan = $bln_lalu and tahun = $thn AND kd_vendor = '$r->kd_vendor'";
			$result_lalu = $this->db->query($cek_awal)->result();
			$data_awal = $this->db->query($cek_awal)->num_rows();
			if($data_awal ==0 ){
				$saldo_awal = 0;
			}	
			else{
				$saldo_awal = $result_lalu[0]->saldo_akhir;
			}

			$hutang_now = "SELECT SUM(jmlh_hutang) AS hutang FROM t_hutang 
			WHERE MONTH(tgl_bi) = $bulan AND YEAR(tgl_bi) = $tahun AND kd_vendor = '$r->kd_vendor'";
			$htng_now = $this->db->query($hutang_now)->result();
			$r_htng = $this->db->query($hutang_now)->num_rows();
			$htng_bln_ini = $htng_now[0]->hutang;
			
			$bayar_now = "SELECT SUM(a.jmlh_bayar) AS pelunasan FROM t_bayar_hutang a 
			LEFT JOIN t_hutang b ON a.no_bukti_bi = b.no_bukti_bi 
			WHERE MONTH(a.tgl_bayar) = $bulan AND YEAR(a.tgl_bayar) = $tahun AND b.kd_vendor = '$r->kd_vendor'";
			
			$byr_now = $this->db->query($bayar_now)->result();
			$r_byr = $this->db->query($bayar_now)->num_rows();
			$byr_bln_ini = $byr_now[0]->pelunasan;
			
			if($htng_bln_ini == ''){
				$htng_bln_ini = 0;
			}
			if($byr_bln_ini == ''){
				$byr_bln_ini = 0;
			}
			
			$saldo_akhir = $saldo_awal + $htng_bln_ini - $byr_bln_ini;
			if($saldo_awal == 0 && $htng_bln_ini == 0 && $byr_bln_ini ==0){
						
			}
			else{
				$ins = "insert into t_saldo_hutang set bulan = $bulan,tahun = $tahun,kd_vendor='$r->kd_vendor',saldo_awal=$saldo_awal,
				debit=$htng_bln_ini,kredit=$byr_bln_ini,saldo_akhir=$saldo_akhir";
		
				$result_insert = $this->db->query($ins);
			}
		}
		
	}
}
