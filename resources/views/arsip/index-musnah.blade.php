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


<div class="container mt-4 mb-5">
    <div class="card-custom">
        <!-- Card Header -->
        <div class="card-top">
            <div class="card-top-left">
                <div class="card-icon"><i class="bi bi-archive"></i></div>
                <div>
                <div class="card-title">Data Arsip Musnah {{ auth()->user()->opd?->unit_kerja }}</div>
                <div class="card-subtitle">Kelola seluruh data arsip musnah</div>
                </div>
            </div>
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
                    <th>Tanggal Musnah </th>
                    <th>After</th>
                    <th>Sisa</th>
                    <th>Nomor Definitif</th>
                    <th>Kode</th>
                    <th>Tanggal Arsip</th>
                    <th>Redaksi</th>
                    <th>Deskripsi</th>
                    <th>Unit</th>
                    <th>Nomor RAK</th>
                    <th>Nomor Dus</th>
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

                        <td>
                            {{ $item->tanggal_musnah ?? '-' }}
                        </td>

                        <td>
                            {{ $item->pemusnahan ?? '-' }}
                        </td>

                        <td>
                        <?php
                            // 1. Atur zona waktu ke Asia/Jakarta (WIB)
                            // Gunakan 'Asia/Makassar' untuk WITA atau 'Asia/Jayapura' untuk WIT
                            $timezone = new DateTimeZone('Asia/Jakarta');

                            // Ambil tanggal dari database
                            $tanggal_musnah_db = $item->tanggal_musnah; 
                            $tanggal_musnah = new DateTime($tanggal_musnah_db, $timezone);

                            // 2. Buat variabel hari ini dengan format waktu Indonesia
                            $hari_ini = new DateTime('now', $timezone); 

                            // Hitung selisih objek tanggal
                            $selisih = $hari_ini->diff($tanggal_musnah);

                            // Tampilkan tanda minus (-) jika sudah lewat
                            $sisa_hari = $selisih->format('%r%a'); 

                            echo "Sisa waktu: " . $sisa_hari . " hari";

                        ?>

                        
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
                            {{ $item->tanggal ?? '-'}}
                        </td>


                        <td>
                            {{ $item->judul ?? '-' }}
                        </td>

                        <td>
                            {{ $item->deskripsi ?? '-' }}
                        </td>

                        <!-- OPD (Sudah Diperbaiki & Aman dari null) -->
                        <td>
                            @if($item->opd)
                                {{ $item->opd->singkatan_uk ?? '-'}} - {{ $item->opd->singkatan_instansi ?? '-'}}
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

                        <td>

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

                @endforelse

            </tbody>

        </table> 
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Simpan inisialisasi DataTables ke dalam variabel 't'
        var t = $('#arsipTable').DataTable({
            scrollX: true,
            scrollY: "500px", /* Tentukan batas tinggi tabel */
            scrollCollapse: true,
            responsive: false, /* Matikan fungsi responsive untuk mengizinkan gulir horizontal */
            pageLength: 10,        
            // Nonaktifkan fitur pengurutan pada kolom No (indeks 0)
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: 0
                }
            ],
            
            // Pengurutan awal (indeks 1 = Master Kode, indeks 7 = Tanggal)
            order: [[1, 'asc']], 
            
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

        // Hitung ulang nomor urut pada kolom indeks 0 setiap kali tabel diurutkan atau dicari
        t.on('order.dt search.dt', function () {
            let i = 1;
            t.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });
        }).draw();
    });
</script>
@endsection