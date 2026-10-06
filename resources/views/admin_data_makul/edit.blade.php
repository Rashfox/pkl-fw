@extends('layout.main')
@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Mata Kuliah</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ Route('update.makul') }}" method="post">
                  @csrf
                  <div class="modal-body">
                    <div class="form-group">
                      <label>Kode Mata Kuliah</label>
                      <input type="text" class="form-control" value="{{ $makul->kode_makul }}" name="kode_makul" placeholder="Masukkan Kode Makul" readonly>
                    </div>
                    <div class="form-group">
                      <label>Nama Mata Kuliah</label>
                      <input type="text" class="form-control" value="{{ $makul->nama_makul }}" name="nama_makul" placeholder="Masukkan Nama Makul" required>
                    </div>
                    <div class="form-group">
                      <label>Jumlah SKS</label>
                      <input type="number" min="0" maxlength="4" class="form-control" name="jml_sks" placeholder="Masukkan Jumlah SKS" value="{{ $makul->jml_sks }}" required>
                    </div>
                    <div class="form-group">
                      <label>Jumlah CPMK</label>
                      <input type="number" min="0" maxlength="4" class="form-control" name="jml_cpmk" placeholder="Masukkan Jumlah CPMK" value="{{ $makul->jml_cpmk }}" required>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <a href="{{ Route('makul.admin') }}" type="button" class="btn btn-default" data-dismiss="modal">Close</a>
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