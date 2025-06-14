<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Galeri extends Model
{
    protected $table = 'galeris';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'judul',
        'deskripsi',
        'gambar',
    ];

    protected static function booted()
    {
        static::creating(function ($galeri) {
            if (!$galeri->id) {
                $galeri->id = (string) Str::uuid();
            }
        });
    }

    public static function createGambar($data)
    {
        return self::create([
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'],
            'gambar' => $data['gambar'],
        ]);
    }

    public function updateGambar($data)
    {
        return $this->update([
            'judul' => $data['judul'] ?? $this->judul,
            'deskripsi' => $data['deskripsi'] ?? $this->deskripsi,
            'gambar' => $data['gambar'] ?? $this->gambar,
        ]);
    }

    public function deleteGambar()
    {
        return $this->delete();
    }
}
