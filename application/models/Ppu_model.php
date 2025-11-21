<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ppu_model extends CI_Model  {
	
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

	function get_bukti_ppu($data){
		$kd = $data['kd'];
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];
		
		$thn = substr($tahun,2,2);

		$kode = $kd.$bulan.$thn;
		$sql = "SELECT MAX(bukti) AS maxID FROM t_pplsdm WHERE bukti like '$kode%'";
		
		$result = $this->db->query($sql)->result();
		$noUrut = (int) substr($result[0]->maxID, -4);
		$noUrut++;
		$newId = sprintf("%04s", $noUrut);
		$id= $kode.$newId;
		return $id;
	}

	function ppu_gaji($data){
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];
		$jenis = $data['jenis'];

		$username = $this->session->userdata('username');
		$kdprsh = $this->session->userdata('kdprsh');
		$nama = $this->session->userdata('nama');

		$cekdt = "select * from t_gaji where bulan = $bulan and tahun = $tahun and flag_close=1";
		$rdt = $this->db->query($cekdt)->num_rows();
		if($rdt > 0){
			$query="SELECT ROUND(sum(gaji_netto),2) as  gajinetto FROM t_gaji WHERE bulan = $bulan and tahun = $tahun";
			$val = $this->db->query($query)->result();
			$total_gaji = $val[0]->gajinetto;

			$param = array();
			$param['bulan'] = $bulan;
			$param['tahun'] = $tahun;
			$param['kd'] = 'GJT';
			$bukti = $this->get_bukti_ppu($param);
			
			$keterangan = "GAJI PEGAWAI PT.BTP PERIODE $bulan $tahun";

			// --- update t_gaji ---
			$update = "update t_gaji set bukti_ppu = '$bukti' where bulan = $bulan and tahun = $tahun";
			$this->db->query($update);
			
			$param = array();
			$param['bulan'] = $bulan;
			$param['tahun'] = $tahun;
			$param['jenis'] = $jenis;
			$param['bukti'] = $bukti;
			$param['keterangan'] = $keterangan;
			$param['jumlah'] = $total_gaji;
			$this->insert_pplsdm($param);
			
		}
		else{
			return 3;
		}
	}

	function ppu_bpjs($data){
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];
		$jenis = $data['jenis'];

		if($jenis == 2){
			$query = "select sum(total_bpjs) as total_bpjs from bpjs_kesehatan where bulan = $bulan and tahun = $tahun";
			$val = $this->db->query($query)->result();
			$total_bpjs = $val[0]->total_bpjs;

			$param = array();
			$param['bulan'] = $bulan;
			$param['tahun'] = $tahun;
			$param['kd'] = 'BPK';
			$bukti = $this->get_bukti_ppu($param);
			$keterangan = "BPJS KESEHATAN PT.BTP PERIODE $bulan $tahun";

			// --- update t_gaji ---
			$update = "update bpjs_kesehatan set bukti_ppu = '$bukti' where bulan = $bulan and tahun = $tahun";
			$this->db->query($update);
		}
		else if($jenis == 3){
			$query = "select sum(total_bpjs) as total_bpjs from bpjs_tk where bulan = $bulan and tahun = $tahun";
			$val = $this->db->query($query)->result();
			$total_bpjs = $val[0]->total_bpjs;

			$param = array();
			$param['bulan'] = $bulan;
			$param['tahun'] = $tahun;
			$param['kd'] = 'BPT';
			$bukti = $this->get_bukti_ppu($param);
			$keterangan = "BPJS KETENAGAKERJAAN PT.BTP PERIODE $bulan $tahun";

			// --- update t_gaji ---
			$update = "update bpjs_tk set bukti_ppu = '$bukti' where bulan = $bulan and tahun = $tahun";
			$this->db->query($update);
		}
		else if($jenis == 4){
			$query = "select sum(total_bpjs) as total_bpjs from bpjs_jp where bulan = $bulan and tahun = $tahun";
			$val = $this->db->query($query)->result();
			$total_bpjs = $val[0]->total_bpjs;

			$param = array();
			$param['bulan'] = $bulan;
			$param['tahun'] = $tahun;
			$param['kd'] = 'BPJ';
			$bukti = $this->get_bukti_ppu($param);
			$keterangan = "BPJS PENSIUN PT.BTP PERIODE $bulan $tahun";

			// --- update t_gaji ---
			$update = "update bpjs_jp set bukti_ppu = '$bukti' where bulan = $bulan and tahun = $tahun";
			$this->db->query($update);
		}

		$param = array();
		$param['bulan'] = $bulan;
		$param['tahun'] = $tahun;
		$param['jenis'] = $jenis;
		$param['bukti'] = $bukti;
		$param['keterangan'] = $keterangan;
		$param['jumlah'] = $total_bpjs;
		$this->insert_pplsdm($param);

	}

	function insert_pplsdm($data){
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];
		$jenis = $data['jenis'];
		$bukti = $data['bukti'];
		$jumlah = $data['jumlah'];
		$keterangan = $data['keterangan'];

		$username = $this->session->userdata('username');
		$kdprsh = $this->session->userdata('kdprsh');
		$nama = $this->session->userdata('nama');

		// //--- delete ---
		$hapus = "delete from t_pplsdm where bulan = $bulan and tahun = $tahun and jns_trans = $jenis";
		$this->db->query($hapus);

		$data = array(
			'bukti' => $bukti,
			'jns_trans' => $jenis,
			'unit' => $kdprsh,
			'jumlah' => $jumlah,
			'keterangan' => $keterangan,
			'nm_pengguna' => $nama,
			'bulan' => $bulan,
			'tahun' => $tahun,
			'user_id' => $this->session->userdata('username'),
			'kd_pengguna' => $this->session->userdata('username'),
			);
		$this->db->insert('t_pplsdm',$data);
		
	}

	function get_ppu_sdm($data){
		$bulan = $data['bulan'];
		$tahun = $data['tahun'];
		$jenis = $data['jenis'];
		
		$query =  $this->db->query("select * from t_pplsdm where bulan = $bulan and tahun = $tahun and jns_trans = '$jenis' and flag_hapus = 0");
		
        return $query->result();
	}
}
