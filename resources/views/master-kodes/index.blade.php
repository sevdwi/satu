@extends('layouts.head')

@section('content')
<!-- <!DOCTYPE html>
<html>
<head>
    <title>Master Kode</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body> -->
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
        <a href="{{route('dashboard-admin')}}" class="active">
          <i class="bi bi-house"></i> Kembali
        </a>

      </li>
      <!-- <li>
      <a href="{{route('master-kodes.import')}}" class="active">
          <i class="bi bi-house"></i> Import
        </a>
      </li> -->
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

<div >
<div class="breadcrumb-custom">
  <a href="#"><i class="bi bi-house"></i></a>
  <i class="bi bi-chevron-right"></i>
  <a href="#">Manajemen Sistem</a>
  <i class="bi bi-chevron-right"></i>
  <span class="current">Data Master Kode</span>
</div>

<div class="card-custom">
  <div class="card-top">
    <div class="card-top-left">
      <div class="card-icon"><i class="bi bi-inboxes-fill"></i></div>
      <div>
        <div class="card-title">Data Master Kode</div>
        <div class="card-subtitle">Kelola klasifikasi dan struktur kode sistem</div>
      </div>
    </div>
    <a href="{{ route('master-kodes.create') }}" class="btn-add">
      <i class="bi bi-plus-lg"></i> Tambah Data
    </a>
  </div>

  @if(session('success'))
    <div class="alert-custom-success">
      <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
  @endif

  <!-- Toolbar Kustom -->
  <div class="toolbar">
    <div class="search-wrap">
      <i class="bi bi-search"></i>
      <!-- Hapus oninput="filterRows()" -->
      <input type="text" class="search-input" id="searchInput" placeholder="Cari kode, nama, atau keterangan..." />
    </div>
    <div class="toolbar-right">
      <!-- Hapus onchange="filterRows()" -->
      <select class="filter-select" id="levelFilter">
        <option value="">Semua Level</option>
        <option value="1">Level 1</option>
        <option value="2">Level 2</option>
        <option value="3">Level 3</option>
        <option value="4">Level 4</option>
      </select>
      <div class="total-badge">
        <i class="bi bi-inboxes" style="font-size:.72rem;"></i>
        <span id="totalCount">{{ $data->count() }}</span> data
      </div>
    </div>
  </div>

  <!-- Tabel Utama -->
  <div class="table-wrap mt-3">
    <table class="tbl table table-bordered table-striped" id="dataTable" style="width:100%">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode</th>
          <th>Nama</th>
          <th>Level</th>
          <th>Parent</th>
          <th>Is Parent</th>
          <th>Keterangan</th>
          <th width="150">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><strong style="color: var(--primary);">{{ $item->kode }}</strong></td>
          <td>
            <div class="user-cell">
              <div class="user-name">{{ $item->nama }}</div>
            </div>
          </td>
          <td>
            <span class="role-badge" style="background: #e0dbff; color: #3C3489;">Level {{ $item->level }}</span>
          </td>
          <td class="cell-muted">{{ $item->parent?->nama ?? '-' }}</td>
          <td>
            @if($item->is_parent)
              <span class="role-badge" style="background: #d1fae5; color: #065f46;"><i class="bi bi-check-circle-fill" style="font-size:.55rem;"></i> YES</span>
            @else
              <span class="role-badge" style="background: #f3f4f6; color: #4b5563;"><i class="bi bi-x-circle-fill" style="font-size:.55rem;"></i> NO</span>
            @endif
          </td>
          <td class="cell-muted">{{ $item->keterangan }}</td>
          <td>
            <div class="actions">
              <a href="{{ route('master-kodes.edit', $item->id) }}" class="btn-edit"><i class="bi bi-pencil"></i> Edit</a>
              <form action="{{ route('master-kodes.destroy', $item->id) }}" method="POST" class="d-inline" id="form-delete-{{ $item->id }}">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn-hapus" onclick="openDelete('{{ $item->id }}', '{{ $item->nama }}')">
                    <i class="bi bi-trash3"></i> Hapus
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

<!-- Modal Hapus -->
<div class="modal-overlay" id="deleteModal" style="display: none;">
  <div class="modal-box">
    <div class="modal-del-icon"><i class="bi bi-trash3"></i></div>
    <h6>Hapus Data?</h6>
    <p id="deleteModalMsg">Data ini akan dihapus secara permanen dan tidak dapat dipulihkan.</p>
    <div class="modal-actions">
      <button class="btn-modal-cancel" onclick="closeDelete()">Batal</button>
      <button class="btn-modal-del" id="confirmDeleteBtn">Hapus</button>
    </div>
  </div>
</div>
</div>

<!-- Pastikan CDN jQuery dan DataTables sudah dimuat sebelumnya -->
<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script> -->

<script>
  $(document).ready(function() {
      // Inisialisasi DataTables
      var table = $('#dataTable').DataTable({
          scrollX: true,
          responsive: false,
          pageLength: 10,
          // Menyembunyikan input pencarian bawaan DataTables agar sesuai dengan UI kustom
          dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
               "<'row'<'col-sm-12'tr>>" +
               "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
          columnDefs: [
              {
                  searchable: false,
                  orderable: false,
                  targets: 0 // Nonaktifkan sort/search pada kolom No
              },
              {
                  orderable: false,
                  targets: 7 // Nonaktifkan sort pada kolom Aksi
              }
          ],
          language: {
              lengthMenu: "Tampilkan _MENU_ data",
              zeroRecords: "Data master kode masih kosong atau tidak ditemukan.",
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

      // Penomoran otomatis untuk kolom 'No' saat diurutkan atau difilter
      table.on('order.dt search.dt', function () {
          let i = 1;
          table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
              this.data(i++);
          });
      }).draw();

      // Hubungkan input pencarian kustom ke DataTables
      $('#searchInput').on('keyup', function() {
          table.search(this.value).draw();
      });

      // Hubungkan filter Level kustom ke DataTables (Kolom indeks 3)
      $('#levelFilter').on('change', function() {
          var val = $(this).val();
          if (val) {
              // Mencari string "Level X" menggunakan Regex secara presisi
              table.column(3).search('Level ' + val, true, false).draw();
          } else {
              // Hapus filter jika "Semua Level" dipilih
              table.column(3).search('').draw();
          }
      });
  });

  // Fungsi untuk Modal Hapus (Biarkan sesuai aslinya jika sudah berfungsi)
  let deleteFormId = null;
  function openDelete(id, nama) {
      deleteFormId = 'form-delete-' + id;
      document.getElementById('deleteModalMsg').innerText = "Apakah Anda yakin ingin menghapus data '" + nama + "'? Data ini tidak dapat dipulihkan.";
      document.getElementById('deleteModal').style.display = 'flex';
  }

  function closeDelete() {
      document.getElementById('deleteModal').style.display = 'none';
      deleteFormId = null;
  }

  document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
      if (deleteFormId) {
          document.getElementById(deleteFormId).submit();
      }
  });
</script>

@endsection