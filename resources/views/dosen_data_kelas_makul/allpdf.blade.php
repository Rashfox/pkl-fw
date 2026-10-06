<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Presensi</title>
    <style>
        @page {
            margin: 120px 25px 50px 25px; 
        }

        header {
            position: fixed;
            top: -100px;
            left: 0px;
            right: 0px;
            height: 100px;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 30px;
            text-align: center;
            font-size: 10px;
            font-style: italic;
            font-family: 'Times New Roman', Times, serif;
        }

        /* Kop Surat */
        .logo {
            position: absolute;
            left: 10px;
            top: 5px;
            width: 90px; 
        }
        .teks-kop {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
        }
        .teks-kop h3 {
            margin: 0;
            font-size: 14px;
            font-weight: normal;
        }
        .teks-kop h2 {
            margin: 2px 0;
            font-size: 16px;
            font-weight: bold;
        }
        .teks-kop p {
            margin: 0;
            font-size: 12px;
        }
        
        /* Dua garis kop surat */
        .garis-kop-1 {
            border-bottom: 3px solid black;
            margin-top: 10px;
        }
        .garis-kop-2 {
            border-bottom: 1px solid black;
            margin-top: 2px;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
        }

        .judul-laporan {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
        }

        /* Tabel Metadata Info Kelas (Tanpa Border) */
        .tabel-info {
            width: 100%;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .tabel-info td {
            padding: 3px;
            vertical-align: top;
        }

        /* Tabel Data Presensi */
        .tabel-data {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .tabel-data th, .tabel-data td {
            border: 1px solid black;
            padding: 6px;
        }
        .tabel-data th {
            font-weight: bold;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <header>
        <!-- Pastikan file logo ada di public/asset_web/img/logopnc.png -->
        <img src="{{ public_path('asset_web/img/logopnc.png') }}" class="logo" alt="Logo PNC">
        
        <div class="teks-kop">
            <h3>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</h3>
            <h2>POLITEKNIK NEGERI CILACAP</h2>
            <p>Jalan Dr. Soetomo No.1, Sidakaya - Cilacap 53212, Jawa Tengah</p>
            <p>Telepon: (0282) 533329, Fax: (0282) 537992</p>
        </div>
        <div class="garis-kop-1"></div>
        <div class="garis-kop-2"></div>
    </header>

    <!-- NOMOR HALAMAN -->
    <footer>
        <script type="text/php">
            if (isset($pdf)) {
                $text = "Page {PAGE_NUM}/{PAGE_COUNT}";
                $size = 10;
                $font = $fontMetrics->getFont("Times");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width) / 2;
                $y = $pdf->get_height() - 25;
                $pdf->page_text($x, $y, $text, $font, $size);
            }
        </script>
    </footer>

    <!-- ISI LAPORAN -->
    <main>
        <div class="judul-laporan">LAPORAN PRESENSI</div>

        <!-- Info Kelas -->
        <table class="tabel-info">
            <tr>
                <td style="width: 20%;">Periode Akademik</td>
                <td style="width: 2%;">:</td>
                <td style="width: 38%;">{{ $detail->tahun }} - {{ ($detail->semeser =='gl')? 'Ganjil' : 'Genap' }}</td>
                
                <td style="width: 15%;">Mata Kuliah</td>
                <td style="width: 2%;">:</td>
                <td style="width: 23%;">{{ $detail->nama_makul }}</td>
            </tr>
            <tr>
                <td>Prodi</td>
                <td>:</td>
                <td>{{ $detail->nama_prodi }}</td>
                
                <td>Total Pertemuan</td>
                <td>:</td>
                <td>{{ $total_pertemuan }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $detail->nama_kelas }}</td>
                
                <td>Persen Kontrak</td>
                <td>:</td>
                <td>{{ $detail->persen_hdr }}%</td>
            </tr>
            <tr>
                <td>Dosen</td>
                <td>:</td>
                <td colspan="4">{{ $detail->nama_dosen }}</td>
            </tr>
        </table>

        <!-- Tabel Data Mahasiswa & Kehadiran -->
        <table class="tabel-data">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 45%;">Mahasiswa</th>
                    <th style="width: 16%;">Jml Kehadiran</th>
                    <th style="width: 17%;">Kehadiran</th>
                    <th style="width: 17%;">Kontrak</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mahasiswa as $mhs)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $mhs->nim }} - {{ $mhs->nama }}</td>
                        <td class="text-center">{{ $mhs->total_hadir }}</td>
                        <td class="text-center">{{ $mhs->persentase_hadir }}%</td>
                        <td class="text-center">{{ $mhs->persentase_kontrak }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

</body>
</html>