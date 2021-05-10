<section class="content-header">
	<h2>Penjualan</h2>
	<ol class="breadcrumb text-right">
		<li><a href="#"></a></li>
		<li class="active">Penjualan</li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-lg-4">
			<div class="card card-widget">
				<div class="card-body">
					<table width="100%">
						<tr>
							<td style="vertical-align: top">
								<label for="date">Date</label>
							</td>
							<td>
								<div class="form-group">
									<input type="date" id="date" value="<?= date('Y-m-d') ?>" class="form-control">
								</div>
							</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width: 30%">
								<label for="user">Kasir</label>
							</td>
							<td>
								<div class="form-group">
									<input type="text" id="user" value="<?= $this->fungsi->user_login()->nama_user ?>" class="form-control" readonly>
								</div>
							</td>
						</tr>
						<tr>
							<td style="vertical-align: top">
								<label>Customer</label>
							</td>
							<td>
								<div>
									<select class="form-control">
										<option value="">Umum</option>
									</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card card-widget">
				<div class="card-body">
					<table width="100%">
						<tr>
							<td style="vertical-align: top; width: 30%">
								<label for="barcode">Barcode</label>
							</td>
							<td>
								<div class="form-group input-group">
									<input type="hidden" name="id_produk">
									<input type="hidden" name="harga">
									<input type="hidden" name="stock">
									<input type="text" id="barcode" class="form-control" autofocus>
									<span class="input-group-btn">
										<button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-item">
											<i class="fa fa-search"></i>
										</button>
									</span>
								</div>
							</td>
						</tr>
						<tr>
							<td style="vertical-align: top">
								<label for="qty">Qty</label>
							</td>
							<td>
								<div class="form-group">
									<input type="number" id="qty" value="1" min="1" class="form-control">
								</div>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<div>
									<button type="button" id="add_cart" class="btn btn-primary">
										<i class="fas  fa-shopping-cart"> Add</i>
									</button>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="card card-widget">
				<div class="card-body">
					<div align="right">
						<h4>Invoice <b><span id="invoice"><?= $invoice ?></span></b></h4>
						<h1><b><span id="grand_total12" style="font-size:50pt">0</span></b></h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-widget">
				<div class="card-body table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Barcode</th>
								<th>Produk item</th>
								<th>Harga</th>
								<th>Qty</th>
								<th>Diskon Item</th>
								<th>Total</th>
								<th>Opsi</th>
							</tr>
						</thead>
						<tbody id="cart_table">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-3">
			<div class="card card-widget">
				<div class="card-body">
					<table width="100%">
						<tr>
							<td style="vertical-align: top; width: 30%">
								<label for="sub_total"> Sub Total</label>
							</td>
							<td>
								<div class="form-group">
									<input type="number" id="sub_total" value="" class="form-control" readonly>
								</div>
							</td>
						</tr>
						<tr>
							<td style="vertical-align: top">
								<label for="diskon"> Diskon</label>
							</td>
							<td>
								<div class="form-group">
									<input type="number" id="diskon" value="0" min="0" class="form-control">
								</div>
							</td>
						</tr>
						<tr>
							<td style="vertical-align: top">
								<label for="grand_total"> Grand Total</label>
							</td>
							<td>
								<div class="form-group">
									<input type="number" id="grand_total" class="form-control" readonly>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-3">
			<div class="card card-widget">
				<div class="card-body">
					<table width="100%">
						<tr>
							<td style="vertical-align: top; width: 30%">
								<label for="cash"> Cash</label>
							</td>
							<td>
								<div class="form-group">
									<input type="number" id="cash" value="0" min="0" class="form-control">
								</div>
							</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width: 30%">
								<label for="change"> Change</label>
							</td>
							<td>
								<div class="form-group">
									<input type="number" id="change" class="form-control" readonly>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-3">
			<div class="card card-widget">
				<div class="card-body">
					<table width="100%">
						<tr>
							<td style="vertical-align: top">
								<label for="note"> Note</label>
							</td>
							<td>
								<div>
									<textarea id="note" rows="3" class="form-control"></textarea>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-3">
			<div>
				<button id="cancel_payment" class="btn btn-flat btn-warning">
					<i class="fas fa-sync"></i> Cancel
				</button><br><br>
				<button id="proses_payment" class="btn btn-flat btn-success">
					<i class="fa fa-paper-plane"></i> Proses Payment
				</button>
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
						<?php foreach ($produk as $p => $data) { ?>
							<tr>
								<td><?= $data->barcode ?></td>
								<td><?= $data->nama_produk ?></td>
								<td><?= $data->nama_jenis ?></td>
								<td class="text-right"><?= indo_currency($data->harga) ?></td>
								<td class="text-right"><?= $data->stock ?></td>
								<td class="text-right">
									<button class="btn btn-xs btn-info" id="select" data-id="<?= $data->id_produk ?>" data-barcode="<?= $data->barcode ?>" data-nama_produk="<?= $data->nama_produk ?>" data-nama_jenis="<?= $data->nama_jenis ?>" data-stock="<?= $data->stock ?>">
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