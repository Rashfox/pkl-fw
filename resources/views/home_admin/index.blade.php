@extends('layout.main')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Keaktifan Mahasiswa Tahun {{ date('Y') }}</h3>

                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                        <div id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $jml_mhs }}</h3>
                        
                        <p>Total Mahasiswa</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                    <a href="{{ route('data.mahasiswa') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $jml_dosen }}</h3>
                        
                        <p>Total Dosen</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <a href="{{ route('data.dosen') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $jml_prodi }}</h3>
                        
                        <p>Total Prodi</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-university"></i>
                    </div>
                    <a href="{{ route('prodi.admin') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
$(function() {
    function getSize(elementId) {
      return {
        width: document.getElementById(elementId).offsetWidth,
        height: document.getElementById(elementId).offsetHeight,
      }
    }
    const bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    let data = [
      [1, 2, 3, 4, 5, 6, 7,8,9,10,11,12],
      @json($data_hadir),
    ];
    
    const optsLineChart = {
      ... getSize('lineChart'),
      scales: {
        x: {
          time: false,
        },
        y: {
          range: [0, {{ max($data_hadir)+5 }}],
        },
      },
      axes: [
        {
            values: (u, vals) => vals.map(v=>bulan[v] || "")
        },
        {}
      ],
      cursor: {
        drag: {
          x: false,
          y: false
        }
      },
      series: [
        {
          label: 'Bulan'
        },
        {
          label: 'Total Kehadiran',
          fill: 'transparent',
          width: 5,
          stroke: 'rgba(60,141,188,1)',
        },
      ],
    };

    let lineChart = new uPlot(optsLineChart, data, document.getElementById('lineChart'));
})
</script>
@endpush