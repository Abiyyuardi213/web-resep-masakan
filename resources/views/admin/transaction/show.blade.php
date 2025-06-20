<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - Dapur Indonesia</title>
    <link rel="icon" href="{{ asset('image/icondapur.jpg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .info-label {
            font-weight: 600;
            color: #555;
        }
        .badge-status {
            font-size: 0.9rem;
            padding: 0.4em 0.7em;
            border-radius: 10px;
        }
        .badge-settlement { background-color: #28a745; color: white; }
        .badge-pending { background-color: #ffc107; color: black; }
        .badge-default { background-color: #6c757d; color: white; }
        .card-icon {
            font-size: 1.3rem;
            color: #17a2b8;
            margin-right: 0.5rem;
        }
        .payload-box {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            max-height: 300px;
            overflow: auto;
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('include.navbarSistem')
    @include('include.sidebar')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h1 class="m-0"><i class="fas fa-file-invoice-dollar text-primary"></i> Detail Transaksi</h1>
                    <a href="{{ route('admin.transaction.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><span class="info-label"><i class="fas fa-receipt card-icon"></i>Order ID:</span> {{ $transaction->order_id }}</p>
                                <p><span class="info-label"><i class="fas fa-user card-icon"></i>Nama User:</span> {{ $transaction->user->name ?? '-' }}</p>
                                <p><span class="info-label"><i class="fas fa-envelope card-icon"></i>Email:</span> {{ $transaction->user->email ?? '-' }}</p>
                                <p><span class="info-label"><i class="fas fa-box card-icon"></i>Paket:</span> {{ $transaction->paket->nama_paket ?? '-' }}</p>
                                <p><span class="info-label"><i class="fas fa-clock card-icon"></i>Durasi:</span> {{ $transaction->paket->durasi_bulan ?? '-' }} bulan</p>
                            </div>
                            <div class="col-md-6">
                                <p><span class="info-label"><i class="fas fa-money-bill card-icon"></i>Harga:</span> Rp {{ number_format($transaction->gross_amount, 0, ',', '.') }}</p>
                                <p><span class="info-label"><i class="fas fa-check-circle card-icon"></i>Status:</span>
                                    <span class="badge badge-status
                                        {{ $transaction->transaction_status === 'settlement' ? 'badge-settlement' :
                                           ($transaction->transaction_status === 'pending' ? 'badge-pending' : 'badge-default') }}">
                                        {{ ucfirst($transaction->transaction_status) }}
                                    </span>
                                </p>
                                <p><span class="info-label"><i class="fas fa-credit-card card-icon"></i>Metode Pembayaran:</span> {{ $transaction->payment_type ?? '-' }}</p>
                                <p><span class="info-label"><i class="fas fa-barcode card-icon"></i>Transaction ID:</span> {{ $transaction->transaction_id ?? '-' }}</p>
                                <p><span class="info-label"><i class="fas fa-calendar-alt card-icon"></i>Tanggal:</span> {{ $transaction->created_at->format('d M Y H:i') }}</p>
                                <p><span class="info-label"><i class="fas fa-sticky-note card-icon"></i>Catatan:</span> {{ $transaction->notes ?? '-' }}</p>
                            </div>
                        </div>

                        @if ($transaction->payload)
                            <div class="mt-4">
                                <h5><i class="fas fa-code text-info"></i> Payload Midtrans</h5>
                                <div class="payload-box">
<pre>{{ json_encode($transaction->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('include.footerSistem')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
