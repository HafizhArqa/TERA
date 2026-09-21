@extends('layouts.admin')

@section('title', 'Equipment Inventory Status')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/status-unit.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <!-- Top Header Title & Actions -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h1 class="page-title">Equipment Inventory Status</h1>
            <p class="page-subtitle">Real-time monitoring of telecom units across all facilities.</p>
        </div>

        <div class="d-flex align-items-center gap-3">
            <!-- View Mode Switcher: Grid View | List View -->
            <div class="view-toggle-group">
                <a href="{{ request()->fullUrlWithQuery(['view' => 'grid']) }}" 
                   class="view-toggle-btn {{ $viewMode === 'grid' ? 'active' : '' }}" title="Tampilan Kartu Grid">
                    <i class="bi bi-grid-fill"></i>
                    <span>Grid View</span>
                </a>
                <a href="{{ request()->fullUrlWithQuery(['view' => 'list']) }}" 
                   class="view-toggle-btn {{ $viewMode === 'list' ? 'active' : '' }}" title="Tampilan Tabel List">
                    <i class="bi bi-list-ul"></i>
                    <span>List View</span>
                </a>
            </div>

            <!-- Action Button: Register New Unit -->
            <button type="button" class="btn-register-unit" data-bs-toggle="modal" data-bs-target="#registerUnitModal">
                <i class="bi bi-plus-lg"></i>
                <span>Register New Unit</span>
            </button>
        </div>
    </div>

    <!-- Alert Notifikasi Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Terjadi kesalahan pengisian data:</div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Metric Summary Cards  -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Units -->
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-icon-wrapper stat-icon-blue">
                    <i class="bi bi-archive"></i>
                </div>
                <div>
                    <div class="stat-label">TOTAL UNITS</div>
                    <div class="stat-number">{{ number_format($totalUnit) }}</div>
                </div>
            </div>
        </div>

        <!-- 2. Available -->
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-icon-wrapper stat-icon-green">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <div>
                    <div class="stat-label">AVAILABLE</div>
                    <div class="stat-number">{{ number_format($unitTersedia) }}</div>
                </div>
            </div>
        </div>

        <!-- 3. Rented -->
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-icon-wrapper stat-icon-red">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <div class="stat-label">RENTED</div>
                    <div class="stat-number">{{ number_format($unitDisewa) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Pills & Search Filter Row -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <!-- Category Filter Pills -->
        <div class="category-pills-wrap">
            @foreach($categories as $cat)
                @php
                    $isActive = request('kategori') === $cat || (!request('kategori') && $cat === 'All Categories');
                @endphp
                <a href="{{ request()->fullUrlWithQuery(['kategori' => $cat === 'All Categories' ? null : $cat, 'page' => 1]) }}" 
                   class="cat-pill {{ $isActive ? 'active' : '' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <!-- Status Filter Dropdown & Quick Search -->
        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('admin.status-unit.index') }}" method="GET" class="d-flex align-items-center gap-2">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                @if(request('view'))
                    <input type="hidden" name="view" value="{{ request('view') }}">
                @endif

                <select name="status_unit" class="form-select form-select-sm status-filter-select" 
                        onchange="this.form.submit()" style="font-size: 0.82rem; font-weight: 600; min-width: 150px;">
                    <option value="All" {{ request('status_unit') == 'All' || !request('status_unit') ? 'selected' : '' }}>Semua Status</option>
                    <option value="Tersedia" {{ request('status_unit') == 'Tersedia' ? 'selected' : '' }}>Tersedia (Available)</option>
                    <option value="Disewa" {{ request('status_unit') == 'Disewa' ? 'selected' : '' }}>Disewa (Rented)</option>
                    <option value="Terjual" {{ request('status_unit') == 'Terjual' ? 'selected' : '' }}>Terjual (Sold)</option>
                    <option value="Terjual Kredit" {{ request('status_unit') == 'Terjual Kredit' ? 'selected' : '' }}>Terjual Kredit</option>
                    <option value="Lunas Kredit" {{ request('status_unit') == 'Lunas Kredit' ? 'selected' : '' }}>Lunas Kredit</option>
                </select>

                @if(request('search') || request('status_unit') || request('kategori'))
                    <a href="{{ route('admin.status-unit.index', ['view' => $viewMode]) }}" class="btn btn-sm btn-light border rounded-pill px-2" title="Reset Filter">
                        <i class="bi bi-x-circle text-muted"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Main View Section: Grid View vs List View -->
    @if($viewMode === 'grid')
        <!-- GRID VIEW -->
        <div class="row g-4 mb-4">
            @forelse($units as $unit)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="unit-inventory-card">
                        <!-- Top Thumbnail & Floating Badge -->
                        <div class="unit-card-thumb-wrap">
                            <!-- Status Badge -->
                            @if($unit->status_unit === 'Tersedia')
                                <span class="card-status-badge badge-available">
                                    <i class="bi bi-check-circle-fill"></i> AVAILABLE
                                </span>
                            @elseif($unit->status_unit === 'Disewa')
                                <span class="card-status-badge badge-rented">
                                    <i class="bi bi-clock-fill"></i> RENTED
                                </span>
                            @elseif($unit->status_unit === 'Terjual Kredit')
                                <span class="card-status-badge badge-credit">
                                    <i class="bi bi-credit-card-fill"></i> KREDIT
                                </span>
                            @elseif($unit->status_unit === 'Lunas Kredit')
                                <span class="card-status-badge badge-paid">
                                    <i class="bi bi-shield-check"></i> LUNAS
                                </span>
                            @else
                                <span class="card-status-badge badge-sold">
                                    <i class="bi bi-bag-check-fill"></i> TERJUAL
                                </span>
                            @endif

                            <!-- Device Photo -->
                            <img src="{{ $unit->gambar_url }}" alt="{{ $unit->nama_unit }}" loading="lazy">
                        </div>

                        <!-- Card Body -->
                        <div class="unit-card-body">
                            <span class="unit-code-badge">{{ $unit->kode_unit }}</span>
                            <h5 class="unit-device-name" title="{{ $unit->nama_unit }}">{{ $unit->nama_unit }}</h5>

                            <!-- Contextual Metadata Row -->
                            <div class="unit-card-meta-row">
                                <div class="meta-col">
                                    @if($unit->status_unit === 'Disewa')
                                        <div class="meta-title">{{ $unit->klien_aktif ? 'Current Client:' : 'Deployment Area:' }}</div>
                                        <div class="meta-content" title="{{ $unit->klien_aktif ?: ($unit->lokasi ?: 'Klien Aktif') }}">
                                            {{ $unit->klien_aktif ?: ($unit->lokasi ?: 'Klien Aktif') }}
                                        </div>
                                    @elseif($unit->status_unit === 'Tersedia')
                                        <div class="meta-title">{{ $unit->info_tambahan ? 'Info Status:' : 'Storage Loc:' }}</div>
                                        <div class="meta-content" title="{{ $unit->info_tambahan ?: ($unit->lokasi ?: 'Gudang Utama') }}">
                                            {{ $unit->info_tambahan ?: ($unit->lokasi ?: 'Gudang Utama') }}
                                        </div>
                                    @else
                                        <div class="meta-title">Info:</div>
                                        <div class="meta-content" title="{{ $unit->info_tambahan ?: $unit->status_unit }}">
                                            {{ $unit->info_tambahan ?: $unit->status_unit }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Three Dots Menu (⋮) -->
                                <div class="dropdown">
                                    <button class="card-actions-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Opsi">
                                        <i class="bi bi-three-dots-vertical fs-5"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 py-2" style="font-size: 0.85rem;">
                                        <li>
                                            <a class="dropdown-item py-2 d-flex align-items-center gap-2 text-primary fw-semibold btn-open-status-modal" 
                                               href="javascript:void(0)"
                                               data-id="{{ $unit->id_unit }}"
                                               data-kode="{{ $unit->kode_unit }}"
                                               data-nama="{{ $unit->nama_unit }}"
                                               data-merk="{{ $unit->merk }}"
                                               data-status="{{ $unit->status_unit }}"
                                               data-lokasi="{{ $unit->lokasi }}"
                                               data-klien="{{ $unit->klien_aktif }}"
                                               data-info="{{ $unit->info_tambahan }}"
                                               data-kembali="{{ $unit->tgl_kembali ? $unit->tgl_kembali->format('Y-m-d') : '' }}">
                                                <i class="bi bi-sliders"></i>
                                                <span>Ubah Status Unit</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2 d-flex align-items-center gap-2 btn-open-history-modal" 
                                               href="javascript:void(0)"
                                               data-id="{{ $unit->id_unit }}"
                                               data-kode="{{ $unit->kode_unit }}"
                                               data-nama="{{ $unit->nama_unit }}">
                                                <i class="bi bi-clock-history text-secondary"></i>
                                                <span>Riwayat Status</span>
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('admin.units.index', ['search' => $unit->kode_unit]) }}">
                                                <i class="bi bi-pencil-square text-muted"></i>
                                                <span>Edit Data Inventaris</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 bg-white rounded-4 border">
                        <i class="bi bi-inbox text-muted display-4 mb-3"></i>
                        <h5 class="fw-bold text-dark">Unit Tidak Ditemukan</h5>
                        <p class="text-muted small">Tidak ada perangkat yang sesuai dengan kriteria filter atau pencarian Anda.</p>
                        <a href="{{ route('admin.status-unit.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            Reset Filter
                        </a>
                    </div>
                </div>
            @endforelse

            <!-- Dashed "+ Add Unit" Card -->
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="add-unit-dashed-card" data-bs-toggle="modal" data-bs-target="#registerUnitModal">
                    <div class="add-unit-plus-circle">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                    <div class="add-unit-label">Add Unit</div>
                    <div class="add-unit-subtext">Register a new telecom asset to the system</div>
                </div>
            </div>
        </div>
    @else
        <!-- LIST VIEW (Tabel Lengkap Monitoring Status Unit) -->
        <div class="list-view-card mb-4">
            <div class="table-responsive">
                <table class="table align-middle mb-0" style="font-size: 0.88rem;">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 100px;">FOTO</th>
                            <th>KODE UNIT</th>
                            <th>NAMA PERANGKAT</th>
                            <th>KATEGORI</th>
                            <th>STATUS TERKINI</th>
                            <th>LOKASI / KLIEN</th>
                            <th>TARIF SEWA</th>
                            <th class="text-end pe-4">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units as $unit)
                            <tr>
                                <td class="ps-4">
                                    <div class="rounded-3 bg-light p-1 d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px;">
                                        <img src="{{ $unit->gambar_url }}" alt="{{ $unit->nama_unit }}" class="img-fluid" style="max-height: 42px; object-fit: contain;">
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ $unit->kode_unit }}</span>
                                    <div class="text-muted small">{{ $unit->merk }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $unit->nama_unit }}</div>
                                    <div class="text-muted small">{{ $unit->tipe_unit }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $unit->kategori }}</span>
                                </td>
                                <td>
                                    @if($unit->status_unit === 'Tersedia')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill">
                                            <i class="bi bi-check-circle-fill me-1"></i> Available
                                        </span>
                                    @elseif($unit->status_unit === 'Disewa')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill">
                                            <i class="bi bi-clock-fill me-1"></i> Rented
                                        </span>
                                    @elseif($unit->status_unit === 'Terjual Kredit')
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1 rounded-pill">
                                            Terjual Kredit
                                        </span>
                                    @elseif($unit->status_unit === 'Lunas Kredit')
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-pill">
                                            Lunas Kredit
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border px-2 py-1 rounded-pill">
                                            {{ $unit->status_unit }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-dark fw-semibold">{{ $unit->klien_aktif ?: ($unit->lokasi ?: '-') }}</div>
                                    <div class="text-muted small">{{ $unit->info_tambahan ?: 'Unit ID #' . $unit->id_unit }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $unit->formatted_harga_sewa }}</div>
                                    <div class="text-muted small">/ periode</div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 btn-open-status-modal me-1"
                                                data-id="{{ $unit->id_unit }}"
                                                data-kode="{{ $unit->kode_unit }}"
                                                data-nama="{{ $unit->nama_unit }}"
                                                data-merk="{{ $unit->merk }}"
                                                data-status="{{ $unit->status_unit }}"
                                                data-lokasi="{{ $unit->lokasi }}"
                                                data-klien="{{ $unit->klien_aktif }}"
                                                data-info="{{ $unit->info_tambahan }}"
                                                data-kembali="{{ $unit->tgl_kembali ? $unit->tgl_kembali->format('Y-m-d') : '' }}">
                                            <i class="bi bi-sliders me-1"></i> Ubah Status
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-light border rounded-pill px-2 py-1 btn-open-history-modal"
                                                title="Riwayat Status"
                                                data-id="{{ $unit->id_unit }}"
                                                data-kode="{{ $unit->kode_unit }}"
                                                data-nama="{{ $unit->nama_unit }}">
                                            <i class="bi bi-clock-history"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    Tidak ada data unit yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Bottom Footer Info & Pagination -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 pt-2">
        <div class="text-muted small">
            Showing {{ $units->firstItem() ?? 0 }}-{{ $units->lastItem() ?? 0 }} of {{ number_format($units->total()) }} units
        </div>

        <div>
            {{ $units->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 1: KELOLA STATUS UNIT (FR-015, USE CASE 10 KELOLA STATUS UNIT SDD)   -->
<!-- ========================================================================= -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom py-3 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-0" id="updateStatusModalLabel">Ubah Status Perangkat</h5>
                    <small class="text-muted" id="modalUnitSubTitle">Kelola ketersediaan operasional unit secara real-time</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="updateStatusForm" method="POST" action="">
                @csrf
                @method('PATCH')
                
                <div class="modal-body p-4">
                    <!-- Preview Info Perangkat -->
                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold text-primary" id="modalKodeUnit">RADIO-HT-001</span>
                            <span class="badge bg-secondary" id="modalStatusLamaBadge">Tersedia</span>
                        </div>
                        <div class="fw-bold text-dark" id="modalNamaUnit">Radio Base-Motorola</div>
                        <div class="text-muted small" id="modalMerkUnit">Merk: Motorola</div>
                    </div>

                    <!-- Pilihan Status Baru (SDD Use Case 10) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Pilih Status Baru <span class="text-danger">*</span></label>
                        <select name="status_unit" id="modalSelectStatus" class="form-select rounded-3" required>
                            <option value="Tersedia">Tersedia (Available / Siap Digunakan)</option>
                            <option value="Disewa">Disewa (Rented / Sedang Dipakai Klien)</option>
                            <option value="Terjual">Terjual (Sold / Jual Lepas Tunai)</option>
                            <option value="Terjual Kredit">Terjual Kredit (Cicilan Berjalan)</option>
                            <option value="Lunas Kredit">Lunas Kredit (Cicilan Selesai)</option>
                        </select>
                    </div>

                    <!-- Field Kontekstual Berdasarkan Status -->
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-6" id="fieldKlienWrap">
                            <label class="form-label fw-semibold text-dark small">Klien / Penyewa</label>
                            <input type="text" name="klien_aktif" id="modalInputKlien" class="form-control rounded-3" placeholder="Contoh: PT. Tech Solutions">
                        </div>
                        <div class="col-12 col-md-6" id="fieldLokasiWrap">
                            <label class="form-label fw-semibold text-dark small">Lokasi Unit / Site</label>
                            <input type="text" name="lokasi" id="modalInputLokasi" class="form-control rounded-3" placeholder="Contoh: Warehouse A-4">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-6" id="fieldKembaliWrap">
                            <label class="form-label fw-semibold text-dark small">Tgl Estimasi Pengembalian</label>
                            <input type="date" name="tgl_kembali" id="modalInputKembali" class="form-control rounded-3">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold text-dark small">Catatan Singkat (Label Card)</label>
                            <input type="text" name="info_tambahan" id="modalInputInfo" class="form-control rounded-3" placeholder="Contoh: Last Service: 12 Oct 2023">
                        </div>
                    </div>

                    <!-- Keterangan Alasan Audit Log (Tabel 8 SDD) -->
                    <div class="mb-2">
                        <label class="form-label fw-semibold text-dark small">Keterangan / Alasan Perubahan <span class="text-muted fw-normal">(Dicatat ke Audit Log)</span></label>
                        <textarea name="keterangan" id="modalInputKeterangan" rows="2" class="form-control rounded-3" placeholder="Contoh: Perangkat telah selesai disewa dan diperiksa kondisinya..."></textarea>
                    </div>
                </div>

                <div class="modal-footer border-top py-3 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 2: RIWAYAT STATUS UNIT / AUDIT TRAIL (TABEL 8 SDD)                  -->
<!-- ========================================================================= -->
<div class="modal fade" id="historyStatusModal" tabindex="-1" aria-labelledby="historyStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom py-3 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-0" id="historyStatusModalLabel">Riwayat Perubahan Status</h5>
                    <small class="text-muted" id="historyModalSubtitle">Audit log mutasi ketersediaan perangkat</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div id="historyLoadingSpinner" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="text-muted small mt-2">Memuat riwayat status...</div>
                </div>

                <div id="historyContentWrap" style="display: none;">
                    <div class="p-3 bg-light rounded-3 border mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold text-primary fs-6" id="historyUnitKode">RADIO-HT-001</span>
                            <span class="text-dark fw-semibold ms-2" id="historyUnitNama">Radio Base-Motorola</span>
                        </div>
                        <span class="badge bg-primary rounded-pill px-3 py-1" id="historyCurrentBadge">Tersedia</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle" style="font-size: 0.85rem;">
                            <thead class="table-light">
                                <tr>
                                    <th>WAKTU</th>
                                    <th>STATUS SEBELUMNYA</th>
                                    <th>STATUS BARU</th>
                                    <th>ADMIN</th>
                                    <th>KETERANGAN</th>
                                </tr>
                            </thead>
                            <tbody id="historyTableBody">
                                <!-- Konten dinamis via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-top py-3 px-4">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 3: REGISTER NEW UNIT (FAST ASSET REGISTRATION)                       -->
<!-- ========================================================================= -->
<div class="modal fade" id="registerUnitModal" tabindex="-1" aria-labelledby="registerUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom py-3 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-0" id="registerUnitModalLabel">Register New Telecom Unit</h5>
                    <small class="text-muted">Daftarkan unit perangkat telekomunikasi baru ke sistem TERA</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.status-unit.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold small">Kode Unit <span class="text-danger">*</span></label>
                            <input type="text" name="kode_unit" class="form-control rounded-3" placeholder="Contoh: RADIO-HT-011" required>
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label fw-semibold small">Nama Perangkat <span class="text-danger">*</span></label>
                            <input type="text" name="nama_unit" class="form-control rounded-3" placeholder="Contoh: Radio HT - Motorola XiR P8660i" required>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold small">Merk / Brand <span class="text-danger">*</span></label>
                            <input type="text" name="merk" class="form-control rounded-3" placeholder="Motorola / Hytera / Barret" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold small">Kategori Perangkat <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-select rounded-3" required>
                                <option value="HT Radios">HT Radios</option>
                                <option value="Microwave Links">Microwave Links</option>
                                <option value="VSAT Terminals">VSAT Terminals</option>
                                <option value="Power Systems">Power Systems</option>
                                <option value="Repeater">Repeater</option>
                                <option value="Radio Base">Radio Base</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold small">Tipe Unit <span class="text-danger">*</span></label>
                            <select name="tipe_unit" class="form-select rounded-3" required>
                                <option value="Sewa">Sewa</option>
                                <option value="Jual Lepas">Jual Lepas</option>
                                <option value="Jual Kredit">Jual Kredit</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold small">Harga Sewa (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga_sewa" class="form-control rounded-3" value="0" min="0" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold small">Harga Jual (Rp)</label>
                            <input type="number" name="harga_jual" class="form-control rounded-3" value="0" min="0">
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold small">Status Awal <span class="text-danger">*</span></label>
                            <select name="status_unit" class="form-select rounded-3" required>
                                <option value="Tersedia" selected>Tersedia (Available)</option>
                                <option value="Disewa">Disewa (Rented)</option>
                                <option value="Terjual">⚪ Terjual</option>
                                <option value="Terjual Kredit">Terjual Kredit</option>
                                <option value="Lunas Kredit">Lunas Kredit</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold small">Lokasi Penyimpanan</label>
                            <input type="text" name="lokasi" class="form-control rounded-3" placeholder="Contoh: Warehouse A-4">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold small">Keterangan Label</label>
                            <input type="text" name="info_tambahan" class="form-control rounded-3" placeholder="Contoh: Battery Level: 98% Charged">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small">Foto Perangkat</label>
                            <input type="file" name="gambar" class="form-control rounded-3" accept="image/*">
                            <div class="form-text small">Format JPG, PNG, WEBP maksimal 4MB.</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small">Deskripsi Spesifikasi Teknis</label>
                            <textarea name="deskripsi" rows="2" class="form-control rounded-3" placeholder="Frekuensi kerja, daya pancar, kelengkapan aksesoris..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top py-3 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                        <i class="bi bi-save me-1"></i> Daftarkan Unit Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const updateStatusModal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
        const historyStatusModal = new bootstrap.Modal(document.getElementById('historyStatusModal'));
        const updateStatusForm = document.getElementById('updateStatusForm');

        // Event listener saat tombol 'Ubah Status Unit' diklik
        document.querySelectorAll('.btn-open-status-modal').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const kode = this.dataset.kode;
                const nama = this.dataset.nama;
                const merk = this.dataset.merk;
                const status = this.dataset.status;
                const lokasi = this.dataset.lokasi || '';
                const klien = this.dataset.klien || '';
                const info = this.dataset.info || '';
                const kembali = this.dataset.kembali || '';

                // Set form action route
                updateStatusForm.action = `/admin/status-unit/${id}`;

                // Populate modal data
                document.getElementById('modalKodeUnit').textContent = kode;
                document.getElementById('modalNamaUnit').textContent = nama;
                document.getElementById('modalMerkUnit').textContent = `Merk: ${merk}`;
                document.getElementById('modalStatusLamaBadge').textContent = status;

                const selectStatus = document.getElementById('modalSelectStatus');
                selectStatus.value = status;

                document.getElementById('modalInputLokasi').value = lokasi;
                document.getElementById('modalInputKlien').value = klien;
                document.getElementById('modalInputInfo').value = info;
                document.getElementById('modalInputKembali').value = kembali;
                document.getElementById('modalInputKeterangan').value = '';

                updateStatusModal.show();
            });
        });

        // Event listener saat tombol 'Riwayat Status' diklik (Audit Log)
        document.querySelectorAll('.btn-open-history-modal').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const kode = this.dataset.kode;
                const nama = this.dataset.nama;

                document.getElementById('historyUnitKode').textContent = kode;
                document.getElementById('historyUnitNama').textContent = nama;

                document.getElementById('historyLoadingSpinner').style.display = 'block';
                document.getElementById('historyContentWrap').style.display = 'none';

                historyStatusModal.show();

                fetch(`/admin/status-unit/${id}/history`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('historyCurrentBadge').textContent = data.unit.status_unit;

                    const tbody = document.getElementById('historyTableBody');
                    tbody.innerHTML = '';

                    if (data.riwayat && data.riwayat.length > 0) {
                        data.riwayat.forEach(item => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td class="text-nowrap text-muted">${item.tanggal}</td>
                                <td><span class="badge bg-secondary-subtle text-secondary border">${item.status_lama}</span></td>
                                <td><span class="badge bg-primary-subtle text-primary border">${item.status_baru}</span></td>
                                <td class="fw-semibold text-dark">${item.admin}</td>
                                <td class="text-muted">${item.keterangan || '-'}</td>
                            `;
                            tbody.appendChild(tr);
                        });
                    } else {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="5" class="text-center py-3 text-muted">
                                    Belum ada catatan riwayat perubahan status untuk unit ini.
                                </td>
                            </tr>
                        `;
                    }

                    document.getElementById('historyLoadingSpinner').style.display = 'none';
                    document.getElementById('historyContentWrap').style.display = 'block';
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById('historyLoadingSpinner').innerHTML = `
                        <div class="text-danger py-3">
                            <i class="bi bi-exclamation-circle me-1"></i> Gagal memuat riwayat status.
                        </div>
                    `;
                });
            });
        });
    });
</script>
@endpush
