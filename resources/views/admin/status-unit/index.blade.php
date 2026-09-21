@extends('layouts.admin')

@section('title', 'Equipment Inventory Status')

@push('styles')
<style>
    /* Header & Action Controls */
    .page-title {
        font-size: 1.65rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
        margin-bottom: 0.25rem;
    }
    .page-subtitle {
        color: #64748b;
        font-size: 0.88rem;
        margin-bottom: 0;
    }

    /* View Mode Toggle Switch (Grid / List) */
    .view-toggle-group {
        background-color: #f1f5f9;
        padding: 4px;
        border-radius: 10px;
        display: inline-flex;
        border: 1px solid #e2e8f0;
    }
    .view-toggle-btn {
        padding: 0.45rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .view-toggle-btn:hover {
        color: #1e293b;
    }
    .view-toggle-btn.active {
        background-color: #ffffff;
        color: #2563eb;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    .btn-register-unit {
        background-color: #2563eb;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 0.55rem 1.25rem;
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        text-decoration: none;
    }
    .btn-register-unit:hover {
        background-color: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    }

  
    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        gap: 1.25rem;
        height: 100%;
        transition: transform 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
    }
    .stat-icon-wrapper {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .stat-icon-blue {
        background-color: #eff6ff;
        color: #2563eb;
    }
    .stat-icon-green {
        background-color: #ecfdf5;
        color: #10b981;
    }
    .stat-icon-red {
        background-color: #fef2f2;
        color: #ef4444;
    }
    .stat-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.6px;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 0.25rem;
    }
    .stat-number {
        font-size: 1.75rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }

    /* Category Filter Pills */
    .category-pills-wrap {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        overflow-x: auto;
        padding-bottom: 4px;
        scrollbar-width: thin;
    }
    .cat-pill {
        padding: 0.45rem 1.15rem;
        font-size: 0.82rem;
        font-weight: 600;
        border-radius: 9999px;
        text-decoration: none;
        border: 1px solid #e2e8f0;
        background-color: #ffffff;
        color: #64748b;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .cat-pill:hover {
        background-color: #f8fafc;
        color: #1e293b;
        border-color: #cbd5e1;
    }
    .cat-pill.active {
        background-color: #eff6ff;
        color: #2563eb;
        border-color: #3b82f6;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.12);
    }

    .unit-inventory-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    .unit-inventory-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }

    .unit-card-thumb-wrap {
        height: 160px;
        background: linear-gradient(135deg, #f8fafc 0%, #edf2f7 100%);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid #f1f5f9;
    }
    .unit-card-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 0.75rem;
        transition: transform 0.3s ease;
    }
    .unit-inventory-card:hover .unit-card-thumb-wrap img {
        transform: scale(1.05);
    }

    /* Floating Status Badge on Card */
    .card-status-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 2;
        padding: 0.28rem 0.65rem;
        border-radius: 9999px;
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }
    .badge-available {
        background-color: #ffffff;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }
    .badge-rented {
        background-color: #ffffff;
        color: #dc2626;
        border: 1px solid #fecaca;
    }
    .badge-sold {
        background-color: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
    }
    .badge-credit {
        background-color: #ffffff;
        color: #d97706;
        border: 1px solid #fde68a;
    }
    .badge-paid {
        background-color: #ffffff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }

    .unit-card-body {
        padding: 1.15rem 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .unit-code-badge {
        font-size: 0.75rem;
        font-weight: 700;
        color: #2563eb;
        letter-spacing: 0.4px;
        margin-bottom: 0.25rem;
        display: block;
        text-transform: uppercase;
    }
    .unit-device-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.85rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .unit-card-meta-row {
        margin-top: auto;
        padding-top: 0.75rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
    }
    .meta-col {
        min-width: 0;
    }
    .meta-title {
        font-size: 0.72rem;
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 2px;
        text-transform: capitalize;
    }
    .meta-content {
        font-size: 0.82rem;
        font-weight: 700;
        color: #334155;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 145px;
    }

    /* Three Dots Action Button */
    .card-actions-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        color: #94a3b8;
        transition: all 0.2s;
    }
    .card-actions-btn:hover {
        background-color: #f1f5f9;
        color: #1e293b;
    }

    /* Dashed "+ Add Unit" Card */
    .add-unit-dashed-card {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem 1.5rem;
        min-height: 280px;
        height: 100%;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .add-unit-dashed-card:hover {
        border-color: #2563eb;
        background-color: #eff6ff;
        transform: translateY(-4px);
    }
    .add-unit-plus-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        color: #64748b;
        margin-bottom: 0.75rem;
        transition: all 0.2s;
    }
    .add-unit-dashed-card:hover .add-unit-plus-circle {
        background-color: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }
    .add-unit-label {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }
    .add-unit-subtext {
        font-size: 0.78rem;
        color: #94a3b8;
        max-width: 170px;
        line-height: 1.35;
    }

    /* List View Table */
    .list-view-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        overflow: hidden;
    }

    /* Timeline Audit Log */
    .timeline-audit {
        position: relative;
        padding-left: 24px;
    }
    .timeline-audit::before {
        content: '';
        position: absolute;
        top: 6px;
        bottom: 6px;
        left: 8px;
        width: 2px;
        background: #e2e8f0;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 1.25rem;
    }
    .timeline-point {
        position: absolute;
        left: -24px;
        top: 4px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #2563eb;
        border: 3px solid #eff6ff;
    }

    /* =========================================================
       STATUS UNIT - CLEAN MODERN POLISH
       ========================================================= */

    /* Filter status */
    .status-filter-select {
        min-width: 180px;
        height: 38px;
        padding: 0 2.35rem 0 .95rem !important;
        border: 1px solid #dbe2ea !important;
        border-radius: 10px !important;
        background-color: #fff;
        color: #334155;
        font-size: .82rem !important;
        font-weight: 600 !important;
        box-shadow: 0 1px 2px rgba(15,23,42,.03) !important;
        transition: border-color .18s ease, box-shadow .18s ease;
    }

    .status-filter-select:focus {
        border-color: #93b4f8 !important;
        box-shadow: 0 0 0 3px rgba(37,99,235,.08) !important;
    }

    /* Inventory cards */
    .unit-inventory-card {
        border-color: #e5eaf0;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(15,23,42,.035);
    }

    .unit-inventory-card:hover {
        transform: translateY(-3px);
        border-color: #d7dee7;
        box-shadow: 0 12px 28px rgba(15,23,42,.075);
    }

    .unit-card-thumb-wrap {
        height: 155px;
        background: #f8fafc;
        border-bottom-color: #edf1f5;
    }

    .unit-card-thumb-wrap img {
        padding: 1rem;
    }

    /* Status badge on cards */
    .card-status-badge {
        top: 11px;
        left: 11px;
        min-height: 27px;
        padding: .28rem .62rem;
        border-radius: 8px;
        font-size: .64rem;
        font-weight: 700;
        letter-spacing: .35px;
        box-shadow: 0 2px 7px rgba(15,23,42,.06);
    }

    .badge-available {
        background: #f0fdf4;
        color: #15803d;
        border-color: #bbf7d0;
    }

    .badge-rented {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }

    .badge-sold {
        background: #f8fafc;
        color: #475569;
        border-color: #dbe2ea;
    }

    .badge-credit {
        background: #fffbeb;
        color: #b45309;
        border-color: #fde68a;
    }

    .badge-paid {
        background: #eff6ff;
        color: #1d4ed8;
        border-color: #bfdbfe;
    }

    .unit-card-body {
        padding: 1rem 1.1rem 1.05rem;
    }

    .unit-code-badge {
        font-size: .68rem;
        color: #64748b;
        letter-spacing: .55px;
        margin-bottom: .3rem;
    }

    .unit-device-name {
        font-size: .98rem;
        margin-bottom: .8rem;
    }

    .unit-card-meta-row {
        padding-top: .7rem;
        border-top-color: #edf1f5;
    }

    .meta-title {
        font-size: .68rem;
        color: #94a3b8;
    }

    .meta-content {
        font-size: .78rem;
        color: #334155;
    }

    .card-actions-btn {
        width: 34px;
        height: 34px;
        border: 1px solid transparent;
        border-radius: 9px;
    }

    .card-actions-btn:hover {
        border-color: #e2e8f0;
        background: #f8fafc;
    }

    .unit-inventory-card .dropdown-menu {
        min-width: 190px;
        padding: .35rem;
        border: 1px solid #e7ecf2 !important;
        border-radius: 10px !important;
        box-shadow: 0 12px 30px rgba(15,23,42,.10) !important;
    }

    .unit-inventory-card .dropdown-item {
        border-radius: 7px;
        padding: .55rem .65rem !important;
    }

    .unit-inventory-card .dropdown-item:hover {
        background: #f8fafc;
    }

    /* List view status */
    .list-view-card {
        border-radius: 14px;
        border-color: #e5eaf0;
        box-shadow: 0 2px 10px rgba(15,23,42,.035);
    }

    .list-view-card .table-responsive {
        padding: 5px 8px 8px;
    }

    .list-view-card table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .list-view-card thead th {
        padding: 12px 12px !important;
        background: #f8fafc !important;
        border-bottom: 1px solid #e8edf2;
        color: #64748b;
        font-size: .69rem;
        font-weight: 700;
        letter-spacing: .045em;
        white-space: nowrap;
    }

    .list-view-card tbody td {
        padding: 13px 12px !important;
        border-bottom: 1px solid #f1f4f7;
    }

    .list-view-card tbody tr:last-child td {
        border-bottom: 0;
    }

    .list-view-card tbody tr {
        transition: background .15s ease;
    }

    .list-view-card tbody tr:hover {
        background: #fbfcfe;
    }

    .list-view-card .badge {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .1px;
    }

    .list-view-card .ps-4 {
        padding-left: 12px !important;
    }

    .list-view-card .pe-4 {
        padding-right: 12px !important;
    }

    /* =========================================================
       MODALS - CLEAN, COMPACT, CONSISTENT
       ========================================================= */

    .modal-backdrop.show {
        opacity: .45;
    }

    .modal-dialog {
        margin: 1rem auto;
    }

    .modal-content {
        border: 1px solid #e4e9ef !important;
        border-radius: 16px !important;
        box-shadow: 0 22px 65px rgba(15,23,42,.16) !important;
        overflow: hidden;
    }

    .modal-header {
        min-height: 72px;
        padding: 16px 20px !important;
        background: #fff;
        border-bottom: 1px solid #edf1f5 !important;
    }

    .modal-header > div {
        min-width: 0;
    }

    .modal-header .modal-title {
        font-size: .98rem;
        font-weight: 700 !important;
        letter-spacing: -.015em;
        color: #172033 !important;
    }

    .modal-header small {
        display: block;
        margin-top: 3px;
        font-size: .74rem;
        color: #94a3b8 !important;
    }

    /* Close button tetap kanan atas, tapi area klik lebih nyaman */
    .modal-header .btn-close {
        width: 17px;
        height: 17px;
        padding: 9px !important;
        margin: -2px -2px 0 auto !important;
        border-radius: 9px;
        background-color: #f1f5f9;
        box-sizing: content-box;
        opacity: .7;
        flex: 0 0 auto;
        transition: background-color .15s ease, opacity .15s ease;
    }

    .modal-header .btn-close:hover {
        background-color: #e7edf4;
        opacity: 1;
    }

    .modal-body {
        padding: 20px !important;
        background: #fff;
    }

    .modal-body .form-label {
        margin-bottom: 6px;
        color: #475569;
        font-size: .76rem;
        font-weight: 600 !important;
    }

    .modal-body .form-control,
    .modal-body .form-select {
        min-height: 42px;
        padding: .55rem .75rem;
        border: 1px solid #dce3ea;
        border-radius: 9px !important;
        color: #334155;
        font-size: .83rem;
        box-shadow: none;
        transition: border-color .16s ease, box-shadow .16s ease;
    }

    .modal-body textarea.form-control {
        min-height: 76px;
        resize: vertical;
    }

    .modal-body .form-control::placeholder {
        color: #b0bac7;
    }

    .modal-body .form-control:focus,
    .modal-body .form-select:focus {
        border-color: #93b4f8;
        box-shadow: 0 0 0 3px rgba(37,99,235,.08);
    }

    /* Device summary in Update Status modal */
    #updateStatusModal .modal-body > .p-3.bg-light {
        position: relative;
        padding: 14px 15px !important;
        background: #f8fafc !important;
        border: 1px solid #e7ecf1 !important;
        border-radius: 11px !important;
    }

    #modalKodeUnit {
        display: inline-block;
        margin-bottom: 3px;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .5px;
    }

    #modalNamaUnit {
        font-size: .91rem;
        line-height: 1.35;
    }

    #modalMerkUnit {
        margin-top: 2px;
        font-size: .72rem !important;
        color: #94a3b8 !important;
    }

    #modalStatusLamaBadge {
        padding: .35rem .6rem;
        border-radius: 7px;
        background: #fff !important;
        color: #64748b !important;
        border: 1px solid #dce3ea;
        font-size: .64rem;
        font-weight: 700;
    }

    /* Status selector */
    #modalSelectStatus {
        min-height: 44px;
        font-weight: 600;
        background-color: #fff;
    }

    /* Footer */
    .modal-footer {
        padding: 13px 20px 16px !important;
        background: #fafbfc;
        border-top: 1px solid #edf1f5 !important;
        gap: 8px;
    }

    .modal-footer .btn {
        min-height: 39px;
        padding: .48rem 1rem !important;
        border-radius: 9px !important;
        font-size: .78rem;
        font-weight: 600;
        box-shadow: none !important;
    }

    .modal-footer .btn-light {
        border: 1px solid #dfe5eb;
        background: #fff;
        color: #64748b;
    }

    .modal-footer .btn-light:hover {
        background: #f8fafc;
        color: #334155;
    }

    .modal-footer .btn-primary {
        box-shadow: 0 3px 8px rgba(37,99,235,.16) !important;
    }

    /* History modal */
    #historyStatusModal .modal-body {
        padding: 20px !important;
    }

    #historyContentWrap > .p-3.bg-light {
        padding: 13px 15px !important;
        background: #f8fafc !important;
        border: 1px solid #e7ecf1 !important;
        border-radius: 11px !important;
    }

    #historyUnitKode {
        font-size: .73rem !important;
        letter-spacing: .45px;
    }

    #historyUnitNama {
        font-size: .84rem;
    }

    #historyCurrentBadge {
        background: #eff6ff !important;
        color: #2563eb !important;
        border: 1px solid #bfdbfe;
        font-size: .66rem;
        font-weight: 700;
    }

    #historyStatusModal .table-responsive {
        border: 1px solid #e8edf2;
        border-radius: 10px;
        overflow: hidden;
    }

    #historyStatusModal table {
        margin-bottom: 0;
    }

    #historyStatusModal thead th {
        padding: 11px 12px;
        background: #f8fafc;
        border-bottom: 1px solid #e8edf2;
        color: #64748b;
        font-size: .66rem;
        font-weight: 700;
        white-space: nowrap;
    }

    #historyStatusModal tbody td {
        padding: 11px 12px;
        border-bottom: 1px solid #f1f4f7;
        font-size: .75rem;
    }

    #historyStatusModal tbody tr:last-child td {
        border-bottom: 0;
    }

    #historyStatusModal .badge {
        padding: .35rem .55rem;
        border-radius: 6px;
        font-size: .64rem;
        font-weight: 600;
    }

    /* Register modal */
    #registerUnitModal .modal-body {
        padding: 20px !important;
    }

    #registerUnitModal .row.g-3 {
        --bs-gutter-y: 1rem;
    }

    #registerUnitModal .form-text {
        margin-top: 5px;
        color: #94a3b8;
    }

    @media (max-width: 768px) {
        .status-filter-select {
            min-width: 160px;
        }

        .modal-dialog {
            margin: .6rem;
        }

        .modal-header {
            min-height: 64px;
            padding: 14px 16px !important;
        }

        .modal-body {
            padding: 17px !important;
        }

        .modal-footer {
            padding: 12px 16px 14px !important;
        }

        .modal-footer .btn {
            flex: 1;
        }

        #updateStatusModal .row > [class*="col-md-6"] {
            width: 100%;
        }
    }

</style>
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
