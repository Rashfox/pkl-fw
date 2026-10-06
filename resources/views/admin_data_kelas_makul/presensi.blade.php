@extends('layout.main')
@section('content')
    <div class="content">
      <div class="container-fluid">
        <a type="button" href="{{ route('data.pertemuan', ['kode' => $pertemuan->kode_kelas]) }}" class=" btn btn-warning btn-md mb-2"><i class="fa fa-arrow-left"></i> Kembali</a>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Kelas Mata Kuliah - {{ $pertemuan->kelasMakul->nama_kelas }}</h3>
              </div>
              <div class="card-body">
                <div class="row">
                <div class="col-3">
                  @if ($pertemuan->kelasMakul->dosen->kelamin == 'l')
                  <img class="img-fluid" src="<?= (!empty($pertemuan->kelasMakul->dosen->img))? asset($pertemuan->dosen->img) : asset('asset_web/img/dosen/co_default.png');?>">
                  @else
                  <img class="img-fluid" src="<?= (!empty($pertemuan->kelasMakul->dosen->img))? asset($pertemuan->kelasMakul->dosen->img) : asset('asset_web/img/dosen/ce_default.png');?>">
                  @endif
                  <?php
                  if ($pertemuan->status_pertemuan == 0){
                    $teks = 'Buka Presensi';
                    $btnClass = 'btn-success';
                    $fa = 'fa fa-lock-open';
                    $value= '1';
                    $name='aktifkan';
                  } else {
                    $teks = 'Tutup Presensi';
                    $btnClass = 'btn-danger';
                    $fa = 'fa fa-lock';
                    $value = '0';
                    $name='nonaktifkan';
                  }
                  ?>
                <form id="form" action="{{ route('status.presensi', ['id'=>$pertemuan->id_pertemuan]) }}" method="post">
                  @csrf
                  <input type="hidden" name="status" value="{{ $value }}">
                  <button id="kirim" type="submit" onclick="return confirm('apakah anda yakin <?= $teks ?>?')" name="{{ $name }}" class="btn <?= $btnClass ?> btn-block btn-sm mb-2"><i class="<?= $fa ?>"></i> <?= $teks ?></button>
                </form>
                <h3 id="status"></h3>
                <script>
                var data_set = document.getElementById("kirim").getAttribute("name");
                document.getElementById("kirim").addEventListener("click", function() {
                    localStorage.removeItem("countdown_" + <?= $pertemuan->id_pertemuan ?>);
                });
                if (data_set == "nonaktifkan"){
                  var localKey = "countdown_" + <?= $pertemuan->id_pertemuan ?>;
                  var countDownDate = localStorage.getItem(localKey);
                  if (!countDownDate){
                    countDownDate = new Date().getTime() + 5*60*1000; 
                    localStorage.setItem(localKey, countDownDate);
                  }
                  else {
                    countDownDate = parseInt(countDownDate);
                  }
                  timer = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = countDownDate - now;
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    document.getElementById("status").innerHTML = minutes + " menit " + seconds + " detik";
                    if (distance < 0) {
                      clearInterval(timer);
                      $(document).ready(function() {
                        $("#kirim").removeAttr("onclick");
                        $("#kirim").click();
                        $("#status").text("Waktu Presensi Habis");
                    });
                      localStorage.removeItem(localKey);
                    }
                  }, 1000);
                }
                </script>
                </div>
                <div class="col-6">
                  <table class="w-100">
                    <tr>
                        <th>NIK</th>
                        <td>:</td>
                        <td>{{ $pertemuan->kelasMakul->dosen->nik }}</td>
                    </tr>
                    <tr>
                        <th>Nama Dosen</th>
                        <td>:</td>
                        <td>{{ $pertemuan->kelasMakul->dosen->nama }}</td>
                    </tr>
                    <tr>
                        <th>Mata Kuliah</th>
                        <td>:</td>
                        <td>{{ $pertemuan->kelasMakul->makul->nama_makul }}</td>
                      </tr>
                      <tr>
                        <th>Kelas</th>
                        <td>:</td>
                        <td>{{ $pertemuan->kelasMakul->nama_kelas }}</td>
                      </tr>
                      <tr>
                        <th>Prodi</th>
                        <td>:</td>
                        <td>{{ $pertemuan->kelasMakul->prodi->nama_prodi }}</td>
                      </tr>
                      <tr>
                        <th>Hari</th>
                        <td>:</td>
                        <td><?php 
                        $hari_inggris = date('D');
                        $hari_indonesia = [
                          'Sun' => 'Minggu',
                          'Mon' => 'Senin',
                            'Tue' => 'Selasa',
                            'Wed' => 'Rabu',
                            'Thu' => 'Kamis',
                            'Fri' => 'Jumat',
                            'Sat' => 'Sabtu'
                        ];
                        echo $hari_indonesia[$hari_inggris] ?? $hari_inggris;
                        ?></td>
                    </tr>
                    <tr>
                      <th>Tanggal</th>
                      <td>:</td>
                      <td><?= date('d F Y');?></td>
                    </tr>
                    <tr>
                        <th>Pertemuan Ke</th>
                        <td>:</td>
                        <td>{{ $pertemuan->pertemuan_ke }}</td>
                    </tr>
                  </table>
                </div>
                <div class="col-3">
                  <img src="{{ $qr }}" alt="QR Code Kelas" class="img-fluid border mb-1">
                    <p>Scan QR untuk melakukan presensi</p>
                </div>     
            </div>
            <hr>
            <div class="row">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-absensi">

                    </tbody>
                  </table>
                </div>
                <script>
                 async function loadTable() {
                    try {
                        const url = "{{ route('tabel.presensi', ['id' => $pertemuan->id_pertemuan]) }}";
                        const response = await fetch(url, {
                            method: 'GET',
                            cache: 'no-store'
                        });
                        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                        const html = await response.text();
                        document.getElementById('tabel-absensi').innerHTML = html;

                    } catch (error) {
                        console.error('Gagal memuat tabel:', error);
                    }
                  }
                  loadTable();
                  setInterval(loadTable, 5000);
                </script>
            </div>
        </div>
            </div>
        <!-- /.content -->
      </div>
    </div>
   <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('ubah.status.presensi') }}" method="post">
        @csrf  
        <div class="modal-body">
              <input type="hidden" name="id_presensi">
            <div class="form-group">
                <label>Status Pertemuan</label>
                <select name="status_pertemuan" class="form-control">
                  <option value="hadir">Hadir</option>
                  <option value="alpha">Alpha</option>
                  <option value="sakit">Sakit</option>
                  <option value="izin">Izin</option>
                </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="ubah_status" class="btn btn-primary">Ubah</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@include('script')
<script>
$(document).ready(function() {
  $('#modal-edit').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
      
    var id = button.data('id');
    var nama = button.data('nama');
    
    var modal = $(this);
    modal.find('input[name="id_presensi"]').val(id);
    modal.find('h4.modal-title').text('Edit Status Pertemuan - ' + nama);
  });
});
  var data_set = document.getElementById("kirim").getAttribute("name");
  if (data_set == 'nonaktifkan'){
    setTimeout(function(){
        window.location.reload(1);
        const url = "{{ route('data.presensi.dosen', ['id' => $pertemuan->id_pertemuan]) }}";
        const response = fetch(url, {
            method: 'GET',
            cache: 'no-store'
        });
    }, 60000);
  }
</script>
@endsection