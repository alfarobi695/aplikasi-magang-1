<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sign in with illustration - Tabler - Premium and Open Source dashboard template with responsive and high
        quality UI.</title>
    <!-- CSS files -->
    <link href="{{ asset('tabler/dist/css/tabler.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('tabler/dist/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('tabler/dist/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('tabler/dist/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('tabler/dist/css/demo.min.css?1692870487') }}" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1724846371"></script>
    <div class="page page-center">
        <div class="container py-4">
            <div class="text-center mb-4">
                <img src="{{ asset('assets/logo.jpeg') }}" alt="image" class="form-image" style="width: 80px;" />
            </div>
            <form class="card card-md" autocomplete="off" action="/prosesregister" method="POST" id="frmMahasiswa"
                enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Registrasi Mahasiswa Magang</h2>
                    <!-- Pesan Sukses atau Error -->
                    @if (session('success'))
                        <button class="btn btn-success w-100 text-center mb-4">
                            {{ session('success') }}
                        </button>
                    @endif

                    @if (session('error'))
                        <button class="btn btn-danger w-100 text-center mb-4">
                            {{ session('error') }}
                        </button>
                    @endif

                    <!-- Tampilkan Error Validasi -->
                    @if ($errors->any())
                        <div style="color: red;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap"
                                    id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" placeholder="Masukkan Tempat Lahir"
                                    id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" placeholder="Masukkan Alamat" id="alamat_malang"
                                    name="alamat_malang" required>{{ old('alamat_malang') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIM</label>
                                <input type="text" class="form-control" placeholder="Masukkan NIM" id="nim" name="nim"
                                    value="{{ old('nim') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Semester Saat Magang</label>
                                <input type="number" class="form-control" placeholder="Masukkan Semester"
                                    id="semester_saat_magang" name="semester_saat_magang"
                                    value="{{ old('semester_saat_magang') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">IPK Terakhir</label>
                                <input type="number" class="form-control" placeholder="Masukkan IPK" step="0.01"
                                    id="ipk_terakhir" name="ipk_terakhir" value="{{ old('ipk_terakhir') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Program Studi (contoh : S-1 Ilmu Hukum)</label>
                                <input type="text" class="form-control" placeholder="Masukkan Program Studi "
                                    id="program_studi" name="program_studi" value="{{ old('program_studi') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" class="form-control" placeholder="Masukkan Jurusan" id="jurusan"
                                    name="jurusan" value="{{ old('jurusan') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nomor HP (contoh : 628xxxxxxxxx)</label>
                                <input type="tel" class="form-control"
                                    placeholder="Masukkan Nomor HP Dengan 0 Diganti 62" id="no_hp" name="no_hp"
                                    value="{{ old('no_hp') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Durasi Magang</label>
                                <input type="number" class="form-control" placeholder="Masukkan Durasi Magang"
                                    id="durasi_magang" name="durasi_magang" value="{{ old('durasi_magang') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai Magang</label>
                                <input type="date" class="form-control" id="tanggal_mulai_magang"
                                    name="tanggal_mulai_magang" value="{{ old('tanggal_mulai_magang') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Perguruan Tinggi</label>
                                <input type="text" class="form-control" placeholder="Masukkan Perguruan Tinggi"
                                    id="perguruan_tinggi" name="perguruan_tinggi" value="{{ old('perguruan_tinggi') }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link Proposal Magang</label>
                                <input type="url" class="form-control" placeholder="Masukkan Link" id="proposal_magang"
                                    name="proposal_magang" value="{{ old('proposal_magang') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link Surat Pengantar Magang</label>
                                <input type="url" class="form-control" placeholder="Masukkan Link"
                                    id="surat_pengantar_magang" name="surat_pengantar_magang"
                                    value="{{ old('surat_pengantar_magang') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept=".png, .jpg, .jpeg"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" placeholder="Password" id="password"
                                name="password" required>
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" title="Show password" id="togglePassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="icon">
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1724846371" defer></script>
    <script src="./dist/js/demo.min.js?1724846371" defer></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const icon = document.querySelector('#icon');

        togglePassword.addEventListener('click', function (e) {
            e.preventDefault();
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the icon (optional, if you want to change the icon)
            if (type === 'text') {
                icon.innerHTML = `<path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                              <path d="M1 1l22 22" />`;  // A custom icon or SVG for 'hide password'
            } else {
                icon.innerHTML = `<path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                              <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />`; // Original eye icon
            }
        });
    </script>
</body>

</html>