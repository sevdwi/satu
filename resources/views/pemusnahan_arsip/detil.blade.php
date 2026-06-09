@extends('layouts.administrator')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>

<div class="container mt-4">

    <div class="card">
    <div class="card-header">
        <h4 class="mb-0">Detail Dokumen Pemusnahan Arsip</h4>
    </div> 
    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="25%">Kode Arsip</th>
                <td>
                    {{ $data->masterKode->kode ?? '-' }}
                    -
                    {{ $data->masterKode->nama ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>OPD</th>
                <td>
                    {{ $data->opd->singkatan_uk ?? '-' }}
                    -
                    {{ $data->opd->singkatan_instansi ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Korektor</th>
                <td>{{ $data->korektor }}</td>
            </tr>

            <tr>
                <th>Judul</th>
                <td>{{ $data->judul }}</td>
            </tr>

            <tr>
                <th>Nomor Arsip</th>
                <td>{{ $data->nomor }}</td>
            </tr>

            <tr>
                <th>Tanggal Arsip</th>
                <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
            </tr>

            <tr>
                <th>Retensi Aktif</th>
                <td>{{ $data->retensi }} Tahun</td>
            </tr>

            <tr>
                <th>Retensi Inaktif</th>
                <td>{{ $data->retensiinaktif }} Tahun</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    @if($data->status == 'aktif')
                        <span class="badge bg-success">Aktif</span>
                    @elseif($data->status == 'nonaktif')
                        <span class="badge bg-warning">Nonaktif</span>
                    @else
                        <span class="badge bg-danger">
                            {{ ucfirst($data->status) }}
                        </span>
                    @endif
                </td>
            </tr>

            <tr>
                <th>Tanggal Pemusnahan</th>
                <td>
                    {{ \Carbon\Carbon::parse($data->pemusnahan)->format('d-m-Y') }}
                </td>
            </tr>

            <tr>
                <th>Deskripsi</th>
                <td>{!! nl2br(e($data->deskripsi)) !!}</td>
            </tr>

            <tr>
                <th>File Berita Acara</th>
                <td>
                    @if($data->file_ba)
                        <a href="{{ asset('storage/'.$data->file_ba) }}"
                           target="_blank"
                           class="btn btn-primary btn-sm">
                            <i class="fa fa-file-pdf"></i>
                            Lihat Berita Acara
                        </a>
                    @else
                        <span class="text-danger">
                            File berita acara belum tersedia
                        </span>
                    @endif
                </td>
            </tr>

        </table>

    </div>

    <div class="card-footer">
        <a href="{{ route('pemusnahan_arsip.home') }}"
           class="btn btn-secondary">
            Kembali
        </a>

        <!-- <a href="{{ route('pemusnahan_arsip.edit', $data->id) }}"
           class="btn btn-warning">
            Edit Data
        </a> -->
    </div>
    ```

    </div>


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