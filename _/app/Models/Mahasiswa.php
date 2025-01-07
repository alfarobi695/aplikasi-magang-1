<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Mahasiswa extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_malang',
        'no_hp',
        'semester_saat_magang',
        'ipk_terakhir',
        'program_studi',
        'jurusan',
        'perguruan_tinggi',
        'tanggal_mulai_magang',
        'surat_pengantar_magang',
        'proposal_magang',
        'status_magang',
        'foto',
        'password',
        'kode_dept',
        'alasan_blacklist',
        'hakim_pembimbing_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'kode_dept', 'kode_dept');
    }

    public function hakim_pembimbing()
    {
        return $this->belongsTo(HakimPembimbing::class, 'hakim_pembimbing_id', 'id');
    }
    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'nim', 'nim');
    }
    public function riwayat_magang()
    {
        return $this->hasMany(RiwayatMagang::class, 'nim', 'nim');
    }
    public function scopeSearch($query, $nama_lengkap = '', $kode_dept = '')
    {
        $query
            ->when($nama_lengkap, function ($query, $nama_lengkap) {
                return $query->where('nama_lengkap', 'LIKE', "%$nama_lengkap%");
            })
            ->when($kode_dept, function ($query, $kode_dept) {
                return $query->where('kode_dept', $kode_dept);
            });
    }
}
