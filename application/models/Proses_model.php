<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proses_model extends CI_Model  {
	
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

	 function prosesgaji($data){
		$username = $this->session->userdata('username');
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];

		$query = "SELECT a.`no_peg`,a.`kd_prsh`,a.`na_peg`,b.* FROM mas_peg a 
		LEFT JOIN m_level_jabatan b ON a.kd_leveljab = b.`kd_leveljab` WHERE a.`flag_keluar` = 0";

		// --- cek gdp bpjs ---
		$cekgdp = "select * from gdp_bpjs where aktif = 1";
		$rgdp = $this->db->query($cekgdp)->result();
		$gdp_bpjs_pensiun = $rgdp[0]->gdp_pensiun;
		$gdp_bpjs = $rgdp[0]->gdp_bpjs;

		// --- cek umk ---
		$cekumk = "select * from m_umk where aktif = 1 and kota = 1";
		$rumk = $this->db->query($cekumk)->result();
		$umk = $rumk[0]->umk;

		$resultdata = $this->db->query($query)->result_array();
		foreach($resultdata as $key => $val){
			$no_peg = $val['no_peg'];
			$kd_prsh = $val['kd_prsh'];

			$gapok = $val['gapok'];
			$tj_jabatan = $val['tj_jabatan'];
			
			$gdp = $gapok + $tj_jabatan;
			$gdpjamsostek = $gapok + $tj_jabatan;
			$gdp_pensiun = $gapok + $tj_jabatan;

			// ==== bpjs ====
			if($gdp > $gdp_bpjs){
				$total_gdp = $gdp_bpjs;
			}
			else if($gdp > $umk){
				$total_gdp = $gdp_bpjs;
			}
			else{
				$total_gdp = $umk;
			}

			// --- bpjs tk ---
			if($gdpjamsostek > $umk){
				$gdp_jamsostek = $gdpjamsostek;
			}
			else{
				$gdp_jamsostek = $umk;
			}

			// ==== pensiun =====
			if($gdp_pensiun > $gdp_bpjs_pensiun){
				$total_gdp_pensiun = $gdp_bpjs_pensiun;
			}
			else if($gdp_pensiun > $umk){
				$total_gdp_pensiun = $gdp_pensiun;
			}
			else{
				$total_gdp_pensiun = $umk;
			}

			$pot_bpjs_peg = round($total_gdp * 0.01,2);
			$pot_bpjs_prsh = round($total_gdp * 0.04,2);

			$pot_jamsostek_peg = round($gdp_jamsostek * 0.01,2);
			$pot_jamsostek_prsh = round($gdp_jamsostek * 0.0524,2);

			$pot_pensiun_peg = round($total_gdp_pensiun * 0.01,2);
			$pot_pensiun_prsh = round($total_gdp_pensiun * 0.02,2);

			$gajibruto = $gapok + $tj_jabatan + $val['tj_komunikasi'] + $val['tj_transport'] + $val['tj_konsumsi'] + $val['tj_kinerja'] + $val['tj_lembur'] + $val['tj_kehadiran'] + $val['tj_hr'];
			$gajinetto = $gajibruto - $pot_bpjs_peg - $pot_jamsostek_peg - $pot_pensiun_peg;
			
			$data = array(
				'bulan' =>$bulan,
				'tahun' =>$tahun,
				'no_peg'=>$no_peg,
				'kd_prsh'=>$kd_prsh,
				'kd_leveljab'=>$val['kd_leveljab'],
				'kd_jab'=>$val['kd_jab'],
				'level'=>$val['level'],
				'gapok' => $gapok,
				'tj_jabatan' => $val['tj_jabatan'],
				'tj_kinerja' => $val['tj_kinerja'],
				'tj_transport' => $val['tj_transport'],
				'tj_komunikasi' => $val['tj_komunikasi'],
				'tj_konsumsi' => $val['tj_konsumsi'],
				'tj_kinerja' => $val['tj_kinerja'],
				'tj_lembur' => $val['tj_lembur'],
				'tj_hr' => $val['tj_hr'],
				'tj_kehadiran' => $val['tj_kehadiran'],
				'gaji_bruto' => $gajibruto,
				'gaji_netto' => $gajinetto,
				'pot_bpjs_tk' => $pot_jamsostek_peg,
				'pot_bpjs_jkk' => $pot_pensiun_peg,
				'pot_bpjs' => $pot_bpjs_peg,
				'user_id' => $username
			);
			$this->db->insert('t_gaji', $data);

		}
	 }
}
