@extends('layouts.head_customer')
@section('content')
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container px-5">
            <a class="navbar-brand" href="{{route('dashboard')}}"><span class="fw-bolder" style="color: #7944B8;">SATU</span><img src="{{ asset('images/arsip.png') }}" width="40" class="mb-3"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                    <li class="nav-item"><a class="btn px-4 btn-logout-purple me-3" href="{{route('arsip.index')}}">Kelola Arsip</a></li>
                    <!-- <li class="nav-item"><a class="btn px-4 btn-logout-blue me-3" href="{{route('users.index')}}">Kelola Users</a></li> -->
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn px-4 btn-logout-red">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    </li>


                </ul>
            </div>
        </div>
</nav>

<div style="background: #6495ED; min-height: 100vh; padding: 2rem;">
    <div style="max-width: 900px; margin: 0 auto;">
        <div class="card shadow-sm" style="border-radius: 16px; border: 1px solid #e0dbff;">
            <div class="card-body p-4 row">
                <div class="col-md-7">
                {{-- Header --}}
                <h4 class="fw-semibold mb-4" style="color: #3C3489;">
                    <i class="bi bi-house-fill me-2" style="color: #6495ED;"></i>
                    Beranda
                </h4>

                </div>
                <div class="col-md-5">
                {{-- User akun --}}
                <h4 class="fw-semibold mb-4" style="color: #3C3489;">
                    <i class="bi bi-people-fill me-2" style="color: #6495ED;"></i>
                    {{ auth()->guard('web')->user()->name }}
                </h4>
                </div>

                {{-- Tabel --}}
                <table class="table align-middle" style="font-size: 14px;">
                    <thead style="background: #6495ED;">
                        <tr>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">ID</th>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">Name</th>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">OPD</th>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">Email</th>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">Number</th>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">Aksi</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection