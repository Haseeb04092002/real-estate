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
  <style>
    .back-btn {
      color: #00b4d8;
      font-size: 1.5rem;
      text-decoration: none;
    }
    .form-control-custom {
      border: 1px solid #ced4da;
      border-radius: 8px;
      padding: 12px 15px;
      margin-bottom: 15px;
    }
    .form-control-custom::placeholder {
      color: #6c757d;
    }
    .phone-input-group {
      display: flex;
      border: 1px solid #ced4da;
      border-radius: 8px;
      margin-bottom: 15px;
      overflow: hidden;
      align-items: center;
    }
    .phone-code-text {
      background: #fff;
      padding: 12px 15px;
      color: #495057;
      border-right: 0px;
    }
    .phone-input {
      border: none;
      flex: 1;
      padding: 12px 15px;
      outline: none;
    }
    .btn-continue {
      border: 1px solid #198754;
      color: #0f5132;
      background-color: transparent;
      border-radius: 8px;
      padding: 12px;
      font-weight: bold;
      width: 100%;
      margin-top: 15px;
    }
    .btn-continue:hover {
      background-color: #f8f9fa;
    }
    .terms-text {
      font-size: 0.9rem;
      color: #6c757d;
    }
    .terms-text a {
      color: #00b4d8;
      text-decoration: none;
    }
  </style>
</head>
<body>

<div class="d-flex align-items-center justify-content-center vh-100 bg-light">
  <div class="card shadow-sm border-0 rounded-4" style="max-width: 400px; width: 100%;">
    <div class="card-body p-4 p-md-4">
      
      <div class="mb-4">
        <a href="<?= site_url('Properties/signin') ?>" class="back-btn"><i class="fa-solid fa-angle-left"></i></a>
      </div>

      <?php echo form_open('Register/RegisterUser'); ?>

      <input type="text" name="FullName" class="form-control form-control-custom w-100" placeholder="Name*" required>
      <input type="email" name="UserEmail" class="form-control form-control-custom w-100" placeholder="Email*" required>
      <input type="password" name="UserPass1" class="form-control form-control-custom w-100" placeholder="Password*" required>
      <input type="password" name="UserPass2" class="form-control form-control-custom w-100" placeholder="Confirm Password*" required>
      
      <div class="phone-input-group w-100">
        <div class="phone-code-text">PK +92</div>
        <input type="tel" name="UserPhone" class="phone-input" placeholder="Enter your phone number" required>
      </div>

      <div class="form-check d-flex align-items-start mt-3 mb-4">
        <input class="form-check-input me-2 mt-1" type="checkbox" id="terms" required style="width: 1.1rem; height: 1.1rem;">
        <label class="form-check-label terms-text" for="terms">
          I have read and I agree to the Real State.com <br> <a href="#">Terms and Conditions</a>
        </label>
      </div>

      <button type="submit" class="btn btn-continue">Continue</button>

      <?php echo form_close(); ?>

    </div>
  </div>
</div>

<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>