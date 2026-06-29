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


    <div class="container my-5">
    <div class="policy-section">
      <h1 class="mb-4 text-center text-primary">Privacy Policy</h1>

      <p>Effective Date: <?= date('F d, Y'); ?></p>

      <p>
        This Privacy Policy explains how <strong>Your Property Marketplace</strong> (“we”, “us”, or “our”) collects, uses, and discloses your information when you use our website or services related to buying, selling, and renting property in Australia.
      </p>

      <h4 class="mt-4">1. Information We Collect</h4>
      <ul>
        <li><strong>Personal Information:</strong> Name, email address, phone number, postal address, and ID verification details.</li>
        <li><strong>Property Details:</strong> Listings you post, search activity, enquiries, and saved properties.</li>
        <li><strong>Technical Data:</strong> IP address, browser type, operating system, device type, and usage statistics via cookies.</li>
        <li><strong>Location Data:</strong> Geolocation based on IP or device (if permission granted).</li>
      </ul>

      <h4 class="mt-4">2. How We Use Your Information</h4>
      <ul>
        <li>To provide and maintain our services.</li>
        <li>To communicate with you regarding listings, inquiries, and transactions.</li>
        <li>To improve site performance and enhance your user experience.</li>
        <li>To detect and prevent fraud, abuse, or illegal activity.</li>
        <li>To comply with Australian legal obligations.</li>
      </ul>

      <h4 class="mt-4">3. Sharing of Information</h4>
      <p>We do not sell your personal information. We may share your data with:</p>
      <ul>
        <li>Third-party service providers (e.g., payment gateways, email systems).</li>
        <li>Government or law enforcement agencies if required by law.</li>
        <li>Affiliated real estate agents or partners only with your consent.</li>
      </ul>

      <h4 class="mt-4">4. Cookies and Tracking</h4>
      <p>
        We use cookies to enhance site functionality, analyze traffic, and personalize content. You may disable cookies in your browser settings; however, some features may not function properly.
      </p>

      <h4 class="mt-4">5. Data Storage and Security</h4>
      <p>
        Your data is securely stored on Australian-based servers or trusted providers. We take reasonable steps to safeguard personal information using encryption, firewalls, and access control.
      </p>

      <h4 class="mt-4">6. Third-Party Links</h4>
      <p>
        Our website may contain links to third-party sites. We are not responsible for their privacy practices or content. Please read their privacy policies before engaging.
      </p>

      <h4 class="mt-4">7. Access and Correction</h4>
      <p>
        You may request access to your personal data or ask us to correct inaccurate information by contacting us at <a href="mailto:support@yourdomain.com">support@yourdomain.com</a>.
      </p>

      <h4 class="mt-4">8. Children’s Privacy</h4>
      <p>
        Our services are not intended for children under 16. We do not knowingly collect personal data from minors.
      </p>

      <h4 class="mt-4">9. International Transfers</h4>
      <p>
        If any data is transferred outside Australia, we ensure it is done in accordance with the Australian Privacy Principles (APPs).
      </p>

      <h4 class="mt-4">10. Changes to This Policy</h4>
      <p>
        We may update this Privacy Policy from time to time. Updates will be posted on this page with a revised effective date.
      </p>

      <h4 class="mt-4">11. Contact Us</h4>
      <p>
        For any questions or concerns regarding this Privacy Policy, please contact us at:
      </p>
      <ul>
        <li><strong>Email:</strong> <a href="mailto:support@yourdomain.com">support@yourdomain.com</a></li>
        <li><strong>Business Address:</strong> 123 Real Estate Ave, Sydney, NSW 2000, Australia</li>
      </ul>

      <p class="text-muted mt-5 mb-0 text-center">© <?= date('Y'); ?> Your Property Marketplace. All rights reserved.</p>
    </div>
  </div>



  </div>

  

	 
  <?php
  $this->load->view('components/footer.php');
  $this->load->view('components/js_links.php');
  ?>

	
</body>
</html>
