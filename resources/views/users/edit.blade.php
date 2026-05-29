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

<nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container px-5">
            <a class="navbar-brand" href="{{route('dashboard')}}"><span class="fw-bolder" style="color: #7944B8;">SATU</span><img src="{{ asset('images/arsip.png') }}" width="40" class="mb-3"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                    <li class="nav-item"><a class="btn px-4 btn-logout-green me-3" href="{{route('users.index')}}">Kembali</a></li>
                </ul>
            </div>
        </div>
</nav>

<div style="background: #6495ED; min-height: 100vh; padding: 2rem;">
    <div style="max-width: 900px; margin: 0 auto;">
        <div class="card shadow-sm card-edit-user">
            <div class="card-body p-4">

                <h1>
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit User
                </h1>

                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="text" name="name" value="{{ $user->name }}"
                        class="form-control mb-3"
                        placeholder="Nama">

                    <input type="email" name="email" value="{{ $user->email }}"
                        class="form-control mb-3"
                        placeholder="Email">

                    <input type="text" name="phone_number" value="{{ $user->phone_number }}"
                        class="form-control mb-4"
                        placeholder="Nomor Telepon">

                    <button type="submit" class="btn px-4 btn-update-yellow">
                        <i class="bi bi-check-lg me-1"></i> Update
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
