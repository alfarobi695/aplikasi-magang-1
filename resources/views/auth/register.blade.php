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
    


    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS (jika belum ada) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Datepicker JavaScript -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
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
                        <a class="btn btn-success w-100 text-center mb-4">
                            {{ session('success') }}
                        </a>
                    @endif

                    @if (session('error'))
                        <a class="btn btn-danger w-100 text-center mb-4">
                            {{ session('error') }}
                        </a>
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
                                <label class="form-label">Nama Lengkap<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap"
                                    id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Masukkan Tempat Lahir"
                                    id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                    placeholder="DD/MM/YYYY" value="{{ old('tanggal_lahir') }}" required>
                                <small id="dateError" class="form-text text-danger" style="display:none;">Format tanggal
                                    harus dd/mm/yyyy.</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin<span style="color: red;">*</span></label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Di Malang<span style="color: red;">*</span></label>
                                <textarea class="form-control" placeholder="Masukkan Alamat" id="alamat_malang"
                                    name="alamat_malang" required>{{ old('alamat_malang') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIM<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Masukkan NIM" id="nim" name="nim"
                                    value="{{ old('nim') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Semester Saat Magang<span style="color: red;">*</span></label>
                                <input type="number" class="form-control" placeholder="Masukkan Semester"
                                    id="semester_saat_magang" name="semester_saat_magang"
                                    value="{{ old('semester_saat_magang') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">IPK Terakhir<span style="color: red;">*</span></label>
                                <input type="number" class="form-control" placeholder="Masukkan IPK dalam skala 4"
                                    step="0.01" id="ipk_terakhir" name="ipk_terakhir" value="{{ old('ipk_terakhir') }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Program Studi (contoh : S-1 Ilmu Hukum)<span
                                        style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Masukkan Program Studi "
                                    id="program_studi" name="program_studi" value="{{ old('program_studi') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jurusan<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Masukkan Jurusan" id="jurusan"
                                    name="jurusan" value="{{ old('jurusan') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nomor HP (contoh : 628xxxxxxxxx)<span
                                        style="color: red;">*</span></label>
                                <input type="number" class="form-control"
                                    placeholder="Masukkan Nomor HP Dengan 0 Diganti 62" id="no_hp" name="no_hp"
                                    value="{{ old('no_hp') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Durasi Magang (contoh : 2 atau 3)<span
                                        style="color: red;">*</span></label>
                                <input type="number" class="form-control"
                                    placeholder="Masukkan Durasi Magang Dalam Minggu" id="durasi_magang"
                                    name="durasi_magang" value="{{ old('durasi_magang') }}" min="2" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai Magang<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="tanggal_mulai_magang"
                                    placeholder="DD/MM/YYYY" name="tanggal_mulai_magang"
                                    value="{{ old('tanggal_mulai_magang') }}" required>
                                <small id="dateError" class="form-text text-danger" style="display:none;">Format tanggal
                                    harus dd/mm/yyyy.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Perguruan Tinggi<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" placeholder="Masukkan Perguruan Tinggi"
                                    id="perguruan_tinggi" name="perguruan_tinggi" value="{{ old('perguruan_tinggi') }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link Proposal Magang (Opsional)</label>
                                <input type="url" class="form-control" placeholder="Masukkan Link File Google Drive"
                                    id="proposal_magang" name="proposal_magang" value="{{ old('proposal_magang') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link Surat Pengantar Magang<span
                                        style="color: red;">*</span></label>
                                <input type="url" class="form-control" placeholder="Masukkan Link File Google Drive"
                                    id="surat_pengantar_magang" name="surat_pengantar_magang"
                                    value="{{ old('surat_pengantar_magang') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Selfie Sopan Rapi<span style="color: red;">*</span></label>
                        <input type="file" class="form-control" id="foto" name="foto" accept=".png, .jpg, .jpeg"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password<span style="color: red;">*</span></label>
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
                        <small id="passwordHelp" class="form-text text-danger" style="display:none;">Password harus
                            minimal 5 karakter dan mengandung setidaknya 1 angka, 1 huruf kapital, dan 1 karakter
                            khusus.</small>
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
    <!-- <script>
        // Mendapatkan elemen input tanggal
        const dateInput = document.getElementById('tanggal_mulai_magang');

        // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD
        const today = new Date().toISOString().split('T')[0];

        // Mengatur nilai minimum untuk input tanggal
        dateInput.setAttribute('min', today);
    </script> -->
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

    <script>
        $(document).ready(function () {
            // Menghitung tanggal 15-26 tahun yang lalu
            const today = new Date();
            const minDate = new Date();
            const maxDate = new Date();

            // Mengatur minDate 26 tahun lalu
            minDate.setFullYear(today.getFullYear() - 27);
            // Mengatur maxDate 15 tahun lalu
            maxDate.setFullYear(today.getFullYear() - 15);

            // Inisialisasi datepicker
            $('#tanggal_lahir').datepicker({
                format: 'dd/mm/yyyy', // Format yang ditampilkan kepada pengguna
                startDate: minDate, // Tanggal minimum 26 tahun yang lalu
                endDate: maxDate, // Tanggal maksimum 15 tahun yang lalu
                autoclose: true // Menutup datepicker setelah memilih tanggal
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Inisialisasi datepicker
            $('#tanggal_mulai_magang').datepicker({
                format: 'dd/mm/yyyy', // Format yang ditampilkan kepada pengguna
                startDate: new Date(), // Tanggal minimum 26 tahun yang lalu
                autoclose: true // Menutup datepicker setelah memilih tanggal
            });
        });
    </script>


</body>

</html>