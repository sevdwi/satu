@extends('layouts.head')

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
        <a href="{{route('opd_admin.index',$opd_induk->id)}}" class="active">
          <i class="bi bi-house"></i> Kembali
        </a>

      </li>
    </ul>
    

    <!-- Account -->
    <div class="nav-account">
      <div class="account-avatar"><i class="bi bi-people-fill me-2" style="color: #6495ED;"></i></div>
      <div>
        <div class="account-name">{{ auth()->guard('admin')->user()->name }}</div>
        <div class="account-role">Akun yang digunakan</div>
      </div>
      <i class="bi bi-chevron-down" style="font-size:.6rem;color:var(--muted);margin-left:.2rem;"></i>
      <div class="account-dropdown">
        <i class="bi">
        <form action="{{ route('logout-admin') }}" method="POST">
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


<div class="page-wrap">

    <h3 class="text-center">Tambah Data Unit Kerja</h3>

    <form action="{{ route('opd_admin.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf 

        <input type="hidden" name="opd_induk_id" value="{{ $opd_induk }}">

        <div class="mb-3">
            <label>Kode Instansi</label>

            <input type="text"
                   name="kode_instansi"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Unit Kerja</label>

            <input type="text"
                   name="unit_kerja"
                   class="form-control">
        </div>  

        <div class="mb-3">
            <label>Singkatan Unit Kerja</label>

            <input type="text"
                   name="singkatan_uk"
                   class="form-control">
        </div>  

        <div class="mb-3">
            <label>Instansi</label>

            <input type="text"
                   name="instansi"
                   class="form-control">
        </div>  

        <div class="mb-3">
            <label>Singkatan Instansi</label>

            <input type="text"
                   name="singkatan_instansi"
                   class="form-control">
        </div>  

        <button class="btn-add">
            Simpan
        </button>

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

    $('.select-opd_admin').select2({

    placeholder: 'Cari OPD...',
    allowClear: true,
    minimumInputLength: 3,

    ajax: {

        url: "{{ route('opd_admin.search') }}",

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