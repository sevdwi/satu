@extends('layouts.head_customer')

@section('content') 
<?php 
use Carbon\Carbon;
?>
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

<div class="container mt-4">

    <h3>Edit Arsip</h3>

    <form action="{{ route('arsip.update',$id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <input type="hidden" name="id" value="{{$id}}">
        <input type="hidden" name="opd_induk_id" value="{{ auth()->user()->opd_induk_id }}">
        <input type="hidden" name="opd_id" value="{{ auth()->user()->opd_id }}">
        <input type="hidden" name="periode_id" value="{{ $periodes->id }}">



        <div class="row">

            <div class="col-md-6 mt-3">
                <label>OPD</label>
                <input type="text" name="opd_induk_id" value="{{ auth()->user()->opd_induk?->instansi }}" class="form-control" disabled>
            </div>

            <div class="col-md-6 mt-3">
                <label>Unit</label>
                <input type="text" name="opd_induk_id" value="{{ auth()->user()->opd?->unit_kerja }}" class="form-control" disabled>
            </div>

            <div class="col-md-6 mt-3">
                <label>Tahun</label>
                <input type="text" name="tahun" value="{{ date('Y'); }}" class="form-control" disabled>
            </div>

            <div class="col-md-6 mt-3">
                <label>Tahap</label>
                <input type="text" name="tahap" value="{{ $periodes->tahap }} - {{ $periodes->status }}" class="form-control" disabled>
            </div>


            <div class="col-md-6 mt-3">
                <label>Korektor</label>

                <input type="text"
                    name="korektor"
                    class="form-control"
                    value="{{$data->korektor}}">
            </div>

            <div class="col-md-6 mt-3">
                <label>Redaksi</label>

                <input type="text"
                    name="judul"
                    class="form-control"
                    value="{{$data->judul}}">
            </div>

            <div class="col-md-6 mt-3">
                <label>Nomor Arsip</label>

                <input type="text"
                    name="nomor"
                    class="form-control"
                    value="{{$data->nomor}}">
            </div>

            <div class="col-md-6 mt-3">
                <label>Kode Klasifikasi</label>
                <select name="master_kode_id" id="master_kode_id" class="form-select form-select-sm  @error('master_kode_id') is-invalid @enderror"  required aria-label="Large select example"> 
                    <option value="" data-aktif="0" data-inaktif="0" data-keterangan="">-- Pilih Kode --</option> 
                    @foreach($masterKodes as $kode) 
                        <option value="{{ $kode->id }}" 
                                data-aktif="{{ $kode->aktif }}" 
                                data-inaktif="{{ $kode->inaktif }}" 
                                data-keterangan="{{ $kode->keterangan }}"
                                @selected($kode->id == (old('master_kode_id') ?? $data->master_kode_id))> 
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


            <div class="col-md-6 mt-3">
                <label>Tanggal</label>

                <input type="date"
                    name="tanggal"
                    class="form-control"
                    value="{{$data->tanggal}}">
            </div>
            <?php 
            $tanggal = $data->tanggal;
            $aktif = (int) $data->aktif;
            $inaktif = (int) $data->inaktif;

            // 2. Hitung total tahun retensi
            $totalTahun = $aktif + $inaktif;

            // 3. Kalkulasi tanggal musnah menggunakan Carbon
            // Tambahkan pengkondisian jika retensi permanen/tidak ada tanggal
            $totalMusnah = null;
            if ($tanggal) {
                $totalMusnah = Carbon::parse($tanggal)->addYears($totalTahun)->format('Y-m-d');
            }
    ?>
            <div class="col-md-6 mt-3">
                <label>Tanggal Musnah</label>

                <input type="date"
                    name="tanggal_musnah"
                    class="form-control"
                    value="{{$data->tanggal_musnah ?? $totalMusnah }}">
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
                    <option value="input" <?php if($data->status=='input'){?> selected<?php }?>>Input</option>
                    <option value="draft" <?php if($data->status=='draft'){?> selected<?php }?>>Draft</option>

                </select>
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

                    <option value="">-- Pilih Rak --</option>

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

                    <option value="">-- Pilih Dus --</option>
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

        <!-- <a href="{{ route('arsip.home') }}"
           class="btn btn-secondary mt-3 mb-3">
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

        // 1. Buat fungsi khusus untuk mengisi data
        function isiDataOtomatis() {
            // Dapatkan opsi yang sedang dipilih oleh user atau sistem (saat edit)
            const selectedOption = selectMasterKode.options[selectMasterKode.selectedIndex];

            if (selectedOption) {
                // Ambil data atribut dari opsi terpilih
                const valAktif = selectedOption.getAttribute('data-aktif');
                const valInaktif = selectedOption.getAttribute('data-inaktif');
                const valKeterangan = selectedOption.getAttribute('data-keterangan');

                // Tetapkan nilai ke masing-masing elemen target
                selectAktif.value = valAktif ? valAktif : "0";
                selectInaktif.value = valInaktif ? valInaktif : "0";
                inputPemusnahan.value = valKeterangan ? valKeterangan : "";
            }
        }

        // 2. JALANKAN PERTAMA KALI SAAT HALAMAN EDIT DIMUAT
        isiDataOtomatis();

        // 3. JALANKAN SAAT USER MENGUBAH PILIHAN KODE
        selectMasterKode.addEventListener('change', isiDataOtomatis);
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
                                    ? item.opd.singkatan_uk 
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
                                    ? item.opd.singkatan_uk
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