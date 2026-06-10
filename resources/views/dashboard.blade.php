@extends('layouts.head_customer')
@section('content')

<!-- ═══════════════════════════════════════════════
     NAVBAR
════════════════════════════════════════════════ -->
<nav class="navbar-custom">
  <div class="navbar-inner">

    <!-- Brand -->
    <a href="#" class="nav-brand">
      <img src="{{ asset('images/arsip.png') }}" width="40" class="mb-3">
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
          <a href="#"><i class="bi bi-plus-square"></i> Input Unit Pengolah Yg Ditata</a>
          <a href="#"><i class="bi bi-pencil-square"></i> Input Deskripsi Arsip</a>
          <div class="dropdown-divider-custom"></div>
          <a href="#"><i class="bi bi-list-ul"></i> Daftar Arsip Inaktif</a>
        </div>
      </li>
      <li>
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
        <a href="#"><i class="bi bi-person"></i> Profil Saya</a>
        <a href="#"><i class="bi bi-key"></i> Ubah Kata Sandi</a>
        <form action="{{ route('logout') }}" method="POST">
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

  <div>
    <div class="section-eyebrow">Modul Sistem</div>
    <h2 class="section-heading">Akses Cepat per Kategori Arsip</h2>
    <p class="section-sub">Pilih modul arsip yang ingin dikelola. Setiap modul memiliki sub-menu khusus sesuai alur kerja.</p>
  </div>

  <div class="folder-cards">

    <!-- CARD 1: Arsip Inaktif -->
    <div class="folder-card" style="margin-top:2rem;">
      <div class="folder-card-tab tab-inaktif">
        <i class="bi bi-archive me-1"></i> Inaktif
      </div>
      <div class="folder-card-header">
        <div class="folder-card-icon icon-inaktif">
          <i class="bi bi-archive-fill"></i>
        </div>
        <div>
          <div class="folder-card-title">Daftar Arsip Inaktif</div>
          <div class="folder-card-desc">Pencatatan dan pengelolaan arsip yang telah melewati masa aktif penggunaan.</div>
        </div>
      </div>
      <div class="folder-card-body">
        <ul class="menu-links">
          <li>
            <a href="#">
              <i class="bi bi-plus-square"></i>
              Input Unit Pengolah Yg Ditata
              <i class="bi bi-arrow-right link-arrow"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-pencil-square"></i>
              Input Deskripsi Arsip
              <i class="bi bi-arrow-right link-arrow"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-list-ul"></i>
              Daftar Arsip Inaktif
              <i class="bi bi-arrow-right link-arrow"></i>
            </a>
          </li>
        </ul>
      </div>
      <div class="folder-card-footer">
        <div class="card-count">
          <span class="dot dot-inaktif"></span> 1.284 catatan tersimpan
        </div>
        <a href="#" class="btn-card-link">Lihat Semua <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>

    <!-- CARD 2: Arsip Musnah -->
    <div class="folder-card" style="margin-top:2rem;">
      <div class="folder-card-tab tab-musnah">
        <i class="bi bi-trash3 me-1"></i> Musnah
      </div>
      <div class="folder-card-header">
        <div class="folder-card-icon icon-musnah">
          <i class="bi bi-trash3-fill"></i>
        </div>
        <div>
          <div class="folder-card-title">Daftar Arsip Musnah</div>
          <div class="folder-card-desc">Proses pengajuan dan pencatatan resmi pemusnahan arsip yang telah habis masa retensinya.</div>
        </div>
      </div>
      <div class="folder-card-body">
        <ul class="menu-links">
          <li>
            <a href="#">
              <i class="bi bi-file-earmark-plus"></i>
              Daftar Usul Musnah
              <i class="bi bi-arrow-right link-arrow"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-list-check"></i>
              Daftar Musnah
              <i class="bi bi-arrow-right link-arrow"></i>
            </a>
          </li>
        </ul>
      </div>
      <div class="folder-card-footer">
        <div class="card-count">
          <span class="dot dot-musnah"></span> 347 dalam proses pengajuan
        </div>
        <a href="#" class="btn-card-link">Lihat Semua <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>

    <!-- CARD 3: Arsip Statis -->
    <div class="folder-card" style="margin-top:2rem;">
      <div class="folder-card-tab tab-statis">
        <i class="bi bi-building-lock me-1"></i> Statis
      </div>
      <div class="folder-card-header">
        <div class="folder-card-icon icon-statis">
          <i class="bi bi-building-lock"></i>
        </div>
        <div>
          <div class="folder-card-title">Daftar Arsip Statis</div>
          <div class="folder-card-desc">Pengelolaan dan serah terima arsip bernilai permanen ke lembaga kearsipan.</div>
        </div>
      </div>
      <div class="folder-card-body">
        <ul class="menu-links">
          <li>
            <a href="#">
              <i class="bi bi-send"></i>
              Daftar Usul Serah
              <i class="bi bi-arrow-right link-arrow"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-archive-fill"></i>
              Daftar Arsip Statis
              <i class="bi bi-arrow-right link-arrow"></i>
            </a>
          </li>
        </ul>
      </div>
      <div class="folder-card-footer">
        <div class="card-count">
          <span class="dot dot-statis"></span> 92 arsip statis tercatat
        </div>
        <a href="#" class="btn-card-link">Lihat Semua <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>

  </div><!-- /folder-cards -->


  <!-- ── ACTIVITY + INFO PANEL ───────────────────── -->
  <div class="activity-grid">

    <!-- Aktivitas Terbaru -->
    <div class="activity-card">
      <div class="activity-header">
        <h6>Aktivitas Terbaru</h6>
        <span>Hari ini, 9 Jun 2026</span>
      </div>
      <div class="activity-list">
        <div class="activity-item">
          <div class="activity-dot-wrap">
            <div class="activity-dot" style="background:var(--blue-mid);"></div>
            <div class="activity-line"></div>
          </div>
          <div class="activity-text">
            <strong>Input Deskripsi Arsip — Unit Dinas Pendidikan</strong>
            <span>Oleh Admin Diskominfo · 08:42 WIB</span>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-dot-wrap">
            <div class="activity-dot" style="background:#E67E22;"></div>
            <div class="activity-line"></div>
          </div>
          <div class="activity-text">
            <strong>Pengajuan Usul Musnah — 47 berkas BPKAD</strong>
            <span>Oleh Staff Arsip · 08:15 WIB</span>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-dot-wrap">
            <div class="activity-dot" style="background:#27AE60;"></div>
            <div class="activity-line"></div>
          </div>
          <div class="activity-text">
            <strong>Usul Serah Arsip Statis — Sekretariat Daerah</strong>
            <span>Oleh Kabid Kearsipan · 07:55 WIB</span>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-dot-wrap">
            <div class="activity-dot" style="background:var(--blue-mid);"></div>
            <div class="activity-line"></div>
          </div>
          <div class="activity-text">
            <strong>Input Unit Pengolah — Dinas Kesehatan</strong>
            <span>Oleh Admin Diskominfo · Kemarin, 16:30 WIB</span>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-dot-wrap">
            <div class="activity-dot" style="background:#8E44AD;"></div>
            <div class="activity-line"></div>
          </div>
          <div class="activity-text">
            <strong>Daftar Musnah disetujui — 120 berkas Dishub</strong>
            <span>Oleh Kabid Kearsipan · Kemarin, 14:10 WIB</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Info Panel -->
    <div class="activity-card">
      <div class="activity-header">
        <h6>Informasi Sistem</h6>
      </div>
      <div class="info-card">
        <div class="info-item">
          <div class="info-icon" style="background:var(--blue-soft);color:var(--blue-deep);">
            <i class="bi bi-calendar3"></i>
          </div>
          <div>
            <p>Periode Aktif</p>
            <small>Tahun Anggaran 2026</small>
          </div>
        </div>
        <div class="info-item">
          <div class="info-icon" style="background:#E8F8EE;color:#1B8A45;">
            <i class="bi bi-shield-check"></i>
          </div>
          <div>
            <p>Status Sistem</p>
            <small>Berjalan Normal</small>
          </div>
        </div>
        <div class="info-item">
          <div class="info-icon" style="background:#FDE8C8;color:#C27A08;">
            <i class="bi bi-clock-history"></i>
          </div>
          <div>
            <p>Pembaruan Terakhir</p>
            <small>09 Jun 2026, 08:42 WIB</small>
          </div>
        </div>
        <div class="info-item">
          <div class="info-icon" style="background:#F3E8FF;color:#6B21A8;">
            <i class="bi bi-people"></i>
          </div>
          <div>
            <p>Pengguna Aktif</p>
            <small>3 pengguna terdaftar</small>
          </div>
        </div>
        <div class="info-item" style="padding-bottom:0;border-bottom:none;">
          <div class="info-icon" style="background:var(--blue-soft);color:var(--blue-deep);">
            <i class="bi bi-hdd-network"></i>
          </div>
          <div>
            <p>Instansi</p>
            <small>Diskominfo — Kab. Cilacap</small>
          </div>
        </div>
      </div>
    </div>
  </div>

</div><!-- /main-wrap -->

@endsection
<!-- ═══════════════════════════════════════════════
     FOOTER
════════════════════════════════════════════════ -->
