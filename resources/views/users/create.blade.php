@extends('layouts.head')
<title>Form Registrasi</title>
@section('content')

  <style>
    :root {
      --primary:     #7C3AED;
      --primary-dk:  #5B21B6;
      --primary-md:  #8B5CF6;
      --primary-lt:  #F5F3FF;
      --primary-mid: #EDE9FE;
      --accent:      #EC4899;
      --accent-lt:   #FDF2F8;
      --surface:     #FAFAFF;
      --card-bg:     #FFFFFF;
      --border:      #DDD6FE;
      --text-main:   #1E1033;
      --text-muted:  #7C6FA0;
      --success:     #10B981;
      --danger:      #EF4444;
      --warning:     #F59E0B;
    }

    * { box-sizing: border-box; }

    body {
      min-height: 100vh;
      background: var(--surface);
      font-family: 'Nunito', sans-serif;
      color: var(--text-main);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
      position: relative;
      overflow-x: hidden;
    }

    /* Background blobs */
    body::before, body::after {
      content: '';
      position: fixed;
      border-radius: 50%;
      pointer-events: none;
      filter: blur(80px);
      z-index: 0;
    }
    body::before {
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(124,58,237,.15), transparent 70%);
      top: -150px; left: -100px;
    }
    body::after {
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(236,72,153,.12), transparent 70%);
      bottom: -100px; right: -80px;
    }

    /* ── CARD ── */
    .register-card {
      width: 100%;
      max-width: 680px;
      background: var(--card-bg);
      border-radius: 28px;
      border: 1.5px solid var(--border);
      box-shadow:
        0 0 0 1px rgba(124,58,237,.04),
        0 4px 6px -1px rgba(124,58,237,.08),
        0 24px 64px -12px rgba(124,58,237,.18);
      overflow: hidden;
      animation: slideUp .55s cubic-bezier(.22,.68,0,1.2) both;
      position: relative;
      z-index: 1;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(32px) scale(.96); }
      to   { opacity: 1; transform: translateY(0)   scale(1);   }
    }

    /* ── HEADER STRIP ── */
    .card-header-strip {
      background: linear-gradient(135deg, #4C1D95 0%, #6D28D9 40%, #7C3AED 70%, #A855F7 100%);
      padding: 2.25rem 2.5rem 1.75rem;
      position: relative;
      overflow: hidden;
    }

    /* Geometric accent shapes */
    .card-header-strip::before {
      content: '';
      position: absolute;
      width: 300px; height: 300px;
      border-radius: 50%;
      background: rgba(255,255,255,.07);
      top: -120px; right: -80px;
    }
    .card-header-strip::after {
      content: '';
      position: absolute;
      width: 160px; height: 160px;
      border-radius: 50%;
      border: 2px solid rgba(255,255,255,.12);
      bottom: -60px; left: 40px;
    }

    .hex-deco {
      position: absolute;
      top: 16px; right: 24px;
      opacity: .1;
      font-size: 5rem;
      line-height: 1;
      color: #fff;
      pointer-events: none;
    }

    .badge-pill {
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      background: rgba(255,255,255,.15);
      border: 1px solid rgba(255,255,255,.25);
      color: #e9d5ff;
      border-radius: 999px;
      padding: .28rem .9rem;
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      backdrop-filter: blur(8px);
      position: relative;
      z-index: 1;
    }

    .card-header-strip h1 {
      font-family: 'Syne', sans-serif;
      font-size: 1.85rem;
      font-weight: 800;
      color: #fff;
      margin: .8rem 0 .25rem;
      position: relative;
      z-index: 1;
      letter-spacing: -.03em;
    }

    .card-header-strip p {
      color: rgba(233,213,255,.8);
      font-size: .87rem;
      margin: 0;
      position: relative;
      z-index: 1;
    }

    /* ── FORM BODY ── */
    .card-body-form { padding: 2rem 2.5rem 2.5rem; }

    /* ── SECTION LABEL ── */
    .section-label {
      font-family: 'Syne', sans-serif;
      font-size: .68rem;
      font-weight: 700;
      letter-spacing: .12em;
      text-transform: uppercase;
      color: var(--primary);
      margin-bottom: 1rem;
      margin-top: 1.6rem;
      display: flex;
      align-items: center;
      gap: .6rem;
    }
    .section-label::after {
      content: '';
      flex: 1;
      height: 1.5px;
      background: linear-gradient(90deg, var(--border), transparent);
    }
    .section-label:first-of-type { margin-top: 0; }

    /* ── FORM ELEMENTS ── */
    .form-label {
      font-size: .82rem;
      font-weight: 600;
      color: var(--text-main);
      margin-bottom: .4rem;
    }

    .input-group-text {
      background: var(--primary-lt);
      border-color: var(--border);
      color: var(--primary);
      font-size: .9rem;
    }

    .form-control, .form-select {
      border-color: var(--border);
      border-radius: 10px;
      font-size: .88rem;
      padding: .6rem .85rem;
      color: var(--text-main) !important;
      background-color: #fff !important;
      transition: border-color .2s, box-shadow .2s;
      font-family: 'Nunito', sans-serif;
    }

    .form-select option {
      color: var(--text-main) !important;
      background: #fff !important;
    }

    .input-group .form-control,
    .input-group .form-select { border-radius: 0 10px 10px 0; }
    .input-group .input-group-text:first-child { border-radius: 10px 0 0 10px; }

    .form-control:focus, .form-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3.5px rgba(124,58,237,.13);
      outline: none;
    }

    .form-control::placeholder { color: #c4b5e8; }

    .form-text {
      font-size: .75rem;
      color: var(--text-muted);
    }

    /* ── PASSWORD TOGGLE ── */
    .btn-eye {
      background: var(--primary-lt);
      border: 1px solid var(--border);
      border-left: none;
      color: var(--primary);
      border-radius: 0 10px 10px 0 !important;
      padding: 0 .85rem;
      cursor: pointer;
      transition: background .2s;
    }
    .btn-eye:hover { background: var(--primary-mid); }

    /* ── ROLE CARDS ── */
    .role-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: .75rem;
    }

    .role-card input[type="radio"] { display: none; }

    .role-card label {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: .4rem;
      padding: .85rem .5rem;
      border: 2px solid var(--border);
      border-radius: 16px;
      cursor: pointer;
      transition: all .2s;
      font-size: .78rem;
      font-weight: 700;
      color: var(--text-muted);
      background: var(--primary-lt);
      font-family: 'Syne', sans-serif;
      letter-spacing: .02em;
    }

    .role-card label .role-icon {
      font-size: 1.5rem;
      transition: transform .25s cubic-bezier(.34,1.56,.64,1);
    }

    .role-card input:checked + label {
      border-color: var(--primary);
      background: linear-gradient(135deg, #F5F3FF, #EDE9FE);
      color: var(--primary-dk);
      box-shadow: 0 0 0 3px rgba(124,58,237,.12), inset 0 1px 2px rgba(124,58,237,.08);
    }

    .role-card label:hover { border-color: #A78BFA; background: var(--primary-mid); }
    .role-card input:checked + label .role-icon { transform: scale(1.2) rotate(-5deg); }

    /* ── STATUS PILLS ── */
    .status-grid { display: flex; gap: .75rem; flex-wrap: wrap; }

    .status-opt input[type="radio"] { display: none; }

    .status-opt label {
      display: inline-flex;
      align-items: center;
      gap: .45rem;
      padding: .5rem 1.15rem;
      border: 2px solid var(--border);
      border-radius: 999px;
      cursor: pointer;
      font-size: .8rem;
      font-weight: 700;
      color: var(--text-muted);
      transition: all .2s;
      font-family: 'Syne', sans-serif;
    }

    .status-opt.verify input:checked + label { border-color: var(--warning);  background: #fffbeb; color: #92400e; }
    .status-opt.active input:checked + label { border-color: var(--success);  background: #ecfdf5; color: #065f46; }
    .status-opt.banned input:checked + label { border-color: var(--danger);   background: #fef2f2; color: #991b1b; }
    .status-opt label:hover { border-color: #A78BFA; background: var(--primary-lt); }

    /* ── SUBMIT ── */
    .btn-register {
      background: linear-gradient(135deg, #5B21B6 0%, #7C3AED 50%, #A855F7 100%);
      border: none;
      border-radius: 14px;
      color: #fff;
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: .95rem;
      padding: .9rem;
      width: 100%;
      letter-spacing: .04em;
      transition: transform .18s, box-shadow .18s, filter .18s;
      box-shadow: 0 4px 20px rgba(124,58,237,.35), inset 0 1px 0 rgba(255,255,255,.15);
      position: relative;
      overflow: hidden;
    }

    .btn-register::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,.12), transparent 60%);
      pointer-events: none;
    }

    .btn-register:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 32px rgba(124,58,237,.45);
      filter: brightness(1.07);
    }

    .btn-register:active { transform: translateY(0); }

    /* ── LOGIN LINK ── */
    .login-link {
      text-align: center;
      font-size: .84rem;
      color: var(--text-muted);
      margin-top: 1.25rem;
    }
    .login-link a {
      color: var(--primary);
      font-weight: 700;
      text-decoration: none;
    }
    .login-link a:hover { text-decoration: underline; }

    .req { color: var(--accent); margin-left: 2px; }

    .form-control.is-invalid,
    .form-select.is-invalid { border-color: var(--danger); }
    .invalid-feedback { font-size: .75rem; }

    @media (max-width: 576px) {
      .card-header-strip,
      .card-body-form { padding-left: 1.25rem; padding-right: 1.25rem; }
    }
  </style>
</head>
<body>

<div class="register-card" style="overflow: auto;">

  <!-- ── HEADER ── -->
  <div class="card-header-strip">
    <span class="hex-deco">⬡</span>
    <a class="navbar-brand" href="{{route('dashboard')}}"><span class="fw-bolder" style="color: #ffffff;">SATU</span></a> <span> </span> <img src="{{ asset('images/arsip.png') }}" width="40" class="mb-3">
    <h1>Buat Akun Baru</h1>
    <p>Lengkapi data diri Anda untuk mendaftar ke sistem</p>
  </div>

  <!-- ── FORM ── -->
  <div class="card-body-form">
    <form id="registerForm" novalidate>

      <!-- ── INFORMASI PRIBADI ── -->
      <div class="section-label">Informasi Pribadi</div>

      <!-- Nama Lengkap -->
      <div class="mb-3">
        <label class="form-label" for="name">Nama Lengkap <span class="req">*</span></label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
          <input type="text" class="form-control" id="name" name="name"
                 placeholder="Masukkan nama lengkap Anda" required maxlength="255"/>
          <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
        </div>
      </div>

      <!-- OPD & Nomor HP -->
      <div class="row g-3 mb-3">
        <div class="col-md-7">
          <label class="form-label" for="opd">OPD / Instansi <span class="req">*</span></label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-building-fill"></i></span>
            <select class="form-select" id="opd" name="opd" required
                    style="color:#1E1033 !important; background-color:#fff !important; color-scheme:light;">
              <option value="" disabled selected style="color:#7C6FA0;">-- Pilih OPD --</option>
               @foreach($opds as $opd)
                <option value="{{ $opd->instansi }}" {{ old('opd') == $opd->instansi ? 'selected' : '' }}>
                    {{ $opd->instansi }}
                </option>
               @endforeach
            </select>
            <div class="invalid-feedback">OPD wajib dipilih.</div>
          </div>
        </div>
        <div class="col-md-5">
          <label class="form-label" for="phone_number">Nomor HP <span class="req">*</span></label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
            <input type="tel" class="form-control" id="phone_number" name="phone_number"
                   placeholder="08xxxxxxxxxx" required maxlength="15"
                   pattern="^[0-9\+\-\s]{7,15}$"/>
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
                 placeholder="contoh@email.com" required maxlength="255"/>
          <div class="invalid-feedback">Masukkan alamat email yang valid.</div>
        </div>
        <div class="form-text"><i class="bi bi-info-circle me-1"></i>Email harus unik dan belum pernah digunakan.</div>
      </div>

      <!-- Password -->
      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="form-label" for="password">Password <span class="req">*</span></label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Min. 8 karakter" required minlength="8" maxlength="255"/>
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
                   placeholder="Ulangi password" required minlength="8" maxlength="255"/>
            <button type="button" class="btn-eye" onclick="togglePass('password_confirmation','eyeIcon2')">
              <i class="bi bi-eye-fill" id="eyeIcon2"></i>
            </button>
            <div class="invalid-feedback" id="confirmFeedback">Password tidak cocok.</div>
          </div>
        </div>
      </div>

      <!-- ── ROLE ── -->
      <div class="section-label">Role Pengguna</div>

      <div class="role-grid mb-3">
        <div class="role-card">
          <input type="radio" name="role" id="roleAdmin" value="admin"/>
          <label for="roleAdmin"><span class="role-icon">🛡️</span>Admin</label>
        </div>
        <div class="role-card">
          <input type="radio" name="role" id="roleStaff" value="staff" checked/>
          <label for="roleStaff"><span class="role-icon">👷</span>Staff</label>
        </div>
        <div class="role-card">
          <input type="radio" name="role" id="roleCustomer" value="customer"/>
          <label for="roleCustomer"><span class="role-icon">👤</span>Customer</label>
        </div>
      </div>

      <!-- ── STATUS ── -->
      <div class="section-label">Status Akun</div>

      <div class="status-grid mb-4">
        <div class="status-opt verify">
          <input type="radio" name="status" id="statusVerify" value="verify" checked/>
          <label for="statusVerify"><i class="bi bi-hourglass-split"></i> Verify</label>
        </div>
        <div class="status-opt active">
          <input type="radio" name="status" id="statusActive" value="active"/>
          <label for="statusActive"><i class="bi bi-check-circle-fill"></i> Active</label>
        </div>
        <div class="status-opt banned">
          <input type="radio" name="status" id="statusBanned" value="banned"/>
          <label for="statusBanned"><i class="bi bi-slash-circle-fill"></i> Banned</label>
        </div>
      </div>

      <!-- ── SUBMIT ── -->
      <button type="submit" class="btn-register">
        <i class="bi bi-person-plus-fill me-2"></i>Daftar Sekarang
      </button>

      <div class="login-link mt-3">
        <a href="{{route('dashboard-admin')}}">Kembali</a>
      </div>

    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePass(inputId, iconId) {
    const inp  = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    inp.type   = inp.type === 'password' ? 'text' : 'password';
    icon.className = inp.type === 'text' ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
  }

  const form     = document.getElementById('registerForm');
  const passEl   = document.getElementById('password');
  const confEl   = document.getElementById('password_confirmation');
  const confFeed = document.getElementById('confirmFeedback');

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    confEl.setCustomValidity(passEl.value !== confEl.value ? 'Password tidak cocok' : '');
    if (!form.checkValidity()) { form.classList.add('was-validated'); return; }

    const payload = {
      name:         document.getElementById('name').value.trim(),
      opd:          document.getElementById('opd').value.trim(),
      email:        document.getElementById('email').value.trim(),
      phone_number: document.getElementById('phone_number').value.trim(),
      password:     passEl.value,
      role:         document.querySelector('input[name="role"]:checked').value,
      status:       document.querySelector('input[name="status"]:checked').value,
    };

    console.log('Payload:', payload);
    alert('✅ Registrasi berhasil!\n\nNama: ' + payload.name + '\nOPD: ' + payload.opd);
  });

  confEl.addEventListener('input', () => {
    confEl.setCustomValidity(confEl.value && confEl.value !== passEl.value ? 'Password tidak cocok' : '');
  });
</script>
@endsection
