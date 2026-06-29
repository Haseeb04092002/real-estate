<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <?php $this->load->view('components/header_meta'); ?>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/forms.css'); ?>" rel="stylesheet">


</head>
<body>

<!-- Forgot Password -->
<div id="forgotPasswordSection" class="d-flex align-items-center justify-content-center" style="height: 100vh;">
  <div class="form-card pt-4">
    <div class="pt-3 d-flex justify-content-start container-fluid">
      <a href="<?=site_url('Properties/signin');?>" class="btn btn-link text-decoration-none fs-4" onclick="showSection('signInSection')">
        <i class="fa-solid fa-chevron-left"></i>
      </a>
    </div>
    <p class="text-center fw-bold">FORGOT PASSWORD</p>
    <div class="form-card-body d-flex flex-column align-items-center justify-content-center container-fluid">
      <input class="form-input ps-2 mb-3 w-100" type="email" placeholder="Email*" required>
      <button class="form-btn w-100">Confirm</button>
    </div>
  </div>
</div>

  




<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
  
</body>
</html>