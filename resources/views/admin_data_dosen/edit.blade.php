@extends('layout.main')
@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Edit Data Dosen</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ Route('update.dosen') }}" method="post">
                  @csrf
                  <div class="modal-body">
                    <input type="hidden" name="nik" value="<?= $dosen->nik; ?>">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama" value="<?= $dosen->nama; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kontak">kontak</label>
                        <input type="number" min="0" maxlength="13" class="form-control" id="kontak" name="kontak" placeholder="Masukan kontak" value="<?= $dosen->kontak; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" maxlength="100" id="email" name="email" placeholder="Masukan Email" value="<?= $dosen->email; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kelamin">Kelamin</label>
                        <select class="form-control" id="kelamin" name="kelamin" required>
                            <option value="l" <?= ($dosen->kelamin == 'l') ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="p" <?= ($dosen->kelamin == 'p') ? 'selected' : ''; ?>>perempuan</option>
                        </select>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <a class="btn btn-danger" href="{{ Route('data.dosen') }}">Kembali</a>
                      <button type="submit" name="update_dosen" class="btn btn-primary">Simpan Perubahan</button>
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
        </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection