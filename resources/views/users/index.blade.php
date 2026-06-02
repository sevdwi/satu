@extends('layouts.head')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container px-5">
            <a class="navbar-brand" href="{{route('dashboard')}}"><span class="fw-bolder" style="color: #7944B8;">SATU</span><img src="{{ asset('images/arsip.png') }}" width="40" class="mb-3"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                    <li class="nav-item"><a class="btn px-4 btn-logout-green me-3" href="{{route('dashboard-admin')}}">Kembali</a></li>
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
            <div class="card-body p-4">

                {{-- Header --}}
                <h4 class="fw-semibold mb-4" style="color: #3C3489;">
                    <i class="bi bi-people-fill me-2" style="color: #6495ED;"></i>
                    List Users
                </h4>

                {{-- Tombol Tambah --}}
                <a href="{{ route('users.create') }}"
                   class="btn mb-4 px-4"
                   style="background: #6495ED; color: #fff; border-radius: 8px; font-size: 14px;">
                    <i class="bi bi-plus-lg me-1"></i> Tambah User
                </a>

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
                    <tbody>
                        @foreach($users as $u)
                        <tr style="border-color: #f0eeff;">
                            <td>
                                <span class="badge rounded-pill px-3"
                                      style="background: #EEEDFE; color: #534AB7; font-weight: 600;">
                                    #{{ $u->id }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width:32px; height:32px; background:#EEEDFE; color:#6495ED; font-size:11px; font-weight:700;">
                                        {{ strtoupper(substr($u->name, 0, 2)) }}
                                    </div>
                                    {{ $u->name }}
                                </div>
                            </td>
                            <td class="text-muted">{{ $u->opd }}</td>
                            <td class="text-muted">{{ $u->email }}</td>
                            <td class="text-muted">{{ $u->phone_number }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('users.edit', $u) }}"
                                       class="btn btn-sm px-3"
                                       style="background: #FFD700; color: #534AB7; border-radius: 6px; font-size: 12px;">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('users.destroy', $u) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm px-3"
                                                style="background: #fff0f3; color: #A32D2D; border-radius: 6px; font-size: 12px;">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
