@extends('layouts.head')
@section('content')
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container px-5">
            <a class="navbar-brand" href="{{route('dashboard')}}"><span class="fw-bolder" style="color: #7944B8;">SATU</span><img src="{{ asset('images/arsip.png') }}" width="40" class="mb-3"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                    <li class="nav-item"><a class="btn px-4 btn-logout-purple me-3" href="{{route('master-kodes.index')}}">Data Klasifikasi</a></li>
                    <li class="nav-item"><a class="btn px-4 btn-logout-blue me-3" href="{{route('users.index')}}">Kelola Users</a></li>
                    <li class="nav-item">
                        <form action="{{ route('logout-admin') }}" method="POST">
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

@endsection