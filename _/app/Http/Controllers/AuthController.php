<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\RiwayatMagang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
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
                    ->update(['status_magang' => 'Selesai', 'kode_dept' => 'nonaktif']);
            }
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
        return view('auth.login');
    }
    public function proseslogin(Request $request)
    {
        $credentials = ['nim' => $request->nim, 'password' => $request->password];

        if (Auth::guard('mahasiswa')->attempt($credentials)) {
            // Jika login berhasil, cek status_magang
            $mahasiswa = Auth::guard('mahasiswa')->user();

            if ($mahasiswa->status_magang === 'Aktif') {
                return redirect()->to('/dashboard');
            } else {
                Auth::guard('mahasiswa')->logout(); // Logout otomatis jika status magang tidak aktif
                return redirect()->back()->with(['warning' => 'Status magang tidak aktif. Anda tidak dapat masuk']);
            }
        } else {
            return redirect()->back()->with(['warning' => 'nim / Password Salah']);
        }
    }

    public function proseslogout()
    {
        if (Auth::guard('mahasiswa')->check()) {
            Auth::guard('mahasiswa')->logout();
            return redirect()->to('/');
        }
    }

    public function proseslogoutadmin()
    {
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
            return redirect()->to('/panel');
        }
    }

    public function prosesloginadmin(Request $request)
    {
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->to('/panel/dashboardadmin');
        } else {
            return redirect('/panel')->with(['warning' => 'Email / Password Salah']);
        }
    }
    public function prosesloginmahasiswa(Request $request)
    {
        if (Auth::guard('mahasiswa')->attempt(['nim' => $request->nim, 'password' => $request->password])) {
            return redirect()->to('/dashboardmahasiswa');
        } else {
            return redirect('/loginmahasiswa')->with(['warning' => 'NIM / Password Salah']);
        }
    }
    public function proseslogoutmahasiswa()
    {
        if (Auth::guard('mahasiswa')->check()) {
            Auth::guard('mahasiswa')->logout();
            return redirect()->to('/loginmahasiswa');
        }
    }
}
