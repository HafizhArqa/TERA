@extends('layouts.pelanggan')

@section('title', 'Ajukan Penyewaan - TERA Client')

@section('content')
<div class="page-header">
    <div class="page-header-text">
        <h2>Ajukan Penyewaan</h2>
        <p>Lengkapi formulir di bawah ini untuk memulai proses rental unit.</p>
    </div>
</div>

<div class="ajukan-layout">
    <div class="form-card">
        <form action="#" method="POST">
            @csrf
            <div class="form-group">
                <label>Pilih Unit</label>
                <select class="form-control">
                    <option value="">Pilih unit kendaraan atau alat berat</option>
                    <option value="1">Excavator CAT 320</option>
                    <option value="2">Forklift Toyota 2.5T</option>
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" class="form-control" placeholder="mm/dd/yyyy">
                </div>
                <div class="form-group">
                    <label>Durasi (Hari)</label>
                    <div class="form-control-group">
                        <input type="number" class="form-control" value="0">
                        <span class="form-control-addon">HARI</span>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Catatan</label>
                <textarea class="form-control" placeholder="Tambahkan informasi tambahan atau instruksi khusus..."></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="bi bi-send"></i> Ajukan</button>
                <a href="{{ route('pelanggan.dashboard') }}" class="btn-secondary" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-x"></i> Batal</a>
            </div>
        </form>
    </div>
    
    <div>
        <div class="sidebar-card">
            <h4>Informasi Penting</h4>
            <ul class="info-list">
                <li>
                    <i class="bi bi-info-circle"></i>
                    <span>Pengajuan akan diverifikasi oleh admin dalam waktu maksimal 24 jam kerja.</span>
                </li>
                <li>
                    <i class="bi bi-check2-circle"></i>
                    <span>Pastikan unit yang dipilih tersedia pada tanggal mulai yang Anda tentukan.</span>
                </li>
                <li>
                    <i class="bi bi-cash"></i>
                    <span>Invoice akan diterbitkan setelah status pengajuan berubah menjadi "Disetujui".</span>
                </li>
            </ul>
        </div>
        
        <div class="support-card sidebar-card">
            <div class="support-icon">
                <i class="bi bi-headset"></i>
            </div>
            <div class="support-text">
                <h5>Butuh Bantuan?</h5>
                <p>Hubungi tim support TERA untuk konsultasi unit.</p>
            </div>
        </div>
    </div>
</div>
@endsection
