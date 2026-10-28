<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TERA Client')</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Client Dashboard Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/client/dashboard.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="client-topnav" id="clientTopnav">
        <div class="topnav-inner">
            <!-- Left: Brand + Nav Links -->
            <div class="topnav-left">
                <a href="{{ Route::has('pelanggan.dashboard') ? route('pelanggan.dashboard') : '#' }}" class="topnav-brand">
                    <div class="topnav-brand-icon">
                        <img src="{{ asset('image/logoutel.png') }}" alt="TERA Logo" class="topnav-brand-logo">
                    </div>
                    <div class="topnav-brand-text">
                        <span class="brand-title">TERA</span>
                        <span class="brand-subtitle">CLIENT PORTAL</span>
                    </div>
                </a>

                <div class="topnav-links">
                    <a href="{{ Route::has('pelanggan.dashboard') ? route('pelanggan.dashboard') : '#' }}" class="topnav-link {{ request()->routeIs('pelanggan.dashboard*') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('pelanggan.unit.index') }}" class="topnav-link {{ request()->routeIs('pelanggan.unit*') ? 'active' : '' }}">Daftar Unit</a>
                    <a href="{{ route('pelanggan.penyewaan.history') }}" class="topnav-link {{ request()->routeIs('pelanggan.penyewaan.history*') ? 'active' : '' }}">Riwayat Penyewaan</a>
                </div>
            </div>

            <!-- Center: Search -->
            <div class="topnav-search">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Cari perangkat, frekuensi, atau unit..." id="globalSearch">
            </div>

            <!-- Right: Actions + User -->
            <div class="topnav-right">
                <button type="button" class="topnav-icon-btn" title="Notifikasi" id="btnNotifikasi">
                    <i class="bi bi-bell-fill"></i>
                    <span class="notif-dot"></span>
                </button>
                <button type="button" class="topnav-icon-btn" title="Bantuan" id="btnBantuan">
                    <i class="bi bi-question-circle-fill"></i>
                </button>
                <button type="button" class="topnav-icon-btn" title="Pengaturan" id="btnPengaturan">
                    <i class="bi bi-gear-fill"></i>
                </button>

                <div class="topnav-user" id="userDropdownToggle">
                    <div class="topnav-user-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="topnav-user-info">
                        <span class="topnav-user-name">{{ auth()->check() ? (auth()->user()->nama ?? auth()->user()->username ?? 'PT. Mandiri Solusi') : 'PT. Mandiri Solusi' }}</span>
                        <span class="topnav-user-role">Client</span>
                    </div>
                    <i class="bi bi-chevron-down topnav-user-chevron"></i>

                    <!-- User Dropdown -->
                    <div class="user-dropdown" id="userDropdown">
                        <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}" class="user-dropdown-item">
                            <i class="bi bi-person"></i> Profil Saya
                        </a>
                        <a href="#" class="user-dropdown-item" id="btnSettingsDropdown">
                            <i class="bi bi-gear"></i> Pengaturan
                        </a>
                        <div class="user-dropdown-divider"></div>
                        @if(Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}" id="logoutForm" style="display: none;">
                                @csrf
                            </form>
                            <button type="button" class="user-dropdown-item logout" onclick="document.getElementById('logoutForm').submit();">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        @else
                            <a href="#" class="user-dropdown-item logout">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        @endif
                    </div>
                </div>

                <button type="button" class="topnav-icon-btn logout-icon" title="Logout" id="btnLogoutIcon">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </div>

            <!-- Mobile Toggle -->
            <button type="button" class="mobile-nav-toggle" id="mobileNavToggle">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <!-- Mobile Nav Menu -->
        <div class="topnav-mobile-menu" id="mobileMenu">
            <a href="{{ Route::has('pelanggan.dashboard') ? route('pelanggan.dashboard') : '#' }}" class="topnav-link {{ request()->routeIs('pelanggan.dashboard*') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('pelanggan.unit.index') }}" class="topnav-link {{ request()->routeIs('pelanggan.unit*') ? 'active' : '' }}">Daftar Unit</a>
            <a href="{{ route('pelanggan.penyewaan.history') }}" class="topnav-link {{ request()->routeIs('pelanggan.penyewaan.history*') ? 'active' : '' }}">Riwayat Penyewaan</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="client-main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="client-footer">
        <div class="footer-inner">
            <div class="footer-left">
                &copy; 2025 TERA Operational Radio Systems. Hak Cipta Dilindungi.
            </div>
            <div class="footer-right">
                <a href="#">Ketentuan Layanan</a>
                <a href="#">Privasi</a>
                <a href="#">Pusat Bantuan</a>
            </div>
        </div>
    </footer>

    <!-- Notification Popup -->
    <div class="popup-overlay" id="popupOverlay"></div>

    <div class="popup-modal" id="popupNotifikasi">
        <div class="popup-header">
            <h3><i class="bi bi-bell-fill"></i> Notifikasi</h3>
            <button class="popup-close" onclick="closePopup('popupNotifikasi')">&times;</button>
        </div>
        <div class="popup-body">
            <div class="notif-item unread">
                <div class="notif-icon green"><i class="bi bi-check-circle-fill"></i></div>
                <div class="notif-content">
                    <p class="notif-text">Penyewaan <strong>#TRX-99201</strong> telah selesai.</p>
                    <span class="notif-time">2 jam yang lalu</span>
                </div>
            </div>
            <div class="notif-item unread">
                <div class="notif-icon blue"><i class="bi bi-broadcast"></i></div>
                <div class="notif-content">
                    <p class="notif-text">Unit <strong>Repeater Motorola SLR 5300</strong> sedang ON-AIR.</p>
                    <span class="notif-time">5 jam yang lalu</span>
                </div>
            </div>
            <div class="notif-item">
                <div class="notif-icon orange"><i class="bi bi-clock-fill"></i></div>
                <div class="notif-content">
                    <p class="notif-text">Perpanjangan sewa <strong>#HT-6628</strong> jatuh tempo 14 Nov 2023.</p>
                    <span class="notif-time">1 hari yang lalu</span>
                </div>
            </div>
            <div class="notif-item">
                <div class="notif-icon slate"><i class="bi bi-file-earmark-text-fill"></i></div>
                <div class="notif-content">
                    <p class="notif-text">Invoice bulanan tersedia untuk diunduh.</p>
                    <span class="notif-time">3 hari yang lalu</span>
                </div>
            </div>
        </div>
    </div>

    <div class="popup-modal" id="popupBantuan">
        <div class="popup-header">
            <h3><i class="bi bi-question-circle-fill"></i> Pusat Bantuan</h3>
            <button class="popup-close" onclick="closePopup('popupBantuan')">&times;</button>
        </div>
        <div class="popup-body">
            <div class="help-item">
                <i class="bi bi-book"></i>
                <div>
                    <h4>Panduan Penggunaan</h4>
                    <p>Pelajari cara menggunakan portal client TERA.</p>
                </div>
            </div>
            <div class="help-item">
                <i class="bi bi-chat-dots"></i>
                <div>
                    <h4>Live Chat Support</h4>
                    <p>Hubungi tim support kami secara real-time.</p>
                </div>
            </div>
            <div class="help-item">
                <i class="bi bi-envelope"></i>
                <div>
                    <h4>Email Support</h4>
                    <p>support@tera-radio.co.id</p>
                </div>
            </div>
            <div class="help-item">
                <i class="bi bi-telephone"></i>
                <div>
                    <h4>Hotline RF Support</h4>
                    <p>+62 21 8890 1200</p>
                </div>
            </div>
        </div>
    </div>

    <div class="popup-modal" id="popupPengaturan">
        <div class="popup-header">
            <h3><i class="bi bi-gear-fill"></i> Pengaturan</h3>
            <button class="popup-close" onclick="closePopup('popupPengaturan')">&times;</button>
        </div>
        <div class="popup-body">
            <div class="settings-group">
                <label class="settings-label">Bahasa</label>
                <select class="settings-select">
                    <option selected>Bahasa Indonesia</option>
                    <option>English</option>
                </select>
            </div>
            <div class="settings-group">
                <label class="settings-label">Zona Waktu</label>
                <select class="settings-select">
                    <option selected>WIB (UTC+7)</option>
                    <option>WITA (UTC+8)</option>
                    <option>WIT (UTC+9)</option>
                </select>
            </div>
            <div class="settings-group">
                <label class="settings-label">Notifikasi Email</label>
                <div class="settings-toggle">
                    <input type="checkbox" id="toggleEmailNotif" checked>
                    <label for="toggleEmailNotif" class="toggle-switch"></label>
                    <span>Aktifkan notifikasi via email</span>
                </div>
            </div>
            <div class="settings-group">
                <label class="settings-label">Mode Gelap</label>
                <div class="settings-toggle">
                    <input type="checkbox" id="toggleDarkMode">
                    <label for="toggleDarkMode" class="toggle-switch"></label>
                    <span>Tampilan mode gelap</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile nav toggle
        const mobileNavToggle = document.getElementById('mobileNavToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileNavToggle && mobileMenu) {
            mobileNavToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('show');
            });
        }

        // User dropdown
        const userToggle = document.getElementById('userDropdownToggle');
        const userDropdown = document.getElementById('userDropdown');
        if (userToggle && userDropdown) {
            userToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('show');
            });
            document.addEventListener('click', () => {
                userDropdown.classList.remove('show');
            });
        }

        // Popup system
        const overlay = document.getElementById('popupOverlay');

        function openPopup(id) {
            const popup = document.getElementById(id);
            if (popup && overlay) {
                // Close any open popups first
                document.querySelectorAll('.popup-modal.show').forEach(p => p.classList.remove('show'));
                popup.classList.add('show');
                overlay.classList.add('show');
            }
        }

        function closePopup(id) {
            const popup = document.getElementById(id);
            if (popup) popup.classList.remove('show');
            if (overlay) overlay.classList.remove('show');
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                document.querySelectorAll('.popup-modal.show').forEach(p => p.classList.remove('show'));
                overlay.classList.remove('show');
            });
        }

        // Bind navbar buttons to popups
        document.getElementById('btnNotifikasi')?.addEventListener('click', () => openPopup('popupNotifikasi'));
        document.getElementById('btnBantuan')?.addEventListener('click', () => openPopup('popupBantuan'));
        document.getElementById('btnPengaturan')?.addEventListener('click', () => openPopup('popupPengaturan'));
        document.getElementById('btnSettingsDropdown')?.addEventListener('click', (e) => {
            e.preventDefault();
            userDropdown?.classList.remove('show');
            openPopup('popupPengaturan');
        });

        // Logout icon
        document.getElementById('btnLogoutIcon')?.addEventListener('click', () => {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                const form = document.getElementById('logoutForm');
                if (form) form.submit();
            }
        });

        // Close popups with ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.popup-modal.show').forEach(p => p.classList.remove('show'));
                if (overlay) overlay.classList.remove('show');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
