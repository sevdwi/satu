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
        <a href="{{route('opd_induk.index')}}" class="active">
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
        <form action="{{ route('logout-admin') }}" method="POST">
            @csrf
            <button type="submit" class="logout btn px-4 btn-logout-red">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
      </div>
    </div>

    <button class="nav-mobile-toggle"><i class="bi bi-list"></i></button>
  </div>
</nav>


<div class="container mt-4 mb-4">

    <h3>Ubah Data Instansi</h3>

    <form action="{{ route('opd.update',$opd->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="needs-validation" 
        novalidate>

        @csrf 
        @method('PUT')

        <div class="mb-3">
            <label>Kode</label>
            <input type="text"
                name="kode_instansi"
                class="form-control" 
                value="{{ $opd->kode_instansi}}" 
                required>
            <div class="invalid-feedback">Kode instansi wajib diisi.</div>
        </div> 

        <div class="mb-3">
            <label>Unit Kerja</label>
            <input type="text"
                name="instansi"
                class="form-control" 
                value="{{$opd->unit_kerja}}" 
                required>
            <div class="invalid-feedback">Nama unit kerja wajib diisi.</div>
        </div>

        <div class="mb-3">
            <label>Singkatan Unit Kerja</label>
            <input type="text"
                name="singkatan_instansi"
                class="form-control" 
                value="{{$opd->singkatan_uk}}" 
                required>
            <div class="invalid-feedback">Singkatan unit kerja wajib diisi.</div>
        </div>

        <button type="submit" class="btn-add">
            Simpan
        </button>

        <a href="{{ route('opd_induk.index') }}" class="btn btn-secondary">
            Kembali
        </a>

    </form>


</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil semua form yang memiliki kelas 'needs-validation'
        const forms = document.querySelectorAll('.needs-validation');

        // Lakukan iterasi pada setiap form
        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                // Periksa apakah form memenuhi syarat validasi HTML5
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                // Tambahkan kelas 'was-validated' untuk memunculkan pesan invalid-feedback
                form.classList.add('was-validated');
            }, false);
        });
    });
</script>

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