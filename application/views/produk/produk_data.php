<section class="content-header">
  <h2>Data Produk</h2>
  <ol class="breadcrumb text-right">
    <li><a href="#"></a></li>
    <li class="active">Produk</li>
  </ol>
</section>

<!-- Page Heading -->
<section class="content">
  <?php $this->view('messages') ?>
  <p class="mb-4"></p>
  <!-- DataTales Example -->
  <div class="card shadow ">
    <div class="card-header ">
      <h6 class="m-0 font-weight-bold text-gray">Data Produk</h6>
    <div class=" text-right">
     <a href="<?=site_url('produk/tambah')?>" class="btn btn-blue btn-outline-success btn-sm">
      <i class="fa fa-plus"></i> Tambah Produk
    </a>
  </div></div>
  <p class="mb-4"></p>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>Barcode</th>
            <th>Nama</th>
            <th>Brand</th>
            <th>Jenis</th>
            <th>Harga</th>
            <th>Stock</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
         <!-- <?php $no = 1;
         foreach($row->result() as $key => $data) { ?>
         <tr>
          <td style="width:5%;"><?=$no++?>.</td>
          <td>
            <?=$data->barcode?><br>
            <a href="<?=site_url('produk/barcode_qrcode/'.$data->id_produk)?>" class="btn btn-default btn-xs">
            Generate <i class="fa fa-barcode""></i> <i class="fa fa-qrcode""></i> 
          </a>
            </td>
          <td><?=$data->nama_produk?></td>
          <td><?=$data->nama_brand?></td>
          <td><?=$data->nama_jenis?></td>
          <td><?=$data->harga?></td>
          <td><?=$data->stock?></td>
          <td class="text-center" width="250px">
           <a href="<?=site_url('produk/edit/'.$data->id_produk)?>" class="btn btn-warning btn-xs">
            <i class="fa fa-edit""></i> Edit
          </a>
        <a href="<?=site_url('produk/hapus/'.$data->id_produk)?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-xs">
            <i class="fa fa-trash"></i> Hapus
          </a>
        </td>
      </tr>
      <?php } ?> -->
    </tbody>
  </table>
</div>
</div>
</div>
</section>

 <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
              "processing" :true,
              "serverSide" :true,
              "ajax" :{
                "url" : "<?=site_url('produk/get_ajax')?>",
                "type" : "POST"
              },
              "columnDefs" : [
              {
                "targets": [5,6],
                "className": 'text-right'
              },
              {
                "targets": [7],
                "className": 'text-center'
              },
              {
                "targets": [0,7],
                "orderable": false
              }
              ]

            })
        })
    </script>