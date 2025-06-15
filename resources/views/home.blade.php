<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dapur Indonesia</title>
    <link rel="icon" type="image/png" href="{{ asset('image/icondapur.jpg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Nunito:wght@300;600;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>

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

        .navbar {
            background: #ffffff;
            border: none !important;
        }

        .vh-100 {
            height: 100vh;
        }

        .object-fit-cover {
            object-fit: cover;
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
@include('include.navbar')

    <!-- Hero Carousel -->
    <section class="vh-100">
        <div id="carouselExample" class="carousel slide carousel-fade h-100" data-bs-ride="carousel">
            <div class="carousel-inner h-100">
                @foreach ([
                    ['image' => 'slide1.jpg', 'title' => 'Selamat Datang di Dapur Indonesia', 'desc' => 'Temukan berbagai resep nusantara yang menggoda selera'],
                    ['image' => 'slide2.jpg', 'title' => 'Resep Masakan Nusantara', 'desc' => 'Setiap masakan membawa cerita dan kenangan'],
                    ['image' => 'slide3.jpg', 'title' => 'Inspirasi Dapur Anda', 'desc' => 'Resep inovatif untuk semua kesempatan'],
                ] as $index => $slide)
                    <div class="carousel-item h-100 position-relative {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('image/' . $slide['image']) }}" class="d-block w-100 h-100 object-fit-cover" alt="Slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h1>{{ $slide['title'] }}</h1>
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
    </section>


    <!-- Menu Section -->
    <section id="menu" class="container my-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-5">Menu Pilihan</h2>
            <p class="text-muted">Jelajahi resep khas Indonesia favorit Anda</p>
        </div>

        <div class="row g-4" id="menu-list">
            @foreach ($menus->take(8) as $menu)
            <div class="col-sm-6 col-md-4 col-lg-3 menu-item">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <img src="{{ $menu->gambar_menu ? asset('uploads/menu/' . $menu->gambar_menu) : asset('image/default.jpg') }}"
                        class="card-img-top rounded-top"
                        alt="{{ $menu->nama_menu }}"
                        style="height: 230px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark">{{ $menu->nama_menu }}</h5>
                        <p class="card-text text-muted mb-4">{{ \Illuminate\Support\Str::limit($menu->deskripsi_menu, 80) }}</p>
                        <button class="btn btn-warning mt-auto w-100 fw-semibold shadow-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#detailModal"
                                data-id="{{ $menu->id }}"
                                data-title="{{ $menu->nama_menu }}"
                                data-desc="{{ $menu->deskripsi_menu }}"
                                data-prosedur="{{ $menu->prosedur }}"
                                data-image="{{ $menu->gambar_menu ? asset('uploads/menu/' . $menu->gambar_menu) : asset('image/default.jpg') }}"
                                data-video="{{ $menu->video_url }}">
                            Lihat Detail Resep
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            @if ($menus->count() > 8)
                <button id="loadMoreBtn" class="btn btn-outline-warning px-4 fw-semibold">Lihat Lebih Banyak</button>
            @endif
        </div>

        <div class="text-center mt-3">
            <button id="toggleMenuBtn" class="btn btn-outline-secondary px-4 fw-semibold d-none">
                Lihat Lebih Sedikit
            </button>
        </div>
    </section>

    <!-- Galeri Recap -->
    <section id="galeri" class="container my-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold display-5">Rekap Galeri</h2>
            <p class="text-muted">Dokumentasi momen menarik dari komunitas dapur kami</p>
        </div>

        <div class="swiper galeriSwiper">
            <div class="swiper-wrapper">
                @foreach ($galeris as $galeri)
                    <div class="swiper-slide">
                        <img src="{{ asset('uploads/galeri/' . $galeri->gambar) }}"
                            alt="Galeri Gambar"
                            class="img-fluid rounded shadow-sm"
                            style="height: 250px; object-fit: cover; width: 100%;">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sponsor Section -->
    <section id="sponsor" class="container my-5">
        <div class="text-center mb-4">
            <h4 class="fw-bold">Sponsor Kami</h4>
            <p class="text-muted">Terima kasih kepada sponsor yang mendukung Dapur Indonesia</p>
        </div>

        <div id="sponsorCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                @foreach ($sponsors->chunk(6) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row justify-content-center g-4">
                            @foreach ($chunk as $sponsor)
                                <div class="col-4 col-sm-3 col-md-2">
                                    <div class="text-center">
                                        <img src="{{ asset('uploads/sponsor/' . $sponsor->logo_sponsor) }}"
                                            class="img-fluid rounded shadow-sm"
                                            style="height: 80px; object-fit: contain;"
                                            alt="{{ $sponsor->nama_sponsor }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
            @if($sponsors->count() > 6)
                <button class="carousel-control-prev" type="button" data-bs-target="#sponsorCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#sponsorCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            @endif
        </div>
    </section>

    <!-- Komentar dan Subscribe -->
    <section id="kontak" class="container my-5">
        <div class="row">
            <div class="col-md-6 mb-4">
                <h4>Komentar</h4>
                <textarea class="form-control mb-2" rows="4" placeholder="Tulis komentar Anda..."></textarea>
                <button class="btn btn-warning">Kirim</button>
            </div>
            <div class="col-md-6">
                <h4>Langganan Resep</h4>
                <form class="d-flex mt-3">
                    <input type="email" class="form-control rounded-start" placeholder="Masukkan email Anda" required>
                    <button class="btn btn-warning rounded-end" type="submit">Subscribe</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-warning text-white rounded-top-4 px-4 py-3">
                    <h5 class="modal-title" id="detailModalLabel">
                        <i class="fas fa-info-circle me-2"></i> Detail Resep
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup" onclick="stopVideo()"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4 align-items-start">
                        <!-- Gambar -->
                        <div class="col-lg-5">
                            <img id="detailImage" src="" alt="Gambar Resep" class="img-fluid rounded-3 shadow w-100 object-fit-cover" style="max-height: 400px;" />
                        </div>

                        <!-- Informasi Resep -->
                        <div class="col-lg-7">
                            <h3 id="detailTitle" class="fw-bold text-dark mb-2"></h3>
                            <p id="detailDesc" class="text-muted mb-3" style="font-size: 1rem;"></p>
                            <hr>
                            <h5 class="fw-semibold text-dark mb-2">Prosedur Memasak</h5>
                            <p id="detailProsedur" class="text-secondary" style="white-space: pre-line;"></p>
                        </div>
                    </div>

                    <!-- Video Resep -->
                    <div id="videoSection" class="mt-4 d-none">
                        <h5 class="fw-semibold text-dark mb-2">Video Tutorial</h5>
                        <div class="ratio ratio-16x9 rounded-3 overflow-hidden">
                            <iframe id="videoFrame" src="" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4 py-3 px-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" onclick="stopVideo()">
                        <i class="fas fa-times me-1"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        const allMenus = @json($menus);
        const menuList = document.getElementById('menu-list');
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        const toggleMenuBtn = document.getElementById('toggleMenuBtn');

        let visibleCount = 8;

        const detailModal = document.getElementById('detailModal');
        detailModal?.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            document.getElementById('detailTitle').textContent = button.getAttribute('data-title');
            document.getElementById('detailDesc').textContent = button.getAttribute('data-desc');
            document.getElementById('detailImage').src = button.getAttribute('data-image');
            document.getElementById('detailImage').alt = button.getAttribute('data-title');
            document.getElementById('detailProsedur').textContent = button.getAttribute('data-prosedur');

            const videoUrl = button.getAttribute('data-video');
            const videoFrame = document.getElementById('videoFrame');
            const videoSection = document.getElementById('videoSection');

            function extractYoutubeId(url) {
                const regExp = /^.*(?:youtu.be\/|v\/|embed\/|watch\\?v=)([^#&?]*).*/;
                const match = url.match(regExp);
                return (match && match[1].length === 11) ? match[1] : null;
            }

            const videoId = extractYoutubeId(videoUrl);
            if (videoUrl && videoId) {
                videoFrame.src = `https://www.youtube.com/embed/${videoId}`;
                videoSection.classList.remove('d-none');
            } else {
                videoFrame.src = '';
                videoSection.classList.add('d-none');
            }
        });

        detailModal?.addEventListener('hidden.bs.modal', function () {
            const videoFrame = document.getElementById('videoFrame');
            videoFrame.src = '';
        });

        const galeriSwiper = new Swiper('.galeriSwiper', {
            slidesPerView: 'auto',
            spaceBetween: 10,
            loop: true,
            speed: 5000,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            },
            freeMode: true,
            freeModeMomentum: false,
            grabCursor: true,
            breakpoints: {
                320: { slidesPerView: 1 },
                576: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                992: { slidesPerView: 4 }
            }
        });

        loadMoreBtn?.addEventListener('click', function () {
            const nextMenus = allMenus.slice(visibleCount, visibleCount + 4);

            nextMenus.forEach(menu => {
                const col = document.createElement('div');
                col.className = 'col-sm-6 col-md-4 col-lg-3 menu-item extra-menu';
                col.innerHTML = `
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <img src="${menu.gambar_menu ? '/uploads/menu/' + menu.gambar_menu : '/image/default.jpg'}"
                            class="card-img-top rounded-top"
                            alt="${menu.nama_menu}"
                            style="height: 230px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark">${menu.nama_menu}</h5>
                            <p class="card-text text-muted mb-4">${menu.deskripsi_menu.substring(0, 80)}...</p>
                            <button class="btn btn-warning mt-auto w-100 fw-semibold shadow-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal"
                                    data-id="${menu.id}"
                                    data-title="${menu.nama_menu}"
                                    data-desc="${menu.deskripsi_menu}"
                                    data-prosedur="${menu.prosedur ?? ''}"
                                    data-video="${menu.video_url ?? ''}"
                                    data-image="${menu.gambar_menu ? '/uploads/menu/' + menu.gambar_menu : '/image/default.jpg'}">
                                Lihat Detail Resep
                            </button>
                        </div>
                    </div>
                `;
                menuList.appendChild(col);
            });

            visibleCount += 4;

            if (visibleCount >= allMenus.length) {
                loadMoreBtn.style.display = 'none';
            }

            toggleMenuBtn?.classList.remove('d-none');
        });

        toggleMenuBtn?.addEventListener('click', function () {
            document.querySelectorAll('.extra-menu').forEach(el => el.remove());
            visibleCount = 8;
            loadMoreBtn.style.display = 'inline-block';
            toggleMenuBtn.classList.add('d-none');
        });
    </script>
</body>
</html>
