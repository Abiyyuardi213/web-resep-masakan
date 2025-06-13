<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

class MembershipController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function index()
    {
        return view('membership.upgrade');
    }

    public function process()
    {
        $user = auth()->user();
        $orderId = 'ORDER-' . Str::uuid();

        $user->order_id = $orderId;
        $user->save();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => 50000,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return view('membership.payment', compact('snapToken'));
    }

    public function callback(Request $request)
    {
        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $orderId = $notif->order_id;

        if (in_array($transaction, ['capture', 'settlement'])) {
            $user = User::where('order_id', $orderId)->first();

            if ($user && $user->is_member == 0) {
                $user->is_member = 1;
                $user->order_id = null;
                $user->save();
            }
        }

        return response()->json(['message' => 'Callback processed'], 200);
    }
}
