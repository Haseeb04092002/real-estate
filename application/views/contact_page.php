<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$arrProperties = $this->getlist_model->getFieldsMultipleConditions('tbl_properties','*',"WHERE PropertyTypeId > 0 ORDER BY PropertyId DESC LIMIT 0,12");

$Message_Box = 'd-none';

if (empty($arrProperties)) {
  $Message_Box = 'd-block';
}

$StationId = $this->session->userdata('user_station');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<?php
  $this->load->view('components/header_meta');
  $this->load->view('components/css_links');
  ?>

</head>
<body>

  <div class="container-fluid bg-white p-0">

    <?php $this->load->view('components/header', ['ListingPages'=>'no']); ?>


    <section data-aos="zoom-in-up" data-aos-offset="200" data-aos-delay="50" data-aos-duration="1000" id="client" class="container py-5" style="max-width: 90%;">
      <div class="row justify-content-center align-items-center">
        <div class="col-lg-8 rounded-4 p-5 shadow-lg text-light">
          <h2 class="text-center text-dark mb-4 fw-bold">Get in Touch</h2>

          <?php if ($this->session->flashdata('msg')): ?>
            <div class="alert alert-warning text-center">
              <?= $this->session->flashdata('msg'); ?>
            </div>
          <?php endif; ?>

            


          <form method="post" action="<?= site_url('Contact/send_email'); ?>">
            <div class="row g-4">
              <div class="col-md-6">
                <input type="text" name="txtName" class="form-control form-control-lg bg-transparent text-dark border-dark" placeholder="Full Name" required
                  minlength="3"
                  maxlength="100"
                  pattern="[A-Za-z\s]+"
                  title="Name should contain only letters and spaces">
              </div>
              <div class="col-md-6">
                <input type="email" name="txtEmail" class="form-control form-control-lg bg-transparent text-dark border-dark" placeholder="Email Address" required
                  maxlength="150">
              </div>
              <div class="col-12">
                <textarea name="txtMessage" rows="6" class="form-control form-control-lg bg-transparent text-dark border-dark" placeholder="Your Message" required
                  minlength="10"
                  maxlength="1000"></textarea>
              </div>
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-outline-dark px-5 py-2 rounded-pill fw-semibold">Send Message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>



  </div>

  

	 
  <?php
  $this->load->view('components/footer.php');
  $this->load->view('components/js_links.php');
  ?>

	
</body>
</html>
