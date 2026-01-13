<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gajios extends CI_Controller {

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
        $this->load->model('btp_model');
		$this->load->model('ppu_model');
		$this->load->model('func_global');
		$this->load->library("pdf");

		if($this->session->userdata('role') == ""){
			redirect('Welcome/index');
		}

		$this->db_hrd20 = $this->load->database("hrd20", TRUE);
		 
    }

    function prosesgajios(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('proses/proses_gaji_os');
        $this->load->view('general/footer');
    }

	function proses_gajipegawai_os(){
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];

		$blnnow = date("m");
		$thnnow = date("Y");

		$cekdt = "select * from t_gaji_os_btp where bulan = '$bulan' and tahun = '$tahun' and flag_close = 1";
		$rdt = $this->db->query($cekdt)->num_rows();
		if($rdt == 0){
			if($bulan == $blnnow && $tahun == $thnnow){
			
				$reset = "delete from t_gaji_os_btp where bulan = '$bulan' and tahun = '$tahun'";
				$this->db->query($reset);
				
				$param = array();
				$param['bulan'] = $bulan;
				$param['tahun'] = $tahun;
				$resultgaji = $this->btp_model->prosesgajios($param);
				// $resultgaji = $this->btp_model->potongankasus($param);
				$resultgaji = $this->btp_model->prosesbpjs_os($param);

				echo 1;

			}
			else{
				echo 2;
			}
		}
		else{
			echo 2;
		}
	}

	function tab_gajipegawai(){
		echo "<table id='table_gaji' class='table table-bordered dt-responsive table-head-bg-danger table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th>No.Pegawai</th>
				<th>Nm.Pegawai</th>
				<th>Unit</th>
				<th>Level</th>
				<th>Gaji Pokok</th>
				<th>Tj.Lembur</th>
				<th>Tj.Pulsa</th>
				<th>Total Bruto</th>
				<th>BPJS TK</th>
				<th>BPJS Kesehatan</th>
				<th>BPJS JHT</th>
				<th>Potongan</th>
				<th>Total Netto</th>
				<th>Tgl.Approve</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
		$param = array();
		$param['bulan']  = $_POST['bulan'];
		$param['tahun']  = $_POST['tahun'];
        $data = $this->btp_model->get_data_gaji_os("", "", "", 0, 0,$param);
        foreach ($data->result_array() as $key => $value) {
			$tgl_app = "<label class='label label-info'>".$value['tgl_app']."</label>";

			if($value['flag_close'] == 0){
				$status = "<span class='badge badge-warning'>Pending</span>";
			}
			else{
				$status = "<span class='badge badge-success'>Approved</span>";
			}

			//---unit---
			$queryunit = "select * from m_unit where kd_unit = '".$value['kd_unit']."'";
			$runit = $this->db_hrd20->query($queryunit)->result();
			$nm_unit = $runit[0]->nm_unit;

			$querylevel = "select * from level_maspeg where id_level = '".$value['kd_level']."'";
			$rdata = $this->db_hrd20->query($querylevel)->num_rows();
			if($rdata == 0){
				$ket_level = "-";
			}
			else{
				$rlevel = $this->db_hrd20->query($querylevel)->result();
				$ket_level = $rlevel[0]->ket_level;
			}
			
            echo "<tr>
				<td>" . $no . "</td>
				<td>" . $value['no_peg'] . "</td>
				<td>" . $value['na_peg'] . "</td>
				<td>".$nm_unit."</td>
				<td>".$ket_level."</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['gaji_os']) . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['tj_lembur']) . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['tj_pulsa']) . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['jm_bruto']) . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['bpjs']) . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['jamsostek']) . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['jht']) . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['potongan']) . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['jm_netto']) . "</td>
				<td>" . $tgl_app. "</td>
				<td>" . $status. "</td>
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
			$('#table_gaji').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
	}

	function proses_ppusifina(){
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];
		$jenis = $_POST['jenis'];

		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;
		$param['jenis'] = $jenis;

		if($jenis == 1){
			$Datappu = $this->ppu_model->ppu_gaji($param);
		}
		else if($jenis == 2 || $jenis == 3 || $jenis == 4){
			$Datappu = $this->ppu_model->ppu_bpjs($param);
		}

		if($Datappu == 3){
			echo 400;
			return false;
		}
		else{
			echo 200;
		}
		
	}

	function tab_ppu(){
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];
		$jenis = $_POST['jenis'];
		
		echo "
		<table class='table table-bordered dt-responsive table-head-bg-danger table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No</th>
				<th>No.Bukti</th>
				<th>Kd.Pengguna</th>
				<th>Nm.Pengguna</th>
				<th>Kd.Perusahaan</th>
				<th>Keterangan</th>
				<th>Jumlah</th>
				<th>Cetak</th>
			</tr>
		</thead>
		<tbody>";
		
		$no = 1;
		
		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;
		$param['jenis'] = $jenis;
		
		$DataResult = $this->ppu_model->get_ppu_sdm($param);
		$Param  = array();
		$Param['DataResult'] = $DataResult;
		
		$sumtotal = 0;
		
		foreach ($DataResult as $dt) {
			
			$btncetak = "<button class='btn btn-info btn-sm' onclick=pdfcetak('$dt->bukti')><i class='fas fa-print'></i></button>";
			$btnedit = "<button class='btn btn-warning btn-sm' onclick=editppu('$dt->bukti')>Edit</button>";

			echo "<tr>
				<td>" . $no . "</td>
				<td>" . $dt->bukti . "</td>
				<td>" . $dt->kd_pengguna . "</td>
				<td>" . $dt->nm_pengguna . "</td>
				<td>" . $dt->unit . "</td>
				<td>" . $dt->keterangan . "</td>
				<td style=text-align:right>" . $this->func_global->duit($dt->jumlah) . "</td>
				<td>".$btncetak."</td>
			</tr>";
		}
		
		echo "
		</tbody>
		</table>";
	}

	public function pdf_ppu_bukti() {
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
		$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// ---------------------------------------------------------
		
		// set font
		$pdf->SetFont('helvetica', '', 10);
		
	    $pdf->AddPage();
		
		$head = "select a.*,b.jns_ppu,b.bank,b.atas_nama,b.no_rek from t_pplsdm a left join m_jnsppu b on b.id_ppu = a.jns_trans where a.bukti = '".$_GET['bukti']."' and a.flag_hapus = 0";
		$r_head = $this->db->query($head)->result();
		$bukti = $r_head[0]->bukti;
		$kd_pengguna = $r_head[0]->kd_pengguna;
		$nm_pengguna = $r_head[0]->nm_pengguna;
		$unit = $r_head[0]->unit;
		$jumlah = $r_head[0]->jumlah;
		$keterangan = $r_head[0]->keterangan;
		$jns_ppu = $r_head[0]->jns_ppu;

		$no_rek= $r_head[0]->no_rek;
		$bank =$r_head[0]->bank;
		$atasnama = $r_head[0]->atas_nama;
		
		
		$htmls = '
		<p></p>
		<p></p>
		<table width="650" border="0" align="left" cellpadding="0.7" cellspacing="0.3">
			<tr>
				<td align="center" colspan="3"><b>PERMINTAAN PEMBAYARAN SDM</b></td>
			</tr>
			<tr>
				<td align="center" colspan="3"><b>Nomor : '.$bukti.'</b></td>
			</tr>
		</table>';
		
		$pdf->writeHTML($htmls, true, false, true, false, '');

		$style = array(
			'position' => '',
			'align' => 'L',
			'stretch' => false,
			'fitwidth' => true,
			'cellfitalign' => '',
			'border' => false,
			'hpadding' => 'auto',
			'vpadding' => 'auto',
			'fgcolor' => array(0,0,0),
			'bgcolor' => false,
			'text' => false,
			'font' => 'helvetica',
			'fontsize' => 8,
			'stretchtext' => 10
		);
		
		$pdf->write1DBarcode($bukti, 'C128', '', '', '', 20, 0.4, $style, 'N');
		$day = date("d-m-Y");
		$html = '
		<table width="650" border="0" align="left" cellpadding="2" cellspacing="2">
			<tr>
				<td align="left" width="150" >Jenis Pembayaran</td>
				<td align="left" width="10">:</td>
				<td align="left" width="480">'.$jns_ppu.'</td>
			</tr>
			<tr>
				<td align="left" width="150" >Tanggal</td>
				<td align="left" width="10">:</td>
				<td align="left" width="480">'.$day.'</td>
			</tr>
			<tr>
				<td align="left" width="150" >Kd.Pengguna</td>
				<td align="left" width="10">:</td>
				<td align="left" width="480">'.$kd_pengguna.'</td>
			</tr>
			<tr>
				<td align="left" width="150" >Nm.Pengguna</td>
				<td align="left" width="10">:</td>
				<td align="left" width="480">'.$nm_pengguna.'</td>
			</tr>
			<tr>
				<td align="left" width="150">Jumlah</td>
				<td align="left" width="10">:</td>
				<td align="left" width="480">'.$this->func_global->duit($jumlah).'</td>
			</tr>
			<tr>
				<td align="left" width="150">Keterangan</td>
				<td align="left" width="10">:</td>
				<td align="left" width="480">'.$keterangan.'</td>
			</tr>
			<tr>
				<td colspan=""><b><u>Ditransfer Ke :</u></b></td>
			</tr>
			<tr>
				<td align="left" width="150">Bank</td>
				<td align="left" width="10">:</td>
				<td align="left" width="480">'.$bank.'</td>
			</tr>
			<tr>
				<td align="left" width="150">No.Rekening</td>
				<td align="left" width="10">:</td>
				<td align="left" width="480">'.$no_rek.'</td>
			</tr>
			<tr>
				<td align="left" width="150">Atas Nama</td>
				<td align="left" width="10">:</td>
				<td align="left" width="480">'.$atasnama.'</td>
			</tr>
		</table>';
		
		// $ttdkabag = $this->m_laporan->get_ttdkabag();
		// $nm_ttd_kabag = $ttdkabag [0]->nm_ttd;
		// $jab_kabag = $ttdkabag [0]->jabatan;
		
		// $ttdasmen = $this->m_laporan->get_ttdasmen();
		// $nm_ttd_asmen = $ttdasmen [0]->nm_ttd;
		// $jab_asmen = $ttdasmen [0]->jabatan;

		// $ttdkeuangan = $this->m_laporan->get_ttdkeuangan();
		// $nm_ttd_keuangan = $ttdkeuangan [0]->nm_ttd;

		// $ttdakuntansi = $this->m_laporan->get_ttdakuntansi();
		// $nm_ttd_akuntansi = $ttdakuntansi [0]->nm_ttd;

		// $ttdbendahara = $this->m_laporan->get_ttdbendahara();
		// $nm_ttd_bendahara = $ttdbendahara [0]->nm_ttd;

		// $ttdketua = $this->m_laporan->get_ttdketua();
		// $nm_ttd_ketua = $ttdketua [0]->nm_ttd;
		
		$html .= '
		<p></p>
		 <table width="600" align="center" border="0"> 
			<tr>
				<td width="300"></td>
				<td width="300">Gresik, '.$day.'</td>
			</tr>
			<tr>
				<td width="300">Manager</td>
				<td width="300">Ass.Manager</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>____________</td>
				<td>____________</td>
			</tr>
			<tr>
				<td width="300">Manager Keuangan</td>
				<td width="300">Manager Akuntansi</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>_____________</td>
				<td>_____________</td>
			</tr>
			<tr>
				<td width="300">Pengurus</td>
				<td width="300"></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>_______________</td>
				<td>_______________</td>
			</tr>
		 </table>';
		
		
		$html .= '
		<style>
		    td.garis {
		        border-bottom:1px solid black;
		        border-top:1px solid black;
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
		    td.garis3{
		        border-right:1px solid black;
		        border-left:1px solid black;
		    }
		    td.garis4{
		    	border-top:1px solid black;
		        border-right:1px solid black;
		        border-left:1px solid black;
		    }
		    td.garis5{
		        border-right:1px solid black;
		        border-left:1px solid black;
				border-bottom:1px solid black;
		    }
		</style>      
		</body>
		</html>'; 	
	  
	    // Print text using writeHTMLCell()
	    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);  
	  
	    $pdf->Output('pdf_ppu.pdf', 'I');   

    }

	function sinkronmaspeg(){
		$query = "SELECT * FROM mas_peg WHERE kd_jab = '106' AND flag_keluar = 0";
		$rs = $this->db_hrd20->query($query)->result();
		foreach($rs as $row){
			$no_peg = $row->no_peg;
			$na_peg = $row->na_peg;
			$kd_jab = $row->kd_jab;
			$kd_level = $row->kd_level;
			
			$cekdata = "select * from mas_peg where no_peg = '$no_peg'";
			$rcek = $this->db->query($cekdata)->num_rows();
			if($rcek == 0){
				$insert_data = [
					'no_peg'      => $row->no_peg,
					'na_peg'      => $row->na_peg,
					'tgl_masuk'   => $row->tgl_masuk,
					'alamat'      => $row->alamat,
					'no_ktp'      => $row->no_ktp,
					'kd_level'    => $row->kd_level,
					'kd_prsh' => 'P02',
					'kd_unit'     => $row->kd_unit,
					'tgl_lahir'   => $row->tgl_lahir,
					'tmpt_lahir'  => $row->tmpt_lahir,
					'sex'     => $row->sex,
					'status_pajak' => $row->status_pajak,
					'email'       => $row->email,
					'no_rek'       => $row->no_rek,
					'pendidikan'       => $row->pendidikan,
					'ket_pendidikan'       => $row->ket_pendidikan,
					'kd_jab'       => '106',
					'status_peg'   => 'S04',
					'tgl_kontrak' => $row->tgl_kontrak,
					'tgl_akhir' => $row->tgl_akhir,
					'flag_gaji_pusat' => $row->flag_gaji_pusat,
					'flag_kis' => $row->flag_kis,
					'npwp'        => $row->npwp,
					'tgl_update'   => date("Y-m-d H:i:s")
				];
				$result = $this->btp_model->simpan_pegawai_os($insert_data);
			}
		
		}
		echo "Sukses Sinkron";
	}
}
