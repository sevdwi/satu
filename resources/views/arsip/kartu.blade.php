@extends('layouts.head_customer')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Deskripsi Arsip</title>
    <!-- Memuat Bootstrap 5 melalui CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            padding: 2rem;
            display: flex;
            justify-content: center;
        }

        /* Modifikasi gaya tabel untuk mencocokkan dokumen cetak */
        .tabel-arsip {
            background-color: #ffffff;
            width: 100%;
            max-width: 800px;
            border: 1px solid #000 !important;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
            color: #000;
        }

        .tabel-arsip th, 
        .tabel-arsip td {
            border: 1px solid #000 !important;
            padding: 10px;
        }

        .tabel-arsip th {
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
        }

        /* Menghilangkan border internal pada bagian bawah tabel */
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

        .list-angka {
            width: 20px;
        }
        
        .spasi-retensi {
            display: inline-block;
            width: 50px;
        }
    </style>
</head>

<body>

<!-- @section('content') -->
<nav class="navbar-custom">
  <div class="navbar-inner">

    <!-- Brand -->
    <a href="#" class="nav-brand">
      <img src="{{ asset('images/arsip2.png') }}" width="40" class="mb-3">
      <div class="nav-brand-text">
        <strong>SATU</strong>
        <small>Sistem Informasi Kearsipan Terpadu</small>
      </div>
    </a>

    <!-- Nav Links -->
    <ul class="nav-links">
      <li>
        <a href="{{route('arsip.home')}}" class="active">
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

<div class="container mt-4">

    <h3>Kartu Deskripsi Arsip</h3>


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
            <td>{{$data->masterKode->kode}}</td>
            <td>{{$data->nomor}}</td>
            <td>{{ $data->id + auth()->user()->id }}</td>
            <td></td>
        </tr>

        <!-- Baris Isi Berkas -->
        <tr>
            <td colspan="4">
                <div class="mb-3">
                    <strong>Isi Berkas :</strong> Keputusan Dewan Pengurus Korpri Kabupaten Cilacap Nomor 16/KEP/DPK-KAB/II/2020 tentang Pengukuhan Susunan Personalia Pergantian Antar Waktu (PAW) Dewan Pengurus Korpri Unit Dinas KB, PP dan PA Periode Tahun 2015 -2020
                </div>
                <div class="ps-3">
                    <div>- 1 Berkas</div>
                    <div>- Februari 2020</div>
                    <div>- <em>Subbag Umum dan Kepegawaian</em></div>
                </div>
            </td>
        </tr>

        <!-- Baris Informasi Penutup -->
        <tr>
            <td colspan="4" class="p-0">
                <div class="bagian-bawah">
                    <!-- Kolom Keterangan -->
                    <div class="kolom-bawah" style="width: 30%;">
                        <div>Keterangan</div>
                        <ul class="list-tanpa-gaya">
                            <li><span class="list-angka">1.</span> Asli</li>
                            <li><span class="list-angka">2.</span> Tembusan</li>
                            <li><span class="list-angka">3.</span> Fotocopy</li>
                        </ul>
                    </div>
                    
                    <!-- Kolom Retensi -->
                    <div class="kolom-bawah" style="width: 45%;">
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
                                <span class="spasi-retensi">Ket</span> : <strong>M</strong> di Th <strong>2022</strong>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Kolom Korektor -->
                    <div class="kolom-bawah d-flex flex-column justify-content-between align-items-center" style="width: 25%;">
                        <div class="text-start w-100">Korektor</div>
                        <div class="mt-5 pt-3">(...............................)</div>
                    </div>
                </div>
            </td>
        </tr>
    </table>


</div>
<!-- jQuery (WAJIB paling atas) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

<!-- @endsection -->

</html>
