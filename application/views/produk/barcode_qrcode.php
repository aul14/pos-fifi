<section class="content-header">
  <h2>Data Produk</h2>
  <ol class="breadcrumb text-right">
    <li><a href="#"></a></li>
    <li class="active">Produk</li>
  </ol>
</section>

<!-- Page Heading -->
<section class="content">
  <p class="mb-4"></p>
  <!-- DataTales Example -->
  <div class="card shadow ">
    <div class="card-header ">
      <h6 class="m-0 font-weight-bold text-gray">Barcode Generator <i class="fa fa-barcode"></i></h6>
      <div class=" text-right">
        <div align="right"><a href="<?=site_url('produk')?>" class="btn btn-blue btn-outline-danger btn-sm">
          <i class="fa fa-undo"></i> Kembali
        </a></div>
      </div></div>
      <p class="mb-1"></p>
      <div class="card-body">
        <?php
       $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($row->barcode, $generator::TYPE_CODE_128)) . '" style= "width: 200px" >';
        ?>
        <br>
        <?=$row->barcode?>
        <br><br>
          <a href="<?=site_url('produk/barcode_print/'.$row->id_produk)?>" target ="_blank" class="btn btn-default btn-xs">
            <i class="fa fa-print""></i> Print
          </a>
        </div>
      </div>

      <p class="mb-4"></p>
  <!-- DataTales Example -->
  <div class="card shadow ">
    <div class="card-header ">
      <h6 class="m-0 font-weight-bold text-gray">QR-Code Generator <i class="fa fa-qrcode"></i></h6>
      <p class="mb-2"></p>
      <p class="mb-1"></p>
    </div>
      <div class="card-body">
        <?php 
        $qrCode = new Endroid\QrCode\Qrcode($row->barcode);
        $qrCode->writeFile('upload/qr-code/produk-'.$row->barcode.'.png');
        ?>
        <img src="<?=base_url('upload/qr-code/produk-'.$row->barcode.'.png')?>" style= "width: 200px">
        <br>
        <?=$row->barcode?>
        <br><br>
        <a href="<?=site_url('produk/qrcode_print/'.$row->id_produk)?>" target ="_blank" class="btn btn-default btn-xs">
            <i class="fa fa-print""></i> Print
          </a>
        </div>
      </div>
    </section>
