<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\KantorController;

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HakimPembimbingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/beranda', [MahasiswaController::class, 'beranda']);


// Posisi mahasiswa tidak login
Route::middleware(['guest:mahasiswa'])->group(function () {
    //presensi login
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);

    //dashboard mahasiswa login
    Route::get('/loginmahasiswa', function () {
        return view('auth.loginmahasiswa');
    })->name('login');
    Route::post('/prosesloginmahasiswa', [AuthController::class, 'prosesloginmahasiswa']);

    //dashboard mahasiswa register
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    Route::post('/prosesregister', [MahasiswaController::class, 'prosesregister'])->name('prosesregister');

});

// Posisi mahasiswa login
Route::middleware(['auth:mahasiswa'])->group(function () {
    //dashboard mahasiswa
    Route::get('/panel/dashboardmahasiswa', [DashboardController::class, 'dashboardmahasiswa']);
    Route::get('/proseslogoutmahasiswa', [AuthController::class, 'proseslogoutmahasiswa']);

    // Edit Profile
    Route::get('/editmahasiswa', [MahasiswaController::class, 'editmahasiswa']);
    Route::post('/updatemahasiswa', [MahasiswaController::class, 'updatemahasiswa']);

    //Rekap Presensi
    Route::get('/rekappresensi', [MahasiswaController::class, 'rekappresensi']);
    Route::get('/rekapabsensi', [MahasiswaController::class, 'rekapabsensi']);

    // Presensi
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

    // Buat Presensi
    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    // Edit Profile
    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('/presensi/{nim}/updateprofile', [PresensiController::class, 'updateprofile']);

    // Histori
    Route::get('/presensi/histori', [PresensiController::class, 'histori']);
    Route::post('/gethistori', [PresensiController::class, 'gethistori']);

    // Izin/Sakit
    Route::get('/presensi/izin', [PresensiController::class, 'izin']);
    Route::get('/presensi/izinadd', [PresensiController::class, 'izinadd']);
    Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin']);

    Route::post('/presensi/cekpengajuanizin', [PresensiController::class, 'cekpengajuanizin']);

    //dashboard panel
    Route::get('/dashboardmahasiswa', [DashboardController::class, 'dashboardmahasiswa']);

});


Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');
    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
});

Route::middleware(['auth:user'])->group(function () {
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);

    // Mahasiswa
    Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
    Route::post('/mahasiswa/store', [MahasiswaController::class, 'store']);
    Route::post('/mahasiswa/edit', [MahasiswaController::class, 'edit']);
    Route::post('/mahasiswa/{nim}/update', [MahasiswaController::class, 'update']);
    Route::delete('/mahasiswa/delete/{nim}', [MahasiswaController::class, 'delete']);

    // Department
    Route::get('/department', [DepartmentController::class, 'index']);
    Route::post('/department/store', [DepartmentController::class, 'store']);
    Route::post('/department/edit', [DepartmentController::class, 'edit']);
    Route::post('/department/{kode_dept}/update', [DepartmentController::class, 'update']);
    Route::delete('/department/destroy/{kode_dept}', [DepartmentController::class, 'destroy']);

    // Kantor 
    // Route::get('/kantor', [KantorController::class, 'index']);
    // Route::get('/kantor/create', [KantorController::class, 'create']);
    // Route::post('/kantor/store', [KantorController::class, 'store']);
    // Route::get('/kantor/edit/{id}', [KantorController::class, 'edit']);
    // Route::post('/kantor/update/{id}', [KantorController::class, 'update']);
    // Route::delete('/kantor/destroy/{id}', [KantorController::class, 'destroy']);

    // Menampilkan semua data hakim pembimbing
    Route::get('/hakim_pembimbing', [HakimPembimbingController::class, 'index'])->name('hakim_pembimbing.index');

    // Menampilkan form untuk menambah hakim pembimbing
    Route::get('/hakim_pembimbing/create', [HakimPembimbingController::class, 'create'])->name('hakim_pembimbing.create');

    // Menyimpan data hakim pembimbing yang baru
    Route::post('/hakim_pembimbing', [HakimPembimbingController::class, 'store'])->name('hakim_pembimbing.store');

    // Menampilkan form untuk mengedit hakim pembimbing
    Route::get('/hakim_pembimbing/{hakimPembimbing}/edit', [HakimPembimbingController::class, 'edit'])->name('hakim_pembimbing.edit');

    // Memperbarui data hakim pembimbing
    Route::put('/hakim_pembimbing/{hakimPembimbing}', [HakimPembimbingController::class, 'update'])->name('hakim_pembimbing.update');

    // Menghapus data hakim pembimbing
    Route::delete('/hakim_pembimbing/{hakimPembimbing}', [HakimPembimbingController::class, 'destroy'])->name('hakim_pembimbing.destroy');

    // Pengajuan (Sakit & Izin)
    //? Sakit  
    Route::get('/pengajuan/sakit', [PengajuanController::class, 's_index']);
    Route::post('/pengajuan/sakit/edit', [PengajuanController::class, 's_edit']);
    Route::post('/pengajuan/sakit/update/{id}', [PengajuanController::class, 's_update']);
    Route::get('/pengajuan/sakit/decline/{id}', [PengajuanController::class, 's_decline']);

    //? Izin  
    Route::get('/pengajuan/izin', [PengajuanController::class, 'i_index']);
    Route::post('/pengajuan/izin/edit', [PengajuanController::class, 'i_edit']);
    Route::post('/pengajuan/izin/update/{id}', [PengajuanController::class, 'i_update']);
    Route::get('/pengajuan/izin/decline/{id}', [PengajuanController::class, 'i_decline']);

    // Presesni 
    Route::get('/presensi/monitoring', [PresensiController::class, 'monitoring']);
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);
    Route::post('/showmaps', [PresensiController::class, 'showmaps']);
    Route::get('/presensi/laporan', [PresensiController::class, 'laporan']);
    Route::post('/presensi/cetaklaporan', [PresensiController::class, 'cetaklaporan']);
    Route::get('/presensi/rekap', [PresensiController::class, 'rekap']);
    Route::post('/presensi/cetakrekap', [PresensiController::class, 'cetakrekap']);
});
