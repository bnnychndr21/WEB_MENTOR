<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>422 - Validasi Gagal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="text-center px-3">
        <div class="text-danger mb-3" style="font-size: 5rem;">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        <h2 class="fw-bold">422</h2>
        <p class="text-muted mb-4">{{ $exception->getMessage() ?: 'Data yang dikirim tidak valid.' }}</p>
        <a href="{{ url()->previous() }}" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</body>
</html>
