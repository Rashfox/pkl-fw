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
                        <option value="<?= $a->kode_akd; ?>" {{ ($a->kode_akd==$kode_akd)?'selected':'' }}><?= $a->tahun?> - <?= ($a->semester == 'gl')? 'Ganjil' : 'Genap'?> </option>
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
                <h3 class="card-title">Data Kelas</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="5%" >No</th>
                    <th>Kelas</th>
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
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->makul->nama_makul }}</td>
                        <td>{{ $k->prodi->nama_prodi }}</td>
                        <td>{{ $k->akademik->tahun }}  - {{ ($k->akademik->semester == 'gl')?'Ganjil':'Genap' }}</td>
                        <td>
                          <a href="{{ Route('detail.kelas',['id' => $k->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-info-circle"></i></a>
                          <a href="{{ Route('data.pertemuan',['kode' => $k->id]) }}" class="btn btn-dark btn-sm"><i class="fa-solid fa-list"></i></a>
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
@endsection