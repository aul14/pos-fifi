<section class="content-header">
  <h2>Data Jenis</h2>
  <ol class="breadcrumb text-right">
    <li><a href="#"></a></li>
    <li class="active">Satuan Jenis</li>
  </ol>
</section>

<!-- Page Heading -->
<section class="content">
	<p class="mb-4"></p>
	<!-- DataTales Example -->
	<div class="card shadow ">
		<div class="card-header ">
			<h6 class="m-0 font-weight-bold text-gray"><?=ucfirst($page)?> jenis</h6>
		<div class=" text-right">
			<div align="right"><a href="<?=site_url('jenis')?>" class="btn btn-blue btn-outline-danger btn-sm">
				<i class="fa fa-undo"></i> Kembali
			</a></div>
		</div></div>
		<p class="mb-1"></p>
		<div class="card-body">
    <div class="row justify-content-md-center">
				<div class="col-md-4 col-md-offset-7">
					<form action="<?=site_url('jenis/proses')?>" method="post">
						<div class="form-group">
							<label>
								<div align="center">Nama jenis *</div></label>
								<div align="center">
									<input type="hidden" name="id" value="<?=$row->id_jenis?>">
									<input type="text" name="nama_jenis" value="<?=$row->nama_jenis?>" class="form-control" required>
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
