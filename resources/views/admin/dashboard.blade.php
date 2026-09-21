@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold mb-1 text-dark">Dashboard Overview</h2>
            <p class="text-muted mb-0 small">Monitoring operasional unit inventaris dan ringkasan performa sistem TERA</p>
        </div>
        <a href="{{ route('admin.units.index') }}" class="btn btn-primary px-3 py-2 rounded-3 fw-semibold shadow-sm d-inline-flex align-items-center gap-2">
            <i class="bi bi-box-seam"></i>
            <span>Buka Kelola Unit</span>
        </a>
    </div>

    <!-- Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center">
                <div class="rounded-3 p-3 bg-primary-subtle text-primary me-3 fs-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                     <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size: 0.75rem;">Total Unit</div>
                    <div class="h3 fw-bold mb-0 text-dark">{{ number_format($totalUnit ?? 0) }}</div>
                </div>
            </div>
        </div>
       
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center">
                <div class="rounded-3 p-3 bg-success-subtle text-success me-3 fs-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size: 0.75rem;">Unit Tersedia</div>
                    <div class="h3 fw-bold mb-0 text-dark">{{ number_format($unitTersedia ?? 0) }}</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center">
                <div class="rounded-3 p-3 bg-danger-subtle text-danger me-3 fs-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size: 0.75rem;">Unit Disewa</div>
                    <div class="h3 fw-bold mb-0 text-dark">{{ number_format($unitDisewa ?? 0) }}</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center">
                <div class="rounded-3 p-3 bg-info-subtle text-info me-3 fs-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold text-uppercase" style="font-size: 0.75rem;">Total Transaksi</div>
                    <div class="h3 fw-bold mb-0 text-dark">0</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access & Recent Units -->
    
</div>
@endsection