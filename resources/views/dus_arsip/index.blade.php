@extends('layouts.administrator')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<div class="container mt-4">

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
                            {{ $item->opd->singkatan_uk.'-'.$item->opd->singkatan_instansi ?? '-' }}
                        </td> 
                        <td>
                            {{ $item->nomor_rak ?? '-' }}
                        </td> 
                        <td>
                            {{ $item->nomor_dus ?? '-' }}
                        </td> 
                        <td>
                            <a href="{{ route('dus_arsip.edit', $item->id) }}" title="Ubah Data"
                               class="btn btn-warning btn-sm"> 
                                <i class="fa fa-edit"></i> 
                            </a> 
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
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

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