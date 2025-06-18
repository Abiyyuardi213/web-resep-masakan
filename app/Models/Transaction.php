<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'order_id',
        'payment_type',
        'transaction_status',
        'gross_amount',
        'transaction_id',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($transaction) {
            if (!$transaction->id) {
                $transaction->id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paket()
    {
        return $this->belongsTo(PaketMembership::class, 'paket_id');
    }
}
