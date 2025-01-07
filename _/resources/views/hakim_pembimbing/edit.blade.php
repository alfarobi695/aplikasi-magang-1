@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">
                Edit Data Hakim Pembimbing
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('hakim_pembimbing.update', $hakimPembimbing) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                    <label for="nama_hakim">Nama Hakim</label>
                                    <input type="text" name="nama_hakim" class="form-control" value="{{ $hakimPembimbing->nama_hakim }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                    <label for="nip">NIP</label>
                                    <input type="text" name="nip" class="form-control" value="{{ $hakimPembimbing->nip }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" name="cetak" class="btn btn-primary w-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg>
                                            Edit Data
                                        </button>
                                    </div>
                                </div>
                                {{-- <div class="col-6">
                                    <div class="form-group">
                                        <button type="submit" name="exportexcel" class="btn btn-success w-100">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-download" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
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
