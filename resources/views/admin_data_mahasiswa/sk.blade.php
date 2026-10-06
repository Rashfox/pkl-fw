<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Mahasiswa</title>
    <style>
        /* Pengaturan Halaman */
        @page { margin: 40px 50px; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12px; line-height: 1.5; }

        /* Styling Kop Surat */
        .kop-surat { text-align: center; position: relative; margin-bottom: 20px; }
        .logo { position: absolute; left: 0; top: 0; width: 85px; }
        .kop-surat h3 { margin: 0; font-size: 14px; font-weight: normal; }
        .kop-surat h1 { margin: 0; font-size: 16px; font-weight: bold; }
        .kop-surat p { margin: 0; font-size: 12px; }
        .garis-tebal { border-bottom: 3px solid black; margin-top: 10px; }
        .garis-tipis { border-bottom: 1px solid black; margin-top: 2px; margin-bottom: 20px; }

        /* Judul Surat */
        .judul-surat { text-align: center; margin-bottom: 20px; }
        .judul-surat h2 { margin: 0; font-size: 14px; text-decoration: underline; font-weight: bold; }
        .judul-surat p { margin: 0; font-size: 12px; }

        /* Konten Isi Surat */
        .isi-surat { text-align: justify; padding: 0 15px; }
        
        /* Tabel Biodata (Tanpa Border untuk merapikan titik dua) */
        .tabel-biodata { width: 100%; margin-top: 10px; margin-bottom: 10px; border-collapse: collapse; }
        .tabel-biodata td { padding: 4px 0; vertical-align: top; }
        .td-label { width: 25%; padding-left: 20px; }
        .td-titik { width: 3%; text-align: center; }

        /* Area Tanda Tangan */
        .ttd-area { width: 250px; float: right; margin-top: 40px; text-align: center; }
        .ttd-nama { font-weight: bold; text-decoration: underline; margin-top: 70px; margin-bottom: 0; }
        .ttd-nip { margin-top: 0; }
        
        /* Clear Float */
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <img src="{{ public_path('asset_web/img/pnc.png') }}" class="logo" alt="Logo PNC">
        <h3>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</h3>
        <h1>POLITEKNIK NEGERI CILACAP</h1>
        <h1>JURUSAN {{ strtoupper($mahasiswa->jurusan ?? 'KOMPUTER DAN BISNIS') }}</h1>
        <p>Jalan Dr. Soetomo No.1, Sidakaya - Cilacap 53212, Jawa Tengah</p>
        <p>Telepon: (0282) 533329, Fax: (0282) 537992</p>
    </div>
    <div class="garis-tebal"></div>
    <div class="garis-tipis"></div>

    <!-- JUDUL SURAT -->
    <div class="judul-surat">
        <h2>SURAT KETERANGAN MAHASISWA</h2>
        <p>Nomor : {{ $nomorSurat }}</p>
    </div>

    <!-- ISI SURAT -->
    <div class="isi-surat">
        <p>Yang bertanda tangan di bawah ini Kepala Jurusan Komputer dan Bisnis Politeknik Negeri Cilacap menerangkan bahwa:</p>

        <table class="tabel-biodata">
            <tr>
                <td class="td-label">Nama</td>
                <td class="td-titik">:</td>
                <td>{{ $mahasiswa->nama }}</td>
            </tr>
            <tr>
                <td class="td-label">NIM</td>
                <td class="td-titik">:</td>
                <td>{{ $mahasiswa->nim }}</td>
            </tr>
            <tr>
                <td class="td-label">Jenis Kelamin</td>
                <td class="td-titik">:</td>
                <td>{{ $mahasiswa->kelamin == 'l' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td class="td-label">Kontak</td>
                <td class="td-titik">:</td>
                <td>{{ $mahasiswa->kontak }}</td>
            </tr>
            <tr>
                <td class="td-label">Program Studi</td>
                <td class="td-titik">:</td>
                <td>{{ $mahasiswa->namaProdi }}</td>
            </tr>
            <tr>
                <td class="td-label">Semester</td>
                <td class="td-titik">:</td>
                <td>{{ $mahasiswa->semester == 'gl' ? 'Ganjil' : 'Genap' }}</td>
            </tr>
            <tr>
                <td class="td-label">Tahun Akademik</td>
                <td class="td-titik">:</td>
                <td>{{ $mahasiswa->tahun }} / {{ $mahasiswa->tahun + 1 }}</td>
            </tr>
        </table>

        <p>Adalah benar mahasiswa Politeknik Negeri Cilacap yang tercatat dengan status <b>{{ $mahasiswa->status == '1' ? 'Aktif' : 'Tidak Aktif' }}</b>.</p>
        <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- TANDA TANGAN (Otomatis ditarik ke kanan) -->
    <div class="clearfix">
        <div class="ttd-area">
            <p>Cilacap, {{ $tanggalSurat }}<br>Kepala Jurusan,</p>
            <p class="ttd-nama">Dwi Novia Prasetyanti, S.Kom., M.Cs.</p>
            <p class="ttd-nip">NIP : 197911192021212009</p>
        </div>
    </div>

</body>
</html>