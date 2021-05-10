<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class customer_m extends CI_Model {

public function get($id = null)
{
	$this->db->from('customer');
	if($id != null) {
		$this->db->where('id_customer', $id); ///menampilkan satu saja yang sesuai parameternya 
	}
	$query = $this->db->get();
	return $query;
}
public function tambah($post)
{
	//['disamakan pada table(field'] = ['disamakan pada name pada form']
	$params = [
		'nama_customer' => $post['nama_customer'],
		'gender' => $post['gender'],
		'no_hp' => $post['no_hp'],
		'alamat' => $post['alamat'],
	];
	$this->db->insert('customer', $params);
}
public function edit($post)
{
	$params = [
		'nama_customer' => $post['nama_customer'],
		'gender' => $post['gender'],
		'no_hp' => $post['no_hp'],
		'alamat' => $post['alamat'],
		'updated' => date('Y-m-d H:i:s')
	];
	$this->db->where('id_customer', $post['id']);
	$this->db->update('customer', $params);
}
public function hapus($id)
	{
		$this->db->where('id_customer', $id);
		$this->db->delete('customer');
	}

}