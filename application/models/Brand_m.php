<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class brand_m extends CI_Model {

public function get($id = null)
{
	$this->db->from('brand');
	if($id != null) {
		$this->db->where('id_brand', $id); ///menampilkan satu saja yang sesuai parameternya 
	}
	$query = $this->db->get();
	return $query;
}
public function tambah($post)
{
	//['disamakan pada table(field'] = ['disamakan pada name pada form']
	$params = [
		'nama_brand' => $post['nama_brand'],
	];
	$this->db->insert('brand', $params);
}
public function edit($post)
{
	$params = [
		'nama_brand' => $post['nama_brand'],
		'updated' => date('Y-m-d H:i:s')
	];
	$this->db->where('id_brand', $post['id']);
	$this->db->update('brand', $params);

}
public function hapus($id)
	{
		$this->db->where('id_brand', $id);
		$this->db->delete('brand');
	}

}