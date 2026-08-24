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

<div class="container mt-4 mb-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Data periode tahap Opd <span><h5>Jika belum ada silahkan buat periode dahulu</h5></span></h3>

        <a href="{{ route('periode.create') }}" class="btn btn-primary">
            Buat <br> Periode
        </a> 
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table id="periodeTable" class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>No</th>
                <th>Unit</th>
                <th>Tahun</th>
                <th>Tahap</th> 
                <th width="180">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($periodes as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <!-- {{ $item->opd->singkatan_uk.'-'.$item->opd->singkatan_instansi ?? '-' }} -->                             
                            {{ $item->opd->unit_kerja ?? '-' }} - {{ $item->opd->instansi ?? '-' }}

                        </td> 
                        <td>
                            {{ $item->tahun ?? '-' }}
                        </td> 
                        <td>
                            {{ $item->tahap ?? '-' }}
                        </td> 
                        <td>
                            <a href="{{ route('periode.edit', auth()->guard('web')->user()->opd_id) }}" title="Ubah Data Periode"
                               class="btn btn-warning btn-sm"> 
                               <i class="bi bi-pen"></i>
                               Ubah Periode
                            </a> 

                        </td> 
                    </tr>
                    @empty

            @endforelse
        </tbody>

    </table> 
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#periodeTable').DataTable({
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
</script>
@endsection