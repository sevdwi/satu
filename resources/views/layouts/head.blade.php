<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Sistem Informasi Kearsipan Terpadu" />
        <meta name="author" content="Diskominfo" />
        <title>SATU (Sistem Informasi Kearsipan Terpadu)</title>
        
        <!-- Favicon (Dihapus duplikasinya, menggunakan asset Laravel) -->
        <link rel="icon" href="{{ asset('images/arsip2.png') }}" type="image/png">

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <!-- Plus Jakarta Sans -->
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
        <!-- Source Sans Pro (Admin LTE) -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <!-- Bootstrap & Icons CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
        
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Core theme CSS -->
        <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">

        <!-- Slot untuk CSS Tambahan dari Halaman Anak -->
        @stack('styles')

        <!-- jQuery (Wajib ada di head agar bisa digunakan langsung oleh skrip halaman anak) -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    </head>

    <body class="d-flex flex-column h-100">
        
        <!-- Konten Utama -->
        @yield('content')

        <!-- Footer -->
        <footer class="mt-auto py-3 bg-light text-center">
            <p class="mb-0">
                &copy; 2026 <strong>SATU</strong> — Sistem Informasi Kearsipan Terpadu.
                Dikembangkan oleh <strong>Diskominfo</strong>.
            </p>
        </footer>

        <!-- Bootstrap JS (Versi disamakan menjadi 5.3.3) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Chart.js dan Select2 JS (Dipindah ke bawah agar tidak memblokir render halaman) -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>


        <!-- Core theme JS -->
        <script src="{{ asset('js/scripts.js') }}"></script>
        
        <!-- Custom JS -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Mobile menu toggle
                const mobileToggle = document.querySelector('.nav-mobile-toggle');
                const navLinks = document.querySelector('.nav-links');
                
                if (mobileToggle && navLinks) {
                    mobileToggle.addEventListener('click', () => {
                        const isFlex = navLinks.style.display === 'flex';
                        navLinks.style.display = isFlex ? 'none' : 'flex';
                        
                        if (!isFlex) {
                            navLinks.style.flexDirection = 'column';
                            navLinks.style.position = 'absolute';
                            navLinks.style.top = '68px';
                            navLinks.style.left = '0';
                            navLinks.style.right = '0';
                            navLinks.style.background = '#fff';
                            navLinks.style.padding = '1rem';
                            navLinks.style.borderBottom = '1px solid var(--border)';
                            navLinks.style.boxShadow = '0 8px 24px rgba(0,0,0,.08)';
                        }
                    });
                }

                // Smooth scroll for anchor links
                document.querySelectorAll('a[href="#modul"]').forEach(a => {
                    a.addEventListener('click', e => {
                        e.preventDefault();
                        const target = document.getElementById('modul');
                        if(target) {
                            target.scrollIntoView({ behavior: 'smooth' });
                        }
                    });
                });

                // Active nav highlight
                document.querySelectorAll('.nav-links > li > a').forEach(a => {
                    a.addEventListener('click', function() {
                        document.querySelectorAll('.nav-links > li > a').forEach(x => x.classList.remove('active'));
                        this.classList.add('active');
                    });
                });
            });
        </script>

        <!-- Slot untuk JavaScript Tambahan dari Halaman Anak -->
        @stack('scripts')
    </body>
</html>