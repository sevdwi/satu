@extends('layouts.head')

@section('content')
<!-- <!DOCTYPE html>
<html>
<head>
    <title>Master Kode</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body> -->
<nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
    <div class="container px-5">
        <a class="navbar-brand" href="{{route('dashboard')}}"><span class="fw-bolder" style="color: #7944B8;">SATU</span> <img src="{{ asset('images/arsip.png') }}" width="40" class="mb-3"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                <li class="nav-item"><a class="btn px-4 btn-logout-green me-3" href="{{route('dashboard-admin')}}">Kembali</a></li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <!-- <button type="submit"
                                class="btn px-4"
                                style="color: #8B0000; border: 1.5px solid #AFA9EC; border-radius: 8px; font-size: 13px; background: transparent;">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button> -->
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div style="background: #f4f2ff;">
<div class="container mt-5" style="background: #f4f2ff; min-height: 100vh; padding: 2rem;">
    <div class="max-width: 900px; margin: 0 auto;">
        <div class="card shadow-sm" style="border-radius: 16px; border: 1px solid #e0dbff;">
            <div class="card-body p-4">
        
                {{-- Header --}}
                <h4 class="fw-semibold mb-4" style="color: #3C3489;">
                    <i class="bi bi-inboxes-fill me-2" style="color: #7F77DD;"></i>
                    Data Master Kode
                </h4>

                {{-- Tombol Tambah --}}
                <a href="{{ route('master-kodes.create') }}"
                    class="btn mb-4 px-4"
                    style="background: #534AB7; color: #fff; border-radius: 8px; font-size: 14px;">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Data
                </a>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Tabel --}}
                <table class="table align-middle" style="font-size: 14px;">

                    <thead style="background: #EEEDFE;">
                        <tr>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">No</th>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">Kode</th>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">Nama</th>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">Level</th>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">Parent</th>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">Is Parent</th>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">Keterangan</th>
                            <th style="color: #3C3489; font-size: 12px; text-transform: uppercase; letter-spacing: .04em;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($data as $item)
                            <tr style="border-color: #f0eeff;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->level }}</td>
                                <td>
                                    {{ $item->parent?->nama ?? '-' }}
                                </td>
                                <td>
                                    @if($item->is_parent)
                                        <span class="badge bg-success">YES</span>
                                    @else
                                        <span class="badge bg-secondary">NO</span>
                                    @endif
                                </td>

                                <td>{{ $item->keterangan }}</td>

                                <td>

                                    <a href="{{ route('master-kodes.edit', $item->id) }}"
                                    class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('master-kodes.destroy', $item->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus data?')">
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    Data kosong
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>
</div>

@endsection