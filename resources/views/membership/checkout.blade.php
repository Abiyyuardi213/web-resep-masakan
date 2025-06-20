<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Konfirmasi Pembayaran - Dapur Indonesia</title>
    <link rel="icon" href="{{ asset('image/icondapur.jpg') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Nunito:wght@300;600;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #fffdf7;
        }

        body {
            display: flex;
            flex-direction: column;
            padding-top: 90px;
        }

        main {
            flex: 1;
        }

        .checkout-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,0.05);
            padding: 2.5rem;
        }

        .premium-icon {
            font-size: 3rem;
            color: #f5b041;
        }

        .btn-bayar {
            background-color: #28a745;
            color: #fff;
            font-weight: bold;
            border: none;
        }

        .btn-bayar:hover {
            background-color: #218838;
        }

        .label {
            font-weight: 600;
            color: #555;
        }
    </style>
</head>
<body>

@include('include.navbarUser')

<main>
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8 checkout-card">
                <div class="text-center mb-4">
                    <i class="fas fa-receipt premium-icon"></i>
                    <h3 class="fw-bold mt-3">Konfirmasi Pembayaran</h3>
                    <p class="text-muted">Periksa kembali detail pesanan Anda sebelum melanjutkan pembayaran.</p>
                </div>

                <div class="mb-4">
                    <div class="row mb-2">
                        <div class="col-6 label">Nama Paket:</div>
                        <div class="col-6 text-end">{{ $paket->nama_paket }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 label">Durasi:</div>
                        <div class="col-6 text-end">{{ $paket->durasi_bulan }} bulan</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 label">Harga:</div>
                        <div class="col-6 text-end">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 label">Nama Pengguna:</div>
                        <div class="col-6 text-end">{{ $user->name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 label">Kode Transaksi:</div>
                        <div class="col-6 text-end text-primary">{{ $orderId }}</div>
                    </div>
                </div>

                <form action="{{ route('membership.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-bayar btn-lg px-5 py-2 rounded-pill shadow">
                            <i class="fas fa-wallet me-2"></i> Lanjut Bayar
                        </button>
                        <a href="{{ route('membership.index') }}" class="btn btn-outline-secondary ms-3 rounded-pill px-4 py-2">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@include('include.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
