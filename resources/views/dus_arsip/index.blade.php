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
        <div class="account-name">{{ auth()->user()->name }}</div>
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
        <h3>Data Dus Arsip</h3>

        <a href="{{ route('dus_arsip.create') }}" class="btn btn-primary">
            Tambah Data
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table id="dusarsipTable" class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>No</th>
                <th>Qrcode</th>
                <th>OPD</th>
                <th>Nomor RAK</th>
                <th>Nomor DUS</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @if($data)
                @foreach($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($item->qrcode)
                                <!-- Menampilkan gambar berdasarkan path di storage -->
                                <img src="{{ asset('storage/' . $item->qrcode) }}" alt="QR Code" width="50" height="50" class="img-thumbnail">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                        {{ $item->opd_induk->kode_instansi ?? '-' }} - {{ $item->opd->unit_kerja ?? '-' }}
                        </td> 
                        <td>
                            {{ $item->rak_arsip->nomor_rak ?? '-' }}
                        </td> 
                        <td>
                            {{ $item->nomor_dus ?? '-' }}
                        </td>  
                        <td>
                            <button type="button" 
                                    data-url="{{ route('dus_arsip.gen_qr', $item->id) }}" 
                                    title="Generate QR"
                                    class="btn btn-primary btn-sm btn-show-qr"> 
                                <i class="fa fa-qrcode"></i> 
                            </button>
                            </a> 
                            <a href="{{ route('dus_arsip.show', $item->id) }}" title="Detil Berkas"
                               class="btn btn-success btn-sm"> 
                                <i class="fa fa-eye"></i> 
                            </a> 
                            <a href="{{ route('dus_arsip.edit', $item->id) }}" title="Ubah Data"
                               class="btn btn-warning btn-sm"> 
                                <i class="fa fa-edit"></i> 
                            </a> 

                            <form action="{{ route('dus_arsip.destroy', $item->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus data?')">

                                    Hapus

                                </button>

                            </form>

                        </td> 
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">
                        Data kosong
                    </td>
                </tr>
            @endif

        </tbody>

    </table> 
    <!-- Modal QR Code -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">QR Code Dus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="qrModalBody">
                    <!-- Animasi loading saat JS sedang mengambil data -->
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Memuat QR Code...</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const qrModalElement = document.getElementById('qrModal');

    // Event listener bawaan Bootstrap saat modal benar-benar tertutup
    qrModalElement.addEventListener('hidden.bs.modal', function () {
        location.reload(); // Refresh halaman secara otomatis
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Ambil semua tombol dengan class btn-show-qr
        const qrButtons = document.querySelectorAll('.btn-show-qr');
        
        // 2. Inisialisasi Modal Bootstrap
        const qrModalElement = document.getElementById('qrModal');
        const qrModal = new bootstrap.Modal(qrModalElement);
        const qrModalBody = document.getElementById('qrModalBody');

        // 3. Looping ke setiap tombol
        qrButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Ambil URL dari atribut data-url
                const url = this.getAttribute('data-url');

                // Tampilkan modal dengan status loading
                qrModalBody.innerHTML = `
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted">Memuat QR Code...</p>
                `;
                qrModal.show();

                // Lakukan HTTP Request ke backend (Laravel)
                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal memuat data');
                        return response.json(); // Ubah ke JSON
                    })
                    .then(data => {
                        // Ambil isi HTML dari respons JSON
                        qrModalBody.innerHTML = data.html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        qrModalBody.innerHTML = '<div class="alert alert-danger">Gagal memuat QR Code.</div>';
                    });
            });
        });
    });
    </script>
<script>
    $(document).ready(function () {
        $('#dusarsipTable').DataTable({
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