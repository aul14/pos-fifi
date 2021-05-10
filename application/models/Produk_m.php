<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class produk_m extends CI_Model {
	  // start datatables
    var $column_order = array(null, 'barcode', 'produk.nama_produk', 'nama_brand', 'nama_jenis', 'harga', 'stock'); //set column field database for datatable orderable
    var $column_search = array('barcode', 'produk.nama_produk','brand.nama_brand','jenis.nama_jenis', 'harga'); //set column field database for datatable searchable
    var $order = array('id_produk' => 'asc'); // default order 
    
    private function _get_datatables_query() {
        $this->db->select('produk.*, brand.nama_brand as nama_brand, jenis.nama_jenis as nama_jenis');
        $this->db->from('produk');
        $this->db->join('brand', 'produk.id_brand = brand.id_brand');
        $this->db->join('jenis', 'produk.id_jenis = jenis.id_jenis');
        $i = 0;
        foreach ($this->column_search as $produk) { // loop column 
            if(@$_POST['search']['value']) { // if datatable send POST for search
                if($i===0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($produk, $_POST['search']['value']);
                } else {
                    $this->db->or_like($produk, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }
            
        if(isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }  else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables() {
        $this->_get_datatables_query();
        if(@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all() {
        $this->db->from('produk');
        return $this->db->count_all_results();
    }
    // end datatables

    public function get($id = null)
    {
		//memberi alias nama jika fieldnya sama
      $this->db->select('produk.*, brand.nama_brand as nama_brand, jenis.nama_jenis as nama_jenis');
		//
      $this->db->from('produk');
      $this->db->join('brand', 'brand.id_brand = produk.id_brand');
      $this->db->join('jenis', 'jenis.id_jenis = produk.id_jenis');
      if($id != null) {
		$this->db->where('id_produk', $id); ///menampilkan satu saja yang sesuai parameternya 
	}
	$query = $this->db->get();
	return $query;
}
public function tambah($post)
{
	//['disamakan pada table(field'] = ['disamakan pada name pada form']
	$params = [
		'barcode' => $post['barcode'],
		'nama_produk' => $post['nama_produk'],
		'id_brand' => $post['brand'],
		'id_jenis' => $post['jenis'],
		'harga' => $post['harga'],
	];
	$this->db->insert('produk', $params);
}
public function edit($post)
{
	$params = [
		'barcode' => $post['barcode'],
		'nama_produk' => $post['nama_produk'],
		'id_brand' => $post['brand'],
		'id_jenis' => $post['jenis'],
		'harga' => $post['harga'],
        'updated' => date('Y-m-d H:i:s')
        
    ];
    $this->db->where('id_produk', $post['id']);
    $this->db->update('produk', $params);
}
function check_barcode($code, $id = null)
{
    $this->db->from('produk');
    $this->db->where('barcode', $code);
    if($id != null) {
     $this->db->where('id_produk !=', $id);
 }
 $query = $this->db->get();
 return $query;
} 

public function hapus($id)
{
	$this->db->where('id_produk', $id);
	$this->db->delete('produk');
}
function update_stock_in($data)
{
    $qty = $data['qty'];
    $id = $data['id_produk'];
    $sql = "UPDATE produk SET stock = stock + '$qty' WHERE id_produk = '$id'"; 
    $this->db->query($sql);
}
function update_in_out($data)
{
    $qty = $data['qty'];
    $id = $data['id_produk'];
    $sql = "UPDATE produk SET stock = stock - '$qty' WHERE id_produk = '$id'"; 
    $this->db->query($sql);
}
function update_stock_out($data)
{
    $qty = $data['qty'];
    $id = $data['id_produk'];
    $sql = "UPDATE produk SET stock = stock - '$qty' WHERE id_produk = '$id'"; 
    $this->db->query($sql);
}

function update_out_out($data)
{
    $qty = $data['qty'];
    $id = $data['id_produk'];
    $sql = "UPDATE produk SET stock = stock + '$qty' WHERE id_produk = '$id'"; 
    $this->db->query($sql);
}
}