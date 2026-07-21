<?php
defined('BASEPATH') or exit('No direct script access allowed');

$UserId = $this->session->userdata('user_id');
$UserName = $this->session->userdata('user_name');

$arrProperties = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', '*', "WHERE ClientId = '$UserId'");

$Message_Box = false;
if (empty($arrProperties)) {
    $Message_Box = true;
}


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
        <?php $this->load->view('components/header', ['ListingPages' => 'no']); ?>
    </div>

    <div class="p-0">
    <div class="property-section w-100">
        <section class="container pb-3 mt-5">

            <!-- Empty message -->
            <div class="<?= ($Message_Box) ? 'd-block' : 'd-none' ?> pb-2 text-center">
                <h5>There are no properties</h5>
            </div>

            <!-- Listing title -->
            <div class="<?= ($Message_Box) ? 'd-none' : 'd-block' ?> pb-2 text-center">
                <h5>All Listings</h5>
            </div>

            <?php if (!$Message_Box) { ?>
                <div class="row">

                    <?php foreach ($arrProperties as $key => $value) {

                        $PropertyId     = $value->PropertyId ?? '';
                        $IsDeleted      = $value->IsDeleted ?? 0;
                        $PropertyTitle  = $value->PropertyTitle ?? "Property Title";
                        $PropertyTypeId = $value->PropertyTypeId ?? '';
                        $ListType       = $value->ListType ?? "Sale";
                        $TotalPrice     = $value->TotalPrice ?? "0";
                        $MailingAddress = $value->MailingAddress ?? "Mailing Address";
                        $CoveredArea    = $value->CoveredArea ?? "0";
                        $AreaUnitId     = $value->AreaUnitId ?? "1";
                        $AddedOn        = $value->AddedOn ? date('d - M - Y', strtotime($value->AddedOn)) : "";

                        $PropertyFeatures = $this->getlist_model
                            ->getFieldsMultipleConditions('tbl_properties_features', 'Bedrooms, Bathrooms', "WHERE PropertyId = '$PropertyId'", 2);

                        $Bedrooms  = $PropertyFeatures->Bedrooms  ?? "0";
                        $Bathrooms = $PropertyFeatures->Bathrooms ?? "0";

                        $AreaUnit = ["Sqft", "Sqyd", "Kanal", "Marla"][$AreaUnitId - 1];

                        $ImageName = $this->getlist_model->getFieldsMultipleConditions(
                            'tbl_property_media',
                            'FileName',
                            "WHERE PropertyId = '$PropertyId'",
                            1
                        );
                    ?>

                        <!-- CARD -->
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="property-item rounded overflow-hidden border shadow-sm">

                                <!-- IMAGE -->
                                <div class="position-relative">
                                    <img class="img-fluid w-100" 
                                         style="height:230px;object-fit:cover;" 
                                         src="<?= base_url('uploads/Properties/' . $PropertyId . '/images/' . $ImageName); ?>">
                                </div>

                                <!-- CONTENT -->
                                <div class="p-3">
                                    <h5 class="text-dark mb-2">$<?= number_format($TotalPrice); ?></h5>
                                    <p class="text-dark h6 mb-2"><?= $PropertyTitle; ?></p>

                                    <p class="text-muted small mb-1">
                                        <i class="fa-solid fa-paperclip me-1"></i><?= $AddedOn; ?>
                                    </p>

                                    <?php
                                      $words = explode(' ', $MailingAddress);

                                      if (count($words) > 5) {
                                          // Keep only first 5 words
                                          $displayAddress = implode(' ', array_slice($words, 0, 5)) . ".......";
                                      } else {
                                          // Show full address if 5 or fewer words
                                          $displayAddress = $MailingAddress;
                                      }
                                      ?>
                                      <p class="text-dark">
                                          <i class="fa fa-map-marker-alt text-dark me-2"></i>
                                          <?= $displayAddress; ?>
                                      </p>

                                    <!-- BUTTONS -->
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-primary btn-sm" href="<?= site_url('Properties/PropertyDetails/' . $PropertyId); ?>">Details</a>
                                        <a class="btn btn-info btn-sm text-white" href="<?= site_url('Properties/AddListing/' . $PropertyId . '/Edit'); ?>">Edit</a>
                                    </div>
                                </div>

                                <!-- FEATURES -->
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2">
                                        <i class="fa fa-ruler-combined text-primary me-2"></i><?= $CoveredArea . ' ' . $AreaUnit; ?>
                                    </small>
                                    <small class="flex-fill text-center border-end py-2">
                                        <i class="fa fa-bed text-primary me-2"></i><?= $Bedrooms; ?>
                                    </small>
                                    <small class="flex-fill text-center py-2">
                                        <i class="fa fa-bath text-primary me-2"></i><?= $Bathrooms; ?>
                                    </small>
                                </div>

                            </div>
                        </div>

                    <?php } // end foreach ?>
                </div> <!-- end row -->
            <?php } ?>

        </section>
    </div>
</div>


    </div>
    <?php $this->load->view('components/footer.php');
     $this->load->view('components/js_links.php'); ?>

    <script type="text/javascript">
        tippy('.tooltipBtn');
        // Function to generate tooltip content with separate CSS classes for value and unit
        function generateTooltipContent(value, unit) {
            value = parseFloat(value);
            // if (isNaN(value)) {
            //   return "Invalid Value";
            // }

            let kanal, marla, sqft, sqyd;
            let content = '';

            // Conversion logic based on the unit
            switch (unit) {
                case "Sqft":
                    kanal = value / 5445;
                    marla = value / 225;
                    sqyd = value * 0.11111;
                    content = `
              <span class="tooltip-unit">Kanal = </span><span class="tooltip-value">${kanal.toFixed(2)}</span><br>
              <span class="tooltip-unit">Marla = </span><span class="tooltip-value">${marla.toFixed(2)}</span><br>
              <span class="tooltip-unit">Sqyd = </span><span class="tooltip-value">${sqyd.toFixed(2)}</span>`;
                    break;
                case "Kanal":
                    sqft = value * 5445;
                    marla = value * 20;
                    sqyd = value * 605;
                    content = `
              <span class="tooltip-unit">Sqft = </span><span class="tooltip-value">${sqft.toFixed(2)}</span><br>
              <span class="tooltip-unit">Marla = </span><span class="tooltip-value">${marla.toFixed(2)}</span><br>
              <span class="tooltip-unit">Sqyd = </span><span class="tooltip-value">${sqyd.toFixed(2)}</span>`;
                    break;
                case "Marla":
                    kanal = value * 0.05;
                    sqft = value * 272.25;
                    sqyd = value * 30.25;
                    content = `
              <span class="tooltip-unit">Kanal = </span><span class="tooltip-value">${kanal.toFixed(2)}</span><br>
              <span class="tooltip-unit">Sqft = </span><span class="tooltip-value">${sqft.toFixed(2)}</span><br>
              <span class="tooltip-unit">Sqyd = </span><span class="tooltip-value">${sqyd.toFixed(2)}</span>`;
                    break;
                case "Sqyd":
                    kanal = value * 0.00165;
                    marla = value * 0.04;
                    sqft = value * 9;
                    content = `
              <span class="tooltip-unit">Sqft = </span><span class="tooltip-value">${sqft.toFixed(2)}</span><br>
              <span class="tooltip-unit">Marla = </span><span class="tooltip-value">${marla.toFixed(2)}</span><br>
              <span class="tooltip-unit">Kanal = </span><span class="tooltip-value">${kanal.toFixed(2)}</span>`;
                    break;
                default:
                    return "Invalid Unit";
            }

            // Return the formatted content with separate classes
            return content;
        }

        // Initialize tooltips for each element with .tooltipBtn class
        const buttons = document.querySelectorAll('.tooltipBtn');
        buttons.forEach(button => {
            const value = button.getAttribute("value");
            const unit = button.getAttribute("data-unit");

            tippy(button, {
                content: generateTooltipContent(value, unit),
                allowHTML: true, // Allow HTML to be rendered inside the tooltip
                interactive: true,
                placement: 'bottom',
                theme: 'own',
                followCursor: 'horizontal',
                duration: [200, 500],
            });
        });
    </script>

</body>
<style>
    /*.page-titles {
        padding: 0.9375rem 1.875rem;
        background: #fff;
        margin-bottom: 1.875rem;
        border-radius: 0.5rem;
        margin-top: 0;
        margin-left: 0;
        margin-right: 0;
    }

    .page-titles .breadcrumb {
        margin-bottom: 0;
        padding: 0;
        background: transparent;
        font-size: 0.875rem;
    }

    .dropdown-menu .dropdown-item.active,
    .dropdown-menu .dropdown-item:active {
        color: #0B1D8A;
        background: rgba(59, 76, 184, 0.04);
        ;
    }

    .dropdown-menu .dropdown-item {
        color: #7e7e7e;
        padding: 0.5rem 1.75rem;
        text-align: left;
    }*/
</style>

</html>