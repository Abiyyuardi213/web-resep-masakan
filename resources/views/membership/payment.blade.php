<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran - Dapur Indonesia</title>
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

        .payment-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,0.05);
            padding: 2rem;
            text-align: center;
        }

        .loading-icon {
            font-size: 4rem;
            color: #f1c40f;
        }
    </style>
</head>
<body>

    @include('include.navbarUser')

    <main>
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-6 payment-card">
                    <div class="mb-4">
                        <i class="fas fa-spinner loading-icon fa-spin"></i>
                        <h3 class="fw-bold mt-3">Menyiapkan Pembayaran...</h3>
                        <p class="text-muted">Harap tunggu, Anda akan dialihkan ke halaman pembayaran Midtrans.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('include.footer')

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    alert("Pembayaran berhasil!");
                    window.location.href = "/homepage";
                },
                onPending: function (result) {
                    alert("Menunggu pembayaran...");
                },
                onError: function (result) {
                    alert("Terjadi kesalahan saat pembayaran.");
                },
                onClose: function () {
                    alert("Anda menutup popup tanpa menyelesaikan pembayaran.");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
