<?php

namespace App\Services;

use App\Models\Transaction;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Config as LaravelConfig;
use Illuminate\Support\Facades\URL;

class CreateSnapTokenService
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;

        Config::$serverKey = LaravelConfig::get('services.midtrans.server_key');
        Config::$clientKey = LaravelConfig::get('services.midtrans.client_key');
        Config::$isProduction = LaravelConfig::get('services.midtrans.is_production');
        Config::$isSanitized = LaravelConfig::get('services.midtrans.is_sanitized');
        Config::$is3ds = LaravelConfig::get('services.midtrans.is_3ds');
    }

    public function getSnapToken()
    {
        $user = $this->transaction->user;
        $paket = $this->transaction->paket;

        $params = [
            'transaction_details' => [
                'order_id' => $this->transaction->order_id,
                'gross_amount' => (int) $this->transaction->gross_amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $paket->id,
                    'price' => (int) $this->transaction->gross_amount,
                    'quantity' => 1,
                    'name' => $paket->nama_paket,
                ],
            ],
            'notification_url' => URL::to('/midtrans/notification'),
        ];

        return Snap::getSnapToken($params);
    }
}
