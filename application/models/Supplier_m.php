<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_m extends CI_Model {

public function get($id = null)
{
	$this->db->from('supplier');
	if($id != null) {
		$this->db->where('id_supplier', $id); ///menampilkan satu saja yang sesuai parameternya 
	}
	$query = $this->db->get();
	return $query;
}
public function tambah($post)
{
	//['disamakan pada table(field'] = ['disamakan pada name pada form']
	$params = [
		'nama_supplier' => $post['nama_supplier'],
		'no_hp' => $post['no_hp'],
		'alamat' => $post['alamat'],
		'deskripsi' => empty($post['desk']) ? null : $post['desk'],
	];
	$this->db->insert('supplier', $params);
}
public function edit($post)
{
	$params = [
		'nama_supplier' => $post['nama_supplier'],
		'no_hp' => $post['no_hp'],
		'alamat' => $post['alamat'],
		'deskripsi' => empty($post['desk']) ? null : $post['desk'],
		'updated' => date('Y-m-d H:i:s')
	];
	$this->db->where('id_supplier', $post['id']);
	$this->db->update('supplier', $params);
}
public function hapus($id)
	{
		$this->db->where('id_supplier', $id);
		$this->db->delete('supplier');
	}

}