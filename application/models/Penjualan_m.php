<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_m extends CI_Model {

	public function invoice_no()
	{
		$sql = "SELECT MAX(MID(invoice,9,4)) AS invoice_no 
				from penjualan
				WHERE MID(invoice,3,6) = date_format(curdate(), '%y%m%d')";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0){
			$row = $query->row();
			$n = ((int)$row->invoice_no) + 1;
			$no = sprintf("%'.04d", $n);
		} else {
			$no = "0001";
		}
		$invoice = "UM".date('ymd').$no;
		return $invoice;
	}

	public function get($id = null)
	{
		$this->db->from('penjualan');
		if($id != null) {
			$this->db->where('id_penjualan', $id);
		}
		 $query = $this->db->get(); // tampung divariabel
		 return $query;
	}

}