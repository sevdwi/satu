@extends('layouts.head')
@section('content')
<main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.html"><span class="fw-bolder text-primary">Halaman Login SATU</span></a> <span> </span> <img src="{{ asset('images/arsip.png') }}" width="40" class="mb-3">

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                            <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="resume.html">Resume</a></li>
                            <li class="nav-item"><a class="nav-link" href="projects.html">Projects</a></li>
                            <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                        </ul>
                    </div> -->
                </div>
            </nav>

            <!-- Header-->
            <header class="py-5">
                <div class="container px-5 pb-5">
                    <div class="row gx-5 align-items-center">
                        <div class="col-xxl-5">
                            <!-- Header text content-->
                            <div class="text-center text-xxl-start">
                                <div class="badge bg-gradient-primary-to-secondary text-white mb-4"><div class="text-uppercase">Efisien &middot; Simple &middot; Mudah</div></div>
                                <div class="fs-3 fw-light text-muted">Sistem Informasi Kearsipan Terpadu</div>
                                <h1 class="display-3 fw-bolder mb-5"><span class="text-gradient d-inline">SATU</span></h1>
                                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xxl-start mb-3">
                                    <a class="btn btn-primary btn-lg px-5 py-3 me-sm-3 fs-6 fw-bolder" href="{{route('welcome')}}">Home</a>
                                    <!-- <a class="btn btn-outline-dark btn-lg px-5 py-3 fs-6 fw-bolder" href="projects.html">Projects</a> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-7">
                            <!-- Header profile picture-->
                            <div class="d-flex justify-content-center mt-5 mt-xxl-0">
                            <!-- batas atas card -->
                            <div class="align-self-center" style="width:420px;">

                                <div class="card login-card shadow-lg">
                                    <div class="card-body text-center p-4">

                                        <div class="login-title text-purple mb-4">
                                            Selamat Datang 👋
                                        </div>

                                        <form action="/login" method="POST">
                                            @csrf
                                            <!-- <div class="mb-3 text-start">
                                                <label class="form-label text-purple">Nama</label>
                                                <input type="text" class="form-control"
                                                    name="name" required>
                                            </div> -->

                                            <div class="mb-3 text-start">
                                                <label class="form-label text-purple">Nomor HP</label>
                                                <input type="number" class="form-control"
                                                    name="phone_number" required>
                                            </div>

                                            <div class="mb-2 text-start">
                                                <label class="form-label text-purple">Password</label>
                                                <input type="password" class="form-control"
                                                    id="password" name="password" required>
                                            </div>

                                            <div class="form-check text-start mb-3">
                                                <input class="form-check-input" type="checkbox" id="showPassword">
                                                <label class="form-check-label text-purple">
                                                    Tampilkan Password
                                                </label>
                                            </div>

                                            <button type="submit" class="btn btn-primary w-100">
                                                🚀 Masuk
                                            </button>
                                        </form>

                                        {{-- Error --}}
                                        @if ($errors->any())
                                            <div class="alert-custom">
                                                {{ $errors->first() }}
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                             <!-- batas bawah card -->
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- About Section-->
            <section class="bg-light py-5">
                <div class="container px-5">
                    <div class="row gx-5 justify-content-center">
                        <div class="col-xxl-8">
                            <div class="text-center my-5">
                                <h2 class="display-5 fw-bolder"><span class="text-gradient d-inline">About Me</span></h2>
                                <p class="lead fw-light mb-4">Selamat datang di Aplikasi SATU ARPUS Cilacap</p>
                                <p class="text-muted">Perpustakaan di Kabupaten Cilacap merupakan perpustakaan yang berada di lingkungan Sekretariat Daerah Kabupaten Cilacap, sesuai PERDA No. 2 tahun 1998 tepatnya tanggal 28 Oktober 1998 Kantor Perpustakaan Daerah Cilacap beralamatkan di jl. Jend. Sudirman No 12 Cilacap. Sesuai PERDA No. 31 tahun 2004  menjadi Kantor Arsip dan Perpusda Cilacap, dalam sejarahnya terjadi dinamika pengorganisasian tetapi tidak merubah fungsi perpustakaan itu sendiri.</p>
                                <div class="d-flex justify-content-center fs-2 gap-4">
                                    <a class="text-gradient" href="#!"><i class="bi bi-twitter"></i></a>
                                    <a class="text-gradient" href="#!"><i class="bi bi-linkedin"></i></a>
                                    <a class="text-gradient" href="#!"><i class="bi bi-github"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        {{-- Show Password --}}
        <script>
        document.getElementById("showPassword").addEventListener("change", function () {
            document.getElementById("password").type =
                this.checked ? "text" : "password";
        });
        </script>

@endsection