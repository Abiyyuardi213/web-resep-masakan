<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        /** @var \App\Models\User $user */
        $user = Auth::user();
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
        // Validasi Signature
        $serverKey = config('midtrans.server_key');
        $expectedSignature = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($request->signature_key !== $expectedSignature) {
            Log::warning('Signature tidak cocok!', [
                'dikirim' => $request->signature_key,
                'diharapkan' => $expectedSignature,
            ]);
            return response()->json(['message' => 'Signature tidak valid'], 403);
        }

        $notif = new Notification();
        $transaction = $notif->transaction_status;
        $orderId = $notif->order_id;

        Log::info("Notifikasi Midtrans diterima", [
            'order_id' => $orderId,
            'status' => $transaction,
        ]);

        if (in_array($transaction, ['capture', 'settlement'])) {
            $user = User::where('order_id', $orderId)->first();

            if ($user && $user->is_member == 0) {
                $user->is_member = 1;
                $user->order_id = null;
                $user->save();

                Log::info("Membership user {$user->name} berhasil diaktifkan.");
            }
        }

        return response()->json(['message' => 'Callback diproses'], 200);
    }
}
