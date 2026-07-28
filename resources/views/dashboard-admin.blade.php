@extends('layouts.head')
@section('content')

<!-- Navigation-->
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
          <i class="bi bi-archive"></i> Kelola Arsip
          <i class="bi bi-chevron-down nav-caret"></i>
        </a>
        <div class="dropdown-menu-custom">
          <a href="{{route('arsip_admin.home-admin')}}"><i class="bi bi-list-ul"></i> Daftar Arsip Inaktif</a>
          <a href="{{route('arsip_admin.musnah-admin')}}"><i class="bi bi-trash"></i> Daftar Arsip Musnah</a>
        </div>
      </li>
      <li>
        <a href="{{route('master-kodes.index')}}">
          <i class="bi bi-clipboard-data"></i> Data Klasifikasi
        </a>
      </li>
      <li>
        <a href="{{route('users.index')}}">
          <i class="bi bi-people"></i> Kelola User
        </a>
      </li>
      <li>
        <a href="{{route('opd_induk.index')}}">
          <i class="bi bi-building-lock"></i> Kelola Unit
        </a>
      </li>


    </ul>

    <!-- tanggal -->
    <div style="color:#4A9CC7;font-size: .70rem;">
    <?php 
           $timezone = new DateTimeZone('Asia/Jakarta');
           $hari_ini = new DateTime('now', $timezone); 


          $fmt = new IntlDateFormatter(
          'id_ID', // Kode bahasa Indonesia
          IntlDateFormatter::FULL, // Format tanggal lengkap dengan nama hari
          IntlDateFormatter::NONE, // Tidak menampilkan jam
          'Asia/Jakarta'
            );

            echo  $fmt->format($hari_ini);
    ?>
    </div>
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
<section class="hero row">

<!-- Bungkus Canvas dengan DIV yang memiliki ukuran tinggi (Height) yang jelas -->
<div class="col-md-6 mt-1">
        <canvas id="arsipChart"></canvas>
</div>

<div class="chart-container col-md-6 mt-1">
        <canvas id="grafikMusnah"></canvas>
    </div>
</section>
<!-- ═══════════════════════════════════════════════
     STAT BAR
════════════════════════════════════════════════ -->
<div class="stat-bar">
  <div class="stat-bar-inner">
    <div class="stat-item">
      <div class="stat-icon blue"><i class="bi bi-archive"></i></div>
      <div>
        <div class="stat-num">{{ $jumlah_data }}</div>
        <div class="stat-label">Arsip Inaktif</div>
      </div>
    </div>
    <div class="stat-item">
      <div class="stat-icon amber"><i class="bi bi-trash3"></i></div>
      <div>
        <div class="stat-num">{{ $total_lewat}} arsip</div>
        <div class="stat-label">Usul Musnah</div>
      </div>
    </div>
    <div class="stat-item">
      <div class="stat-icon green"><i class="bi bi-building-lock"></i></div>
      <div>
        <div class="stat-num">comming soon</div>
        <div class="stat-label">Arsip Statis</div>
      </div>
    </div>
  </div>
</div>

<script>
    // ==========================================
    // CHART 1: Statistik Arsip Berdasarkan OPD Induk
    // ==========================================
    const labels = @json($labels);
    const dataJumlah = @json($totals);

    // Gunakan nama variabel spesifik: ctxArsip
    const ctxArsip = document.getElementById('arsipChart').getContext('2d');
    new Chart(ctxArsip, {
        type: 'bar',
        data: {
            labels: labels, 
            datasets: [{
                label: 'Jumlah Data Arsip',
                data: dataJumlah, 
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
                        text: 'Instansi'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 
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
                    text: 'Statistik Arsip Berdasarkan Instansi'
                }
            }
        }
    });

    // ==========================================
    // CHART 2: Arsip Mendekati Tenggat Musnah
    // ==========================================
    const labelInstansi_musnah = @json($labelGrafik_musnah);
    const dataJumlah_musnah = @json($dataGrafik_musnah);

    // Gunakan nama variabel spesifik: ctxMusnah
    const ctxMusnah = document.getElementById('grafikMusnah').getContext('2d');
    new Chart(ctxMusnah, {
        type: 'bar',
        data: {
            labels: labelInstansi_musnah,
            datasets: [{
                label: 'Volume Arsip Mendekati Tenggat Musnah',
                data: dataJumlah_musnah,
                backgroundColor: 'rgba(83, 74, 183, 0.7)',
                borderColor: 'rgba(60, 52, 137, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Instansi',
                        // color: '#ffffff',
                        font: { weight: 'bold' }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    title: {
                        display: true,
                        text: 'Kuantitas Arsip',
                        font: { weight: 'bold' }
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Statistik Arsip Musnah (Tenggat 1 Bulan ke Depan)',
                    font: { size: 16 }
                }
            }
        }
    });
</script>



@endsection