<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

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
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">



    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table>
            <tr>
                <td style="width: 100px">
                    <img src="{{ asset('assets/img/yodyakarya.png') }}" width="70" height="70" alt="">
                </td>
                <td>
                    <span id="title">
                        LAPORAN ABSENSI KARYAWAN<br />
                        PERIODE {{ strtoupper($namabulan[$bulan])  }} {{ $tahun }}<br />
                        PT.YODYA KARYA PERSERO <br />
                    </span>
                    <span><i>Timur DKI Jakarta, Jl. Mayjen DI Panjaitan Kav 8 Cipinang Besar Selatan, RT.5/RW.11,
                            Cipinang Cempedak, Kecamatan Jatinegara, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta
                            13340</i></span>
                </td>
            </tr>
        </table>
        <table class="tabeldatakaryawan">
            <tr>
                <td rowspan="6">
                    @php
                        $path = Storage::url('uploads/karyawan/' . $karyawan->foto);
                      @endphp
                    <img src="{{ url($path) }}" width="120px" alt="">
                </td>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Nama karyawan</td>
                <td>:</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td>:</td>
                <td>{{ $karyawan->nama_dept }}</td>
            </tr>
            <tr>
                <td>No HP</td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>
        <table class="tabelpresensi">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>nik</th>
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

                            // Hitung total jam kerja
                            $jam_in = strtotime($prs->jam_in);
                            $jam_out = $prs->jam_out !== null ? strtotime($prs->jam_out) : null;
                            $total_jam_kerja = $jam_out ? round(($jam_out - $jam_in) / 3600, 2) : 'Belum Absen';

                            // Hitung menit terlambat
                            $waktu_masuk_normal = strtotime('07:30');
                            $menit_terlambat = $jam_in > $waktu_masuk_normal ? round(($jam_in - $waktu_masuk_normal) / 60) : 0;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date("d-m-y", strtotime($prs->tgl_presensi)) }}</td>
                            <td>{{ $prs->nik }}</td>
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
                                    Terlambat {{ $menit_terlambat }} menit | Kerja : {{ $total_jam_kerja }} Jam || Kegiatan : </br> {{ $prs->kegiatan }}
                                @else
                                    Tepat Waktu | Kerja : {{ $total_jam_kerja }} Jam || Kegiatan : </br> {{ $prs->kegiatan }}
                                @endif
                            </td>
                        </tr>
            @endforeach
        </table>


        <table width="100%" style="margin-top: 100px">
            <tr>
                <td colspan="2" style="text-align: right">Jakarta Selatan, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="100">
                    <u>Ranu</u><br>
                    <i><b>HRG Manager</b></i>
                </td>
                <td style="text-align: center; vertical-align:bottom">
                    <u>Antariksa Artidi</u><br>
                    <i><b>Direktur</b></i>
                </td>
            </tr>
        </table>
    </section>

</body>

</html>