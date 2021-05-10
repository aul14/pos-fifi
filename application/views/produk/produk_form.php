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
  <?php $this->view('messages') ?>
	<!-- DataTales Example -->
	<div class="card shadow ">
		<div class="card-header ">
			<h6 class="m-0 font-weight-bold text-gray"><?=ucfirst($page)?> Produk</h6>
			<p class="mb-2"></p>
			<div class=" text-right">
				<div align="right"><a href="<?=site_url('produk')?>" class="btn btn-blue btn-outline-danger btn-sm">
					<i class="fa fa-undo"></i> Kembali
				</a></div>
			</div></div>
			<p class="mb-1"></p>
			<div class="card-body">
    <div class="row justify-content-md-center">
					<div class="col-md-4 col-md-offset-7">
						<form action="<?=site_url('produk/proses')?>" method="post">
							<div class="form-group">
								<label>
									<div align="center">Barcode *</div></label>
									<div align="center">
										<input type="hidden" name="id" value="<?=$row->id_produk?>">
										<input type="text" name="barcode" value="<?=$row->barcode?>" class="form-control" required>
									</div>
								</div>
							<div class="form-group">
								<label for="nama_produk">
									<div align="center">Nama Produk *</div></label>
									<div align="center">
										<input type="text" name="nama_produk" id="nama_produk" value="<?=$row->nama_produk?>" class="form-control" required>
									</div>
								</div>
								<!-- Cara pertama dengan manual -->
								<div class="form-group">
								<label>
									<div align="center">Brand *</div></label>
									<div align="center">
										<select name="brand" class="form-control" required>
											<option value="">- Pilih -</option>
											<?php foreach($brand->result() as $key => $data) { ?>
										<option value="<?=$data->id_brand?>" <?=$data->id_brand == $row->id_brand ? "selected" : null?>><?=$data->nama_brand?></option>

											<?php } ?>
										</select>
									</div>
								</div>
								<!-- Cara kedua dengan formdown loopingnya/ valuenya di controller -->
								<div class="form-group">
								<label>
									<div align="center">Jenis *</div></label>
									<div align="center">
										<?php echo form_dropdown('jenis', $jenis, $selectedjenis,       ['class' => 'form-control', 'required' => 'required']) ?>
									</div>
								</div>
								<div class="form-group">
								<label>
									<div align="center">Harga *</div></label>
									<div align="center">
										<input type="number" name="harga" value="<?=$row->harga?>" class="form-control" required>
									</div>
								</div>
								<div class="form-group">
									<div class="text-center">
										<div align="center">
											<button type="submit" name="<?=$page?>" class="btn btn-success btn-flat"> <i class="fa fa-paper-plane"></i> Save</button>
											<button type="reset" class="btn btn-primary btn-flat">Reset</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
