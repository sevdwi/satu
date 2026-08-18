@extends('layouts.head_customer')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

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
      <!-- <li>
      <a href="{{route('dashboard')}}" class="active">
          <i class="bi bi-house"></i> Beranda
        </a>
      </li> -->
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


<div class="container mt-4 mb-5">
    <div class="card-custom">
        <!-- Card Header -->
        <div class="card-top">
            <div class="card-top-left">
                <div class="card-icon"><i class="bi bi-archive"></i></div>
                <div>
                <div class="card-title">Data Arsip tahap {{ session('periodes') }} - {{ auth()->user()->opd?->unit_kerja }}</div>
                <div class="card-subtitle">Kelola seluruh data arsip</div>
                </div>
            </div>
            <a href="{{ route('arsip.manuver') }}" class="btn-manuver">
                <i class="bi bi-list-check"></i> Manuver
            </a>

            <a href="{{ route('arsip.create') }}" class="btn-add">
                <i class="bi bi-plus-lg"></i> Tambah Arsip
            </a>
        </div>


        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    
        <!-- Table -->
        <div class="table-wrap mt-2 p-2 ">
        <table id="arsipTable" class="tbl table table-bordered table-striped">

            <thead>
                <tr>
                    <th>No</th>
                    <!-- <th>Master Kode ID </th> -->
                    <th>Nomor Sementara</th>
                    <th>Nomor Definitif</th>
                    <th>Kode</th>
                    <th>Redaksi</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Unit</th>
                    <th>Nomor RAK</th>
                    <th>Nomor Dus</th>
                    <th>Korektor</th>
                    <th>Status</th>
                    <!-- <th>File</th> -->
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody id="tableBody">

                @forelse($data as $item)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <!-- <td>
                            {{ $item->master_kode_id }}
                        </td> -->

                        <td>
                            {{ $item->id }} - {{ auth()->user()->id }} 
                        </td>

                        <td>
                            {{ $item->nomor?? '-' }} - 
                            <a href="{{ route('arsip.edit-nomor', $item->id) }}"
                            class="btn btn-warning btn-sm mb-2">
                                Edit nomor
                            </a>

                        </td>

                        <!-- Kode Master (Aman) -->
                        <td>
                            {{ $item->masterKode?->kode ?? '-' }} - {{ $item->masterKode?->nama ?? '-' }}
                        </td>

                        <td>
                            {{ $item->judul }}
                        </td>

                        <td>
                            {{ $item->deskripsi }}
                        </td>

                        <td>
                            {{ $item->tanggal }}
                        </td>


                        <!-- OPD (Sudah Diperbaiki & Aman dari null) -->
                        <td>
                            @if($item->opd)
                                {{ $item->opd->singkatan_uk }} - {{ $item->opd->singkatan_instansi }}
                            @else
                                -
                            @endif
                        </td>

                        <!-- Rak (Aman) -->
                        <td>
                            {{ $item->rak_arsip->nomor_rak ?? '-' }}
                        </td>

                        <!-- Dus (Aman) -->
                        <td>
                            {{ $item->dus_arsip->nomor_dus ?? '-' }}
                        </td>

                        <td>
                            {{ $item->korektor ?? '-' }}
                        </td>
                        
                        <td>
                            @switch($item->status)
                                @case('verify')
                                    <span class="badge bg-success">Verify</span>
                                    @break
                                @case('input')
                                    <span class="badge bg-primary">Input</span>
                                    @break
                                @case('draft')
                                    <span class="badge bg-warning text-dark">Draft</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $item->status }}</span>
                            @endswitch
                        </td>

                        <!-- <td>
                            @if($item->file)

                                <button class="btn btn-info btn-sm form-control btn-view-pdf"
                                        data-bs-toggle="modal"
                                        data-bs-target="#pdfModal"
                                        data-file="{{ asset('arsip/'.$item->file) }}">
                                    <i class="fa fa-book"></i> Lihat File
                                </button>

                                <button class="btn btn-primary btn-sm form-control btn-upload"
                                        data-bs-toggle="modal"
                                        data-bs-target="#uploadModal"
                                        data-id="{{ $item->id }}">
                                    <i class="fa fa-upload"></i>
                                </button>

                            @else

                                <button class="btn btn-primary btn-sm form-control btn-upload"
                                        data-bs-toggle="modal"
                                        data-bs-target="#uploadModal"
                                        data-id="{{ $item->id }}">
                                    <i class="fa fa-upload"></i>
                                </button>

                            @endif
                        </td>  -->

                        <td>

                            <a href="{{ route('arsip.edit', $item->id) }}"
                            class="btn btn-warning btn-sm mb-2">
                                Edit
                            </a>

                            <a href="{{ route('arsip.kartu', $item->id) }}"
                            class="btn btn-warning btn-sm mb-2">
                                Kartu
                            </a>


                            <form action="{{ route('arsip.destroy', $item->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm mb-2"
                                        onclick="return confirm('Hapus data?')">

                                    Hapus

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="11" class="text-center">
                            Data kosong
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table> 
        </div>
        <div class="modal fade" id="pdfModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Preview File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-0" style="height: 80vh;">
                        <iframe id="pdfFrame"
                                src=""
                                width="100%"
                                height="100%"
                                style="border:none;">
                        </iframe>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="uploadModal" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('arsip.uploads') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" id="upload_id">

                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Upload Dokumen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input type="file" name="file" class="form-control" required>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Upload</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function () {
        $('#arsipTable').DataTable({
            scrollX: true,
            scrollY: "500px", /* Tentukan batas tinggi tabel */
            scrollCollapse: true,
            responsive: false, /* Matikan fungsi responsive untuk mengizinkan gulir horizontal */
            pageLength: 10,
            ordering: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "→",
                    previous: "←"
                }
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function () {

    // OPEN PDF
    document.querySelectorAll('.btn-view-pdf').forEach(btn => {
        btn.addEventListener('click', function () {

            let file = this.dataset.file;

            document.getElementById('pdfFrame').src = file;

        });
    });

    // OPEN UPLOAD
    document.querySelectorAll('.btn-upload').forEach(btn => {
        btn.addEventListener('click', function () {

            let id = this.dataset.id;

            document.getElementById('upload_id').value = id;

        });
    });

    // CLEAN IFRAME
    document.getElementById('pdfModal')
        .addEventListener('hidden.bs.modal', function () {

            document.getElementById('pdfFrame').src = '';

        });

});
</script>
@endsection