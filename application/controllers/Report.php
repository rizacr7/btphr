<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

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
	public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('report_model');
		$this->load->model('func_global');

		if($this->session->userdata('role') == ""){
			redirect('Welcome/index');
		}
    }

    function saldohutang(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('report/saldo_hutang');
        $this->load->view('general/footer');
    }

	function kartuhutang(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('report/kartu_hutang');
        $this->load->view('general/footer');
    }

	function tab_hutang(){
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];

		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;
		$this->view_saldohutang($param);
        
	}

	function view_saldohutang($data){
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];

		echo "
		<table class='table table-bordered table-head-bg-primary table-bordered-bd-primary' width='100%'>
		<thead>
			<tr class='info'>
				<th>Kode Vendor</th>
				<th>Vendor</th>
				<th>Saldo Awal</th>
				<th>Debit</th>
				<th>Kredit</th>
				<th>Saldo Akhir</th>
			</tr>
		</thead>
		<tbody>";

        $no = 1;
		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;
        $DataResult = $this->report_model->get_saldohutang($param);
		$Param  = array();
		$Param['DataResult'] = $DataResult;
		
		$sumsaldoawal=0;
		$sumdebit=0;
		$sumkredit=0;
		$sumsaldoakhir=0;
        foreach ($DataResult as $dt) {

            echo "<tr>
				<td>" . $dt->kd_vendor . "</td>
				<td>" . $dt->nm_vendor . "</td>
				<td style=text-align:right>" . $this->func_global->duit($dt->saldo_awal) . "</td>
				<td style=text-align:right>" . $this->func_global->duit($dt->debit) . "</td>
				<td style=text-align:right>" . $this->func_global->duit($dt->kredit) . "</td>
				<td style=text-align:right>" . $this->func_global->duit($dt->saldo_akhir) . "</td>
			</tr>";
            $no++;
			$sumsaldoawal+=$dt->saldo_awal;
			$sumdebit+=$dt->debit;
			$sumkredit+=$dt->kredit;
			$sumsaldoakhir+=$dt->saldo_akhir;
        }
		
        echo "
			<tr>
				<td colspan='2'><b>TOTAL</b></td>
				<td style=text-align:right><b>" . $this->func_global->duit($sumsaldoawal) . "</b></td>
				<td style=text-align:right><b>" . $this->func_global->duit($sumdebit) . "</b></td>
				<td style=text-align:right><b>" . $this->func_global->duit($sumkredit) . "</b></td>
				<td style=text-align:right><b>" . $this->func_global->duit($sumsaldoakhir) . "</b></td>
			</tr>
		</tbody>
		</table>";
	}

	function sinkron_hutang(){
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];

		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;
		$SinkronSaldo = $this->report_model->sinkron_saldo_hutang($param);
		
	}

	function excel_saldohutang(){
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];

		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=lap_hutang_".$bulan."_".$tahun.".xls");//ganti nama sesuai keperluan
		header("Pragma: no-cache");
		header("Expires: 0");

		echo "
		<table>
			<tr><th colspan='6'>LAPORAN SALDO HUTANG SEWA</th></tr>
			<tr><th colspan='6'>PERIODE: " . strtoupper(date('F', mktime(0, 0, 0, $bulan, 10))) . " {$tahun}</th></tr>
		</table>
		<br>";

		echo "
		<table border='1'>
		<thead>
			<tr class='info'>
				<th>Kode Vendor</th>
				<th>Vendor</th>
				<th>Saldo Awal</th>
				<th>Debit</th>
				<th>Kredit</th>
				<th>Saldo Akhir</th>
			</tr>
		</thead>
		<tbody>";

        $no = 1;
		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;
        $DataResult = $this->report_model->get_saldohutang($param);
		$Param  = array();
		$Param['DataResult'] = $DataResult;
		
		$sumsaldoawal=0;
		$sumdebit=0;
		$sumkredit=0;
		$sumsaldoakhir=0;
        foreach ($DataResult as $dt) {

            echo "<tr>
				<td>" . $dt->kd_vendor . "</td>
				<td>" . $dt->nm_vendor . "</td>
				<td style=text-align:right>" . $dt->saldo_awal . "</td>
				<td style=text-align:right>" . $dt->debit . "</td>
				<td style=text-align:right>" . $dt->kredit . "</td>
				<td style=text-align:right>" . $dt->saldo_akhir . "</td>
			</tr>";
            $no++;
			$sumsaldoawal+=$dt->saldo_awal;
			$sumdebit+=$dt->debit;
			$sumkredit+=$dt->kredit;
			$sumsaldoakhir+=$dt->saldo_akhir;
        }
		
        echo "
			<tr>
				<td colspan='2'><b>TOTAL</b></td>
				<td style=text-align:right><b>" . $sumsaldoawal . "</b></td>
				<td style=text-align:right><b>" . $sumdebit . "</b></td>
				<td style=text-align:right><b>" . $sumkredit . "</b></td>
				<td style=text-align:right><b>" . $sumsaldoakhir . "</b></td>
			</tr>
		</tbody>
		</table>";
	}

	//--- kartu hutang ---
	function tab_kartuhutang(){
		$tanggal = $_POST['tanggal'];
		$tanggal = $this->func_global->tgl_dsql($tanggal);
		$day = $this->func_global->bulanThn($tanggal);
		$dayAwal = $day."01";
		
		$bulan = $this->func_global->month($tanggal);
		$tahun = $this->func_global->year($tanggal);
		
		$vendor = "SELECT a.kd_vendor,b.nm_vendor FROM t_saldo_hutang a 
		LEFT JOIN m_vendor b ON a.kd_vendor = b.kd_vendor 
		WHERE a.bulan = '$bulan' AND a.tahun = '$tahun' GROUP BY a.kd_vendor 
		ORDER BY a.kd_vendor ASC";
		$result = $this->db->query($vendor);
		$l	= 0;
		$row   = array(); 
		
		$grand_saldoawal =0;
		$grand_debit =0;
		$grand_kredit =0;
		$grand_saldoakhir =0;

		foreach ($result->result() as $r) {
			$row[$l]['kd_vendor'] = $r->kd_vendor;
			$row[$l]['nm_vendor'] = $r->nm_vendor;
			
			echo "
			<table>
				<tr>
					<th>".$r->kd_vendor." - ".$r->nm_vendor."</th>
				</tr>
			</table>";
			
			echo "
			<table class='table table-bordered table-head-bg-primary table-bordered-bd-primary'>
			<tr>
				<td style=\"text-align: center; width:15%\">TGL.TRANSAKSI</td>
				<td style=\"text-align: center; width:10%\">NO.BUKTI</td>
				<td style=\"text-align: center; width:15%\">NO.INVOICE</td>
				<td style=\"text-align: center; width:15%\">SALDO AWAL</td>
				<td style=\"text-align: center; width:10%\">DEBIT</td>
				<td style=\"text-align: center; width:10%\">KREDIT</td>
				<td style=\"text-align: center; width:15%\">SALDO AKHIR</td>	 				  
			</tr>";

			$bi = "SELECT m.*,SUM( IF (c.jmlh_bayar IS NULL,0,c.jmlh_bayar)) AS jmlh_bayar_lalu FROM (SELECT a.*,SUM( IF (b.jmlh_bayar IS NULL,0,b.jmlh_bayar)) AS jmlh_bayar
			FROM t_hutang a 
			LEFT JOIN (SELECT * FROM t_bayar_hutang WHERE (tgl_bayar BETWEEN '$dayAwal' AND '$tanggal')) b ON a.no_bukti_bi = b.no_bukti_bi
			WHERE a.kd_vendor = '$r->kd_vendor' AND substr(a.no_bukti_bi,1,2) = 'HS' AND a.tgl_bi >= '2023-06-01' AND a.tgl_bi <= '$tanggal' AND (a.tgl_done IS NULL OR a.tgl_done >= '$dayAwal') 
			GROUP BY a.no_bukti_bi) m 
			LEFT JOIN (SELECT * FROM t_bayar_hutang WHERE (tgl_bayar < '$dayAwal' OR tgl_bayar IS NULL)) c ON m.no_bukti_bi = c.no_bukti_bi
			GROUP BY m.no_bukti_bi ORDER BY m.tgl_bi ASC ";

			$result2 = $this->db->query($bi);
			$i	= 0;
			$row   = array(); 
			$sum_saldoawal =0;
			$sum_bayar_brg = 0;
			$sum_hutang_brg = 0;
			$sum_saldoakhir = 0;
			foreach ($result2->result() as $d) {
				$row[$i]['tgl_bi'] = $d->tgl_bi;
				$row[$i]['tgl_jth_tempo'] = $d->tgl_jth_tempo;
				$row[$i]['no_bukti_bi'] = $d->no_bukti_bi;
				$row[$i]['jmlh_hutang'] = $d->jmlh_hutang;
				$row[$i]['jmlh_bayar'] = $d->jmlh_bayar;
				$row[$i]['jmlh_bayar_lalu'] = $d->jmlh_bayar_lalu;
				
				$bln_bi = $this->func_global->month($d->tgl_bi);
				$thn_bi = $this->func_global->year($d->tgl_bi);

				
				if($bulan == $bln_bi && $tahun == $thn_bi){
					$saldo_awal = 0;
					$debit = $d->jmlh_hutang;
				}
				else{
					$saldo_awal =  $d->jmlh_hutang - $d->jmlh_bayar_lalu;
					$debit = 0;
				}
				
				$saldo_akhir = $saldo_awal - $d->jmlh_bayar + $debit;
				
				$sum_saldoawal +=$saldo_awal;
				$sum_bayar_brg += $d->jmlh_bayar;
				$sum_hutang_brg += $debit;
				$sum_saldoakhir += $saldo_akhir;

				// --- cek invoice ---
				$queryInv = "select * from t_bi_sewa where no_bukti_bi = '$d->no_bukti_bi'";
				$rinv = $this->db->query($queryInv)->result();
				$noinvoice = $rinv[0]->no_invoice;

				echo "
				<tr>
					<td>".$this->func_global->dsql_tgl($d->tgl_bi)."</td>					
					<td>$d->no_bukti_bi</td>
					<td>".$noinvoice."</td>
					<td style='text-align:right'>".$this->func_global->duit($saldo_awal)."</td>
					<td style='text-align:right'>".$this->func_global->duit($debit)."</td>
					<td style='text-align:right'>".$this->func_global->duit($d->jmlh_bayar)."</td>
					<td style='text-align:right'>".$this->func_global->duit($saldo_akhir)."</td>
				</tr>
				";
			}
				echo "
					<tr class='default'>
						<th colspan=3>TOTAL</th>
						<td style='text-align:right'><b>".$this->func_global->duit($sum_saldoawal)."</b></td>
						<td style='text-align:right'><b>".$this->func_global->duit($sum_hutang_brg)."</b></td>
						<td style='text-align:right'><b>".$this->func_global->duit($sum_bayar_brg)."</b></td>
						<td style='text-align:right'><b>".$this->func_global->duit($sum_saldoakhir)."</b></td>
					</tr>
				</table>";
				
				$grand_saldoawal +=$sum_saldoawal;
				$grand_debit +=$sum_hutang_brg;
				$grand_kredit +=$sum_bayar_brg;
				$grand_saldoakhir +=$sum_saldoakhir;
		}

		echo "<table class='table table-bordered table-head-bg-info table-bordered-bd-info mt-4' width='100%'>
			<tr>
				<td><b>Total Saldo Awal</b></td>
				<td><b>Total Debit</b></td>
				<td><b>Total Kredit</b></td>
				<td><b>Total Saldo Akhir</b></td>
			</tr>
			<tr>
				<td style='text-align:right'><b>".$this->func_global->duit($grand_saldoawal)."</b></td>
				<td style='text-align:right'><b>".$this->func_global->duit($grand_debit)."</b></td>
				<td style='text-align:right'><b>".$this->func_global->duit($grand_kredit)."</b></td>
				<td style='text-align:right'><b>".$this->func_global->duit($grand_saldoakhir)."</b></td>
			</tr>
		</table>";
	}

	function excel_kartuhutang(){

		$tanggal = $_GET['tanggal'];
		$tanggal = $this->func_global->tgl_dsql($tanggal);
		$day = $this->func_global->bulanThn($tanggal);
		$dayAwal = $day."01";
		
		$bulan = $this->func_global->month($tanggal);
		$tahun = $this->func_global->year($tanggal);
		
		$vendor = "SELECT a.kd_vendor,b.nm_vendor FROM t_saldo_hutang a 
		LEFT JOIN m_vendor b ON a.kd_vendor = b.kd_vendor 
		WHERE a.bulan = '$bulan' AND a.tahun = '$tahun' GROUP BY a.kd_vendor 
		ORDER BY a.kd_vendor ASC";
		$result = $this->db->query($vendor);
		$l	= 0;
		$row   = array(); 
		
		$grand_saldoawal =0;
		$grand_debit =0;
		$grand_kredit =0;
		$grand_saldoakhir =0;

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=lap_kartuhutang_".$bulan."_".$tahun.".xls");//ganti nama sesuai keperluan
		header("Pragma: no-cache");
		header("Expires: 0");

		echo "
		<table>
			<tr><th colspan='6'>LAPORAN KARTU HUTANG SEWA</th></tr>
			<tr><th colspan='6'>PERIODE: " . strtoupper(date('F', mktime(0, 0, 0, $bulan, 10))) . " {$tahun}</th></tr>
		</table>
		<br>";

		foreach ($result->result() as $r) {
			$row[$l]['kd_vendor'] = $r->kd_vendor;
			$row[$l]['nm_vendor'] = $r->nm_vendor;
			
			echo "
			<table>
				<tr>
					<td colpsan='7'>".$r->kd_vendor." - ".$r->nm_vendor."</td>
				</tr>
			</table>";
			
			echo "
			<table border='1'>
			<tr>
				<td style=\"text-align: center; width:15%\">TGL.TRANSAKSI</td>
				<td style=\"text-align: center; width:10%\">NO.BUKTI</td>
				<td style=\"text-align: center; width:15%\">NO.INVOICE</td>
				<td style=\"text-align: center; width:15%\">SALDO AWAL</td>
				<td style=\"text-align: center; width:10%\">DEBIT</td>
				<td style=\"text-align: center; width:10%\">KREDIT</td>
				<td style=\"text-align: center; width:15%\">SALDO AKHIR</td>	 				  
			</tr>";

			$bi = "SELECT m.*,SUM( IF (c.jmlh_bayar IS NULL,0,c.jmlh_bayar)) AS jmlh_bayar_lalu FROM (SELECT a.*,SUM( IF (b.jmlh_bayar IS NULL,0,b.jmlh_bayar)) AS jmlh_bayar
			FROM t_hutang a 
			LEFT JOIN (SELECT * FROM t_bayar_hutang WHERE (tgl_bayar BETWEEN '$dayAwal' AND '$tanggal')) b ON a.no_bukti_bi = b.no_bukti_bi
			WHERE a.kd_vendor = '$r->kd_vendor' AND substr(a.no_bukti_bi,1,2) = 'HS' AND a.tgl_bi >= '2023-06-01' AND a.tgl_bi <= '$tanggal' AND (a.tgl_done IS NULL OR a.tgl_done >= '$dayAwal') 
			GROUP BY a.no_bukti_bi) m 
			LEFT JOIN (SELECT * FROM t_bayar_hutang WHERE (tgl_bayar < '$dayAwal' OR tgl_bayar IS NULL)) c ON m.no_bukti_bi = c.no_bukti_bi
			GROUP BY m.no_bukti_bi ORDER BY m.tgl_bi ASC ";

			$result2 = $this->db->query($bi);
			$i	= 0;
			$row   = array(); 
			$sum_saldoawal =0;
			$sum_bayar_brg = 0;
			$sum_hutang_brg = 0;
			$sum_saldoakhir = 0;
			foreach ($result2->result() as $d) {
				$row[$i]['tgl_bi'] = $d->tgl_bi;
				$row[$i]['tgl_jth_tempo'] = $d->tgl_jth_tempo;
				$row[$i]['no_bukti_bi'] = $d->no_bukti_bi;
				$row[$i]['jmlh_hutang'] = $d->jmlh_hutang;
				$row[$i]['jmlh_bayar'] = $d->jmlh_bayar;
				$row[$i]['jmlh_bayar_lalu'] = $d->jmlh_bayar_lalu;
				
				$bln_bi = $this->func_global->month($d->tgl_bi);
				$thn_bi = $this->func_global->year($d->tgl_bi);

				
				if($bulan == $bln_bi && $tahun == $thn_bi){
					$saldo_awal = 0;
					$debit = $d->jmlh_hutang;
				}
				else{
					$saldo_awal =  $d->jmlh_hutang - $d->jmlh_bayar_lalu;
					$debit = 0;
				}
				
				$saldo_akhir = $saldo_awal - $d->jmlh_bayar + $debit;
				
				$sum_saldoawal +=$saldo_awal;
				$sum_bayar_brg += $d->jmlh_bayar;
				$sum_hutang_brg += $debit;
				$sum_saldoakhir += $saldo_akhir;

				// --- cek invoice ---
				$queryInv = "select * from t_bi_sewa where no_bukti_bi = '$d->no_bukti_bi'";
				$rinv = $this->db->query($queryInv)->result();
				$noinvoice = $rinv[0]->no_invoice;

				echo "
				<tr>
					<td>".$this->func_global->dsql_tgl($d->tgl_bi)."</td>					
					<td>$d->no_bukti_bi</td>
					<td>".$noinvoice."</td>
					<td style='text-align:right'>".$this->func_global->duit($saldo_awal)."</td>
					<td style='text-align:right'>".$this->func_global->duit($debit)."</td>
					<td style='text-align:right'>".$this->func_global->duit($d->jmlh_bayar)."</td>
					<td style='text-align:right'>".$this->func_global->duit($saldo_akhir)."</td>
				</tr>
				";
			}
				echo "
					<tr class='default'>
						<th colspan=3>TOTAL</th>
						<td style='text-align:right'><b>".$this->func_global->duit($sum_saldoawal)."</b></td>
						<td style='text-align:right'><b>".$this->func_global->duit($sum_hutang_brg)."</b></td>
						<td style='text-align:right'><b>".$this->func_global->duit($sum_bayar_brg)."</b></td>
						<td style='text-align:right'><b>".$this->func_global->duit($sum_saldoakhir)."</b></td>
					</tr>
				</table>";
				
				$grand_saldoawal +=$sum_saldoawal;
				$grand_debit +=$sum_hutang_brg;
				$grand_kredit +=$sum_bayar_brg;
				$grand_saldoakhir +=$sum_saldoakhir;
		}

		echo "
		<p></p>
		<table border='1'>
			<tr class='info'>
				<td><b>Total Saldo Awal</b></td>
				<td><b>Total Debit</b></td>
				<td><b>Total Kredit</b></td>
				<td><b>Total Saldo Akhir</b></td>
			</tr>
			<tr>
				<td style='text-align:right'><b>".$this->func_global->duit($grand_saldoawal)."</b></td>
				<td style='text-align:right'><b>".$this->func_global->duit($grand_debit)."</b></td>
				<td style='text-align:right'><b>".$this->func_global->duit($grand_kredit)."</b></td>
				<td style='text-align:right'><b>".$this->func_global->duit($grand_saldoakhir)."</b></td>
			</tr>
		</table>";

	}
}
