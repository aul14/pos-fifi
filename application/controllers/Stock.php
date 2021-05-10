<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model(['produk_m', 'supplier_m', 'stock_m']);
	}
	public function stock_in_data()
	{
		$data['row'] = $this->stock_m->get_stock_in()->result();
		$this->template->load('template', 'stock/stock_in/stock_in_data', $data);
		
	}
	public function stock_out_data()
	{
		$data['row'] = $this->stock_m->get_stock_out()->result();
		$this->template->load('template', 'stock/stock_out/stock_out_data', $data);
		
	}
	public function stock_in_add()
	{
		$produk = $this->produk_m->get()->result();
		$supplier = $this->supplier_m->get()->result();
		$data = ['produk' => $produk, 'supplier' => $supplier];
		$this->template->load('template', 'stock/stock_in/stock_in_form', $data);
		
	}
	public function stock_out_add()
	{
		$produk = $this->produk_m->get()->result();
		$data = ['produk' => $produk];
		$this->template->load('template', 'stock/stock_out/stock_out_form', $data);
		
	}
	public function stock_in_del()
	{
		$id_stock = $this->uri->segment(4); // dihitung dari array pada url
		$id_produk = $this->uri->segment(5); // dihitung dari array pada url
		$qty = $this->stock_m->get($id_stock)->row()->qty;
		$data = ['qty' => $qty, 'id_produk' => $id_produk];
		$this->produk_m->update_stock_out($data);
		$this->stock_m->hapus($id_stock);
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('success', 'Data Stock-In Berhasil Dihapus');
		}
		redirect('stock/in');
	}

	public function stock_out_del()
	{
		$id_stock = $this->uri->segment(4); // dihitung dari array pada url
		$id_produk = $this->uri->segment(5); // dihitung dari array pada url
		$qty = $this->stock_m->get($id_stock)->row()->qty;
		$data = ['qty' => $qty, 'id_produk' => $id_produk];
		$this->produk_m->update_out_out($data);
		$this->stock_m->hapus($id_stock);
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('success', 'Data Stock-Out Berhasil Dihapus');
		}
		redirect('stock/out');
	}


	public function proses()
	{
		if(isset($_POST['in_add'])){
			$post = $this->input->post(null,TRUE);
			$this->stock_m->tambah_stock_in($post);
			$this->produk_m->update_stock_in($post);
		}
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('success', 'Data Stock-In Berhasil Disimpan');
		}
		redirect('stock/in');
	}

	public function proses_out(){
		$cekqty = @$_POST['qty'];
		$cekstock = @$_POST['stock'];

		if (isset($_POST['out_add'])){
			if($cekqty > $cekstock){
				$this->session->set_flashdata('error', "Quantity $post[qty] tidak boleh melebih stock");
				redirect ('stock/out');
			} else {
				$post = $this->input->post(null,TRUE);
				$this->stock_m->tambah_stock_out($post);
				$this->produk_m->update_in_out($post);

				if($this->db->affected_rows() > 0){
					$this->session->set_flashdata('success', 'Data Stock-Out Berhasil Disimpan');

				}
				redirect('stock/out');
			}
		}

	}

}
