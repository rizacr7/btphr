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
		$this->load->model('proses_model');
		$this->load->model('func_global');

		if($this->session->userdata('role') == ""){
			redirect('Welcome/index');
		}
    }

    function reportgaji(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('report/lap_gaji');
        $this->load->view('general/footer');
    }

	function reportbpjs(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('report/lap_bpjs');
        $this->load->view('general/footer');
    }

	function tab_gaji(){
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];

		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;
		$this->view_gajipegawai($param);
        
	}

	function view_gajipegawai($data){
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];

		echo "
		<table class='table table-bordered table-head-bg-primary table-bordered-bd-primary' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th>No.Pegawai</th>
				<th>Nm.Pegawai</th>
				<th>Jabatan</th>
				<th>Level</th>
				<th>Gapok</th>
				<th>Tj.Jabatan</th>
				<th>Tj.Komunikasi</th>
				<th>Tj.Transport</th>
				<th>Tj.Konsumsi</th>
				<th>Tj.Kinerja</th>
				<th>Tj.Lembur</th>
				<th>Tj.HR</th>
				<th>Tj.Kehadiran</th>
				<th>Gaji Bruto</th>
				<th>Pot.BPJS Kesehatan</th>
				<th>Pot.BPJS TK</th>
				<th>Pot.BPJS Pensiun</th>
				<th>Total Potongan</th>
				<th>Gaji Netto</th>
			</tr>
		</thead>
		<tbody>";

        $no = 1;
		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;
		$DataResult = $this->proses_model->get_data_gaji("", "", "", 0, 0,$param);
		$totalbruto=0;
		$totalnetto=0;
		$totalPotongan=0;
		foreach ($DataResult->result_array() as $key => $value) {
			$sumPotongan = $value['pot_bpjs'] + $value['pot_bpjs_jp'] + $value['pot_bpjs_tk'];

            echo "<tr>
				<td>" . $no . "</td>
				<td>" . $value['no_peg'] . "</td>
				<td>" . $value['na_peg'] . "</td>
				<td>" . $value['nm_jab'] . "</td>
				<td>" . $value['level'] . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['gapok']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_jabatan']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_komunikasi']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_transport']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_konsumsi']) . "</td>

				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_kinerja']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_lembur']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_hr']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_kehadiran']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['gaji_bruto']) . "</td>

				<td style='text-align:right'>" . $this->func_global->formatrp($value['pot_bpjs']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['pot_bpjs_tk']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['pot_bpjs_jp']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($sumPotongan) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['gaji_netto']) . "</td>

			</tr>";
            $no++;

			$totalbruto +=$value['gaji_bruto'];
			$totalnetto +=$value['gaji_netto'];
			$totalPotongan +=$sumPotongan;
        }
		
        echo "
			<tr>
				<td colspan='14'><b>TOTAL</b></td>
				<td style=text-align:right><b>" . $this->func_global->duit($totalbruto) . "</b></td>
				<td style=text-align:right></td>
				<td style=text-align:right></td>
				<td style=text-align:right></td>
				<td style=text-align:right><b>" . $this->func_global->duit($totalPotongan) . "</b></td>
				<td style=text-align:right><b>" . $this->func_global->duit($totalnetto) . "</b></td>
			</tr>
		</tbody>
		</table>";
	}

	function tab_bpjs(){
		$bulan = $_POST['bulan'];
		$tahun = $_POST['tahun'];
		$jenis = $_POST['jenis'];

		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;
		$param['jenis'] = $jenis;
		$this->view_bpjspegawai($param);
        
	}

	function view_bpjspegawai($data){
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];
		$jenis = $data['jenis'];

		echo "
		<table class='table table-bordered table-head-bg-primary table-bordered-bd-primary' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th>No.Pegawai</th>
				<th>Nm.Pegawai</th>
				<th>Gaji Dasar</th>
				<th>Pot.Karyawan</th>
				<th>Pot.Perusahaan</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>";

		$no = 1;
		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;

		if($jenis == 1){
			$DataResult = $this->report_model->get_data_bpjskesehatan($param);
		}
		else if($jenis == 2){
			$DataResult = $this->report_model->get_data_bpjstk($param);
		}
		else{
			$DataResult = $this->report_model->get_data_bpjsjp($param);
		}

		$no=1;
		$totalpotkaryawan=0;
		$totalpotperusahaan=0;
		$totalbpjsall=0;

		foreach ($DataResult->result_array() as $key => $value) {
			echo "
			<tr>
				<td>" . $no . "</td>
				<td>" . $value['no_peg'] . "</td>
				<td>" . $value['na_peg'] . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['gdp']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['pot_karyawan']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['pot_perusahaan']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['total_bpjs']) . "</td>
			</tr>";
			$no++;
			$totalpotkaryawan+=$value['pot_karyawan'];
			$totalpotperusahaan+=$value['pot_perusahaan'];
			$totalbpjsall+=$value['total_bpjs'];
		}
			echo "
			<tr>
				<td colspan='3'></td>
				<td><b>TOTAL</b></td>
				<td style='text-align:right'><b>" . $this->func_global->formatrp($totalpotkaryawan) . "</b></td>
				<td style='text-align:right'><b>" . $this->func_global->formatrp($totalpotperusahaan) . "</b></td>
				<td style='text-align:right'><b>" . $this->func_global->formatrp($totalbpjsall) . "</b></td>
			</tr>
			</table>";

	}

	function excel_gaji(){
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];

		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=lap_gaji_".$bulan."_".$tahun.".xls");//ganti nama sesuai keperluan
		header("Pragma: no-cache");
		header("Expires: 0");

		echo "
		<table>
			<tr><th colspan='6'>LAPORAN GAJI PEGAWAI</th></tr>
			<tr><th colspan='6'>PERIODE: " . strtoupper(date('F', mktime(0, 0, 0, $bulan, 10))) . " {$tahun}</th></tr>
		</table>
		<br>";

		echo "
		<table border='1'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th>No.Pegawai</th>
				<th>Nm.Pegawai</th>
				<th>Jabatan</th>
				<th>Level</th>
				<th>Gapok</th>
				<th>Tj.Jabatan</th>
				<th>Tj.Komunikasi</th>
				<th>Tj.Transport</th>
				<th>Tj.Konsumsi</th>
				<th>Tj.Kinerja</th>
				<th>Tj.Lembur</th>
				<th>Tj.HR</th>
				<th>Tj.Kehadiran</th>
				<th>Gaji Bruto</th>
				<th>Pot.BPJS Kesehatan</th>
				<th>Pot.BPJS TK</th>
				<th>Pot.BPJS Pensiun</th>
				<th>Total Potongan</th>
				<th>Gaji Netto</th>
			</tr>
		</thead>
		<tbody>";

        $no = 1;
		
		$DataResult = $this->proses_model->get_data_gaji("", "", "", 0, 0,$param);
		$totalbruto=0;
		$totalnetto=0;
		$totalPotongan=0;
		foreach ($DataResult->result_array() as $key => $value) {
			$sumPotongan = $value['pot_bpjs'] + $value['pot_bpjs_jp'] + $value['pot_bpjs_tk'];

            echo "<tr>
				<td>" . $no . "</td>
				<td>" . $value['no_peg'] . "</td>
				<td>" . $value['na_peg'] . "</td>
				<td>" . $value['nm_jab'] . "</td>
				<td>" . $value['level'] . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['gapok']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_jabatan']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_komunikasi']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_transport']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_konsumsi']) . "</td>

				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_kinerja']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_lembur']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_hr']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['tj_kehadiran']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['gaji_bruto']) . "</td>

				<td style='text-align:right'>" . $this->func_global->formatrp($value['pot_bpjs']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['pot_bpjs_tk']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['pot_bpjs_jp']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($sumPotongan) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['gaji_netto']) . "</td>

			</tr>";
            $no++;

			$totalbruto +=$value['gaji_bruto'];
			$totalnetto +=$value['gaji_netto'];
			$totalPotongan +=$sumPotongan;
        }
		
        echo "
			<tr>
				<td colspan='14'><b>TOTAL</b></td>
				<td style=text-align:right><b>" . $this->func_global->duit($totalbruto) . "</b></td>
				<td style=text-align:right></td>
				<td style=text-align:right></td>
				<td style=text-align:right></td>
				<td style=text-align:right><b>" . $this->func_global->duit($totalPotongan) . "</b></td>
				<td style=text-align:right><b>" . $this->func_global->duit($totalnetto) . "</b></td>
			</tr>
		</tbody>
		</table>";
	}

	function excel_bpjs(){
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];
		$jenis = $_GET['jenis'];

		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;
		if($jenis == 1){
			$judul = "LAPORAN BPJS KESEHATAN";
			$DataResult = $this->report_model->get_data_bpjskesehatan($param);
		}
		else if($jenis == 2){
			$judul = "LAPORAN BPJS TENAGA KERJA";
			$DataResult = $this->report_model->get_data_bpjstk($param);
		}
		else{
			$judul = "LAPORAN BPJS PENSIUN";
			$DataResult = $this->report_model->get_data_bpjsjp($param);
		}

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=lap_bpjs_".$bulan."_".$tahun.".xls");//ganti nama sesuai keperluan
		header("Pragma: no-cache");
		header("Expires: 0");

		echo "
		<table>
			<tr><th colspan='6'>$judul</th></tr>
			<tr><th colspan='6'>PERIODE: " . strtoupper(date('F', mktime(0, 0, 0, $bulan, 10))) . " {$tahun}</th></tr>
		</table>
		<br>";

		echo "
		<table border='1'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th>No.Pegawai</th>
				<th>Nm.Pegawai</th>
				<th>Gaji Dasar</th>
				<th>Pot.Karyawan</th>
				<th>Pot.Perusahaan</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>";

		$no=1;
		$totalpotkaryawan=0;
		$totalpotperusahaan=0;
		$totalbpjsall=0;

		foreach ($DataResult->result_array() as $key => $value) {
			echo "
			<tr>
				<td>" . $no . "</td>
				<td>" . $value['no_peg'] . "</td>
				<td>" . $value['na_peg'] . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['gdp']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['pot_karyawan']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['pot_perusahaan']) . "</td>
				<td style='text-align:right'>" . $this->func_global->formatrp($value['total_bpjs']) . "</td>
			</tr>";
			$no++;
			$totalpotkaryawan+=$value['pot_karyawan'];
			$totalpotperusahaan+=$value['pot_perusahaan'];
			$totalbpjsall+=$value['total_bpjs'];
		}
			echo "
			<tr>
				<td colspan='3'></td>
				<td><b>TOTAL</b></td>
				<td style='text-align:right'><b>" . $this->func_global->formatrp($totalpotkaryawan) . "</b></td>
				<td style='text-align:right'><b>" . $this->func_global->formatrp($totalpotperusahaan) . "</b></td>
				<td style='text-align:right'><b>" . $this->func_global->formatrp($totalbpjsall) . "</b></td>
			</tr>
			</table>";
	}
}
