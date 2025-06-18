<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaketMembership extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'paket_membership';

    protected $fillable = ['id', 'nama_paket', 'durasi_bulan', 'harga'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public static function createPaket($data)
    {
        return self::create([
            'nama_paket' => $data['nama_paket'],
            'durasi_bulan' => $data['durasi_bulan'],
            'harga' => $data['harga'],
        ]);
    }

    public function updatePaket($data)
    {
        $this->update([
            'nama_paket' => $data['nama_paket'],
            'durasi_bulan' => $data['durasi_bulan'] ?? $this->durasi_bulan,
            'harga' => $data['harga'] ?? $this->harga,
        ]);
    }

    public function deletePaket()
    {
        return $this->delete();
    }

    public function toggleStatus()
    {
        $this->status = !$this->status;
        $this->save();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'paket_id');
    }
}
