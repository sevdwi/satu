@extends('layouts.administrator')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>

<div class="container mt-4">

    <h3>Tambah Arsip</h3>

    <form action="{{ route('pemusnahan_arsip.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf 

        <div class="mb-3">
            <label>Arsip</label>

            <select name="id_arsip" class="form-control  select-arsip">
                <option value="0">-- Pilih arsip --</option> 
                <?php 
                    if($arsip){
                        foreach($arsip as $dat){?>
                            <option value="{{$dat->id}}">Tahun {{substr($dat->tanggal,0,4)}} Nomor : {{$dat->nomor}}, {{$dat->judul}}</option>
                        <?php } 
                    }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Pemusnahan</label>

            <input type="date"
                   name="tanggal_pemusnahan"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>No BA Pemusnahan</label>

            <input type="text"
                   name="no_ba"
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
            url: "{{ route('master-kodes.search') }}", 

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

    $('.select-arsip').select2({

    placeholder: 'Cari Arsip...',
    allowClear: true,
    minimumInputLength: 3,

    ajax: {

        url: "{{ route('arsip.search') }}",

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
                        text: 'nomor:'+item.nomor+' Tahun '+item.tanggal.substring(0, 4)+' tentang:'+item.judul + ' - ' + (item.opd?.instansi || '-')
                    };
                })
            };
        },

        cache: true
    }

});

});
</script>
@endsection