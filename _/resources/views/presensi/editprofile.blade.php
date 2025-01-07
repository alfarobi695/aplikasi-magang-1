@extends('layouts.presensi')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle" style="margin-left:35%">Edit Profile</div>
        <div class="right">
            <a href="/proseslogout" style="color:white; margin-right:10px">Logout</a>
        </div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <div class="row" style="margin-top: 4rem">
        <div class="col">
            @php
                $messageSuccess = Session::get('success');
                $messageError = Session::get('error');
            @endphp

            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ $messageSuccess }}
                </div>
            @endif

            @if (Session::get('error'))
                <div class="alert alert-error">
                    {{ $messageError }}
                </div>
            @endif
        </div>
    </div>
    <form action="/presensi/{{ $mahasiswa->nim }}/updateprofile" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col">
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">
                </div>
                <small id="passwordHelp" class="form-text text-danger" style="display:none;">Password harus
                            minimal 5 karakter dan mengandung setidaknya 1 angka, 1 huruf kapital, dan 1 karakter
                            khusus.</small>
            </div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <button type="submit" class="btn btn-primary btn-block">
                        <ion-icon name="refresh-outline"></ion-icon>
                        Update
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('myscript')
<script>
        const passwordInput = document.getElementById('password');
        const passwordHelp = document.getElementById('passwordHelp');

        passwordInput.addEventListener('input', function () {
            const password = passwordInput.value;

            // Regex untuk validasi password
            const isValid = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{5,}$/.test(password);

            if (!isValid) {
                passwordHelp.style.display = 'block'; // Menampilkan pesan jika password tidak valid
            } else {
                passwordHelp.style.display = 'none'; // Menyembunyikan pesan jika password valid
            }
        });
        // Validasi saat form disubmit
        document.querySelector('form').addEventListener('submit', function (event) {
            const password = passwordInput.value;
            const isValid = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{5,}$/.test(password);

            if (!isValid) {
                event.preventDefault(); // Mencegah form disubmit

                passwordInput.focus(); // Memfokuskan kembali input password
            }
        });
    </script>
@endpush
