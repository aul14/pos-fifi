<section class="content-header">
	<h2>Data User</h2>
	<ol class="breadcrumb text-right">
		<li><a href="#"></a></li>
		<li class="active">Pengguna</li>
	</ol>
</section>

<!-- Page Heading -->
<section class="content">
	<p class="mb-4"></p>
	<!-- DataTales Example -->
	<div class="card shadow ">
		<div class="card-header ">
			<h6 class="m-0 font-weight-bold text-gray">Add User</h6>
		<div class=" text-right">
			<div align="right"><a href="<?=site_url('user')?>" class="btn btn-blue btn-outline-danger btn-sm">
				<i class="fa fa-undo"></i> Kembali
			</a></div>
		</div>
		</div>
		<p class="mb-1"></p>
		<div class="card-body">
    <div class="row justify-content-md-center">
				<div class="col-md-4 col-md-offset-7">
					<?php //echo validation_errors() ?>
					<form action="" method="post">
						<div class="form-group <?=form_error('fullname') ? 'has-error' : null?>">
							<label>
								<div align="center">Nama *</div>
							</label>
							
								<input type="text" name="fullname" value="<?=set_value('fullname')?>" class="form-control">
								<?=form_error('fullname')?>
							
						</div>
						<div class="form-group <?=form_error('email') ? 'has-error' : null?>">
							<label>
								<div align="center">Email *</div>
							</label>
							
								<input type="text" name="email" value="<?=set_value('email')?>" class="form-control">
								<?=form_error('email')?>
							
						</div>
						<div class="form-group <?=form_error('password') ? 'has-error' : null?>">
							<label>
								<div align="center">Password *</div>
							</label>
							
								<input type="password" name="password" value="<?=set_value('password')?>" class="form-control">
								<?=form_error('password')?>
							
						</div>
						<div class="form-group <?=form_error('hak_akses') ? 'has-error' : null?>">
							<label>
								<div align="center">Hak Akses *</div>
							</label>
							
								<select type="text" name="hak_akses" class="form-control">
									<option value="">- Pilih -</option>
									<option value="1" <?=set_value('hak_akses') == 1 ? "selected" : null?>> Admin </option>
									<option value="2" <?=set_value('hak_akses') == 2 ? "selected" : null?>> Kasir </option>
								</select>
								<?=form_error('hak_akses')?>
							
						</div>
						<div class="form-group <?=form_error('status_user') ? 'has-error' : null?>">
							<label>
								<div align="center">Status User *</div>
							</label>
							
								<select type="text" name="status_user" class="form-control">
									<option value="">- Pilih -</option>
									<option value="1" <?=set_value('status_user') == 1 ? "selected" : null?>> Aktif </option>
									<option value="2" <?=set_value('status_user') == 2 ? "selected" : null?>> Tidak Aktif </option>
								</select>
								<?=form_error('status_user')?>
							
						</div>
						<div class="form-group">
							<div class="text-center">
								
									<button type="submit" class="btn btn-success btn-flat"> <i class="fa fa-paper-plane"></i> Save</button>
									<button type="reset" class="btn btn-primary btn-flat">Reset</button>
								
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
