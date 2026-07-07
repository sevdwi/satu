@extends('layouts.head_customer')

@section('content')

<nav class="navbar-custom">
  <div class="navbar-inner">

    <!-- Brand -->
    <a href="#" class="nav-brand">
      <img src="{{ asset('images/arsip2.png') }}" width="40" class="mb-3">
      <div class="nav-brand-text">
        <strong>SATU</strong>
        <small>Sistem Informasi Kearsipan Terpadu</small>
      </div>
    </a>

    <!-- Nav Links -->
    <ul class="nav-links">
      <li>
        <a href="{{route('dashboard')}}" class="active">
          <i class="bi bi-house"></i> Kembali
        </a>

      </li>
    </ul>
    

    <!-- Account -->
    <div class="nav-account">
      <div class="account-avatar"><i class="bi bi-people-fill me-2" style="color: #6495ED;"></i></div>
      <div>
        <div class="account-name">{{ auth()->guard('web')->user()->name }}</div>
        <div class="account-role">Akun yang digunakan</div>
      </div>
      <i class="bi bi-chevron-down" style="font-size:.6rem;color:var(--muted);margin-left:.2rem;"></i>
      <div class="account-dropdown">
        <i class="bi">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout btn px-4 btn-logout-red">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
        </i>
      </div>
    </div>

    <button class="nav-mobile-toggle"><i class="bi bi-list"></i></button>
  </div>
</nav>


<div class="container mt-4 mb-4">

    <h3>Tambah Dus Arsip</h3>

    <form action="{{ route('dus_arsip.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf 

        <div class="mb-3">
            <label>OPD</label>

            <select name="opd_id" class="form-control  select-opd">

                <option value="0">-- Pilih OPD --</option>

                

            </select>
        </div>

        <div class="mb-3">
            <label>Nomor Rak Arsip</label>

            <select name="nomor_rak" class="form-control  select-rakarsip">

                <option value="0">-- Pilih Rak --</option>

                

            </select>
        </div>

        <div class="mb-3">
            <label>Nomor Dus</label>

            <input type="text"
                   name="nomor_dus"
                   class="form-control">
        </div> 

        <button class="btn btn-primary">
            Simpan
        </button>

        <!-- <a href="{{ route('arsip.home') }}"
           class="btn btn-secondary">

            Kembali

        </a> -->

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

    $('.select-rakarsip').select2({

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