<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nama_kategori',
        'gambar_kategori',
    ];

    protected static function booted()
    {
        static::creating(function ($kategori) {
            if (!$kategori->id) {
                $kategori->id = (string) Str::uuid();
            }
        });
    }

    public static function createKategori(array $data)
    {
        return self::create([
            'nama_kategori' => $data['nama_kategori'],
            'gambar_kategori' => $data['gambar_kategori'],
        ]);
    }

    public function updateKategori(array $data)
    {
        $this->update([
            'nama_kategori' => $data['nama_kategori'],
            'gambar_kategori' => $data['gambar_kategori'],
        ]);
    }

    public function deleteKategori()
    {
        return $this->delete();
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'kategori_id');
    }
}
