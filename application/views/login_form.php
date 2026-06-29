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
  <div class="card shadow-lg border-0" style="max-width: 400px; width: 100%;">
    <div class="card-body p-4">
      
      <h3 class="text-center mb-4">Sign In</h3>

      

      <!-- Continue with Google -->
      <div class="d-grid mb-3">
        <a href="<?=site_url('google_login');?>" class="border border-dark fs-6 btn btn-light-blue rounded-pill py-2 d-flex align-items-center justify-content-center">
          
          <!-- Google G Logo -->
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="me-2" viewBox="0 0 488 512">
            <path fill="#4285F4" d="M488 261.8c0-17.9-1.5-35-4.3-51.8H249v98.1h134.1c-5.8 31-23.2 57.4-49.7 75l80.5 62C450 405 488 338.8 488 261.8z"/>
            <path fill="#34A853" d="M249 492c67.4 0 123.9-22.3 165.2-60.4l-80.5-62c-22.4 15-51.2 23.9-84.7 23.9-65 0-120-43.8-139.6-102.9l-81.3 61.9C69.7 445.7 154.4 492 249 492z"/>
            <path fill="#FBBC05" d="M109.4 290.6c-4.9-15-7.6-31-7.6-47.6s2.7-32.6 7.6-47.6l-81.3-61.9C10.1 170.4 0 217.6 0 265.7s10.1 95.3 28.1 135.1l81.3-61.9z"/>
            <path fill="#EA4335" d="M249 97.6c36.7 0 69.5 12.7 95.3 37.5l71.2-71.2C372.8 23.4 316.3 0 249 0 154.4 0 69.7 46.3 28.1 130.7l81.3 61.9C129 141.4 184 97.6 249 97.6z"/>
          </svg>
          
          Continue with Google
        </a>
      </div>

      <!-- Continue with Email Button -->
      <div class="d-grid mb-3">
        <button class="border border-dark fs-6 btn btn-light-blue rounded-pill py-2 d-flex align-items-center justify-content-center"
                type="button" data-bs-toggle="collapse" data-bs-target="#collapseEmail"
                aria-expanded="false" aria-controls="collapseEmail">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
               role="img" aria-label="Email" class="me-2">
            <rect x="2" y="5" width="20" height="14" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="1.6"/>
            <path d="M3 7.5l8.5 6L20.5 7.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Continue with Email
        </button>
      </div>

      <!-- Accordion Collapse Section -->
      <div class="accordion mb-3 border-0" id="accordionExample">
        <div class="accordion-item border-0">
          <div id="collapseEmail" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body" style="background-color:#ebf5fb;">
              
              <!-- Email -->
              <div class="mb-3">
                <label for="EmailAddress" class="form-label">Email address</label>
                <input name="txtUserEmail" type="email" class="form-control" id="EmailAddress" placeholder="Enter email" required>
              </div>

              <!-- Password -->
              <div class="mb-3">
                <label for="Password" class="form-label">Password</label>
                <input name="txtUserPassword" type="password" class="form-control" id="Password" placeholder="Enter password" required>
              </div>

              <!-- Login Button -->
              <div class="d-grid mb-3">
                <input type="submit" value="Log in" class="rounded-pill py-2 btn btn-primary">
              </div>

              <hr>

              <!-- Register -->
              <p class="text-start mb-1 fs-6 fw-bold">Are you new here?</p>

              <!-- Register with Email -->
              <div class="d-grid mb-3">
                <a href="<?=site_url('Properties/join');?>" class="border border-dark fs-6 btn btn-light-blue rounded-pill py-2 d-flex align-items-center justify-content-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="me-2">
                    <rect x="2" y="5" width="20" height="14" rx="2" ry="2" fill="none" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M3 7.5l8.5 6L20.5 7.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  Register with Email
                </a>
              </div>

            </div>
          </div>
        </div>
      </div>


      

    </div>
      <div class="form-check w-100 pb-2">
        <input class="custom-checkbox me-3" type="checkbox" id="agree">
        <label for="agree">I have read and I agree to the Real State.com <br> <a href="#">Terms and Conditions</a></label>
      </div>
  </div>
</div>
<?php echo form_close(); ?>



<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
  
</body>
</html>