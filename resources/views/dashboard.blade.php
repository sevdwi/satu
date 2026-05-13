@extends('layouts.head-users')
@section('content')
    <!-- Navigation-->
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container px-5">
            <a class="navbar-brand" href="index.html"><span class="fw-bolder text-primary">SATU</span></a> <span> </span> <img src="{{ asset('images/arsip.png') }}" width="40" class="mb-3">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                    <li class="nav-item btn btn-danger btn-lg px-5 py-3 me-sm-3 fs-6 fw-bolder"><a class="btn btn-primary btn-lg px-5 py-3 me-sm-3 fs-6 fw-bolder" href="{{route('logout')}}">Logout</a></li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class=" nav-link btn btn-danger btn-lg px-5 py-3 me-sm-3 fs-6 fw-bolder text-white" type="submit">
                            Logout
                            </button>
                        </form>
                    </li>

                </ul>
            </div>
        </div>
    </nav> -->

@endsection