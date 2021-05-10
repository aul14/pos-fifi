<section class="content-header">
  <h2>Data Supplier</h2>
  <ol class="breadcrumb text-right">
    <li><a href="#"></a></li>
    <li class="active">Pemasok Barang</li>
  </ol>
</section>

<!-- Page Heading -->
<section class="content">
	<p class="mb-4"></p>
	<!-- DataTales Example -->
	<div class="card shadow ">
		<div class="card-header ">
			<h6 class="m-0 font-weight-bold text-gray"><?=ucfirst($page)?> Supplier</h6>
		<div class=" text-right">
			<div align="right"><a href="<?=site_url('supplier')?>" class="btn btn-blue btn-outline-danger btn-sm">
				<i class="fa fa-undo"></i> Kembali
			</a></div>
		</div></div>
		<p class="mb-1"></p>
		<div class="card-body">
    <div class="row justify-content-md-center">
				<div class="col-md-4 col-md-offset-7">
					<form action="<?=site_url('supplier/proses')?>" method="post">
						<div class="form-group">
							<label>Nama Supplier *</label>
								
									<input type="hidden" name="id" value="<?=$row->id_supplier?>">
									<input type="text" name="nama_supplier" value="<?=$row->nama_supplier?>" class="form-control" required>
							</div>
							<div class="form-group">
							<label>No. Hp *</label>
									<input type="number" name="no_hp" value="<?=$row->no_hp?>" class="form-control" required>
							</div>
							<div class="form-group">
							<label>Alamat *</label>
									<textarea name="alamat" class="form-control" required><?=$row->alamat?></textarea>
							</div>
							<div class="form-group">
							<label>Deskirpsi </label>
									<textarea name="desk" class="form-control"><?=$row->deskripsi?></textarea>
							</div>
								<div class="form-group">
											<button type="submit" name="<?=$page?>" class="btn btn-success btn-flat"> <i class="fa fa-paper-plane"></i> Save</button>
											<button type="reset" class="btn btn-primary btn-flat">Reset</button>
								</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
