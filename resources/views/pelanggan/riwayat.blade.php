@extends('layouts.pelanggan')

@section('title', 'Riwayat Penyewaan - TERA Client')

@section('content')
<!-- Page Header -->
<div class="page-breadcrumb">
    PORTAL MANAJEMEN KLIEN <span class="dot"></span> Log Transaksi
</div>
<div class="page-header">
    <div class="page-header-text">
        <h2>Riwayat Penyewaan</h2>
        <p>Pantau dan kelola seluruh jejak transaksi penyewaan perangkat radio telekomunikasi Anda secara transparan dan terorganisir.</p>
    </div>
    <div class="page-header-actions">
        <button class="btn-outline" id="btnRiwayatFilter"><i class="bi bi-filter"></i> Filter</button>
        <button class="btn-primary" id="btnEkspor"><i class="bi bi-download"></i> Ekspor Data</button>
    </div>
</div>

<!-- Stats Cards -->
<div class="riwayat-stats-grid">
    <div class="riwayat-stat-card">
        <div>
            <div class="stat-label">TOTAL KONTRAK DISEWA</div>
            <div class="stat-value">42 Transaksi</div>
            <div class="stat-trend"><i class="bi bi-graph-up-arrow"></i> +14% bulan ini</div>
        </div>
        <div class="stat-icon blue"><i class="bi bi-receipt-cutoff"></i></div>
    </div>
    <div class="riwayat-stat-card">
        <div>
            <div class="stat-label">BIAYA TERSERAP</div>
            <div class="stat-value">Rp 65.000.000</div>
            <div class="stat-sub">Q4 Fiskal Berjalan</div>
        </div>
        <div class="stat-icon blue"><i class="bi bi-wallet2"></i></div>
    </div>
    <div class="riwayat-stat-card">
        <div>
            <div class="stat-label">UNIT AKTIF ON-AIR</div>
            <div class="stat-value">8</div>
            <div class="stat-value-unit">Perangkat Radio</div>
            <div class="stat-trend"><i class="bi bi-check-circle"></i> Efisiensi 98.2%</div>
        </div>
        <div class="stat-icon green"><i class="bi bi-broadcast"></i></div>
    </div>
    <div class="riwayat-stat-card">
        <div>
            <div class="stat-label">DURASI RATA-RATA</div>
            <div class="stat-value">3.5 Bulan / Unit</div>
            <div class="stat-sub">Siklus sewa telekomunikasi</div>
        </div>
        <div class="stat-icon slate"><i class="bi bi-clock-history"></i></div>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="riwayat-search-bar">
    <div class="riwayat-search-input-wrap">
        <i class="bi bi-search"></i>
        <input type="text" class="riwayat-search-input" placeholder="Cari ID Sewa, Model Unit, atau Lokasi..." id="riwayatSearch">
    </div>
    <div class="riwayat-filter-pills">
        <button class="riwayat-filter-pill active" data-status="all">Semua</button>
        <button class="riwayat-filter-pill" data-status="selesai">Selesai</button>
        <button class="riwayat-filter-pill" data-status="pending">Pending</button>
        <button class="riwayat-filter-pill" data-status="dibatalkan">Dibatalkan</button>
    </div>
</div>

<!-- Data Table -->
<div class="rentals-table-card">
    <table class="rentals-table">
        <thead>
            <tr>
                <th>ID SEWA</th>
                <th>UNIT</th>
                <th>TANGGAL</th>
                <th>DURASI</th>
                <th>TOTAL BIAYA</th>
                <th>STATUS</th>
                <th style="text-align: center;">AKSI</th>
            </tr>
        </thead>
        <tbody id="riwayatTableBody">
            <tr data-status="selesai">
                <td class="td-id-unit"><a href="#">#TRX-99201</a></td>
                <td>
                    <div class="unit-info-cell">
                        <div class="unit-icon-box" style="background: #eff6ff; color: #2563eb;">
                            <i class="bi bi-broadcast"></i>
                        </div>
                        <div>
                            <div class="unit-name-text">Repeater Motorola SLR 5300</div>
                            <div class="unit-sub-text">UHF 350-400 MHz (Tower Alpha)</div>
                        </div>
                    </div>
                </td>
                <td class="td-date">12 Okt - 15 Des 2023</td>
                <td>2 Bulan</td>
                <td><strong>Rp 4.000.000</strong></td>
                <td>
                    <span class="badge-status-pill" style="background: #dcfce7; color: #166534;">
                        <span class="status-dot" style="background: #22c55e;"></span> Selesai
                    </span>
                </td>
                <td style="text-align: center;">
                    <button type="button" class="btn-action-dots" title="Detail" onclick="openRiwayatDetail('#TRX-99201', 'Repeater Motorola SLR 5300', 'UHF 350-400 MHz (Tower Alpha)', '12 Okt - 15 Des 2023', '2 Bulan', 'Rp 4.000.000', 'Selesai')">
                        <i class="bi bi-eye"></i>
                    </button>
                </td>
            </tr>
            <tr data-status="selesai">
                <td class="td-id-unit"><a href="#">#TRX-99215</a></td>
                <td>
                    <div class="unit-info-cell">
                        <div class="unit-icon-box" style="background: #eff6ff; color: #2563eb;">
                            <i class="bi bi-broadcast"></i>
                        </div>
                        <div>
                            <div class="unit-name-text">Repeater HYTERA RD988</div>
                            <div class="unit-sub-text">UHF 350-400 MHz (Site Tambang)</div>
                        </div>
                    </div>
                </td>
                <td class="td-date">05 Okt - 05 Nov 2023</td>
                <td>1 Bulan</td>
                <td><strong>Rp 2.000.000</strong></td>
                <td>
                    <span class="badge-status-pill" style="background: #dcfce7; color: #166534;">
                        <span class="status-dot" style="background: #22c55e;"></span> Selesai
                    </span>
                </td>
                <td style="text-align: center;">
                    <button type="button" class="btn-action-dots" title="Detail" onclick="openRiwayatDetail('#TRX-99215', 'Repeater HYTERA RD988', 'UHF 350-400 MHz (Site Tambang)', '05 Okt - 05 Nov 2023', '1 Bulan', 'Rp 2.000.000', 'Selesai')">
                        <i class="bi bi-eye"></i>
                    </button>
                </td>
            </tr>
            <tr data-status="pending">
                <td class="td-id-unit"><a href="#">#TRX-99304</a></td>
                <td>
                    <div class="unit-info-cell">
                        <div class="unit-icon-box" style="background: #f0fdf4; color: #16a34a;">
                            <i class="bi bi-router"></i>
                        </div>
                        <div>
                            <div class="unit-name-text">Radio Base Motorola XiR M8628</div>
                            <div class="unit-sub-text">UHF 350-400 MHz (Dispatcher Room)</div>
                        </div>
                    </div>
                </td>
                <td class="td-date">28 Sep - 28 Nov 2023</td>
                <td>2 Bulan</td>
                <td><strong>Rp 750.000</strong></td>
                <td>
                    <span class="badge-status-pill" style="background: #fef08a; color: #854d0e;">
                        <span class="status-dot" style="background: #eab308;"></span> Pending
                    </span>
                </td>
                <td style="text-align: center;">
                    <button type="button" class="btn-action-dots" title="Detail" onclick="openRiwayatDetail('#TRX-99304', 'Radio Base Motorola XiR M8628', 'UHF 350-400 MHz (Dispatcher Room)', '28 Sep - 28 Nov 2023', '2 Bulan', 'Rp 750.000', 'Pending')">
                        <i class="bi bi-eye"></i>
                    </button>
                </td>
            </tr>
            <tr data-status="dibatalkan">
                <td class="td-id-unit"><a href="#">#TRX-99388</a></td>
                <td>
                    <div class="unit-info-cell">
                        <div class="unit-icon-box" style="background: #fef2f2; color: #dc2626;">
                            <i class="bi bi-wifi"></i>
                        </div>
                        <div>
                            <div class="unit-name-text">Radio HF SSB Barret 4050</div>
                            <div class="unit-sub-text">HF 1.6-30 MHz (Stasiun Pesisir)</div>
                        </div>
                    </div>
                </td>
                <td class="td-date">15 Sep - 15 Okt 2023</td>
                <td>1 Bulan</td>
                <td><strong>Rp 30.000.000</strong></td>
                <td>
                    <span class="badge-status-pill" style="background: #fee2e2; color: #991b1b;">
                        <span class="status-dot" style="background: #ef4444;"></span> Dibatalkan
                    </span>
                </td>
                <td style="text-align: center;">
                    <button type="button" class="btn-action-dots" title="Detail" onclick="openRiwayatDetail('#TRX-99388', 'Radio HF SSB Barret 4050', 'HF 1.6-30 MHz (Stasiun Pesisir)', '15 Sep - 15 Okt 2023', '1 Bulan', 'Rp 30.000.000', 'Dibatalkan')">
                        <i class="bi bi-eye"></i>
                    </button>
                </td>
            </tr>
            <tr data-status="selesai">
                <td class="td-id-unit"><a href="#">#TRX-99412</a></td>
                <td>
                    <div class="unit-info-cell">
                        <div class="unit-icon-box" style="background: #eff6ff; color: #2563eb;">
                            <i class="bi bi-phone"></i>
                        </div>
                        <div>
                            <div class="unit-name-text">Radio HT Motorola XiR P6620i</div>
                            <div class="unit-sub-text">UHF 350-400 MHz (Tim Lapangan Cikarang)</div>
                        </div>
                    </div>
                </td>
                <td class="td-date">01 Sep - 01 Des 2023</td>
                <td>3 Bulan</td>
                <td><strong>Rp 1.050.000</strong></td>
                <td>
                    <span class="badge-status-pill" style="background: #dcfce7; color: #166534;">
                        <span class="status-dot" style="background: #22c55e;"></span> Selesai
                    </span>
                </td>
                <td style="text-align: center;">
                    <button type="button" class="btn-action-dots" title="Detail" onclick="openRiwayatDetail('#TRX-99412', 'Radio HT Motorola XiR P6620i', 'UHF 350-400 MHz (Tim Lapangan Cikarang)', '01 Sep - 01 Des 2023', '3 Bulan', 'Rp 1.050.000', 'Selesai')">
                        <i class="bi bi-eye"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="table-pagination">
        <div class="table-pagination-info">Menampilkan 1-5 dari 42 transaksi</div>
        <div class="table-pagination-nav">
            <button>&lt;</button>
            <button class="active">1</button>
            <button>2</button>
            <button>3</button>
            <button style="border: none; background: transparent; cursor: default;">...</button>
            <button>9</button>
            <button>&gt;</button>
        </div>
    </div>
</div>

<!-- Bottom Section: Stats + RF Card -->
<div class="riwayat-bottom-grid">
    <!-- Distribution Card -->
    <div class="riwayat-bottom-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.3rem;">
            <h4>Distribusi Durasi Unit</h4>
            <span class="card-badge-quarter">Q3-Q4 2023</span>
        </div>
        <div class="card-subtitle">Frekuensi durasi sewa yang paling sering diajukan klien.</div>

        <div class="duration-bar-item">
            <div class="duration-bar-label">
                <span>1 - 3 Bulan (Jangka Pendek)</span>
                <span>58%</span>
            </div>
            <div class="duration-bar">
                <div class="duration-bar-fill" style="width: 58%;"></div>
            </div>
        </div>
        <div class="duration-bar-item">
            <div class="duration-bar-label">
                <span>4 - 6 Bulan (Proyek Menengah)</span>
                <span>27%</span>
            </div>
            <div class="duration-bar">
                <div class="duration-bar-fill" style="width: 27%; background: #3b82f6;"></div>
            </div>
        </div>
        <div class="duration-bar-item">
            <div class="duration-bar-label">
                <span>> 6 Bulan (Kontrak Tahunan)</span>
                <span>15%</span>
            </div>
            <div class="duration-bar">
                <div class="duration-bar-fill" style="width: 15%; background: #60a5fa;"></div>
            </div>
        </div>

        <div class="card-footer-note">
            <i class="bi bi-info-circle"></i>
            Data diperbarui otomatis setiap pergantian shift logistik.
        </div>
    </div>

    <!-- ISR Card -->
    <div class="riwayat-bottom-card">
        <h4>Sertifikasi & Kelayakan Frekuensi ISR</h4>
        <div class="card-subtitle">Status kelengkapan izin transmisi RF dan sertifikasi frekuensi radio sebelum implementasi perangkat.</div>

        <div class="isr-donut-wrap">
            <div class="isr-donut">
                <div class="isr-donut-inner">
                    <span class="isr-donut-value">100%</span>
                    <span class="isr-donut-label">SDPPI</span>
                </div>
            </div>
            <div class="isr-info">
                <h5>Izin Stasiun Radio (ISR) SDPPI</h5>
                <p>Standar izin resmi SDPPI Kominfo & uji transmisi RF 100% tersertifikasi.</p>
            </div>
        </div>

        <button type="button" class="btn-download-isr" onclick="alert('Mengunduh Sertifikat ISR Kolektif...')">
            Unduh Sertifikat ISR Kolektif <i class="bi bi-download"></i>
        </button>
    </div>

    <!-- RF Support Card -->
    <div class="rf-support-card">
        <div class="rf-icon">
            <i class="bi bi-broadcast"></i>
        </div>
        <h4>Dukungan Teknis RF & Radio 24/7</h4>
        <p>Mengalami gangguan intervensi sinyal, kendala repeater, atau butuh pengaturan kanal frekuensi darurat?</p>
        <div class="rf-hotline">
            <i class="bi bi-telephone-fill"></i>
            Hotline RF Support: +62 21 8890 1200
        </div>
        <button type="button" class="btn-rf-contact" onclick="openPopup('popupBantuan')">Hubungi Tim Radio TERA</button>
    </div>
</div>

<!-- Detail Popup -->
<div class="popup-modal" id="popupRiwayatDetail">
    <div class="popup-header">
        <h3><i class="bi bi-eye"></i> Detail Transaksi</h3>
        <button class="popup-close" onclick="closePopup('popupRiwayatDetail')">&times;</button>
    </div>
    <div class="popup-body">
        <div class="popup-unit-header">
            <div class="popup-unit-icon"><i class="bi bi-broadcast"></i></div>
            <div>
                <div class="popup-unit-name" id="rdUnitName">-</div>
                <div class="popup-unit-cat" id="rdUnitFreq">-</div>
            </div>
        </div>
        <div class="popup-detail-grid">
            <div class="popup-detail-item">
                <div class="popup-detail-label">ID Sewa</div>
                <div class="popup-detail-value" id="rdId">-</div>
            </div>
            <div class="popup-detail-item">
                <div class="popup-detail-label">Status</div>
                <div class="popup-detail-value" id="rdStatus">-</div>
            </div>
            <div class="popup-detail-item">
                <div class="popup-detail-label">Tanggal</div>
                <div class="popup-detail-value" id="rdDate">-</div>
            </div>
            <div class="popup-detail-item">
                <div class="popup-detail-label">Durasi</div>
                <div class="popup-detail-value" id="rdDuration">-</div>
            </div>
            <div class="popup-detail-item" style="grid-column: 1 / -1;">
                <div class="popup-detail-label">Total Biaya</div>
                <div class="popup-detail-value" id="rdCost" style="font-size: 1.1rem; color: var(--tera-client-primary);">-</div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Popup -->
<div class="popup-modal" id="popupRiwayatFilter">
    <div class="popup-header">
        <h3><i class="bi bi-filter"></i> Filter Riwayat</h3>
        <button class="popup-close" onclick="closePopup('popupRiwayatFilter')">&times;</button>
    </div>
    <div class="popup-body">
        <div class="form-group">
            <label>Status Transaksi</label>
            <select class="form-control">
                <option value="">Semua Status</option>
                <option>Selesai</option>
                <option>Pending</option>
                <option>Dibatalkan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Periode</label>
            <div class="form-row">
                <input type="date" class="form-control" placeholder="Dari">
                <input type="date" class="form-control" placeholder="Sampai">
            </div>
        </div>
        <div class="form-group">
            <label>Tipe Unit</label>
            <select class="form-control">
                <option value="">Semua Tipe</option>
                <option>Repeater</option>
                <option>Radio Base / Mobile</option>
                <option>Radio HT</option>
                <option>Radio HF SSB</option>
            </select>
        </div>
        <div style="display: flex; gap: 0.75rem; margin-top: 1rem;">
            <button type="button" class="btn-primary" style="flex: 1; justify-content: center;" onclick="closePopup('popupRiwayatFilter')">
                <i class="bi bi-check2"></i> Terapkan
            </button>
            <button type="button" class="btn-secondary" style="flex: 1; justify-content: center;" onclick="closePopup('popupRiwayatFilter')">Reset</button>
        </div>
    </div>
</div>

<!-- Ekspor Popup -->
<div class="popup-modal" id="popupEkspor">
    <div class="popup-header">
        <h3><i class="bi bi-download"></i> Ekspor Data</h3>
        <button class="popup-close" onclick="closePopup('popupEkspor')">&times;</button>
    </div>
    <div class="popup-body">
        <div class="form-group">
            <label>Format File</label>
            <select class="form-control">
                <option>CSV (.csv)</option>
                <option>Excel (.xlsx)</option>
                <option selected>PDF (.pdf)</option>
            </select>
        </div>
        <div class="form-group">
            <label>Rentang Data</label>
            <select class="form-control">
                <option>Bulan Ini</option>
                <option selected>Kuartal Ini (Q4 2023)</option>
                <option>Tahun Ini</option>
                <option>Semua Data</option>
            </select>
        </div>
        <div style="display: flex; gap: 0.75rem; margin-top: 1.25rem;">
            <button type="button" class="btn-primary" style="flex: 1; justify-content: center;" onclick="alert('Data riwayat berhasil diekspor!'); closePopup('popupEkspor');">
                <i class="bi bi-download"></i> Unduh Sekarang
            </button>
            <button type="button" class="btn-secondary" style="flex: 1; justify-content: center;" onclick="closePopup('popupEkspor')">Batal</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Status filter pills
    document.querySelectorAll('.riwayat-filter-pill').forEach(pill => {
        pill.addEventListener('click', function() {
            document.querySelectorAll('.riwayat-filter-pill').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            const status = this.dataset.status;
            document.querySelectorAll('#riwayatTableBody tr').forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // Search filter
    document.getElementById('riwayatSearch')?.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        document.querySelectorAll('#riwayatTableBody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });

    // Detail popup
    function openRiwayatDetail(id, name, freq, date, duration, cost, status) {
        document.getElementById('rdId').textContent = id;
        document.getElementById('rdUnitName').textContent = name;
        document.getElementById('rdUnitFreq').textContent = freq;
        document.getElementById('rdDate').textContent = date;
        document.getElementById('rdDuration').textContent = duration;
        document.getElementById('rdCost').textContent = cost;
        document.getElementById('rdStatus').textContent = status;
        openPopup('popupRiwayatDetail');
    }

    // Bind buttons
    document.getElementById('btnRiwayatFilter')?.addEventListener('click', () => openPopup('popupRiwayatFilter'));
    document.getElementById('btnEkspor')?.addEventListener('click', () => openPopup('popupEkspor'));
</script>
@endpush
