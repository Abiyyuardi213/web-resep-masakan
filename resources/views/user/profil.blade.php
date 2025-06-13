<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Saya - Dapur Indonesia</title>
    <link rel="icon" type="image/png" href="{{ asset('image/icondapur.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Nunito:wght@300;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            margin: 0;
            padding-top: 120px; /* ganti margin-top jadi padding-top */
        }

        .form-background {
            background-image: url('{{ asset('image/random2.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 60px 0;
        }

        .hover-shadow {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .custom-card {
            background-color: #f9f9f9;
            border-radius: 1rem;
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

        label {
            font-weight: 600;
        }

        input.form-control, textarea.form-control {
            border-radius: 0.5rem;
        }

        .form-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        }

        .profile-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ccc;
        }
    </style>
</head>
<body>

@include('include.navbarUser')

<!-- Tombol Toggle Sidebar -->
<button id="toggleSidebar" class="btn btn-outline-secondary shadow-sm">
    <i class="fas fa-bars"></i> Menu
</button>

<!-- Konten Utama -->
<div class="form-background">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="form-section">
                    <h3 class="mb-4 text-center">Edit Profil Saya</h3>

                    <form action="{{ route('usersprofil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Kolom Kiri: Foto Profil -->
                            <div class="col-md-4 mb-4 text-center">
                                <img src="{{ $user->profile_picture ? asset('uploads/profile/' . $user->profile_picture) : asset('image/default-avatar.png') }}" class="profile-image mb-3" alt="Foto Profil">
                                <div class="mb-3">
                                    <label for="profile_picture" class="form-label">Foto Profil (opsional)</label>
                                    <input type="file" name="profile_picture" class="form-control">
                                    @error('profile_picture') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <!-- Kolom Tengah: Biodata -->
                            <div class="col-md-4 mb-4">
                                <div class="mb-3">
                                    <label for="name">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                                    @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="no_telepon">No. Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon) }}">
                                    @error('no_telepon') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan: Ubah Password -->
                            <div class="col-md-4 mb-4">
                                <div class="mb-3">
                                    <label for="current_password">Password Lama</label>
                                    <input type="password" name="current_password" class="form-control">
                                    @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="new_password">Password Baru</label>
                                    <input type="password" name="new_password" class="form-control">
                                    @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                    <input type="password" name="new_password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sidebar Kanan -->
<div id="sidebar" class="position-fixed top-0 end-0 h-100 bg-white shadow-lg p-4 z-2 overflow-auto">
    <button id="closeSidebar" class="btn btn-danger mb-3"><i class="fas fa-times"></i> Tutup</button>

    <div class="d-flex align-items-center mb-4">
        <img src="{{ Auth::user()->profile_picture ? asset('uploads/profile/' . Auth::user()->profile_picture) : asset('image/default-avatar.png') }}" alt="Profil" class="rounded-circle me-3" width="60" height="60">
        <div>
            <h6 class="mb-0">{{ Auth::user()->name ?? 'Nama Pengguna' }}</h6>
            <small class="text-muted">{{ Auth::user()->is_member ? 'Premium' : 'Free' }}</small>
        </div>
    </div>

    <hr>

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
