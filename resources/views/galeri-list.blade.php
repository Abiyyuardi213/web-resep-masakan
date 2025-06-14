<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Galeri - Dapur Indonesia</title>
    <link rel="icon" type="image/png" href="{{ asset('image/icondapur.jpg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Nunito:wght@300;600;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet" />

    <style>
        body {
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            scroll-behavior: smooth;
            margin: 0;
            padding: 0;
        }

        .navbar-brand {
            font-family: 'Pacifico', cursive;
            font-size: 1.8rem;
        }

        .floating-navbar {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #ffffff;
            border-radius: 20px;
            padding: 0.5rem 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            z-index: 1050;
            width: auto;
            max-width: 90%;
        }

        .section-title {
            font-family: 'Pacifico', cursive;
            font-size: 2.5rem;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .galeri-description {
            max-height: 40px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
@include('include.navbar')

{{-- Galeri Content --}}
<section class="container my-5 pt-5">
    <div class="text-center mt-5 pt-5">
        <h1 class="section-title text-warning">Galeri</h1>
        <p class="text-muted lead">Momen spesial dan kegiatan Dapur Indonesia</p>
    </div>

    <div class="row mt-4">
        @forelse($galeris as $galeri)
            <div class="col-md-4 mb-4">
                <div class="position-relative rounded overflow-hidden shadow-sm" style="height: 250px;">
                    <img src="{{ asset('uploads/galeri/' . $galeri->gambar) }}" class="w-100 h-100 object-fit-cover" alt="{{ $galeri->judul }}">

                    <div class="position-absolute bottom-0 start-0 w-100 text-white p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0));">
                        <h5 class="mb-1 fw-bold">{{ $galeri->judul }}</h5>
                        <p class="mb-0 small galeri-description">{{ $galeri->deskripsi }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada galeri yang ditambahkan.</p>
            </div>
        @endforelse
    </div>
</section>

{{-- Footer --}}
@include('include.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
