<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Akun - TERA PT Utama Telekomindo</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --tera-primary: #1d68e1;
            --tera-primary-hover: #1555bd;
            --tera-dark: #0f172a;
            --tera-gray-bg: #f1f5f9;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--tera-gray-bg);
            color: #1e293b;
        }

        .navbar-tera {
            background-color: var(--tera-dark);
        }

        .btn-primary-tera {
            background-color: var(--tera-primary);
            border-color: var(--tera-primary);
            color: #ffffff;
            font-weight: 600;
        }

        .btn-primary-tera:hover {
            background-color: var(--tera-primary-hover);
            border-color: var(--tera-primary-hover);
            color: #ffffff;
        }

        .card-profile {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
        }

        .input-group-password {
            position: relative;
        }

        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            z-index: 10;
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-tera py-3 px-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-white fs-4 d-flex align-items-center" href="{{ strtolower(auth()->user()->role) === 'admin' ? route('admin.dashboard') : route('pelanggan.dashboard') }}">
                <i class="bi bi-broadcast-pin text-primary me-2"></i> TERA 
                <span class="badge {{ strtolower(auth()->user()->role) === 'admin' ? 'bg-primary' : 'bg-success' }} ms-2 fs-6 text-capitalize">
                    {{ auth()->user()->role }}
                </span>
            </a>
            <div class="d-flex align-items-center ms-auto gap-2">
                <a href="{{ strtolower(auth()->user()->role) === 'admin' ? route('admin.dashboard') : route('pelanggan.dashboard') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container py-4" style="max-width: 800px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Pengaturan Profil Akun</h1>
                <p class="text-muted mb-0">Kelola identitas akun dan keamanan kata sandi Anda</p>
            </div>
        </div>

        <!-- Feedback Alert -->
        @if (session('status') === 'Profil berhasil diperbarui' || session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>Profil berhasil diperbarui</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>Password berhasil diperbarui</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Card: Edit Profile Information (FR-004) -->
        <div class="card card-profile p-4 mb-4">
            <h5 class="fw-bold mb-1">Informasi Akun</h5>
            <p class="text-muted small mb-4">Perbarui informasi profil pengguna dan alamat email akun.</p>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input 
                        type="text" 
                        class="form-control @error('nama') is-invalid @enderror" 
                        id="nama" 
                        name="nama" 
                        value="{{ old('nama', $user->nama ?: $user->name) }}" 
                        required
                    >
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input 
                        type="text" 
                        class="form-control @error('username') is-invalid @enderror" 
                        id="username" 
                        name="username" 
                        value="{{ old('username', $user->username) }}" 
                        required
                    >
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}" 
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary-tera px-4">
                        <i class="bi bi-check2 me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>

        <!-- Card: Update Password -->
        <div class="card card-profile p-4 mb-4">
            <h5 class="fw-bold mb-1">Perbarui Password</h5>
            <p class="text-muted small mb-4">Pastikan akun Anda menggunakan password yang aman dan sulit ditebak.</p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Password Saat Ini</label>
                    <div class="input-group-password">
                        <input 
                            type="password" 
                            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                            id="current_password" 
                            name="current_password" 
                            autocomplete="current-password"
                            style="padding-right: 40px;"
                            required
                        >
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('current_password', 'toggle-current')" tabindex="-1">
                            <i id="toggle-current" class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('current_password', 'updatePassword')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <div class="input-group-password">
                        <input 
                            type="password" 
                            class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                            id="new_password" 
                            name="password" 
                            autocomplete="new-password"
                            style="padding-right: 40px;"
                            required
                        >
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('new_password', 'toggle-new')" tabindex="-1">
                            <i id="toggle-new" class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password', 'updatePassword')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <div class="input-group-password">
                        <input 
                            type="password" 
                            class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            autocomplete="new-password"
                            style="padding-right: 40px;"
                            required
                        >
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirmation', 'toggle-confirm')" tabindex="-1">
                            <i id="toggle-confirm" class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation', 'updatePassword')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary-tera px-4">
                        <i class="bi bi-key me-1"></i> Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Logout  -->
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
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>
