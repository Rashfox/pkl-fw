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
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Periode</button>
                <a href="{{ Route('reset.perak') }}" type="button" class="btn btn-danger mb-2"><i class="fa fa-exclamation-triangle"></i> Reset</a>
                <table  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%" >No</th>
                    <th>Kode Akademik</th>
                    <th>Semester</th>
                    <th>tahun</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                  <tbody>
                    <?php $no=1; ?>
                    @foreach ($perak as $p)
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $p->kode_akd ?></td>
                        <td><?= ($p->semester == 'gl')? 'Ganjil' : 'Genap' ?></td>
                        <td><?= $p->tahun ?></td>
                        <td><?= ($p->is_active == '1')? 'Aktif' : 'Tidak Aktif' ?></td>
                        
                        <td>
                          <a href="{{ Route('edit.perak',['kode' => $p->kode_akd]) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt"></i></a>
                          <a href="{{ Route('hapus.perak',['kode' => $p->kode_akd]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fas fa-trash"></i></a>
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
          <h4 class="modal-title">Tambah Data Periode Akademik</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ Route('simpan.perak') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label>Kode Akademik</label>
              <input type="text" class="form-control" name="kode_akd" placeholder="Masukkan Kode Akademik" required>
            </div>
            <div class="form-group">
              <label>Semester</label>
              <select name="semester" class="form-control" required>
                <option value="gl">Ganjil</option>
                <option value="gn">Genap</option>
              </select>
            </div>
            <div class="form-group">
              <label>Tahun</label>
              <input type="number" min="0" maxlength="4" class="form-control" name="tahun" placeholder="Masukkan Tahun" required>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control" required>
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="simpan_perak" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endsection