<head>

  <?php

  $this->load->view('components/header_meta');
  $this->load->view('components/css_links');
  $UserId = $this->session->userdata('user_id');
  $UserName = $this->session->userdata('user_name');

  $side_menu = 'd-none';
  if ($ListingPages == 'yes') {
    $side_menu = 'd-block';
  }

  ?>
  <style>
    /* Navbar link underline animation */
    .navbar-nav .nav-link {
      position: relative;
      transition: color 0.3s ease;
    }

    .navbar-nav .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 5px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #1F509A;
      transition: width 0.3s ease;
    }

    .navbar-nav .nav-link:hover::after,
    .navbar-nav .nav-link.active::after {
      width: 80%;
    }
  </style>

</head>

<!-- Global Loader -->
<div id="global-loader" class="d-none justify-content-center align-items-center position-fixed w-100 h-100 bg-white"
  style="top: 0; left: 0; z-index: 9999; opacity: 0.8;">
  <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>

<!-- Navbar Start -->
<div class="container-fluid nav-bar bg-transparent" style="position: sticky; top: 0;">
  <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
    <a href="<?= site_url('Properties'); ?>" class="navbar-brand d-flex align-items-center text-center">
      <div class="p-1 me-2">
        <img class="img-fluid" src="<?= base_url('assets/images/Fre-logo.png'); ?>" alt="Icon"
          style="width: 65px; height: 50px; object-fit: contain;">
      </div>
      <div>
        <h1 style="color: #1F509A; font-size: 2rem; line-height: 1;" class="m-0 navbar-h1">Free Real Estate</h1>
        <span
          style="font-size: 0.9rem; color: #6c757d; font-weight: 600; display: block; text-align: left; padding-left: 2px; letter-spacing: 1px;">Australia</span>
      </div>
    </a>
    <button class="<?= $side_menu; ?> btn btn-primary d-block d-lg-none" type="button" data-bs-toggle="offcanvas"
      data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">Menu</button>
    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto align-items-center">
        <?php
        $class = $this->router->fetch_class();
        $method = $this->router->fetch_method();
        ?>
        <a href="<?= site_url('Properties'); ?>"
          class="nav-item nav-link <?= ($class == 'Properties' && ($method == 'index' || $method == 'Home')) ? 'active' : ''; ?>">Home</a>
        <a href="<?= site_url('Properties/news_details'); ?>"
          class="nav-item nav-link <?= ($method == 'news_details') ? 'active' : ''; ?>">News</a>
        <a href="<?= site_url('Properties/map'); ?>"
          class="nav-item nav-link <?= ($method == 'map') ? 'active' : ''; ?>">Map</a>


        <a href="<?= site_url('Properties/contract'); ?>"
          class="nav-item nav-link <?= ($method == 'contract') ? 'active' : ''; ?>">Contract</a>

        <?php if ($UserId > 0): ?>
          <a href="<?= site_url('Properties/user_dashboard'); ?>"
            class="nav-item nav-link <?= ($method == 'user_dashboard') ? 'active' : ''; ?>"><i
              class="mx-1 fa-solid fa-user"></i><?= $UserName; ?></a>
          <a href="<?= site_url('Properties/AddListing'); ?>"
            class="nav-item nav-link <?= ($method == 'AddListing') ? 'active' : ''; ?>">Post Property</a>
          <a href="<?= site_url('Admin/login'); ?>"
            class="nav-item nav-link <?= ($class == 'Admin') ? 'active' : ''; ?>">Admin</a>
          <a href="<?= site_url('Login/Logout'); ?>" class="nav-item nav-link">Logout</a>
        <?php else: ?>
          <a href="<?= site_url('Admin/login'); ?>"
            class="nav-item nav-link <?= ($class == 'Admin') ? 'active' : ''; ?>">Admin</a>
          <a href="<?= site_url('Properties/signin'); ?>"
            class="nav-item nav-link <?= ($method == 'signin') ? 'active' : ''; ?>">Sign in</a>
        <?php endif; ?>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Calculator">
          Calculator
        </button>

        <!-- Area Unit Converter Modal -->
        <div style="z-index: 99999999999999999999;" class="modal fade" id="Calculator"
          aria-labelledby="CalculatorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">

              <!-- Header -->
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">
                  <i class="bi bi-calculator me-2"></i>
                  Area Unit Converter
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>

              <!-- Body -->
              <div class="modal-body">

                <form id="areaConverterForm">

                  <!-- Area -->
                  <div class="mb-3">
                    <label class="form-label fw-semibold">
                      Enter Area
                    </label>
                    <div class="input-group">
                      <span class="input-group-text">
                        <i class="bi bi-rulers"></i>
                      </span>
                      <input type="number" class="form-control" name="area" placeholder="Enter Area" step="any"
                        required>
                    </div>
                  </div>

                  <!-- From Unit -->
                  <div class="mb-3">
                    <label class="form-label fw-semibold">
                      From Unit
                    </label>
                    <select class="form-select" name="from_unit">
                      <option value="sqft">Square Feet (Sq Ft)</option>
                      <option value="sqyd">Square Yard (Sq Yd)</option>
                      <option value="marla">Marla</option>
                      <option value="kanal">Kanal</option>
                    </select>
                  </div>

                  <!-- To Unit -->
                  <div class="mb-4">
                    <label class="form-label fw-semibold">
                      To Unit
                    </label>
                    <select class="form-select" name="to_unit">
                      <option value="sqft">Square Feet (Sq Ft)</option>
                      <option value="sqyd">Square Yard (Sq Yd)</option>
                      <option value="marla">Marla</option>
                      <option value="kanal">Kanal</option>
                    </select>
                  </div>

                  <!-- Buttons -->
                  <div class="d-flex justify-content-center align-items-center gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                      <i class="bi bi-arrow-repeat me-2"></i>
                      Convert
                    </button>

                    <button id="resetBtn" type="reset" class="btn btn-outline-secondary w-100">
                      <i class="bi bi-arrow-counterclockwise me-2"></i>
                      Reset
                    </button>
                  </div>

                </form>

                <!-- Result -->
                <div class="card bg-light mt-4 border-0">
                  <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Converted Result</h6>

                    <h3 class="fw-bold text-primary mb-0" id="result">
                      0.00
                    </h3>
                  </div>
                </div>

              </div>

              <!-- Footer -->
              <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                  Close
                </button>
              </div>

            </div>
          </div>
        </div>
      </div>

  </nav>
</div>
<!-- Navbar End -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Your DOM manipulation code goes here
    console.log("The DOM is fully loaded and ready!");
    $('#areaConverterForm').submit(function (e) {

      var base_url = "<?= base_url(); ?>";
      console.log(base_url);
      base_url + "Calculator/calculator";
      console.log(base_url + "Calculator/calculator");

      e.preventDefault();

      $.ajax({
        url: base_url + "Calculator/calculator",
        type: 'POST',
        data: $(this).serialize(),
        success: function (res) {

          $('#result').html(res);

          console.log(res);
        },
        error: function (xhr) {
          console.log(xhr.responseText);
        }
      });

    });

    $('#resetBtn').on('click', function () {
      $('#result').html('0.00');
      $('#areaConverterForm').trigger('reset');
    });

  });

</script>

<div id="registration-modal">
  <!-- signin modal -->
  <div class="modal fade mt-5" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <?= form_open('Login'); ?>
        <div class="pt-3 d-flex justify-content-end container-fluid">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex flex-column align-items-center justify-content-center container-fluid">
          <a href="<?= site_url('Properties/Home'); ?>" class="navbar-brand d-flex align-items-center text-center mb-3">
            <div class="icon p-2 me-2">
              <img class="img-fluid" src="<?= base_url('assets/images/Fre-logo.png'); ?>" alt="Icon"
                style="width: 40px; height: 40px; object-fit: contain;">
            </div>
            <div>
              <h1 style="color: #1F509A; line-height: 1;" class="m-0">Free Real Estate</h1>
              <span
                style="font-size: 0.8rem; color: #6c757d; font-weight: 600; display: block; text-align: left; padding-left: 2px; letter-spacing: 1px;">Australia</span>
            </div>
          </a>
          <h3 class="mb-4">Sign in</h3>
          <input class="modal-input ps-2 mb-3 w-100" name="UserEmail" type="email" placeholder="Email*" required>
          <input class="modal-input ps-2 mb-3 w-100" type="password" name="UserPass1" placeholder="Password*" required>
          <input class="modal-log mb-3 w-100" style="color:white;background-color: #1F509A;" type="submit"
            value="Continue">
          <div class="modal-forget w-100 pb-3">
            <div class="d-flex align-items-center">
              <input class="custom-checkbox me-3" type="checkbox" name="Remember Me" id=""> Remember Me
            </div>
            <p><a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop3" data-bs-dismiss="modal"
                style="color: #1F509A;">Forgot Password?</a></p>
          </div>
          <p class="modal-p2 pb-2">Are you new to Real Estate?
            <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop2" data-bs-dismiss="modal"
              style="color: #1F509A;">Sign Up</a>
          </p>
          <!--  <button class="modal-btn w-100" data-bs-toggle="modal" data-bs-target="#staticBackdrop2" data-bs-dismiss="modal">
            Sign Up
          </button> -->
          <p class="modal-p fw-bold" style="color:black;">OR</p>
          <button class="modal-btn mb-3 w-100">
            <i class="fa-brands fa-facebook" style="color: blue;"></i> Continue with Facebook
          </button>
          <button class="modal-btn w-100">
            <i class="fa-brands fa-google"></i> Continue with Google
          </button>
        </div>
        <?= form_close(); ?>
      </div>
    </div>
  </div>


  <!-- signup modal  -->

  <div class="modal fade mt-5" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <?= form_open('Register/RegisterUser'); ?>
        <div class="pt-3 d-flex justify-content-start container-fluid">
          <button class="btn btn-link text-decoration-none fs-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
            data-bs-dismiss="modal">
            <i class="fa-solid fa-chevron-left"></i>
          </button>
        </div>
        <div class="modal-body d-flex flex-column align-items-center justify-content-center container-fluid">
          <button class="modal-btn mb-3 w-100">
            <i class="fa-brands fa-facebook" style="color: blue;"></i> Continue with Facebook
          </button>
          <button class="modal-btn w-100">
            <i class="fa-brands fa-google"></i> Continue with Google
          </button>
          <p class="modal-p">OR</p>

          <!-- method2 -->
          <!-- <input class="modal-input ps-2 mb-3 w-100" name="txtUserName" type="text" value="<?= ($PropertyTitle ?? ''); ?>" placeholder="UserName*" required> -->

          <?= form_input(['name' => 'FullName', 'class' => 'modal-input ps-2 mb-3 w-100', 'type' => 'text', 'placeholder' => 'Full Name*', 'required' => 'required']); ?>
          <?= form_input(['name' => 'UserEmail', 'class' => 'modal-input ps-2 mb-3 w-100', 'type' => 'email', 'placeholder' => 'Email*', 'required' => 'required']); ?>
          <?= form_input(['name' => 'UserPass1', 'class' => 'modal-input ps-2 mb-3 w-100', 'type' => 'password', 'placeholder' => 'Password*', 'required' => 'required']); ?>
          <?= form_input(['name' => 'UserPass2', 'class' => 'modal-input ps-2 mb-3 w-100', 'type' => 'password', 'placeholder' => 'Confirm Password*', 'required' => 'required']); ?>




          <!-- <input class="modal-input ps-2 mb-3 w-100" type="email" placeholder="Email*" required>
          <input class="modal-input ps-2 mb-3 w-100" type="password" name="" placeholder="Password*" required>
          <input class="modal-input ps-2 mb-3 w-100" type="password" name="" placeholder="Confirm Password*" required> -->
          <!-- <input class="modal-input ps-2 mb-3 w-100" type="text" placeholder="Name*" required> -->
          <div class="phone-input-container modal-input w-100 ps-2 mb-3 d-flex align-items-center">
            <div class="flag-icon">PK</div>
            <span class="country-code">+61</span>

            <?= form_input(['name' => 'UserPhone', 'class' => 'phone-input', 'type' => 'number', 'placeholder' => 'Enter your phone number', 'required' => 'required']); ?>

            <!-- <input class="phone-input" type="tel" placeholder="Enter your phone number"> -->

          </div>
          <div class="modal-check w-100 pb-3">
            <input class="custom-checkbox me-3" type="checkbox" name="Remember Me" id="">
            <p>I have read and I agree to the Real State.com <br> <a href="#">Terms and Conditions</a></p>
          </div>
          <?= form_submit('mysubmit', 'Continue', "class='modal-btn w-100'"); ?>
          <!-- <input type="submit" value="Continue" class="modal-btn w-100"> -->
        </div>
        <?= form_close(); ?>
      </div>
    </div>
  </div>
  <!-- forgot password modal -->
  <!-- <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="pt-3 d-flex justify-content-start container-fluid">
          <button class="btn btn-link text-decoration-none fs-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-bs-dismiss="modal">
            <i class="fa-solid fa-chevron-left"></i>
          </button> 
        </div>
        <p class="text-center fw-bold">FORGOT PASSWORD</p>
        <div class="modal-body d-flex flex-column align-items-center justify-content-center container-fluid">
          <input class="modal-input ps-2 mb-3 w-100" type="email" placeholder="Email*" required>
          <button class="modal-btn w-100">Send</button>
        </div>
      </div>
    </div>
  </div> -->
</div>