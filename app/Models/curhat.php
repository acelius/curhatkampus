<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Curhat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_curhat',
        'user_id',
        'nim',
        'nama_lengkap',
        'email',
        'nomor_hp',
        'kategori',
        'lokasi',
        'judul',
        'detail',
        'lampiran_path',
        'lampiran_original_name',
        'lampiran_mime',
        'lampiran_size',
        'status',
        'catatan_admin',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}