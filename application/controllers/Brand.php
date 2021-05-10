<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model('brand_m');
	}

	public function index()
	{
		$data['row'] = $this->brand_m->get();
		$this->template->load('template', 'brand/brand_data', $data);
	}

	public function tambah()
	{
		$brand = new stdClass();
		$brand->id_brand = null;
		$brand->nama_brand = null;
		$data = array(
			'page' => 'tambah',
			'row' =>  $brand
		);
		$this->template->load('template', 'brand/brand_form', $data);
	}

	public function edit($id)
	{
		$query = $this->brand_m->get($id);
		if($query->num_rows() > 0){
			$brand = $query->row();
			$data = array(
				'page' => 'edit',
				'row' =>  $brand
			);
			$this->template->load('template', 'brand/brand_form', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan');";
		echo "window.location='".site_url('brand')."';</script>";
	}
}

	public function proses()
	{
		$post = $this->input->post(null,TRUE);
		if(isset($_POST['tambah'])){
			$this->brand_m->tambah($post);
		} else if (isset($_POST['edit'])){
			$this->brand_m->edit($post);
		}
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('success', 'Data Berhasil Disimpan');
		}
		redirect('brand');
	}
	public function hapus($id)
	{
		
		$this->brand_m->hapus($id);
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('success', 'Data Berhasil Dihapus');
		}
		redirect('brand');
	}

}
