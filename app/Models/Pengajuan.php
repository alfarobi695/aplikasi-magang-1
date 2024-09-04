<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_izin';

    protected $fillable = [
        'nim',
        'tgl_izin',
        'status',
        'keterangan',
        'status_approved',
    ];


    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function scopeSearch(
        $query,
        $dari = '',
        $sampai = '',
        $nim = '',
        $nama_karyawan = '',
        $status_approved = '',
    ) {
        $query
            ->when($dari && $sampai, function ($query) use ($dari, $sampai) {
                return $query->whereBetween('tgl_izin', [$dari, $sampai]);
            })
            ->when($nim, function ($query, $nim) {
                return $query->where('nim', 'LIKE', "%$nim%");
            })
            ->when($nama_karyawan, function ($query, $nama_karyawan) {
                // Pastikan bahwa 'mahasiswa' adalah nama relasi pada model Pengajuan
                return $query->whereHas('mahasiswa', function ($q) use ($nama_karyawan) {
                    $q->where('nama_lengkap', 'LIKE', "%$nama_karyawan%");
                });
            })
            ->when(true, function ($query) use ($status_approved) {
                if ($status_approved === '0' || $status_approved === 0) {
                    return $query->where('status_approved', $status_approved);
                } elseif ($status_approved == '') {
                } else {
                    // Hanya mencari jika nilai $status_approved tidak nol
                    return $query->where('status_approved', $status_approved);
                }
            });
    }
}
