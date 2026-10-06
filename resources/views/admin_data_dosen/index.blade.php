@extends('layout.main')
@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Dosen</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Dosen</button>
                <a type="button" href="{{ route('reset.dosen') }}" class="btn btn-danger mb-2"><i class="fa fa-exclamation-triangle"></i> Reset</a>
                <a type="button" href="{{ asset('template/template_dosen.xlsx') }}" download="template_dosen.xlsx" class="btn btn-danger mb-2"><i class="fa fa-download"></i> Template</a>
                <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modal-impor"><i class="fas fa-file-excel"></i> Impor</button>
                <a type="button" class="btn btn-danger mb-2" href="{{ route('pdf.dosen') }}"><i class="fas fa-file-pdf"></i> Ekspor</a>
                <!-- <a type="button" class="btn btn-success mb-2" href="{{ route('expor.dosen') }}"><i class="fas fa-file-excel"></i> Ekspor</a> -->
                <table  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%" >No</th>
                    <th>nik</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Email</th>
                    <th>Kelamin</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                  <tbody>
                    <?php $no=1; ?>
                    @foreach ($dosen as $d)
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $d->nik ?></td>
                        <td><?= $d->nama ?></td>
                        <td><?= $d->kontak ?></td>
                        <td><?= $d->email ?></td>
                        <td>
                          <?php
                          if ($d->kelamin == 'l'){
                            echo 'Laki-laki';
                          } else{
                            echo 'Perempuan';
                          }
                          ?>
                        </td>
                        <td>
                          @if ($d->kelamin == 'l')
                            <button type="button" class="btn" data-nik="<?= $d->nik?>" data-toggle="modal" data-target="#modal-foto"><img width="40" src="<?= (!empty($d['img']))? asset($d['img']) : asset('asset_web/img/dosen/co_default.png');?>"></button>
                          
                            @else
                            <button type="button" class="btn" data-nik="<?= $d->nik?>" data-toggle="modal" data-target="#modal-foto"><img width="40" src="<?= (!empty($d['img']))? asset($d['img']) : asset('asset_web/img/dosen/ce_default.png');?>"></button>
                          @endif
                        </td>
                        <td>
                          <a href="{{ Route('edit.dosen', ['nik' => $d->nik]) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt"></i></a>
                          <a href="{{ Route('hapus.dosen', ['nik' =>$d->nik]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fas fa-trash"></i></a>
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
  <!-- /.content-wrapper -->
  <div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Dosen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ Route('simpan.dosen') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="nik">NIK</label>
              <input type="number" min="0" maxlength="10" class="form-control" id="nik" name="nik" placeholder="Masukkan Nik" required>
            </div>
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
            </div>
            <div class="form-group">
              <label for="kontak">Kontak</label>
              <input type="number" min="0" maxlength="13" class="form-control" id="kontak" name="kontak" placeholder="Masukkan Kontak" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" maxlength="100" id="email" name="email" placeholder="Masukkan Email" required>
            </div>
            <div class="form-group">
              <label for="kelamin">Kelamin</label>
              <select class="form-control" id="kelamin" name="kelamin" required>
                <option value="l">Laki-laki</option>
                <option value="p">Perempuan</option>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="simpan_dosen" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modal-foto">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Foto Dosen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('foto.dosen') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
              <input type="hidden" name="nik">
            <div class="form-group">
                <label>Pilih Foto</label>
                <input type="file" class="form-control" name="foto" required accept=".jpg,.jpeg,.webp,.png">
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="btn_foto" class="btn btn-primary">Upload</button>
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
          <h4 class="modal-title">Impor Data Dosen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('impor.dosen') }}" method="post" enctype="multipart/form-data">
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
@endsection
@push('script')
 @if (session('error'))
    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000
            });
            
            Toast.fire({
                icon: 'error',
                // title mengambil isi dari session 'error'
                title: '{{ session("error") }}' 
            });
        });
    </script>
@endif
<script>
  $('#modal-foto').on('show.bs.modal', function(d){
    let nik = $(d.relatedTarget).data('nik');

    $(d.currentTarget).find('input[name="nik"]').val(nik);
  })
</script>
@endpush