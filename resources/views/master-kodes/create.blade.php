@extends('layouts.administrator')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="container mt-5">

    <h3 class="mb-4">Tambah Master Kode</h3>

    @if ($errors->any())
        <div class="alert alert-danger">

            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <form action="{{ route('master-kodes.store') }}"
          method="POST">

        @csrf

        <div class="mb-3">
            <label class="form-label">Kode</label>

            <input type="text"
                   name="kode"
                   class="form-control"
                   value="{{ old('kode') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama</label>

            <input type="text"
                   name="nama"
                   class="form-control"
                   value="{{ old('nama') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Parent</label>

            <select name="parent_id" class="form-select select2">

                <option value="">-- Pilih Parent --</option>

                @foreach($parents as $parent)

                    <option value="{{ $parent->id }}">

                        {{ $parent->nama }}

                    </option>

                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>

            <textarea name="keterangan"
                      class="form-control"
                      rows="4">{{ old('keterangan') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan
        </button>

        <a href="{{ route('master-kodes.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>
<!-- jQuery (WAJIB paling atas) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script> 
$(document).ready(function () {

    $('.select2').select2({
        placeholder: 'Cari parent...',
        allowClear: true,
        minimumInputLength: 3,
        ajax: {
            url: '/master-kodes/search',
            dataType: 'json',
            delay: 250,

            data: function (params) {
                console.log('Yang diketik:', params.term); // ✔️ INI LOG INPUT

                return {
                    q: params.term
                };
            },

            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.kode + ' - ' + item.nama
                        }
                    })
                };
            }
        }
    });  
});
</script>
@endsection