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
        <a href="{{route('arsip.home')}}" class="active">
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

<div class="page-wrap">
<div class="mt-4 mb-4 card-custom">

    <!-- <h3 class="mt-2">Tambah Arsip</h3> -->
        <!-- Card Header -->
    <div class="card-top mt-1">
      <div class="card-top-left">
        <div class="card-icon"><i class="bi bi-archive"></i></div>
        <div>
          <div class="card-title">Tambah Arsip</div>
          <div class="card-subtitle">Kelola seluruh akun pengguna sistem</div>
        </div>
      </div>
      <!-- <a href="{{ route('users.create') }}" class="btn-add">
        <i class="bi bi-plus-lg"></i> Tambah User
      </a> -->
    </div>

<form action="{{ route('arsip.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

    <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">
    <input type="hidden" name="opd_induk_id" value="{{ auth()->user()->opd_induk_id }}">
    <input type="hidden" name="opd_id" value="{{ auth()->user()->opd_id }}">



    <div class="row mt-3 ms-2 me-2">

            <div class="col-md-6 mt-3">
                        <label>OPD</label>
                        <input type="text" name="opd_induk_id" value="{{ auth()->user()->opd_induk?->instansi }}" class="form-control" disabled>
                        <!-- <select name="opd_induk_id" class="form-select form-select-sm" aria-label="Large select example">

                            <option value="0">-- Pilih OPD --</option>
                            @foreach($opdinduks as $opdinduk)

                            <option value="{{ $opdinduk->id }}">

                            {{ $opdinduk->kode_instansi }} - {{ $opdinduk->instansi }}

                            </option>

                            @endforeach
                        
                        </select> -->
            </div>

            <div class="col-md-6 mt-3">
                        <label>Unit</label>
                        <input type="text" name="opd_induk_id" value="{{ auth()->user()->opd?->unit_kerja }}" class="form-control" disabled>
                        <!-- <select name="opd_id" class="form-select form-select-sm" aria-label="Large select example">

                            <option value="0">-- Pilih Unit --</option>
                            @foreach($opds as $opd)

                            <option value="{{ $opd->id }}">

                            {{ $opd->unit_kerja }}

                            </option>

                            @endforeach
                         
                        </select> -->

            </div>
            <div class="col-md-6 mt-3">
                        <label>Tahun</label>
                        <input type="text" name="tahun" value="{{ date('Y'); }}" class="form-control" disabled>

            </div>

            <div class="col-md-6 mt-3">
                        <label>Tahap</label>
                        <input type="text" name="tahap" value="{{ session('periodes') }}" class="form-control" disabled>

            </div>

            <div class="col-md-6 mt-3">
                <label>Redaksi</label>

                <input type="text"
                    name="judul"
                    class="form-control">
            </div>

            <div class="col-md-6 mt-3">
                <label>Nomor Arsip</label>

                <input type="text"
                    name="nomor"
                    class="form-control"
                    placeholder="Masukkan nomor atau biarkan kosong">
            </div>

            <div class="col-md-6 mt-3">
                <label>Tanggal</label>

                <input type="date"
                    name="tanggal"
                    class="form-control">
            </div>

            <div class="col-md-6 mt-3">
                <label>Kode Arsip</label>
                <select name="master_kode_id" id="master_kode_id" class="form-select form-select-sm  @error('master_kode_id') is-invalid @enderror"  required aria-label="Large select example"> 
                <!-- Nilai value untuk opsi default harus kosong "" agar dibaca tidak valid oleh required -->
                    <option value="" data-aktif="0" data-inaktif="0" data-keterangan="">-- Pilih Kode --</option> 
                    @foreach($masterKodes as $kode) 
                        <option value="{{ $kode->id }}" 
                                data-aktif="{{ $kode->aktif }}" 
                                data-inaktif="{{ $kode->inaktif }}" 
                                data-keterangan="{{ $kode->keterangan }}"> 
                            {{ $kode->kode }} - {{ $kode->nama }} 
                        </option> 
                    @endforeach 
                </select>
                @error('master_kode_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <div class="invalid-feedback">Kode wajib dipilih</div>
                @enderror
            </div>


            <!-- Dropdown Retensi Aktif -->
            <div class="col-md-6 mt-3"> 
                <label>Retensi Aktif</label> 
                <select name="aktif" id="aktif" class="form-control" readonly style="pointer-events: none;"> 
                    <option value="0">pilih data</option> 
                    @for($a=1;$a<=10;$a++) 
                        <option value="{{$a}}">{{$a}} Tahun</option> 
                    @endfor 
                </select> 
            </div> 

            <!-- Dropdown Retensi Inaktif -->
            <div class="col-md-6 mt-3"> 
                <label>Retensi Inaktif</label> 
                <select name="inaktif" id="inaktif" class="form-control" readonly style="pointer-events: none;"> 
                    <option value="0">pilih data</option> 
                    @for($a=1;$a<=10;$a++) 
                        <option value="{{$a}}">{{$a}} Tahun</option> 
                    @endfor 
                </select> 
            </div> 

            <!-- Input Pemusnahan/Keterangan -->
            <div class="col-md-6 mt-3"> 
                <label>Pemusnahan (Keterangan)</label> 
                <!-- Tipe input diubah ke 'text' menyesuaikan isi data string 'Permanen' atau 'Musnah' -->
                <input type="text" name="pemusnahan" id="pemusnahan" class="form-control" readonly> 
            </div>


            <div class="col-md-6 mt-3">
                <label>Status</label>

                <select name="status" class="form-control">

                    <option value="input">Input</option>
                    <option value="draft">Draft</option>

                </select>
            </div>


            <div class="col-md-6 mt-3">
                <label>Deskripsi</label>

                <textarea name="deskripsi"
                        class="form-control"></textarea>
            </div> 

            <div class="col-md-6 mt-3">
                <label>Korektor</label>

                <input type="text"
                    name="korektor"
                    class="form-control"
                    placeholder="Belum ada"
                    value="Belum ada">
            </div>

        </div>

        <div class="row ms-2 me-2"> 
            <div class="col-md-6 mt-3">
                <label>Nomor RAK (kosongkan jika belum dibuat)</label>

                <select name="rak_arsip_id" class="form-select form-select-sm" aria-label="Large select example">

                    <option value="">-- Pilih Rak --</option> 
                    @foreach($rak_arsips as $rak_arsip)

                    <option value="{{ $rak_arsip->id }}">
                    {{ $rak_arsip->nomor_rak }}
                    </option>

                    @endforeach

                </select>
            </div> 
            <div class="col-md-6 mt-3">
                <label>Nomor Dus (kosongkan jika belum dibuat)</label>

                <select name="dus_arsip_id" class="form-select form-select-sm" aria-label="Large select example">

                    <option value="">-- Pilih Dus --</option> 
                    @foreach($dus_arsips as $dus_arsip)

                    <option value="{{ $dus_arsip->id }}">
                    {{ $dus_arsip->nomor_dus }}
                    </option>

                    @endforeach
                </select>
            </div> 
        </div>

        <div class="mt-5 mb-5 ms-4">

            <button class="btn btn-primary">
                Simpan
            </button>

        </div>
</form>

    </div>
</div>
</div>
<!-- jQuery (WAJIB paling atas) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Seleksi formulir yang memerlukan validasi kustom Bootstrap
        const forms = document.querySelectorAll('.needs-validation');

        // Berikan penanganan kejadian 'submit' pada setiap formulir
        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                // Hentikan pengiriman jika formulir tidak valid secara aturan HTML5
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                // Tambahkan kelas indikator ke formulir untuk memunculkan gaya error
                form.classList.add('was-validated');
            }, false);
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectMasterKode = document.getElementById('master_kode_id');
        const selectAktif = document.getElementById('aktif');
        const selectInaktif = document.getElementById('inaktif');
        const inputPemusnahan = document.getElementById('pemusnahan');

        selectMasterKode.addEventListener('change', function() {
            // Dapatkan opsi yang sedang dipilih oleh user
            const selectedOption = this.options[this.selectedIndex];

            // Ambil data atribut dari opsi terpilih
            const valAktif = selectedOption.getAttribute('data-aktif');
            const valInaktif = selectedOption.getAttribute('data-inaktif');
            const valKeterangan = selectedOption.getAttribute('data-keterangan');

            // Tetapkan nilai ke masing-masing elemen target
            selectAktif.value = valAktif ? valAktif : "0";
            selectInaktif.value = valInaktif ? valInaktif : "0";
            inputPemusnahan.value = valKeterangan ? valKeterangan : "";
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
        minimumInputLength: 1,

        ajax: { 
            url: "{{ route('dus_arsip.search2') }}", 

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
        minimumInputLength: 1,

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