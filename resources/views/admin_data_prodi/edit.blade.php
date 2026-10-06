@extends('layout.main')
@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Prodi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ Route('update.prodi') }}" method="post">
                  @csrf
                  <div class="modal-body">
                    <div class="form-group">
                      <label>Kode Prodi</label>
                      <input type="text" class="form-control" value="{{ $prodi->kode_prodi }}" name="kode_prodi" placeholder="Masukkan Kode Prodi" readonly>
                    </div>
                    <div class="form-group">
                      <label>Nama Prodi</label>
                      <input type="text" class="form-control" value="{{ $prodi->nama_prodi }}" name="nama_prodi" placeholder="Masukkan Nama Prodi">
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <a href="{{ Route('prodi.admin') }}" type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                    <button type="submit" name="update_makul" class="btn btn-primary">Save changes</button>
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