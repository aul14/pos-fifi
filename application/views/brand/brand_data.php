<section class="content-header">
  <h2>Data Brand</h2>
  <ol class="breadcrumb text-right">
    <li><a href="#"></a></li>
    <li class="active">Satuan Brand</li>
  </ol>
</section>

<!-- Page Heading -->
<section class="content">
  <?php $this->view('messages') ?>
  <p class="mb-4"></p>
  <!-- DataTales Example -->
  <div class="card shadow ">
    <div class="card-header ">
      <h6 class="m-0 font-weight-bold text-gray">Data Brand</h6>
    <div class=" text-right">
     <a href="<?=site_url('brand/tambah')?>" class="btn btn-blue btn-outline-success btn-sm">
      <i class="fa fa-plus"></i> Tambah Brand
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
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
         <?php $no = 1;
         foreach($row->result() as $key => $data) { ?>
         <tr>
          <td style="width:5%;"><?=$no++?>.</td>
          <td><?=$data->nama_brand?></td>
          <td class="text-center" width="250px">
           <a href="<?=site_url('brand/edit/'.$data->id_brand)?>" class="btn btn-warning btn-xs">
            <i class="fa fa-edit""></i> Edit
          </a>
        <a href="<?=site_url('brand/hapus/'.$data->id_brand)?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-xs">
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