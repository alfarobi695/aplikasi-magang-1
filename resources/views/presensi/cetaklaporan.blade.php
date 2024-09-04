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

        .tabeldatakaryawan tr td {
            margin-top: 30px;
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
        window.onload = function() {
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
                <p>MONITORING KEGIATAN MAHASISWA MAGANG PERIODE {{ strtoupper($namabulan[$bulan])  }} {{ $tahun }}</p><br/>
                <p>POLITEKNIK NEGERI MALANG</p>
                <p>JURUSAN TEKNOLOGI INFORMASI</p>
                <p>PROGRAM STUDI D-IV TEKNIK INFORMATIKA</p>
                <br>
                <p style="text-transform:uppercase">{{ $mahasiswa->nama_lengkap }}</p>
                <p>NIM : {{ $mahasiswa->nim }}</p>
            </div>
        </div>
        <table class="tabelpresensi">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Ruang</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
                <th>Jam Pulang</th>
                <th>Foto</th>
                <th>Keterangan</th>
            </tr>
            @foreach ($presensi as $prs)
                @php
                    $path_in = Storage::url('upload/absensi/' . $prs->foto_in);
                    $path_out = Storage::url('upload/absensi/' . $prs->foto_out);

                    $jam_in = strtotime($prs->jam_in);
                    $jam_out = $prs->jam_out !== null ? strtotime($prs->jam_out) : null;
                    $total_jam_kerja = $jam_out ? round(($jam_out - $jam_in) / 3600, 2) : 'Belum Absen';

                    $waktu_masuk_normal = strtotime('07:30');
                    $menit_terlambat = $jam_in > $waktu_masuk_normal ? round(($jam_in - $waktu_masuk_normal) / 60) : 0;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date("d-m-y", strtotime($prs->tgl_presensi)) }}</td>
                    <td>{{ $prs->nim }}</td>
                    <td>{{ $prs->jam_in }}</td>
                    <td><img src="{{ url($path_in) }}" alt="" class="foto"></td>
                    <td>{{ $prs->jam_out !== null ? $prs->jam_out : 'Belum Absen' }}</td>
                    <td>
                        @if ($prs->jam_out !== null)
                            <img src="{{ url($path_out) }}" alt="" class="foto">
                        @else
                            <img src="{{ asset('assets/img/kamera.png') }}" alt="" class="foto">
                        @endif
                    </td>
                    <td>
                        @if ($menit_terlambat > 0)
                            Terlambat {{ $menit_terlambat }} menit | Kerja : {{ $total_jam_kerja }} Jam || Kegiatan : </br>
                            {{ $prs->kegiatan }}
                        @else
                            Tepat Waktu | Kerja : {{ $total_jam_kerja }} Jam || Kegiatan : </br> {{ $prs->kegiatan }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
        <table width="100%" style="margin-top: 100px">
            <tr>
                <td colspan="2" style="text-align: right">Malang, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="100">
                    <u>Pak Muslih</u><br>
                    <i><b>Hakim Pembimbing Magang</b></i>
                </td>
                <td style="text-align: center; vertical-align:bottom">
                    <u>Pak ....</u><br>
                    <i><b>Hakim Koordinator Magang</b></i>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>