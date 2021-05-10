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
			<h6 class="m-0 font-weight-bold text-gray">Edit User</h6>
		<div class=" text-right">
			<a href="<?=site_url('user')?>" class="btn btn-blue btn-outline-danger btn-sm">
				<i class="fa fa-undo"></i> Kembali
			</a>
		</div></div>
		<p class="mb-1"></p>
		<div class="card-body">
			<div class="row justify-content-md-center">
				<div class="col-md-4 col-md-offset-7">
					<form action="" method="post">
						<div class="form-group <?=form_error('fullname') ? 'has-error' : null?>">
							<label>Nama *</label>
							<input type="hidden" name="id_user" value="<?=$row->id_user?>">
							<input type="text" name="fullname" value="<?=$this->input->post('fullname') ? $this->input->post('fullname')  : $row->nama_user ;?>" class="form-control">
							<?=form_error('fullname')?>
						</div>
						<div class="form-group <?=form_error('email') ? 'has-error' : null?>">
							<label>Email *</label>
							<input type="text" name="email" value="<?=$this->input->post('email') ? $this->input->post('email') : $row->email ;?>" class="form-control">
							<?=form_error('email')?>
						</div>
						<div class="form-group <?=form_error('password') ? 'has-error' : null?>">
							<label>Password</label>
							<input type="password" name="password" value="<?=$this->input->post('password')?>" class="form-control">
							<?=form_error('password')?>
						</div>
						<div class="form-group <?=form_error('hak_akses') ? 'has-error' : null?>">
							<label>Hak Akses</label>
							<select type="text" name="hak_akses" class="form-control">
								<?php $hak_akses = $this->input->post('hak_akses') ? $this->input->post('hak_akses') : $row->hak_akses ?>
								<option value="1"> Admin </option>
								<option value="2" <?=$hak_akses == 2 ? 'selected' : null?>> Kasir </option>
							</select>
							<?=form_error('hak_akses')?>
						</div>
						<div class="form-group <?=form_error('status_user') ? 'has-error' : null?>">
							<label>Status User</label>
							<select type="text" name="status_user" class="form-control">
								<?php $status_user = $this->input->post('status_user') ? $this->input->post('status_user') : $row->status_user ?>
								<option value="1"> Aktif </option>
								<option value="2"<?=$status_user == 2 ? 'selected' : null?>> Tidak Aktif </option>
							</select>
							<?=form_error('status_user')?>
						</div>
						<div class="form-group">
							<div class="text-center"><button type="submit" class="btn btn-success btn-flat"> <i class="fa fa-paper-plane"></i> Edit</button>
								<button type="reset" class="btn btn-primary btn-flat">Reset</button></div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
