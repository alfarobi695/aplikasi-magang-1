<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{

    public function index(Request $request)
    {
        $nama_lengkap = $request->nama_mahasiswa;
        $kode_dept = $request->kode_dept;

        $mahasiswa = Mahasiswa::with('department')
            ->search($nama_lengkap, $kode_dept)
            ->orderBy('nama_lengkap')
            ->paginate(10);

        $department = Department::get();

        return view('mahasiswa.index', [
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
        return view('mahasiswa.edit', [
            'mahasiswa' => $mahasiswa,
            'department' => $department,
        ]);
    }

    public function update($nim, Request $request)
    {
        $nim = $request->nim;
        $nama_lengkap = $request->nama_lengkap;
        $program_studi = $request->program_studi;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $old_foto = $request->old_foto;

        if ($request->hasFile('foto')) {
            $foto = $nim . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }

        $data = [
            'nama_lengkap' => $nama_lengkap,
            'program_studi' => $program_studi,
            'no_hp' => $no_hp,
            'kode_dept' => $kode_dept,
            'password' => Hash::make('12345'),
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
        $mahasiswa = new Mahasiswa();
        $mahasiswa->nim = $request->nim;
        $mahasiswa->nama_lengkap = $request->nama_lengkap;
        $mahasiswa->jenis_kelamin = $request->jenis_kelamin;
        $mahasiswa->tempat_lahir = $request->tempat_lahir;
        $mahasiswa->tanggal_lahir = $request->tanggal_lahir;
        $mahasiswa->alamat_malang = $request->alamat_malang;
        $mahasiswa->no_hp = $request->no_hp;
        $mahasiswa->semester_saat_magang = $request->semester_saat_magang;
        $mahasiswa->ipk_terakhir = $request->ipk_terakhir;
        $mahasiswa->program_studi = $request->program_studi;
        $mahasiswa->jurusan = $request->jurusan;
        $mahasiswa->perguruan_tinggi = $request->perguruan_tinggi;
        $mahasiswa->durasi_magang = $request->durasi_magang;
        $mahasiswa->tanggal_mulai_magang = $request->tanggal_mulai_magang;
        $mahasiswa->surat_pengantar_magang = $request->surat_pengantar_magang;
        $mahasiswa->proposal_magang = $request->proposal_magang;
        $mahasiswa->foto = $request->foto != '' ? $request->nim . ".png" : '';
        $mahasiswa->password = Hash::make($request->password);
        $mahasiswa->kode_dept = 'IT';
        $mahasiswa->status_magang = 'Calon';

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
    public function editmahasiswa(Request $request){
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
        $old_password =Auth::guard('mahasiswa')->user()->password;
        $kode_dept =Auth::guard('mahasiswa')->user()->kode_dept;
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
            'kode_dept'=> $kode_dept,
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
}
