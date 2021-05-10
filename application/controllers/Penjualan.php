<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model(['penjualan_m', 'produk_m', 'supplier_m', 'stock_m']);
	}

	public function index()
	{
		$produk = $this->db->select('produk.*, jenis.nama_jenis, brand.nama_brand')
			->from('produk')
			->join('jenis', 'jenis.id_jenis = produk.id_jenis', 'left')
			->join('brand', 'brand.id_brand = produk.id_brand', 'left')
			->get()->result();

		$data = array(
			'invoice' => $this->penjualan_m->invoice_no(),
			'produk'	=> $produk
		);
		$this->template->load('template', 'penjualan/penjualan_form', $data);
	}
}
