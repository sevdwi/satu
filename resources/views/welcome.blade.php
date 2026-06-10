@extends('layouts.head_depan')
@section('content')
<!-- ═══════════════════════════════════════════════
     NAVBAR
════════════════════════════════════════════════ -->
<nav class="navbar-custom">
  <div class="navbar-inner">
    <a href="#" class="nav-brand">
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
    <div>
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
    <div class="hero-visual">
      <div class="doc-stack">
        <!-- Back document -->
        <div class="doc-card doc-c">
          <div class="doc-card-lines">
            <div class="doc-line doc-line-short"></div>
            <div class="doc-line doc-line-long"></div>
            <div class="doc-line doc-line-med"></div>
          </div>
        </div>
        <!-- Middle document -->
        <div class="doc-card doc-b">
          <div class="doc-card-lines">
            <div class="doc-line doc-line-med"></div>
            <div class="doc-line doc-line-long"></div>
            <div class="doc-line doc-line-short"></div>
            <div class="doc-line doc-line-long"></div>
          </div>
        </div>
        <!-- Front document -->
        <div class="doc-card doc-a">
          <div class="doc-header">
            <div class="doc-header-dot"></div>
            <div class="doc-header-dot"></div>
          </div>
          <div class="doc-card-lines">
            <div class="doc-line doc-line-short"></div>
            <div class="doc-line doc-line-long"></div>
            <div class="doc-line doc-line-med"></div>
            <div class="doc-line doc-line-long"></div>
            <div class="doc-line doc-line-short"></div>
          </div>
        </div>
 
        <!-- Floating badges -->
        <div class="hero-float-badge">
          <div class="float-badge-icon"><i class="bi bi-archive"></i></div>
          <div>
            <div class="float-badge-num">1.284</div>
            <div class="float-badge-lbl">Arsip tercatat</div>
          </div>
        </div>
        <div class="hero-float-status">
          <span class="status-dot"></span> Sistem aktif
        </div>
      </div>
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
 
    <!-- Info Card -->
    <div class="about-card">
      <div class="about-card-header">
        <h6>Informasi Instansi</h6>
      </div>
      <div class="about-card-body">
        <div class="info-row">
          <div class="info-row-icon" style="background:var(--blue-soft);color:var(--blue-deep);">
            <i class="bi bi-building"></i>
          </div>
          <div>
            <p>Nama Instansi</p>
            <small>Dinas Arsip dan Perpustakaan Kab. Cilacap</small>
          </div>
        </div>
        <div class="info-row">
          <div class="info-row-icon" style="background:#D1FAE5;color:#1B8A45;">
            <i class="bi bi-geo-alt"></i>
          </div>
          <div>
            <p>Alamat</p>
            <small>Jl. Jend. Sudirman No. 12, Cilacap</small>
          </div>
        </div>
        <div class="info-row">
          <div class="info-row-icon" style="background:#FDE8C8;color:#C27A08;">
            <i class="bi bi-calendar3"></i>
          </div>
          <div>
            <p>Berdiri Sejak</p>
            <small>28 Oktober 1998 (PERDA No. 2/1998)</small>
          </div>
        </div>
        <div class="info-row">
          <div class="info-row-icon" style="background:#EDE9FE;color:#5B21B6;">
            <i class="bi bi-archive"></i>
          </div>
          <div>
            <p>Modul Tersedia</p>
            <small>Arsip Inaktif · Musnah · Statis</small>
          </div>
        </div>
      </div>
      <!-- <div class="about-card-cta">
        <a href="#" class="btn-cta-full btn-cta-primary">
          <i class="bi bi-person-circle"></i> Masuk sebagai User
        </a>
        <a href="#" class="btn-cta-full btn-cta-ghost">
          <i class="bi bi-shield-lock"></i> Masuk sebagai Admin
        </a>
      </div> -->
    </div>
 
  </div>
</section>
 
@endsection