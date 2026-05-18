@extends('layouts.administrator')

@section('content')
<!-- <!DOCTYPE html>
<html>
<head>
    <title>Master Kode</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body> -->

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Master Kode</h3>

        <a href="{{ route('master-kodes.create') }}" class="btn btn-primary">
            Tambah Data
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
                <th>Nama</th>
                <th>Level</th>
                <th>Parent</th>
                <th>Is Parent</th>
                <th>Keterangan</th>
                <th width="200">Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse($data as $item)
                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->kode }}</td>

                    <td>{{ $item->nama }}</td>

                    <td>{{ $item->level }}</td>

                    <td>
                        {{ $item->parent?->nama ?? '-' }}
                    </td>

                    <td>
                        @if($item->is_parent)
                            <span class="badge bg-success">YES</span>
                        @else
                            <span class="badge bg-secondary">NO</span>
                        @endif
                    </td>

                    <td>{{ $item->keterangan }}</td>

                    <td>

                        <a href="{{ route('master-kodes.edit', $item->id) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('master-kodes.destroy', $item->id) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus data?')">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        Data kosong
                    </td>
                </tr>
            @endforelse

        </tbody>

    </table>

</div>

@endsection