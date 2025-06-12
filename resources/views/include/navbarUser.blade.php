<nav class="navbar navbar-expand-lg floating-navbar">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-warning" href="#">
            🍳 Dapur <span class="text-danger">Indonesia</span>
        </a>

        <!-- Custom Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <i class="bi bi-list fs-2 text-dark"></i>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav align-items-lg-center gap-2">
                <li class="nav-item"><a class="nav-link" href="{{ url('/homepage') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard-user') }}">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/kategori-list') }}">Kategori</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Resep</a></li>

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->profile_picture ? asset('uploads/profile/' . Auth::user()->profile_picture) : asset('image/default-avatar.png') }}"
                                class="rounded-circle" alt="Foto Profil"
                                style="width: 32px; height: 32px; object-fit: cover; margin-right: 8px;">
                            {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li class="px-3 py-2">
                                <div class="d-flex align-items-center">
                                    <img src="{{ Auth::user()->profile_picture ? asset('uploads/profile/' . Auth::user()->profile_picture) : asset('image/default-avatar.png') }}"
                                        class="rounded-circle me-2" alt="Foto Profil"
                                        style="width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <strong>{{ Auth::user()->username }}</strong><br>
                                        <span class="badge {{ Auth::user()->is_member ? 'bg-warning text-dark' : 'bg-success' }}">
                                            {{ Auth::user()->is_member ? 'Premium' : 'Free' }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/profil') }}">
                                    <i class="bi bi-person-circle me-2"></i> Profil
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<style>
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

    .navbar {
        background: #ffffff;
        border: none !important;
    }

    .dropdown-menu {
        min-width: 250px;
    }
</style>
