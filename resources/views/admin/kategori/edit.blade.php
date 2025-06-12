<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Kategori</title>
    <link rel="icon" href="{{ asset('assets/itats-icon.jpg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/cropperjs@1.5.12/dist/cropper.min.css" rel="stylesheet"/>
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
                        <h1 class="m-0"><i class="fas fa-edit"></i> Ubah Kategori</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h3 class="card-title"><i class="fas fa-pencil-alt"></i> Form Ubah Kategori</h3>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="kategori_name"><i class="fas fa-id-badge"></i> Nama Kategori</label>
                                <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                                    name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                                @error('nama_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tambahan edit gambar -->
                            <div class="form-group text-center mt-4">
                                <label for="gambar_kategori">Ubah Gambar Kategori</label>
                                <input type="file" name="gambar_kategori" id="gambar_kategori" class="form-control-file @error('gambar_kategori') is-invalid @enderror" accept="image/*">
                                @error('gambar_kategori')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="text-center mb-3">
                                <div style="width: 300px; height: 300px; border: 2px dashed #ccc; margin: auto; display: flex; align-items: center; justify-content: center;">
                                    <img id="preview" src="{{ asset('uploads/kategori/' . $kategori->gambar_kategori) }}" class="img-fluid rounded" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                </div>
                                <input type="hidden" name="cropped_image" id="cropped_image">
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
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
<script src="https://unpkg.com/cropperjs@1.5.12/dist/cropper.min.js"></script>
<script>
    let cropper;
    const image = document.getElementById('preview');
    const input = document.getElementById('gambar_kategori');

    input.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = () => {
            image.src = reader.result;

            if (cropper) cropper.destroy();
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
                crop(event) {
                    const canvas = cropper.getCroppedCanvas({ width: 300, height: 300 });
                    canvas.toBlob((blob) => {
                        const reader = new FileReader();
                        reader.onloadend = () => {
                            document.getElementById('cropped_image').value = reader.result;
                        };
                        reader.readAsDataURL(blob);
                    });
                }
            });
        };
        reader.readAsDataURL(file);
    });
</script>
</body>
</html>
