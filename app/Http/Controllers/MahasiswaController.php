<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $nama_lengkap = $request->nama_karyawan;
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
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $foto = $request->foto;

        $data = [
            'nim' => $nim,
            'nama_lengkap' => $nama_lengkap,
            'jabatan' => $jabatan,
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
        $jabatan = $request->jabatan;
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
            'jabatan' => $jabatan,
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
}
