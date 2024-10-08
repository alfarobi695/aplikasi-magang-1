<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'department';
    protected $primaryKey = 'kode_dept';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kode_dept',
        'nama_dept',
    ];

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'kode_dept', 'kode_dept');
    }
    public function riwayat_magang()
    {
        return $this->hasOne(RiwayatMagang::class, 'kode_dept', 'kode_dept');
    }
}
