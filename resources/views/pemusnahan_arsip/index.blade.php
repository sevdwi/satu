@extends('layouts.administrator')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Data Histori Pemusnahan Arsip</h3>

        <a href="{{ route('pemusnahan_arsip.create') }}" class="btn btn-primary">
            Musnahkan Arsip
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
                <th width="180" style="display: block;">Aksi</th>
                <th>No BA</th>
                <th>No Berkas</th>
                <th>Kode</th>
                <th>Judul</th> 
                <th>OPD</th> 
                <th>Status</th>
                <th>File BA</th>
                <th width="180" style="display: none;">Aksi</th>
            </tr>
        </thead>
@if($data)
        <tbody>

            @forelse($data as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        <a href="{{ route('pemusnahan_arsip.show',$item->id) }}" class="btn btn-primary form-control btn-view-data" title="Lihat Detil Data">
                            <i class="fa fa-book"></i>
                        </a>
                    </td>

                    <td>
                        {{ $item->no_ba }}
                    </td> 

                    <td>
                        {{ $item->nomor }}
                    </td> 

                    <td> 
                        {{ $item->masterKode->kode.'-'.$item->masterKode->nama?? '-' }}
                    </td>

                    <td>
                        {{ $item->judul }}
                    </td> 

                    <td>
                        {{ $item->opd->singkatan_uk.'-'.$item->opd->singkatan_instansi ?? '-' }}
                    </td> 

                    <td>
                        <span class="badge bg-danger">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>
                        @if($item->file_ba)
                        <button class="btn btn-info btn-sm form-control btn-view-pdf"
                                data-bs-toggle="modal"
                                data-bs-target="#pdfModal"
                                data-file="{{ asset('storage/'.$item->file_ba) }}">
                            <i class="fa fa-book"></i>
                            Lihat File BA
                        </button>

                            <button class="btn btn-primary btn-sm form-control mt-1 btn-upload"
                                    data-bs-toggle="modal"
                                    data-bs-target="#uploadModal"
                                    data-id="{{ $item->id }}">
                                <i class="fa fa-upload"></i>
                            </button>
                        @else
                            <button class="btn btn-primary btn-sm form-control btn-upload"
                                    data-bs-toggle="modal"
                                    data-bs-target="#uploadModal"
                                    data-id="{{ $item->id }}">
                                <i class="fa fa-upload"></i>
                            </button>
                        @endif
                    </td> 

                    <td style="display:none;">

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
    <div class="modal fade" id="pdfModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Preview Berita Acara</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-0">
                    <iframe id="pdfFrame"
                            src=""
                            width="100%"
                            height="700px"
                            style="border:none;">
                    </iframe>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('pemusnahan_arsip.upload_ba') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <input type="hidden"
                           name="id"
                           id="upload_id">

                    <div class="modal-header">
                        <h5 class="modal-title">Upload Berita Acara</h5>
                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>File PDF</label>
                            <input type="file"
                                   name="file_ba"
                                   class="form-control"
                                   accept=".pdf"
                                   required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit"
                                class="btn btn-primary">
                            Upload
                        </button>
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
    document.addEventListener('DOMContentLoaded', function() {

        // Preview PDF
        document.querySelectorAll('.btn-view-pdf').forEach(btn => {
            btn.addEventListener('click', function() {

                let file = this.dataset.file;

                document.getElementById('pdfFrame').src = file;
            });
        });

        // Upload
        document.querySelectorAll('.btn-upload').forEach(btn => {
            btn.addEventListener('click', function() {

                let id = this.dataset.id;

                document.getElementById('upload_id').value = id;
            });
        });

        // Bersihkan iframe saat modal ditutup
        document.getElementById('pdfModal')
            .addEventListener('hidden.bs.modal', function() {

                document.getElementById('pdfFrame').src = '';
            });
    });
</script>
@endsection