@extends('layout.main')
@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Kelas Matkul</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ Route('update.kelas') }}" method="post">
                  @csrf
                  <div class="modal-body">
                    <div class="form-group">
                      <input type="hidden" name="id" value="{{ $kelas->id }}">
                      <label>Nama Kelas</label>
                      <input type="text" class="form-control" name="nama_kelas" placeholder="Masukkan Nama Kelas" required value="{{ $kelas->nama_kelas }}">
                    </div>
                    <div class="form-group">
                      <label>Perode Akademik</label>
                      <select name="kode_akd" class="form-control" required>
                        @foreach ($perak as $p)
                          <option value="{{ $p->kode_akd }}" {{ ($p->kode_akd==$kelas->kode_akd)? "selected":"" }}>{{ $p->tahun }} - {{ ($p->semester=='gl')?'Ganjil':'Genap' }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Mata Kuliah</label>
                      <select name="kode_makul" class="form-control" required>
                        @foreach ($makul as $m)
                          <option value="{{ $m->kode_makul }}" {{ ($m->kode_makul==$kelas->kode_makul)?"selected": "" }}>{{ $m->nama_makul }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Prodi</label>
                      <select name="kode_prodi" class="form-control" required>
                        @foreach ($prodi as $p)
                          <option value="{{ $p->kode_prodi }}" {{ ($p->kode_prodi==$kelas->kode_prodi)?"selected":"" }}>{{ $p->nama_prodi }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Dosen</label>
                      <select name="kode_dosen" class="form-control" required>
                        @foreach ($dosen as $d)
                          <option value="{{ $d->nik }}" {{ ($d->nik==$kelas->kode_dosen)?"selected":"" }}>{{ $d->nama }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <a href="{{ Route('kelas.admin') }}" type="button" class="btn btn-default" data-dismiss="modal">Close</a>
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