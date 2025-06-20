<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        Log::info('Midtrans Callback Diterima:', $request->all());

        $serverKey = 'SB-Mid-server-KdwIUo1X21W-XYb-W_bqBcuu';
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

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;

        Log::info("Transaksi $orderId status: $transactionStatus");

        return response()->json(['message' => 'Callback diterima']);
    }
}
