@extends('layouts.pelanggan')

@section('title', 'Daftar Unit - TERA Client')

@section('content')
<!-- Page Header -->
<div class="page-breadcrumb">
    <span class="dot"></span>
    KATALOG PERANGKAT RADIO & TELEKOMUNIKASI TERA
</div>
<div class="page-header">
    <div class="page-header-text">
        <h2>Daftar Unit</h2>
        <p>Kelola dan sewa perangkat telekomunikasi radio rig, repeater, HT (Handie Talkie), dan radio HF SSB standar enterprise industri.</p>
    </div>
    <div class="page-header-actions">
        <button class="btn-outline" id="btnFilterUnit"><i class="bi bi-filter"></i> Filter <span class="badge-count">3</span></button>
        <button class="btn-outline" id="btnSortUnit"><i class="bi bi-sort-down"></i> Urutkan</button>
    </div>
</div>

<!-- Filter Tabs + Count -->
<div class="filters-row">
    <div class="filters-wrap">
        <button class="filter-btn active" data-filter="all">Semua Unit</button>
        <button class="filter-btn" data-filter="repeater">Repeater</button>
        <button class="filter-btn" data-filter="radio-base">Radio Base / Mobile</button>
        <button class="filter-btn" data-filter="radio-ht">Radio HT (Handie Talkie)</button>
        <button class="filter-btn" data-filter="radio-hf">Radio HF SSB</button>
    </div>
    <div class="unit-count-info">
        <span><span class="count-dot green"></span> 14 Unit Siap Sewa</span>
        <span><span class="count-dot blue"></span> Periode Sewa Bulanan</span>
    </div>
</div>

<!-- Units Grid -->
<div class="units-grid" id="unitsGrid">
    <!-- Card 1: Motorola SLR 5300 -->
    <div class="unit-card" data-category="repeater">
        <div class="unit-card-image" style="background: linear-gradient(135deg, #1e3a5f, #2d5a87);">
            <span class="badge-available"><span class="avail-dot"></span> Tersedia</span>
            <button class="btn-heart" onclick="toggleHeart(this)" title="Favorit"><i class="bi bi-heart"></i></button>
            <span class="unit-id-badge">ID: MOT-SLR5300</span>
        </div>
        <div class="unit-card-body">
            <div class="unit-category">REPEATER</div>
            <div class="unit-title">Motorola SLR 5300</div>
            <div class="unit-description">Frekuensi UHF 350-400 MHz, transmisi sinyal stabil 1-50W daya kontinu 100%...</div>
            <div class="tenor-section">
                <div class="tenor-label">
                    <span>Pilihan Tenor / Masa Sewa:</span>
                    <span class="tenor-selected">12 Bln</span>
                </div>
                <div class="tenor-pills">
                    <button class="tenor-pill" onclick="selectTenor(this)">6 Bln</button>
                    <button class="tenor-pill active" onclick="selectTenor(this)">12 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">24 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">36 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">60 Bln</button>
                </div>
            </div>
            <div class="unit-footer">
                <div class="unit-price-wrap">
                    <span class="unit-price-label">Harga / Bulan</span>
                    <span class="unit-price">Rp 2.000.000</span>
                </div>
                <button type="button" class="btn-sewa" onclick="openSewaPopup('Motorola SLR 5300', 'REPEATER', 'Rp 2.000.000', 'MOT-SLR5300')">Sewa <i class="bi bi-arrow-right"></i></button>
            </div>
        </div>
    </div>

    <!-- Card 2: HYTERA RD988 -->
    <div class="unit-card" data-category="repeater">
        <div class="unit-card-image" style="background: linear-gradient(135deg, #1a3a2e, #2d6b50);">
            <span class="badge-available"><span class="avail-dot"></span> Tersedia</span>
            <button class="btn-heart" onclick="toggleHeart(this)" title="Favorit"><i class="bi bi-heart"></i></button>
            <span class="unit-id-badge">ID: HYT-RD988</span>
        </div>
        <div class="unit-card-body">
            <div class="unit-category">REPEATER</div>
            <div class="unit-title">HYTERA RD988</div>
            <div class="unit-description">UHF 350-400 MHz, DMR Tier II standar industri telekomunikasi dengan modul...</div>
            <div class="tenor-section">
                <div class="tenor-label">
                    <span>Pilihan Tenor / Masa Sewa:</span>
                    <span class="tenor-selected">12 Bln</span>
                </div>
                <div class="tenor-pills">
                    <button class="tenor-pill" onclick="selectTenor(this)">6 Bln</button>
                    <button class="tenor-pill active" onclick="selectTenor(this)">12 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">24 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">36 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">60 Bln</button>
                </div>
            </div>
            <div class="unit-footer">
                <div class="unit-price-wrap">
                    <span class="unit-price-label">Harga / Bulan</span>
                    <span class="unit-price">Rp 2.000.000</span>
                </div>
                <button type="button" class="btn-sewa" onclick="openSewaPopup('HYTERA RD988', 'REPEATER', 'Rp 2.000.000', 'HYT-RD988')">Sewa <i class="bi bi-arrow-right"></i></button>
            </div>
        </div>
    </div>

    <!-- Card 3: Motorola XiR M8628 -->
    <div class="unit-card" data-category="radio-base">
        <div class="unit-card-image" style="background: linear-gradient(135deg, #2c3e50, #4a6741);">
            <span class="badge-available"><span class="avail-dot"></span> Tersedia</span>
            <button class="btn-heart" onclick="toggleHeart(this)" title="Favorit"><i class="bi bi-heart"></i></button>
            <span class="unit-id-badge">ID: MOT-M8628</span>
        </div>
        <div class="unit-card-body">
            <div class="unit-category">RADIO BASE / MOBILE</div>
            <div class="unit-title">Motorola XiR M8628</div>
            <div class="unit-description">Frekuensi UHF 350-400 MHz, radio rig bergerak dan base station dengan...</div>
            <div class="tenor-section">
                <div class="tenor-label">
                    <span>Pilihan Tenor / Masa Sewa:</span>
                    <span class="tenor-selected">12 Bln</span>
                </div>
                <div class="tenor-pills">
                    <button class="tenor-pill" onclick="selectTenor(this)">6 Bln</button>
                    <button class="tenor-pill active" onclick="selectTenor(this)">12 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">24 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">36 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">60 Bln</button>
                </div>
            </div>
            <div class="unit-footer">
                <div class="unit-price-wrap">
                    <span class="unit-price-label">Harga / Bulan</span>
                    <span class="unit-price">Rp 375.000</span>
                </div>
                <button type="button" class="btn-sewa" onclick="openSewaPopup('Motorola XiR M8628', 'RADIO BASE / MOBILE', 'Rp 375.000', 'MOT-M8628')">Sewa <i class="bi bi-arrow-right"></i></button>
            </div>
        </div>
    </div>

    <!-- Card 4: HYTERA MD788 -->
    <div class="unit-card" data-category="radio-base">
        <div class="unit-card-image" style="background: linear-gradient(135deg, #3a2f1e, #6b5a2d);">
            <span class="badge-available"><span class="avail-dot"></span> Tersedia</span>
            <button class="btn-heart" onclick="toggleHeart(this)" title="Favorit"><i class="bi bi-heart"></i></button>
            <span class="unit-id-badge">ID: HYT-MD788</span>
        </div>
        <div class="unit-card-body">
            <div class="unit-category">RADIO BASE / MOBILE</div>
            <div class="unit-title">HYTERA MD788</div>
            <div class="unit-description">UHF 350-400 MHz, layar TFT warna beresolusi tinggi dengan keandalan...</div>
            <div class="tenor-section">
                <div class="tenor-label">
                    <span>Pilihan Tenor / Masa Sewa:</span>
                    <span class="tenor-selected">12 Bln</span>
                </div>
                <div class="tenor-pills">
                    <button class="tenor-pill" onclick="selectTenor(this)">6 Bln</button>
                    <button class="tenor-pill active" onclick="selectTenor(this)">12 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">24 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">36 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">60 Bln</button>
                </div>
            </div>
            <div class="unit-footer">
                <div class="unit-price-wrap">
                    <span class="unit-price-label">Harga / Bulan</span>
                    <span class="unit-price">Rp 450.000</span>
                </div>
                <button type="button" class="btn-sewa" onclick="openSewaPopup('HYTERA MD788', 'RADIO BASE / MOBILE', 'Rp 450.000', 'HYT-MD788')">Sewa <i class="bi bi-arrow-right"></i></button>
            </div>
        </div>
    </div>

    <!-- Card 5: Motorola CP1660 -->
    <div class="unit-card" data-category="radio-ht">
        <div class="unit-card-image" style="background: linear-gradient(135deg, #1e2d3d, #3a5c6e);">
            <span class="badge-available"><span class="avail-dot"></span> Tersedia</span>
            <button class="btn-heart" onclick="toggleHeart(this)" title="Favorit"><i class="bi bi-heart"></i></button>
            <span class="unit-id-badge">ID: MOT-CP1660</span>
        </div>
        <div class="unit-card-body">
            <div class="unit-category">RADIO HT</div>
            <div class="unit-title">Motorola CP1660</div>
            <div class="unit-description">Frekuensi VHF 136-170 MHz & UHF, keypad alfanumerik penuh dengan...</div>
            <div class="tenor-section">
                <div class="tenor-label">
                    <span>Pilihan Tenor / Masa Sewa:</span>
                    <span class="tenor-selected">12 Bln</span>
                </div>
                <div class="tenor-pills">
                    <button class="tenor-pill" onclick="selectTenor(this)">6 Bln</button>
                    <button class="tenor-pill active" onclick="selectTenor(this)">12 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">24 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">36 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">60 Bln</button>
                </div>
            </div>
            <div class="unit-footer">
                <div class="unit-price-wrap">
                    <span class="unit-price-label">Harga / Bulan</span>
                    <span class="unit-price">Rp 175.000</span>
                </div>
                <button type="button" class="btn-sewa" onclick="openSewaPopup('Motorola CP1660', 'RADIO HT', 'Rp 175.000', 'MOT-CP1660')">Sewa <i class="bi bi-arrow-right"></i></button>
            </div>
        </div>
    </div>

    <!-- Card 6: Motorola XiR P6620i -->
    <div class="unit-card" data-category="radio-ht">
        <div class="unit-card-image" style="background: linear-gradient(135deg, #2a1e3d, #5a3d6e);">
            <span class="badge-available"><span class="avail-dot"></span> Tersedia</span>
            <button class="btn-heart" onclick="toggleHeart(this)" title="Favorit"><i class="bi bi-heart"></i></button>
            <span class="unit-id-badge">ID: MOT-P6620i</span>
        </div>
        <div class="unit-card-body">
            <div class="unit-category">RADIO HT</div>
            <div class="unit-title">Motorola XiR P6620i</div>
            <div class="unit-description">Frekuensi UHF 350-400 MHz, audio cerdas generasi terbaru dengan...</div>
            <div class="tenor-section">
                <div class="tenor-label">
                    <span>Pilihan Tenor / Masa Sewa:</span>
                    <span class="tenor-selected">12 Bln</span>
                </div>
                <div class="tenor-pills">
                    <button class="tenor-pill" onclick="selectTenor(this)">6 Bln</button>
                    <button class="tenor-pill active" onclick="selectTenor(this)">12 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">24 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">36 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">60 Bln</button>
                </div>
            </div>
            <div class="unit-footer">
                <div class="unit-price-wrap">
                    <span class="unit-price-label">Harga / Bulan</span>
                    <span class="unit-price">Rp 350.000</span>
                </div>
                <button type="button" class="btn-sewa" onclick="openSewaPopup('Motorola XiR P6620i', 'RADIO HT', 'Rp 350.000', 'MOT-P6620i')">Sewa <i class="bi bi-arrow-right"></i></button>
            </div>
        </div>
    </div>

    <!-- Card 7: HYTERA PD568 -->
    <div class="unit-card" data-category="radio-ht">
        <div class="unit-card-image" style="background: linear-gradient(135deg, #3d2a1e, #6e5a3d);">
            <span class="badge-available"><span class="avail-dot"></span> Tersedia</span>
            <button class="btn-heart" onclick="toggleHeart(this)" title="Favorit"><i class="bi bi-heart"></i></button>
            <span class="unit-id-badge">ID: HYT-PD568</span>
        </div>
        <div class="unit-card-body">
            <div class="unit-category">RADIO HT</div>
            <div class="unit-title">HYTERA PD568</div>
            <div class="unit-description">Frekuensi VHF 136-170 MHz, bodi ergonomis ringan dengan enkripsi...</div>
            <div class="tenor-section">
                <div class="tenor-label">
                    <span>Pilihan Tenor / Masa Sewa:</span>
                    <span class="tenor-selected">12 Bln</span>
                </div>
                <div class="tenor-pills">
                    <button class="tenor-pill" onclick="selectTenor(this)">6 Bln</button>
                    <button class="tenor-pill active" onclick="selectTenor(this)">12 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">24 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">36 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">60 Bln</button>
                </div>
            </div>
            <div class="unit-footer">
                <div class="unit-price-wrap">
                    <span class="unit-price-label">Harga / Bulan</span>
                    <span class="unit-price">Rp 400.000</span>
                </div>
                <button type="button" class="btn-sewa" onclick="openSewaPopup('HYTERA PD568', 'RADIO HT', 'Rp 400.000', 'HYT-PD568')">Sewa <i class="bi bi-arrow-right"></i></button>
            </div>
        </div>
    </div>

    <!-- Card 8: Barret 4050 -->
    <div class="unit-card" data-category="radio-hf">
        <div class="unit-card-image" style="background: linear-gradient(135deg, #1e293b, #334155);">
            <span class="badge-available"><span class="avail-dot"></span> Tersedia</span>
            <button class="btn-heart" onclick="toggleHeart(this)" title="Favorit"><i class="bi bi-heart"></i></button>
            <span class="unit-id-badge">ID: BRT-4050</span>
        </div>
        <div class="unit-card-body">
            <div class="unit-category">RADIO HF SSB</div>
            <div class="unit-title">Barret 4050</div>
            <div class="unit-description">HF Long Range SDR Transceiver 1.6 MHz - 30 MHz, layar sentuh 24-bit...</div>
            <div class="tenor-section">
                <div class="tenor-label">
                    <span>Pilihan Tenor / Masa Sewa:</span>
                    <span class="tenor-selected">12 Bln</span>
                </div>
                <div class="tenor-pills">
                    <button class="tenor-pill" onclick="selectTenor(this)">6 Bln</button>
                    <button class="tenor-pill active" onclick="selectTenor(this)">12 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">24 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">36 Bln</button>
                    <button class="tenor-pill" onclick="selectTenor(this)">60 Bln</button>
                </div>
            </div>
            <div class="unit-footer">
                <div class="unit-price-wrap">
                    <span class="unit-price-label">Harga / Bulan</span>
                    <span class="unit-price">Rp 30.000.000</span>
                </div>
                <button type="button" class="btn-sewa" onclick="openSewaPopup('Barret 4050', 'RADIO HF SSB', 'Rp 30.000.000', 'BRT-4050')">Sewa <i class="bi bi-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="table-pagination" style="border-top: none; background: transparent;">
    <div class="table-pagination-info">Menampilkan 1 - 8 dari 14 unit radio & repeater</div>
    <div class="table-pagination-nav">
        <button>&lt;</button>
        <button class="active">1</button>
        <button>2</button>
        <button>3</button>
        <button style="border: none; background: transparent; cursor: default;">...</button>
        <button>8</button>
        <button>&gt;</button>
    </div>
</div>

<!-- Sewa Popup -->
<div class="popup-modal" id="popupSewa">
    <div class="popup-header">
        <h3><i class="bi bi-cart-plus"></i> Ajukan Penyewaan</h3>
        <button class="popup-close" onclick="closePopup('popupSewa')">&times;</button>
    </div>
    <div class="popup-body">
        <div class="popup-unit-header">
            <div class="popup-unit-icon"><i class="bi bi-broadcast"></i></div>
            <div>
                <div class="popup-unit-name" id="sewaUnitName">-</div>
                <div class="popup-unit-cat" id="sewaUnitCat">-</div>
            </div>
        </div>
        <div class="popup-detail-grid" style="margin-bottom: 1.25rem;">
            <div class="popup-detail-item">
                <div class="popup-detail-label">ID Unit</div>
                <div class="popup-detail-value" id="sewaUnitId">-</div>
            </div>
            <div class="popup-detail-item">
                <div class="popup-detail-label">Harga / Bulan</div>
                <div class="popup-detail-value" id="sewaUnitPrice">-</div>
            </div>
        </div>
        <div class="form-group">
            <label>Durasi Sewa</label>
            <select class="form-control" id="sewaDurasi">
                <option value="6">6 Bulan</option>
                <option value="12" selected>12 Bulan</option>
                <option value="24">24 Bulan</option>
                <option value="36">36 Bulan</option>
                <option value="60">60 Bulan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tanggal Mulai</label>
            <input type="date" class="form-control" id="sewaStartDate">
        </div>
        <div class="form-group">
            <label>Catatan Tambahan</label>
            <textarea class="form-control" placeholder="Lokasi pemasangan, kebutuhan frekuensi khusus, dll..." rows="3"></textarea>
        </div>
        <div style="display: flex; gap: 0.75rem; margin-top: 1rem;">
            <button type="button" class="btn-primary" style="flex: 1; justify-content: center;" onclick="alert('Pengajuan sewa berhasil dikirim! Tim admin akan memverifikasi dalam 24 jam kerja.'); closePopup('popupSewa');">
                <i class="bi bi-send"></i> Ajukan Sewa
            </button>
            <button type="button" class="btn-secondary" style="flex: 1; justify-content: center;" onclick="closePopup('popupSewa')">Batal</button>
        </div>
    </div>
</div>

<!-- Filter Popup -->
<div class="popup-modal" id="popupFilter">
    <div class="popup-header">
        <h3><i class="bi bi-filter"></i> Filter Unit</h3>
        <button class="popup-close" onclick="closePopup('popupFilter')">&times;</button>
    </div>
    <div class="popup-body">
        <div class="form-group">
            <label>Tipe Perangkat</label>
            <select class="form-control">
                <option value="">Semua Tipe</option>
                <option>Repeater</option>
                <option>Radio Base / Mobile</option>
                <option>Radio HT (Handie Talkie)</option>
                <option>Radio HF SSB</option>
            </select>
        </div>
        <div class="form-group">
            <label>Rentang Harga</label>
            <div class="form-row">
                <input type="text" class="form-control" placeholder="Min (Rp)">
                <input type="text" class="form-control" placeholder="Max (Rp)">
            </div>
        </div>
        <div class="form-group">
            <label>Frekuensi</label>
            <select class="form-control">
                <option value="">Semua Frekuensi</option>
                <option>UHF 350-400 MHz</option>
                <option>VHF 136-170 MHz</option>
                <option>HF 1.6-30 MHz</option>
            </select>
        </div>
        <div class="form-group">
            <label>Ketersediaan</label>
            <select class="form-control">
                <option value="">Semua</option>
                <option>Tersedia</option>
                <option>Tersewa</option>
            </select>
        </div>
        <div style="display: flex; gap: 0.75rem; margin-top: 1rem;">
            <button type="button" class="btn-primary" style="flex: 1; justify-content: center;" onclick="closePopup('popupFilter')">
                <i class="bi bi-check2"></i> Terapkan Filter
            </button>
            <button type="button" class="btn-secondary" style="flex: 1; justify-content: center;" onclick="closePopup('popupFilter')">Reset</button>
        </div>
    </div>
</div>

<!-- Sort Popup -->
<div class="popup-modal" id="popupSort">
    <div class="popup-header">
        <h3><i class="bi bi-sort-down"></i> Urutkan</h3>
        <button class="popup-close" onclick="closePopup('popupSort')">&times;</button>
    </div>
    <div class="popup-body">
        <div class="form-group">
            <label>Urutkan Berdasarkan</label>
            <select class="form-control" id="sortBy">
                <option value="name">Nama Perangkat (A-Z)</option>
                <option value="name-desc">Nama Perangkat (Z-A)</option>
                <option value="price-asc">Harga Terendah</option>
                <option value="price-desc">Harga Tertinggi</option>
                <option value="category">Kategori</option>
            </select>
        </div>
        <div style="display: flex; gap: 0.75rem; margin-top: 1rem;">
            <button type="button" class="btn-primary" style="flex: 1; justify-content: center;" onclick="closePopup('popupSort')">
                <i class="bi bi-check2"></i> Terapkan
            </button>
            <button type="button" class="btn-secondary" style="flex: 1; justify-content: center;" onclick="closePopup('popupSort')">Batal</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;
            document.querySelectorAll('.unit-card').forEach(card => {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Heart toggle
    function toggleHeart(btn) {
        btn.classList.toggle('liked');
        const icon = btn.querySelector('i');
        if (btn.classList.contains('liked')) {
            icon.className = 'bi bi-heart-fill';
        } else {
            icon.className = 'bi bi-heart';
        }
    }

    // Tenor selection
    function selectTenor(pill) {
        const pills = pill.parentElement.querySelectorAll('.tenor-pill');
        pills.forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        const label = pill.closest('.tenor-section').querySelector('.tenor-selected');
        if (label) label.textContent = pill.textContent;
    }

    // Sewa popup
    function openSewaPopup(name, category, price, id) {
        document.getElementById('sewaUnitName').textContent = name;
        document.getElementById('sewaUnitCat').textContent = category + ' • ID: ' + id;
        document.getElementById('sewaUnitId').textContent = id;
        document.getElementById('sewaUnitPrice').textContent = price;
        openPopup('popupSewa');
    }

    // Filter & Sort buttons
    document.getElementById('btnFilterUnit')?.addEventListener('click', () => openPopup('popupFilter'));
    document.getElementById('btnSortUnit')?.addEventListener('click', () => openPopup('popupSort'));
</script>
@endpush
