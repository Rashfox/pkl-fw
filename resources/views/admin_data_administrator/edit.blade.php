@extends('layout.main')
@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Edit Data Pengguna</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ Route('update.user') }}" method="post">
                  @csrf
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukan username" value="<?= $user->username; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama" value="<?=$user->nama; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="peran">Peran</label>
                        <select class="form-control" id="peran" name="peran" disabled>
                            <option value="a" <?= ($user->peran == 'a') ? 'selected' : ''; ?>>Admin</option>
                            <option value="m" <?= ($user->peran == 'm') ? 'selected' : ''; ?>>Mahasiswa</option>
                            <option value="d" <?= ($user->peran == 'd') ? 'selected' : ''; ?>>Dosen</option>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password">
                    </div> -->
                  </div>
                  <div class="modal-footer justify-content-between">
                      <a class="btn btn-danger" href="{{Route('data.user')}}">Kembali</a>
                      <button type="submit" name="update_pengguna" class="btn btn-primary">Simpan Perubahan</button>
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
        </div>
      <!-- /.container-fluid -->
    </div>
  
@endsection