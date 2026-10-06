<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mata Kuliah</title>
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
            font-family: Arial, sans-serif;
        }

        .logo {
            position: absolute;
            left: 10px;
            top: 5px;
            width: 75px; 
        }
        .teks-kop {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .teks-kop h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .teks-kop p {
            margin: 2px 0 0 0;
            font-size: 11px;
        }
        .garis-kop {
            border-bottom: 2px solid black;
            margin-top: 15px;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
        }
        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 6px;
            font-size: 12px;
        }
        th {
            font-weight: bold;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('asset_web/img/pnc.png') }}" class="logo" alt="Logo">
        
        <div class="teks-kop">
            <h2>Jurusan Komputer dan Bisnis</h2>
            <h2>Teknik Informatika</h2>
            <p>Alamat: Jl. Dr. Soetomo No.1, Sidakaya, Kecamatan Cilacap Selatan,</p>
            <p>Kabupaten Cilacap, Provinsi Jawa Tengah, 53212</p>
        </div>
        <div class="garis-kop"></div>
    </header>

    
    <footer>
        <script type="text/php">
            if (isset($pdf)) {
                $text = "Page {PAGE_NUM}/{PAGE_COUNT}";
                $size = 8;
                $font = $fontMetrics->getFont("Arial");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width) / 2;
                $y = $pdf->get_height() - 25;
                $pdf->page_text($x, $y, $text, $font, $size);
            }
        </script>
    </footer>

    <!-- KONTEN TABEL -->
    <main>
        <div class="judul">Data Mata Kuliah</div>

        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Kode Matkul</th>
                    <th style="width: 40%;">Nama Matkul</th>
                    <th style="width: 20%;">Jumlah SKS</th>
                    <th style="width: 20%;">Jumlah CPMK</th>
                </tr>
            </thead>
            <tbody>
                @forelse($makul as $index => $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $data->kode_makul }}</td>
                        <td>{{ $data->nama_makul }}</td>
                        <td class="text-center">{{ $data->jml_sks }}</td>
                        <td class="text-center">{{ $data->jml_cpmk }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Data mata kuliah belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>

</body>
</html>