<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jenis_m extends CI_Model {

public function get($id = null)
{
	$this->db->from('jenis');
	if($id != null) {
		$this->db->where('id_jenis', $id); ///menampilkan satu saja yang sesuai parameternya 
	}
	$query = $this->db->get();
	return $query;
}
public function tambah($post)
{
	//['disamakan pada table(field'] = ['disamakan pada name pada form']
	$params = [
		'nama_jenis' => $post['nama_jenis'],
	];
	$this->db->insert('jenis', $params);
}
public function edit($post)
{
	$params = [
		'nama_jenis' => $post['nama_jenis'],
		'updated' => date('Y-m-d H:i:s')
		
	];
	$this->db->where('id_jenis', $post['id']);
	$this->db->update('jenis', $params);
}
public function hapus($id)
	{
		$this->db->where('id_jenis', $id);
		$this->db->delete('jenis');
	}

}