@extends('layouts.administrator')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>

<div class="container mt-4">

    <h3>Tambah Rak Arsip</h3>

    <form action="{{ route('rak_arsip.update',$id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf 

        <div class="mb-3">
            <label>OPD</label>

            <select name="opd_id" class="form-control  select-opd">

                <option value="0">-- Pilih OPD --</option>
                <option value="{{ $data->opd_id }}" selected> 
                        {{ $data->opd->singkatan_uk }} - {{ $data->opd->singkatan_instansi }}
                </option>  

                

            </select>
        </div>

        <div class="mb-3">
            <label>Nomor Rak</label>

            <input type="text"
                   name="nomor_rak"
                   class="form-control"
                   value="{{$data->nomor_rak}}">
        </div>  

        <button class="btn btn-primary">
            Simpan
        </button>

        <a href="{{ route('rak_arsip.index') }}"
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
    | SELECT OPD
    |--------------------------------------------------------------------------
    */

    $('.select-opd').select2({

    placeholder: 'Cari OPD...',
    allowClear: true,
    minimumInputLength: 3,

    ajax: {

        url: "{{ route('opd.search') }}",

        type: 'GET',

        dataType: 'json',

        delay: 250,

        data: function (params) {

            return {
                q: params.term,
                _token: $('meta[name="csrf-token"]').attr('content')
            };
        },

        processResults: function (data) {

            return {
                results: $.map(data, function(item) {

                    return {
                        id: item.id,
                        text: item.unit_kerja + ' - ' + item.instansi
                    }

                })
            };
        },

        cache: true
    }

});

});
</script>
@endsection