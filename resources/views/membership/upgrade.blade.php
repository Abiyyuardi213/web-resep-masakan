<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upgrade ke Premium - Dapur Indonesia</title>
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

        .premium-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .premium-icon {
            font-size: 3rem;
            color: #f5b041;
        }

        .btn-upgrade {
            background-color: #f1c40f;
            color: #000;
            font-weight: bold;
            border: none;
        }

        .btn-upgrade:hover {
            background-color: #d4ac0d;
        }
    </style>
</head>
<body>

@include('include.navbarUser')

<main>
    <div class="container my-4">
        <div class="text-center mb-5">
            <i class="fas fa-crown premium-icon"></i>
            <h2 class="fw-bold mt-3">Pilih Paket Membership</h2>
            <p class="text-muted">Nikmati fitur eksklusif dengan paket yang sesuai kebutuhan Anda.</p>
        </div>

        <div class="row">
            @foreach($pakets as $paket)
                <div class="col-md-4">
                    <div class="premium-card text-center">
                        <h4 class="fw-bold">{{ $paket->nama_paket }}</h4>
                        <p class="text-muted mb-2">Durasi: {{ $paket->durasi_bulan }} bulan</p>
                        <p class="fs-5 fw-semibold">Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>

                        <form action="{{ route('membership.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="paket_id" value="{{ $paket->id }}">
                            <button type="submit" class="btn btn-upgrade btn-sm px-4 py-2 rounded-pill shadow">
                                <i class="fas fa-crown me-1"></i> Pilih Paket
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        @if($pakets->isEmpty())
            <div class="alert alert-warning text-center mt-4">
                Belum ada paket membership yang tersedia.
            </div>
        @endif
    </div>
</main>

@include('include.footer')

@if(session('snap_token'))
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    snap.pay('{{ session('snap_token') }}', {
        onSuccess: function(result) {
            alert("Pembayaran berhasil!");
            location.href = '/homepage';
        },
        onPending: function(result) {
            alert("Menunggu pembayaran...");
        },
        onError: function(result) {
            alert("Terjadi kesalahan saat pembayaran.");
        },
        onClose: function() {
            alert("Anda menutup popup tanpa menyelesaikan pembayaran");
        }
    });
});
</script>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
