@extends('layouts.head_customer')

@section('content')
<div class="container py-3">
    <!-- Judul Halaman -->
    <div class="row mb-3">
        <div class="col-12 text-center">
            <h5 class="fw-bold text-primary mb-1">
                <i class="bi bi-qr-code-scan"></i> Daftar Berkas Terdeteksi
            </h5>
            <p class="text-muted small">Menampilkan data arsip dari hasil pemindaian QR.</p>
        </div>
    </div>

    <!-- Container List Card (Looping data berkas) -->
    <div class="row g-3"> 
        @forelse($data as $berkas)
        {{var_dump($berkas)}}
            <div class="col-12 col-md-6 col-lg-4">
                <!-- Card Bootstrap yang ramah mobile -->
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-3">
                        
                        <!-- Header Card: Label & Status -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill small fw-semibold">
                                {{ $berkas->nomor ?? 'LABEL-00X' }}
                            </span>
                            <span class="badge bg-success bg-opacity-10 text-success small">
                                Aktif
                            </span>
                        </div>

                        <!-- Judul / Nama Berkas -->
                        <h6 class="card-title fw-bold text-dark mb-1">
                            {{ $berkas->judul ?? 'Nama Berkas Arsip' }}
                        </h6>

                        <!-- Informasi Detail Berkas -->
                        <p class="card-text text-muted small mb-3">
                            <i class="bi bi-folder2-open me-1"></i> Dus: {{ $berkas->deskripsi ?? '-' }} <br>
                        </p>

                        <!-- Tombol Aksi (Full width agar mudah ditekan di HP) -->
                        <div class="d-grid">
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-pill py-2 fw-semibold">
                                <i class="bi bi-eye me-1"></i> Lihat Detail Berkas
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <!-- Tampilan jika data kosong -->
            <div class="col-12">
                <div class="card border-0 shadow-sm text-center py-5 rounded-4">
                    <div class="card-body">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2 mb-0">Tidak ada label berkas yang ditemukan.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Tambahan CSS Khusus Mobile Experience -->
<style>
    /* Membuat sudut card lebih modern */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    /* Efek sedikit terangkat saat ditekan di HP */
    .card:active {
        transform: scale(0.98);
    }
    /* Memastikan tombol nyaman disentuh jari (touch-friendly) */
    .btn-sm {
        font-size: 0.875rem;
    }
</style>
@endsection