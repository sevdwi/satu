@extends('layouts.head')
@section('content')
<style>
/* edit-user.css */

.card-edit-user {
    border-radius: 16px;
    border: 1px solid #fde68a;
    max-width: 500px;
}

.card-edit-user h1 {
    font-size: 22px;
    font-weight: 600;
    color: #92400e;
    margin-bottom: 1.25rem;
}

.card-edit-user h1 i {
    color: #d97706;
}

.card-edit-user .form-control {
    border-radius: 8px;
    border: 1.5px solid #fcd34d;
    font-size: 14px;
    background: #fffbeb;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.card-edit-user .form-control:focus {
    border-color: #d97706;
    box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.15);
    background: #fffbeb;
}

.btn-update-yellow {
    background: #d97706;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    transition: background 0.2s ease, transform 0.15s ease;
}

.btn-update-yellow:hover {
    background: #b45309;
    color: #fff;
}

.btn-update-yellow:active {
    background: #92400e;
    color: #fff;
    transform: scale(0.97);
}
</style>

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
          <i class="bi bi-house"></i> Kembali
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

<div class="page-wrap">
 
  <!-- Breadcrumb -->
  <div class="breadcrumb-custom">
    <a href="#"><i class="bi bi-house"></i></a>
    <i class="bi bi-chevron-right"></i>
    <a href="#">Data Pengguna</a>
    <i class="bi bi-chevron-right"></i>
    <span class="current">Edit User</span>
  </div>
 
  <div class="card-custom">
 
    <!-- Card Header -->
    <div class="card-top">
      <div class="card-icon"><i class="bi bi-pencil-square"></i></div>
      <div>
        <div class="card-title">Edit User</div>
        <div class="card-subtitle">Perbarui data pengguna yang dipilih</div>
      </div>
    </div>
 
    <!-- User Identity Strip -->
    <div class="user-strip">
      <div class="user-avatar-lg">AD</div>
      <div>
        <div class="user-strip-name">{{ $user->role }}</div>
        <div class="user-strip-label">ID <span>{{ $user->id }}</span>---<span>{{ $user->status }}</span></div>
      </div>
      <span class="user-strip-badge">
        <i class="bi bi-circle-fill" style="font-size:.45rem;"></i> Aktif
      </span>
    </div>
 
    <!-- Form -->
    <div class="card-body-form">
 
      {{-- Ganti action="{{ route('users.update', $user) }}" dan value="{{ $user->xxx }}" sesuai Blade --}}
    <form action="{{ route('users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="section-label">Informasi Pengguna</div>

    <!-- Nama -->
    <div class="form-group">
      <label class="form-label-custom">
        <i class="bi bi-person"></i> Nama Pengguna <span class="required">*</span>
      </label>
      <div class="input-wrap">
        <i class="bi bi-person input-icon"></i>
        <input type="text" name="name" class="form-input @error('name') is-invalid @enderror" 
              value="{{ old('name') ?? $user->name }}" placeholder="Nama pengguna" required />
      </div>
      @error('name')
        <div class="invalid-feedback text-danger small mt-1">
          <i class="bi bi-exclamation-circle"></i> {{ $message }}
        </div>
      @enderror
    </div>

    <!-- Role -->
    <div class="form-group">
      <label class="form-label-custom" for="role">
        <i class="bi bi-shield-lock"></i> Role <span class="required">*</span>
      </label>
      <div class="input-wrap">
        <i class="bi bi-shield-lock input-icon"></i>
        <select name="role" id="role" class="form-input @error('role') is-invalid @enderror" required>
          <option value="" disabled {{ (old('role') ?? $user->role) == '' ? 'selected' : '' }}>-- Pilih Role --</option>
          <option value="admin" {{ (old('role') ?? $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="pengolah" {{ (old('role') ?? $user->role) == 'pengolah' ? 'selected' : '' }}>Pengolah</option>
          <option value="sekretariat" {{ (old('role') ?? $user->role) == 'sekretariat' ? 'selected' : '' }}>Sekretariat</option>
          <option value="customer" {{ (old('role') ?? $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
        </select>
      </div>
      @error('role')
        <div class="invalid-feedback text-danger small mt-1">
          <i class="bi bi-exclamation-circle"></i> {{ $message }}
        </div>
      @enderror
    </div>

    <!-- Status -->
    <div class="form-group">
      <label class="form-label-custom" for="status">
        <i class="bi bi-toggle-on"></i> Status <span class="required">*</span>
      </label>
      <div class="input-wrap">
        <i class="bi bi-toggle-on input-icon"></i>
        <select name="status" id="status" class="form-input @error('status') is-invalid @enderror" required>
          <option value="" disabled {{ (old('status') ?? $user->status) == '' ? 'selected' : '' }}>-- Pilih Status --</option>
          <option value="active" {{ (old('status') ?? $user->status) == 'active' ? 'selected' : '' }}>Active</option>
          <option value="banned" {{ (old('status') ?? $user->status) == 'banned' ? 'selected' : '' }}>Banned</option>
          <option value="verify" {{ (old('status') ?? $user->status) == 'verify' ? 'selected' : '' }}>Verify</option>
        </select>
      </div>
      @error('status')
        <div class="invalid-feedback text-danger small mt-1">
          <i class="bi bi-exclamation-circle"></i> {{ $message }}
        </div>
      @enderror
    </div>

    <!-- Email -->
    <div class="form-group">
      <label class="form-label-custom">
        <i class="bi bi-envelope"></i> Alamat Email <span class="required">*</span>
      </label>
      <div class="input-wrap">
        <i class="bi bi-envelope input-icon"></i>
        <input type="email" name="email" class="form-input @error('email') is-invalid @enderror" 
              value="{{ old('email') ?? $user->email }}" placeholder="contoh@email.com" required />
      </div>
      @error('email')
        <div class="invalid-feedback text-danger small mt-1">
          <i class="bi bi-exclamation-circle"></i> {{ $message }}
        </div>
      @enderror
    </div>

    <!-- Nomor Telepon -->
    <div class="form-group">
      <label class="form-label-custom">
        <i class="bi bi-telephone"></i> Nomor Telepon <span class="required">*</span>
      </label>
      <div class="input-wrap">
        <i class="bi bi-telephone input-icon"></i>
        <input type="text" name="phone_number" class="form-input @error('phone_number') is-invalid @enderror" 
              value="{{ old('phone_number') ?? $user->phone_number }}" placeholder="08xxxxxxxxxx" required />
      </div>
      <div class="form-hint">
        <i class="bi bi-info-circle"></i> Format: diawali 08, tanpa tanda hubung.
      </div>
      @error('phone_number')
        <div class="invalid-feedback text-danger small mt-1">
          <i class="bi bi-exclamation-circle"></i> {{ $message }}
        </div>
      @enderror
    </div>

    <!-- Password (Opsional saat update) -->
    <div class="form-group">
      <label class="form-label-custom">
        <i class="bi bi-key"></i> Password Baru <span class="text-muted" style="font-size: 0.8rem;">(Kosongkan jika tidak ingin mengubah)</span>
      </label>
      <div class="input-wrap">
        <i class="bi bi-key input-icon"></i>
        <input type="password" name="password" class="form-input @error('password') is-invalid @enderror" 
              placeholder="Minimal 4 karakter" />
      </div>
      @error('password')
        <div class="invalid-feedback text-danger small mt-1">
          <i class="bi bi-exclamation-circle"></i> {{ $message }}
        </div>
      @enderror
    </div>

    {{-- Field Tersembunyi (Sesuai database pada method store) --}}
    <input type="hidden" name="opd_id" value="{{ old('opd_id') ?? $user->opd_id }}">
    <input type="hidden" name="opd_induk_id" value="{{ old('opd_induk_id') ?? $user->opd_induk_id }}">

    <hr class="form-divider" />

    <!-- Action Buttons -->
    <div class="action-row">
      <a href="{{route('users.index')}}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
      <button type="submit" class="btn-update">
        <i class="bi bi-check-lg"></i> Simpan Perubahan
      </button>
    </div>

</form>

    </div>
 
  </div>
</div>
@endsection
