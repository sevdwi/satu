@extends('layouts.administrator')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>

<div class="container mt-4">

    <h3>Tambah Arsip</h3>

    <form action="{{ route('arsip.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="mb-3">
            <label>Kode Arsip</label>

            <select name="master_kode_id" class="form-control  select-master-kode">

                <option value="">-- Pilih Kode --</option>

                @foreach($masterKodes as $kode)

                    <option value="{{ $kode->id }}">

                        {{ $kode->kode }} - {{ $kode->nama }}

                    </option>

                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label>OPD</label>

            <select name="opd_id" class="form-control  select-opd">

                <option value="">-- Pilih OPD --</option>

                @foreach($opds as $opd)

                    <option value="{{ $opd->id }}">

                        {{ $opd->nama }}

                    </option>

                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label>Judul</label>

            <input type="text"
                   name="judul"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Nomor</label>

            <input type="text"
                   name="nomor"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Tanggal</label>

            <input type="date"
                   name="tanggal"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Retensi</label>

            <input type="text"
                   name="retensi"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>

            <select name="status" class="form-control">

                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>

            </select>
        </div>

        <div class="mb-3">
            <label>Pemusnahan</label>

            <input type="date"
                   name="pemusnahan"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>

            <textarea name="deskripsi"
                      class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>File</label>

            <input type="file"
                   name="file"
                   class="form-control">
        </div>

        <button class="btn btn-primary">
            Simpan
        </button>

        <a href="{{ route('arsip.index') }}"
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

    /*
    |--------------------------------------------------------------------------
    | SELECT MASTER KODE
    |--------------------------------------------------------------------------
    */

    $('.select-master-kode').select2({

        placeholder: 'Cari kode arsip...',
        allowClear: true,
        minimumInputLength: 3,

        ajax: {

            url: '/master-kodes/search',

            dataType: 'json',

            delay: 250,

            data: function (params) {

                console.log('Kode diketik:', params.term);

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


    /*
    |--------------------------------------------------------------------------
    | SELECT OPD
    |--------------------------------------------------------------------------
    */

    $('.select-opd').select2({

        placeholder: 'Cari OPD...',
        allowClear: true,
        minimumInputLength: 3,

        ajax: {

            url: '/opd/search',

            dataType: 'json',

            delay: 250,

            data: function (params) {

                console.log('OPD diketik:', params.term);

                return {
                    q: params.term
                };
            },

            processResults: function (data) {

                return {
                    results: data.map(function (item) {

                        return {
                            id: item.id,
                            text: item.nama
                        }

                    })
                };
            }
        }
    });

});
</script>
@endsection