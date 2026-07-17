@extends('layouts.head')

@section('content')

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
        <i class="bi">
        <form action="{{ route('logout-admin') }}" method="POST">
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

<div class="page-wrap">
    <h3 class="text-center">Tambah User</h3>

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @else
                <div class="invalid-feedback">Nama wajib diisi.</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @else
                <div class="invalid-feedback">Format email tidak valid atau kosong.</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Nomor Telepon</label>
            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" class="form-control @error('phone_number') is-invalid @enderror" required>
            @error('phone_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @else
                <div class="invalid-feedback">Nomor telepon wajib diisi.</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @else
                <div class="invalid-feedback">Password wajib diisi.</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="opd_induk_id" class="form-label">OPD Induk</label>
            <select class="form-select @error('opd_induk_id') is-invalid @enderror" id="opd_induk_id" name="opd_induk_id" required>
                <option value="" disabled selected>-- Pilih OPD Induk --</option>
                @foreach($opd_induks as $opd_induk)
                    <option value="{{ $opd_induk->id }}" {{ old('opd_induk_id') == $opd_induk->id ? 'selected' : '' }}>
                        {{ $opd_induk->instansi }}
                    </option>
                @endforeach
            </select>
            @error('opd_induk_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @else
                <div class="invalid-feedback">Silakan pilih OPD Induk.</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="opd_id" class="form-label">OPD</label>
            <select class="form-select @error('opd_id') is-invalid @enderror" id="opd_id" name="opd_id" required>
                <option value="" disabled selected>-- Pilih Unit Kerja --</option>
                @foreach($opds as $opd)
                    <option value="{{ $opd->id }}" {{ old('opd_id') == $opd->id ? 'selected' : '' }}>
                        {{ $opd->unit_kerja }}
                    </option>
                @endforeach
            </select>
            @error('opd_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @else
                <div class="invalid-feedback">Silakan pilih OPD.</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Role --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="pengolah" {{ old('role') == 'pengolah' ? 'selected' : '' }}>Pengolah</option>
            </select>
            @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
            @else
                <div class="invalid-feedback">Role wajib dipilih.</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="" disabled {{ old('status') ? '' : 'selected' }}>-- Pilih Status --</option>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="banned" {{ old('status') == 'banned' ? 'selected' : '' }}>Non-Aktif</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @else
                <div class="invalid-feedback">Status wajib dipilih.</div>
            @enderror
        </div>
        

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
    
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Seleksi formulir yang memerlukan validasi kustom Bootstrap
        const forms = document.querySelectorAll('.needs-validation');

        // Berikan penanganan kejadian 'submit' pada setiap formulir
        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                // Hentikan pengiriman jika formulir tidak valid secara aturan HTML5
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                // Tambahkan kelas indikator ke formulir untuk memunculkan gaya error
                form.classList.add('was-validated');
            }, false);
        });
    });
</script>
