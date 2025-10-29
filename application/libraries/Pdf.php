<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Pdf extends TCPDF {
    function __construct() {
        parent::__construct();
    }
	
	 public function Header() {
		
        $image_file = K_PATH_IMAGES.'btplogo.png';
        $this->Image($image_file, 7, 7, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
		
		$this->SetFont('helvetica', 'B', 10);
        $this->SetX(26); 
        $this->Cell(90, 7, 'PT. Bangun Tumbuh Persada', 0, 1, 'L', 0, '', 1);
        $this->SetFont('helvetica', 'B', 9);
        $this->SetX(26);
        $this->Cell(95, 0, '', 0, 1, 'L', 0, '', 1);
    }
	
	public function Footer() {
		
    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */
