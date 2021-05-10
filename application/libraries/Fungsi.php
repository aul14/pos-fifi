<?php 

Class Fungsi {

	protected $ci;

	function __construct() {
		$this->ci =& get_instance();
	}
	function user_login() {
		$this->ci->load->model('user_m');
		$id_user = $this->ci->session->userdata('id_user');
		$user_data = $this->ci->user_m->get($id_user)->row();
		return $user_data;
	}
	function pdfGenerator($html, $filename, $paper, $orientation)
	{
		$dompdf = new  Dompdf\Dompdf();
		$dompdf->loadHtml($html);
		$dompdf->set_option('isRemoteEnabled', TRUE);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper($paper, $orientation);
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream($filename, array('Attachment' => 0));
	}

	public function count_produk(){
		$this->ci->load->model('produk_m');
		return $this->ci->produk_m->get()->num_rows();
	}
	public function count_supplier(){
		$this->ci->load->model('supplier_m');
		return $this->ci->supplier_m->get()->num_rows();
	}
	public function count_brand(){
		$this->ci->load->model('brand_m');
		return $this->ci->brand_m->get()->num_rows();
	}
	public function count_user(){
		$this->ci->load->model('user_m');
		return $this->ci->user_m->get()->num_rows();
	}
}