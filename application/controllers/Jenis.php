<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jenis extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model('jenis_m');
	}

	public function index()
	{
		$data['row'] = $this->jenis_m->get();
		$this->template->load('template', 'jenis/jenis_data', $data);
	}

	public function tambah()
	{
		$jenis = new stdClass();
		$jenis->id_jenis = null;
		$jenis->nama_jenis = null;
		$data = array(
			'page' => 'tambah',
			'row' =>  $jenis
		);
		$this->template->load('template', 'jenis/jenis_form', $data);
	}

	public function edit($id)
	{
		$query = $this->jenis_m->get($id);
		if($query->num_rows() > 0){
			$jenis = $query->row();
			$data = array(
				'page' => 'edit',
				'row' =>  $jenis
			);
			$this->template->load('template', 'jenis/jenis_form', $data);
		} else {
			echo "<script>alert('Data tidak ditemukan');";
		echo "window.location='".site_url('jenis')."';</script>";
	}
}

	public function proses()
	{
		$post = $this->input->post(null,TRUE);
		if(isset($_POST['tambah'])){
			$this->jenis_m->tambah($post);
		} else if (isset($_POST['edit'])){
			$this->jenis_m->edit($post);
		}
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('success', 'Data Berhasil Disimpan');
		}
		redirect('jenis');
	}
	public function hapus($id)
	{
		
		$this->jenis_m->hapus($id);
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('success', 'Data Berhasil Dihapus');
		}
		redirect('jenis');
	}

}
