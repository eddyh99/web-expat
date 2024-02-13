<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical" data-boxed-layout="boxed" data-card="shadow"><head>
  <!-- Required meta tags -->
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Favicon icon-->
<link rel="shortcut icon" type="image/png" href="<?php echo config_item('base_url');?>assets/img/favicon.png">

<!-- Core Css -->
<link rel="stylesheet" href="<?php echo config_item('base_url');?>assets/css/styles.css">
<link rel="stylesheet" href="<?php echo config_item('base_url');?>assets/css/custom.css">

  <title>ERROR 404 NOT FOUND</title>
</head>

<body data-sidebartype="full">

  <div class="preloader" style="display: none;">
    <img src="../assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid">
  </div>
  <div id="main-wrapper">
    <div class="position-relative overflow-hidden min-vh-100 w-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-lg-4">
            <div class="text-center">
              <img src="<?php echo config_item('base_url');?>assets/img/error404.jpg" alt="" class="img-fluid" width="500">
              <h1 class="fw-semibold mb-7 fs-9">Opps!!!</h1>
              <h4 class="fw-semibold mb-7">This page you are looking for could not be found.</h4>
              <a class="btn btn-expat" href="<?php echo config_item('base_url');?>" role="button">Go Back to Home</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>