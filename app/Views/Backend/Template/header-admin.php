<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard Solvamatika</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../../adminassets/img/favicon.png" rel="icon">
  <link href="../../adminassets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../adminassets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../adminassets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../adminassets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../../adminassets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../../adminassets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../../adminassets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../../adminassets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../../adminassets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="../../adminassets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Solvamatika</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown">

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

        </li><!-- End Messages Nav -->

<li class="nav-item pe-3"> <!-- Hapus class 'dropdown' -->
  <!-- Ubah tag <a> menghilangkan data-bs-toggle dan class dropdown-toggle -->
  <span class="nav-link d-flex align-items-center pe-0 text-dark fw-semibold" id="live-clock">
    00:00:00
  </span>
</li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <script>
  function updateClock() {
    const now = new Date();

    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    const timeString = `${hours}:${minutes}:${seconds}`;

    document.getElementById('live-clock').textContent = timeString;
  }

  setInterval(updateClock, 1000);

  updateClock();
</script>