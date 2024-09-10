@extends('layouts.dashboardmahasiswa.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                    Overview
                </div>
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h2 class="page-title">
                                    <a href="/dashboardmahasiswa">Dashboard</a> / Rekap Absensi
                                </h2>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="/dashboardmahasiswa" type="button" class="btn btn-secondary w-10">
                                Kembali
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th style="width: 100px;">TANGGAL</th>
                                            <th>PENGAJUAN</th>
                                            <th class="text-center">KETERANGAN</th>
                                            <th>STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="loadpresensi">
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
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td >{{ date("d-m-y", strtotime($prs->tgl_presensi)) }}</td>
                                            <td class="text-center">{{ $prs->jam_in }}</td>
                                            <td class="text-center"><img src="{{ url($path_in) }}" alt="" class="foto"  style="max-width: 50px; max-height: 50px;"></td>
                                            <td class="text-center">{{ $prs->jam_out !== null ? $prs->jam_out : 'Belum Absen' }}</td>
                                            <td class="text-center">
                                                @if ($prs->jam_out !== null)
                                                    <img src="{{ url($path_out) }}" alt="" class="foto" style="max-width: 50px; max-height: 50px;">
                                                @else
                                                    <!-- <img src="{{ asset('assets/img/kamera.png') }}" alt="" class="foto"  width="50" height="30"> -->
                                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded" style="max-width: 40px;">
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal modal-blur fade" id="modal-tampilkanpeta" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lokasi Presensi User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadmap">
                </div>
            </div>
        </div>
    </div>
@endsection
