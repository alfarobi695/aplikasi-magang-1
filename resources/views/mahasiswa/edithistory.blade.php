<form action="/mahasiswa/{{ $mahasiswa->nim }}/update" method="POST" id="frmMahasiswa" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
    <label for="nim" class="form-label">NIM</label>
        <div class="input-icon mb-3">
            <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>
                    <path d="M4 17v1a2 2 0 0 0 2 2h2"></path>
                    <path d="M16 4h2a2 2 0 0 1 2 2v1"></path>
                    <path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>
                    <path d="M5 11h1v2h-1z"></path>
                    <path d="M10 11l0 2"></path>
                    <path d="M14 11h1v2h-1z"></path>
                    <path d="M19 11l0 2"></path>
                </svg>
            </span>
            <input type="text" name="nim" id="nim" class="form-control" value="{{ $mahasiswa->nim }}" placeholder="NIM">
        </div>
    </div>
    <div class="mb-3">
    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
        <div class="input-icon mb-3">
            <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                </svg>
            </span>
            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                value="{{ $mahasiswa->nama_lengkap }}" placeholder="Nama Lengkap">
        </div>
    </div>
    <div class="mb-3">
    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
        <div class="input-icon mb-3">
            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                    Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                    Perempuan</option>
            </select>
        </div>
    </div>
    <div class="mb-3">
    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
        <div class="input-icon mb-3">
            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                value="{{ $mahasiswa->tempat_lahir }}" placeholder="Tempat Lahir">
        </div>
    </div>
    <div class="mb-3">
    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
        <div class="input-icon mb-3">
            <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                value="{{ $mahasiswa->tanggal_lahir }}" placeholder="Tanggal Lahir">
        </div>
    </div>
    <div class="mb-3">
    <label for="alamat_malang" class="form-label">Alamat Malang</label>
        <div class="input-icon mb-3">
            <textarea  class="form-control" name="alamat_malang" id="">{{ $mahasiswa->alamat_malang }}</textarea>
        </div>
    </div>
    <div class="mb-3">
    <label for="no_hp" class="form-label">No Handphone</label>
        <div class="input-icon mb-3">
            <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path
                        d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                    </path>
                </svg>
            </span>
            <input type="text" name="no_hp" id="no_hp" value="{{ $mahasiswa->no_hp }}" class="form-control"
                placeholder="No Hanphone">
        </div>
    </div>
    <div class="mb-3">
    <label for="semester_saat_magang" class="form-label">Semester Saat Magang</label>
        <div class="input-icon mb-3">
            <input type="text" name="semester_saat_magang" id="semester_saat_magang" class="form-control"
                value="Semester {{ $mahasiswa->semester_saat_magang }}" placeholder="Semester Saat Magang">
        </div>
    </div>
    <div class="mb-3">
    <label for="ipk_terakhir" class="form-label">IPK Terakhir</label>
        <div class="input-icon mb-3">
            <input type="text" name="ipk_terakhir" id="ipk_terakhir" class="form-control"
                value="{{ $mahasiswa->ipk_terakhir }}" placeholder="IPK Terakhir">
        </div>
    </div>
    <div class="mb-3">
    <label for="program_studi" class="form-label">Program Studi</label>
        <div class="input-icon mb-3">
            <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-analytics" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M3 4m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z">
                    </path>
                    <path d="M7 20l10 0"></path>
                    <path d="M9 16l0 4"></path>
                    <path d="M15 16l0 4"></path>
                    <path d="M8 12l3 -3l2 2l3 -3"></path>
                </svg>
            </span>
            <input type="text" name="program_studi" id="program_studi" class="form-control"
                value="{{ $mahasiswa->program_studi }}" placeholder="program_studi">
        </div>
    </div>
    <div class="mb-3">
    <label for="jurusan" class="form-label">Jurusan</label>
        <div class="input-icon mb-3">
            <input type="text" name="jurusan" id="jurusan" class="form-control"
                value="{{ $mahasiswa->jurusan }}" placeholder="Jurusan">
        </div>
    </div>
    <div class="mb-3">
    <label for="perguruan_tinggi" class="form-label">Perguruan Tinggi</label>
        <div class="input-icon mb-3">
            <input type="text" name="perguruan_tinggi" id="perguruan_tinggi" class="form-control"
                value="{{ $mahasiswa->perguruan_tinggi }}" placeholder="Perguruan Tinggi">
        </div>
    </div>
    <div class="mb-3">
    <label for="durasi_magang" class="form-label">Durasi Magang</label>
        <div class="input-icon mb-3">
            <input type="text" name="durasi_magang" id="durasi_magang" class="form-control"
                value="{{ $mahasiswa->durasi_magang }} Minggu" placeholder="Durasi Magang">
        </div>
    </div>
    <div class="mb-3">
    <label for="tanggal_mulai_magang" class="form-label">Tanggal Mulai Magang</label>
        <div class="input-icon mb-3">
            <input type="text" name="tanggal_mulai_magang" id="tanggal_mulai_magang" class="form-control"
                value="{{ $mahasiswa->tanggal_mulai_magang }}" placeholder="Tanggal Mulai Magang">
        </div>
    </div>
    <div class="mb-3">
    <label for="surat_pengantar_magang" class="form-label">Surat Pengantar Magang</label>
        <div class="input-icon mb-3">
            <input type="text" name="surat_pengatar_magang" id="surat_pengatar_magang" class="form-control"
                value="{{ $mahasiswa->surat_pengatar_magang }}" placeholder="Surat Pengantar Magang">
        </div>
    </div>
    <div class="mb-3">
    <label for="proposal_magang" class="form-label">Proposal Magang</label>
        <div class="input-icon mb-3">
            <input type="text" name="proposal_magang" id="proposal_magang" class="form-control"
                value="{{ $mahasiswa->proposal_magang }}" placeholder="Proposal Magang">
        </div>
    </div>
    <div class="mb-3">
    <label for="kode_dept" class="form-label">Department</label>
        <select name="kode_dept" id="kode_dept" class="form-select">
            <option value="">Pilih Department</option>
            @foreach ($department as $d)
                <option value="{{ $d->kode_dept }}" {{ $mahasiswa->kode_dept == $d->kode_dept ? 'selected' : '' }}>
                    {{ $d->nama_dept }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
    <label for="status_magang" class="form-label">Status Magang</label>
        <select name="status_magang" id="status_magang" class="form-select" required>
            <option value="">Pilih Status Magang</option>
            <option value="Calon" {{ $mahasiswa->status_magang == 'Calon' ? 'selected' : '' }}>Calon</option>
            <option value="Ditolak" {{ $mahasiswa->status_magang == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            <option value="Aktif" {{ $mahasiswa->status_magang == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Selesai" {{ $mahasiswa->status_magang == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="Blacklist" {{ $mahasiswa->status_magang == 'Blacklist' ? 'selected' : '' }}>Blacklist</option>
        </select>
    </div>
    <div class="mb-3">
    <label for="hakim_pembimbing_id" class="form-label">Hakim Pembimbing</label>
        <label for="hakim_pembimbing_id" class="form-label">Pilih Hakim Pembimbing</label>
        <select name="hakim_pembimbing_id" id="hakim_pembimbing_id" class="form-select" required>
            <option value="">Pilih Hakim Pembimbing</option>
            @foreach ($hakim_pembimbing as $hakim)
                <option value="{{ $hakim->id }}" {{ $mahasiswa->hakim_pembimbing_id == $hakim->id ? 'selected' : '' }}>
                    {{ $hakim->nama_hakim }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3" id="alasan_blacklist_field"
        style="display: {{ $mahasiswa->status_magang == 'Blacklist' ? 'block' : 'none' }};">
        <label for="alasan_blacklist" class="form-label">Hakim Pembimbing</label>
        <div class="input-icon mb-3">
            <textarea name="alasan_blacklist" placeholder="Alasan Blacklist" id="alasan_blacklist"
                class="form-control">{{ $mahasiswa->alasan_blacklist }}</textarea>
        </div>
    </div>


    <div class="mb-3">
        <div class="input-icon mb-3">
            <input name="foto" type="file" class="form-control">
            <input type="hidden" name="old_foto" value="{{ $mahasiswa->foto }}">
        </div>
    </div>
</form>
@push('myscript')