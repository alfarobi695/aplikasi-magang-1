<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Department;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\RiwayatMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\HakimPembimbing;
use App\Models\Presensi;
use Illuminate\Support\Facades\Storage;


class MahasiswaController extends Controller
{

    public function index(Request $request)
    {
        $nim = $request->nim;
        $nama_lengkap = $request->nama_lengkap;
        $kode_dept = $request->kode_dept;
        $status_magang = $request->status_magang;
        $mahasiswa = Mahasiswa::with('department')
            ->when($nama_lengkap, function ($query) use ($nama_lengkap) {
                return $query->where('nama_lengkap', 'LIKE', '%' . $nama_lengkap . '%');
            })
            ->when($kode_dept, function ($query) use ($kode_dept) {
                return $query->where('kode_dept', $kode_dept);
            })
            ->when($status_magang, function ($query) use ($status_magang) {
                return $query->where('status_magang', $status_magang);
            })
            ->when($nim, function ($query) use ($nim) {
                return $query->where('nim', $nim);
            })
            ->orderBy('nama_lengkap')
            ->paginate(30);


        $department = Department::get();

        return view('mahasiswa.index', [
            'mahasiswa' => $mahasiswa,
            'department' => $department,
        ]);
    }

    public function riwayat(Request $request)
    {
        $nim = $request->nim;
        $nama_lengkap = $request->nama_lengkap;
        $kode_dept = $request->kode_dept;
        $status_magang = $request->status_magang;
        $mahasiswa = RiwayatMagang::with('department')
            ->when($nama_lengkap, function ($query) use ($nama_lengkap) {
                return $query->where('nama_lengkap', 'LIKE', '%' . $nama_lengkap . '%');
            })
            ->when($kode_dept, function ($query) use ($kode_dept) {
                return $query->where('kode_dept', $kode_dept);
            })
            ->when($status_magang, function ($query) use ($status_magang) {
                return $query->where('status_magang', $status_magang);
            })
            ->when($nim, function ($query) use ($nim) {
                return $query->where('nim', $nim);
            })
            ->orderBy('nama_lengkap')
            ->paginate(30);


        $department = Department::get();

        return view('mahasiswa.history', [
            'mahasiswa' => $mahasiswa,
            'department' => $department,
        ]);
    }
    public function store(Request $request)
    {
        $nim = $request->nim;
        $nama_lengkap = $request->nama_lengkap;
        $program_studi = $request->program_studi;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $foto = $request->foto;

        $data = [
            'nim' => $nim,
            'nama_lengkap' => $nama_lengkap,
            'program_studi' => $program_studi,
            'no_hp' => $no_hp,
            'kode_dept' => $kode_dept,
            'password' => Hash::make('12345'),
            'foto' => $foto != '' ? $nim . ".png" : '',
        ];

        $simpan = Mahasiswa::create($data);
        if ($simpan) {
            if ($foto != '') {
                $folderPath = 'public/upload/mahasiswa/';
                $fileName = $nim . ".png";
                $request->file('foto')->storeAs($folderPath, $fileName);
            }
            return Redirect::back()->with(['success' => 'Data berhasil di simpan']);
        } else {
            return Redirect::back()->with(['error' => 'Data gagal di simpan']);
        }
    }

    public function edit(Request $request)
    {
        $nim = $request->nim;
        $mahasiswa = Mahasiswa::with('department')
            ->where('nim', $nim)->first();

        $department = Department::get();
        $hakim_pembimbing = HakimPembimbing::orderBy('nama_hakim')->get();
        return view('mahasiswa.edit', [
            'mahasiswa' => $mahasiswa,
            'department' => $department,
            'hakim_pembimbing' => $hakim_pembimbing
        ]);
    }

    public function editriwayat(Request $request)
    {
        $nim = $request->nim;
        $mahasiswa = RiwayatMagang::with('department')
            ->where('nim', $nim)->first();

        $department = Department::get();
        $hakim_pembimbing = HakimPembimbing::orderBy('nama_hakim')->get();
        return view('mahasiswa.edithistory', [
            'mahasiswa' => $mahasiswa,
            'department' => $department,
            'hakim_pembimbing' => $hakim_pembimbing
        ]);
    }
    public function update($nim, Request $request)
    {
        $nim = $request->nim;
        $nama_lengkap = $request->nama_lengkap;
        $program_studi = $request->program_studi;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $status_magang = $request->status_magang;
        $old_foto = $request->old_foto;
        $hakim_pembimbing_id = $request->hakim_pembimbing_id;


        if ($request->hasFile('foto')) {
            $foto = $nim . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }
        if ($request->status_magang === 'Blacklist') {
            $alasan_blacklist = $request->alasan_blacklist;
            $kode_dept = 'nonaktif';
        } else {
            $alasan_blacklist = null; // Hapus alasan jika status bukan blacklist
        }

        $data = [
            'nama_lengkap' => $nama_lengkap,
            'program_studi' => $program_studi,
            'no_hp' => $no_hp,
            'kode_dept' => $kode_dept,
            'status_magang' => $status_magang,
            'alasan_blacklist' => $alasan_blacklist,
            'hakim_pembimbing_id' => $hakim_pembimbing_id,
            'foto' => $foto != '' ? $nim . ".png" : '',
        ];

        $update = Mahasiswa::where('nim', $nim)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = 'public/upload/mahasiswa/';
                $folderPathOld = 'public/upload/mahasiswa/' . $old_foto;
                Storage::delete($folderPathOld);
                $fileName = $nim . ".png";
                $request->file('foto')->storeAs($folderPath, $fileName);
            }
            $mahasiswass = Mahasiswa::get();
            foreach ($mahasiswass as $mahasiswa) {
                if ($mahasiswa && in_array($mahasiswa->status_magang, ['Selesai', 'Blacklist', 'Ditolak'])) {
                    // Duplicate data mahasiswa ke tabel riwayat_magang
                    RiwayatMagang::create([
                        'nim' => $mahasiswa->nim,
                        'nama_lengkap' => $mahasiswa->nama_lengkap,
                        'jenis_kelamin' => $mahasiswa->jenis_kelamin,
                        'tempat_lahir' => $mahasiswa->tempat_lahir,
                        'tanggal_lahir' => $mahasiswa->tanggal_lahir,
                        'alamat_malang' => $mahasiswa->alamat_malang,
                        'no_hp' => $mahasiswa->no_hp,
                        'semester_saat_magang' => $mahasiswa->semester_saat_magang,
                        'ipk_terakhir' => $mahasiswa->ipk_terakhir,
                        'program_studi' => $mahasiswa->program_studi,
                        'jurusan' => $mahasiswa->jurusan,
                        'perguruan_tinggi' => $mahasiswa->perguruan_tinggi,
                        'durasi_magang' => $mahasiswa->durasi_magang,
                        'tanggal_mulai_magang' => $mahasiswa->tanggal_mulai_magang,
                        'surat_pengantar_magang' => $mahasiswa->surat_pengantar_magang,
                        'proposal_magang' => $mahasiswa->proposal_magang,
                        'foto' => $mahasiswa->foto,
                        'password' => $mahasiswa->password,
                        'kode_dept' => $mahasiswa->kode_dept,
                        'status_magang' => $mahasiswa->status_magang,
                        'alasan_blacklist' => $mahasiswa->alasan_blacklist,
                        'hakim_pembimbing_id' => $mahasiswa->hakim_pembimbing_id,
                    ]);
                    $mahasiswa->delete();
                }
            }
            return Redirect::back()->with(['success' => 'Data berhasil di update']);
        } else {
            return Redirect::back()->with(['error' => 'Data gagal di update']);
        }
    }

    public function delete($nim, Request $request)
    {
        $nim = $request->nim;
        $mahasiswa = Mahasiswa::find($nim);
        if ($mahasiswa) {
            $mahasiswa->delete();
            return Response::json(['success' => 'Data berhasil di hapus'], 200);
        } else {
            return Redirect::back()->with(['error' => 'Data gagal di update']);
        }
    }

    public function prosesregister(Request $request)
    {
        $request->validate([
            'nim' => 'required|max:255|unique:mahasiswa',
        ], [
            'nim.unique' => 'Gagal, NIM Sudah ada. Tolong hubungi pemberi link register dengan pesan bahwa NIM sudah ada/sudah pernah magang di PN Malang.',
        ]);
        $kuota = [
            'perdata' => 2,
            'ptsp' => 2,
            'pidana' => 1,
            'pp1' => 7,
            'pp2' => 6,
            'hukum' => 1,
        ];
        // Mendapatkan jumlah mahasiswa per departemen
        $jumlahMahasiswa = Mahasiswa::select('kode_dept', DB::raw('COUNT(*) as jumlah_mahasiswa'))
            ->groupBy('kode_dept')
            ->get()
            ->keyBy('kode_dept');

        // Menghitung kuota tersisa
        $kuotaTersisa = [];
        foreach ($kuota as $kodeDept => $maxKuota) {
            $jumlah = $jumlahMahasiswa->has($kodeDept) ? $jumlahMahasiswa[$kodeDept]->jumlah_mahasiswa : 0;
            $kuotaTersisa[$kodeDept] = $maxKuota - $jumlah;
        }

        // Buat array departemen dengan kuota yang tersisa
        $departemenTersedia = array_filter($kuotaTersisa, function ($kuota) {
            return $kuota > 0; // Hanya ambil yang masih ada kuota
        });

        // Pilih departemen secara acak jika ada yang tersedia
        if (!empty($departemenTersedia)) {
            $kodeDept = array_rand($departemenTersedia); // Pilih kunci acak
        } else {
            // Handle jika tidak ada departemen yang tersedia
            $kodeDept = 'belum';
        }

        $tanggal_mulai_magang = Carbon::createFromFormat('d/m/Y', $request->tanggal_mulai_magang)->format('Y-m-d');
        $tanggal_lahir = Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir)->format('Y-m-d');
        $mahasiswa = new Mahasiswa();
        $mahasiswa->nim = $request->nim;
        $mahasiswa->nama_lengkap = $request->nama_lengkap;
        $mahasiswa->jenis_kelamin = $request->jenis_kelamin;
        $mahasiswa->tempat_lahir = $request->tempat_lahir;
        $mahasiswa->tanggal_lahir = $tanggal_lahir;
        $mahasiswa->alamat_malang = $request->alamat_malang;
        $mahasiswa->no_hp = $request->no_hp;
        $mahasiswa->semester_saat_magang = $request->semester_saat_magang;
        $mahasiswa->ipk_terakhir = $request->ipk_terakhir;
        $mahasiswa->program_studi = $request->program_studi;
        $mahasiswa->jurusan = $request->jurusan;
        $mahasiswa->perguruan_tinggi = $request->perguruan_tinggi;
        $mahasiswa->durasi_magang = $request->durasi_magang;
        $mahasiswa->tanggal_mulai_magang = $tanggal_mulai_magang;
        $mahasiswa->surat_pengantar_magang = $request->surat_pengantar_magang;
        $mahasiswa->proposal_magang = $request->proposal_magang;
        $mahasiswa->foto = $request->foto != '' ? $request->nim . ".png" : '';
        $mahasiswa->password = Hash::make($request->password);
        $mahasiswa->kode_dept = $kodeDept;
        $mahasiswa->status_magang = 'Calon';
        // dd($mahasiswa);
        if ($mahasiswa->save()) {
            if ($request->foto != '') {
                $folderPath = 'public/upload/mahasiswa/';
                $fileName = $request->nim . ".png";
                $request->file('foto')->storeAs($folderPath, $fileName);
            }
            return Redirect::back()->with(['success' => 'Data berhasil disimpan']);
        } else {
            return Redirect::back()->with(['error' => 'Data gagal disimpan']);
        }
        // $nim = $request->nim;
        // $nama_lengkap = $request->nama_lengkap;
        // $program_studi = $request->program_studi;
        // $no_hp = $request->no_hp;
        // $kode_dept = $request->kode_dept;
        // $foto = $request->foto;

        // $data = [
        //     'nim' => $nim,
        //     'nama_lengkap' => $nama_lengkap,
        //     'program_studi' => $program_studi,
        //     'no_hp' => $no_hp,
        //     'kode_dept' => $kode_dept,
        //     'password' => Hash::make('12345'),
        //     'foto' => $foto != '' ? $nim . ".png" : '',
        // ];

        // $simpan = Mahasiswa::create($data);
        // if ($simpan) {
        //     if ($foto != '') {
        //         $folderPath = 'public/upload/mahasiswa/';
        //         $fileName = $nim . ".png";
        //         $request->file('foto')->storeAs($folderPath, $fileName);
        //     }
        //     return Redirect::back()->with(['success' => 'Data berhasil di simpan']);
        // } else {
        //     return Redirect::back()->with(['error' => 'Data gagal di simpan']);
        // }
    }
    public function editmahasiswa(Request $request)
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $mahasiswa = Mahasiswa::with('department')
            ->where('nim', $nim)->first();

        $department = Department::get();
        return view('panelmahasiswa.editmahasiswa', [
            'mahasiswa' => $mahasiswa,
            'department' => $department,
        ]);
    }
    public function updatemahasiswa(Request $request)
    {
        $nim = $request->nim;
        $nama_lengkap = $request->nama_lengkap;
        $jenis_kelamin = $request->jenis_kelamin;
        $tempat_lahir = $request->tempat_lahir;
        $tanggal_lahir = $request->tanggal_lahir;
        $alamat_malang = $request->alamat_malang;
        $no_hp = $request->no_hp;
        $semester_saat_magang = $request->semester_saat_magang;
        $ipk_terakhir = $request->ipk_terakhir;
        $program_studi = $request->program_studi;
        $jurusan = $request->jurusan;
        $perguruan_tinggi = $request->perguruan_tinggi;
        $durasi_magang = $request->durasi_magang;
        $tanggal_mulai_magang = $request->tanggal_mulai_magang;
        $surat_pengantar_magang = $request->surat_pengantar_magang;
        $proposal_magang = $request->proposal_magang;
        $old_foto = $request->old_foto;
        //old password variable fiktif
        $old_password = Auth::guard('mahasiswa')->user()->password;
        $kode_dept = Auth::guard('mahasiswa')->user()->kode_dept;
        // dd($request->foto);
        // dd($request->old_foto);

        if ($request->hasFile('foto')) {
            $foto = $nim . "." . $request->file('foto')->getClientOriginalExtension();

        } else {
            $foto = $old_foto;
        }


        if ($request->filled('password')) {
            $password = bcrypt($request->input('password'));
        } else {
            $password = $old_password;
        }

        $data = [
            // 'nim' => $nim,
            'nama_lengkap' => $nama_lengkap,
            'jenis_kelamin' => $jenis_kelamin,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'alamat_malang' => $alamat_malang,
            'no_hp' => $no_hp,
            'semester_saat_magang' => $semester_saat_magang,
            'ipk_terakhir' => $ipk_terakhir,
            'program_studi' => $program_studi,
            'jurusan' => $jurusan,
            'perguruan_tinggi' => $perguruan_tinggi,
            'durasi_magang' => $durasi_magang,
            'tanggal_mulai_magang' => $tanggal_mulai_magang,
            'surat_pengantar_magang' => $surat_pengantar_magang,
            'proposal_magang' => $proposal_magang,
            'kode_dept' => $kode_dept,
            'password' => $password,
            'foto' => $foto != '' ? $nim . ".png" : '',
        ];

        $update = Mahasiswa::where('nim', $nim)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = 'public/upload/mahasiswa/';
                $folderPathOld = 'public/upload/mahasiswa/' . $old_foto;
                Storage::delete($folderPathOld);
                $fileName = $nim . ".png";
                $request->file('foto')->storeAs($folderPath, $fileName);
            }
            return Redirect::back()->with(['success' => 'Data berhasil di update']);
        } else {
            return Redirect::back()->with(['error' => 'Data gagal di update']);
        }
    }
    public function rekappresensi(Request $request)
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;

        $presensi = Presensi::where('nim', $nim)->orderBy('tgl_presensi', 'desc')
            ->get();

        return view('panelmahasiswa.rekappresensi', [
            'presensi' => $presensi
        ]);
    }
    public function rekapabsensi(Request $request)
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;

        $absensi = Pengajuan::where('nim', $nim)->orderBy('tgl_izin', 'desc')
            ->get();

        return view('panelmahasiswa.rekapabsensi', [
            'presensi' => $absensi
        ]);
    }

    public function beranda(Request $request)
    {

        $tabel = Mahasiswa::where('status_magang', 'Aktif')->orderBy('tanggal_mulai_magang', 'desc')
            ->get();
        $alokasi = Mahasiswa::selectRaw('SUM(IF(status_magang="Aktif",1,0)) as jml_mahasiswa')
            ->first();
        return view('beranda', [
            'tabel' => $tabel,
            'alokasi' => $alokasi
        ]);
    }
    //function tidak aktif
    public function updateStatusMagang()
    {
        // Ambil semua mahasiswa yang belum Selesai
        $mahasiswas = DB::table('mahasiswa')
            ->where('status_magang', '=', 'Aktif')
            ->get();

        foreach ($mahasiswas as $mahasiswa) {
            // Hitung tanggal selesai magang berdasarkan tanggal mulai magang dan durasi magang dalam minggu
            $tanggal_mulai_magang = Carbon::parse($mahasiswa->tanggal_mulai_magang);
            $durasi_minggu = $mahasiswa->durasi_magang;

            // Tanggal selesai magang
            $tanggal_selesai_magang = $tanggal_mulai_magang->addWeeks($durasi_minggu);

            // Cek apakah hari ini sudah melewati tanggal selesai magang
            if (Carbon::now()->greaterThanOrEqualTo($tanggal_selesai_magang)) {
                // Update status_magang menjadi 'Selesai'
                DB::table('mahasiswa')
                    ->where('nim', $mahasiswa->nim)
                    ->update(['status_magang' => 'Selesai']);
            }
        }
    }

    public function updateStatus(Request $request)
    {
        // Cari data mahasiswa berdasarkan NIM
        $mahasiswas = Mahasiswa::get();
        foreach ($mahasiswas as $mahasiswa) {
            if ($mahasiswa && in_array($mahasiswa->status_magang, ['Selesai', 'Blacklist', 'Ditolak'])) {
                // Duplicate data mahasiswa ke tabel riwayat_magang
                RiwayatMagang::create([
                    'nim' => $mahasiswa->nim,
                    'nama_lengkap' => $mahasiswa->nama_lengkap,
                    'jenis_kelamin' => $mahasiswa->jenis_kelamin,
                    'tempat_lahir' => $mahasiswa->tempat_lahir,
                    'tanggal_lahir' => $mahasiswa->tanggal_lahir,
                    'alamat_malang' => $mahasiswa->alamat_malang,
                    'no_hp' => $mahasiswa->no_hp,
                    'semester_saat_magang' => $mahasiswa->semester_saat_magang,
                    'ipk_terakhir' => $mahasiswa->ipk_terakhir,
                    'program_studi' => $mahasiswa->program_studi,
                    'jurusan' => $mahasiswa->jurusan,
                    'perguruan_tinggi' => $mahasiswa->perguruan_tinggi,
                    'durasi_magang' => $mahasiswa->durasi_magang,
                    'tanggal_mulai_magang' => $mahasiswa->tanggal_mulai_magang,
                    'surat_pengantar_magang' => $mahasiswa->surat_pengantar_magang,
                    'proposal_magang' => $mahasiswa->proposal_magang,
                    'foto' => $mahasiswa->foto,
                    'password' => $mahasiswa->password,
                    'kode_dept' => $mahasiswa->kode_dept,
                    'status_magang' => $mahasiswa->status_magang,
                    'alasan_blacklist' => $mahasiswa->alasan_blacklist,
                    'hakim_pembimbing_id' => $mahasiswa->hakim_pembimbing_id,
                ]);
                $mahasiswa->delete();
            }
        }
    }
}
