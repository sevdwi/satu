@extends('layouts.head_customer')
@section('content')

<!-- ═══════════════════════════════════════════════
     NAVBAR
════════════════════════════════════════════════ -->
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
        <a href="{{route('dashboard')}}" class="active">
          <i class="bi bi-house"></i> Beranda
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bi bi-archive"></i> Arsip Inaktif
          <i class="bi bi-chevron-down nav-caret"></i>
        </a>
        <div class="dropdown-menu-custom">
          <a href="{{route('arsip.home')}}"><i class="bi bi-list-ul"></i> Daftar Arsip Inaktif</a>
          <!-- <div class="dropdown-divider-custom"></div> -->
        </div>
      </li>
      <li>
        <a href="#">
          <i class="bi bi-trash3"></i> Arsip Musnah
          <i class="bi bi-chevron-down nav-caret"></i>
        </a>
        <div class="dropdown-menu-custom">
          <a href="#"><i class="bi bi-file-earmark-plus"></i> Daftar Usul Musnah</a>
        </div>
      </li>
      <li>
        <a href="{{route('arsip.kartu')}}">
          <i class="bi bi-building-lock"></i> Kartu Arsip
          <i class="bi bi-chevron-down nav-caret"></i>
        </a>
        <!-- <div class="dropdown-menu-custom">
          <a href="#"><i class="bi bi-send"></i> Daftar Usul Serah</a>
          <div class="dropdown-divider-custom"></div>
          <a href="#"><i class="bi bi-archive-fill"></i> Daftar Arsip Statis</a>
        </div> -->
      </li>
      <li>
        <a href="#">
          <i class="bi bi-building-lock"></i> Nomor Rak & Dus
          <i class="bi bi-chevron-down nav-caret"></i>
        </a>
        <div class="dropdown-menu-custom">
          <a href="{{route('rak_arsip.index')}}"><i class="bi bi-send"></i> Buat Nomor Rak</a>
          <!-- <div class="dropdown-divider-custom"></div> -->
          <a href="{{route('dus_arsip.index')}}"><i class="bi bi-archive-fill"></i> Buat Nomor Dus</a>
        </div>
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
        <!-- <a href="#"><i class="bi bi-person"></i> Profil Saya</a> -->
        <!-- <a href="#"><i class="bi bi-key"></i> Ubah Kata Sandi</a> -->
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


<!-- ═══════════════════════════════════════════════
     HERO
════════════════════════════════════════════════ -->
<section class="hero">
  <div class="hero-inner">
    <div class="hero-text">
      <div class="hero-eyebrow">
        <i class="bi bi-circle-fill" style="font-size:.4rem;color:#A8D8F0;"></i>
        Sistem Aktif — Tahun Anggaran 2026
      </div>
      <h1 class="hero-heading">
        Pengelolaan <em>Arsip Daerah</em><br>Terpadu &amp; Terstruktur
      </h1>
      <p class="hero-sub">
        Platform terpusat untuk pencatatan, pengelolaan, dan pemusnahan arsip
        inaktif, musnah, dan statis di lingkungan pemerintah daerah.
      </p>
      <div class="hero-actions">
        <a href="#modul" class="btn-hero-primary">
          <i class="bi bi-grid-1x2-fill"></i> Masuk ke Modul
        </a>
        <a href="#" class="btn-hero-ghost">
          <i class="bi bi-question-circle"></i> Panduan Penggunaan
        </a>
      </div>
    </div>

    <!-- Folder Stack Illustration -->
    <div class="hero-illustration">
      <div class="folder-stack">
        <div class="folder-item f3"><div class="folder-tab"></div></div>
        <div class="folder-item f2"><div class="folder-tab"></div></div>
        <div class="folder-item f1">
          <div class="folder-tab"></div>
          <div class="f1-lines">
            <div class="f1-line"></div>
            <div class="f1-line"></div>
            <div class="f1-line"></div>
            <div class="f1-line"></div>
          </div>
        </div>
      </div>
      <div class="hero-badge">
        <div class="hero-badge-dot"></div>
        <span>Sistem Berjalan Normal</span>
      </div>
    </div>
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
        <div class="stat-num">1.284</div>
        <div class="stat-label">Arsip Inaktif</div>
      </div>
    </div>
    <div class="stat-item">
      <div class="stat-icon amber"><i class="bi bi-trash3"></i></div>
      <div>
        <div class="stat-num">347</div>
        <div class="stat-label">Usul Musnah</div>
      </div>
    </div>
    <div class="stat-item">
      <div class="stat-icon green"><i class="bi bi-building-lock"></i></div>
      <div>
        <div class="stat-num">92</div>
        <div class="stat-label">Arsip Statis</div>
      </div>
    </div>
    <div class="stat-item">
      <div class="stat-icon teal"><i class="bi bi-clock-history"></i></div>
      <div>
        <div class="stat-num">18</div>
        <div class="stat-label">Diperbarui Hari Ini</div>
      </div>
    </div>
  </div>
</div>


<!-- ═══════════════════════════════════════════════
     MAIN: MODULE CARDS
════════════════════════════════════════════════ -->
<div class="main-wrap" id="modul">

  
</div><!-- /main-wrap -->

@endsection
<!-- ═══════════════════════════════════════════════
     FOOTER
════════════════════════════════════════════════ -->
