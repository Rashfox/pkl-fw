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
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Prodi</button>
                <a href="{{ Route('reset.prodi') }}" type="button" class="btn btn-danger mb-2"><i class="fa fa-exclamation-triangle"></i> Reset</a>
                <a href="{{ asset('template/template_prodi.xlsx') }}" download="template_prodi.xlsx" class="btn btn-danger mb-2"><i class="fa fa-download"></i> Template</a>
                <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor"><i class="fas fa-file-excel"></i> Impor</button>
                <table  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%" >No</th>
                    <th>Kode Prodi</th>
                    <th>Nama Prodi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                  <tbody>
                    <?php $no=1; ?>
                    @foreach ($prodi as $p)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $p->kode_prodi }}</td>
                        <td>{{ $p->nama_prodi }}</td>
                        <td>
                          <a href="{{ Route('edit.prodi',['kode' => $p->kode_prodi]) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt"></i></a>
                          <a href="{{ Route('hapus.prodi',['kode' => $p->kode_prodi]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fas fa-trash"></i></a>
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
  
  <div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Prodi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ Route('simpan.prodi') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label>Kode Prodi</label>
              <input type="text" class="form-control" name="kode_prodi" placeholder="Masukkan Kode Prodi" required>
            </div>
            <div class="form-group">
              <label>nama Prodi</label>
              <input type="text" class="form-control" name="nama_prodi" placeholder="Masukkan Nama Prodi" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="simpan_prodi" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modal-impor">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Impor Data Prodi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('impor.prodi') }}" method="post" enctype="multipart/form-data">
        @csrf  
        <div class="modal-body">
            <p class="text-red b">Download template Excel dulu di tombol Template</p>
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
@endsection