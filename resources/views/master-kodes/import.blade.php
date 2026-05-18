@extends('layouts.administrator')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">

    <h3>Import Excel Master Kode</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <input type="file" name="file" class="form-control" required>
        </div>

        <button class="btn btn-primary">
            Import
        </button>
    </form>

</div>
@endsection
