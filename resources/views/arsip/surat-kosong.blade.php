@extends('layouts.head_customer')
@section('content')
<nav class="navbar-custom">
    <div class="navbar-inner">
        <!-- Brand -->
        <a href="#" class="nav-brand">
            <img src="{{ asset('images/arsip2.png') }}" width="40" class="mb-3" alt="Logo">
            <div class="nav-brand-text">
                <strong>SATU</strong>
                <small>Sistem Informasi Kearsipan Terpadu</small>
            </div>
        </a>

        <!-- Nav Links -->
        <ul class="nav-links">
            <li>
                <a href="{{ route('arsip.home') }}" class="active">
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
<div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-5">
                        <i class="bi bi-link-45deg display-1 text-primary mb-4 d-block"></i>
                        <h1 class="h3 mb-3 fw-bold">Link surat kosong</h1>
                        <p class="text-muted mb-4">
                            harap masukan link drive surat arsip.
                        </p>
                        <p class="text-muted mb-0 fw-semibold">
                            Terima kasih.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection