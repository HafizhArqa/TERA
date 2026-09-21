<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Portal') - TERA PT Utama Telekomindo</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 & App via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Admin Layout Styles -->
    <link rel="stylesheet" href="{{ asset('css/admin/layout.css') }}">
    @stack('styles')
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="app-sidebar" id="appSidebar">
            <div class="sidebar-brand">
                <h4>TERA Admin</h4>
                <small>Management Portal</small>
            </div>

            <nav class="sidebar-nav">
                <!-- 1. Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="nav-item-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i>
                    <span>Dashboard</span>
                </a>

                <!-- 2. Kelola Data Unit (FR-010) -->
                <a href="{{ route('admin.units.index') }}" class="nav-item-link {{ request()->routeIs('admin.units.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Kelola Data Unit</span>
                </a>

                <!-- 3. Kelola Data Pelanggan (FR-011) -->
                <a href="#" class="nav-item-link text-white-50" title="Modul Pelanggan">
                    <i class="bi bi-people"></i>
                    <span>Kelola Data Pelanggan</span>
                </a>

                <!-- 4. Transaksi Penyewaan (FR-012, FR-021) -->
                <a href="#" class="nav-item-link text-white-50" title="Modul Transaksi">
                    <i class="bi bi-receipt"></i>
                    <span>Transaksi Penyewaan</span>
                </a>

                <!-- 5. Status Unit (FR-015) -->
                <a href="{{ route('admin.status-unit.index') }}" class="nav-item-link {{ request()->routeIs('admin.status-unit.*') ? 'active' : '' }}" title="Monitoring Status Unit">
                    <i class="bi bi-broadcast-pin"></i>
                    <span>Status Unit</span>
                </a>

                <!-- 6. Laporan Penyewaan (FR-013) -->
                <a href="#" class="nav-item-link text-white-50" title="Laporan Sewa">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Laporan Penyewaan</span>
                </a>

                <!-- 7. Laporan Pendapatan (FR-014) -->
                <a href="#" class="nav-item-link text-white-50" title="Laporan Pendapatan">
                    <i class="bi bi-cash-stack"></i>
                    <span>Laporan Pendapatan</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <button type="button" class="btn-sidebar-logout" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="bi bi-box-arrow-left me-2"></i>
                    <span>Logout</span>
                </button>
            </div>
        </aside>

        <!-- Main Body -->
        <main class="app-main">
            <!-- Topbar Header -->
            <header class="app-topbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm btn-light d-lg-none" id="sidebarToggleBtn" type="button">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <form action="{{ request()->routeIs('admin.status-unit.*') ? route('admin.status-unit.index') : route('admin.units.index') }}" method="GET" class="search-container">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" class="form-control" 
                               value="{{ request('search') }}" 
                               placeholder="Cari data, transaksi, atau unit...">
                    </form>
                </div>

                <div class="topbar-right">
                    <button type="button" class="icon-btn" title="Notifikasi">
                        <i class="bi bi-bell"></i>
                        <span class="badge-dot"></span>
                    </button>
                    <button type="button" class="icon-btn" title="Bantuan">
                        <i class="bi bi-question-circle"></i>
                    </button>
                    <a href="{{ route('profile.edit') }}" class="icon-btn" title="Pengaturan Akun">
                        <i class="bi bi-gear"></i>
                    </a>
                    
                    <div class="admin-profile">
                        <span class="fw-semibold small text-dark d-none d-sm-inline">
                            {{ auth()->user()->nama ?: 'Admin' }}
                        </span>
                        <div class="admin-avatar">
                            {{ strtoupper(substr(auth()->user()->nama ?: auth()->user()->username ?: 'A', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-body">
                <!-- Flash Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4 d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> Periksa kembali data yang dimasukkan:</div>
                        <ul class="mb-0 ps-3 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Modal Konfirmasi Logout  -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
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
                    <button type="button" class="btn btn-light px-3 rounded-3" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4 rounded-3 fw-semibold">Ya / Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Toggle mobile sidebar
        const toggleBtn = document.getElementById('sidebarToggleBtn');
        const sidebar = document.getElementById('appSidebar');
        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('show');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
