@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
            <!-- Page pre-title -->
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
            <div class="">
                <div class="card">
                    <div class="card-body">
                        <form action="/presensi/cetaklaporan" id="formlaporan" target="_blank" method="POST">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <select class="form-select" name="bulan" id="bulan">
                                            <option value="">Bulan</option>
                                            @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}" {{ date("m") == $i ? 'selected': '' }}>{{ $namabulan[$i] }}</option>
                                                
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <select class="form-select" name="tahun" id="tahun">
                                            <option value="">Tahun</option>
                                            @php
                                                $tahunmulai = 2022;
                                                $tahunskrg = date("Y");
                                            @endphp
                                            @for ($tahun = $tahunmulai; $tahun <= $tahunskrg; $tahun++) <option valur="{{ $tahun }}" {{ date("Y") == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <select class="form-select" name="nim" id="nim">
                                            <option value="">Pilih Mahasiswa</option>
                                            @foreach ($mahasiswa as $kry)
                                                <option value="{{ $kry->nim }}">{{ $kry->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" name="cetak" class="btn btn-primary w-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path>
                                                <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                                                <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path>
                                             </svg>
                                             Cetak Laporan
                                        </button>
                                    </div>
                                </div>
                                {{-- <div class="col-6">
                                    <div class="form-group">
                                        <button type="submit" name="exportexcel" class="btn btn-success w-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                                <path d="M7 11l5 5l5 -5"></path>
                                                <path d="M12 4l0 12"></path>
                                             </svg>
                                             Export to Excel
                                        </button>
                                    </div>
                                </div> --}}
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
        $(function(){
            $("#formlaporan").submit(function(e){
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();
                var nim = $("#nim").val();
                
                if(bulan==""){
                    Swal.fire({
                    title: 'Warning !',
                    text: 'Bulan Harus Diisi !!!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result)=> {
                        $("#bulan").focus();
                    });
                    return false;
                } else if(tahun==""){
                    Swal.fire({
                    title: 'Warning !',
                    text: 'Tahun Harus Diisi !!!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result)=> {
                        $("#tahun").focus();
                    });
                    return false;
                } else if(nim==""){
                    Swal.fire({
                    title: 'Warning !',
                    text: 'Nim Harus Diisi !!!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    }).then((result)=> {
                        $("#nim").focus();
                    });
                    return false;
                }
            });
        });
    </script>
@endpush