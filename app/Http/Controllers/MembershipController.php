<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
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
        $user = Auth::user();
        $grossAmount = 50000;

        $orderId = 'PREM-' . uniqid();

        Transaction::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'payment_type' => 'pending',
            'transaction_status' => 'pending',
            'gross_amount' => $grossAmount,
            'transaction_id' => null,
            'payload' => null,
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return view('membership.payment', compact('snapToken'));
    }

    public function handleNotification(Request $request)
    {
        Log::info('📩 Midtrans Callback Masuk', ['payload' => $request->all()]);

        $notif = new Notification();

        $orderId = $notif->order_id;
        $status = $notif->transaction_status;
        $paymentType = $notif->payment_type;
        $transactionId = $notif->transaction_id;
        $grossAmount = $notif->gross_amount;

        $userId = $this->getUserIdFromOrderId($orderId);

        $transaction = Transaction::updateOrCreate(
            ['order_id' => $orderId],
            [
                'user_id' => $userId,
                'payment_type' => $paymentType,
                'transaction_status' => $status,
                'transaction_id' => $transactionId,
                'gross_amount' => $grossAmount,
                'payload' => json_encode($notif),
            ]
        );

        if (in_array($status, ['settlement', 'capture'])) {
            $user = User::find($userId);
            if ($user && !$user->is_premium) {
                $user->is_premium = true;
                $user->save();
                Log::info("✅ User {$user->name} berhasil di-upgrade ke Premium");
            }
        }

        return response()->json(['message' => 'Notification handled']);
    }

    private function getUserIdFromOrderId($orderId)
    {
        // Format: PREMIUM-<user_id>-<timestamp>
        $parts = explode('-', $orderId);
        return $parts[1] ?? null;
    }
}
