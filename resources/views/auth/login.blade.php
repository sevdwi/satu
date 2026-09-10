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
        {{-- Google reCAPTCHA --}}  
        <!-- Load API Google reCAPTCHA -->
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>

        <style>
            /* Sembunyikan badge bawaan Google yang melayang di pojok kanan bawah */
            .grecaptcha-badge {
                visibility: hidden !important;
            }

            /* Styling untuk teks info di bawah tombol login */
            .recaptcha-info {
                margin-top: 12px;
                text-align: center;
                font-size: 11px;
                color: #777;
            }

            .recaptcha-info a {
                color: #555;
                text-decoration: none;
            }

            .recaptcha-info a:hover {
                text-decoration: underline;
            }
        </style>

        <form action="/login" method="POST" id="loginForm">
            @csrf

            <!-- Nomor HP -->
            <div class="form-group">
                <label class="form-label-custom">
                    <i class="bi bi-telephone"></i> Nomor HP
                </label>

                <div class="input-wrap">
                    <i class="bi bi-telephone i-icon"></i>
                    <input type="number"
                           name="phone_number"
                           class="form-input"
                           placeholder="08xxxxxxxxxx"
                           value="{{ old('phone_number') }}"
                           required>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label-custom">
                    <i class="bi bi-lock"></i> Password
                </label>

                <div class="input-wrap">
                    <i class="bi bi-lock i-icon"></i>
                    <input type="password"
                           name="password"
                           id="passwordInput"
                           class="form-input has-toggle"
                           placeholder="Masukkan password"
                           required>

                    <button type="button"
                            class="toggle-pw-btn"
                            id="togglePw"
                            title="Tampilkan password">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Input hidden untuk menyimpan token reCAPTCHA -->
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

            @error('g-recaptcha-response')
                <div class="text-danger mt-2">
                    {{ $message }}
                </div>
            @enderror

            <hr class="form-divider">

            <!-- Tombol Submit -->
            <button type="submit" class="btn-submit" id="loginButton">
                <i class="bi bi-box-arrow-in-right"></i> Masuk
            </button>
            
            <!-- Teks Pemberitahuan reCAPTCHA (Wajib karena badge disembunyikan) -->
            <div class="recaptcha-info">
                <span>Protected by reCAPTCHA</span>
                <a href="https://policies.google.com/privacy" target="_blank">Privacy</a>
                -
                <a href="https://policies.google.com/terms" target="_blank">Terms</a>
            </div>
        </form>

        <script>
        // Catatan: server (UserController::login) TIDAK memvalidasi
        // g-recaptcha-response sama sekali — token ini murni informatif.
        // Sebelumnya, kalau grecaptcha gagal load/execute (site key belum
        // di-whitelist untuk domain yang dipakai, koneksi ke Google
        // diblokir firewall/ad-blocker, dll), form INI TERKUNCI TOTAL:
        // event.preventDefault() sudah terlanjur jalan lalu promise-nya
        // gagal, jadi submit tidak pernah terjadi — user cuma lihat
        // "tidak bisa login" tanpa request pernah sampai ke server (makanya
        // tidak ada apa pun di laravel.log). Sekarang: kalau recaptcha
        // gagal dengan cara apa pun, form tetap dikirim sebagai fallback.
        (function () {
            const form = document.getElementById('loginForm');
            const button = document.getElementById('loginButton');

            function submitWithoutRecaptcha() {
                if (button) button.disabled = false;
                form.submit();
            }

            if (typeof grecaptcha === 'undefined') {
                // Script reCAPTCHA gagal dimuat sama sekali — biarkan
                // form submit normal (native), jangan pasang handler apa pun.
                console.warn('reCAPTCHA tidak termuat, lanjut tanpa verifikasi.');
                return;
            }

            grecaptcha.ready(function () {
                form.addEventListener('submit', function (event) {
                    event.preventDefault(); // Hentikan proses submit bawaan form sementara

                    if (button) button.disabled = true; // Nonaktifkan tombol agar user tidak klik 2 kali

                    // Generate token reCAPTCHA
                    grecaptcha.execute(
                        '6LcepWsrAAAAACyuyQURxFBA1qY-NXeFo6aGJ7-6',
                        { action: 'login' }
                    ).then(function (token) {

                        // Masukkan token ke input hidden
                        document.getElementById('g-recaptcha-response').value = token;

                        // Lanjutkan submit form secara manual ke server
                        form.submit();

                    }).catch(function (error) {
                        console.error('reCAPTCHA error, lanjut submit tanpa token:', error);
                        submitWithoutRecaptcha();
                    });
                });
            });
        })();
        </script>

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