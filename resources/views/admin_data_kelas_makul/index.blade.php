@extends('layout.main')
@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <form action="" method="post">
          <div class="row">
            <div class="col-3">
                <div class="form-group">                    
                    <select class="form-control" name="kode_akd" id="">
                      <option value="">--Pilih Tahun Akademik--</option>
                       @foreach ($perak as $a) 
                        <option value="<?= $a->kode_akd; ?>" {{ ($a->kode_akd==$kode_akd)? 'selected':'' }}><?= $a->tahun?> - <?= ($a->semester == 'gl')? 'Ganjil' : 'Genap'?> </option>
                       @endforeach
                    </select>
                </div>
              </div>
              <div class="col-9">
                <button type="submit" name="btn_cari" class="btn btn-primary mb-2"><i class="fas fa-search"></i> Tampilkan Data</button>
              </div>
            </div>
          </form>
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Kelas Mata Kuliah</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @if (session('peran') == 'a')
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Kelas</button>
                <button href="{{ Route('impor.kelas') }}" type="button" data-toggle="modal" data-target="#modal-impor" class="btn btn-success mb-2"><i class="fa fa-file-excel"></i> Impor</button>
                @endif
                <table  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%" >No</th>
                    @if (session('peran') == 'a')
                    <th>Nama Dosen</th>
                    @endif
                    <th>Nama Kelas</th>
                    <th>Makul</th>
                    <th>Prodi</th>
                    <th>Akademik</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                  <tbody>
                    <?php $no=1; ?>
                    @foreach ($kelas as $k)
                      <tr>
                        <td>{{ $no++ }}</td>
                        @if (session('peran') == 'a')
                        <td>{{ $k->dosen->nama}}</td>
                        @endif
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->makul->nama_makul }}</td>
                        <td>{{ $k->prodi->nama_prodi }}</td>
                        <td>{{ $k->akademik->tahun }}  - {{ ($k->akademik->semester == 'gl')?'Ganjil':'Genap' }}</td>
                        <td>
                          <a href="{{ Route('detail.kelas',['id' => $k->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-info-circle"></i></a>
                          <a href="{{ Route('data.pertemuan',['kode' => $k->id]) }}" class="btn btn-dark btn-sm"><i class="fa-solid fa-list"></i></a>
                          @if (session('peran') == 'a')
                          <a href="{{ Route('edit.kelas',['id' => $k->id]) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt"></i></a>
                          <a href="{{ Route('hapus.kelas',['id' => $k->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fas fa-trash"></i></a>
                          @endif
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
   <div class="modal fade" id="modal-impor">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Impor Data Kelas</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('impor.kelas') }}" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <div class="row">
                <div class="col-4">
                  <p>Download Template</p>
                  <a href="{{ asset('template/template_kelas.xlsx') }}" download="template_kelas.xlsx" class="btn btn-success btn-sm">
               Unduh Sekarang</a>
                </div>
                <div class="col-8">
                  <p>Download Data</p>
                  <a href="{{ route('expor.mahasiswa') }}" class="btn btn-success btn-sm">Mahasiswa</a>
                  <a href="{{ route('expor.dosen') }}" class="btn btn-success btn-sm">Dosen</a>
                  <a href="{{ route('expor.prodi') }}" class="btn btn-success btn-sm">Prodi</a>
                  <a href="{{ route('expor.perak') }}" class="btn btn-success btn-sm">Perak</a>
                  <a href="{{ route('expor.makul') }}" class="btn btn-success btn-sm">Matkul</a>
                </div>
              </div>
            </div>
            <div class="form-group">
                <label for="file_excel">Pilih file Excel</label>
                <input type="file" class="form-control" name="file_excel" id="file_excel" required accept=".xls, .xlsx">
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="btn_impor" class="btn btn-primary">Impor</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Mata Kuliah</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ Route('simpan.kelas') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label>Nama Kelas</label>
              <input type="text" class="form-control" name="nama_kelas" placeholder="Masukkan Nama Kelas" required>
            </div>
            <div class="form-group">
              <label>Perode Akademik</label>
              <select name="kode_akd" class="form-control" required>
                @foreach ($perak as $p)
                  <option value="{{ $p->kode_akd }}">{{ $p->tahun }} - {{ ($p->semester=='gl')?'Ganjil':'Genap' }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Mata Kuliah</label>
              <select name="kode_makul" class="form-control" required>
                @foreach ($makul as $m)
                  <option value="{{ $m->kode_makul }}">{{ $m->nama_makul }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Prodi</label>
              <select name="kode_prodi" class="form-control" required>
                @foreach ($prodi as $p)
                  <option value="{{ $p->kode_prodi }}">{{ $p->nama_prodi }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Dosen</label>
              <select name="kode_dosen" class="form-control" required>
                @foreach ($dosen as $d)
                  <option value="{{ $d->nik }}">{{ $d->nama }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="simpan_kelas" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- Control Sidebar -->
@endsection