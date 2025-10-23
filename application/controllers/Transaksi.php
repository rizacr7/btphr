<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

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
        $this->load->model('transaksi_model');
		$this->load->model('func_global');
    }

    function spk_kendaraan(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('transaksi/inp_spk');
        $this->load->view('general/footer');
    }

	function viewspk(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('transaksi/v_spk');
        $this->load->view('general/footer');
    }

	function datasewa(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('transaksi/data_sewa');
        $this->load->view('general/footer');
    }

	function koreksi_spk(){
		$data=array(
			'bukti'=>$this->input->get('bukti')
		);
		$Dataspk = $this->transaksi_model->header_spk($data);
		$Param  = array();
		$Param['Dataspk']= $Dataspk;

        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('transaksi/koreksi_spk',$Param);
        $this->load->view('general/footer');
    }

	function get_bukti(){
		$tgl_spk = $this->input->post('tgl_spk');
		$kd = $this->input->post('kd');

		$param = array(
			'tgl_spk' => $tgl_spk,
			'kd' => $kd
		);

		$bukti = $this->transaksi_model->get_bukti_spk($param);
		echo $bukti;		
	}

	function get_kendaraan(){
		$kd_kendaraan = $this->input->post('kd_kendaraan');

		$this->db->where('kd_kendaraan', $kd_kendaraan);
		$query = $this->db->get('m_kendaraan');

		if($query->num_rows() > 0){
			$row = $query->row();
			$data = array(
				'nm_kendaraan' => $row->nm_kendaraan,
			);
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	function ins_transaksi_spk(){
		$no_bukti_spk = $this->input->post('no_bukti_spk');
		$tgl_spk = $this->input->post('tgl_spk');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$tgl_awal = $this->input->post('tgl_awal');
		$kd_vendor = $this->input->post('kd_vendor');
		$no_ref_spk = $this->input->post('no_ref_spk');
		$jumlahdatakendaraan = $this->input->post('jumlahdatakendaraan');	

		$query = "SELECT * FROM t_spk WHERE no_bukti_spk='$no_bukti_spk'";
		$dt = $this->db->query($query)->num_rows();

		if ($dt == 0) {
			// Insert header
			$data = array(
				'no_bukti_spk' => $no_bukti_spk,
				'tgl_spk' => $this->func_global->tgl_dsql($tgl_spk),
				'tgl_akhir' => $this->func_global->tgl_dsql($tgl_akhir),
				'tgl_awal' => $this->func_global->tgl_dsql($tgl_awal),
				'kd_vendor' => $kd_vendor,
				'flag_spk' => 1,
				'no_ref_spk' => $no_ref_spk
			);
			$this->db->insert('t_spk', $data);

			for ($i = 0; $i < $jumlahdatakendaraan; $i++) {
				
				$kd_kendaraan = $_POST['data_h'][$i];
				$nm_kendaraan = $_POST['data_i'][$i];
				$nopol = $_POST['data_j'][$i];
				$hrg_satuan = $this->func_global->rupiah($_POST['data_k'][$i]);

				$dpp = round($hrg_satuan / 1.11,0);
				$ppn = round($dpp * 0.11,0);

				$data_detail = array(
					'no_bukti_spk' => $no_bukti_spk,
					'kd_kendaraan' => $kd_kendaraan,
					'nopol' => $nopol,
					'hrg_sewa' => $hrg_satuan,
					'dpp_sewa' => $dpp,
					'ppn_sewa' => $ppn
				);
				$this->db->insert('t_spk_detail', $data_detail);
			}
			echo 1; // Berhasil
		}
	}

	function tab_spk(){
		 echo "<table id='table_spk' class='table table-bordered dt-responsive table-head-bg-primary table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th>No.Bukti</th>
				<th>Nm.Vendor</th>
				<th>No.Ref SPK</th>
				<th>Tgl.Awal Kontrak</th>
				<th>Tgl.Akhir Kontrak</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->transaksi_model->get_data_spk("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
            echo "<tr>
				<td>" . $no . "</td>
				<td>" . $value['no_bukti_spk'] . "</td>
				<td>" . $value['nm_vendor'] . "</td>
				<td>" . $value['no_ref_spk'] . "</td>
				<td>" . $value['tgl_awal'] . "</td>
				<td>" . $value['tgl_akhir'] . "</td>
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
			$('#table_spk').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
	}

	function v_spk_sewa(){
		$no_bukti_spk = $this->input->post('no_bukti_spk');

		// buatkan header t_spk
		$this->db->where('no_bukti_spk', $no_bukti_spk);
		$this->db->join('m_vendor', 't_spk.kd_vendor = m_vendor.kd_vendor', 'left');
		$query = $this->db->get('t_spk');		
		$row = $query->row();
		
		echo "	
		<table class='table table-bordered'>
		<tr>
			<td width=150><b>No. Bukti SPK</b></td>
			<td width=10>:</td>						
			<td>".$row->no_bukti_spk."</td>

			<td><b>Tgl. SPK</b></td>
			<td>:</td>					
			<td>".$this->func_global->dsql_tgl($row->tgl_spk)."</td>		
		</tr>
		<tr>
			<td><b>Vendor</b></td>
			<td>:</td>					
			<td>".$row->nm_vendor."</td>	

			<td><b>No. Ref SPK</b></td>
			<td>:</td>					
			<td>".$row->no_ref_spk."</td>	
		</tr>	
		<tr>
			<td><b>Tgl. Awal Kontrak</b></td>
			<td>:</td>					
			<td>".$this->func_global->dsql_tgl($row->tgl_awal)."</td>	

			<td><b>Tgl. Akhir Kontrak</b></td>
			<td>:</td>					
			<td>".$this->func_global->dsql_tgl($row->tgl_akhir)."</td>	
		</tr>
		</table>";

		echo "
		<table class='table table-bordered table-head-bg-primary table-bordered-bd-primary mt-2' width='100%'>
		<tr>
			<td width=30 style=\"text-align: center;\"><b>No</b></td>
			<td width=150 style=\"text-align: center;\"><b>Kendaraan</b></td>
			<td width=100 style=\"text-align: center;\"><b>Nopol</b></td>
			<td width=110 style=\"text-align: center;\"><b>Harga Sewa</b></td>
			<td width=110 style=\"text-align: center;\"><b>Status Sewa</b></td>
		</tr>";
		
		$detail = "SELECT a.*,b.nm_kendaraan FROM t_spk_detail a 
		LEFT JOIN m_kendaraan b ON a.kd_kendaraan = b.kd_kendaraan
		WHERE a.no_bukti_spk = '$no_bukti_spk'";
		
		$result = $this->db->query($detail);
		$rows = array(); 
		$i=0;
		$no=0;
		$sumtotal = 0;
		foreach ($result->result() as $dt) {
			$rows[$i]['nopol'] = $dt->nopol;
			$rows[$i]['hrg_sewa'] = $dt->hrg_sewa;
			$rows[$i]['nm_kendaraan'] = $dt->nm_kendaraan;
			$rows[$i]['flag_stop_sewa'] = $dt->flag_stop_sewa;
			
			$no++;

			if($dt->flag_stop_sewa == 0){
				$status = "<button type='button' class='btn btn-icon btn-round btn-success'>
					<i class='fa fa-check-square'></i>
				</button>";
			}
			else{
				$status = "<button type='button' class='btn btn-icon btn-round btn-danger'>
					<i class='fa fa-stop-circle'></i>
				</button>";
			}
			echo "
			<tr>
				<td>$no</td>
				<td>$dt->nm_kendaraan</td>
				<td>$dt->nopol</td>
				<td style='text-align: right'>".$this->func_global->duit($dt->hrg_sewa)."</td>
				<td style='text-align: center'>$status</td>
			</tr>";
			$sumtotal += $dt->hrg_sewa;
		}
		echo "
		<tr>
			<td colspan='2'></td>
			<td style='text-align: center'>TOTAL</td>
			<td style='text-align: right'>".$this->func_global->duit($sumtotal)."</td>
		</tr>
		</table>";
	}

	function hapus_spk(){
		$no_bukti_spk = $this->input->post('no_bukti_spk');

		$this->db->where('no_bukti_spk', $no_bukti_spk);
		$this->db->update('t_spk', array('is_del' => 1));

		echo 1; // Berhasil
	}

	function load_data_detail_spk(){
		$no_bukti_spk = $this->input->post('no_bukti_spk');

		$data_detail = $this->transaksi_model->get_spk_detail($no_bukti_spk);

		echo "<table id='table_spk_detail' class='table table-bordered table-head-bg-primary table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>Kode Kendaraan</th>
				<th>Nama Kendaraan</th>
				<th>Nopol</th>
				<th>Harga Sewa</th>
				<th>Status Sewa</th>
			</tr>
		</thead>
		<tbody>";
		$no = 1;
		foreach ($data_detail as $key => $value) {
			
			if($value->flag_stop_sewa == 0){
				$status = "<button type='button' class='btn btn-icon btn-round btn-success'>
					<i class='fa fa-check-square'></i>
				</button>";
			}
			else{
				$status = "<button type='button' class='btn btn-icon btn-round btn-danger'>
					<i class='fa fa-stop-circle'></i>
				</button>";
			}

			echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value->id_spk . "</td>
				<td>" . $value->kd_kendaraan . "</td>
				<td>" . $value->nm_kendaraan . "</td>
				<td>" . $value->nopol . "</td>
				<td style='text-align: right'>" . $this->func_global->duit($value->hrg_sewa) . "</td>
				<td style='text-align: center'>".$status."</td>
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
			$('#table_spk_detail').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
	}

	function ins_data_detail_spk(){
		$no_bukti_spk = $this->input->post('no_bukti_spk');
		$kd_kendaraan = $this->input->post('kd_kendaraan');
		$nopol = $this->input->post('nopol');
		$id_spk = $this->input->post('id_spk');
		$hrg_satuan = $this->func_global->rupiah($this->input->post('hrg_satuan'));

		$dpp = round($hrg_satuan / 1.11,0);
		$ppn = round($dpp * 0.11,0);

		if($id_spk != ""){
			// Update data detail
			$data_detail = array(
				'kd_kendaraan' => $kd_kendaraan,
				'nopol' => $nopol,
				'hrg_sewa' => $hrg_satuan,
				'dpp_sewa' => $dpp,
				'ppn_sewa' => $ppn
			);
			$this->db->where('id_spk', $id_spk);
			$this->db->update('t_spk_detail', $data_detail);

			echo 1; // Berhasil
			return;
		}
		$data_detail = array(
			'no_bukti_spk' => $no_bukti_spk,
			'kd_kendaraan' => $kd_kendaraan,
			'nopol' => $nopol,
			'hrg_sewa' => $hrg_satuan,
			'dpp_sewa' => $dpp,
			'ppn_sewa' => $ppn
		);
		$this->db->insert('t_spk_detail', $data_detail);

		echo 1; // Berhasil
	}

	function hapus_data_detail_spk(){
		$id_spk = $this->input->post('id_spk');

		$this->db->where('id_spk', $id_spk);
		$this->db->delete('t_spk_detail');

		echo 1; // Berhasil
	}

	function simpan_koreksi_spk(){
		$no_bukti_spk = $this->input->post('no_bukti_spk');
		// Update header
		$data = array(
			'flag_spk' => 1,
			'tgl_update' => date('Y-m-d H:i:s')
		);
		$this->db->where('no_bukti_spk', $no_bukti_spk);
		$this->db->update('t_spk', $data);

		echo 1; // Berhasil
	}

	//---data sewa kendaraan---//
	function tab_sewakendaraan(){
		 echo "<table id='table_sewa' class='table table-bordered dt-responsive table-head-bg-primary table-bordered-bd-primary mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>Kendaraan</th>
				<th>Nopol</th>
				<th>Vendor</th>
				<th>Hrg.Sewa</th>
				<th>Dpp</th>
				<th>PPn</th>
				<th>Status Sewa</th>
				<th>Tgl.Penghentian</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->transaksi_model->get_data_sewa("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
			if($value['flag_stop_sewa'] == 0){
				$status = "<button type='button' class='btn btn-icon btn-round btn-success'>
					<i class='fa fa-check-square'></i>
				</button>";
			}
			else{
				$status = "<button type='button' class='btn btn-icon btn-round btn-danger'>
					<i class='fa fa-stop-circle'></i>
				</button>";
			}

            echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value['id_spk'] . "</td>
				<td>" . $value['nm_kendaraan'] . "</td>
				<td>" . $value['nopol'] . "</td>
				<td>" . $value['nm_vendor'] . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['hrg_sewa']) . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['dpp_sewa']) . "</td>
				<td style='text-align:right'>" . $this->func_global->duit($value['ppn_sewa']) . "</td>
				<td style='text-align:center'>" . $status . "</td>
				<td>" . $this->func_global->dsql_tgl($value['tgl_stop']) . "</td>
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
			$('#table_sewa').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
	}

	function update_stopsewa(){
		$id_spk = $this->input->post('id_spk');
		$tgl_stop = $this->input->post('tgl_stop');

		$data = array(
			'flag_stop_sewa' => 1,
			'tgl_stop' => $this->func_global->tgl_dsql($tgl_stop)
		);
		$this->db->where('id_spk', $id_spk);
		$this->db->update('t_spk_detail', $data);

		echo 1; // Berhasil
	}

	function batal_stopsewa(){
		$id_spk = $this->input->post('id_spk');

		$data = array(
			'flag_stop_sewa' => 0,
			'tgl_stop' => null
		);
		$this->db->where('id_spk', $id_spk);
		$this->db->update('t_spk_detail', $data);

		echo 1; // Berhasil
	}
}
