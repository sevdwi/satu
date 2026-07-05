@extends('layouts.head_customer')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>

<div class="container mt-4">

    <h3>Tambah Arsip</h3>

    <form action="{{ route('arsip.update',$id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        <div class="row">

        <div class="col-md-6 mt-3">
            <label>Kode Arsip</label>
            <input type="hidden" name="id" value="{{$id}}">

            <select name="master_kode_id" class="form-control  select-master-kode">

                <option value="0">-- Pilih Kode --</option>

                <option value="{{ $data->master_kode_id }}" selected> 
                        {{ $data->masterKode->kode }} -   {{ $data->masterKode->nama }}
                </option>  

            </select>
            
        </div>

        <div class="col-md-6 mt-3">
            <label>OPD</label>

            <select name="opd_induk_id" class="form-control  select-opd_induk">

                <option value="0">-- Pilih OPD --</option>
                <option value="{{ $data->opd_induk_id }}" selected> 
                {{ $data->opd_induk->kode_instansi }} - {{ $data->opd_induk->instansi }} 
                </option>  
            </select>
        </div>


        <div class="col-md-6 mt-3">
            <label>Unit</label>

            <select name="opd_id" class="form-control  select-opd">

                <option value="0">-- Pilih OPD --</option>
                <option value="{{ $data->opd_id }}" selected> 
                        {{ $data->opd->singkatan_uk }}
                </option>  
            </select>
        </div>

        <div class="col-md-6 mt-3">
            <label>Korektor</label>

            <input type="text"
                   name="korektor"
                   class="form-control"
                   value="{{$data->korektor}}">
        </div>

        <div class="col-md-6 mt-3">
            <label>Judul</label>

            <input type="text"
                   name="judul"
                   class="form-control"
                   value="{{$data->judul}}">
        </div>

        <div class="col-md-6 mt-3">
            <label>Nomor Sementara</label>

            <input type="text"
                   name="nomor_sementara"
                   class="form-control"
                   value="{{$data->nomor_sementara}}">
        </div>

        <div class="col-md-6 mt-3">
            <label>Nomor</label>

            <input type="text"
                   name="nomor"
                   class="form-control"
                   value="{{$data->nomor}}">
        </div>

        <div class="col-md-6 mt-3">
            <label>Tanggal</label>

            <input type="date"
                   name="tanggal"
                   class="form-control"
                   value="{{$data->tanggal}}">
        </div>

        <div class="col-md-6 mt-3">
            <label>Retensi Aktif</label>
            <select name="retensi" class="form-control">
                <option value="0">pilih data</option>
                @for($a=1;$a<=10;$a++)
                <option value="{{$a}}" <?php if($a==$data->retensi){?>selected<?php }?>>{{$a}} Tahun</option>
                @endfor
            </select>
        </div>

        <div class="col-md-6 mt-3">
            <label>Retensi Inaktif</label>
            <select name="retensiinaktif" class="form-control">
                <option value="0">pilih data</option>
                @for($a=1;$a<=10;$a++)
                <option value="{{$a}}"  <?php if($a==$data->retensiinaktif){?>selected<?php }?>>{{$a}} Tahun</option>
                @endfor
            </select>
        </div>

        <div class="col-md-6 mt-3">
            <label>Status</label>

            <select name="status" class="form-control"> 
                <option value="aktif" <?php if($data->status=='aktif'){?> selected<?php }?>>Aktif</option>
                <option value="nonaktif" <?php if($data->status=='nonaktif'){?> selected<?php }?>>Nonaktif</option>

            </select>
        </div>

        <div class="col-md-6 mt-3">
            <label>Pemusnahan</label>

            <input type="date"
                   name="pemusnahan"
                   class="form-control"
                   value="{{$data->pemusnahan}}">
        </div>

        <div class="col-md-6 mt-3">
            <label>Deskripsi</label>

            <textarea name="deskripsi"
                      class="form-control">{{$data->deskripsi}}</textarea>
        </div> 
    </div>
    <div class="row"> 
        <div class="col-md-6 mt-3"> 
            <label>Nomor RAK</label>

            <select name="rak_arsip_id" class="form-control select-rak_arsip">

                <option value="0">-- Pilih Rak --</option>

                @if($data['rak_arsip'])
                    <option value="{{ $data->rak_arsip_id }}" selected>
                        {{ $data->rak_arsip->nomor_rak }}
                    </option>
                @endif

            </select> 
        </div> 
        <div class="col-md-6 mt-3">
            <label>Nomor Dus</label>

            <select name="dus_arsip_id" class="form-control  select-dus_arsip">

                <option value="0">-- Pilih Dus --</option>
                @if($data['dus_arsip'])
                <option value="{{ $data->dus_arsip_id }}" selected> 
                        {{ $data->dus_arsip->nomor_dus }}
                </option> 
                @endif
            </select>
        </div> 
    </div>

        <button class="btn btn-primary mt-3 mb-3">
            Simpan
        </button>

        <a href="{{ route('arsip.home') }}"
           class="btn btn-secondary mt-3 mb-3">

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
            url: "{{ route('master_kodes.search') }}", 

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

$('.select-opd_induk').select2({

placeholder: 'Cari OPD...',
allowClear: true,
minimumInputLength: 3,

ajax: {

    url: "{{ route('opd_induk.search') }}",

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
                    text: item.kode_instansi + ' - ' + item.instansi
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