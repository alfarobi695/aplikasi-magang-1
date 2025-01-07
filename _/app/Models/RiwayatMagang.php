<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatMagang extends Model
{
    use HasFactory;

    protected $table = 'riwayat_mahasiswa';
    protected $primaryKey = 'id';

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

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'kode_dept', 'kode_dept');
    }
}
