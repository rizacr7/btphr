<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

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
        $this->load->model('user_model');

		if($this->session->userdata('role') == ""){
			redirect('Welcome/index');
		}
    }

    function datauser(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('settings/m_user');
        $this->load->view('general/footer');
    }

	function datarole(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('settings/m_role');
        $this->load->view('general/footer');
    }

	function datamenu(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('settings/m_menu');
        $this->load->view('general/footer');
    }

	function aksesmenu(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('settings/m_akses');
        $this->load->view('general/footer');
    }

	function tab_user()
	{
		 echo "<table id='table_user' class='table table-bordered dt-responsive table-head-bg-danger table-bordered-bd-danger mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>Username</th>
				<th>Nama</th>
				<th>Role</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->user_model->get_data_user("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
            echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value['id_user'] . "</td>
				<td>" . $value['username'] . "</td>
				<td>" . $value['nama'] . "</td>
				<td>" . $value['role'] . "</td>
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
			$('#table_user').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
	}

	function tab_role()
	{
		 echo "<table id='table_role' class='table table-bordered dt-responsive table-head-bg-danger table-bordered-bd-danger mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>Role</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->user_model->get_data_role("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
            echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value['id_level'] . "</td>
				<td>" . $value['level'] . "</td>
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
			$('#table_role').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
	}

	function tab_menu()
	{
		 echo "<table id='table_menu' class='table table-bordered dt-responsive table-head-bg-danger table-bordered-bd-danger mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th style='display:none'>Id</th>
				<th>Header Menu</th>
				<th>Nama Menu</th>
				<th>Controller</th>
				<th>Link</th>
			</tr>
		</thead>
		<tbody>";
        $no = 1;
        $data = $this->user_model->get_data_menu("", "", "", 0, 0);
        foreach ($data->result_array() as $key => $value) {
			
            echo "<tr>
				<td>" . $no . "</td>
				<td style='display:none'>" . $value['id_sub'] . "</td>
				<td>" . $value['judul_head'] . "</td>
				<td>" . $value['judul_sub'] . "</td>
				<td>" . $value['controller'] . "</td>
				<td>" . $value['link'] . "</td>
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
			$('#table_menu').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
	}

	function hapus_user() {
		$id_user = $this->input->post('id_user');

		// Hapus data user berdasarkan ID
		$this->db->where('id_user', $id_user);
		$deleted = $this->db->delete('t_login');

		if ($deleted) {
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error']);
		}
	}

	function simpan_user() {
		$id_user = $this->input->post('id_user');
		$username = $this->input->post('username');
		$nama = $this->input->post('nama');
		$role = $this->input->post('role');

		if (empty($id_user)) {
			$password = md5($username); // Password default untuk user baru

			$data = [
				'username' => $username,
				'nama' => $nama,
				'role' => $role,
				'password' => $password
			];

			// Insert data baru
			$this->db->insert('t_login', $data);
		} else {
			// Update data existing
			$data = [
				'username' => $username,
				'nama' => $nama,
				'role' => $role
			];

			$this->db->where('id_user', $id_user);
			$this->db->update('t_login', $data);
		}

		echo json_encode(['status' => 'success']);
	}	

	function reset_password() {
		$id_user = $this->input->post('id_user');

		// Set password default menjadi md5 dari username
		$this->db->select('username');
		$this->db->from('t_login');
		$this->db->where('id_user', $id_user);
		$query = $this->db->get();
		$user = $query->row();

		if ($user) {
			$default_password = md5($user->username);

			$this->db->where('id_user', $id_user);
			$this->db->update('t_login', ['password' => $default_password]);

			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error']);
		}
	}

	function get_user_by_id() {
		$id_user = $this->input->post('id_user');

		$this->db->where('id_user', $id_user);
		$query = $this->db->get('t_login');
		$user = $query->row();

		echo json_encode($user);
	}

	function hapus_role() {
		$id_level = $this->input->post('id_level');

		// Hapus data role berdasarkan ID
		$this->db->where('id_level', $id_level);
		$deleted = $this->db->delete('m_level');

		if ($deleted) {
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error']);
		}
	}

	function get_role_by_id() {
		$id_level = $this->input->post('id_level');

		$this->db->where('id_level', $id_level);
		$query = $this->db->get('m_level');
		$role = $query->row();

		echo json_encode($role);
	}

	function simpan_role() {
		$id_level = $this->input->post('id_role');
		$level = $this->input->post('role');

		if (empty($id_level)) {
			$data = [
				'level' => $level
			];

			// Insert data baru
			$this->db->insert('m_level', $data);
		} else {
			// Update data existing
			$data = [
				'level' => $level
			];

			$this->db->where('id_level', $id_level);
			$this->db->update('m_level', $data);
		}

		echo json_encode(['status' => 'success']);
	}

	function get_menu_by_id() {
		$id_sub = $this->input->post('id_sub');
		$this->db->where('id_sub', $id_sub);
		$this->db->join('m_menu_head b', 'm_menu_sub.id_head = b.id_head', 'left');
		$query = $this->db->get('m_menu_sub');
		$menu = $query->row();

		echo json_encode($menu);
	}

	function hapus_menu() {
		$id_sub = $this->input->post('id_sub');

		// Hapus data menu berdasarkan ID
		$this->db->where('id_sub', $id_sub);
		$deleted = $this->db->delete('m_menu_sub');

		if ($deleted) {
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error']);
		}
	}

	function simpan_menu() {
		$id_sub = $this->input->post('id_sub');
		$id_head = $this->input->post('id_head');
		$judul_sub = $this->input->post('judul_sub');
		$controller = $this->input->post('controller');
		$link = $this->input->post('link');

		if (empty($id_sub)) {
			$data = [
				'id_head' => $id_head,
				'judul_sub' => $judul_sub,
				'controller' => $controller,
				'link' => $link
			];

			// Insert data baru
			$this->db->insert('m_menu_sub', $data);
		} else {
			// Update data existing
			$data = [
				'id_head' => $id_head,
				'judul_sub' => $judul_sub,
				'controller' => $controller,
				'link' => $link
			];

			$this->db->where('id_sub', $id_sub);
			$this->db->update('m_menu_sub', $data);
		}

		echo json_encode(['status' => 'success']);
	}

	function tab_akses(){
		$level = $_POST['level'];
		
		echo "<table id='table_akses' class='table table-bordered dt-responsive table-head-bg-danger table-bordered-bd-danger mt-2' width='100%'>
		<thead>
			<tr class='info'>
				<th>No.</th>
				<th hidden='true'>Id</th>
				<th hidden='true'>Id Head</th>
				<th>Header Menu</th>
				<th>Id Sub Menu</th>
				<th>Judul Menu</th>
			</tr>
		</thead>
		<tbody>";
		$no=1;
		$param = array();
		$param['level'] = $level;
		$data = $this->user_model->get_data_aksesmenu("", "", "", 0, 0,$param);
        foreach ($data->result_array() as $key => $value) {

            echo "<tr>
				<td>" . $no . "</td>
				<td hidden='true'>" . $value['id'] . "</td>
				<td hidden='true'>" . $value['id_head'] . "</td>
				<td>" . $value['judul_head'] . "</td>
				<td>" . $value['id_sub_menu'] . "</td>
				<td>" . $value['judul_sub'] . "</td>
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
			$('#table_akses').dataTable({
				responsive:'true',
				select: {style: 'single'}
			});
		</script>";
	}

	function simpan_akses(){
		$level = $this->input->post('level');
		$id_head = $this->input->post('id_header');
		$id_sub_menu = $this->input->post('id_sub_menu');

		//---cek data sudah ada atau belum
		$this->db->where('level', $level);
		$this->db->where('id_sub_menu', $id_sub_menu);
		$query = $this->db->get('m_akses');
		$akses = $query->row();	

		if ($akses) {
			// Data sudah ada, kirim respons error
			echo "error";
			return;
		}
		else{
		// Data belum ada, lanjutkan proses penyimpanan
			$data = [
				'level' => $level,
				'id_head' => $id_head,
				'id_sub_menu' => $id_sub_menu
			];

			// Insert data baru
			$this->db->insert('m_akses', $data);

			echo json_encode(['status' => 'success']);
		}
	}

	function hapus_akses() {
		$id = $this->input->post('id');

		// Hapus data akses berdasarkan ID
		$this->db->where('id', $id);
		$deleted = $this->db->delete('m_akses');

		if ($deleted) {
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error']);
		}
	}
}
