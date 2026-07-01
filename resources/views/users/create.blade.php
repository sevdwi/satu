@extends('layouts.head')
<title>Form Registrasi</title>
@section('content')

  <style>
    :root {
      --bg:        #EFF6FF;
      --surface:   #FFFFFF;
      --blue-deep: #1B5E8A;
      --blue-mid:  #4A9CC7;
      --blue-pale: #D5EAF7;
      --blue-soft: #EBF5FC;
      --border:    #BDD8EE;
      --text:      #0D3B5E;
      --muted:     #5A7D96;
      --danger:    #DC2626;
      --radius:    18px;
    }
 
    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin: 0; }
    body {
      font-family: 'Nunito', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
 
    .page-wrap {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2.5rem 1rem;
    }
 
    /* ═══════════════════════════════════════════════
       CARD SHELL
    ════════════════════════════════════════════════ */
    .register-card {
      width: 100%;
      max-width: 640px;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: 0 10px 44px rgba(27,94,138,.13);
      overflow: hidden;
    }
 
    /* ── HEADER STRIP ────────────────────────────── */
    .card-header-strip {
      background: linear-gradient(135deg, #0D3B5E 0%, #1B5E8A 50%, #4A9CC7 100%);
      padding: 2.5rem 2.5rem 2.25rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .card-header-strip::before {
      content: '';
      position: absolute; inset: 0;
      background-image:
        repeating-linear-gradient(0deg, transparent, transparent 33px, rgba(255,255,255,.05) 34px),
        repeating-linear-gradient(90deg, transparent, transparent 89px, rgba(255,255,255,.03) 90px);
      pointer-events: none;
    }
    .hex-deco {
      position: absolute;
      top: 14px; right: 22px;
      font-size: 2.4rem;
      color: rgba(255,255,255,.08);
      line-height: 1;
      pointer-events: none;
    }
    .header-brand-row {
      display: flex; align-items: center; justify-content: center; gap: .55rem;
      position: relative; z-index: 1;
      margin-bottom: 1.4rem;
    }
    .header-brand-icon {
      width: 36px; height: 36px;
      /* background: rgba(255,255,255,.15);
      border: 1px solid rgba(255,255,255,.3); */
      border-radius: 9px;
      display: flex; align-items: center; justify-content: center;
    }
    .header-brand-icon svg { width: 18px; height: 18px; fill: #fff; }
    .header-wordmark {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.3rem; font-weight: 700;
      color: #fff; letter-spacing: .03em;
    }
    .card-header-strip h1 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.85rem; font-weight: 600;
      color: #fff; margin: 0 0 .4rem;
      position: relative; z-index: 1;
    }
    .card-header-strip p {
      font-size: .85rem;
      color: rgba(255,255,255,.7);
      margin: 0;
      position: relative; z-index: 1;
    }
 
    /* ── FORM BODY ───────────────────────────────── */
    .card-body-form { padding: 2rem 2.25rem 2.25rem; }
 
    .section-label {
      font-size: .7rem; font-weight: 700;
      letter-spacing: .1em; text-transform: uppercase;
      color: var(--blue-mid);
      padding-bottom: .55rem;
      border-bottom: 1px solid var(--border);
      margin: 1.75rem 0 1.25rem;
    }
    .section-label:first-of-type { margin-top: 0; }
 
    .form-label {
      font-size: .81rem; font-weight: 600;
      color: var(--text); margin-bottom: .42rem;
      display: inline-block;
    }
    .req { color: var(--danger); margin-left: .1rem; }
 
    /* ── INPUT GROUP (icon INSIDE input, single box — no overlap) ── */
    /* Self-contained: icon sits absolutely inside one bordered box,
       instead of Bootstrap's two-piece span+input layout. This avoids
       collisions if external page CSS overrides flex/border-radius. */
    .input-group {
      position: relative;
      display: block;
      margin-bottom: 20px;
    }
    .input-group-text {
      position: absolute;
      top: 40%; left: 1px;
      transform: translateY(-50%);
      width: 38px;
      height: calc(100% - 4px);
      display: flex;
      align-items: center;
      justify-content: center;
      background: transparent;
      border: none;
      color: var(--blue-mid);
      font-size: .88rem;
      pointer-events: none;
      z-index: 2;
      transition: color .2s;
    }
    .form-control, .form-select {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      background: #FDFCFF;
      font-family: 'Nunito', sans-serif;
      font-size: .87rem;
      color: var(--text);
      padding: .62rem .9rem .62rem 2.5rem;
      transition: border-color .2s, box-shadow .2s, background .2s;
    }
    .form-control::placeholder { color: #A8C4D8; }
    .form-control:focus, .form-select:focus {
      border-color: var(--blue-mid);
      box-shadow: 0 0 0 4px rgba(74,156,199,.12);
      background: #fff;
    }
    .input-group:focus-within .input-group-text { color: var(--blue-deep); }
    .form-select {
      cursor: pointer;
      appearance: none;
      -webkit-appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%235A7D96' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 1rem center;
      padding-right: 2.5rem;
    }
 
    /* Password fields need extra right padding for the eye button */
    #password, #password_confirmation { padding-right: 2.8rem; }
 
    /* Password toggle button — absolutely positioned at right edge */
    .btn-eye {
      position: absolute;
      top: 50%; right: 2px;
      transform: translateY(-50%);
      width: 38px;
      height: calc(100% - 4px);
      display: flex;
      align-items: center;
      justify-content: center;
      border: none;
      background: transparent;
      color: var(--muted);
      cursor: pointer;
      z-index: 2;
      transition: color .15s;
    }
    .btn-eye:hover { color: var(--blue-deep); }
 
    .invalid-feedback { font-size: .73rem; }
    .form-text {
      font-size: .73rem; color: var(--muted); margin-top: .35rem;
      display: flex; align-items: center;
    }
 
    /* ═══════════════════════════════════════════════
       ROLE CARDS (radio as card)
    ════════════════════════════════════════════════ */
    .role-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: .75rem;
      margin-left: 80px;
    }
    .role-card { position: relative; }
    .role-card input[type="radio"] {
      position: absolute;
      opacity: 0;
      width: 0; height: 0;
    }
    .role-card label {
      display: flex; flex-direction: column; align-items: center;
      gap: .5rem;
      padding: 1.1rem .75rem;
      border: 1.5px solid var(--border);
      border-radius: 12px;
      background: var(--bg);
      font-size: .82rem; font-weight: 600;
      color: var(--muted);
      cursor: pointer;
      transition: all .18s;
      text-align: center;
      margin: 0;
    }
    .role-icon { font-size: 1.4rem; line-height: 1; }
    .role-card label:hover {
      border-color: var(--blue-mid);
      background: var(--blue-soft);
    }
    .role-card input[type="radio"]:checked + label {
      border-color: var(--blue-deep);
      background: var(--blue-soft);
      color: var(--blue-deep);
      box-shadow: 0 0 0 3px rgba(27,94,138,.1);
    }
    .role-card input[type="radio"]:checked + label::after {
      content: '\F26E';
      font-family: 'bootstrap-icons';
      position: absolute;
      top: 8px; right: 10px;
      font-size: .8rem;
      color: var(--blue-deep);
    }
 
    /* ═══════════════════════════════════════════════
       STATUS PILLS (radio as pill)
    ════════════════════════════════════════════════ */
    .status-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: .65rem;
      margin-left: 80px;

    }
    .status-opt { position: relative; }
    .status-opt input[type="radio"] {
      position: absolute; opacity: 0; width: 0; height: 0;
    }
    .status-opt label {
      display: flex; align-items: center; justify-content: center; gap: .45rem;
      padding: .65rem .6rem;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      background: var(--surface);
      font-size: .79rem; font-weight: 600;
      color: var(--muted);
      cursor: pointer;
      transition: all .18s;
      margin: 0;
    }
    .status-opt label:hover { background: var(--bg); }
 
    .status-opt.verify input:checked + label {
      border-color: #D4A015; background: #FEF9E7; color: #92701A;
    }
    .status-opt.active input:checked + label {
      border-color: #27AE60; background: #EAFAF1; color: #1B8A45;
    }
    .status-opt.banned input:checked + label {
      border-color: #E74C3C; background: #FDEDEC; color: #B91C1C;
    }
 
    /* ═══════════════════════════════════════════════
       SUBMIT + LINKS
    ════════════════════════════════════════════════ */
    .btn-register {
      width: 100%;
      padding: .78rem 1rem;
      border: none; border-radius: 11px;
      background: var(--blue-deep); color: #fff;
      font-family: 'Nunito', sans-serif;
      font-size: .92rem; font-weight: 700;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: background .18s, transform .15s, box-shadow .18s;
      margin-top: 1.75rem;
    }
    .btn-register:hover {
      background: #164d72;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(27,94,138,.3);
    }
    .btn-register:active { transform: translateY(0); }
 
    .login-link { text-align: center; }
    .login-link a {
      display: inline-flex; align-items: center; gap: .4rem;
      font-size: .81rem; font-weight: 600;
      color: var(--muted); text-decoration: none;
      transition: color .15s;
    }
    .login-link a:hover { color: var(--blue-deep); }
 
    /* ── FOOTER ──────────────────────────────────── */
    footer {
      background: var(--surface);
      border-top: 1px solid var(--border);
      padding: 1.25rem 2rem;
      text-align: center;
    }
    footer p { font-size: .76rem; color: var(--muted); margin: 0; }
    footer strong { color: var(--blue-deep); }
 
    @media (max-width: 576px) {
      .role-grid, .status-grid { grid-template-columns: 1fr; }
      .card-header-strip { padding: 2rem 1.5rem; }
      .card-body-form { padding: 1.75rem 1.25rem 2rem; }
    }
  </style>
</head>
<body>

<div class="page-wrap">
  <div class="register-card">
 
    <!-- ═══════════ HEADER ═══════════ -->
    <div class="card-header-strip">
      <span class="hex-deco">⬡</span>
 
      <div class="header-brand-row">
        <div class="header-brand-icon">
        <img src="{{ asset('images/arsip2.png') }}" width="40" class="mb-3">
        </div>
        <span class="header-wordmark">SATU</span>
      </div>
 
      <h1>Buat Akun Baru</h1>
      <p>Lengkapi data diri Anda untuk mendaftar ke sistem</p>
    </div>
 
    <!-- ═══════════ FORM ═══════════ -->
    <div class="card-body-form">
      <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
 
        <!-- ── INFORMASI PRIBADI ── -->
        <div class="section-label">Informasi Pribadi</div>
 
        <!-- Nama Lengkap -->
        <div class="mb-7">
          <label class="form-label" for="name">Nama Lengkap <span class="req">*</span></label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
            <input type="text" class="form-control" id="name" name="name"
                   placeholder="Masukkan nama lengkap Anda" required maxlength="255" />
            <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
          </div>
        </div>
 
        <!-- OPD & Nomor HP -->
        <div class="row g-3 mb-3">
          <div class="col-md-7">
            <label class="form-label" for="opd">OPD / Instansi <span class="req">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-building-fill"></i></span>
              <select class="form-select" id="opd" name="opd_induk_id" required>
                <option value="" disabled selected>-- Pilih Unit Kerja --</option>
                @foreach($opd_induks as $opd_induk)
                  <option value="{{ $opd_induk->id }}" {{ old('opd_induk_id') == $opd_induk->id ? 'selected' : '' }}>
                    {{ $opd_induk->instansi }}
                  </option>
                @endforeach
              </select>
              <div class="invalid-feedback">Unit Kerja wajib dipilih.</div>
            </div>
          </div>

          <div class="col-md-7">
            <label class="form-label" for="opd">Unit Kerja <span class="req">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-building-fill"></i></span>
              <select class="form-select" id="opd" name="opd_id" required>
                <option value="" disabled selected>-- Pilih Unit Kerja --</option>
                @foreach($opds as $opd)
                  <option value="{{ $opd->id }}" {{ old('opd_id') == $opd->id ? 'selected' : '' }}>
                    {{ $opd->unit_kerja }}
                  </option>
                @endforeach
              </select>
              <div class="invalid-feedback">Unit Kerja wajib dipilih.</div>
            </div>
          </div>

          <div class="col-md-5">
            <label class="form-label" for="phone_number">Nomor HP <span class="req">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
              <input type="tel" class="form-control" id="phone_number" name="phone_number"
                     placeholder="08xxxxxxxxxx" required maxlength="15"
                     pattern="^[0-9\+\-\s]{7,15}$" />
              <div class="invalid-feedback">Nomor HP tidak valid.</div>
            </div>
          </div>
        </div>
 
        <!-- ── AKUN & KEAMANAN ── -->
        <div class="section-label">Akun &amp; Keamanan</div>
 
        <!-- Email -->
        <div class="mb-3">
          <label class="form-label" for="email">Alamat Email <span class="req">*</span></label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
            <input type="email" class="form-control" id="email" name="email"
                   placeholder="contoh@email.com" required maxlength="255" />
            <!-- <div class="invalid-feedback">Masukkan alamat email yang valid.</div> -->
            <div class="form-text"><i class="bi bi-info-circle me-1"></i>Masukan Email yang valid dan harus unik dan belum pernah digunakan.</div>
          </div>
        </div>
 
        <!-- Password -->
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label" for="password">Password <span class="req">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password" class="form-control" id="password" name="password"
                     placeholder="Min. 8 karakter" required minlength="8" maxlength="255" />
              <button type="button" class="btn-eye" onclick="togglePass('password','eyeIcon1')">
                <i class="bi bi-eye-fill" id="eyeIcon1"></i>
              </button>
              <div class="invalid-feedback">Password minimal 8 karakter.</div>
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="password_confirmation">Konfirmasi Password <span class="req">*</span></label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password" class="form-control" id="password_confirmation"
                     name="password_confirmation"
                     placeholder="Ulangi password" required minlength="8" maxlength="255" />
              <button type="button" class="btn-eye" onclick="togglePass('password_confirmation','eyeIcon2')">
                <i class="bi bi-eye-fill" id="eyeIcon2"></i>
              </button>
              <!-- <div class="invalid-feedback" id="confirmFeedback">Password tidak cocok.</div> -->
            </div>
          </div>
        </div>
 
        <!-- ── ROLE ── -->
        <div class="section-label">Role Pengguna</div>
 
        <div class="role-grid mb-3">
          <div class="role-card">
            <input type="radio" name="role" id="roleAdmin" value="admin" />
            <label for="roleAdmin"><span class="role-icon">🛡️</span>Admin</label>
          </div>
          <!-- <div class="role-card">
            <input type="radio" name="role" id="roleStaff" value="staff" checked />
            <label for="roleStaff"><span class="role-icon">👷</span>Staff</label>
          </div> -->
          <div class="role-card">
            <input type="radio" name="role" id="roleCustomer" value="customer" />
            <label for="roleCustomer"><span class="role-icon">👤</span>Customer</label>
          </div>
        </div>
 
        <!-- ── STATUS ── -->
        <div class="section-label">Status Akun</div>
 
        <div class="status-grid mb-2">
          <!-- <div class="status-opt verify">
            <input type="radio" name="status" id="statusVerify" value="verify" checked />
            <label for="statusVerify"><i class="bi bi-hourglass-split"></i> Verify</label>
          </div> -->
          <div class="status-opt active">
            <input type="radio" name="status" id="statusActive" value="active" />
            <label for="statusActive"><i class="bi bi-check-circle-fill"></i> Active</label>
          </div>
          <div class="status-opt banned">
            <input type="radio" name="status" id="statusBanned" value="banned" />
            <label for="statusBanned"><i class="bi bi-slash-circle-fill"></i> Banned</label>
          </div>
        </div>
 
        <!-- ── SUBMIT ── -->
        <button type="submit" class="btn-register">
          <i class="bi bi-person-plus-fill me-2"></i>Daftar Sekarang
        </button>
 
        <div class="login-link mt-3">
          <a href="{{ route('dashboard-admin') }}"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
 
      </form>
    </div>
 
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePass(fieldId, iconId) {
    const input = document.getElementById(fieldId);
    const icon  = document.getElementById(iconId);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    icon.className = isHidden ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
  }
</script>
@endsection
