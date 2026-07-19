@extends('layouts.head')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<!-- Navigation-->
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container px-5">
            <a class="navbar-brand" href="{{route('dashboard')}}"><span class="fw-bolder" style="color: #7944B8;">SATU</span><img src="{{ asset('images/arsip.png') }}" width="40" class="mb-3"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                    <li class="nav-item"><a class="btn px-4 btn-logout-purple me-3" href="{{route('master-kodes.index')}}">Data Klasifikasi</a></li>
                    <li class="nav-item"><a class="btn px-4 btn-logout-blue me-3" href="{{route('users.index')}}">Kelola Users</a></li>
                    <li class="nav-item">
                        <form action="{{ route('logout-admin') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn px-4 btn-logout-red">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    </li>


                </ul>
            </div>
        </div>
 </nav> -->
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
        <a href="{{route('dashboard-admin')}}" class="active">
          <i class="bi bi-house"></i> Beranda
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bi bi-archive"></i> Arsip Inaktif
          <i class="bi bi-chevron-down nav-caret"></i>
        </a>
        <div class="dropdown-menu-custom">
        <!-- <a href="{{route('arsip.home')}}"><i class="bi bi-list-ul"></i> Daftar Arsip Inaktif</a> -->

          <!-- <a href="#"><i class="bi bi-plus-square"></i> Input Unit Pengolah Yg Ditata</a> -->
          <!-- <a href="#"><i class="bi bi-pencil-square"></i> Input Deskripsi Arsip</a> -->
          <!-- <div class="dropdown-divider-custom"></div> -->
          <a href="{{route('arsip_admin.home-admin')}}"><i class="bi bi-list-ul"></i> Daftar Arsip Inaktif</a>
        </div>
      </li>
      <!-- <li>
        <a href="#">
          <i class="bi bi-trash3"></i> Arsip Musnah
          <i class="bi bi-chevron-down nav-caret"></i>
        </a>
        <div class="dropdown-menu-custom">
          <a href="#"><i class="bi bi-file-earmark-plus"></i> Daftar Usul Musnah</a>
          <div class="dropdown-divider-custom"></div>
          <a href="#"><i class="bi bi-list-check"></i> Daftar Musnah</a>
        </div>
      </li>
      <li>
        <a href="#">
          <i class="bi bi-building-lock"></i> Arsip Statis
          <i class="bi bi-chevron-down nav-caret"></i>
        </a>
        <div class="dropdown-menu-custom">
          <a href="#"><i class="bi bi-send"></i> Daftar Usul Serah</a>
          <div class="dropdown-divider-custom"></div>
          <a href="#"><i class="bi bi-archive-fill"></i> Daftar Arsip Statis</a>
        </div>
      </li> -->
      <li>
        <a href="{{route('master-kodes.index')}}">
          <i class="bi bi-building-lock"></i> Data Klasifikasi
        </a>
      </li>
      <li>
        <a href="{{route('users.index')}}">
          <i class="bi bi-building-lock"></i> Kelola User
        </a>
      </li>
      <li>
        <a href="{{route('opd_induk.index')}}">
          <i class="bi bi-building-lock"></i> Kelola Unit
        </a>
      </li>


    </ul>

    <!-- Account -->
    <div class="nav-account">
      <div class="account-avatar"><i class="bi bi-people-fill me-2" style="color: #6495ED;"></i></div>
      <div>
        <div class="account-name">{{ auth()->guard('admin')->user()->name }}</div>
        <div class="account-role">Akun yang digunakan</div>
      </div>
      <i class="bi bi-chevron-down" style="font-size:.6rem;color:var(--muted);margin-left:.2rem;"></i>
      <div class="account-dropdown">
        <!-- <a href="#"><i class="bi bi-person"></i> Profil Saya</a>
        <a href="#"><i class="bi bi-key"></i> Ubah Kata Sandi</a> -->
        <form action="{{ route('logout-admin') }}" method="POST">
            @csrf
            <button type="submit" class="logout btn px-4 btn-logout-red">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
      </div>
    </div>

    <button class="nav-mobile-toggle"><i class="bi bi-list"></i></button>
  </div>
</nav>

<!-- Bungkus Canvas dengan DIV yang memiliki ukuran tinggi (Height) yang jelas -->
<div style="width: 800px; margin: auto;">
        <canvas id="arsipChart"></canvas>
    </div>

    <script>
        // Ambil data dari Controller Laravel
        const labels = @json($labels);
        const dataJumlah = @json($totals);

        // Konfigurasi Chart.js
        const ctx = document.getElementById('arsipChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, // Sumbu X: Nama OPD Induk / Instansi
                datasets: [{
                    label: 'Jumlah Data Arsip',
                    data: dataJumlah, // Sumbu Y: Jumlah Arsip
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'OPD Induk (Instansi)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Pastikan angka pada sumbu Y berupa bilangan bulat
                        },
                        title: {
                            display: true,
                            text: 'Jumlah Arsip'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Statistik Arsip Berdasarkan OPD Induk'
                    }
                }
            }
        });
    </script>



@endsection