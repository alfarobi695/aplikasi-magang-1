<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Print Laporan Magang PN {{ $tahun }}</title>

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
            text-align: center;
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
            <img src="{{ asset('assets/logo.jpeg') }}" style="margin-right: 45px;margin-left: 40px;padding-left:18%;" alt="Logo">
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
        <h3 style="text-transform:uppercase">LAPORAN BULANAN MAHASISWA MAGANG PERIODE {{ \Carbon\Carbon::createFromFormat('m', $bulan)->format('F') }} {{ $tahun }}</h3>
        <table class="tabelpresensi">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIM</th>
                    @foreach($tanggalArray as $tanggal)
                        <th>{{ \Carbon\Carbon::parse($tanggal)->format('d') }}</th>
                    @endforeach
                    <th>Kehadiran (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $data)
                    <tr>
                        <td>{{ $data['nama'] }}</td>
                        <td>{{ $data['nim'] }}</td>
                        @foreach($data['kehadiran'] as $status)
    <td style="
        @if($status == '+')
            background-color: green; color: white;
        @elseif($status == '-')
            background-color: red; color: white;
        @elseif($status == '#')
            background-color: yellow; color: black;
        @endif
    ">
        {{ $status }}
    </td>
@endforeach
                        <td>{{ $data['persentase'] }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</body>

</html>