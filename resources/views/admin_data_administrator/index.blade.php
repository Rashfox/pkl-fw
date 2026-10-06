@extends('layout.main')
@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Pengguna</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-default"><i class="fas fa-plus"></i> Tambah Pengguna</button>
                <table  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Peran</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; ?>
                    @foreach ($users as $u)
                    <tr>
                      <td width="5%"><?= $no++ ?></td>
                      <td><?= $u->username ?></td>
                      <td><?= $u->nama ?></td>
                      <td><?= ($u->peran=='a')? 'Admin': 'Dosen' ?></td>
                      <td>
                        <a href="{{ Route('edit.user', ['id' => $u->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ Route('hapus.user', ['id' => $u->id]) }}" class="btn btn-danger btn-sm">Hapus</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <!-- /.control-sidebar -->
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Pengguna</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ Route('tambah.user') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username">
            </div>
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama">
            </div>
            <div class="form-group">
              <label for="peran">Peran</label>
              <select class="form-control" id="peran" name="peran">
                <option value="">Pilih Peran</option>
                <option value="a">Admin</option>
                <option value="m">Mahasiswa</option>
                <option value="d">Dosen</option>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="simpan_pengguna" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
 @endsection