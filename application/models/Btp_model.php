<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Btp_model extends CI_Model  {
	
	public function __construct() {
        $this->load->database();
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

	 function prosesgajios($data){
        $username = $this->session->userdata('username');
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];
        $dateKeluar = $tahun."-".$bulan."-06";
		
		// --- hapus data ---
		$Qhapus = "delete from t_gaji_os_btp where bulan = $bulan and tahun = $tahun";
		$this->db->query($Qhapus);

        $queryPegawai = "SELECT a.*,b.`gaji_os`,b.`coef`,c.kd_akun_unit,c.kd_bagian,a.flag_kis,IF(d.`tj_trans` IS NULL,0,d.tj_trans) AS tj_trans,SUBSTR(a.tgl_keluar,-2,2) AS tglout,a.flag_keluar,a.kd_level,'0' AS cekdt FROM mas_peg a 
        LEFT JOIN m_umr b ON a.`kd_unit` = b.`kd_unit` AND b.`aktif` = 1 AND b.tahun = $tahun AND b.is_del = 0
        LEFT JOIN m_unit c ON a.kd_unit = c.kd_unit
        LEFT JOIN m_tunjangan_peg d ON a.`no_peg` = d.`no_peg` AND d.`is_del` = 0
        WHERE SUBSTR(a.no_peg,1,2) = 'OS' AND a.kd_jab = '106' AND a.flag_keluar = 0 AND a.flag_gaji_pusat = 1 AND a.`kd_level` NOT IN ('7','136','137')
        UNION
        SELECT a.*,b.`gaji_os`,b.`coef`,c.kd_akun_unit,c.kd_bagian,a.flag_kis,IF(d.`tj_trans` IS NULL,0,d.tj_trans) AS tj_trans,SUBSTR(a.tgl_keluar,-2,2) AS tglout,a.flag_keluar,a.kd_level,IF(f.`cekdt`=1,1,0) AS cekdt FROM mas_peg a 
        LEFT JOIN m_umr b ON a.`kd_unit` = b.`kd_unit` AND b.`aktif` = 1 AND b.tahun = $tahun AND b.is_del = 0
        LEFT JOIN m_unit c ON a.kd_unit = c.kd_unit
        LEFT JOIN m_tunjangan_peg d ON a.`no_peg` = d.`no_peg` AND d.`is_del` = 0
        LEFT JOIN cek_os f ON a.no_peg = f.`no_peg`
        WHERE SUBSTR(a.no_peg,1,2) = 'OS' AND a.kd_jab = '106' AND a.flag_keluar = 0 AND a.kd_unit  = '90AD' AND a.flag_gaji_pusat = 1 AND a.`kd_level` IN ('136')
        UNION
        SELECT a.*,b.`gaji_os`,b.`coef`,c.kd_akun_unit,c.kd_bagian,a.flag_kis,IF(d.`tj_trans` IS NULL,0,d.tj_trans) AS tj_trans,SUBSTR(a.tgl_keluar,-2,2) AS tglout,a.flag_keluar,a.kd_level,'0' AS cekdt FROM mas_peg a 
        LEFT JOIN m_umr b ON a.`kd_unit` = b.`kd_unit` AND b.`aktif` = 1 AND b.tahun = $tahun AND b.is_del = 0
        LEFT JOIN m_unit c ON a.kd_unit = c.kd_unit
        LEFT JOIN m_tunjangan_peg d ON a.`no_peg` = d.`no_peg` AND d.`is_del` = 0
        WHERE SUBSTR(a.no_peg,1,2) = 'OS' AND a.kd_jab = '106' AND a.flag_keluar = 1 AND MONTH(a.tgl_keluar) = $bulan  AND YEAR(a.tgl_keluar)=$tahun and a.tgl_keluar > '$dateKeluar' AND a.flag_gaji_pusat = 1 AND a.`kd_level` NOT IN ('7','136','137')";
        
        $Dataresult = $this->db_hrd20->query($queryPegawai)->result_array();
        foreach($Dataresult as $key => $val){
            $gaji_os = $val['gaji_os'];
            $no_peg = $val['no_peg'];
            $kd_unit = $val['kd_unit'];
            $kd_bagian = $val['kd_bagian'];
            $coef = $val['coef'];
            $kd_jab = $val['kd_jab'];
            $tj_trans = $val['tj_trans'];
            $kd_akun_unit = $val['kd_akun_unit'];
            $tglout = $val['tglout'];
            $kd_level = $val['kd_level'];
            $flag_keluar = $val['flag_keluar'];

            if($val['cekdt'] == 1){
                $coef = 100;
            }

            $gapok = round($gaji_os*($coef/100),0);
            $gdp = round($gaji_os*($coef/100),0);

            //---hitung master level coef ----
            $qlevel = "SELECT coef_level FROM m_level_coef WHERE id_level = '".$kd_level."' AND kd_unit = '".$kd_unit."'";
            $rbaris = $this->db_hrd20->query($qlevel)->num_rows();
            if($rbaris != 0){
               $data = $this->db_hrd20->query($qlevel)->result();
               $coef_level = $data[0]->coef_level;
            //    $gapok = round(($coef_level/100)*$gapok,0);
               $gapok = round(($coef_level/100)*$gaji_os,0);
            }

            //---kondisi sk terbaru---
            if($gapok == 0){
                $gapok = 0;
            }
            else{
                if($gapok < 2500000){
                    $gapok = 2500000;
                }
            }
            
            //----insentif lembur pbb---
            $ceklembur = "select * from m_lembur_insentif where kd_grup = '$kd_akun_unit' and bulan = '$bulan' and tahun = '$tahun' and kdjab=1";	
            $dtlembur = $this->db_hrd20->query($ceklembur)->num_rows();
            if($dtlembur == 0){
                $tj_lembur = 0;
            }
            else{
                $rlembur = $this->db_hrd20->query($ceklembur)->result();
                if($kd_level == "129" && $kd_akun_unit == "2101"){
                    //---khusus driver ekspedisi---
                    $tj_lembur = 0;
                } 
                else{
                    $tj_lembur = $rlembur[0]->tj_lembur;
                }
            }

            // ---- insentif fungsional ----
			$cekInsentif = "select * from m_insentif_fungsional where kd_bagian = '$kd_bagian' and bulan = '$bulan' and tahun = '$tahun' and persentase <> 0";
            $jmData = $this->db_hrd20->query($cekInsentif)->num_rows();
            $staff = 0;
			if($jmData != 0){
				$dtIns = $this->db_hrd20->query($cekInsentif)->result();
				$staff = $dtIns[0]->staff;
            }
            $tjlembur = $tj_lembur + $staff;

            if($flag_keluar == 1 && $tglout < 15){
                $gapok = $gapok/2;
                $tj_trans = $tj_trans/2;
                $tjlembur = $tjlembur/2;
            }

            $jm_bruto = $gapok +$tjlembur + $tj_trans;

            if($kd_unit <> "90AD"){
                $jm_fee = round($jm_bruto * 0.055,0);
                $pph = round($jm_fee * 0.02,0);
            }

            $data = array(
                 'no_peg' => $no_peg,
                 'kd_unit' => $kd_unit,
                 'kd_jab' => $kd_jab,
				 'kd_level' => $kd_level,
                 'tj_pulsa' => $tj_trans,
                 'beban' => $kd_akun_unit,
                 'gaji_os' => $gapok,
                 'gdp' => $gdp,
                 'tj_lembur' => $tjlembur,
                 'jm_bruto'=>$jm_bruto,
                 'jm_netto'=>$jm_bruto,
                 'bulan' => $bulan,
                 'tahun' => $tahun,
                 'fee'=>$jm_fee,
                 'jm_pph'=>$pph
                 );
             $this->db->insert('t_gaji_os_btp',$data);

        }
    }

	function prosesbpjs_os($data){
		$username = $this->session->userdata('username');
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];
		
		//--- delete jkm ---
		$hapus = "delete from bpjs_os_btp where bulan = $bulan and tahun = $tahun";
		$this->db->query($hapus);
		
		$query = "SELECT a.no_peg,a.kd_unit,a.gaji_os,a.tj_lembur,a.tj_pulsa,a.gdp,b.kd_level,b.flag_kis,a.potongan FROM t_gaji_os_btp a 
        LEFT JOIN mas_peg b ON a.no_peg = b.no_peg
        WHERE a.bulan = $bulan AND a.tahun = $tahun AND b.flag_kis = 0";
		$rdt = $this->db->query($query);
		$i= 0;
		$rows = array();
		foreach($rdt->result() as $dt){
			$rows[$i]['no_peg'] = $dt->no_peg;
            $rows[$i]['kd_unit'] = $dt->kd_unit;
			$rows[$i]['gaji_os'] = $dt->gaji_os;
            $rows[$i]['tj_lembur'] = $dt->tj_lembur;
            $rows[$i]['tj_pulsa'] = $dt->tj_pulsa;
            $rows[$i]['gdp'] = $dt->gdp;
            $rows[$i]['kd_level'] = $dt->kd_level;
            $rows[$i]['potongan'] = $dt->potongan;
			$jm_fee = 0;
            $pph = 0;

			$gdp = $dt->gdp;
			
            //---bpjs jaminan hari tua---
            if($dt->kd_level == "129"){
                $queryUmr = "SELECT * FROM m_umr WHERE kd_unit = '".$dt->kd_unit."' and aktif = 1";
                $data = $this->db_hrd20->query($queryUmr)->result();
                $gdp = $data[0]->jm_umr;

                // $gdp = $dt->gdp;
                //---khusus driver ekspedisi---
                $pot_pensiun_peg = 0;
			    $pot_pensiun_prsh = 0;
            }
            else{
                $pot_pensiun_peg = $gdp * 0.01;
			    $pot_pensiun_prsh = $gdp * 0.02;
            }
			
			
            //---bpjs tenaga kerja---
			$pot_jamsostek_peg = round($gdp * 0.01,2);
			$pot_jamsostek_prsh = round($gdp * 0.0524,2);
			
            //---bpjs kesehatan---
			$pot_bpjs_peg = round($gdp * 0.01,2);
			$pot_bpjs_prsh = round($gdp * 0.04,2);
			
			$total_bpjs = $pot_pensiun_peg + $pot_pensiun_prsh + $pot_jamsostek_peg + $pot_jamsostek_prsh + $pot_bpjs_peg + $pot_bpjs_prsh;
			
			$insbpjs = "insert into bpjs_os_btp set bulan='$bulan',tahun='$tahun',no_peg = '$dt->no_peg',kd_unit='$dt->kd_unit',gdp='$gdp',jht_peg='$pot_pensiun_peg',jht_prsh='$pot_pensiun_prsh',jkk_peg='$pot_bpjs_peg',jkk_prsh='$pot_bpjs_prsh',bpjstk_prsh='$pot_jamsostek_prsh',bpjstk_peg='$pot_jamsostek_peg',total_bpjs='$total_bpjs',user='$username'";
			$this->db->query($insbpjs);

            //---updategaji---
            $jm_bruto = $dt->gaji_os + $dt->tj_lembur + $dt->tj_pulsa;
            $jm_netto = $jm_bruto - $pot_pensiun_peg - $pot_jamsostek_peg - $pot_bpjs_peg - $dt->potongan;

            if($jm_netto < 0){
                $jm_netto = 0;
            }

            if($dt->kd_unit <> "90AD"){
                $jm_fee = round($jm_bruto * 0.055,0);
                $pph = round($jm_fee * 0.02,0);
            }

            $updateGaji = "UPDATE t_gaji_os_btp SET jm_bruto='$jm_bruto',bpjs='$pot_bpjs_peg',jamsostek='$pot_jamsostek_peg',jht='$pot_pensiun_peg',jm_netto='$jm_netto',fee='$jm_fee',jm_pph='$pph' WHERE no_peg = '".$dt->no_peg."' AND bulan = $bulan AND tahun = $tahun";
            $this->db->query($updateGaji);

		}
	}

	function get_data_gaji_os($cari = "", $sort = "", $order = "", $offset = "0", $limit = "",$data, $numrows = 0) {
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];

        $query_select = ($numrows) ? " count(*) numrows " : " a.*,c.na_peg ";

        if (is_array($cari) and $cari['value'] != "") {
            $cari_field = isset($cari['field']) ? $cari['field'] : array("a.no_peg", "c.na_peg");

            $isi_where = implode(" like '%" . $cari['value'] . "%' or ", $cari_field);

            $query_where = " and (" . $isi_where . " like '%" . $cari['value'] . "%' ) ";
        } else {
            $query_where = "";
        }
		
        $query_sort = ($sort) ? " order by " . $sort . " " . $order : "order by a.kd_unit asc";

        $query_limit = ($limit) ? " limit " . $offset . ", " . $limit : "";

		$query = "select " . $query_select . " FROM t_gaji_os_btp a 
		LEFT JOIN mas_peg c ON a.no_peg = c.no_peg
		WHERE a.bulan = $bulan AND a.tahun = $tahun " . $query_where . " " . $query_sort . " " . $query_limit;
       
        return $this->db->query($query);
    }

    function simpan_pegawai_os($data){
        return $this->db->insert('mas_peg', $data);
    }
	
}
