<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class produk extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model(['produk_m','brand_m','jenis_m']);
	}

	 function get_ajax() {
        $list = $this->produk_m->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $produk) {
            $no++;
            $row = array();
            $row[] = $no.".";
            $row[] = $produk->barcode.'<br><a href="'.site_url('produk/barcode_qrcode/'.$produk->id_produk).'" class="btn btn-default btn-xs">Generate <i class="fa fa-barcode"></i></a>';
            $row[] = $produk->nama_produk;
            $row[] = $produk->nama_brand;
            $row[] = $produk->nama_jenis;
            $row[] = indo_currency($produk->harga);
            $row[] = $produk->stock;
            // add html for action
            $row[] = '<a href="'.site_url('produk/edit/'.$produk->id_produk).'" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                    <a href="'.site_url('produk/hapus/'.$produk->id_produk).'" onclick="return confirm(\'Yakin hapus data?\')"  class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>';
            $data[] = $row;
        }
        $output = array(
                    "draw" => @$_POST['draw'],
                    "recordsTotal" => $this->produk_m->count_all(),
                    "recordsFiltered" => $this->produk_m->count_filtered(),
                    "data" => $data,
                );
        // output to json format
        echo json_encode($output);
    }
	public function index()
	{
		$data['row'] = $this->produk_m->get();
		$this->template->load('template', 'produk/produk_data', $data);
	}

	public function tambah()
	{
		$produk = new stdClass();
		$produk->id_produk = null;
		$produk->barcode = null;
		$produk->nama_produk = null;
		$produk->harga = null;
		$produk->id_brand = null;

		$query_brand = $this->brand_m->get(); //melempar data

		$query_jenis = $this->jenis_m->get(); 
		$jenis[null] = '- Pilih -';
		foreach($query_jenis->result() as $jen) {
			$jenis[$jen->id_jenis] = $jen->nama_jenis;
		}
		$data = array(
			'page' => 'tambah',
			'row' =>  $produk,
			'brand' => $query_brand,
			'jenis' => $jenis, 'selectedjenis' => null,
		);
		$this->template->load('template', 'produk/produk_form', $data);
	}

	public function edit($id)
	{
		$query = $this->produk_m->get($id);
		if($query->num_rows() > 0){
			$produk = $query->row();
			$query_brand = $this->brand_m->get(); //melempar data

			$query_jenis = $this->jenis_m->get(); 
			$jenis[null] = '- Pilih -';
			foreach($query_jenis->result() as $jen) {
				$jenis[$jen->id_jenis] = $jen->nama_jenis;
			}

			$data = array(
				'page' => 'edit',
				'row' =>  $produk,
				'brand' => $query_brand,
				'jenis' => $jenis, 'selectedjenis' => $produk->id_jenis,
			);
		$this->template->load('template', 'produk/produk_form', $data);
		} else {
			echo "<script>alert('Data tidak diprodukukan');";
			echo "window.location='".site_url('produk')."';</script>";
		}
	}

	public function proses()
	{
		$post = $this->input->post(null,TRUE);
		if(isset($_POST['tambah'])){
			// pemanggilan check-barcode             untuk ketika edit barcode tetep bisa disimpan
			if($this->produk_m->check_barcode($post['barcode'], $post['id'])->num_rows() > 0 ){
		$this->session->set_flashdata('error', "Barcode $post[barcode] sudah dipakai produk lain");
		redirect('produk/tambah');
			} else {
			$this->produk_m->tambah($post);
		}
		} else if (isset($_POST['edit'])){
			if($this->produk_m->check_barcode($post['barcode'], $post['id'])->num_rows() > 0 ){
		$this->session->set_flashdata('error', "Barcode $post[barcode] sudah dipakai produk lain");
		redirect('produk/edit/'.$post['id']);
			} else {
			$this->produk_m->edit($post);
		}
		}
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('success', 'Data Berhasil Disimpan');
		}
		redirect('produk');
	}
	public function hapus($id)
	{
		
		$this->produk_m->hapus($id);
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('success', 'Data Berhasil Dihapus');
		}
		redirect('produk');
	}
	function barcode_qrcode($id)
	{
		
		$data['row'] = $this->produk_m->get($id)->row();
		$this->template->load('template', 'produk/barcode_qrcode', $data);
	}
	function barcode_print($id)
	{
		$data['row'] = $this->produk_m->get($id)->row();
		$html = $this->load->view('produk/barcode_print', $data, true);
		$this->fungsi->pdfGenerator($html,'barcode-'.$data['row']->barcode, 'A4', 'landscape');
	}
	function qrcode_print($id)
	{
		$data['row'] = $this->produk_m->get($id)->row();
		$html = $this->load->view('produk/qrcode_print', $data, true);
		$this->fungsi->pdfGenerator($html,'qrcode-'.$data['row']->barcode, 'A4', 'Potrait');
	}
}
