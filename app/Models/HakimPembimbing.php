<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HakimPembimbing extends Model
{
    use HasFactory;
    protected $table = 'hakim_pembimbing';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_hakim',
        'nip',
        'created_at',
        'updated_at'
    ];
}
