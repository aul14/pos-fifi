<section class="content-header">
  <h2>Stock Out</h2>
  <ol class="breadcrumb text-right">
    <li><a href="#"></a></li>
    <li class="active">Barang Keluar</li>
  </ol>
</section>

<!-- Page Heading -->
<section class="content">
  <?php $this->view('messages') ?>
  <p class="mb-4"></p>
  <!-- DataTales Example -->
  <div class="card shadow ">
    <div class="card-header ">
      <h6 class="m-0 font-weight-bold text-gray">Data Stock Out</h6>
      <div class=" text-right">
       <a href="<?=site_url('stock/out/add')?>" class="btn btn-blue btn-outline-success btn-sm">
        <i class="fa fa-plus"></i> Tambah Stock Out
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
              <th>Produk Item</th>
              <th>Qty</th>
              <th>info</th>
              <th>Date</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
           <?php $no = 1;
           foreach($row as $key => $data) { ?>
           <tr>
            <td style="width:5%;"><?=$no++?>.</td>
            <td><?=$data->barcode?></td>
            <td><?=$data->nama_produk?></td>
            <td class="text-right"><?=$data->qty?></td>
            <td><?=$data->info?></td>
            <td class="text-center"><?=indo_date($data->date)?></td>
            <td class="text-center" width="250px">
             <a  id="set_dtl" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#modal-detail" 
             data-barcode="<?=$data->barcode?>"
             data-namaproduk="<?=$data->nama_produk?>"
             data-info="<?=$data->info?>"
             data-qty="<?=$data->qty?>"
             data-date="<?=indo_date($data->date)?>">
              <i class="fa fa-eye""></i> Details
            </a>
            <a href="<?=site_url('stock/out/hapus/'.$data->id_stock.'/'.$data->id_produk)?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-xs">
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

  <div class="modal fade" tabindex="-1" id="modal-detail">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Stock Out Detail</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body table-responsive">
          <table class="table table-bordered no-margin">
            <tbody>
              <tr>
                <th style="width: 35%">Barcode</th>
                <td><span id="barcode"></span></td>
              </tr>
               <tr>
                <th>Nama Produk</th>
                <td><span id="nama_produk"></span></td>
              </tr>
               <tr>
                <th>Info</th>
                <td><span id="info"></span></td>
              </tr>
               <tr>
                <th>Qty</th>
                <td><span id="qty"></span></td>
              </tr>
               <tr>
                <th>Date</th>
                <td><span id="date"></span></td>
              </tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>

    <script>
  $(document).ready(function() {
    $(document).on('click', '#set_dtl', function() {
      var barcode = $(this).data('barcode');
      var namaproduk = $(this).data('namaproduk');
      var info = $(this).data('info');
      var qty = $(this).data('qty');
      var date = $(this).data('date');
      $('#barcode').text(barcode);
      $('#nama_produk').text(namaproduk);
      $('#info').text(info);
      $('#qty').text(qty);
      $('#date').text(date);
      $('#info').text(info);
    })
  })
</script>