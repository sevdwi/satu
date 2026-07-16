<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SATU (Sistem Informasi Kearsipan Terpadu)</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link rel="icon" href="{{ asset('images/arsip2.png') }}" type="image/png">

        <!-- Custom Google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <!-- <link href="css/styles.css" rel="stylesheet" /> -->
        <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">

        <!-- ADMIN LTE -->
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        

        


    </head>

    <body class="d-flex flex-column h-100">
    @yield('content')

        <!-- Footer-->
        <footer>
            <p class="">
                &copy; 2026 <strong>SATU</strong> — Sistem Informasi Kearsipan Terpadu.
                Dikembangkan oleh <strong>Diskominfo</strong>.
            </p>
        </footer>

        <!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Core theme JS-->
<script src="js/scripts.js"></script>
<script>
  // Mobile menu toggle
  const mobileToggle = document.querySelector('.nav-mobile-toggle');
  const navLinks = document.querySelector('.nav-links');
  if (mobileToggle) {
    mobileToggle.addEventListener('click', () => {
      navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
      navLinks.style.flexDirection = 'column';
      navLinks.style.position = 'absolute';
      navLinks.style.top = '68px';
      navLinks.style.left = '0';
      navLinks.style.right = '0';
      navLinks.style.background = '#fff';
      navLinks.style.padding = '1rem';
      navLinks.style.borderBottom = '1px solid var(--border)';
      navLinks.style.boxShadow = '0 8px 24px rgba(0,0,0,.08)';
    });
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href="#modul"]').forEach(a => {
    a.addEventListener('click', e => {
      e.preventDefault();
      document.getElementById('modul').scrollIntoView({ behavior: 'smooth' });
    });
  });

  // Active nav highlight
  document.querySelectorAll('.nav-links > li > a').forEach(a => {
    a.addEventListener('click', function() {
      document.querySelectorAll('.nav-links > li > a').forEach(x => x.classList.remove('active'));
      this.classList.add('active');
    });
  });
</script>

    </body>
</html>
