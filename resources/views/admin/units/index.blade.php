@extends('layouts.admin')

@section('title', 'Kelola Data Unit')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/units.css') }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <!-- Page Header  -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="h3 fw-bold mb-1 text-dark">Kelola Data Unit</h2>
            <p class="text-muted mb-0 small">Manajemen inventaris peralatan telekomunikasi dan logistik.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary px-3 py-2 rounded-3 fw-semibold shadow-sm d-inline-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#tambahUnitModal">
                <i class="bi bi-plus-lg fs-6"></i>
                <span>Tambah Unit</span>
            </button>
        </div>
    </div>

    <!-- 3 Metric Cards -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Total Unit -->
        <div class="col-12 col-md-4">
            <div class="metric-card border-blue">
                <div>
                    <div class="metric-label">TOTAL UNIT</div>
                    <div class="metric-value">{{ number_format($totalUnit) }}</div>
                </div>
                <div>
                    <span class="metric-badge blue">+12%</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Tersedia -->
        <div class="col-12 col-md-4">
            <div class="metric-card border-green">
                <div>
                    <div class="metric-label">TERSEDIA</div>
                    <div class="metric-value">{{ number_format($unitTersedia) }}</div>
                </div>
                <div>
                    <span class="metric-badge green">{{ $persenTersedia }}%</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Disewa -->
        <div class="col-12 col-md-4">
            <div class="metric-card border-red">
                <div>
                    <div class="metric-label">DISEWA</div>
                    <div class="metric-value">{{ number_format($unitDisewa) }}</div>
                </div>
                <div>
                    <span class="metric-badge red">{{ $persenDisewa }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Data Card -->
    <div class="inventory-card">
        <!-- Filter Header with Category Tabs -->
        <div class="card-filter-header">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <span class="fw-bold text-dark fs-6">Daftar Unit Inventaris</span>
                <div class="category-tabs">
                    @foreach($kategoriList as $kat)
                        @php
                            $isActive = (request('kategori') == $kat) || (!request('kategori') && $kat == 'Semua');
                        @endphp
                        <a href="{{ route('admin.units.index', array_merge(request()->except('kategori', 'page'), ['kategori' => $kat])) }}" 
                           class="category-tab-btn {{ $isActive ? 'active' : '' }}">
                            {{ $kat }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <!-- Filter Status Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light btn-sm border rounded-pill px-3 dropdown-toggle text-muted" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-funnel me-1"></i> 
                        {{ request('status_unit') ? 'Status: ' . request('status_unit') : 'Semua Status' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                        <li><a class="dropdown-item" href="{{ route('admin.units.index', request()->except('status_unit', 'page')) }}">Semua Status</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.units.index', array_merge(request()->except('page'), ['status_unit' => 'Tersedia'])) }}">Tersedia</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.units.index', array_merge(request()->except('page'), ['status_unit' => 'Disewa'])) }}">Disewa</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.units.index', array_merge(request()->except('page'), ['status_unit' => 'Terjual'])) }}">Terjual</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.units.index', array_merge(request()->except('page'), ['status_unit' => 'Terjual Kredit'])) }}">Terjual Kredit</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.units.index', array_merge(request()->except('page'), ['status_unit' => 'Lunas Kredit'])) }}">Lunas Kredit</a></li>
                    </ul>
                </div>

                @if(request()->hasAny(['search', 'kategori', 'status_unit', 'tipe_unit']))
                    <a href="{{ route('admin.units.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-2" title="Reset Filter">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
        </div>

        <!-- Table View -->
        <div class="table-responsive">
            <table class="table unit-table align-middle">
                <thead>
                    <tr>
                        <th style="min-width: 280px;">NAMA UNIT</th>
                        <th>TIPE</th>
                        <th>HARGA / BULAN</th>
                        <th>STATUS</th>
                        <th class="text-end" style="min-width: 120px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($units as $unit)
                        <tr>
                            <!-- 1. Nama Unit & Thumbnail Foto -->
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $unit->gambar_url }}" 
                                         alt="{{ $unit->nama_unit }}" 
                                         class="unit-thumb shadow-sm"
                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(substr($unit->nama_unit, 0, 2)) }}&background=e2e8f0&color=475569&size=100';">
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $unit->nama_unit }}</div>
                                        <div class="text-muted" style="font-size: 0.76rem;">
                                            ID: <span class="fw-semibold text-secondary">{{ $unit->kode_unit }}</span> 
                                            &bull; {{ $unit->merk }}
                                            @if($unit->deskripsi)
                                                &bull; <span class="text-truncate d-inline-block align-middle" style="max-width: 180px;">{{ Str::limit($unit->deskripsi, 30) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- 2. Tipe / Kategori -->
                            <td>
                                <span class="badge-category">{{ $unit->kategori ?: $unit->tipe_unit }}</span>
                            </td>

                            <!-- 3. Harga / Bulan -->
                            <td>
                                <div class="fw-bold text-dark">{{ $unit->formatted_harga_sewa }}</div>
                                @if($unit->harga_jual > 0)
                                    <div class="text-muted" style="font-size: 0.72rem;">
                                        Jual: {{ $unit->formatted_harga_jual }}
                                    </div>
                                @endif
                            </td>

                            <!-- 4. Status Unit dengan dot warna -->
                            <td>
                                @php
                                    $statusClass = match($unit->status_unit) {
                                        'Tersedia'       => 'tersedia',
                                        'Disewa'         => 'disewa',
                                        'Terjual'        => 'terjual',
                                        'Terjual Kredit' => 'kredit',
                                        'Lunas Kredit'   => 'lunas',
                                        default          => 'tersedia',
                                    };
                                @endphp
                                <span class="status-pill {{ $statusClass }}">
                                    <span class="dot"></span>
                                    <span>{{ strtolower($unit->status_unit) }}</span>
                                </span>
                            </td>

                            <!-- 5. Aksi (Detail, Edit, Hapus) -->
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <!-- Tombol View Detail & Riwayat -->
                                    <button type="button" class="action-btn" title="Detail & Riwayat Status"
                                            onclick="openDetailModal({{ $unit->id_unit }})">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Tombol Edit Unit -->
                                    <button type="button" class="action-btn edit-btn" title="Edit Unit"
                                            onclick="openEditModal(@js($unit))">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <!-- Tombol Hapus Unit -->
                                    <button type="button" class="action-btn delete-btn" title="Hapus Unit"
                                            onclick="confirmDelete({{ $unit->id_unit }}, '{{ addslashes($unit->nama_unit) }}', '{{ $unit->kode_unit }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-box-seam fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                Tidak ada data unit yang sesuai filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card Footer & Pagination  -->
        <div class="p-3 px-4 border-top d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
            <div class="text-muted small">
                Menampilkan <span class="fw-semibold">{{ $units->firstItem() ?? 0 }}</span> - 
                <span class="fw-semibold">{{ $units->lastItem() ?? 0 }}</span> dari 
                <span class="fw-semibold">{{ number_format($units->total()) }}</span> unit
            </div>
            <div>
                {{ $units->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: TAMBAH UNIT BARU (FR-010, Use Case 6)             -->
<!-- ======================================================== -->
<div class="modal fade" id="tambahUnitModal" tabindex="-1" aria-labelledby="tambahUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="{{ route('admin.units.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold" id="tambahUnitModalLabel">
                            <i class="bi bi-plus-circle text-primary me-2"></i> Tambah Unit Inventaris Baru
                        </h5>
                        <p class="text-muted small mb-0">Lengkapi spesifikasi perangkat telekomunikasi untuk disimpan ke database.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Batal"></button>
                </div>

                <div class="modal-body py-3">
                    <div class="row g-3">
                        <!-- Upload Foto Unit -->
                        <div class="col-12 col-md-5">
                            <label class="form-label fw-semibold small">Foto Perangkat</label>
                            <div class="image-preview-container mb-2" onclick="document.getElementById('gambarInputTambah').click()">
                                <img id="previewGambarTambah" src="" alt="Pratinjau Foto" style="display: none;">
                                <div id="placeholderGambarTambah" class="text-center p-3 text-muted">
                                    <i class="bi bi-cloud-arrow-up fs-2 text-primary d-block mb-1"></i>
                                    <span class="small fw-semibold">Pilih atau Seret Foto</span>
                                    <div class="text-secondary" style="font-size: 0.72rem;">PNG, JPG, WEBP (Maks. 4MB)</div>
                                </div>
                            </div>
                            <input type="file" name="gambar" id="gambarInputTambah" class="d-none" accept="image/*"
                                   onchange="previewImage(this, 'previewGambarTambah', 'placeholderGambarTambah')">
                            <div class="form-text small">Unggah gambar nyata perangkat untuk katalog penyewaan.</div>
                        </div>

                        <!-- Info Utama -->
                        <div class="col-12 col-md-7">
                            <div class="row g-2">
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-semibold small">Kode Unit <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="kode_unit" id="kodeUnitTambah" class="form-control form-control-sm" required 
                                               placeholder="contoh: TERA-REP-010" value="{{ old('kode_unit') }}">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="generateKodeUnit('tambah')" title="Generate Kode Otomatis">
                                            <i class="bi bi-magic"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-semibold small">Merk Perangkat <span class="text-danger">*</span></label>
                                    <input type="text" name="merk" class="form-control form-control-sm" required 
                                           placeholder="Motorola / HYTERA / Alinco / Barret" value="{{ old('merk', 'Motorola') }}" list="merkList">
                                    <datalist id="merkList">
                                        <option value="Motorola">
                                        <option value="HYTERA">
                                        <option value="Alinco">
                                        <option value="Barret">
                                        <option value="Icom">
                                    </datalist>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small">Nama Unit / Seri <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_unit" class="form-control form-control-sm" required 
                                           placeholder="contoh: Repeater - Motorola SLR 5300" value="{{ old('nama_unit') }}">
                                </div>

                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-semibold small">Kategori Perangkat <span class="text-danger">*</span></label>
                                    <select name="kategori" class="form-select form-select-sm" required id="kategoriSelectTambah">
                                        <option value="Radio HT" {{ old('kategori') == 'Radio HT' ? 'selected' : '' }}>Radio HT</option>
                                        <option value="Radio Base" {{ old('kategori') == 'Radio Base' ? 'selected' : '' }}>Radio Base</option>
                                        <option value="Repeater" {{ old('kategori') == 'Repeater' ? 'selected' : '' }}>Repeater</option>
                                        <option value="Radio HF SSB" {{ old('kategori') == 'Radio HF SSB' ? 'selected' : '' }}>Radio HF SSB</option>
                                    </select>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-semibold small">Tipe Unit (FR-020) <span class="text-danger">*</span></label>
                                    <select name="tipe_unit" class="form-select form-select-sm" required>
                                        <option value="Sewa" {{ old('tipe_unit') == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                        <option value="Jual Lepas" {{ old('tipe_unit') == 'Jual Lepas' ? 'selected' : '' }}>Jual Lepas</option>
                                        <option value="Jual Kredit" {{ old('tipe_unit') == 'Jual Kredit' ? 'selected' : '' }}>Jual Kredit</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Harga & Status -->
                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-semibold small">Harga Sewa / Bulan (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga_sewa" class="form-control form-control-sm" required min="0" step="1000"
                                   placeholder="0" value="{{ old('harga_sewa', 0) }}">
                        </div>

                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-semibold small">Harga Jual / Unit (Rp)</label>
                            <input type="number" name="harga_jual" class="form-control form-control-sm" min="0" step="1000"
                                   placeholder="0" value="{{ old('harga_jual', 0) }}">
                        </div>

                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-semibold small">Status Awal Unit <span class="text-danger">*</span></label>
                            <select name="status_unit" class="form-select form-select-sm" required>
                                <option value="Tersedia" {{ old('status_unit') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Disewa" {{ old('status_unit') == 'Disewa' ? 'selected' : '' }}>Disewa</option>
                                <option value="Terjual" {{ old('status_unit') == 'Terjual' ? 'selected' : '' }}>Terjual</option>
                                <option value="Terjual Kredit" {{ old('status_unit') == 'Terjual Kredit' ? 'selected' : '' }}>Terjual Kredit</option>
                                <option value="Lunas Kredit" {{ old('status_unit') == 'Lunas Kredit' ? 'selected' : '' }}>Lunas Kredit</option>
                            </select>
                        </div>

                        <!-- Deskripsi / Frekuensi -->
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Deskripsi & Spesifikasi Frekuensi</label>
                            <textarea name="deskripsi" class="form-control form-control-sm" rows="3" 
                                      placeholder="contoh: Frekuensi UHF 350-400 MHz, power 25W, cocok untuk lokasi proyek konstruksi.">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light px-3 rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3 fw-semibold shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan Unit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: EDIT DATA UNIT (Use Case 6 & FR-010)              -->
<!-- ======================================================== -->
<div class="modal fade" id="editUnitModal" tabindex="-1" aria-labelledby="editUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <form id="formEditUnit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold" id="editUnitModalLabel">
                            <i class="bi bi-pencil-square text-primary me-2"></i> Edit Data Unit Perangkat
                        </h5>
                        <p class="text-muted small mb-0">Ubah informasi perangkat, perbarui foto, atau sesuaikan harga.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Batal"></button>
                </div>

                <div class="modal-body py-3">
                    <div class="row g-3">
                        <!-- Upload / Ganti Foto Unit -->
                        <div class="col-12 col-md-5">
                            <label class="form-label fw-semibold small">Foto Perangkat</label>
                            <div class="image-preview-container mb-2" onclick="document.getElementById('gambarInputEdit').click()">
                                <img id="previewGambarEdit" src="" alt="Pratinjau Foto">
                                <div id="placeholderGambarEdit" class="text-center p-3 text-muted" style="display:none;">
                                    <i class="bi bi-cloud-arrow-up fs-2 text-primary d-block mb-1"></i>
                                    <span class="small fw-semibold">Ganti Foto</span>
                                </div>
                            </div>
                            <input type="file" name="gambar" id="gambarInputEdit" class="d-none" accept="image/*"
                                   onchange="previewImage(this, 'previewGambarEdit', 'placeholderGambarEdit')">
                            <div class="form-text small">Klik kotak gambar di atas untuk mengganti foto perangkat.</div>
                        </div>

                        <!-- Info Utama -->
                        <div class="col-12 col-md-7">
                            <div class="row g-2">
                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-semibold small">Kode Unit <span class="text-danger">*</span></label>
                                    <input type="text" name="kode_unit" id="editKodeUnit" class="form-control form-control-sm" required>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-semibold small">Merk Perangkat <span class="text-danger">*</span></label>
                                    <input type="text" name="merk" id="editMerk" class="form-control form-control-sm" required list="merkList">
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small">Nama Unit / Seri <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_unit" id="editNamaUnit" class="form-control form-control-sm" required>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-semibold small">Kategori Perangkat <span class="text-danger">*</span></label>
                                    <select name="kategori" id="editKategori" class="form-select form-select-sm" required>
                                        <option value="Radio HT">Radio HT</option>
                                        <option value="Radio Base">Radio Base</option>
                                        <option value="Repeater">Repeater</option>
                                        <option value="Radio HF SSB">Radio HF SSB</option>
                                    </select>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <label class="form-label fw-semibold small">Tipe Unit (FR-020) <span class="text-danger">*</span></label>
                                    <select name="tipe_unit" id="editTipeUnit" class="form-select form-select-sm" required>
                                        <option value="Sewa">Sewa</option>
                                        <option value="Jual Lepas">Jual Lepas</option>
                                        <option value="Jual Kredit">Jual Kredit</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Harga & Status -->
                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-semibold small">Harga Sewa / Bulan (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga_sewa" id="editHargaSewa" class="form-control form-control-sm" required min="0" step="1000">
                        </div>

                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-semibold small">Harga Jual / Unit (Rp)</label>
                            <input type="number" name="harga_jual" id="editHargaJual" class="form-control form-control-sm" min="0" step="1000">
                        </div>

                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-semibold small">Status Unit <span class="text-danger">*</span></label>
                            <select name="status_unit" id="editStatusUnit" class="form-select form-select-sm" required>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Disewa">Disewa</option>
                                <option value="Terjual">Terjual</option>
                                <option value="Terjual Kredit">Terjual Kredit</option>
                                <option value="Lunas Kredit">Lunas Kredit</option>
                            </select>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Deskripsi & Spesifikasi</label>
                            <textarea name="deskripsi" id="editDeskripsi" class="form-control form-control-sm" rows="2"></textarea>
                        </div>

                        <!-- Catatan Perubahan Status Opsional (Audit Log) -->
                        <div class="col-12">
                            <label class="form-label fw-semibold small text-muted">Catatan Perubahan (Opsional)</label>
                            <input type="text" name="keterangan_status" class="form-control form-control-sm" 
                                   placeholder="contoh: Unit kembali dari rental project PT Adhi Karya">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light px-3 rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3 fw-semibold shadow-sm">
                        <i class="bi bi-check-lg me-1"></i> Perbarui Unit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: DETAIL & RIWAYAT STATUS UNIT (SDD Tabel 8)        -->
<!-- ======================================================== -->
<div class="modal fade" id="detailUnitModal" tabindex="-1" aria-labelledby="detailUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" id="detailUnitModalLabel">
                        <i class="bi bi-info-circle text-primary me-2"></i> Detail & Riwayat Status Perangkat
                    </h5>
                    <p class="text-muted small mb-0" id="detailSubtitle">Memuat data...</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body py-3">
                <div class="row g-4">
                    <!-- Foto & Spesifikasi Ringkas -->
                    <div class="col-12 col-md-4 text-center">
                        <img id="detailUnitFoto" src="" alt="Foto Unit" 
                             class="img-fluid rounded-4 shadow-sm border mb-3" style="max-height: 200px; width: 100%; object-fit: cover;">
                        
                        <div id="detailStatusBadge" class="mb-2"></div>
                        <div class="h5 fw-bold text-dark mb-0" id="detailHargaSewa">Rp 0</div>
                        <div class="text-muted small">Tarif Sewa / Bulan</div>
                    </div>

                    <!-- Detail Spesifikasi -->
                    <div class="col-12 col-md-8">
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Informasi Spesifikasi</h6>
                        <div class="row g-2 small mb-3">
                            <div class="col-6">
                                <span class="text-muted d-block">Kode Unit</span>
                                <span class="fw-bold text-dark" id="detailKodeUnit">-</span>
                            </div>
                            <div class="col-6">
                                <span class="text-muted d-block">Merk Perangkat</span>
                                <span class="fw-bold text-dark" id="detailMerk">-</span>
                            </div>
                            <div class="col-6">
                                <span class="text-muted d-block">Kategori</span>
                                <span class="fw-bold text-dark" id="detailKategori">-</span>
                            </div>
                            <div class="col-6">
                                <span class="text-muted d-block">Tipe Operasi</span>
                                <span class="fw-bold text-dark" id="detailTipeUnit">-</span>
                            </div>
                            <div class="col-12">
                                <span class="text-muted d-block">Deskripsi & Frekuensi</span>
                                <p class="text-dark mb-0" id="detailDeskripsi">-</p>
                            </div>
                        </div>

                        <!-- Riwayat Perubahan Status (Tabel 8 SDD & Trigger trg_log_status_unit) -->
                        <h6 class="fw-bold text-dark border-bottom pb-2 mb-2 d-flex justify-content-between align-items-center">
                            <span>Riwayat Status Unit</span>
                            <small class="text-muted fw-normal" style="font-size: 0.75rem;">Audit Log Otomatis</small>
                        </h6>
                        <div class="table-responsive" style="max-height: 180px; overflow-y: auto;">
                            <table class="table table-sm table-striped align-middle mb-0" style="font-size: 0.78rem;">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                        <th>Admin</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="detailRiwayatTbody">
                                    <tr>
                                        <td colspan="4" class="text-center py-2 text-muted">Memuat data riwayat...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: KONFIRMASI HAPUS UNIT                             -->
<!-- ======================================================== -->
<div class="modal fade" id="deleteUnitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content rounded-4 border-0 shadow">
            <form id="formDeleteUnit" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger">
                        <i class="bi bi-trash3-fill me-2"></i> Konfirmasi Hapus Unit
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Batal"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="text-secondary mb-2">Apakah Anda yakin ingin menghapus data perangkat berikut dari sistem?</p>
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="fw-bold text-dark" id="deleteUnitNama">-</div>
                        <div class="text-muted small" id="deleteUnitKode">-</div>
                    </div>
                    <div class="text-danger small mt-2">
                        <i class="bi bi-exclamation-circle me-1"></i> Data dan foto unit yang telah dihapus tidak dapat dikembalikan.
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light px-3 rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4 rounded-3 fw-semibold">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Live Image Preview Handler
    function previewImage(input, previewImgId, placeholderId) {
        const preview = document.getElementById(previewImgId);
        const placeholder = document.getElementById(placeholderId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto generator format kode unit (contoh: TERA-HT-011)
    function generateKodeUnit(prefix) {
        const kat = document.getElementById('kategoriSelectTambah').value;
        let katCode = 'UNIT';
        if (kat === 'Radio HT') katCode = 'HT';
        else if (kat === 'Repeater') katCode = 'REP';
        else if (kat === 'Radio Base') katCode = 'CR';
        else if (kat === 'Radio HF SSB') katCode = 'BZ';

        const rand = Math.floor(100 + Math.random() * 900);
        document.getElementById('kodeUnitTambah').value = `TERA-${katCode}-${rand}`;
    }

    // Buka Modal Edit dan isi data
    function openEditModal(unit) {
        const form = document.getElementById('formEditUnit');
        form.action = "{{ url('admin/units') }}/" + unit.id_unit;

        document.getElementById('editKodeUnit').value = unit.kode_unit;
        document.getElementById('editNamaUnit').value = unit.nama_unit;
        document.getElementById('editMerk').value = unit.merk;
        document.getElementById('editKategori').value = unit.kategori || 'Radio HT';
        document.getElementById('editTipeUnit').value = unit.tipe_unit || 'Sewa';
        document.getElementById('editHargaSewa').value = unit.harga_sewa;
        document.getElementById('editHargaJual').value = unit.harga_jual;
        document.getElementById('editStatusUnit').value = unit.status_unit;
        document.getElementById('editDeskripsi').value = unit.deskripsi || '';

        // Tampilkan foto saat ini
        const preview = document.getElementById('previewGambarEdit');
        const placeholder = document.getElementById('placeholderGambarEdit');
        if (unit.gambar) {
            preview.src = "{{ asset('storage') }}/" + unit.gambar;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        } else {
            preview.src = "https://ui-avatars.com/api/?name=" + encodeURIComponent(unit.nama_unit.substring(0, 2)) + "&background=e2e8f0&color=475569&size=200";
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }

        const modal = new bootstrap.Modal(document.getElementById('editUnitModal'));
        modal.show();
    }

    // Buka Modal Detail & Ambil Riwayat Status via AJAX
    function openDetailModal(id) {
        const modalEl = document.getElementById('detailUnitModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        document.getElementById('detailSubtitle').innerText = 'Memuat rincian unit...';
        document.getElementById('detailRiwayatTbody').innerHTML = '<tr><td colspan="4" class="text-center py-3 text-muted">Memuat riwayat status...</td></tr>';

        fetch("{{ url('admin/units') }}/" + id)
            .then(res => res.json())
            .then(data => {
                const u = data.unit;
                document.getElementById('detailSubtitle').innerText = u.nama_unit + ' (' + u.kode_unit + ')';
                document.getElementById('detailKodeUnit').innerText = u.kode_unit;
                document.getElementById('detailMerk').innerText = u.merk;
                document.getElementById('detailKategori').innerText = u.kategori || '-';
                document.getElementById('detailTipeUnit').innerText = u.tipe_unit || 'Sewa';
                document.getElementById('detailDeskripsi').innerText = u.deskripsi || 'Tidak ada keterangan tambahan.';
                document.getElementById('detailHargaSewa').innerText = data.harga_sewa_fmt;
                document.getElementById('detailUnitFoto').src = data.gambar_url;

                // Status Badge
                let badgeClass = 'tersedia';
                if (u.status_unit === 'Disewa') badgeClass = 'disewa';
                else if (u.status_unit === 'Terjual') badgeClass = 'terjual';
                else if (u.status_unit === 'Terjual Kredit') badgeClass = 'kredit';
                else if (u.status_unit === 'Lunas Kredit') badgeClass = 'lunas';

                document.getElementById('detailStatusBadge').innerHTML = `
                    <span class="status-pill ${badgeClass}">
                        <span class="dot"></span>
                        <span>${u.status_unit}</span>
                    </span>
                `;

                // Riwayat Status Table
                if (data.riwayat && data.riwayat.length > 0) {
                    let html = '';
                    data.riwayat.forEach(r => {
                        html += `
                            <tr>
                                <td class="text-muted">${r.tanggal}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">${r.status_lama}</span>
                                    <i class="bi bi-arrow-right mx-1 text-muted"></i>
                                    <span class="badge bg-primary-subtle text-primary border">${r.status_baru}</span>
                                </td>
                                <td>${r.admin}</td>
                                <td class="text-secondary">${r.keterangan || '-'}</td>
                            </tr>
                        `;
                    });
                    document.getElementById('detailRiwayatTbody').innerHTML = html;
                } else {
                    document.getElementById('detailRiwayatTbody').innerHTML = '<tr><td colspan="4" class="text-center py-2 text-muted">Belum ada riwayat perubahan status.</td></tr>';
                }
            })
            .catch(err => {
                document.getElementById('detailRiwayatTbody').innerHTML = '<tr><td colspan="4" class="text-center py-2 text-danger">Gagal memuat data detail.</td></tr>';
            });
    }

    // Konfirmasi Hapus Unit
    function confirmDelete(id, nama, kode) {
        const form = document.getElementById('formDeleteUnit');
        form.action = "{{ url('admin/units') }}/" + id;
        document.getElementById('deleteUnitNama').innerText = nama;
        document.getElementById('deleteUnitKode').innerText = 'Kode Unit: ' + kode;

        const modal = new bootstrap.Modal(document.getElementById('deleteUnitModal'));
        modal.show();
    }
</script>
@endpush
