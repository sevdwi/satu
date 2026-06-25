@extends('layouts.head')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<!-- Navigation-->
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
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
 </nav> -->
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
        <a href="{{route('dashboard-admin')}}" class="active">
          <i class="bi bi-house"></i> Beranda
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bi bi-archive"></i> Arsip Inaktif
          <i class="bi bi-chevron-down nav-caret"></i>
        </a>
        <div class="dropdown-menu-custom">
          <a href="#"><i class="bi bi-plus-square"></i> Input Unit Pengolah Yg Ditata</a>
          <a href="#"><i class="bi bi-pencil-square"></i> Input Deskripsi Arsip</a>
          <div class="dropdown-divider-custom"></div>
          <a href="#"><i class="bi bi-list-ul"></i> Daftar Arsip Inaktif</a>
        </div>
      </li>
      <li>
        <a href="#">
          <i class="bi bi-trash3"></i> Arsip Musnah
          <i class="bi bi-chevron-down nav-caret"></i>
        </a>
        <div class="dropdown-menu-custom">
          <a href="#"><i class="bi bi-file-earmark-plus"></i> Daftar Usul Musnah</a>
          <div class="dropdown-divider-custom"></div>
          <a href="#"><i class="bi bi-list-check"></i> Daftar Musnah</a>
        </div>
      </li>
      <li>
        <a href="#">
          <i class="bi bi-building-lock"></i> Arsip Statis
          <i class="bi bi-chevron-down nav-caret"></i>
        </a>
        <div class="dropdown-menu-custom">
          <a href="#"><i class="bi bi-send"></i> Daftar Usul Serah</a>
          <div class="dropdown-divider-custom"></div>
          <a href="#"><i class="bi bi-archive-fill"></i> Daftar Arsip Statis</a>
        </div>
      </li>
      <li>
        <a href="{{route('master-kodes.index')}}">
          <i class="bi bi-building-lock"></i> Data Klasifikasi
        </a>
      </li>
      <li>
        <a href="{{route('users.index')}}">
          <i class="bi bi-building-lock"></i> Kelola User
        </a>
      </li>

    </ul>

    <!-- Account -->
    <div class="nav-account">
      <div class="account-avatar"><i class="bi bi-people-fill me-2" style="color: #6495ED;"></i></div>
      <div>
        <div class="account-name">{{ auth()->guard('admin')->user()->name }}</div>
        <div class="account-role">Akun yang digunakan</div>
      </div>
      <i class="bi bi-chevron-down" style="font-size:.6rem;color:var(--muted);margin-left:.2rem;"></i>
      <div class="account-dropdown">
        <a href="#"><i class="bi bi-person"></i> Profil Saya</a>
        <a href="#"><i class="bi bi-key"></i> Ubah Kata Sandi</a>
        <form action="{{ route('logout-admin') }}" method="POST">
            @csrf
            <button type="submit" class="logout btn px-4 btn-logout-red">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
      </div>
    </div>

    <button class="nav-mobile-toggle"><i class="bi bi-list"></i></button>
  </div>
</nav>

<div class="container mt-4">
    <div class="card-custom">
        <!-- Card Header -->
        <div class="card-top">
            <div class="card-top-left">
                <div class="card-icon"><i class="bi bi-archive"></i></div>
                <div>
                <div class="card-subtitle">Kelola seluruh data arsip</div>
                </div>
            </div>
            <!-- <a href="{{ route('arsip.create') }}" class="btn-add">
                <i class="bi bi-plus-lg"></i> Tambah Arsip
            </a> -->
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
                    <th>Unit</th>
                    <th>OPD id</th>
                    <th>instansi</th>
                    <th>Status</th>
                    <!-- <th>File</th> -->
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody id="tableBody">

                @forelse($data as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $item->opd->singkatan_uk.'-'.$item->opd->singkatan_instansi ?? '-' }}
                        </td>

                        <td>
                            {{ $item->opd->id }}
                        </td>

                        <td>
                            {{ $item->opd->instansi }}
                        </td>

                        <td>
                            <span class="badge bg-success">
                                {{ $item->status }}
                            </span>
                        </td>

                        <td>
                        @if(isset($item->opd->id))
                            <a href="{{ route('arsip.data-admin', $item->opd->id) }}"
                            class="btn btn-warning btn-sm mb-2">
                                Daftar Lengkap
                            </a>
                        @endif
                            <button class="btn btn-secondary btn-sm mb-2" disabled>Tidak Ada OPD</button>
                       

                        </td>

                    </tr>

                @empty

                    <!-- <tr>
                        <td colspan="11" class="text-center">
                            Data kosong
                        </td>
                    </tr> -->

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
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#arsipTable').DataTable({
            responsive: true,
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