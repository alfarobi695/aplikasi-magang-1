<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Print Laporan Magang PN {{ strtoupper($namabulan[$bulan])  }} {{ $tahun }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <style>
        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            font-weight: bold;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelpresensi tr th {
            border: 1px solid #0a0a0a;
            padding: 8px;
            background-color: #dbdbdb;
            font-size: 12px;
        }

        .tabelpresensi tr td {
            border: 1px solid #131212;
            padding: 5px;
            font-size: 12px;
        }

        .foto {
            width: 40px;
            height: 30px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .header-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #000;
        }

        .header-wrapper img {
            width: 80px;
            margin-right: 20px;
        }

        .header {
            text-align: center;
        }

        .header h1 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
            margin: 0;
        }

        .header p {
            font-size: 11px;
            margin: 0;
        }

        .content {
            padding: 0 50px;
        }

        .content .student-info {
            font-size: 14px;
            text-align: center;
            margin: 0;
        }

        .content .student-info p {
            font-weight: bold;
            margin: 0;
        }
    </style>

    <script>
        // JavaScript to trigger print dialog automatically
        window.onload = function () {
            window.print();
        };
    </script>
</head>

<body>
    <section class="sheet padding-10mm">
        <div class="header-wrapper">
            <img src="{{ asset('assets/logo.jpeg') }}" style="margin-right: 45px;margin-left: 40px" alt="Logo">
            <div class="header">
                <h1>MAHKAMAH AGUNG REPUBLIK INDONESIA</h1>
                <h1>DIREKTORAT JENDERAL BADAN PERADILAN UMUM</h1>
                <h1>PENGADILAN TINGGI SURABAYA</h1>
                <h1>PENGADILAN NEGERI MALANG</h1>
                <p>Jln. Jend. A. Yani Utara No.198 RT 001 RW 008 Kel. Purwodadi, Kec Blimbing,</p>
                <p>Kota Malang, Jawa Timur 65126 Telp. (0341) 491254, Fax. (0341) 495171</p>
                <p>Website: www.pn-malang.go.id | Email: pn.malang198@gmail.com</p>
            </div>
        </div>

        <div class="content">
            <div class="student-info">
                <p>MONITORING KEGIATAN MAHASISWA MAGANG PERIODE {{ strtoupper($namabulan[$bulan])  }} {{ $tahun }}</p>
                <br />
                <p style="text-transform:uppercase">{{ $mahasiswa->perguruan_tinggi }}</p>
                <p style="text-transform:uppercase">JURUSAN {{ $mahasiswa->jurusan }}</p>
                <p style="text-transform:uppercase">PROGRAM STUDI {{ $mahasiswa->program_studi }}</p>
                <br>
                <p style="text-transform:uppercase">NAMA : {{ $mahasiswa->nama_lengkap }}</p>
                <p>NIM : {{ $mahasiswa->nim }}</p>
                <br>
                <p style="text-transform:uppercase">Ruang : {{ $mahasiswa->nama_dept }}</p>
            </div>
        </div>
        <table class="tabelpresensi">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Foto Masuk</th>
                <th>Foto Pulang</th>
                <th>Keterangan</th>
            </tr>
            @foreach ($data_laporan as $laporan)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td style="white-space: nowrap; word-wrap: break-word;">
                        {{ date("d-m-Y", strtotime($laporan['tanggal'])) }}
                    </td>
                    <td style="text-align: center;">{{ $laporan['jam_in'] ?? 'Belum Absen' }}</td>
                    <td style="text-align: center;">{{ $laporan['jam_out'] ?? 'Belum Absen' }}</td>
                    <td style="text-align: center;">
                        @if ($laporan['foto_in'])
                            <img src="{{ url(Storage::url('upload/absensi/' . $laporan['foto_in'])) }}" alt="Foto Masuk"
                                class="foto">
                        @else
                            <img src="{{ asset('assets/img/kamera.png') }}" alt="Belum Absen" class="foto">
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if ($laporan['foto_out'])
                            <img src="{{ url(Storage::url('upload/absensi/' . $laporan['foto_out'])) }}" alt="Foto Pulang"
                                class="foto">
                        @else
                            <img src="{{ asset('assets/img/kamera.png') }}" alt="Belum Absen" class="foto">
                        @endif
                    </td>
                    <td>
                        <p style="text-align: justify; margin:0px;">
                            {{ $laporan['status'] }} {{ $laporan['terlambat'] ?? ''}} | Kerja : {{ $laporan['total_jam_kerja'] }} <br> Keterangan :
                            {{ $laporan['keterangan'] }}
                        </p>
                    </td>
                </tr>
            @endforeach
        </table>


        <table width="100%" style="margin-top: 2%">
            <tr>
                <td></td>
                <td colspan="2" style="text-align: left;padding-left: 5%;">Malang, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: left;padding-left: 5%;">

                        <b>Hakim Pembimbing,</b><br> <!-- Jabatan ditambahkan di atas -->
                        <br><br> <!-- Ruang untuk tanda tangan -->
                        <br><br> <!-- Ruang untuk tanda tangan -->
                        <b>
                            <u style="text-transform:uppercase">{{ $nama_hakim }}</u><br>
                        </b>
                        <b>NIP. {{ $nip }}</b>
                    
                </td>
                <td style="text-align: left;padding-left: 5%;">

                        <b>Koordinator Magang,</b><br> <!-- Jabatan ditambahkan di atas -->
                        <br><br> <!-- Ruang untuk tanda tangan -->
                        <br><br> <!-- Ruang untuk tanda tangan -->
                        <b>
                            <u>EKO WAHONO, S.H</u><br>
                        </b>
                        <b>NIP. 19800330 200212 1 002</b>
                    
                </td>
            </tr>
        </table>
    </section>
</body>

</html>