@extends('layouts.head_customer')

{{-- Sangat disarankan berkas layouts/head_customer.blade.php Anda memiliki @stack('styles') di dalam tag <head> --}}
@push('styles')
    <style>
/* TAMPILAN LAYAR (SCREEN) */
.wrapper-kartu-arsip {
            background-color: #ffffff;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: start;
        }

        .pengaturan-cetak {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }

        .tabel-arsip {
            background-color: #ffffff;
            border: 1px solid #000 !important;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #000;
            width: 100%;
            max-width: 600px; /* Ukuran standar di layar */
        }

        .tabel-arsip th, 
        .tabel-arsip td {
            border: 1px solid #000 !important;
            padding: 8px;
        }

        .tabel-arsip th {
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
        }

        .bagian-bawah {
            display: flex;
            flex-wrap: wrap;
        }

        .kolom-bawah {
            padding: 5px 10px;
        }

        .list-tanpa-gaya {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .list-tanpa-gaya li {
            display: flex;
            margin-bottom: 2px;
        }

        .list-angka { width: 20px; }
        .spasi-retensi { display: inline-block; width: 50px; }

        /* TAMPILAN SAAT CETAK (PRINT) */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0.5cm; /* Margin tepi kertas */
            }
            
            /* Sembunyikan elemen UI (tombol & pilihan) saat dicetak */
            .d-print-none, .navbar-custom,.page-title,h1, h2, h3, h4, h5, h6, title, footer {
                display: none !important;
            }
            
            html, body {
                background-color: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 100%;
                height: 100%;
            }

            /* NETRALKAN BOOTSTRAP CONTAINER & WRAPPER KARTU SAAT CETAK */
            .wrapper-kartu-arsip, 
            .container {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
            }

            /* Container Flexbox Penuh 1 Halaman A4 */
            #print-wrapper {
                display: flex !important;
                width: 100%;
                height: 98vh; /* Menghindari halaman kedua kosong */
                margin: 0 !important;
                padding: 0 !important;
                box-sizing: border-box;
                /* justify-content dan align-items akan diinjeksi via JavaScript */
            }

            /* Ukuran kartu saat dicetak (seperempat halaman A4) */
            .tabel-arsip {
                width: 9.5cm !important; /* Lebar kartu di kertas */
                font-size: 11px !important;
                margin: 0 !important;
                page-break-inside: avoid;
            }

            .tabel-arsip th, 
            .tabel-arsip td {
                padding: 5px !important;
            }
        }
    </style>

@endpush

@section('content')
<nav class="navbar-custom">
    <div class="navbar-inner">
        <!-- Brand -->
        <a href="#" class="nav-brand">
            <img src="{{ asset('images/arsip2.png') }}" width="40" class="mb-3" alt="Logo">
            <div class="nav-brand-text">
                <strong>SATU</strong>
                <small>Sistem Informasi Kearsipan Terpadu</small>
            </div>
        </a>

        <!-- Nav Links -->
        <ul class="nav-links">
            <li>
                <a href="{{ route('arsip.home') }}" class="active">
                    <i class="bi bi-house"></i> Kembali
                </a>
            </li>
        </ul>
        
        <!-- Account -->
        <div class="nav-account">
            <div class="account-avatar"><i class="bi bi-people-fill me-2" style="color: #6495ED;"></i></div>
            <div>
                <div class="account-name">{{ auth()->guard('web')->user()->name }}</div>
                <div class="account-role">Akun yang digunakan</div>
            </div>
            <i class="bi bi-chevron-down" style="font-size:.6rem;color:var(--muted);margin-left:.2rem;"></i>
            <div class="account-dropdown">
                <i class="bi">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout btn px-4 btn-logout-red">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
                </i>
            </div>
        </div>

        <button class="nav-mobile-toggle"><i class="bi bi-list"></i></button>
    </div>
</nav>

<!-- KONTROL PILIHAN CETAK (Hanya Tampil di Layar) -->
<div class="d-print-none pengaturan-cetak text-center">
    <h5 class="mb-3">Pengaturan Posisi Cetak A4</h5>
    <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
        <div>
            <label class="form-label mb-1">Posisi Horizontal</label>
            <select id="posisi-x" class="form-select form-select-sm" onchange="updatePosisiCetak()">
                <option value="flex-start">Kiri</option>
                <option value="center">Tengah</option>
                <option value="flex-end">Kanan</option>
            </select>
        </div>
        <div>
            <label class="form-label mb-1">Posisi Vertikal</label>
            <select id="posisi-y" class="form-select form-select-sm" onchange="updatePosisiCetak()">
                <option value="flex-start">Atas</option>
                <option value="center">Tengah</option>
                <option value="flex-end">Bawah</option>
            </select>
        </div>
        <div class="mt-3">
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                <i class="bi bi-printer"></i> Cetak Kartu
            </button>
        </div>
    </div>
</div>

<div class="wrapper-kartu-arsip">
    <div class="container mt-4">
        <h3 class="d-print-none">Kartu Deskripsi Arsip</h3>
<!-- Wrapper Grid -->
<!-- WRAPPER UNTUK POSISI PRINT -->
<!-- Default awal: Kiri Atas -->
        <div id="print-wrapper" style="justify-content: flex-start; align-items: flex-start;">
            
            <table class="table tabel-arsip mb-0">
                <!-- Baris Header -->
                <tr>
                    <th style="width: 15%;">CODE</th>
                    <th style="width: 35%;">KLASIFIKASI</th>
                    <th style="width: 25%;">SEMENTARA</th>
                    <th style="width: 25%;">DIFINITIF</th>
                </tr>
                
                <!-- Baris Data Klasifikasi -->
                <tr class="text-center align-middle">
                    <td>{{ Str::substr($data->masterKode?->kode, 0, 3) }}</td>
                    <td>{{ $data->masterKode->kode ?? '-' }}</td>
                    <td>{{ $data->id }}-{{ auth()->user()->id }}</td>
                    <td>{{ $data->nomor ?? '-' }}</td>
                </tr>

                <!-- Baris Isi Berkas -->
                <tr>
                    <td colspan="4">
                        <div class="mb-3">
                            <strong>Isi Berkas :</strong>  {{ $data->deskripsi }}
                        </div>
                        <div class="ps-3">
                            <div>- {{ $data->deskripsi }}</div>
                            <div>- <em>{{ $data->opd->unit_kerja }} - {{ $data->opd_induk->instansi }}</em></div>
                        </div>
                    </td>
                </tr>

                <!-- Baris Informasi Penutup -->
                <tr>
                    <td colspan="4" class="p-0">
                        <div class="bagian-bawah">
                            <div class="kolom-bawah" style="width: 30%;">
                                <div>Keterangan</div>
                                <ul class="list-tanpa-gaya">
                                    <li><span class="list-angka">1.</span> Asli</li>
                                    <li><span class="list-angka">2.</span> Tembusan</li>
                                    <li><span class="list-angka">3.</span> Fotocopy</li>
                                </ul>
                            </div>
                            
                            <div class="kolom-bawah" style="width: 70%;">
                                <div>Retensi</div>
                                <ul class="list-tanpa-gaya">
                                    <li>
                                        <span class="list-angka">1.</span> 
                                        <span class="spasi-retensi">Aktif</span> : <strong>1</strong> Th
                                    </li>
                                    <li>
                                        <span class="list-angka">2.</span> 
                                        <span class="spasi-retensi">Inaktif</span> : <strong>1</strong> Th
                                    </li>
                                    <li>
                                        <span class="list-angka">3.</span> 
                                        <span class="spasi-retensi">Ket</span> : <strong>{{ Str::substr($data->pemusnahan, 0, 1) }}</strong>&nbsp;di Th&nbsp;<strong>{{ date('Y', strtotime($data->tanggal_musnah)) }}</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- <button onclick="window.print()" class="btn btn-primary btn-sm btn-cetak mt-3 mb-3">
            <i class="bi bi-printer"></i> Cetak Kartu
        </button> -->
    </div>
</div>
@push('scripts')
<script>
    // Fungsi untuk memperbarui posisi CSS Wrapper saat dropdown diubah
    function updatePosisiCetak() {
        const posisiX = document.getElementById('posisi-x').value;
        const posisiY = document.getElementById('posisi-y').value;
        const wrapper = document.getElementById('print-wrapper');
        
        // Menerapkan gaya Flexbox ke container utama
        wrapper.style.justifyContent = posisiX;
        wrapper.style.alignItems = posisiY;
    }
</script>
@endpush

@endsection