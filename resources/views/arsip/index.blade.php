@extends('layouts.administrator')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Data Arsip</h3>

        <a href="{{ route('arsip.create') }}" class="btn btn-primary">
            Tambah Arsip
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Judul</th>
                <th>OPD</th>
                <th>Status</th>
                <th>File</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse($data as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $item->masterKode->kode ?? '-' }}
                    </td>

                    <td>
                        {{ $item->judul }}
                    </td>

                    <td>
                        {{ $item->opd->nama ?? '-' }}
                    </td>

                    <td>
                        <span class="badge bg-success">
                            {{ $item->status }}
                        </span>
                    </td>

                    <td>
                        @if($item->file)

                            <a href="{{ asset('arsip/'.$item->file) }}"
                               target="_blank">

                                Lihat File

                            </a>

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

                <tr>
                    <td colspan="7" class="text-center">
                        Data kosong
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>
@endsection