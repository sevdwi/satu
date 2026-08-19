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
        <a href="{{route('arsip.home')}}" class="active">
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
                <div class="card-title">Data Arsip {{ auth()->user()->opd?->unit_kerja }}</div>
                <div class="card-subtitle">Kelola seluruh data arsip</div>
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
                    <th>Master Kode ID </th>
                    <th>Nomor Sementara</th>
                    <th>Nomor Definitif</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Redaksi</th>
                    <th>Deskripsi</th>
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

                        <td>
                            {{ $item->master_kode_id }}
                        </td>

                        <td>
                            {{ $item->id }} - {{ auth()->user()->id }} 
                        </td>

                        <!-- <td>
                            {{ $item->nomor?? '-' }} - 
                            <a href="{{ route('arsip.edit-nomor', $item->id) }}"
                            class="btn btn-warning btn-sm mb-2">
                                Edit nomor
                            </a>

                        </td> -->
                        <!-- Kolom Nomor Definitif -->
                        <td>
                            <input type="number" name="nomor[{{ $item->id }}]" class="form-control input-nomor" value="{{ $item->nomor }}">
                        </td>

                        <!-- Kode Master (Aman) -->
                        <td>
                            {{ $item->masterKode?->kode ?? '-' }} - {{ $item->masterKode?->nama ?? '-' }}
                        </td>

                        <td>
                            {{ $item->tanggal }}
                        </td>


                        <td>
                            {{ $item->judul }}
                        </td>

                        <td>
                            {{ $item->deskripsi }}
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

                        <td>

                            <a href="{{ route('arsip.edit', $item->id) }}"
                            class="btn btn-warning btn-sm mb-2">
                                Edit
                            </a>

                            <a href="{{ route('arsip.kartu', $item->id) }}"
                            class="btn btn-warning btn-sm mb-2">
                                Kartu
                            </a>
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

        <!-- Tombol Pemicu di luar tabel -->
        <div class="p-3 text-end">
            <button type="button" id="btnSimpanMassal" class="btn btn-success px-4">
                Simpan Perubahan Nomor
            </button>
        </div>

        <!-- Form Tersembunyi Khusus Proses Simpan -->
        <form id="formSimpanNomor" action="{{ route('arsip.nomor-definitif') }}" method="POST" class="d-none">
            @csrf
            <!-- JavaScript akan menyuntikkan data ke sini -->
        </form>

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
            order: [[1, 'asc'], [5, 'asc']], 
            
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

            // Event listener untuk pengurutan dan pencarian
            t.on('order.dt search.dt', function () {
            // Hitung ulang teks pada kolom No (Indeks 0)
            let i = 1;
            t.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });

            // Isi otomatis input pada kolom Nomor Definitif (Indeks 3)
            let j = 1;
            t.cells(null, 3, { search: 'applied', order: 'applied' }).every(function (cell) {
                $(this.node()).find('.input-nomor').val(j++);
            });
        }).draw();

        // Event listener untuk tombol simpan massal
        $('#btnSimpanMassal').on('click', function () {
            let btn = $(this);
            let form = $('#formSimpanNomor');
            
            // 1. Blokir tombol dan tampilkan animasi loading
            btn.prop('disabled', true);
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan Data...');

            // 2. Bersihkan sisa input dari proses sebelumnya jika ada
            form.find('.input-dinamis').remove();

            // 3. Ekstrak SEMUA elemen '.input-nomor' dari API DataTables
            t.$('.input-nomor').each(function () {
                
                // Salin setiap nilai ke dalam input tipe hidden
                $('<input>').attr({
                    type: 'hidden',
                    name: $(this).attr('name'),
                    value: $(this).val(),
                    class: 'input-dinamis'
                }).appendTo(form);

            });

            // 4. Eksekusi pengiriman formulir tersembunyi ke server
            form.submit();
        });
    });
</script>
@endsection