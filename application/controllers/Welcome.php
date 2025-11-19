<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
        $this->load->model('User_model'); // model untuk cek login
        $this->load->helper('url');
    }

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function login() {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        // Validasi input sederhana
        if (empty($username)) {
            echo json_encode(['status' => 'error', 'field' => 'username', 'message' => 'Username wajib diisi']);
            return;
        }
        if (empty($password)) {
            echo json_encode(['status' => 'error', 'field' => 'password', 'message' => 'Password wajib diisi']);
            return;
        }

        // Cek ke model
        $user = $this->User_model->check_login($username, $password);
        if ($user) {
            // Simpan session
            $this->session->set_userdata([
                'logged_in' => true,
                'username' => $user->username,
                'nama' => $user->nama,
                'role' => $user->role,
                'kdprsh' => $user->kd_prsh
            ]);
            echo json_encode(['status' => 'success', 'redirect' =>base_url('index.php/Welcome/home')]);
        } else {
            echo json_encode(['status' => 'error', 'field' => 'password', 'message' => 'Username atau password salah']);
        }
    }

    function home(){
        $this->load->view('general/header');
        $this->load->view('general/sidebar');
        $this->load->view('home');
        $this->load->view('general/footer');
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url('index.php/welcome'));
    }
}
