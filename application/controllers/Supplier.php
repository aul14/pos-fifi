<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class supplier extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model('supplier_m');
	}

	public function index()
	{
		$data['row'] = $this->supplier_m->get();
		$this->template->load('template', 'supplier/supplier_data', $data);
	}

	public function tambah()
	{
		$supplier = new stdClass();
		$supplier->id_supplier = null;
		$supplier->nama_supplier = null;
		$supplier->no_hp = null;
		$supplier->alamat = null;
		$supplier->deskripsi = null;
		$data = array(
			'page' => 'tambah',
			'row' =>  $supplier
		);
		$this->template->load('template', 'supplier/supplier_form', $data);
	}

	public function edit($id)
	{
		$query = $this->supplier_m->get($id);
		if($query->num_rows() > 0){
			$supplier = $query->row();
			$data = array(
				'page' => 'edit',
				'row' =>  $supplier
			);
			$this->template->load('template', 'supplier/supplier_form', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan');";
		echo "window.location='".site_url('supplier')."';</script>";
	}
}

	public function proses()
	{
		$post = $this->input->post(null,TRUE);
		if(isset($_POST['tambah'])){
			$this->supplier_m->tambah($post);
		} else if (isset($_POST['edit'])){
			$this->supplier_m->edit($post);
		}
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('success', 'Data Berhasil Disimpan');
		}
		redirect('supplier');
	}
	public function hapus($id)
	{
		
		$this->supplier_m->hapus($id);
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('success', 'Data Berhasil Dihapus');
		}
		redirect('supplier');
	}

}
