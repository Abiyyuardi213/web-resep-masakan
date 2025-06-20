<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Services\CreateSnapTokenService;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'paket'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.transaction.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'paket'])->findOrFail($id);
        return view('admin.transaction.show', compact('transaction'));
    }

    public function payment($id)
    {
        $transaksi = Transaction::findOrFail($id);

        if (!$transaksi->snap_token) {
            $midtrans = new CreateSnapTokenService($transaksi);
            $snapToken = $midtrans->getSnapToken();

            $transaksi->snap_token = $snapToken;
            $transaksi->save();
        } else {
            $snapToken = $transaksi->snap_token;
        }

        $user = auth()->user();
        $paket = $transaksi->paket;

        $durasiBulan = $paket->durasi ?? 1; // fallback default
        $user->status = 'premium';
        $user->premium_expired_at = now()->addMonths($durasiBulan);
        $user->save();

        return view('payment', compact('snapToken'));
    }
}
