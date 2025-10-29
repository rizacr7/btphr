<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends CI_Controller {

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
        $this->load->model('tagihan_model');
		$this->load->model('func_global');
		$this->load->library("pdf");

		if($this->session->userdata('role') == ""){
			redirect('Welcome/index');
		}
    }

    function invoice_sewa(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('invoice/v_invoice');
        $this->load->view('general/footer');
    }

	function tab_invoice(){
		echo "<table id='table_inv' class='table table-bordered dt-responsive table-head-bg-primary table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th>Tanggal</th>
				<th>No.Bukti</th>
				<th>No.Invoice</th>
				<th>Vendor</th>
				<th>Tgl.Jth Tempo</th>		
				<th>Hutang Sewa</th>		
			</tr>
		</thead>
		<tbody>";
		
		$data = $this->tagihan_model->get_data_invoice("", "", "", 0, 0);
		$no = 1;
		
		$month_now = date('m');
		$year_now = date('Y');
		
        foreach ($data->result_array() as $key => $value) {
			
			$no_bukti_bi = $value['no_bukti_bi'];
			
			// $tahun = $this->func_global->year($value['tgl_input']);
			// $bulan = $this->func_global->month($value['tgl_input']);
			
			$cekdt = "select sum(hrg_satuan) as hutangsewa from t_bi_sewa_detail where no_bukti_bi = '$no_bukti_bi'";
			$rdt = $this->db->query($cekdt)->result();
			$hutangsewa = $rdt[0]->hutangsewa;
			
            echo "<tr>
				<td>" . $no . "</td>
				<td>" . $this->func_global->dsql_tgl($value['tgl_bi']) . "</td>
				<td>" . $value['no_bukti_bi'] . "</td>
				<td>" . $value['no_invoice'] . "</td>
				<td>" . $value['nm_vendor'] . "</td>
				<td>" . $this->func_global->dsql_tgl($value['tgl_jth_tempo']) . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($hutangsewa) . "</td>
			</tr>";
            $no++;
		
        }
			
		echo "</tbody>
		</table>
		<style>
			.selected td {
				background-color: #c6ccdcff; !important;
			}
		</style>
		<script>
			$('#table_inv ').DataTable({
				responsive:'true',
				select: {style: 'single'},
				
			});
		</script>";
	}

	function create_tagihan(){
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];
		$kd_vendor = $_POST['kd_vendor'];
		$jns_ppn = $_POST['jns_ppn'];
		$jns_pph = $_POST['jns_pph'];
		
		$tgl_bi = $tahun."-".$bulan."-01";
		$lama_tempo =30;
		
		$newdate = strtotime ( '+'.$lama_tempo. 'day' , strtotime ( $tgl_bi ) ) ; 
		$jthTempo = date ( 'Y-m-d' , $newdate ); //untuk menyimpan ke dalam variabel baru
		
		//--cek spk aktif ---
		$qspk = "select * from t_spk where kd_vendor='$kd_vendor' and flag_spk <> 0 and flag_stop = 0 and is_del = 0";
		$rspk = $this->db->query($qspk)->result();
		foreach($rspk as $dspk){
			$no_ref_spk = $dspk->no_ref_spk;
			$no_bukti_spk = $dspk->no_bukti_spk;

			//--cek data bi ----
			$qbi = "select * from t_bi_sewa where no_ref_spk='$no_ref_spk' and kd_vendor='$kd_vendor' and month(tgl_bi)=$bulan and year(tgl_bi)=$tahun";
			$rbi = $this->db->query($qbi)->num_rows();
			if($rbi == 0){
				$param = array();
				$param['tanggal'] = $tgl_bi;
				$param['kd'] = 'HS';
				$bukti_bi = $this->tagihan_model->get_bukti($param);
			
				$data_bi = array(
					'no_bukti_bi' => $bukti_bi,
					'tgl_bi' => $tgl_bi,
					'no_ref_spk' => $no_ref_spk,
					'kd_vendor' => $kd_vendor,
					'pajak' => $jns_ppn,
					'jns_pph' => $jns_pph,
					'tgl_jth_tempo' => $jthTempo,
					'user_id' => $this->session->userdata('username')
				);
				
				$this->db->insert('t_bi_sewa', $data_bi);

				//---detail nopol ---
				$qspkdet = "select * from t_spk_detail where no_bukti_spk='$no_bukti_spk' and flag_stop_sewa=0";
				$rspkdet = $this->db->query($qspkdet)->result();
				foreach($rspkdet as $dspkdet){
					$nopol = $dspkdet->nopol;
					$kd_kendaraan = $dspkdet->kd_kendaraan;
					$dpp_sewa = $dspkdet->dpp_sewa;
					$ppn_sewa = $dspkdet->ppn_sewa;
					$hrg_sewa = $dspkdet->hrg_sewa;
					$kd_unit = $dspkdet->kd_unit;

					if($jns_pph == "PPH23"){
						if($kd_vendor == 'S07220001'){
							$jm_pph = round(($dpp_sewa*0.04),2);
						}
						else{
							$jm_pph = round(($dpp_sewa*0.02),2);
						}
					}
					else if($jns_pph == "PPH4"){
						$jm_pph = round(($dpp_sewa*0.005),2);
					}
					else{
						$jm_pph = 0;
					}
				
					$data_bidet = array(
						'no_bukti_bi' => $bukti_bi,
						'nopol' => $nopol,
						'kd_kendaraan' => $kd_kendaraan,
						'kd_unit' => $kd_unit,
						'hrg_satuan' => $hrg_sewa,
						'dpp' => $dpp_sewa,
						'ppn' => $ppn_sewa,
						'pph' => $jm_pph,
						'no_ref_spk' => $no_bukti_spk
					);
					
					$this->db->insert('t_bi_sewa_detail', $data_bidet);
				}
			}

			//-- insert t_hutang_sewa ---
			$param = array();
			$param['kd_vendor'] = $kd_vendor;
			$param['tanggal'] = $tgl_bi;
			$param['tgl_jth_tempo'] = $jthTempo;
			$param['jns_ppn'] = $jns_ppn;
			$param['jns_pph'] = $jns_pph;
			$param['no_bukti_bi'] = $bukti_bi;
			$this->tagihan_model->insert_hutang_sewa($param);

		}
		echo 1;
	}

	function hapus_tagihan(){
		$no_bukti_bi = $_POST['no_bukti_bi'];
		
		$this->db->where('no_bukti_bi', $no_bukti_bi);
		$this->db->delete('t_bi_sewa');
		
		$this->db->where('no_bukti_bi', $no_bukti_bi);
		$this->db->delete('t_bi_sewa_detail');

		//-----hapus t_hutang ---
		$this->db->where('no_bukti_bi', $no_bukti_bi);
		$this->db->delete('t_hutang');
		
		echo 1;
	}

	function v_databi(){
		$no_bukti_bi = $_POST['no_bukti_bi'];
		
		echo "<table id='table_inv' class='table table-bordered table-head-bg-primary table-bordered-bd-primary'>
		<tr>
			<td style=\"text-align: center;\"><b>NO</b></td>
			<td style=\"text-align: center;\"><b>KENDARAAN</b></td>
			<td style=\"text-align: center;\"><b>NOPOL</b></td>
			<td style=\"text-align: center;\"><b>HARGA SEWA</b></td>
			<td style=\"text-align: center;\"><b>DPP</b></td>
			<td style=\"text-align: center;\"><b>PPN</b></td>
			<td style=\"text-align: center;\"><b>PPH</b></td>
			<td style=\"text-align: center;\"><b>Action</b></td>
		</tr>";
		
		$detail = "SELECT a.*,b.nm_kendaraan FROM t_bi_sewa_detail a 
		LEFT JOIN m_kendaraan b ON a.kd_kendaraan = b.kd_kendaraan
		WHERE a.no_bukti_bi = '$no_bukti_bi'";
		
		$result = $this->db->query($detail);
		$rows = array(); 
		$i=0;
		$no=0;
		$sumtotal = 0;
		$sumdpp = 0;
		$sumppn = 0;
		$sumpph = 0;
		foreach ($result->result() as $dt) {
			$rows[$i]['id_bi'] = $dt->id_bi;
			$rows[$i]['no_ref_spk'] = $dt->no_ref_spk;
			$rows[$i]['nopol'] = $dt->nopol;
			$rows[$i]['hrg_satuan'] = $dt->hrg_satuan;
			$rows[$i]['dpp'] = $dt->dpp;
			$rows[$i]['ppn'] = $dt->ppn;
			$rows[$i]['pph'] = $dt->pph;
			$rows[$i]['nm_kendaraan'] = $dt->nm_kendaraan;
			$no++;
			
			$dpp = $dt->dpp;
			$ppn = $dt->ppn;
			$pph = $dt->pph;

			$btnhapus = "<button class='btn btn-danger btn-sm' onclick=deletebi('$dt->id_bi')><i class='fa fa-trash'></i></button>";
			$btnedit = "<button class='btn btn-warning btn-sm' onclick=editbi('$dt->id_bi')><i class='fa fa-pen'></i></button>";
			
			echo "<tr>
				<td>$no</td>
				<td>$dt->nm_kendaraan</td>
				<td>$dt->nopol</td>

				<td style='text-align: right'>".$this->func_global->duit($dt->hrg_satuan)."</td>
				<td style='text-align: right'>".$this->func_global->duit($dpp)."</td>
				<td style='text-align: right'>".$this->func_global->duit($ppn)."</td>
				<td style='text-align: right'>".$this->func_global->duit($pph)."</td>
				<td>$btnedit $btnhapus</td>
			</tr>";
			$sumtotal += $dt->hrg_satuan;
			$sumdpp += $dpp;
			$sumppn += $ppn;
			$sumpph += $pph;
		}
			echo "
			<tr>
				<td colspan='3'>TOTAL</td>
				<td style='text-align: right'>".$this->func_global->duit($sumtotal)."</td>
				<td style='text-align: right'>".$this->func_global->duit($sumdpp)."</td>
				<td style='text-align: right'>".$this->func_global->duit($sumppn)."</td>
				<td style='text-align: right'>".$this->func_global->duit($sumpph)."</td>
			</tr>
		</table>";
		
	}

	function hapus_bidetail(){
		$id_bi = $_POST['id_bi'];

		//---cek nomer bukti bi ---
		$qbidetail = "SELECT no_bukti_bi FROM t_bi_sewa_detail where id_bi = '$id_bi'";
		$result = $this->db->query($qbidetail)->result();
		$no_bukti_bi = $result[0]->no_bukti_bi;
		
		$this->db->where('id_bi', $id_bi);
		$this->db->delete('t_bi_sewa_detail');

		// --- update t_hutang ----
		$queryBI = "SELECT * FROM t_bi_sewa WHERE no_bukti_bi = '$no_bukti_bi'";
		$resultBI = $this->db->query($queryBI)->row();
		$kd_vendor = $resultBI->kd_vendor;
		$tgl_bi = $resultBI->tgl_bi;
		$no_bukti_bi = $resultBI->no_bukti_bi;
		$tgl_jth_tempo = $resultBI->tgl_jth_tempo;
		$jns_pph = $resultBI->jns_pph;
		$jns_ppn = $resultBI->pajak;	

		//-- insert t_hutang_sewa ---
		$param = array();
		$param['kd_vendor'] = $kd_vendor;
		$param['tanggal'] = $tgl_bi;
		$param['tgl_jth_tempo'] = $tgl_jth_tempo;
		$param['jns_ppn'] = $jns_ppn;
		$param['jns_pph'] = $jns_pph;
		$param['no_bukti_bi'] = $no_bukti_bi;
		$this->tagihan_model->insert_hutang_sewa($param);
		
		echo 1;
	}

	function ajaxdtbisewadtl(){
		$query = "select a.* from t_bi_sewa_detail a 
		where a.id_bi = '".$_GET['id_bi']."'";

		$result = $this->db->query($query)->row();
		echo json_encode($result);
	}

	function ajaxdtbisewa(){
		$query = "select a.*,b.nm_vendor from t_bi_sewa a 
		left join m_vendor b on a.kd_vendor = b.kd_vendor where a.no_bukti_bi = '".$_GET['no_bukti_bi']."'";

		$result = $this->db->query($query)->row();
		echo json_encode($result);
	}

	function simpan_bidetail_edit(){	
		$id_bi = $_POST['idbi'];
		$no_bukti_bi = $_POST['buktibi'];
		$hrg_sewa = $this->func_global->rupiah($_POST['jm_hrg']);

		$cekData = "select * from t_bi_sewa where no_bukti_bi = '$no_bukti_bi'";
		$data = $this->db->query($cekData)->result();
		$jns_ppn = $data[0]->pajak;
		$jns_pph = $data[0]->jns_pph;
		$kd_vendor = $data[0]->kd_vendor;

		if($jns_ppn == "Y"){
			$jm_Dpp = round(($hrg_sewa/1.11),2);
			$jm_ppn = round(($jm_Dpp*0.11),2);
		}
		else{
			$jm_Dpp = $hrg_sewa;
			$jm_ppn = 0;
		}

		if($jns_pph == "PPH23"){
			if($kd_vendor == 'S07220001'){
				$jm_pph = round(($jm_Dpp*0.04),2);
			}
			else{
				$jm_pph = round(($jm_Dpp*0.02),2);
			}
			
		}
		else if($jns_pph == "PPH4"){
			$jm_pph = round(($jm_Dpp*0.005),2);
		}
		else{
			$jm_pph = 0;
		}

		$data = array(
			'hrg_satuan' => $hrg_sewa,
			'dpp' => $jm_Dpp,
			'ppn' => $jm_ppn,
			'pph' => $jm_pph
		);
		
		$this->db->where('id_bi', $id_bi);
		$this->db->update('t_bi_sewa_detail', $data);

		// --- update t_hutang ----
		$queryBI = "SELECT * FROM t_bi_sewa WHERE no_bukti_bi = '$no_bukti_bi'";
		$resultBI = $this->db->query($queryBI)->row();
		$kd_vendor = $resultBI->kd_vendor;
		$tgl_bi = $resultBI->tgl_bi;
		$no_bukti_bi = $resultBI->no_bukti_bi;
		$tgl_jth_tempo = $resultBI->tgl_jth_tempo;
		$jns_pph = $resultBI->jns_pph;
		$jns_ppn = $resultBI->pajak;	

		//-- insert t_hutang_sewa ---
		$param = array();
		$param['kd_vendor'] = $kd_vendor;
		$param['tanggal'] = $tgl_bi;
		$param['tgl_jth_tempo'] = $tgl_jth_tempo;
		$param['jns_ppn'] = $jns_ppn;
		$param['jns_pph'] = $jns_pph;
		$param['no_bukti_bi'] = $no_bukti_bi;
		$this->tagihan_model->insert_hutang_sewa($param);

		echo 1;
	}

	function simpan_bi_invoice(){
		$no_invoice = $_POST['no_invoice'];
		$no_bukti_bi = $_POST['nobuktibi'];

		$data = array(
			'no_invoice' => $no_invoice
		);
		
		$this->db->where('no_bukti_bi', $no_bukti_bi);
		$this->db->update('t_bi_sewa', $data);
		echo 1;
	}

	function pdf_sewa(){
		$day = date("d-m-Y"); 	
		$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('za_riza');
		$pdf->SetTitle('PDF Purchase Order');
		$pdf->SetSubject('PDF Purchase Order');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		
		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// set margins
		$pdf->SetMargins(7, 25, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// ---------------------------------------------------------
		
		// set font
		$pdf->SetFont('dejavusans', '', 9);
	  	$no_bukti_bi = $_GET['no_bukti_bi'];
		$header = "select a.*,b.nm_vendor from t_bi_sewa a left join m_vendor b on a.kd_vendor = b.kd_vendor where no_bukti_bi = '$no_bukti_bi'";
	
		$rdt = $this->db->query($header)->result();
		$no_invoice = $rdt[0]->no_invoice;
		$nm_vendor = $rdt[0]->nm_vendor;
		$tgl_bi = $rdt[0]->tgl_bi;
		
	    $pdf->AddPage();
	  
	    // set text shadow effect
	    $html = '<html> 
			<body>
			<table width="600" border="0" align="left" cellpadding="0.9" cellspacing="0"> 
			<tr>
				<th colspan="6" align="center"><b><u>TAGIHAN SEWA KENDARAAN</u></b></th>
			</tr>
			</table><p></p>';
			
			$html .= '
			<table width="600" border="0">
				<tr>
					<td width="70">Tanggal</td>
					<td width="5">:</td>
					<td width="230">'.$this->func_global->dsql_tgl($tgl_bi).'</td>
					
					<td>No.Bukti</td>
					<td width="5">:</td>
					<td width="230">'.$no_bukti_bi.'</td>
				</tr>
				<tr>
					<td>Vendor</td>
					<td width="5">:</td>
					<td>'.$nm_vendor.'</td>
					
					<td>No.Invoice</td>
					<td width="5">:</td>
					<td>'.$no_invoice.'</td>
				</tr>
			</table><p></p>';

			$html .='
			<table width="600" cellpadding="2">
			<tr>
				<td class="garis" width="30" align="center">NO</td>
				<td class="garis" width="150" align="center">KENDARAAN</td>
				<td class="garis" width="100" align="center">NOPOL</td>
				<td class="garis" width="100" align="center">HRG.SEWA</td>
				<td class="garis" width="100" align="center">DPP</td>
				<td class="garis" width="90" align="center">PPN</td>
				<td class="garis" width="90" align="center">PPH</td>
			</tr>';

			$qdetail = "SELECT a.*,b.nm_kendaraan FROM t_bi_sewa_detail a 
			LEFT JOIN m_kendaraan b ON a.kd_kendaraan = b.kd_kendaraan
			WHERE a.no_bukti_bi = '$no_bukti_bi'";
			$result = $this->db->query($qdetail);
			$rows = array(); 
			$i=0;
			$no=0;
			$sumtotal = 0;
			$sumdpp = 0;
			$sumppn = 0;
			$sumpph = 0;
			foreach ($result->result() as $dt) {
				$rows[$i]['no_ref_spk'] = $dt->no_ref_spk;
				$rows[$i]['nopol'] = $dt->nopol;
				$rows[$i]['hrg_satuan'] = $dt->hrg_satuan;
				$rows[$i]['dpp'] = $dt->dpp;
				$rows[$i]['ppn'] = $dt->ppn;
				$rows[$i]['pph'] = $dt->pph;
				$rows[$i]['nm_kendaraan'] = $dt->nm_kendaraan;
				$no++;

				$html.='
				<tr>
					<td class="garis" style="text-align: center">'.$no.'</td>
					<td class="garis">'.$dt->nm_kendaraan.'</td>
					<td class="garis">'.$dt->nopol.'</td>
					<td class="garis" style="text-align: right">'.$this->func_global->duit($dt->hrg_satuan).'</td>
					<td class="garis" style="text-align: right">'.$this->func_global->duit($dt->dpp).'</td>
					<td class="garis" style="text-align: right">'.$this->func_global->duit($dt->ppn).'</td>
					<td class="garis" style="text-align: right">'.$this->func_global->duit($dt->pph).'</td>
				</tr>';

				$sumtotal += $dt->hrg_satuan;
				$sumdpp += $dt->dpp;
				$sumppn += $dt->ppn;
				$sumpph += $dt->pph;

			}
			$html.='
				<tr>
					<td class="garis" colspan="3"><b>TOTAL</b></td>

					<td class="garis" style="text-align: right"><b>'.$this->func_global->duit($sumtotal).'</b></td>
					<td class="garis" style="text-align: right"><b>'.$this->func_global->duit($sumdpp).'</b></td>
					<td class="garis" style="text-align: right"><b>'.$this->func_global->duit($sumppn).'</b></td>
					<td class="garis" style="text-align: right"><b>'.$this->func_global->duit($sumpph).'</b></td>
				</tr>
				</table>';
			
			$html .= '
				
			     <p></p> 
				<table width="3400" align="left"> 
			     	<tr>
			     		<td width="120"></td>
			     		<td width="150"></td>
			     		<td width="100"></td>
			     		<td width="100"></td>
			     		<td width="150">Gresik, '.$day.'</td>
			     	</tr>
			     	<tr>
			     		<td width="120"></td>
			     		<td width="150" style="text-align: center"></td>
			     		<td width="100"></td>
			     		<td width="100"></td>
			     		<td width="150">Dibuat</td>
			     	</tr>
			     	<tr>
			     		<td></td>
			     		<td></td>
			     		<td></td>
			     		<td></td>
			     	</tr>
			     	<tr>
			     		<td></td>
			     		<td></td>
			     		<td></td>
			     		<td></td>
			     	</tr>
			     	<tr>
			     		<td></td>
			     		<td></td>
			     		<td></td>
			     		<td></td>
			     	</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
			     	<tr>
			     		<td></td>
			     		<td></td>
			     		<td></td>
			     		<td></td>
			     		<td>_______________________</td>
			     	</tr>
			     	<tr>
			     		<td colspan="4"><font size="7"></font></td>
			     	</tr>
			     </table>
			      <style>
				    td.garis {
				        border-bottom:1px solid black;
				        border-top:1px solid black;
						border-right:1px solid black;
				        border-left:1px solid black;
				    }
				    td.total{
				        border-bottom:1px dotted black;
				        border-top:1px dotted black;
				    }
				    td.garis1{
				        border-top:1px solid black;
				    }
				    th.garis2{
				        border-top:1px solid black;
				    }
					th.garisb{
				        border-bottom:1px solid black;
				    }
				    td.garis3{
				        border-right:1px solid black;
				        border-left:1px solid black;
				    }
					
				</style> 
			</body>
			</html>'; 	
			
			
	    // Print text using writeHTMLCell()
	    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);  
	    $pdf->Output('pdf_inv_sewa.pdf', 'I');   
	}
}
