<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends CI_Model {

	public function login($post)
	{
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where('email', $post['email']);
		$this->db->where('password', $post['password']); ///'sesuai db', 'sesuai name'
		$query = $this->db->get();
		return $query;
}
public function get($id = null)
{
	$this->db->from('tbl_user');
	if($id != null) {
		$this->db->where('id_user', $id); ///menampilkan satu saja yang sesuai parameternya 
	}
	$query = $this->db->get();
	return $query;
}
public function tambah($post)
{
	//['disamakan pada table(field'] = ['disamakan pada name pada form']
	$params['email'] = $post['email'];
	$params['nama_user'] = $post['fullname'];
	$params['password'] = $post['password'];
	$params['hak_akses'] = $post['hak_akses'];
	$params['status_user'] = $post['status_user'];
	$this->db->insert('tbl_user', $params);
}
public function edit($post)
{
	//['disamakan pada table(field'] = ['disamakan pada name pada form']
	$params['email'] = $post['email'];
	$params['nama_user'] = $post['fullname'];
	if(!empty($post['password'])){ //// artinya tidak wajib untuk diganti (opsional)
	$params['password'] = $post['password'];
	}
	$params['hak_akses'] = $post['hak_akses'];
	$params['status_user'] = $post['status_user'];
	$this->db->where('id_user', $post['id_user']);
	$this->db->update('tbl_user', $params);
}
public function hapus($id)
	{
		$this->db->where('id_user', $id);
		$this->db->delete('tbl_user');
	}

}
