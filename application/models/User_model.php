<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model  {
	
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
	 public function check_login($username, $password) {
        // Enkripsi password input pakai md5 sebelum dicocokkan
        $password_md5 = md5($password);

        $this->db->where('username', $username);
        $this->db->where('password', $password_md5);
        $query = $this->db->get('t_login');

        if ($query->num_rows() > 0) {
            return $query->row(); // user ditemukan
        } else {
            return false;
        }
    }
}
