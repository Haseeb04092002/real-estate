<div id="divFunctions">
</div>

<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

<script type="text/javascript">
$(document).ready(function(){

    var base_url = "<?php echo base_url();?>" ;
    $("#divFunctions").load(base_url+'Home/LoadFunctions');

});
</script>


<!-- Footer Start -->
<div class="d-none container-fluid bg-dark text-white-50 footer pt-5 mt-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
                <h5 class="text-white mb-4">Get In Touch</h5>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <h5 class="text-white mb-4">Quick Links</h5>
                <a class="btn btn-link text-white-50" href="">About Us</a>
                <a class="btn btn-link text-white-50" href="<?= site_url('Properties/contact'); ?>">Contact Us</a>
                <a class="btn btn-link text-white-50" href="">Our Services</a>
                <a class="btn btn-link text-white-50" href="<?= site_url('Properties/PrivacyPolicy'); ?>">Privacy Policy</a>
                <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <h5 class="text-white mb-4">Newsletter</h5>
                <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                <div class="position-relative mx-auto" style="max-width: 400px;">
                    <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                    <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">RealEstate</a>, All Right Reserved.
                    Designed By <a class="border-bottom" href="https://jauntsolutions.com/">Jaunts Solutions</a>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href="">Home</a>
                        <a href="">Cookies</a>
                        <a href="">Help</a>
                        <a href="">FAQs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->



<footer class="d-none bg-dark text-light py-5">
  <div class="container-fluid py-3 px-5">
    <!-- Social Icons and Menu Links -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center border-bottom pb-3">
      <div class="mb-3 mb-md-0">
        <a href="#" class="text-reset me-3"><i class="bi bi-facebook fs-4"></i></a>
        <a href="#" class="text-reset me-3"><i class="bi bi-twitter fs-4"></i></a>
        <a href="#" class="text-reset me-3"><i class="bi bi-pinterest fs-4"></i></a>
        <a href="#" class="text-reset me-3"><i class="bi bi-linkedin fs-4"></i></a>
        <a href="#" class="text-reset"><i class="bi bi-youtube fs-4"></i></a>
      </div>
      <div class="d-flex flex-wrap justify-content-center gap-4 small">
        <a href="<?= site_url('Properties/PrivacyPolicy'); ?>" class="fs-5 text-reset">Privacy Policy</a>
        <a href="#" class="fs-5 text-reset">Contact us</a>
        <a href="#" class="fs-5 text-reset">Ignite</a>
        <a href="#" class="fs-5 text-reset">Agent admin</a>
        <a href="#" class="fs-5 text-reset">Media sales</a>
        <a href="#" class="fs-5 text-reset">Legal</a>
        <a href="#" class="fs-5 text-reset">Privacy settings</a>
        <a href="#" class="fs-5 text-reset">Privacy centre</a>
        <a href="#" class="fs-5 text-reset">Site map</a>
        <a href="#" class="fs-5 text-reset">Careers</a>
      </div>
    </div>

    <!-- Company Logos -->
    <div class="d-flex flex-wrap align-items-center gap-5 py-4 border-bottom">
      <div class="d-flex h6 align-items-center gap-1">
        <i class="bi bi-house-door-fill text-light"></i>
        <span class="text-muted">REA Group</span>
      </div>
      <div class="d-flex h6 align-items-center gap-1 text-primary">
        <i class="bi bi-globe2 text-light"></i>
        <span class="text-muted">realestate.com.au</span>
      </div>
      <div class="d-flex h6 align-items-center gap-1 text-primary">
        <i class="bi bi-building text-light"></i>
        <span class="text-muted">realcommercial.com.au</span>
      </div>
      <div class="d-flex h6 align-items-center gap-1 text-dark">
        <i class="bi bi-circle-fill text-light"></i>
        <span class="text-muted">PropTrack</span>
      </div>
      <div class="d-flex h6 align-items-center gap-1 text-dark">
        <i class="bi bi-box-seam text-light"></i>
        <span class="text-muted">Flatmates</span>
      </div>
      <div class="d-flex h6 align-items-center gap-1 text-info">
        <i class="bi bi-piggy-bank text-light"></i>
        <span class="text-muted">Mortgage Choice</span>
      </div>
      <div class="d-flex h6 align-items-center gap-1 text-danger">
        <i class="bi bi-house-heart-fill text-light"></i>
        <span class="text-muted">property</span>
      </div>
    </div>

    <!-- International and Partner Sites -->
    <div class="py-4">
      <!-- <p class="mb-1 fw-bold  fs-4 text-light">International sites</p>
      <p class="mb-2 ">
        <a href="#" class="text-reset me-2">India</a> |
        <a href="#" class="text-reset mx-2">United States</a> |
        <a href="#" class="text-reset ms-2">International properties</a>
      </p>

      <p class="mb-1 fw-bold  fs-4 text-light">Partner sites</p>
      <p class="mb-2 ">
        <a href="#" class="text-reset me-2">news.com.au</a> |
        <a href="#" class="text-reset mx-2">foxsports.com.au</a> |
        <a href="#" class="text-reset mx-2">Mansion Global</a> |
        <a href="#" class="text-reset mx-2">askizzy.org.au</a> |
        <a href="#" class="text-reset ms-2">proptiger.com</a>
      </p>
      <hr>
 -->      <!-- Footer Note -->
      <p class="mt-4 text-muted">
        realestate.com.au is owned and operated by ASX-listed REA Group Ltd (REA:ASX) © REA Group Ltd.
        By accessing or using our platform, you agree to our
        <a href="#" class="text-decoration-underline text-reset">Terms of Use</a>.
      </p>
    </div>
  </div>
</footer>




<!-- Back to Top -->
<a href="#" class="border border-2 rounded-circle border-light btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa-solid fa-arrow-up"></i></a>