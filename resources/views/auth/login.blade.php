@extends('layouts.head_depan')
@section('content')
<!-- ═══════════════════════════════════════════════
     NAVBAR
════════════════════════════════════════════════ -->
<nav class="navbar-custom">
  <div class="navbar-inner">
    <a href="{{route('welcome')}}" class="nav-brand">
      <div class="nav-brand-mark">
      <img src="{{ asset('images/arsip2.png') }}" width="40" class="mb-3">
      </div>
      <div>
        <div class="nav-brand-wordmark">SATU</div>
        <span class="nav-brand-sub">Sistem Informasi Kearsipan Terpadu</span>
      </div>
    </a>
 
    <div class="nav-actions" id="navActions">
      <a href="{{route('login')}}" class="btn-nav-login">
        <i class="bi bi-person"></i> Login
      </a>
      <a href="{{route('login-admin')}}" class="btn-nav-admin">
        <i class="bi bi-shield-lock"></i> Login Admin
      </a>
    </div>
 
    <button class="nav-mobile-toggle" id="mobileToggle">
      <i class="bi bi-list"></i>
    </button>
  </div>
</nav>
 
 
<!-- ═══════════════════════════════════════════════
     HERO
════════════════════════════════════════════════ -->
<section class="hero">
  <div class="hero-inner">
 
    <!-- Text Column -->
    <div class="col-5">
      <div class="hero-badge">
        <span class="hero-badge-dot"></span>
        Efisien &nbsp;·&nbsp; Simple &nbsp;·&nbsp; Mudah
      </div>
      <div class="hero-system-name">Sistem Informasi Kearsipan Terpadu</div>
      <h1 class="hero-wordmark">SA<span class="wordmark-thin">TU</span></h1>
      <p class="hero-desc">
        Platform digital terpadu untuk pengelolaan arsip inaktif, musnah, dan statis
        di lingkungan Dinas Arsip dan Perpustakaan Kabupaten Cilacap.
      </p>
      <!-- <div class="hero-cta">
        <a href="#" class="btn-hero-solid">
          <i class="bi bi-person-circle"></i> Masuk sebagai User
        </a>
        <a href="#" class="btn-hero-glass">
          <i class="bi bi-shield-lock"></i> Masuk sebagai Admin
        </a>
      </div> -->
      <div class="hero-note">
        <i class="bi bi-lock"></i>
        Akses terbatas untuk pegawai yang telah terdaftar.
      </div>
    </div>
 
    <!-- Visual Column -->
    <div class="col-7">
      <!-- batas atas card -->
      <div class="login-wrapper">
  <div class="login-card">
 
    <!-- Top accent band -->
    <div class="card-band"></div>
 
    <!-- Card Header / Branding -->
    <div class="card-head">
      <div class="brand-mark">
      <img src="{{ asset('images/arsip2.png') }}" width="40" class="mb-3">
      </div>
      <span class="card-wordmark">SATU</span>
      <p class="card-greeting">Selamat datang kembali</p>
    </div>
 
    <!-- Form -->
    <div class="card-form">
        {{-- Ganti action dengan route Laravel --}}
        <form action="/login" method="POST" id="loginForm">
        @csrf
  
          <!-- Nomor HP -->
          <div class="form-group">
            <label class="form-label-custom">
              <i class="bi bi-telephone"></i> Nomor HP
            </label>
            <div class="input-wrap">
              <i class="bi bi-telephone i-icon"></i>
              <input type="number" name="phone_number"
                    class="form-input"
                    placeholder="08xxxxxxxxxx" required />
            </div>
          </div>
  
          <!-- Password -->
          <div class="form-group">
            <label class="form-label-custom">
              <i class="bi bi-lock"></i> Password
            </label>
            <div class="input-wrap">
              <i class="bi bi-lock i-icon"></i>
              <input type="password" name="password" id="passwordInput"
                    class="form-input has-toggle"
                    placeholder="Masukkan password" required />
              <button type="button" class="toggle-pw-btn" id="togglePw" title="Tampilkan password">
                <i class="bi bi-eye" id="toggleIcon"></i>
              </button>
            </div>
          </div>
  
          <hr class="form-divider" />
  
          <!-- Submit -->
          <button type="submit" class="btn-submit">
            <i class="bi bi-box-arrow-in-right"></i> Masuk
          </button>
  
        </form>
 
      {{-- Error block — tampilkan jika ada error dari Laravel --}}
      @if ($errors->any())
        <div class="error-box">
          <i class="bi bi-exclamation-circle-fill"></i>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

 
      <!-- Back to Home -->
      <a href="#" class="back-link">
        <i class="bi bi-arrow-left"></i> Kembali ke Halaman Utama
      </a>
 
    </div>
  </div>
</div>
        <!-- batas bawah card -->
    </div>
 
  </div>
</section>
 
 
<!-- ═══════════════════════════════════════════════
     FEATURES
════════════════════════════════════════════════ -->
<section class="features-section">
  <div class="features-inner">
    <div class="features-header">
      <div class="section-eyebrow">Mengapa SATU?</div>
      <h2 class="section-heading">Dirancang untuk Kemudahan</h2>
      <p class="section-sub">Satu sistem, tiga modul utama, semua kebutuhan arsip terpenuhi.</p>
    </div>
    <div class="features-grid">
      <div class="feat-card feat-c1">
        <div class="feat-icon feat-icon-blue"><i class="bi bi-lightning-charge-fill"></i></div>
        <div class="feat-title">Efisien</div>
        <p class="feat-desc">Pencatatan dan pengelolaan arsip yang cepat. Tidak perlu formulir kertas — semua dilakukan digital dari satu dasbor.</p>
      </div>
      <div class="feat-card feat-c2">
        <div class="feat-icon feat-icon-green"><i class="bi bi-layout-text-window-reverse"></i></div>
        <div class="feat-title">Simple</div>
        <p class="feat-desc">Antarmuka bersih dan navigasi yang intuitif. Staf dapat langsung bekerja tanpa perlu pelatihan teknis panjang.</p>
      </div>
      <div class="feat-card feat-c3">
        <div class="feat-icon feat-icon-amber"><i class="bi bi-diagram-3-fill"></i></div>
        <div class="feat-title">Terpadu</div>
        <p class="feat-desc">Arsip inaktif, musnah, dan statis dikelola dalam satu platform dengan alur kerja yang terintegrasi dan konsisten.</p>
      </div>
    </div>
  </div>
</section>
 
 
<!-- ═══════════════════════════════════════════════
     ABOUT
════════════════════════════════════════════════ -->
<section class="about-section" id="about">
  <div class="about-inner">
 
    <!-- Text -->
    <div class="about-text">
      <div class="section-eyebrow">Tentang Kami</div>
      <h2 class="section-heading">ARPUS Cilacap</h2>
      <div class="about-body">
        <p>
          Perpustakaan di Kabupaten Cilacap merupakan perpustakaan yang berada di
          lingkungan Sekretariat Daerah Kabupaten Cilacap. Sesuai PERDA No. 2 tahun 1998
          tepatnya tanggal 28 Oktober 1998, Kantor Perpustakaan Daerah Cilacap
          beralamatkan di Jl. Jend. Sudirman No. 12 Cilacap.
        </p>
        <p>
          Sesuai PERDA No. 31 tahun 2004 berganti menjadi Kantor Arsip dan Perpusda
          Cilacap. Dalam sejarahnya telah terjadi dinamika pengorganisasian, namun tidak
          merubah fungsi perpustakaan dan kearsipan itu sendiri.
        </p>
        <p>
          Aplikasi SATU dikembangkan sebagai bagian dari transformasi digital layanan
          kearsipan untuk mendukung tata kelola pemerintahan yang lebih transparan,
          terstruktur, dan akuntabel.
        </p>
      </div>
      <div class="about-socials">
        <a href="#" class="social-btn"><i class="bi bi-twitter-x"></i> Twitter</a>
        <a href="#" class="social-btn"><i class="bi bi-linkedin"></i> LinkedIn</a>
        <a href="#" class="social-btn"><i class="bi bi-github"></i> GitHub</a>
        <a href="#" class="social-btn"><i class="bi bi-globe2"></i> Website</a>
      </div>
    </div>
 
 
  </div>
</section>

<script>
  // Toggle show/hide password
  const pwInput  = document.getElementById('passwordInput');
  const toggleBtn = document.getElementById('togglePw');
  const toggleIcon = document.getElementById('toggleIcon');
 
  toggleBtn.addEventListener('click', () => {
    const isHidden = pwInput.type === 'password';
    pwInput.type = isHidden ? 'text' : 'password';
    toggleIcon.className = isHidden ? 'bi bi-eye-slash' : 'bi bi-eye';
    toggleBtn.title = isHidden ? 'Sembunyikan password' : 'Tampilkan password';
  });
</script>
@endsection