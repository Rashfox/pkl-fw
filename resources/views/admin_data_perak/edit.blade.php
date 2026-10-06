@extends('layout.main')
@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Periode Akademik</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ Route('update.perak') }}" method="post">
                  @csrf
                  <div class="modal-body">
                    <div class="form-group">
                      <label>Kode Akademik</label>
                      <input type="text" class="form-control" value="{{ $perak->kode_akd }}" name="kode_akd" placeholder="Masukkan Kode Akademik" readonly>
                    </div>
                    <div class="form-group">
                      <label>Semester</label>
                      <select name="semester" class="form-control"  required>
                        <option value="gl" {{ ($perak->semester=='gl')? 'selected' :'' }}>Ganjil</option>
                        <option value="gn" {{ ($perak->semester=='gn')? 'selected' :'' }}>Genap</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Tahun</label>
                      <input type="number" min="0" maxlength="4" class="form-control" name="tahun" placeholder="Masukkan Tahun" value="{{ $perak->tahun }}" required>
                    </div>
                    <div class="form-group">
                      <label>Status</label>
                      <select name="status" class="form-control" required>
                        <option value="1" {{ ($perak->is_active=='1')? 'selected' :'' }}>Aktif</option>
                        <option value="0" {{ ($perak->is_active=='0')? 'selected' :'' }}>Tidak Aktif</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <a href="{{ Route('perak.admin') }}" type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                    <button type="submit" name="update_perak" class="btn btn-primary">Save changes</button>
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