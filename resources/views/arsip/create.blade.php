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
<div class="row">
        <div class="col-md-6">
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

        <div class="col-md-6">
            <label>OPD</label>

            <select name="opd_id" class="form-control  select-opd">

                <option value="0">-- Pilih OPD --</option>

                

            </select>
        </div>

        <div class="col-md-6">
            <label>Korektor</label>

            <input type="text"
                   name="korektor"
                   class="form-control">
        </div>

        <div class="col-md-6">
            <label>Judul</label>

            <input type="text"
                   name="judul"
                   class="form-control">
        </div>

        <div class="col-md-6">
            <label>Nomor</label>

            <input type="text"
                   name="nomor"
                   class="form-control">
        </div>

        <div class="col-md-6">
            <label>Tanggal</label>

            <input type="date"
                   name="tanggal"
                   class="form-control">
        </div>

        <div class="col-md-6">
            <label>Retensi Aktif</label>
            <select name="retensi" class="form-control">
                <option value="0">pilih data</option>
                @for($a=1;$a<=10;$a++)
                <option value="{{$a}}">{{$a}} Tahun</option>
                @endfor
            </select>
        </div>

        <div class="col-md-6">
            <label>Retensi Inaktif</label>
            <select name="retensiinaktif" class="form-control">
                <option value="0">pilih data</option>
                @for($a=1;$a<=10;$a++)
                <option value="{{$a}}">{{$a}} Tahun</option>
                @endfor
            </select>
        </div>

        <div class="col-md-6">
            <label>Status</label>

            <select name="status" class="form-control">

                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>

            </select>
        </div>

        <div class="col-md-6">
            <label>Pemusnahan</label>

            <input type="date"
                   name="pemusnahan"
                   class="form-control">
        </div>

        <div class="col-md-6">
            <label>Deskripsi</label>

            <textarea name="deskripsi"
                      class="form-control"></textarea>
        </div> 
    </div>

    <div class="row"> 
        <div class="col-md-6">
            <label>Nomor RAK</label>

            <select name="nomor_rak" class="form-control  select-rak_arsip">

                <option value="0">-- Pilih Rak --</option> 
            </select>
        </div> 
        <div class="col-md-6">
            <label>Nomor Dus</label>

            <select name="nomor_dus" class="form-control  select-dus_arsip">

                <option value="0">-- Pilih Dus --</option> 
            </select>
        </div> 
    </div>

        <button class="btn btn-primary">
            Simpan
        </button>

        <a href="{{ route('arsip.home') }}"
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
    select dus arsip
    */
    $('.select-dus_arsip').select2({

        placeholder: 'Cari kode arsip...',
        allowClear: true,
        minimumInputLength: 3,

        ajax: { 
            url: "{{ route('dus_arsip.search') }}", 

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
                            text: item.nomor_dus + ' - ' +
                                  (item.opd
                                    ? item.opd.singkatan_uk + ' - ' + item.opd.singkatan_instansi
                                    : '-')
                        };
                    })
                };
            }
        }
    });
    /*---
    select rak arsip
    ---*/ 

    $('.select-rak_arsip').select2({

        placeholder: 'Cari kode arsip...',
        allowClear: true,
        minimumInputLength: 3,

        ajax: { 
            url: "{{ route('rak_arsip.search') }}", 

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
                            text: item.nomor_rak + ' - ' +
                                  (item.opd
                                    ? item.opd.singkatan_uk + ' - ' + item.opd.singkatan_instansi
                                    : '-')
                        };
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