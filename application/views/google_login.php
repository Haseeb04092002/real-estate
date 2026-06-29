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

<!-- Sign In -->
<?php echo form_open('Login'); ?>
<div id="signInSection" class="d-flex align-items-center justify-content-center vh-100 bg-light">
  <div class="card shadow-lg border-0 rounded-4 p-3" style="max-width: 420px; width: 100%;">
    <div class="card-body text-center">

      <!-- Icon -->
      <div class="mb-3">
        <i class="bi bi-google" style="font-size: 3rem; color: #ea4335;"></i>
      </div>

      <!-- Heading -->
      <h4 class="mb-3 fw-bold text-dark">Register with Google</h4>
      <p class="text-muted small mb-4">Use your Google account to access your dashboard quickly and securely.</p>

      <!-- Google Button -->
      <a href="<?= $google_login_url ?>" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
        <i class="bi bi-box-arrow-in-right"></i>
        <span>Continue with Google</span>
      </a>

    </div>
  </div>
</div>
<?php echo form_close(); ?>



<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
  
</body>
</html>