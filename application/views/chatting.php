<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$arrProperties = $this->getlist_model->getFieldsMultipleConditions('tbl_properties','*',"WHERE PropertyTypeId > 0 ORDER BY PropertyId DESC LIMIT 0,12");

$Message_Box = 'd-none';

if (empty($arrProperties)) {
  $Message_Box = 'd-block';
}

$StationId = $this->session->userdata('user_station');

$PropertyDetails = $this->getlist_model->getFieldsMultipleConditions('tbl_properties','*',"WHERE PropertyId = '$PropertyId'", 2);
$SellerDetails = $this->getlist_model->getFieldsMultipleConditions('clients_view','*',"WHERE ClientId = '$SellerId'", 2);
$BuyerDetails = $this->getlist_model->getFieldsMultipleConditions('clients_view','*',"WHERE ClientId = '$BuyerId'", 2);

$data = array();
$data['IsRead'] = 1;
$this->db->where('InspectionId',$InspectionId)->update('tbl_properties_messages', $data);

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


    <div class="container py-4" style="max-width: 1000px; height: 90vh;">
  
      <!-- Chat Header -->
      <div class="card shadow border-0 rounded-3 mb-3">
        <div class="card-body d-flex flex-column flex-md-row gap-4 justify-content-between">
          
          <!-- Seller Info -->
          <div class="d-flex align-items-center mb-2 mb-md-0">
            <i class="bi bi-person-circle fs-2 text-primary me-3"></i>
            <div>
              <h6 class="mb-0 fw-bold"><?= $SellerDetails->ClientName ?> <span class="badge bg-primary">Seller</span></h6>
              <small class="text-muted align-items-center d-flex"><i class="bi bi-envelope me-1"></i> <?= $SellerDetails->EmailAddress ?></small>
            </div>
          </div>

          <!-- Buyer Info -->
          <div class="d-flex align-items-center mb-2 mb-md-0">
            <i class="bi bi-person-circle fs-2 text-secondary me-3"></i>
            <div>
              <h6 class="mb-0 fw-bold"><?= $BuyerDetails->ClientName ?> <span class="badge bg-secondary">Buyer</span></h6>
              <small class="text-muted align-items-center d-flex"><i class="bi bi-envelope me-1"></i> <?= $BuyerDetails->EmailAddress ?></small>
            </div>
          </div>

          <!-- Property Info -->
          <div class="text-md-end">
            <h6 class="mb-0 fw-bold"><?= $PropertyDetails->PropertyTitle ?></h6>
            <small class="d-block text-muted"><i class="bi bi-geo-alt me-1"></i> <?= $PropertyDetails->MailingAddress ?></small>
            <small class="fw-semibold text-success"><i class="bi bi-currency-dollar text-dark"></i> <?= number_format($PropertyDetails->TotalPrice) ?></small>
          </div>
        </div>
      </div>

      <!-- Chat Body -->
      <div class="card shadow border-0 rounded-3 d-flex flex-column" style="height: calc(100% - 120px);">
        <div class="card-body overflow-auto px-3" id="chatBox">

          <div id="messages-area">
            <!-- all messages will load here -->
          </div>

        </div>

        <!-- Chat Input -->
        <div class="card-footer bg-white border-0 p-2">
          <form id="chat-form" class="d-flex align-items-center">
            <input name="message" reqiured type="text" class="form-control rounded-pill me-2" placeholder="Type a message...">
            <!-- +InspectionId+"/"+SellerId+"/"+BuyerId -->
            <input type="hidden" name="InspectionId" value="<?= $InspectionId ?>">
            <input type="hidden" name="SellerId" value="<?= $SellerId ?>">
            <input type="hidden" name="BuyerId" value="<?= $BuyerId ?>">
            <button class="btn btn-primary rounded-circle">
              <i class="bi bi-send-fill"></i>
            </button>
          </form>
        </div>
      </div>
    </div>



  </div>

  

	 
  <?php
  $this->load->view('components/footer.php');
  $this->load->view('components/js_links.php');
  ?>


  <script type="text/javascript">
    
    const InspectionId = <?= $InspectionId ?>;
    const SellerId = <?= $SellerId ?>;
    const BuyerId = <?= $BuyerId ?>;
    
    function fetchMessages() {
      $.get("<?= site_url('Properties/fetch_messages/') ?>"+ "/" + InspectionId, function(data) {
        $('#messages-area').html(data);
        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight); // auto scroll
      });
    }

    // Send message via AJAX
    $('#chat-form').submit(function(e) {
      e.preventDefault();

      let message = $('input[name="message"]').val();
      if(!message){
        alert('Empty cannot be sent!');
        return;
      }

      $.ajax({
          url: "<?= site_url('Properties/send_message') ?>",
          type: "POST",
          data: $(this).serialize(),
          dataType: "json",
          success: function(response) {
              if (response.Status === false) {
                  console.log(response.Message);
              } else {
                  console.log(response.Message);
                  $('input[name="message"]').val(''); // clear input
                  fetchMessages(); // refresh messages
              }
          }
      });

    });

    // Load messages initially and start polling
    // Load messages every 2 seconds
    fetchMessages();
    setInterval(fetchMessages, 2000);
  </script>

	
</body>
</html>
