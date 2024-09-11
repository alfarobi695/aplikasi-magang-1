@extends('layouts.dashboardguest.tabler')
@section('content')

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards" style="margin-bottom:20px">
            <div class="col-md">
                <div class="card">
                    <div class="">
                        <div id="carousel-default" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100 rounded" alt=""
                                        src="https://images.bisnis.com/posts/2023/07/10/1673252/bisnis.com-begini-rasanya-magang-di-perusahaan-penopang-energi-nasional-1.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom:20px">
            <div class="col-md">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center">
                            Deskripsi
                        </h1>
                        <p class=" text-secondary font-weight-normal" style="font-size: 19px; text-align: justify;">
                            Selamat datang di website program magang Pengadilan Negeri Malang. Dalam hal pelaksanaan
                            program magang di Pengadilan Negeri Malang, website ini menyediakan berbagai informasi
                            penting untuk mahasiswa magang. Setiap mahasiswa yang ingin mengikuti program magang harus
                            melakukan pendaftaran melalui platform ini dan melengkapi data yang diperlukan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom:20px">
            <div class="col-md-6 col-xl-6">
                <a href="#">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-auto">
                                    <span
                                        class="bg-success text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user-edit">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                            <path
                                                d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">

                                    </div>
                                    <div class="my-2">
                                        <h3>
                                            Syarat Daftar Magang
                                        </h3>
                                    </div>
                                    <div class="text-secondary" style="text-align: justify;">
                                        Mahasiswa yang ingin mendaftar magang sebagai bagian dari program Pengadilan
                                        Negeri Malang wajib merupakan mahasiswa aktif dari
                                        perguruan tinggi. Selain itu, peserta harus
                                        menyertakan Surat Pengantar dari kampus,
                                        Proposal Magang, dan berkomitmen untuk mengikuti seluruh kegiatan magang yang
                                        sudah ditetapkan sesuai dengan
                                        jadwal dan ketentuan yang berlaku.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-md-6 col-xl-6">
                <a href="#">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <span
                                        class="bg-info text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-file-text" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                            <path
                                                d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z">
                                            </path>
                                            <path d="M9 9l1 0"></path>
                                            <path d="M9 13l6 0"></path>
                                            <path d="M9 17l6 0"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">

                                    </div>
                                    <div class="my-2" id="alokasi">
                                        <h3>
                                            Alokasi Peserta Magang
                                        </h3>
                                    </div>
                                    <div class="text-secondary" style="text-align: justify;">
                                        Program Magang di Pengadilan Negeri Malang memiliki alokasi maksimal 19 peserta
                                        dalam satu periode. Saat ini, jumlah
                                        mahasiswa aktif yang sedang mengikuti program magang adalah
                                        {{ $alokasi->jml_mahasiswa ? $alokasi->jml_mahasiswa : 0 }} orang. Mahasiswa magang
                                        akan mendapatkan bimbingan dari
                                        mentor yang berkompeten. Pendaftaran
                                        ditutup jika kuota telah terpenuhi atau sesuai dengan jadwal yang telah
                                        ditetapkan.
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- <div class="col-md-6 col-xl-4 mb-2">
                <a href="#">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <span
                                        class="bg-info text-white avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-license">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                                            <path d="M9 7l4 0" />
                                            <path d="M9 11l4 0" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">

                                    </div>
                                    <div class="my-2">
                                        <h3>
                                            Data Diri
                                        </h3>
                                    </div>
                                    <div class="text-secondary" style="text-align: justify;">
                                        Advokat selaku Pengguna Terdaftar dan Para Pencari Keadilan (Non-Advokat) selaku
                                        Pengguna Lainnya yang sudah terdaftar dapat beracara di seluruh Pengadilan yang
                                        sudah aktif dalam pemilihan saat mau mendaftar perkara baru.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div> -->
        </div>
        <div>
            <div class="row" style="margin-bottom:20px">
                <div class="col-md">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center" id="bagan">
                                <h3>Bagan Mahasiswa Magang</h3>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Nama</td>
                                        <td>NIM</td>
                                        <td>Program Studi</td>
                                        <td>Perguruan Tinggi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tabel as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ $d->nim }}</td>
                                            <td>{{ $d->program_studi }}</td>
                                            <td>{{ $d->perguruan_tinggi }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection