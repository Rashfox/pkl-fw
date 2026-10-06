<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Detail Presensi</title>
    <style>
        /* Margin dan Header/Footer persis sama seperti sebelumnya */
        @page { margin: 120px 25px 50px 25px; }
        header { position: fixed; top: -100px; left: 0px; right: 0px; height: 100px; }
        footer { position: fixed; bottom: -30px; left: 0px; right: 0px; height: 30px; text-align: center; font-size: 10px; font-style: italic; font-family: 'Times New Roman', Times, serif; }

        /* Kop Surat */
        .logo { position: absolute; left: 10px; top: 5px; width: 90px; }
        .teks-kop { text-align: center; font-family: 'Times New Roman', Times, serif; }
        .teks-kop h3 { margin: 0; font-size: 14px; font-weight: normal; }
        .teks-kop h2 { margin: 2px 0; font-size: 16px; font-weight: bold; }
        .teks-kop p { margin: 0; font-size: 12px; }
        .garis-kop-1 { border-bottom: 3px solid black; margin-top: 10px; }
        .garis-kop-2 { border-bottom: 1px solid black; margin-top: 2px; }

        body { font-family: 'Times New Roman', Times, serif; }
        .judul-laporan { text-align: center; font-weight: bold; font-size: 14px; margin-bottom: 20px; }

        /* Tabel Metadata */
        .tabel-info { width: 100%; margin-bottom: 20px; font-size: 12px; }
        .tabel-info td { padding: 3px; vertical-align: top; }

        /* Tabel Data Presensi */
        .tabel-data { width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 15px; }
        .tabel-data th, .tabel-data td { border: 1px solid black; padding: 6px; }
        .tabel-data th { font-weight: bold; text-align: center; }
        .text-center { text-align: center; }

        /* Judul per pertemuan */
        .judul-pertemuan { width: 100%; font-size: 12px; font-weight: bold; margin-bottom: 5px; }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <header>
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

    <!-- FOOTER PAGE NUMBER -->
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
        <div class="judul-laporan">LAPORAN PRESENSI DETAIL</div>

        <!-- Info Kelas -->
        <table class="tabel-info">
            <tr>
                <td style="width: 20%;">Periode Akademik</td><td style="width: 2%;">:</td><td style="width: 38%;">{{ $periode }}</td>
                <td style="width: 15%;">Mata Kuliah</td><td style="width: 2%;">:</td><td style="width: 23%;">{{ $detail->makul->nama_makul }}</td>
            </tr>
            <tr>
                <td>Prodi</td><td>:</td><td>{{ $detail->prodi->nama_prodi }}</td>
                <td>Total Pertemuan</td><td>:</td><td>{{ $total_pertemuan }}</td>
            </tr>
            <tr>
                <td>Kelas</td><td>:</td><td>{{ $detail->nama_kelas }}</td>
                <td>Persen Kontrak</td><td>:</td><td>{{ $detail->persen_hdr }}%</td>
            </tr>
            <tr>
                <td>Dosen</td><td>:</td><td colspan="4">{{ $detail->dosen->nama }}</td>
            </tr>
        </table>

        <!-- Looping Pertemuan & Tabel Presensi -->
        @php $no = 1; @endphp <!-- Inisialisasi nomor -->

        @foreach($pertemuan as $pert)
            <!-- Header Pertemuan -->
            <table class="judul-pertemuan">
                <tr>
                    <td style="width: 30%;">Pertemuan Ke {{ $pert->pertemuan_ke }}</td>
                    <td style="width: 45%;">{{ $pert->judul_pertemuan }}</td>
                    <td style="width: 25%; text-align: right;">{{ $pert->tgl_format }}</td>
                </tr>
            </table>

            <!-- Tabel Daftar Mahasiswa di Pertemuan Tersebut -->
            <table class="tabel-data">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 65%;">Mahasiswa</th>
                        <th style="width: 30%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pert->data_presensi as $mhs)
                        <tr>
                            <!-- Di script lama, $no jalan terus tanpa reset per pertemuan, ini kita replikasi -->
                            <td class="text-center">{{ $no++ }}</td>
                            <td>{{ $mhs->nim }} - {{ $mhs->mahasiswa->nama }}</td>
                            <td class="text-center">{{ ucfirst($mhs->status_pertemuan) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Data presensi belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endforeach

    </main>
</body>
</html>