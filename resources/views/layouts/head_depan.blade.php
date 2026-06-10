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
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

        <!-- ADMIN LTE -->
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        


    </head>

    <body class="d-flex flex-column h-100">
    @yield('content')

    <!-- ═══════════════════════════════════════════════
        FOOTER
    ════════════════════════════════════════════════ -->
    <footer>
      <p>&copy; 2026 <strong>SATU</strong> — Sistem Informasi Kearsipan Terpadu. Dikembangkan oleh <strong>Diskominfo</strong>.</p>
    </footer>
 
        <!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
<script>
  const toggle = document.getElementById('mobileToggle');
  const actions = document.getElementById('navActions');
  if (toggle) {
    toggle.addEventListener('click', () => {
      actions.classList.toggle('open');
    });
  }
</script>

    </body>
</html>
