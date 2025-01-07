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
                <h2 class="page-title">
                    <a href="/dashboardmahasiswa">Dashboard</a>/Data Diri
                </h2>
            </div>
        </div>
    </div>
</div>

<body class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1724846371"></script>
    <div class="page page-center">
        <div class="container" style="margin-top: 20px;">
            <form class="card card-md" autocomplete="off" action="/updatemahasiswa" method="POST" id="frmMahasiswa"
                enctype="multipart/form-data">
                @csrf

                <div class="card-body">
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
                                    id="nama_lengkap" name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" placeholder="Masukkan Tempat Lahir"
                                    id="tempat_lahir" name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $mahasiswa->tempat_lahir) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $mahasiswa->tanggal_lahir) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" placeholder="Masukkan Alamat" id="alamat_malang"
                                    name="alamat_malang"
                                    required>{{ old('alamat_malang', $mahasiswa->alamat_malang) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIM</label>
                                <input type="text" class="form-control" placeholder="Masukkan NIM" id="nim" 
                                    value="{{ old('nim', $mahasiswa->nim) }}" disabled>
                                <input type="hidden"id="nim" name="nim"
                                    value="{{ old('nim', $mahasiswa->nim) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Semester Saat Magang</label>
                                <input type="number" class="form-control" placeholder="Masukkan Semester"
                                    id="semester_saat_magang" name="semester_saat_magang"
                                    value="{{ old('semester_saat_magang', $mahasiswa->semester_saat_magang) }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">IPK Terakhir</label>
                                <input type="number" class="form-control" placeholder="Masukkan IPK" step="0.01"
                                    id="ipk_terakhir" name="ipk_terakhir"
                                    value="{{ old('ipk_terakhir', $mahasiswa->ipk_terakhir) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Program Studi</label>
                                <input type="text" class="form-control" placeholder="Masukkan Program Studi"
                                    id="program_studi" name="program_studi"
                                    value="{{ old('program_studi', $mahasiswa->program_studi) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" class="form-control" placeholder="Masukkan Jurusan" id="jurusan"
                                    name="jurusan" value="{{ old('jurusan', $mahasiswa->jurusan) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nomor HP (contoh : 628xxxxxxxxx)</label>
                                <input type="tel" class="form-control"
                                    placeholder="Masukkan Nomor WA Dengan 0 Diganti 62" id="no_hp" name="no_hp"
                                    value="{{ old('no_hp', $mahasiswa->no_hp) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Durasi Magang</label>
                                <input type="number" class="form-control" placeholder="Masukkan Durasi Magang"
                                    id="durasi_magang" name="durasi_magang"
                                    value="{{ old('durasi_magang', $mahasiswa->durasi_magang) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai Magang</label>
                                <input type="date" class="form-control" id="tanggal_mulai_magang"
                                    name="tanggal_mulai_magang"
                                    value="{{ old('tanggal_mulai_magang', $mahasiswa->tanggal_mulai_magang) }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Perguruan Tinggi</label>
                                <input type="text" class="form-control" placeholder="Masukkan Perguruan Tinggi"
                                    id="perguruan_tinggi" name="perguruan_tinggi"
                                    value="{{ old('perguruan_tinggi', $mahasiswa->perguruan_tinggi) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link Proposal Magang</label>
                                <input type="url" class="form-control" placeholder="Masukkan Link" id="proposal_magang"
                                    name="proposal_magang"
                                    value="{{ old('proposal_magang', $mahasiswa->proposal_magang) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link Surat Pengantar Magang</label>
                                <input type="url" class="form-control" placeholder="Masukkan Link"
                                    id="surat_pengantar_magang" name="surat_pengantar_magang"
                                    value="{{ old('surat_pengantar_magang', $mahasiswa->surat_pengantar_magang) }}"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <!-- Input file untuk unggah foto baru -->
                        <input type="file" class="form-control" id="foto" name="foto" accept=".png, .jpg, .jpeg">

                        <!-- Input tersembunyi untuk menyimpan nama file foto lama -->
                        <input type="hidden" class="form-control" id="old_foto" name="old_foto"
                            value="{{ $mahasiswa->foto }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" placeholder="Password" id="password"
                                name="password">
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <a href="/dashboardmahasiswa" type="button" class="btn btn-secondary w-100">
                                        Kembali
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Ubah</button>
                                </div>
                            </div>
                        </div>
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
@endsection