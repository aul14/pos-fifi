<section class="content-header">
	<h2>Stock Out</h2>
	<ol class="breadcrumb text-right">
		<li><a href="#"></a></li>
		<li class="active">Barang Keluar</li>
	</ol>
</section>

<!-- Page Heading -->
<section class="content">
	<p class="mb-4"></p>
	<!-- DataTales Example -->
	<div class="card shadow ">
		<div class="card-header ">
			<h6 class="m-0 font-weight-bold text-gray"> Add Stock Out</h6>
		<div class=" text-right">
			<div align="right"><a href="<?=site_url('stock/out')?>" class="btn btn-blue btn-outline-danger btn-sm">
				<i class="fa fa-undo"></i> Kembali
			</a></div>
		</div></div>
		<p class="mb-1"></p>
		<div class="card-body">
    <div class="row justify-content-md-center">
				<div class="col-md-4 col-md-offset-7">
					<form action="<?=site_url('stock/proses_out')?>" method="post">
						<div class="form-group">
							<label>Date *</label>
									<input type="date" name="date" value="<?=date('Y-m-d')?>" class="form-control" required>
							</div>
							<div>
							<label for="barcode">Barcode *</label>
							</div>
							<div class="form-group input-group">
							<input type="hidden" name="id_produk" id="id_produk">
							<input type="text" name="barcode" id="barcode" class="form-control" required autofocus>
							<span class="input-group-btn">
								<button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-item"><i class="fa fa-search"></i></button>
							</span>
							</div>
							<div class="form-group">
							<label>Nama Produk *</label>
									<input type="text" name="nama_produk" id="nama_produk" class="form-control" readonly>
							</div>
							<div class="form-group">
							<div class="row">
								<div class="col-lg-8">
									<label for="nama_jenis"> Item Jenis</label>
									<input type="text" name="nama_jenis" id="nama_jenis" value="-" class="form-control" readonly>
								</div>
								<div class="col-lg-4"><label for="stock"> Intial Stock</label>
									<input type="text" name="stock" id="stock" value="-" class="form-control" readonly></div>
								</div>
							</div>
							<div class="form-group">
							<label>Info *</label>
									<input type="text" name="info" class="form-control"  placeholder="Rusak / Hilang / Kadaluwarsa / etc" required>
							</div>
							<div class="form-group">
							<label>Qty *</label>
									<input type="number" name="qty"  class="form-control" required>
							</div>
								<div class="form-group">
								<div class="text-center">
								<div align="center">
											<button type="submit" name="out_add" class="btn btn-success btn-flat"> <i class="fa fa-paper-plane"></i> Save</button>
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

	<div class="modal fade" tabindex="-1" id="modal-item">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Select Product Item</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body table-responsive">
					<table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Barcode</th>
								<th>Nama</th>
								<th>Jenis</th>
								<th>Harga</th>
								<th>Stock</th>
								<th>Opsi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($produk as $p => $data) { ?>
							<tr>
								<td><?=$data->barcode?></td>
								<td><?=$data->nama_produk?></td>
								<td><?=$data->nama_jenis?></td>
								<td class="text-right"><?=indo_currency($data->harga)?></td>
								<td class="text-right"><?=$data->stock?></td>
								<td class="text-right">
									<button class="btn btn-xs btn-info" id="select" 
									data-id="<?=$data->id_produk?>"
									data-barcode="<?=$data->barcode?>"
									data-nama_produk="<?=$data->nama_produk?>"
									data-nama_jenis="<?=$data->nama_jenis?>"
									data-stock="<?=$data->stock?>">
										<i class="fa fa-check"></i> Select
									</button>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<script>
	$(document).ready(function() {
		$(document).on('click', '#select', function() {
			var id_produk = $(this).data('id');
			var barcode = $(this).data('barcode');
			var nama_produk = $(this).data('nama_produk');
			var nama_jenis = $(this).data('nama_jenis');
			var stock = $(this).data('stock');
			$('#id_produk').val(id_produk);
			$('#barcode').val(barcode);
			$('#nama_produk').val(nama_produk);
			$('#nama_jenis').val(nama_jenis);
			$('#stock').val(stock);
			$('#modal-item').modal('hide');
		})
	})
</script>