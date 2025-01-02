<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/proker/ice24/style.css') ?>">
  <link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/logo_buket_1.webp') ?>">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <title>LeafForce Bouquets</title>

  <style>
    :root {
      --primary-color: #65759C;
      --secondary-color: #F0F4FF;
      --accent-color: #3D4E81;
      --text-color: #333333;
      --light-color: #FFFFFF;
      --navbar-height: 54px; 
    }


    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      border-radius: 5px;
      background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
      border-radius: 5px;
      background: linear-gradient(180.89deg, #3A4255 24.96%, #65759C 99.24%);
      transition: background 0.3s ease;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(0deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), linear-gradient(180.89deg, #3A4255 24.96%, #65759C 99.24%);
    }

    .fa,
    .fas {
      font-family: "Font Awesome 6 Free" !important;
      font-weight: 900;
    }

    /* navbar */
    .navbar-ic {
      background-color: #CBC7C7;
      height: var(--navbar-height); /* Gunakan variable navbar-height */
    }

    .navbar-ic .nav-link {
      font-weight: 600;
      color: #3F475B !important;
    }

    .navbar-ic .nav-link:hover {
      color: rgb(155, 153, 153) !important;
    }

    /* Hero */
    .btn-cyan {
      background-color: #65759C !important;
      color: white !important;
    }

    .btn-cyan:hover {
      transform: scale(1.05);
      box-shadow: 0 0 5px rgba(255, 255, 255, 0.7);
    }

    .navbar-ic .btn-cyan:hover {
      color: white !important;
    }

    /* About */
    .btn-orange {
      background-color: #F7B267 !important;
    }

    .btn-orange:hover {
      transform: scale(1.05);
    }

    .btn-outline-orange {
      border-color: #F7B267 !important;
      color: #F7B267 !important;
    }

    .btn-outline-orange:hover {
      background-color: white !important;
      border-color: white !important;
      color: #F7B267 !important;
    }

    @media screen and (max-width: 576px) {
      body {
        background-position: center !important;
      }
    }
  </style>

</head>

<body class="d-flex flex-column min-vh-100" style="background-image: url('<?= base_url('#') ?>'); background-size: cover;">
  <?= $this->include('layout/navbar') ?>

  <main class="flex-grow-1">
    <?= $this->renderSection('content') ?>

    
  </main>

  <?= $this->include('layout/footer') ?>

  <script>
    AOS.init();
    
  </script>
</body>



</html>

