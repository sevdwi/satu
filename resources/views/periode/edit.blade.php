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
<div class="container mt-4">

    <h3>Edit Tahapan</h3>

    <form action="{{ route('periode.update',$data_periode) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')
        

        <input type="hidden" name="opd_id" value="{{ auth()->user()->opd_id }}">


        <div class="row">

          <div class="col-md-6 mt-3">
                <label>Unit</label>
                <input type="text" name="opd_id" value="{{ auth()->user()->opd_id }}" class="form-control" disabled>
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
                    <option value="" disabled {{ (old('tahap') ?? $data_periode->tahap) == '' ? 'selected' : '' }}>-- Pilih Tahap --</option>
                    <option value="1" {{ (old('tahap') ?? $data_periode->tahap) == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ (old('tahap') ?? $data_periode->tahap) == '2' ? 'selected' : '' }}>2</option>
                    <option value="3" {{ (old('tahap') ?? $data_periode->tahap) == '3' ? 'selected' : '' }}>3</option>
                    <option value="4" {{ (old('tahap') ?? $data_periode->tahap) == '4' ? 'selected' : '' }}>4</option>
                </select>
                @error('tahap')
                        <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <!-- kss -->
            <div class="col-md-6 mt-3">
                <label>Status</label>
                <select name="status" id="status" class="form-input @error('status') is-invalid @enderror" required>
                    <option value="" disabled {{ (old('status') ?? $data_periode->status) == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                    <option value="buka" {{ (old('status') ?? $data_periode->status) == 'buka' ? 'selected' : '' }}>buka</option>
                    <option value="tutup" {{ (old('status') ?? $data_periode->status) == 'tutup' ? 'selected' : '' }}>tutup</option>
                </select>
                @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <button class="btn btn-primary mt-3 mb-3">
            Simpan
        </button>


    </form>

</div>

@endsection