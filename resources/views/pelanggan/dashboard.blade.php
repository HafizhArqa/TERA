@extends('layouts.pelanggan')

@section('title', 'Dashboard Pelanggan - TERA Client')

@section('content')
    <!-- Welcome Banner -->
    <div class="client-welcome-banner">
        <div class="client-welcome-badge">
            <span class="badge-dot"></span>
            PORTAL PERANGKAT RADIO TELEKOMUNIKASI
        </div>
        <div class="client-welcome-circle"></div>
        <h1>Selamat datang kembali, {{ auth()->check() ? (auth()->user()->nama ?? auth()->user()->username ?? 'Alex') : 'Alex' }}!</h1>
        <p>Kelola sistem komunikasi radio, repeater, dan transceiver operasional Anda.
           Anda memiliki <strong>3 perangkat aktif</strong> hari ini.</p>
    </div>

    <!-- 3 Quick Action Cards -->
    <div class="quick-cards-grid">
        <!-- Card 1: Katalog Perangkat -->
        <a href="{{ route('pelanggan.unit.index') }}" class="quick-card">
            <div class="quick-card-icon-box blue">
                <i class="bi bi-broadcast"></i>
            </div>
            <div class="quick-card-title">Katalog Perangkat</div>
            <p class="quick-card-desc">Repeater SLR/RD988, Radio HT XiR, Barret SSB siap sewa.</p>
            <span class="quick-card-link">Buka katalog <i class="bi bi-arrow-right"></i></span>
        </a>

        <!-- Card 2: Status Frekuensi & Kanal -->
        <a href="{{ route('pelanggan.unit.index') }}" class="quick-card">
            <div class="quick-card-icon-box slate">
                <i class="bi bi-sliders"></i>
            </div>
            <div class="quick-card-title">Status Frekuensi & Kanal</div>
            <p class="quick-card-desc">Cek alokasi frekuensi ISR, repeater duplexer, dan operasional.</p>
            <span class="quick-card-link">Monitoring unit <i class="bi bi-arrow-right"></i></span>
        </a>

        <!-- Card 3: Riwayat Sewa & Tagihan -->
        <a href="{{ route('pelanggan.penyewaan.history') }}" class="quick-card">
            <div class="quick-card-icon-box slate">
                <i class="bi bi-receipt-cutoff"></i>
            </div>
            <div class="quick-card-title">Riwayat Sewa & Tagihan</div>
            <p class="quick-card-desc">Arsip kontrak sewa bulanan, invoice resmi, dan BAST perangkat.</p>
            <span class="quick-card-link">Lihat riwayat <i class="bi bi-arrow-right"></i></span>
        </a>
    </div>

    <!-- Bottom Section: Active Rentals Table & RF Support Card -->
    <div class="dashboard-split-section">
        <!-- Left Column: Active Rentals -->
        <div class="rentals-section">
            <div class="rentals-header">
                <div class="rentals-header-left">
                    <h3>Penyewaan Aktif</h3>
                    <span class="rentals-badge-count">3 Unit Berjalan</span>
                </div>
                <a href="{{ route('pelanggan.penyewaan.history') }}">Lihat Semua <i class="bi bi-chevron-right"></i></a>
            </div>

            <div class="rentals-table-card">
                <table class="rentals-table">
                    <thead>
                        <tr>
                            <th>ID UNIT</th>
                            <th>TIPE UNIT</th>
                            <th>MULAI SEWA</th>
                            <th>STATUS</th>
                            <th style="text-align: center;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->
                        <tr>
                            <td class="td-id-unit"><a href="#">#RP-5301</a></td>
                            <td>
                                <div class="unit-info-cell">
                                    <div class="unit-icon-box" style="background: #eff6ff; color: #2563eb;">
                                        <i class="bi bi-broadcast"></i>
                                    </div>
                                    <div>
                                        <div class="unit-name-text">Repeater Motorola SLR 5300</div>
                                        <div class="unit-sub-text">UHF 350-400 MHz • Base Site Tower Alpha</div>
                                    </div>
                                </div>
                            </td>
                            <td class="td-date">
                                <div>01 Okt 2023</div>
                                <div class="date-sub">Rp 2.000.000 / bln (Kontrak 6 Bln)</div>
                            </td>
                            <td>
                                <span class="badge-status-pill" style="background: #dcfce7; color: #166534;">
                                    <span class="status-dot" style="background: #22c55e;"></span> ON-AIR AKTIF
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-action-dots" title="Detail" onclick="openDetailPopup('RP-5301', 'Repeater Motorola SLR 5300', 'UHF 350-400 MHz', '01 Okt 2023', 'ON-AIR AKTIF', 'Rp 2.000.000 / bln')">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr>
                            <td class="td-id-unit"><a href="#">#HT-6628</a></td>
                            <td>
                                <div class="unit-info-cell">
                                    <div class="unit-icon-box" style="background: #f0fdf4; color: #16a34a;">
                                        <i class="bi bi-phone"></i>
                                    </div>
                                    <div>
                                        <div class="unit-name-text">Motorola XiR P6620i</div>
                                        <div class="unit-sub-text">UHF 350-400 MHz • Tim Lapangan Cikarang</div>
                                    </div>
                                </div>
                            </td>
                            <td class="td-date">
                                <div>15 Okt 2023</div>
                                <div class="date-sub">Rp 350.000 / bln (Durasi 30 Hari)</div>
                            </td>
                            <td>
                                <span class="badge-status-pill" style="background: #dbeafe; color: #1e40af;">
                                    <span class="status-dot" style="background: #2563eb;"></span> DIGUNAKAN
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-action-dots" title="Detail" onclick="openDetailPopup('HT-6628', 'Motorola XiR P6620i', 'UHF 350-400 MHz', '15 Okt 2023', 'DIGUNAKAN', 'Rp 350.000 / bln')">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr>
                            <td class="td-id-unit"><a href="#">#SSB-4050</a></td>
                            <td>
                                <div class="unit-info-cell">
                                    <div class="unit-icon-box" style="background: #eff6ff; color: #2563eb;">
                                        <i class="bi bi-wifi"></i>
                                    </div>
                                    <div>
                                        <div class="unit-name-text">Barret 4050 HF SSB</div>
                                        <div class="unit-sub-text">HF High Frequency • Stasiun Jarak Jauh</div>
                                    </div>
                                </div>
                            </td>
                            <td class="td-date">
                                <div>10 Okt 2023</div>
                                <div class="date-sub">Rp 30.000.000 / bln (Enterprise SLA)</div>
                            </td>
                            <td>
                                <span class="badge-status-pill" style="background: #dcfce7; color: #166534;">
                                    <span class="status-dot" style="background: #22c55e;"></span> ON-AIR AKTIF
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-action-dots" title="Detail" onclick="openDetailPopup('SSB-4050', 'Barret 4050 HF SSB', 'HF High Frequency', '10 Okt 2023', 'ON-AIR AKTIF', 'Rp 30.000.000 / bln')">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Bottom Notice -->
                <div class="info-notice">
                    <i class="bi bi-info-circle"></i>
                    <span><strong>Jadwal Perpanjangan Frekuensi Radio HT</strong> — Unit Motorola XiR P6620i (#HT-6628) jatuh tempo 14 Nov 2023</span>
                    <button type="button" class="btn-perpanjang" onclick="openPerpanjangPopup()">Perpanjang Sewa</button>
                </div>
            </div>
        </div>

        <!-- Right Column: RF Support Card -->
        <div class="rf-support-card">
            <div class="rf-icon">
                <i class="bi bi-headset"></i>
            </div>
            <h4>Dukungan RF 24/7</h4>
            <p>Tim teknis radio siap membantu monitoring & troubleshooting frekuensi operasional Anda.</p>
            <div class="rf-hotline">
                <i class="bi bi-telephone-fill"></i>
                Hotline RF Support: +62 21 8890 1200
            </div>
            <button type="button" class="btn-rf-contact" onclick="openPopup('popupBantuan')">Hubungi Tim RF</button>
        </div>
    </div>

    <!-- Detail Popup -->
    <div class="popup-modal" id="popupDetail">
        <div class="popup-header">
            <h3><i class="bi bi-eye"></i> Detail Unit</h3>
            <button class="popup-close" onclick="closePopup('popupDetail')">&times;</button>
        </div>
        <div class="popup-body">
            <div class="popup-unit-header">
                <div class="popup-unit-icon"><i class="bi bi-broadcast"></i></div>
                <div>
                    <div class="popup-unit-name" id="detailUnitName">-</div>
                    <div class="popup-unit-cat" id="detailUnitFreq">-</div>
                </div>
            </div>
            <div class="popup-detail-grid">
                <div class="popup-detail-item">
                    <div class="popup-detail-label">ID Unit</div>
                    <div class="popup-detail-value" id="detailUnitId">-</div>
                </div>
                <div class="popup-detail-item">
                    <div class="popup-detail-label">Status</div>
                    <div class="popup-detail-value" id="detailUnitStatus">-</div>
                </div>
                <div class="popup-detail-item">
                    <div class="popup-detail-label">Mulai Sewa</div>
                    <div class="popup-detail-value" id="detailUnitDate">-</div>
                </div>
                <div class="popup-detail-item">
                    <div class="popup-detail-label">Biaya</div>
                    <div class="popup-detail-value" id="detailUnitCost">-</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Perpanjang Popup -->
    <div class="popup-modal" id="popupPerpanjang">
        <div class="popup-header">
            <h3><i class="bi bi-arrow-repeat"></i> Perpanjang Sewa</h3>
            <button class="popup-close" onclick="closePopup('popupPerpanjang')">&times;</button>
        </div>
        <div class="popup-body">
            <div class="popup-unit-header">
                <div class="popup-unit-icon"><i class="bi bi-phone"></i></div>
                <div>
                    <div class="popup-unit-name">Motorola XiR P6620i</div>
                    <div class="popup-unit-cat">ID: #HT-6628 • UHF 350-400 MHz</div>
                </div>
            </div>
            <div class="form-group">
                <label>Durasi Perpanjangan</label>
                <select class="form-control">
                    <option value="1">1 Bulan</option>
                    <option value="3">3 Bulan</option>
                    <option value="6" selected>6 Bulan</option>
                    <option value="12">12 Bulan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Catatan Tambahan</label>
                <textarea class="form-control" placeholder="Tambahkan catatan untuk admin..."></textarea>
            </div>
            <div style="display: flex; gap: 0.75rem; margin-top: 1.25rem;">
                <button type="button" class="btn-primary" style="flex: 1; justify-content: center;" onclick="alert('Permintaan perpanjangan berhasil dikirim!'); closePopup('popupPerpanjang');">
                    <i class="bi bi-send"></i> Kirim Permintaan
                </button>
                <button type="button" class="btn-secondary" style="flex: 1; justify-content: center;" onclick="closePopup('popupPerpanjang')">Batal</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openDetailPopup(id, name, freq, date, status, cost) {
        document.getElementById('detailUnitId').textContent = '#' + id;
        document.getElementById('detailUnitName').textContent = name;
        document.getElementById('detailUnitFreq').textContent = freq;
        document.getElementById('detailUnitDate').textContent = date;
        document.getElementById('detailUnitStatus').textContent = status;
        document.getElementById('detailUnitCost').textContent = cost;
        openPopup('popupDetail');
    }

    function openPerpanjangPopup() {
        openPopup('popupPerpanjang');
    }
</script>
@endpush