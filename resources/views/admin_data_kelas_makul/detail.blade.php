@extends('layout.main')
@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
          <form action="{{ route('simpan.detail') }}" method="post">
            @csrf
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Data Kelas</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="row">
                        <div class="col-6">
                          <table class="table table-borderless">
                          <tr>
                            <td>Periode Akademik</td>
                            <td>:</td>
                            <td>{{ $kelas->akademik->tahun }} - {{ ($kelas->akademik->semester == 'gl')?'Ganjil':'Genap' }}</td>
                          </tr>
                          <tr>
                            <td>Prodi</td>
                            <td>:</td>
                            <td>{{ $kelas->prodi->nama_prodi }}</td>
                          </tr>
                          <tr>
                            <td>Kelas</td>
                            <td>:</td>
                            <td>{{ $kelas->nama_kelas }}</td>
                          </tr>
                          </table>
                        </div>
                        <div class="col-6">
                          <table class="table table-borderless">
                          <tr>
                            <td>Dosen</td>
                            <td>:</td>
                            <td>{{ $kelas->dosen->nama }}</td>
                          </tr>
                          <tr>
                            <td>Mata Kuliah</td>
                            <td>:</td>
                            <td>{{$kelas->makul->nama_makul}}</td>
                          </tr>
                          <tr>
                            <td>Total Mahasiswa</td>
                            <td>:</td>
                            <td>{{ $jmlh }}</td>
                          </tr>
                          </table>
                        </div>
                      </div>
                      <a type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah Data</a>
                      <a type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor"><i class="fa fa-file-excel"></i> Impor Data</a>
                      <table  class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th width="5%" >No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $no = 1 ?>
                        @foreach ($detail as $d )
                          <tr>
                            <td>{{ $no++}}</td>
                            <td>{{  '['.$d->mahasiswa->nim.'] '.$d->mahasiswa->nama}}</td>
                            <td>
                              <a type="button" class="btn btn-danger btn-sm" href="{{ route('hapus.detail',['id'=>$d->id]) }}"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                    <div class="card-footer">
                      <a href="{{route('kelas.admin')}}" class="btn btn-warning">Kembali</a>
                    </div>
                  </div>
                </div>
            </div>
          </form>
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
        <form action="impor.php" method="post" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <div class="row">
                <div class="col-6">
                  <p>Download Template</p>
                  <a href="template/template_kelas.xlsx" download="template_detail_kelas.xlsx" class="btn btn-success btn-sm">
               Unduh Sekarang</a>
                </div>
                <div class="col-6">
                  <p>Download Data</p>
                  <a href="../admin_data_mahasiswa/ekspor_excel.php" class="btn btn-success btn-sm">Mahasiswa</a>
                </div>
              </div>
            </div>
            <div class="form-group">
                <label for="file_excel">Pilih file Excel</label>
                <input type="hidden" name="id_kelas" value="{{ $kelas->id }}">
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
          <h4 class="modal-title">Tambah Mahasiswa</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('simpan.detail') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="id_kelas" value="{{ $kelas->id }}">
              <label for="nama">Nama</label>
              <select name="nim" class="form-control">
                @foreach ( $mahasiswa as $mhs )
                <option value="{{$mhs['nim']}}"> {{$mhs['nama']}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="simpan_detail" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endsection