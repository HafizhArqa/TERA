<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - TERA PT Utama Telekomindo</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .navbar-tera-client {
            background-color: #1e293b;
        }
        .banner-welcome {
            background: linear-gradient(135deg, #1d68e1 0%, #3b82f6 100%);
            border-radius: 16px;
            color: white;
            padding: 2.25rem;
        }
        .card-menu {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            transition: all 0.2s ease;
            background-color: #ffffff;
            text-decoration: none;
            color: inherit;
        }
        .card-menu:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            border-color: #93c5fd;
        }
        .icon-circle {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 0.75rem;
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-tera-client py-3 px-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-white fs-4 d-flex align-items-center" href="#">
                <i class="bi bi-broadcast-pin text-primary me-2"></i> TERA <span class="badge bg-success ms-2 fs-6">Pelanggan Tetap</span>
            </a>
            <div class="d-flex align-items-center ms-auto gap-2">
                <div class="text-white text-end me-2 d-none d-sm-block">
                    <div class="fw-semibold small">{{ auth()->user()->displayName }}</div>
                    <div class="text-muted" style="font-size: 0.75rem;">{{ auth()->user()->email }}</div>
                </div>
                <!-- Profile Link -->
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-sm d-flex align-items-center">
                    <i class="bi bi-person-gear me-1"></i> Profil
                </a>
                <!-- Logout Trigger Button -->
                <button type="button" class="btn btn-outline-danger btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-4">
        <!-- Welcome Banner  -->
        <div class="banner-welcome mb-4 shadow-sm">
            <h2 class="fw-bold mb-2">Selamat datang kembali, {{ auth()->user()->displayName }}!</h2>
            <p class="mb-0 opacity-75">Kelola penyewaan unit telekomunikasi Anda dengan mudah. Anda dapat melihat unit tersedia dan riwayat transaksi.</p>
        </div>

        <!-- Quick Access Menus -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card card-menu p-3 h-100">
                    <div class="icon-circle bg-primary-subtle text-primary">
                        <i class="bi bi-grid-fill"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Lihat Daftar Unit</h6>
                    <small class="text-muted">Jelajahi armada telekomunikasi yang siap sewa</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-menu p-3 h-100">
                    <div class="icon-circle bg-success-subtle text-success">
                        <i class="bi bi-plus-circle-fill"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Ajukan Penyewaan</h6>
                    <small class="text-muted">Mulai permohonan sewa perangkat baru</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-menu p-3 h-100">
                    <div class="icon-circle bg-warning-subtle text-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Status Penyewaan</h6>
                    <small class="text-muted">Pantau unit aktif yang sedang digunakan</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-menu p-3 h-100">
                    <div class="icon-circle bg-info-subtle text-info">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Riwayat Penyewaan</h6>
                    <small class="text-muted">Lihat histori transaksi dan pengembalian</small>
                </div>
            </div>
        </div>

        <!-- User Information Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Detail Akun Pelanggan</h5>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-pencil-square me-1"></i> Edit Profil
                </a>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <small class="text-muted d-block">Nama Lengkap</small>
                    <span class="fw-semibold">{{ auth()->user()->displayName }}</span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block">Username / ID</small>
                    <span class="fw-semibold">{{ auth()->user()->username }}</span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block">Email Terdaftar</small>
                    <span class="fw-semibold">{{ auth()->user()->email }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="logoutModalLabel">
                        <i class="bi bi-exclamation-circle text-warning me-2"></i> Konfirmasi Logout
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Batal"></button>
                </div>
                <div class="modal-body text-secondary py-3">
                    Apakah Anda yakin ingin keluar dari sistem TERA? Sesi aktif Anda akan diakhiri.
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger px-3">Ya / Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>