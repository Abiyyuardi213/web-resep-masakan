<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dapur Indonesia</title>
    <link rel="icon" type="image/png" href="{{ asset('image/icondapur.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Nunito:wght@300;600;800&display=swap" rel="stylesheet">

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

        .custom-card {
            background-color: #f9f9f9;
            border-radius: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
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
        .bi-heart-fill.liked {
            color: red;
        }

        .like-btn i {
            transition: color 0.3s ease;
            cursor: pointer;
        }
    </style>
</head>
<body>

    @include('include.navbarUser')

    <!-- Hero Section dengan Grid Layout -->
    <section class="container pt-5 mt-5 pb-5">
        <div class="row g-4">
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
    </section>

    <div class="container mb-5">
        <h2 class="text-center fw-bold mb-4">Menu Masakan Favorit</h2>

        <div class="row g-4">
            @foreach ($menus ?? [] as $menu)
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm h-100 position-relative">

                    {{-- Badge Premium/Gratis --}}
                    <span class="badge position-absolute top-0 start-0 m-2
                                {{ $menu['is_premium'] ? 'bg-warning' : 'bg-success' }}">
                        {{ $menu['is_premium'] ? 'Premium' : 'Gratis' }}
                    </span>

                    <img src="{{ asset('uploads/menu/' . $menu['image']) }}"
                        class="card-img-top"
                        alt="{{ $menu['title'] }}"
                        style="height: 220px; object-fit: cover;">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $menu['title'] }}</h5>

                        @if (!empty($menu['video_url']))
                            <p>
                                <a href="{{ $menu['video_url'] }}" target="_blank" rel="noopener" class="text-danger text-decoration-none">
                                    <i class="bi bi-youtube"></i> Lihat di YouTube
                                </a>
                            </p>
                        @endif

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="like-btn" data-id="{{ $menu['id'] }}" role="button" title="Suka">
                                    <i class="bi {{ $menu['is_liked'] ? 'bi-heart-fill liked' : 'bi-heart' }}"></i>
                                </span>
                                <span class="ms-1 like-count">{{ $menu['likes_count'] }}</span>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-primary comment-btn" data-bs-toggle="collapse" data-bs-target="#comments-{{ $menu['id'] }}">
                                    <i class="bi bi-chat-left-text"></i> ({{ count($menu['comments'] ?? []) }})
                                </button>
                            </div>
                        </div>

                        <button class="btn btn-warning w-100 mt-auto" data-bs-toggle="modal" data-bs-target="#detailModal"
                            data-id="{{ $menu['id'] }}"
                            data-title="{{ $menu['title'] }}"
                            data-image="{{ asset('uploads/menu/' . $menu['image']) }}"
                            data-detail-url="{{ route('menu.detail', $menu['id']) }}"
                            data-comments='@json($menu['comments'])'>
                            Lihat Komentar Pengguna
                        </button>

                        <div class="collapse mt-3" id="comments-{{ $menu['id'] }}">
                            <div class="comments-section">
                                @forelse ($menu['comments'] as $comment)
                                    <div><strong>{{ $comment['user'] }}:</strong> {{ $comment['text'] }}</div>
                                @empty
                                    <small class="text-muted">Belum ada komentar.</small>
                                @endforelse
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm comment-input" placeholder="Tulis komentar..." />
                                <button class="btn btn-sm btn-warning btn-submit-comment" data-id="{{ $menu['id'] }}">Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="detailModalLabel">Detail Resep Masakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-0">
                        <!-- Gambar di kiri -->
                        <div class="col-md-6 border-end">
                            <img id="detailImage" src="" alt="" class="img-fluid h-100 w-100 object-fit-cover" style="max-height: 100%; object-fit: cover;">
                        </div>

                        <!-- Detail & Komentar di kanan -->
                        <div class="col-md-6 d-flex flex-column" style="max-height: 500px; overflow-y: auto;">
                            <div class="p-3 flex-grow-1">
                                <h5 id="detailTitle" class="fw-semibold mb-2"></h5>
                                <p id="detailDesc" class="text-muted small"></p>

                                <hr>

                                <!-- Komentar-komentar -->
                                <div id="detailComments" class="mb-3">
                                    <small class="text-muted">Belum ada komentar.</small>
                                </div>
                            </div>

                            <!-- Form komentar -->
                            <div class="border-top p-2">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" id="inputDetailComment" placeholder="Tulis komentar..." />
                                    <button class="btn btn-sm btn-warning" id="btnSubmitDetailComment">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <a id="btn-detail-resep" href="#" class="btn btn-primary" target="_blank">Lihat detail resep</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const detailModal = document.getElementById('detailModal');
        const detailComments = document.getElementById('detailComments');
        const btnSubmitDetailComment = document.getElementById('btnSubmitDetailComment');

        detailModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const menuId = button.getAttribute('data-id');
            const comments = JSON.parse(button.getAttribute('data-comments'));
            const detailUrl = button.getAttribute('data-detail-url');

            document.getElementById('btn-detail-resep').setAttribute('href', detailUrl);
            document.getElementById('detailTitle').textContent = button.getAttribute('data-title');
            document.getElementById('detailDesc').textContent = button.getAttribute('data-desc');
            document.getElementById('detailImage').src = button.getAttribute('data-image');
            document.getElementById('detailImage').alt = button.getAttribute('data-title');

            detailComments.innerHTML = '';

            if (comments.length > 0) {
                comments.forEach(comment => {
                    const div = document.createElement('div');
                    div.innerHTML = `<strong>${comment.user}:</strong> ${comment.text}`;
                    detailComments.appendChild(div);
                });
            } else {
                detailComments.innerHTML = '<small class="text-muted">Belum ada komentar.</small>';
            }

            btnSubmitDetailComment.setAttribute('data-menuid', menuId);
        });

        document.getElementById('btnSubmitDetailComment').addEventListener('click', () => {
            const input = document.getElementById('inputDetailComment');
            const text = input.value.trim();
            const menuId = document.getElementById('btnSubmitDetailComment').getAttribute('data-menuid');
            const csrfToken = '{{ csrf_token() }}';

            if (!text) return alert('Komentar tidak boleh kosong!');

            fetch("{{ route('menu.comment') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    menu_id: menuId,
                    comment: text
                })
            })
            .then(res => res.json())
            .then(data => {
                const newComment = document.createElement('div');
                newComment.innerHTML = `<strong>Anda:</strong> ${text}`;
                detailComments.appendChild(newComment);
                input.value = '';
            })
            .catch(err => {
                console.error(err);
                alert('Gagal mengirim komentar.');
            });
        });

        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.classList.toggle('liked');
                const icon = btn.querySelector('i');
                const countSpan = btn.nextElementSibling;
                let count = parseInt(countSpan.textContent);
                if (btn.classList.contains('liked')) {
                    icon.classList.replace('bi-star', 'bi-star-fill');
                    count++;
                } else {
                    icon.classList.replace('bi-star-fill', 'bi-star');
                    count--;
                }
                countSpan.textContent = count;
            });
        });

        document.querySelectorAll('.btn-submit-comment').forEach(btn => {
            btn.addEventListener('click', () => {
                const parent = btn.closest('.collapse');
                const input = parent.querySelector('.comment-input');
                const commentsSection = parent.querySelector('.comments-section');
                const text = input.value.trim();
                if (text === '') return alert('Komentar tidak boleh kosong!');
                const newComment = document.createElement('div');
                newComment.innerHTML = `<strong>Anda:</strong> ${text}`;
                commentsSection.appendChild(newComment);
                input.value = '';

                const commentBtn = parent.previousElementSibling.querySelector('.comment-btn');
                const match = commentBtn.innerText.match(/\((\d+)\)/);
                let current = match ? parseInt(match[1]) : 0;
                commentBtn.innerHTML = `<i class="bi bi-chat-left-text"></i> (${current + 1})`;
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            const csrfToken = '{{ csrf_token() }}';

            document.querySelectorAll('.like-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const menuId = btn.getAttribute('data-id');
                    fetch(`/menu/${menuId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        const icon = btn.querySelector('i');
                        const countSpan = btn.nextElementSibling;
                        let count = parseInt(countSpan.textContent);

                        if (data.status === 'liked') {
                            icon.classList.replace('bi-star', 'bi-star-fill');
                            count++;
                        } else {
                            icon.classList.replace('bi-star-fill', 'bi-star');
                            count--;
                        }
                        countSpan.textContent = count;
                    });
                });
            });

            document.querySelectorAll('.btn-submit-comment').forEach(btn => {
                btn.addEventListener('click', () => {
                    const menuId = btn.getAttribute('data-id');
                    const parent = btn.closest('.collapse');
                    const input = parent.querySelector('.comment-input');
                    const commentsSection = parent.querySelector('.comments-section');
                    const text = input.value.trim();
                    if (text === '') return alert('Komentar tidak boleh kosong!');

                    fetch(`{{ route('menu.comment') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            menu_id: menuId,
                            comment: text
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        const newComment = document.createElement('div');
                        newComment.innerHTML = `<strong>Anda:</strong> ${text}`;
                        commentsSection.appendChild(newComment);
                        input.value = '';

                        const commentBtn = parent.previousElementSibling.querySelector('.comment-btn');
                        const match = commentBtn.innerText.match(/\((\d+)\)/);
                        let current = match ? parseInt(match[1]) : 0;
                        commentBtn.innerHTML = `<i class="bi bi-chat-left-text"></i> (${current + 1})`;
                    });
                });
            });
        });

        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const icon = btn.querySelector('i');
                icon.classList.toggle('bi-heart');
                icon.classList.toggle('bi-heart-fill');
                icon.classList.toggle('liked');
            });
        });
    </script>
</body>
</html>
