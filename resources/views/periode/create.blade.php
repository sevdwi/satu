@extends('layouts.head_customer')

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
        <a href="{{route('dashboard')}}" class="active">
          <i class="bi bi-house"></i> Kembali
        </a>

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


<div class="container mt-4 mb-4">

    <h3>Tambah Tahap Arsip</h3>

    <form action="{{ route('periode.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf 

        <input type="hidden" name="opd_id" value="{{ auth()->user()->opd_id }}">
        
      <div class="row mt-3 ms-2 me-2">

        <div class="col-md-6 mt-3">
            <label>Unit</label>
            <input type="text" name="opd_id" value="{{ auth()->user()->opd_id }}" class="form-control" disabled>
        </div>

        <div class="col-md-6 mt-3">
            <label>Unit</label>
            <input type="text" name="opd_id" value="{{ auth()->user()->opd?->unit_kerja }}" class="form-control" disabled>
        </div>  

        <div class="col-md-6 mt-3">
            <label>Unit</label>
            <input type="text" name="opd_id" value="{{ auth()->user()->opd?->unit_kerja }}" class="form-control" disabled>
        </div>  

        <div class="col-md-6 mt-3">
            <label>Tahun</label>
            <input type="text" name="tahun" value="{{ date('Y'); }}" class="form-control" readonly>
        </div>

        <div class="col-md-6 mt-3">
            <label>Tahap</label>
            <select name="tahap" id="tahap" class="form-input @error('tahap') is-invalid @enderror" required>
                <option value="" disabled {{ old('tahap') == '' ? 'selected' : '' }}>-- Pilih Tahap --</option>
                <option value="1" {{ old('tahap') == '1' ? 'selected' : '' }}>1</option>
                <!-- <option value="2" {{ old('tahap') == '2' ? 'selected' : '' }}>2</option>
                <option value="3" {{ old('tahap') == '3' ? 'selected' : '' }}>3</option>
                <option value="4" {{ old('tahap') == '4' ? 'selected' : '' }}>4</option> -->
            </select>
            @error('tahap')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- kss -->
        <div class="col-md-6 mt-3">
            <label>Status</label>
            <select name="status" id="status" class="form-input @error('status') is-invalid @enderror" required>
                <option value="" disabled {{ old('status') == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                <option value="buka" {{ old('status') == 'buka' ? 'selected' : '' }}>buka</option>
                <!-- <option value="tutup" {{ old('status') == 'tutup' ? 'selected' : '' }}>tutup</option> -->
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-5 mb-5 ">
            <button class="btn btn-primary">
                Simpan
            </button>
        </div>


      </div>
    </form>

</div>
<!-- jQuery (WAJIB paling atas) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection