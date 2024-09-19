@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Laporan Presensi
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12 col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Cetak Laporan</h4>
                    </div>
                    <div class="card-body">
                        <form action="/presensi/cetaklaporan" id="formlaporan" target="_blank" method="POST">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="bulan" class="form-label">Pilih Bulan</label>
                                        <select class="form-select" name="bulan" id="bulan" required>
                                            <option value="">-- Pilih Bulan --</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ date("m") == $i ? 'selected' : '' }}>
                                                    {{ $namabulan[$i] }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="tahun" class="form-label">Pilih Tahun</label>
                                        <select class="form-select" name="tahun" id="tahun" >
                                            <option value="">-- Pilih Tahun --</option>
                                            @php
                                                $tahunmulai = 2022;
                                                $tahunskrg = date("Y");
                                            @endphp
                                            @for ($tahun = $tahunmulai; $tahun <= $tahunskrg; $tahun++)
                                                <option value="{{ $tahun }}" {{ date("Y") == $tahun ? 'selected' : '' }}>
                                                    {{ $tahun }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="nim" class="form-label">Pilih Mahasiswa</label>
                                        <select class="form-select" name="nim" id="nim" >
                                            <option value="">-- Pilih Mahasiswa --</option>
                                            @foreach ($mahasiswa as $mhs)
                                                <option value="{{ $mhs->nim }}">{{ $mhs->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="id_komagang" class="form-label">Pilih Koordinator Magang</label>
                                        <select class="form-select" name="id_komagang" id="id_komagang" required>
                                            <option value="">-- Pilih Koordinator Magang --</option>
                                            @foreach ($hakim as $komagang)
                                                <option value="{{ $komagang->id }}">{{ $komagang->nama_hakim }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" name="cetak" class="btn btn-primary w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-printer" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2">
                                            </path>
                                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                                            <path
                                                d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z">
                                            </path>
                                        </svg>
                                        Cetak Laporan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
    <script>
        $(function () {
            $("#formlaporan").submit(function (e) {
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();
                var nim = $("#nim").val();

                if (bulan == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Bulan Harus Diisi!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#bulan").focus();
                    });
                    return false;
                } else if (tahun == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Tahun Harus Diisi!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#tahun").focus();
                    });
                    return false;
                } else if (nim == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Pilih Mahasiswa!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        $("#nim").focus();
                    });
                    return false;
                }
            });
        });
    </script>
@endpush