<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dapur Indonesia</title>
    <link rel="icon" type="image/png" href="{{ asset('image/icondapur.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Nunito:wght@300;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            scroll-behavior: smooth;
            margin: 0;
            padding: 0;
        }

        .carousel-caption h1 {
            font-family: 'Pacifico', cursive;
            font-size: 3rem;
        }

        .hover-shadow {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .vh-100 {
            height: 100vh;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .custom-card {
            background-color: #f9f9f9;
            border-radius: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        #toggleSidebar {
            padding: 0.5rem 1rem;
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1050;
        }

        #sidebar {
            width: 300px;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }
        .carousel-wrapper {
            height: 400px;
            overflow: hidden;
        }

        .carousel-inner,
        .carousel-item {
            height: 100%;
        }

        .carousel-item > img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .carousel-item {
            height: 100%;
        }


        .carousel-caption h1 {
            font-size: 2rem;
        }

        .carousel-caption p {
            font-size: 1rem;
        }
    </style>
</head>
<body>

    @include('include.navbarUser')

    <!-- Tombol Toggle Sidebar -->
    <button id="toggleSidebar" class="btn btn-outline-secondary shadow-sm">
        <i class="fas fa-bars"></i> Menu
    </button>

    <!-- Hero Section dengan Grid Layout -->
    <section class="container pt-5 mt-5 pb-5">
        <div class="row g-4">
            <!-- Kolom Kiri: Carousel dan Info Singkat -->
            <div class="col-lg-8">
                <!-- Carousel -->
                <div class="carousel-wrapper mb-3">
                    <div id="carouselExample" class="carousel slide carousel-fade h-100" data-bs-ride="carousel">
                        <div class="carousel-inner h-100 rounded-4 overflow-hidden shadow">
                            @foreach ([
                                ['image' => 'slide1.jpg', 'title' => 'Selamat Datang di Dapur Indonesia', 'desc' => 'Temukan berbagai resep nusantara yang menggoda selera'],
                                ['image' => 'slide2.jpg', 'title' => 'Resep Masakan Nusantara', 'desc' => 'Setiap masakan membawa cerita dan kenangan'],
                                ['image' => 'slide3.jpg', 'title' => 'Inspirasi Dapur Anda', 'desc' => 'Resep inovatif untuk semua kesempatan'],
                            ] as $index => $slide)
                                <div class="carousel-item position-relative {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('image/' . $slide['image']) }}"
                                        class="d-block w-100 h-100"
                                        alt="Slide {{ $index + 1 }}">
                                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-3 px-3 py-2">
                                        <h1 class="fw-bold">{{ $slide['title'] }}</h1>
                                        <p>{{ $slide['desc'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                @if(Auth::check() && Auth::user()->is_member)
                    <!-- Card Premium Member -->
                    <div class="bg-light rounded-4 shadow-sm p-4 h-100 text-center border border-warning">
                        <div class="mb-3">
                            <div class="badge bg-warning text-dark px-4 py-2 fs-5 rounded-pill shadow-sm d-inline-flex align-items-center gap-2">
                                <i class="bi bi-star-fill fs-5"></i> <strong>Premium Member</strong>
                            </div>
                        </div>

                        <h4 class="fw-bold text-warning">🎉 Terima Kasih Telah Menjadi Member Premium!</h4>
                        <p class="text-muted">Nikmati akses penuh ke seluruh fitur dan resep spesial dari Dapur Indonesia.</p>

                        <ul class="list-unstyled text-muted text-start mt-3">
                            <li>🌟 Akses eksklusif ke resep premium</li>
                            <li>💾 Simpan dan kelola resep favorit</li>
                            <li>👩‍🍳 Bagikan resep kreasi pribadi</li>
                            <li>🏆 Ikut serta dalam lomba masak</li>
                            <li>🛠 Bebas iklan & pengalaman lebih cepat</li>
                        </ul>

                        <div class="mt-4">
                            <a href="{{ url('/dashboard-user') }}" class="btn btn-outline-warning w-100 fw-semibold">
                                Jelajahi Resep Premium
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Card Ajakan Upgrade -->
                    <div class="bg-warning-subtle rounded-4 shadow-sm p-4 h-100">
                        <div class="text-center mb-3">
                            <div class="badge bg-secondary text-white px-4 py-2 fs-5 rounded-pill shadow-sm d-inline-flex align-items-center gap-2">
                                <i class="bi bi-person-fill fs-5"></i> <strong>Free Member</strong>
                            </div>
                        </div>

                        <h4 class="fw-bold text-warning text-center">👥 Membership</h4>
                        <p class="text-muted text-center">Bergabunglah menjadi anggota Dapur Indonesia dan nikmati:</p>
                        <ul class="list-unstyled text-muted">
                            <li>✔ Akses penuh ke ribuan resep</li>
                            <li>✔ Simpan resep favorit Anda</li>
                            <li>✔ Bagikan resep kreasi sendiri</li>
                            <li>✔ Ikuti event dan kompetisi masak</li>
                        </ul>
                        <a href="{{ url('/upgrade') }}" class="btn btn-warning w-100 fw-semibold mt-3">Daftar Sekarang</a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <div class="container my-5">
        <div class="row g-4 text-center">
            @foreach([
                ['icon' => 'fas fa-user', 'title' => 'Profil Saya', 'btn' => 'Lihat', 'url' => '#'],
                ['icon' => 'fas fa-shopping-basket', 'title' => 'Pesanan', 'btn' => 'Lihat', 'url' => '#'],
                ['icon' => 'fas fa-bell', 'title' => 'Notifikasi', 'btn' => 'Cek', 'url' => '#'],
                ['icon' => 'fas fa-plus-circle', 'title' => 'Ajukan Resep', 'btn' => 'Buat', 'url' => '#'],
            ] as $card)
                <div class="col-md-6 col-lg-3">
                    <div class="card custom-card h-100 text-center shadow-sm border-0 hover-shadow">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                            <i class="{{ $card['icon'] }} text-primary mb-3" style="font-size: 2.5rem;"></i>
                            <h5 class="fw-semibold mb-3">{{ $card['title'] }}</h5>
                            <a href="{{ $card['url'] }}" class="btn btn-outline-primary btn-sm rounded-pill px-4 mt-auto">{{ $card['btn'] }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Sidebar Kanan -->
    <div id="sidebar" class="position-fixed top-0 end-0 h-100 bg-white shadow-lg p-4 z-2 overflow-auto">
        <button id="closeSidebar" class="btn btn-danger mb-3"><i class="fas fa-times"></i> Tutup</button>

        {{-- Profil Pengguna --}}
        <div class="d-flex align-items-center mb-4">
            <img src="{{ Auth::user()->profile_picture ? asset('uploads/profile/' . Auth::user()->profile_picture) : asset('image/default-avatar.png') }}" alt="Profil" class="rounded-circle me-3" width="60" height="60">
            <div>
                <h6 class="mb-0">{{ Auth::user()->name ?? 'Nama Pengguna' }}</h6>
                <small class="text-muted">{{ Auth::user()->is_member ? 'Premium' : 'Free' }}</small>
            </div>
        </div>

        <hr>

        {{-- Menu Navigasi --}}
        <nav class="nav flex-column mb-4">
            <a href="{{ url('/homepage') }}" class="nav-link text-dark"><i class="fas fa-home me-2"></i> Dashboard</a>
            <a href="{{ url('/dashboard-user') }}" class="nav-link text-dark"><i class="fas fa-utensils me-2"></i> Menu</a>
            <a href="{{ url('/kategori-list') }}" class="nav-link text-dark"><i class="fas fa-tags me-2"></i> Kategori</a>
            <a href="#" class="nav-link text-dark"><i class="fas fa-book me-2"></i> Resep</a>
            <a href="#" class="nav-link text-dark"><i class="fas fa-crown me-2"></i> Premium</a>
            <a href="#" class="nav-link text-dark"><i class="fas fa-bookmark me-2"></i> Disimpan</a>
        </nav>

        <hr>

        <h5 class="fw-bold">Tentang Dapur Indonesia</h5>
        <p>Selamat datang di portal resep masakan khas Indonesia! Jelajahi ratusan resep dari seluruh nusantara.</p>

        <hr>
    </div>

    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const detailModal = document.getElementById('detailModal');
        if (detailModal) {
            detailModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                document.getElementById('detailTitle').textContent = button.getAttribute('data-title');
                document.getElementById('detailDesc').textContent = button.getAttribute('data-desc');
                document.getElementById('detailImage').src = button.getAttribute('data-image');
                document.getElementById('detailImage').alt = button.getAttribute('data-title');
            });
        }

        // Toggle sidebar
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        toggleSidebar.addEventListener('click', () => {
            sidebar.style.transform = 'translateX(0)';
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.style.transform = 'translateX(100%)';
        });
    </script>
</body>
</html>
