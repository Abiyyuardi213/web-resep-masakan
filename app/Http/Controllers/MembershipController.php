<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Models\Transaction;
use App\Models\User;
use App\Models\PaketMembership;
use Illuminate\Support\Facades\Config as LaravelConfig;
use App\Services\CreateSnapTokenService;

class MembershipController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = LaravelConfig::get('services.midtrans.server_key');
        Config::$clientKey = LaravelConfig::get('services.midtrans.client_key');
        Config::$isProduction = LaravelConfig::get('services.midtrans.is_production');
        Config::$isSanitized = LaravelConfig::get('services.midtrans.is_sanitized');
        Config::$is3ds = LaravelConfig::get('services.midtrans.is_3ds');
    }

    public function index()
    {
        $pakets = PaketMembership::where('paket_status', 1)->get();
        return view('membership.upgrade', compact('pakets'));
    }

    public function process(Request $request)
    {
        $user = Auth::user();
        $paket = PaketMembership::findOrFail($request->paket_id);
        $usernameSlug = strtolower(preg_replace('/\s+/', '', $user->name));
        $orderId = 'PREM-' . strtoupper($usernameSlug) . '-' . strtoupper(uniqid());
        $grossAmount = $paket->harga;

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'paket_id' => $paket->id,
            'payment_type' => 'pending',
            'transaction_status' => 'pending',
            'gross_amount' => $grossAmount,
            'transaction_id' => null,
            'payload' => null,
        ]);

        // Gunakan service
        $snapToken = (new CreateSnapTokenService($transaction))->getSnapToken();

        return view('membership.payment', compact('snapToken'));
    }

    public function handleNotification(Request $request)
    {
        // Gunakan raw body karena Midtrans kirim JSON
        $json = json_decode($request->getContent());

        Log::info('📩 Midtrans Callback Masuk', ['payload' => $json]);

        if (!$json) {
            return response()->json(['message' => 'Invalid JSON'], 400);
        }

        $orderId = $json->order_id ?? null;
        $status = $json->transaction_status ?? null;
        $paymentType = $json->payment_type ?? null;
        $transactionId = $json->transaction_id ?? null;
        $grossAmount = $json->gross_amount ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Missing order ID'], 400);
        }

        $transaction = Transaction::where('order_id', $orderId)->first();

        if (!$transaction) {
            Log::warning("❌ Transaksi dengan order_id {$orderId} tidak ditemukan.");
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->update([
            'payment_type' => $paymentType,
            'transaction_status' => $status,
            'transaction_id' => $transactionId,
            'gross_amount' => $grossAmount,
            'payload' => json_encode($json),
        ]);

        if (in_array($status, ['settlement', 'capture'])) {
            $user = $transaction->user;
            if ($user && !$user->is_member) {
                $user->is_member = 1;
                $user->save();

                Log::info("✅ User {$user->name} berhasil di-upgrade ke MEMBER");
            }
        }

        return response()->json(['message' => 'Notification handled']);
    }

    public function checkout(Request $request)
    {
        $paket = PaketMembership::findOrFail($request->paket_id);
        $user = Auth::user();

        $usernameSlug = strtolower(preg_replace('/\s+/', '', $user->name));
        $orderId = 'PREM-' . strtoupper($usernameSlug) . '-' . strtoupper(uniqid());

        return view('membership.checkout', compact('paket', 'user', 'orderId'));
    }
}
