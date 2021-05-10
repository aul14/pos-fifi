<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_m extends CI_Model {

	public function get($id = null)
	{
		$this->db->from('stock');
		if($id != null) {
			$this->db->where('id_stock', $id);
		}
		 $query = $this->db->get(); // tampung divariabel
		 return $query;
	}
	public function hapus($id)
	{
		$this->db->where('id_stock', $id);
		$this->db->delete('stock');
	}

	public function get_stock_in()
	{
		$this->db->select('stock.id_stock, produk.barcode, produk.nama_produk, qty, date, detail, supplier.nama_supplier, produk.id_produk');
		$this->db->from('stock');
		$this->db->join('produk','stock.id_produk = produk.id_produk');
		$this->db->join('supplier','stock.id_supplier = supplier.id_supplier', 'left');
		$this->db->where('type' , 'in');
		$this->db->order_by('id_stock', 'desc');
		$query = $this->db->get();
		return $query;
	}

	public function get_stock_out()
	{
		$this->db->select('stock.id_stock, produk.barcode, produk.nama_produk, qty, date, info,produk.id_produk');
		$this->db->from('stock');
		$this->db->join('produk','stock.id_produk = produk.id_produk');
		$this->db->where('type' , 'out');
		$this->db->order_by('barcode', 'asc');
		$query = $this->db->get();
		return $query;
	}

	public function tambah_stock_in($post)
	{
		$params = [
		'id_produk' => $post['id_produk'],
		'type' => 'in',
		'detail' => $post['detail'],
		'id_supplier' => $post['supplier'] == '' ? null : $post['supplier'] ,
		'qty' => $post['qty'],
		'date' => $post['date'],
		'id_user' => $this->session->userdata('id_user'),
	];
	$this->db->insert('stock', $params);
	}
	// stock out
	
	public function tambah_stock_out($post)
	{
		$params = [
		'id_produk' => $post['id_produk'],
		'type' => 'out',
		'info' => $post['info'],
		'qty' => $post['qty'],
		'date' => $post['date'],
		'id_user' => $this->session->userdata('id_user'),
	];
	$this->db->insert('stock', $params);
	}
// 	function check_stockout($stock, $id = null)
// {
//     $this->db->from('produk');
//     $this->db->where('stock', $stock);
//     if($id != null) {
//      $this->db->where('id_stock !=', $id);
//  }
//  $query = $this->db->get();
//  return $query;
// } 
}