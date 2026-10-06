@extends('layout.main')
@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
          <form action="" method="post">
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
                            <td>{{ ($kelas->akademik->semester=='gl')? $kelas->akademik->tahun.' - Ganjil': $kelas->akademik->tahun. ' - Genap' }}</td>
                          </tr>
                          <tr>
                            <td>Prodi</td>
                            <td>:</td>
                            <td>{{ $kelas->prodi->nama_prodi}}</td>
                          </tr>
                          <tr>
                            <td>Kelas</td>
                            <td>:</td>
                            <td>{{ $kelas->nama_kelas}}</td>
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
                            <td>{{ $kelas->makul->nama_makul }}</td>
                          </tr>
                          <tr>
                            <td>Presentase Kontrak</td>
                            <td>:</td>
                            <td>{{ $kelas->persen_hdr }}%</td>
                          </tr>
                          </table>
                        </div>
                      </div>
                      <a type="button" class="btn btn-primary mb-2" data-id="<?= $kelas->id?>" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah Pertemuan</a>
                      <a href="{{ route('pdf.pertemuan', ['id' => $kelas->id]) }}" target="_blank" type="button" class="btn btn-danger mb-2"><i class="fa fa-file-pdf"></i> Ekspor PDF</a>
                      <a href="{{ route('detail.pdf.pertemuan', ['id' => $kelas->id]) }}" target="_blank" type="button" class="btn btn-danger mb-2"><i class="fa fa-file-pdf"></i> Ekspor Pertemuan</a>
                      <a type="button" class="btn btn-warning mb-2" data-id="<?= $kelas->id?>" data-toggle="modal" data-target="#modal-persen"><i class="fa fa-pencil"></i> Ubah Presentase</a>
                      <table  class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th width="5%" >No</th>
                            <th>Pertemuan Ke</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no=1;
                          ?>
                          @foreach ($pertemuan as $p)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $p->pertemuan_ke }}</td>
                            <td>{{ $p->judul_pertemuan }}</td>
                            <td>{{ date('d F Y', strtotime($p->tgl_pertemuan)) }}</td>
                            <td>
                              <a type="button" class="btn btn-dark btn-sm" href="{{ route('data.presensi', ['id' => $p->id_pertemuan]) }}"><i class="fa fa-qrcode"></i></a>
                              <a type="button" onclick="return confirm('apakah anda yakin?');" class="btn btn-danger btn-sm" href="{{ route('hapus.pertemuan', ['id' => $p->id_pertemuan]) }}"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    <div class="card-footer">
                      <a href="{{ route('kelas.admin') }}" class="btn btn-warning">Kembali</a>
                    </div>
                  </div>
                </div>
            </div>
          </form>
        </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Pertemuan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('simpan.pertemuan') }}" method="post">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="kode_kelas">
            <div class="form-group">
              <label>Judul Pertemuan</label>
              <input type="text" class="form-control" name="judul_pertemuan" placeholder="Masukkan judul pertemuan">
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="simpan_pertemuan" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div class="modal fade" id="modal-persen">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ubah Presentase Kontrak</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('persen.kelas') }}" method="post">
          <div class="modal-body">
            <input type="hidden" name="kode_kelas" value="{{ $kelas->id }}">
            <div class="form-group">
              <label>Presentase Kontrak</label>
              <input type="number" min="0" max="40" class="form-control" name="persen_hdr" placeholder="Masukkan Presentase Kontrak" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="ubah_persen" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endsection
@push('scripts')
<script>
    $('#modal-tambah').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var id = button.data('id')
      var modal = $(this)
      modal.find('.modal-body input[name="kode_kelas"]').val(id)
    })
</script>
@endpush