<section class="content-header">
  <h2>Data Supplier</h2>
  <ol class="breadcrumb text-right">
    <li><a href="#"></a></li>
    <li class="active">Pemasok Barang</li>
  </ol>
</section>

<!-- Page Heading -->
<section class="content">
  <?php $this->view('messages') ?>
  <p class="mb-4"></p>
  <!-- DataTales Example -->
  <div class="card shadow ">
    <div class="card-header ">
      <h6 class="m-0 font-weight-bold text-gray">Data Supplier</h6>
    <div class=" text-right">
     <a href="<?=site_url('supplier/tambah')?>" class="btn btn-blue btn-outline-success btn-sm">
      <i class="fa fa-plus"></i> Tambah supplier
    </a>
  </div></div>
  <p class="mb-4"></p>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>No.Hp</th>
            <th>Alamat</th>
            <th>Deskripsi</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
         <?php $no = 1;
         foreach($row->result() as $key => $data) { ?>
         <tr>
          <td style="width:5%;"><?=$no++?>.</td>
          <td><?=$data->nama_supplier?></td>
          <td><?=$data->no_hp?></td>
          <td><?=$data->alamat?></td>
          <td><?=$data->deskripsi?></td>
          <td class="text-center" width="250px">
           <a href="<?=site_url('supplier/edit/'.$data->id_supplier)?>" class="btn btn-warning btn-xs">
            <i class="fa fa-edit""></i> Edit
          </a>
        <a href="<?=site_url('supplier/hapus/'.$data->id_supplier)?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-xs">
            <i class="fa fa-trash"></i> Hapus
          </a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</div>
</div>
</section>