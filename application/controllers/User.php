<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		check_not_login();
		check_admin();
		$this->load->model('user_m');
		$this->load->library('form_validation');
	}
	public function index()
	{
		$data['row'] = $this->user_m->get();
		$this->template->load('template', 'user/user_data', $data);
	}
	public function tambah()
	{
		$this->form_validation->set_rules('email','Email','required|is_unique[tbl_user.email]'); 
		$this->form_validation->set_rules('fullname','Nama','required|min_length[3]');
		$this->form_validation->set_rules('password','Password','required|min_length[3]'); 
		$this->form_validation->set_rules('hak_akses','Hak Akses','required'); 
		$this->form_validation->set_rules('status_user','Status User','required'); 

		$this->form_validation->set_message('required','%s masih Kosong, silahkan isi'); 
		$this->form_validation->set_message('min_length','%s minimal 3 Karakter'); 
		$this->form_validation->set_message('is_unique','%s ini sudah ada,silahkan ganti'); 
		$this->form_validation->set_error_delimiters('<span class="text-danger">','</span>');
		// $this->form_validation->set_error_delimiters('<div class="invalid-feedback">', '</div>');
		if ($this->form_validation->run() == FALSE)
		{
			$this->template->load('template', 'user/tambah_user');
		}else {
			$post = $this->input->post(null, TRUE);
			$this->user_m->tambah($post);
			if($this->db->affected_rows() > 0){
				echo "<script>alert('Data Berhasil Disimpan');</script>";
			}
			echo "<script>window.location='".site_url('user')."';</script>";
		}
	}
	public function edit($id)
	{
		
		$this->form_validation->set_rules('email','Email','required|callback_email_check'); 
		$this->form_validation->set_rules('fullname','Nama','required|min_length[3]');
		if($this->input->post('password')){
		$this->form_validation->set_rules('password','Password','min_length[3]');
	} 
		$this->form_validation->set_rules('hak_akses','Hak Akses'); 
		$this->form_validation->set_rules('status_user','Status User'); 

		$this->form_validation->set_message('required','%s masih Kosong, silahkan isi'); 
		$this->form_validation->set_message('min_length','%s minimal 3 Karakter'); 
		$this->form_validation->set_message('is_unique','%s ini sudah ada,silahkan ganti'); 

		$this->form_validation->set_error_delimiters('<span class="help-block">','</span>');

		if ($this->form_validation->run() == FALSE)
		{
			$query = $this->user_m->get($id);
			if($query->num_rows() > 0){
				$data ['row'] = $query->row();
			$this->template->load('template', 'user/edit_user', $data);
		} else {
				echo "<script>alert('Data Tidak Ditemukan');";
				echo "window.location='".site_url('user')."';</script>";
		}
		}else {
			$post = $this->input->post(null, TRUE);
			$this->user_m->edit($post);
			if($this->db->affected_rows() > 0){
				echo "<script>alert('Data Berhasil Diedit');</script>";
			}
			echo "<script>window.location='".site_url('user')."';</script>";
		}
	}
	function email_check()
	{
			$post = $this->input->post(null, TRUE);
			$query = $this->db->query("SELECT * FROM tbl_user WHERE email = '$post[email]' AND id_user != '$post[id_user]'");
			if($query->num_rows() > 0){
			$this->form_validation->set_message('email_check','%s ini sudah dipakai, silahkan diganti'); 
			return FALSE;
			} else {
				return TRUE;
			}
	}
	public function hapus()
	{
		$id = $this->input->post('id_user');
		$this->user_m->hapus($id);
		if($this->db->affected_rows() > 0){
			echo "<script>alert('Data Berhasil Dihapus');</script>";
		}
		echo "<script>window.location='".site_url('user')."';</script>";
	}

	}

