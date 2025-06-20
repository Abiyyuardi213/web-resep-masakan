<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Paket</title>
    <link rel="icon" type="image/png" href="{{ asset('image/icondapur.jpg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('include.navbarSistem')
    @include('include.sidebar')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="fas fa-edit"></i> Ubah Paket</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h3 class="card-title"><i class="fas fa-pencil-alt"></i> Form Ubah Paket Membership</h3>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('admin.paket-membership.update', $paket->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="nama_paket">Nama Paket</label>
                                <input type="text" name="nama_paket"
                                    class="form-control @error('nama_paket') is-invalid @enderror"
                                    value="{{ old('nama_paket', $paket->nama_paket) }}" required
                                    placeholder="Contoh: Member Silver">
                                @error('nama_paket')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="durasi_bulan">Durasi (bulan)</label>
                                <input type="number" name="durasi_bulan"
                                    class="form-control @error('durasi_bulan') is-invalid @enderror"
                                    value="{{ old('durasi_bulan', $paket->durasi_bulan) }}" required min="1"
                                    placeholder="Contoh: 3">
                                @error('durasi_bulan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="harga">Harga (Rp)</label>
                                <input type="number" name="harga"
                                    class="form-control @error('harga') is-invalid @enderror"
                                    value="{{ old('harga', $paket->harga) }}" required min="0"
                                    placeholder="Contoh: 50000">
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="paket_status">Status</label>
                                <select class="form-control @error('paket_status') is-invalid @enderror"
                                        name="paket_status">
                                    <option value="1" {{ old('paket_status', $paket->paket_status) == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('paket_status', $paket->paket_status) == '0' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('paket_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.paket-membership.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('include.footerSistem')
</div>

@include('services.logoutModal')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
