@extends('layouts.administrator')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Data Arsip</h3>

        <a href="{{ route('pemusnahan_arsip.create') }}" class="btn btn-primary">
            Tambah Arsip
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table id="arsipTable" class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>OPD</th>
                <th>Korektor</th>
                <th>Status</th>
                <th>File</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>
@if($data)
        <tbody>

            @forelse($data as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td> 
                        {{ $item->masterKode->kode.'-'.$item->masterKode->nama?? '-' }}
                    </td>

                    <td>
                        {{ $item->judul }}
                    </td>

                    <td>
                        {{ $item->deskripsi }}
                    </td>

                    <td>
                        {{ $item->opd->singkatan_uk.'-'.$item->opd->singkatan_instansi ?? '-' }}
                    </td>

                    <td>
                        {{ $item->korektor }}
                    </td>

                    <td>
                        <span class="badge bg-success">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>
                        @if($item->file)
                             <button class="btn btn-info btn-sm form-control"
                                    data-bs-toggle="modal"
                                    data-bs-target="#pdfModal{{ $item->id }}"> <i class="fa fa-book"></i>
                                Lihat File
                            </button>
                            <!-- <a href="{{ asset('arsip/'.$item->file) }}" target="_blank">
                                Lihat File
                            </a> -->
                            <button class="btn btn-primary btn-sm form-control" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#uploadModal{{ $item->id }}">
                                <i class="fa fa-upload"></i>
                            </button>
                        @else
                            <button class="btn btn-primary btn-sm form-control"
                                    data-bs-toggle="modal"
                                    data-bs-target="#uploadModal{{ $item->id }}">
                                <i class="fa fa-upload"></i>
                            </button>
                        @endif
                    </td>

                    <td>

                        <a href="{{ route('arsip.edit', $item->id) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form action="{{ route('arsip.destroy', $item->id) }}"
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

            @empty

            @endforelse

        </tbody>
@endif
    </table> 
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
</script>
@endsection