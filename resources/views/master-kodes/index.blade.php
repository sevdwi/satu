@extends('layouts.head')

@section('content')
<!-- <!DOCTYPE html>
<html>
<head>
    <title>Master Kode</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body> -->
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
      <li>
      <a href="{{route('master-kodes.import')}}" class="active">
          <i class="bi bi-house"></i> Import
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

<div class="page-wrap">

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
 
    <div class="toolbar">
      <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" class="search-input" id="searchInput"
               placeholder="Cari kode, nama, atau keterangan..." oninput="filterRows()" />
      </div>
      <div class="toolbar-right">
        <select class="filter-select" id="levelFilter" onchange="filterRows()">
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
 
    <div class="table-wrap">
      <table class="tbl" id="dataTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Level</th>
            <th>Parent</th>
            <th>Is Parent</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @forelse($data as $item)
          <tr data-name="{{ strtolower($item->kode . ' ' . $item->nama . ' ' . $item->keterangan) }}" data-level="{{ $item->level }}">
            <td><span class="id-badge">#{{ $loop->iteration }}</span></td>
            <td><strong style="color: var(--primary);">{{ $item->kode }}</strong></td>
            <td>
              <div class="user-cell">
                <div class="user-name">{{ $item->nama }}</div>
              </div>
            </td>
            <td><span class="role-badge" style="background: #e0dbff; color: #3C3489;">Level {{ $item->level }}</span></td>
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
          @empty
          <tr id="emptyRowDefault">
            <td colspan="8" class="text-center" style="padding: 2rem; color: var(--muted);">
              Data master kode masih kosong.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
 
      <div class="empty-state" id="emptyState" style="display:none; text-align: center; padding: 3rem 1rem;">
        <div class="empty-icon" style="font-size: 2rem; color: var(--muted);"><i class="bi bi-search"></i></div>
        <p style="font-weight:600;color:var(--text);margin-bottom:.25rem;">Tidak ada hasil</p>
        <p style="font-size:.8rem;color:var(--muted);">Coba ubah kata kunci atau filter pencarian Anda.</p>
      </div>
    </div>
 
    <div class="card-footer-custom">
      <span class="pagination-info">Menampilkan <strong id="shownCount">{{ $data->count() > 0 ? '1–'.$data->count() : '0' }}</strong> dari <strong>{{ $data->count() }}</strong> data</span>
      <div class="pagination-btns">
        <button class="pg-btn" disabled><i class="bi bi-chevron-left"></i></button>
        <button class="pg-btn active">1</button>
        <button class="pg-btn" disabled><i class="bi bi-chevron-right"></i></button>
      </div>
    </div>
 
  </div></div><div class="modal-overlay" id="deleteModal" style="display: none;">
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

@endsection