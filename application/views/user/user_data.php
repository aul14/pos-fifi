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
      <h6 class="m-0 font-weight-bold text-gray">Data Users</h6>
    <div class=" text-right">
     <a href="<?=site_url('user/tambah')?>" class="btn btn-outline-success btn-sm">
      <i class="fa fa-user-plus"></i> Tambah User
    </a>
  </div></div>
  <p class="mb-4"></p>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>Email</th>
            <th>Nama</th>
            <th>Hak Akses</th>
            <th>Status User</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
         <?php $no = 1;
         foreach($row->result() as $key => $data) { ?>
         <tr>
          <td style="width:5%;"><?=$no++?></td>
          <td><?=$data->email?></td>
          <td><?=$data->nama_user?></td>
          <td><?=$data->hak_akses == 1 ? "Admin" : "Kasir"?></td>
          <td><?=$data->status_user == 1 ? "Aktif" : "Tidak Aktif"?></td>
          <td class="text-center" width="250px">
            <form action="<?=site_url('user/hapus')?>" method="post">
             <a href="<?=site_url('user/edit/'.$data->id_user)?>" class="btn btn-warning btn-xs">
              <i class="fa fa-edit""></i> Edit
            </a>
            <input type="hidden" name="id_user" value="<?=$data->id_user?>"> 
            <button onclick="return confirm('Apakah anda yakin?')" class="btn btn-danger btn-xs">
              <i class="fa fa-trash"></i> Hapus
            </button>
          </form>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</div>
</div>
</section>