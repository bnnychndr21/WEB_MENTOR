<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="text-center px-3">
        <div class="text-warning mb-3" style="font-size: 5rem;">
            <i class="bi bi-emoji-frown"></i>
        </div>
        <h2 class="fw-bold">404</h2>
        <p class="text-muted mb-4">Halaman yang Anda cari tidak ditemukan.</p>
        <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-house me-1"></i> Ke Beranda
        </a>
    </div>
</body>
</html>
