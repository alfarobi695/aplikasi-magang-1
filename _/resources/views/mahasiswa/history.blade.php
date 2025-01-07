@extends('layouts.admin.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Master Data
                    </div>
                    <h2 class="page-title">
                        Data Riwayat Mahasiswa
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">

                    @php
                        $success = Session::get('success');
                        $error = Session::get('error');
                    @endphp

                    @if ($success)
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div>
                                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 12l5 5l10 -10"></path>
                                    </svg>
                                </div>
                                <div>
                                    {{ $success }}
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @elseif ($error)
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div>
                                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                        <path d="M12 8v4"></path>
                                        <path d="M12 16h.01"></path>
                                    </svg>
                                </div>
                                <div>
                                    {{ $error }}
                                </div>
                            </div>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @endif


                    <div class="card mt-2">
                        <div class="card-body d-flex flex-column gap-3">
                            <div>
                                <form action="/riwayat" method="GET">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Nama Mahasiswa"
                                                    name="nama_lengkap" id="nama_lengkap"
                                                    value="{{ Request('nama_lengkap') }}">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <select name="status_magang" class="form-select">
                                                    <option value="">Pilih Status Magang</option>
                                                    <option value="Ditolak" {{ Request('status_magang') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                    <option value="Selesai" {{ Request('status_magang') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="Blacklist" {{ Request('status_magang') == 'Blacklist' ? 'selected' : '' }}>Blacklist</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <button type="submit" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-search" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                </svg>
                                                Cari
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <td>No</td>
                                            <td>NIM</td>
                                            <td>Nama</td>
                                            <td>Status </td>
                                            <td>Durasi</td>
                                            <td>No. HP</td>
                                            <td>Foto</td>
                                            <td>Ruang</td>
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mahasiswa as $d)
                                            @php
                                                $path = Storage::url('upload/mahasiswa/' . $d->foto);
                                            @endphp
                                            <tr style="text-align: center;">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $d->nim }}</td>
                                                <td>{{ $d->nama_lengkap }}</td>
                                                <td>{{ $d->status_magang }}</td>
                                                <td>{{ $d->durasi_magang }} minggu, hingga {{ \Carbon\Carbon::parse($d->tanggal_mulai_magang)->addWeeks($d->durasi_magang)->format('d-m-Y') }}</td>
                                                <td><a href="https://wa.me/{{ $d->no_hp }}" target="_blank">{{ $d->no_hp }}</a></td>
                                                <td>
                                                    @if (empty($d->foto))
                                                        <img src="{{ url('assets/img/no_image.png') }}" class="avatar"
                                                            alt="foto">
                                                    @else
                                                        <img src="{{ url($path) }}" class="avatar" alt="foto">
                                                    @endif
                                                </td>
                                                <td>{{ $d->department->nama_dept }}</td>
                                                <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="#" class="edit" nim={{ $d->nim }}>
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-edit" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path
                                                                    d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                                </path>
                                                                <path
                                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                                </path>
                                                                <path d="M16 5l3 3"></path>
                                                            </svg>
                                                        </a>
                                                    
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                                {{ $mahasiswa->links('vendor.pagination.bootstrap-5') }}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- Modal Edit --}}
    <div class="modal modal-blur fade" id="modal-editmahasiswa" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadeditForm">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(document).ready(function() {

            $('#btnAddKar').click(function(e) {
                e.preventDefault();
                $('#modal-inputmahasiswa').modal("show");
            });

            $('.edit').click(function(e) {
                e.preventDefault();
                let nim = $(this).attr('nim');
                $.ajax({
                    type: "POST",
                    url: "/riwayat/edit",
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        nim: nim,
                    },
                    success: function(response) {
                        $('#loadeditForm').html(response);
                    }
                });
                $('#modal-editmahasiswa').modal("show");
            });

            $('#frmMahasiswa').submit(function() {
                let nim = $('#nim').val()
                let nama_lengkap = $('#nama_lengkap').val()
                let program_studi = $('#program_studi').val()
                let no_hp = $('#no_hp').val()
                let kode_dept = $('#frmMahasiswa').find('#kode_dept').val()

                if (nim == '') {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Nim Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        $('#nim').focus()
                    })

                    return false
                } else if (nama_lengkap == '') {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Nama Lengkap Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        $('#nama_lengkap').focus()
                    })

                    return false
                } else if (program_studi == '') {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Jabtan Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        $('#program_studi').focus()
                    })

                    return false
                } else if (no_hp == '') {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'No Handphone Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        $('#no_hp').focus()
                    })

                    return false
                } else if (kode_dept == '') {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Kode Department Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then(() => {
                        $('#kode_dept').focus()
                    })

                    return false
                }

            });
        });
    </script>
    
@endpush
