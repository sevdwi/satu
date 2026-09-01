@extends('layouts.head')

@section('content')
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

<!-- newww -->

<div class="page-wrap">

  <!-- Breadcrumb -->
  <div class="breadcrumb-custom">
    <a href="#"><i class="bi bi-house"></i></a>
    <i class="bi bi-chevron-right"></i>
    <a href="#">Manajemen Sistem</a>
    <i class="bi bi-chevron-right"></i>
    <span class="current">Data Instansi</span>
  </div>
 
  <!-- Card -->
  <div class="card-custom">
 
    <!-- Card Header -->
    <div class="card-top">
      <div class="card-top-left">
        <div class="card-icon"><i class="bi bi-house-door-fill"></i></div>
        <div>
          <div class="card-title">List Instansi</div>
          <div class="card-subtitle">Kelola seluruh instansi pengolah sistem</div>
        </div>
      </div>
      <a href="{{ route('opd_induk.create') }}" class="btn-add">
        <i class="bi bi-plus-lg"></i> Tambah Instansi
      </a>
    </div>
 
    <!-- Toolbar -->
    <div class="toolbar">
      <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" class="search-input" id="searchInput"
               placeholder="Cari nama OPD…" oninput="filterRows()" />
      </div>
      <div class="toolbar-right">
        <div class="total-badge">
          <i class="bi bi-people" style="font-size:.72rem;"></i>
          <span id="totalCount">{{ $opd_induk->count() }}</span> instansi
        </div>
      </div>
    </div>
 
    <!-- Table -->
    <div class="table-wrap">
      <table class="tbl" id="userTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Kode</th>
            <th>Instansi</th>
            <th>Singkatan Instansi</th>
            <th>Aksi</th>
            <!-- <th>Nomor HP</th>
            <th>Peran</th>
            -->
          </tr>
        </thead>
        <tbody id="tableBody">
        @foreach($opd_induk as $u)
 
          <tr>
            <td><span class="id-badge">#{{ $u->id }}</span></td>
            <td>
              <div class="user-cell">
                <div class="user-avatar"><i class="bi bi-house-door-fill"></i></div>
                <div>
                  <div class="user-role">{{ $u->kode_instansi }}</div>
                  <!-- <div class="user-name">{{ $u->Instansi }}</div> -->
                </div>
              </div>
            </td>
            <td class="cell-muted">{{ $u->instansi ?? 'Tidak Ada OPD'}}</td>
            <td class="cell-muted">{{ $u->singkatan_instansi ?? 'Tidak Ada OPD'}}</td>
            <td>
              <div class="actions">
              <a href="{{ route('opd_admin.index', $u->id) }}" class="btn-update"><i class="bi bi-caret-down-fill"></i> Bidang </a>
                <a href="{{ route('opd_induk.edit', $u->id) }}" class="btn-edit"><i class="bi bi-pencil"></i> Edit</a>
                <form action="{{ route('opd_induk.destroy', $u->id) }}" method="POST" class="d-inline" id="deleteForm-{{ $u->id }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-hapus" onclick="openDelete(event, 'admin', 'deleteForm-{{ $u->id }}')">
                      <i class="bi bi-trash3"></i> Hapus
                  </button>
              </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
 
      <!-- Empty State (hidden by default) -->
      <div class="empty-state" id="emptyState" style="display:none;">
        <div class="empty-icon"><i class="bi bi-search"></i></div>
        <p style="font-weight:600;color:var(--text);margin-bottom:.25rem;">Tidak ada hasil</p>
        <p style="font-size:.8rem;color:var(--muted);">Coba ubah kata kunci atau filter pencarian.</p>
      </div>
    </div>
 
    <!-- Card Footer / Pagination -->
    <div class="card-footer-custom">
      <span class="pagination-info">Menampilkan <strong id="shownCount">1–4</strong> dari <strong>4</strong> pengguna</span>
      <div class="pagination-btns">
        <button class="pg-btn" disabled><i class="bi bi-chevron-left"></i></button>
        <button class="pg-btn active">1</button>
        <button class="pg-btn" disabled><i class="bi bi-chevron-right"></i></button>
      </div>
    </div>
 
  </div><!-- /card -->
</div><!-- /page-wrap -->
 
 
<!-- Modal Hapus -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal-box">
    <div class="modal-del-icon"><i class="bi bi-trash3"></i></div>
    <h6>Hapus Pengguna?</h6>
    <p id="deleteModalMsg">Pengguna ini akan dihapus secara permanen dan tidak dapat dipulihkan.</p>
    <div class="modal-actions">
      <button class="btn-modal-cancel" onclick="closeDelete()">Batal</button>
      <button class="btn-modal-del" id="confirmDeleteBtn">Hapus</button>
    </div>
  </div>
</div>
 
<!-- Toast Container -->
<div class="toast-wrap" id="toastWrap"></div>
 
<script>
  /* ── Search + Filter ───────────────────────────── */
  function filterRows() {
    const q    = document.getElementById('searchInput').value.toLowerCase();
    const role = document.querySelector('.filter-select').value.toLowerCase();
    const rows = document.querySelectorAll('#tableBody tr');
    let visible = 0;
 
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      const r    = row.dataset.role || '';
      const match = text.includes(q) && (role === '' || r === role);
      row.style.display = match ? '' : 'none';
      if (match) visible++;
    });
 
    document.getElementById('emptyState').style.display = visible === 0 ? 'block' : 'none';
    document.getElementById('totalCount').textContent  = visible;
    document.getElementById('shownCount').textContent  = visible === 0 ? '0' : `1–${visible}`;
  }
 
  /* ── Delete Modal ──────────────────────────────── */
  let pendingName = '';
  let pendingFormId = ''; // Variabel baru untuk menyimpan ID formulir

  function openDelete(event, name, formId) {
    // Blokir pengiriman formulir otomatis
    event.preventDefault(); 

    pendingName = name;
    pendingFormId = formId; 

    document.getElementById('deleteModalMsg').textContent =
      `Pengguna "${name}" akan dihapus secara permanen dan tidak dapat dipulihkan.`;
    document.getElementById('deleteModal').classList.add('show');
    
    // Kaitkan aksi konfirmasi ke fungsi doDelete
    document.getElementById('confirmDeleteBtn').onclick = doDelete;
  }

  function closeDelete() {
    document.getElementById('deleteModal').classList.remove('show');
  }

  function doDelete() {
    closeDelete();
    
    // Kirimkan formulir spesifik ke server
    document.getElementById(pendingFormId).submit();
  }

  // Menutup modal saat pengguna menekan area luar
  document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDelete();
  });
 
  /* ── Toast ─────────────────────────────────────── */
  function showToast(msg, type = 'success') {
    const colors = { success: 'var(--blue-deep)', danger: '#DC2626' };
    const icons  = { success: 'bi-check-circle-fill', danger: 'bi-x-circle-fill' };
    const wrap = document.getElementById('toastWrap');
    const t = document.createElement('div');
    t.className = 'toast-item';
    t.style.borderLeftColor = colors[type];
    t.innerHTML = `<i class="bi ${icons[type]}" style="color:${colors[type]};"></i> ${msg}`;
    wrap.appendChild(t);
    setTimeout(() => {
      t.style.transition = 'opacity .3s, transform .3s';
      t.style.opacity = '0'; t.style.transform = 'translateX(16px)';
      setTimeout(() => t.remove(), 320);
    }, 3000);
  }
</script>
@endsection
