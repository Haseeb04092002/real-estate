<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$PropertyTypeId = $PropertyDetails->PropertyTypeId;
$AreaUnitId = $PropertyDetails->AreaUnitId??'1';
$UserId = $this->session->userdata('user_id');
$ClientId = $this->getlist_model->getFieldsMultipleConditions('tbl_properties','ClientId',"WHERE PropertyId = '$PropertyId'",1);

// echo "<pre>";
// print_r($PropertyDetails);
// die();

switch ($AreaUnitId) {
  case '1': $AreaUnit = 'Sqft'; break;
  case '2': $AreaUnit = 'Sqyd'; break;
  case '3': $AreaUnit = 'Kanal'; break;
  case '4': $AreaUnit = 'Marla'; break;
  default:  $AreaUnit = 'Sqft'; break;
}

$PropertyType = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_types','Title',"WHERE TypeId = '$PropertyTypeId'",1);
$PropertyFeatures = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_features', '*', "WHERE PropertyId = '$PropertyId'", 2);
if (!$PropertyFeatures) {
    $PropertyFeatures = new stdClass();
}

$DynamicFeaturesList = [];
$mappings = $this->db->select('m.FeatureValue, f.Title, f.InputType')
                     ->from('tbl_property_feature_mapping m')
                     ->join('tbl_properties_features_lists f', 'm.FeatureId = f.FeatureId')
                     ->where('m.PropertyId', $PropertyId)
                     ->get()->result();

// Known struct fields that we fetch directly from tbl_properties_features
$structTitles = [
    'bedrooms', 'bathrooms', 'built in year', 'year built', 
    'parking spaces', 'floors', 'kitchens', 'store rooms', 'servant quarters'
];

foreach($mappings as $m) {
    if(strtolower($m->Title) == 'garages') $PropertyFeatures->Garages = $m->FeatureValue;
    else if(strtolower($m->Title) == 'garage size sqft') $PropertyFeatures->GarageSize = $m->FeatureValue;
    else {
        // If it's a structural field, it's already in $PropertyFeatures from tbl_properties_features,
        // but if it's missing there, we can fall back to the mapping value.
        if (in_array(strtolower($m->Title), $structTitles)) {
            // Already handled via tbl_properties_features (or fallback if empty)
            if (strtolower($m->Title) == 'bedrooms' && empty($PropertyFeatures->Bedrooms)) $PropertyFeatures->Bedrooms = $m->FeatureValue;
            if (strtolower($m->Title) == 'bathrooms' && empty($PropertyFeatures->Bathrooms)) $PropertyFeatures->Bathrooms = $m->FeatureValue;
            if ((strtolower($m->Title) == 'built in year' || strtolower($m->Title) == 'year built') && empty($PropertyFeatures->BuiltInYear)) $PropertyFeatures->BuiltInYear = $m->FeatureValue;
        } else {
            if ($m->InputType == 'checkbox' && $m->FeatureValue == '1') {
                $DynamicFeaturesList[$m->Title] = true;
            } else if ($m->InputType != 'checkbox' && !empty($m->FeatureValue)) {
                $DynamicFeaturesList[$m->Title] = $m->FeatureValue;
            }
        }
    }
}
$arrProperties = $this->getlist_model->getFieldsMultipleConditions('tbl_properties','*',"WHERE PropertyTypeId > 0 ORDER BY PropertyId DESC LIMIT 0,6");

$Seller = $this->getlist_model->getFieldsMultipleConditions('tbl_clients', '*', "WHERE ClientId = '$ClientId'", 2);
if (!is_object($Seller)) {
    $Seller = new stdClass();
    $Seller->ClientName = 'System Admin';
    $Seller->ClientId = 0;
    $Seller->EmailAddress = 'admin@example.com';
    $Seller->PhoneNumber = '';
}

$SellerInitials = 'SA';
if (!empty($Seller->ClientName)) {
    $names = explode(' ', trim($Seller->ClientName));
    $SellerInitials = strtoupper($names[0][0]);
    if (isset($names[1])) {
        $SellerInitials .= strtoupper($names[1][0]);
    }
}

$Message_Box = 'd-none';

$UserId = $this->session->userdata('user_id');

$LoggedInUser = null;
if (!empty($UserId)) {
    $LoggedInUser = $this->getlist_model->getFieldsMultipleConditions('tbl_clients', '*', "WHERE ClientId = '$UserId'", 2);
}
$autoName  = $LoggedInUser ? htmlspecialchars($LoggedInUser->ClientName ?? '') : '';
$autoEmail = $LoggedInUser ? htmlspecialchars($LoggedInUser->EmailAddress ?? '') : '';
$autoPhone = $LoggedInUser ? htmlspecialchars($LoggedInUser->PhoneNumber ?? '') : '';
$autoReadonly = $LoggedInUser ? 'readonly' : '';

$IsFavourite = $this->getlist_model->getFieldsMultipleConditions(
  'tbl_properties_favourites',
  'IsFavourite',
  "WHERE PropertyId = '$PropertyId' AND UserId = '$UserId'",
  1
);

?>



<?php
$ImageNames = $this->getlist_model->getFieldsMultipleConditions(
    'tbl_property_media',
    'FileName',
    "WHERE PropertyId = '$PropertyId'"
);
if (!is_array($ImageNames) && !is_object($ImageNames)) {
    $ImageNames = [];
}

$PropertyImages = [];
$PropertyVideos = [];

if (is_array($ImageNames) || is_object($ImageNames)) {
    foreach ($ImageNames as $doc) {
        $ext = pathinfo($doc->FileName ?? '', PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), ['mp4', 'webm', 'ogg', 'mov'])) {
            $PropertyVideos[] = $doc;
        } else {
            $PropertyImages[] = $doc;
        }
    }
}

// Check if no images, add 3 dummies
if (empty($PropertyImages)) {
    $PropertyImages = [
        (object)['FileName' => 'dummy_img_1', 'is_dummy' => true, 'path' => base_url('assets/images/property-1.jpg')],
        (object)['FileName' => 'dummy_img_2', 'is_dummy' => true, 'path' => base_url('assets/images/property-2.jpg')],
        (object)['FileName' => 'dummy_img_3', 'is_dummy' => true, 'path' => base_url('assets/images/property-3.jpg')]
    ];
} else {
    foreach ($PropertyImages as &$img) {
        $img->is_dummy = false;
        $img->path = base_url('uploads/Properties/' . $PropertyId . '/images/' . ($img->FileName ?? ''));
    }
}

if (!empty($PropertyVideos)) {
    foreach ($PropertyVideos as &$vid) {
        $vid->is_dummy = false;
        $vid->path = base_url('uploads/Properties/' . $PropertyId . '/videos/' . ($vid->FileName ?? ''));
    }
}

$urlImage = $PropertyId;

$PropertyDocs = $this->db->select('d.*, t.DocumentTitle')
                         ->from('tbl_property_documents d')
                         ->join('tbl_property_document_types t', 'd.DocTypeId = t.DocTypeId', 'left')
                         ->where('d.PropertyId', $PropertyId)
                         ->get()->result();
if (!is_array($PropertyDocs)) {
    $PropertyDocs = [];
}

$Latitude = $PropertyDetails->Latitude ?? '';
$Longitude = $PropertyDetails->Longitude ?? '';
?>

<?php if (!isset($IsPreview) || !$IsPreview): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('components/header_meta'); ?>
    <?php $this->load->view('components/css_links'); ?>
<?php endif; ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .property-title {
            font-size: 32px;
            font-weight: 700;
            color: #222;
        }
        .text-primary-custom {
            color: #0066ff !important;
        }
        .bg-primary-custom {
            background-color: #0066ff !important;
        }
        .btn-primary-custom {
            background-color: #0066ff;
            border-color: #0066ff;
            color: #fff;
        }
        .btn-primary-custom:hover {
            background-color: #005ce6;
            border-color: #005ce6;
            color: #fff !important;
        }
        .btn-outline-primary-custom {
            color: #0066ff;
            border-color: #0066ff;
            background-color: #fff;
        }
        .btn-outline-primary-custom:hover {
            background-color: #005ce6;
            border-color: #005ce6;
            color: #fff !important;
        }
        .badge-custom {
            background-color: #4da6ff;
            font-weight: 500;
        }
        .action-btn {
            font-size: 13px;
            font-weight: 600;
            color: #444;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 5px 15px;
        }
        .action-btn:hover {
            background: #f1f1f1;
        }
        .slider-arrow {
            background: rgba(0, 0, 0, 0.4);
            color: #fff;
            padding: 15px 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        .slider-arrow:hover {
            background: rgba(0, 0, 0, 0.7);
        }
        .nav-tabs .nav-link {
            font-size: 14px;
            color: #666;
            background: #f8f9fa;
            border: none;
        }
        .nav-tabs .nav-link.active {
            color: #222;
            background: #fff;
            border-bottom: 3px solid #0066ff !important;
        }
        .form-control, .form-select {
            font-size: 14px;
            border-color: #e0e0e0;
        }
        .form-control::placeholder {
            color: #999;
        }
        .overview-icon {
            color: #555;
            margin-bottom: 10px;
        }
        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #222;
        }
        .detail-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .detail-list li {
            padding: 12px 0;
            border-bottom: 1px solid #f1f1f1;
            display: flex;
            justify-content: space-between;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        .feature-item i {
            color: #0066ff;
            margin-right: 10px;
        }
        .btn-check:checked + .tour-type-btn {
            background-color: #fff !important;
            color: #0066ff !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .tour-type-btn {
            transition: all 0.2s ease;
        }
        .tour-type-btn:hover {
            color: #0066ff !important;
        }
    </style>
<?php if (!isset($IsPreview) || !$IsPreview): ?>
</head>
<body>
    <div class="container-fluid p-0">
        <?php $this->load->view('components/header', ['ListingPages'=>'no']); ?>
<?php endif; ?>

        <div class="container-lg mt-4 mb-5">
            
            <?php if (isset($IsPreview) && $IsPreview): ?>
                <div class="alert alert-info d-flex flex-column flex-md-row justify-content-between align-items-center shadow-sm mb-4">
                    <div class="fw-bold mb-3 mb-md-0"><i class="fa fa-eye me-2"></i> This is a preview of how your property will look once published.</div>
                    <button type="button" class="btn btn-success fw-bold px-4 shadow-sm" onclick="publishProperty(<?= $PropertyDetails->PropertyId ?>)"><i class="fa-solid fa-paper-plane me-2"></i>Publish Property</button>
                </div>
                
                <!-- Publish Validation Modal -->
                <div class="modal fade" id="publishValidationModal" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                      <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title text-white"><i class="text-white fa-solid fa-triangle-exclamation me-2"></i> Incomplete Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body fs-6 py-4" id="publishValidationMessage">
                        <!-- message here -->
                      </div>
                      <div class="modal-footer border-0 justify-content-center pb-4">
                        <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal">OK, I will fill them</button>
                      </div>
                    </div>
                  </div>
                </div>

                <script>
                function publishProperty(propertyId) {
                    Swal.fire({
                        title: 'Publish Property?',
                        text: "Are you sure you want to make this property live?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, publish it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "<?= base_url('Properties/PublishProperty/') ?>" + propertyId,
                                type: "POST",
                                dataType: "json",
                                success: function(res) {
                                    if (res.Status) {
                                        Swal.fire('Published!', res.Message, 'success').then(() => {
                                            window.location.href = "<?= base_url('Properties/dashboard') ?>";
                                        });
                                    } else {
                                        $('#publishValidationMessage').html(res.Message);
                                        $('#publishValidationModal').modal('show');
                                    }
                                },
                                error: function() {
                                    Swal.fire('Error', 'An error occurred while communicating with the server.', 'error');
                                }
                            });
                        }
                    });
                }
                </script>
            <?php endif; ?>

            <!-- Header Section (Fully Wide) -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
                <div>
                    <div class="mb-2">
                        <?php
                        // echo "<pre>";
                        // echo "<br>";
                        // print_r($PropertyDetails);
                        // echo "<pre>";
                        ?>
                        <span class="badge badge-custom rounded-1 me-1"><?= $PropertyDetails->ListType ?? "" ?></span>
                        <span class="badge badge-custom rounded-1"><?= $PropertyType ?? "" ?></span>
                    </div>
                    <h1 class="property-title mb-1"><?= $PropertyDetails->PropertyTitle ?? "" ?></h1>
                    <div class="text-muted small">
                        <i class="fa-solid fa-location-dot me-1"></i> 
                        <?php
                            $dispAddr = [];
                            if (!empty($PropertyDetails->MailingAddress)) {
                                $dispAddr[] = $PropertyDetails->MailingAddress;
                            } else {
                                if (!empty($PropertyDetails->UnitNumber)) $dispAddr[] = "Unit " . $PropertyDetails->UnitNumber;
                                if (!empty($PropertyDetails->StreetNumber) && !empty($PropertyDetails->StreetName)) {
                                    $dispAddr[] = $PropertyDetails->StreetNumber . ' ' . $PropertyDetails->StreetName;
                                }
                                if (!empty($PropertyDetails->Suburb)) $dispAddr[] = $PropertyDetails->Suburb;
                                if (!empty($PropertyDetails->State)) $dispAddr[] = $PropertyDetails->State;
                                if (!empty($PropertyDetails->ZipCode)) $dispAddr[] = $PropertyDetails->ZipCode;
                            }
                            $fAddr = implode(', ', array_filter($dispAddr));
                            echo !empty($fAddr) ? htmlspecialchars($fAddr) : "Address not provided";
                        ?>
                    </div>
                </div>
                <div class="text-md-end">
                    <?php if (($PropertyDetails->ListType ?? 'Sale') === 'Rent'): ?>
                        <div class="text-primary-custom fw-bold" style="font-size: 15px;">
                            <span class="text-muted fw-normal">Rental Price</span>
                        </div>
                        <div class="text-primary-custom fw-bold" style="font-size: 34px; line-height: 1;">
                            $<?= number_format($PropertyDetails->TotalPrice ?? 0); ?> <span style="font-size: 18px;" class="text-muted fw-normal">/Month</span>
                        </div>
                    <?php else: ?>
                        <?php if (!empty($PropertyDetails->CoveredArea) && $PropertyDetails->CoveredArea > 0): ?>
                        <div class="text-primary-custom fw-bold" style="font-size: 15px;">
                            $<?= number_format(($PropertyDetails->TotalPrice ?? 0) / $PropertyDetails->CoveredArea, 2); ?> <span class="text-muted fw-normal">/<?= $AreaUnit ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="text-primary-custom fw-bold" style="font-size: 34px; line-height: 1;">
                            $<?= number_format($PropertyDetails->TotalPrice ?? 0); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-3 d-flex justify-content-md-end gap-2">
                        <button class="action-btn" onclick="copyToClipboard(window.location.href)"><i class="fa-solid fa-share-nodes"></i> Share</button>
                        
                        <?php if ($IsFavourite): ?>
                            <button class="action-btn text-danger border-danger" onclick="window.location.href='<?= base_url('Properties/RemoveFromFavourites/'.$PropertyId) ?>'"><i class="fa-solid fa-heart"></i> Favorite</button>
                        <?php else: ?>
                            <button class="action-btn" onclick="window.location.href='<?= base_url('Properties/AddToFavourites/'.$PropertyId) ?>'"><i class="fa-regular fa-heart"></i> Favorite</button>
                        <?php endif; ?>

                        <button class="action-btn" onclick="window.print()"><i class="fa-solid fa-print"></i> Print</button>
                    </div>
                    <script>
                    function copyToClipboard(text) {
                        var dummy = document.createElement("textarea");
                        document.body.appendChild(dummy);
                        dummy.value = text;
                        dummy.select();
                        document.execCommand("copy");
                        document.body.removeChild(dummy);
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({toast: true, position: 'top-end', icon: 'success', title: 'Link copied!', showConfirmButton: false, timer: 1500});
                        } else {
                            alert('Link copied to clipboard!');
                        }
                    }
                    </script>
                </div>
            </div>

            <div class="row">
                <!-- Main Content Column -->
                <div class="col-lg-12">
                    <!-- Slider & Thumbnails -->
                    <div class="position-relative mb-2">
                        <div class="position-absolute top-0 end-0 m-3 z-3">
                            <span class="badge bg-primary-custom rounded-1 px-3 py-2 fs-6 fw-normal">Active</span>
                        </div>
                        <div class="swiper mySwiper2" style="height: 500px; border-radius: 4px;">
                            <div class="swiper-wrapper">
                                <?php foreach($PropertyImages as $value): ?>
                                <div class="swiper-slide"><img src="<?= $value->path ?>" class="w-100 h-100" style="object-fit: cover;" alt="Image"></div>
                                <?php endforeach; ?>
                            </div>
                            <div class="swiper-button-next" style="color: #fff; text-shadow: 0 0 5px rgba(0,0,0,0.5);"></div>
                            <div class="swiper-button-prev" style="color: #fff; text-shadow: 0 0 5px rgba(0,0,0,0.5);"></div>
                        </div>
                    </div>

                    <!-- Thumbnails Row -->
                    <?php if (count($PropertyImages) > 1): ?>
                    <div class="swiper mySwiper mb-4" style="height: 90px; cursor: pointer;">
                        <div class="swiper-wrapper">
                            <?php foreach($PropertyImages as $value): ?>
                            <div class="swiper-slide"><img src="<?= $value->path ?>" class="w-100 h-100 rounded-1" style="object-fit: cover;" alt="Thumb"></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Overview Section -->
                    <div class="bg-white p-4 rounded-2 shadow-sm border mb-4">
                        <h4 class="fw-bold mb-4" style="color: #333;">Overview</h4>
                        <div class="row text-center g-3">
                            <div class="col">
                                <i class="fa-regular fa-calendar fs-3 overview-icon"></i>
                                <div class="fw-bold small text-dark">Updated On:</div>
                                <div class="small fw-bold text-dark"><?= date("F j, Y", strtotime($PropertyDetails->CreatedAt ?? date("Y-m-d"))) ?></div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-bed fs-3 overview-icon"></i>
                                <div class="fw-bold small text-dark"><?= $PropertyFeatures->Bedrooms ?? "0" ?> Bedrooms</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-bath fs-3 overview-icon"></i>
                                <div class="fw-bold small text-dark"><?= $PropertyFeatures->Bathrooms ?? "0" ?> Bathrooms</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-car fs-3 overview-icon"></i>
                                <div class="fw-bold small text-dark"><?= $PropertyFeatures->Garages ?? "0" ?> Garages</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-vector-square fs-3 overview-icon"></i>
                                <div class="fw-bold small text-dark"><?= $PropertyDetails->CoveredArea ?? "" ?> <?= $AreaUnit ?></div>
                            </div>
                            <div class="col">
                                <i class="fa-regular fa-calendar-days fs-3 overview-icon"></i>
                                <div class="fw-bold small text-dark">Year Built: <?= !empty($PropertyFeatures->BuiltInYear) ? date("Y", strtotime($PropertyFeatures->BuiltInYear)) : "N/A" ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-white p-4 rounded-2 shadow-sm border mb-4">
                        <h3 class="section-title">Description</h3>
                        <div class="text-muted" style="line-height: 1.8; font-size: 15px;">
                            <?= $PropertyDetails->PropertyDescription ?? "" ?>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="bg-white p-4 rounded-2 shadow-sm border mb-4">
                        <h3 class="section-title">Property Details</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="detail-list">
                                    <li><strong>Property ID:</strong> <span><?= $PropertyId ?? "" ?></span></li>
                                    <li><strong>Price:</strong> <span>$<?= number_format($PropertyDetails->TotalPrice ?? 0); ?></span></li>
                                    <li><strong>Property Size:</strong> <span><?= $PropertyDetails->CoveredArea ?? "" ?> <?= $AreaUnit ?></span></li>
                                    <li><strong>Bedrooms:</strong> <span><?= $PropertyFeatures->Bedrooms ?? "0" ?></span></li>
                                    <li><strong>Bathrooms:</strong> <span><?= $PropertyFeatures->Bathrooms ?? "0" ?></span></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="detail-list">
                                    <li><strong>Garage:</strong> <span><?= $PropertyFeatures->Garages ?? "0" ?></span></li>
                                    <li><strong>Garage Size:</strong> <span><?= $PropertyFeatures->GarageSize ?? "0" ?> <?= $AreaUnit ?></span></li>
                                    <li><strong>Year Built:</strong> <span><?= !empty($PropertyFeatures->BuiltInYear) ? date("Y", strtotime($PropertyFeatures->BuiltInYear)) : "N/A" ?></span></li>
                                    <li><strong>Property Type:</strong> <span><?= $PropertyType ?? "" ?></span></li>
                                    <li><strong>Property Status:</strong> <span>For <?= ucfirst(strtolower($PropertyDetails->ListType ?? "")) ?></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Address Accordion -->
                    <div class="accordion mb-4 shadow-sm border rounded-2" id="accordionPropertyAddress">
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header" id="heading_accordion_property_address_collapse">
                                <button class="accordion-button fw-bold bg-white text-dark rounded-top-2" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_property_address_collapse" aria-expanded="true" aria-controls="accordion_property_address_collapse" style="font-size: 18px;">
                                    Address
                                </button>
                            </h2>
                            <div id="accordion_property_address_collapse" class="accordion-collapse collapse show" aria-labelledby="heading_accordion_property_address_collapse">
                                <div class="accordion-body text-muted bg-white rounded-bottom-2 border-top">
                                    <div class="row g-3">
                                        <div class="col-md-12 mb-2 border-bottom pb-2"><strong>Mailing Address:</strong> <span class="text-dark"><?= $PropertyDetails->MailingAddress ?? "Not Provided" ?></span></div>
                                        <div class="col-md-4"><strong>Country:</strong> <?= $PropertyDetails->Country ?? "Australia" ?></div>
                                        <div class="col-md-4"><strong>State:</strong> <?= !empty($PropertyDetails->State) ? $PropertyDetails->State : "Not Provided" ?></div>
                                        <div class="col-md-4"><strong>Suburb:</strong> <?= !empty($PropertyDetails->Suburb) ? $PropertyDetails->Suburb : "Not Provided" ?></div>
                                        <div class="col-md-4"><strong>Postal Code:</strong> <?= !empty($PropertyDetails->ZipCode) ? $PropertyDetails->ZipCode : "Not Provided" ?></div>
                                        <div class="col-md-4"><strong>Unit Number:</strong> <?= !empty($PropertyDetails->UnitNumber) ? $PropertyDetails->UnitNumber : "Not Provided" ?></div>
                                        <div class="col-md-4"><strong>Street Number:</strong> <?= !empty($PropertyDetails->StreetNumber) ? $PropertyDetails->StreetNumber : "Not Provided" ?></div>
                                        <div class="col-md-4"><strong>Street Name:</strong> <?= !empty($PropertyDetails->StreetName) ? $PropertyDetails->StreetName : "Not Provided" ?></div>
                                        
                                        <!-- <div class="col-md-12 mt-3">
                                            <a href="https://maps.google.com/?q=<?= urlencode($PropertyDetails->MailingAddress ?? "") ?>" target="_blank" rel="noopener" class="text-primary-custom text-decoration-none fw-bold"><i class="fa-solid fa-map-location-dot me-2"></i>Open In Google Maps</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Travel Time Accordion -->
                    <div class="accordion mb-4 shadow-sm border rounded-2" id="accordionTravelTime">
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header" id="headingTravelTime">
                                <button class="accordion-button fw-bold bg-white text-dark rounded-top-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTravelTime" aria-expanded="true" aria-controls="collapseTravelTime">
                                    <div>
                                        <h5 class="fw-semibold mb-1" style="font-size: 18px;">See Your Travel Time</h5>
                                        <p class="mb-0 text-muted small fw-normal">
                                            From <?= $PropertyDetails->MailingAddress ?? "" ?>
                                        </p>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseTravelTime" class="accordion-collapse collapse show" aria-labelledby="headingTravelTime" data-bs-parent="#accordionTravelTime">
                                <div class="accordion-body bg-white rounded-bottom-2 border-top">
                                    <form class="p-1 pt-0 mt-0">
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark fs-6">Travel Mode</label>
                                                <select id="travelMode" class="form-select bg-light border-0">
                                                    <option value="DRIVE">Car</option>
                                                    <option value="BICYCLE">Bike</option>
                                                    <option value="WALK">Walking</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row g-3 mt-2">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark fs-6">Your Location</label>
                                                <input type="text" id="txtSearchCurrLocation" class="form-control bg-light border-0" placeholder="Enter a location" autocomplete="off">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark fs-6">Destination</label>
                                                <input type="text" class="form-control bg-light border-0 text-muted" value="<?= $PropertyDetails->MailingAddress ?? "" ?>" readonly="">
                                            </div>
                                        </div>

                                        <div class="row g-3 mt-2 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark fs-6">Distance</label>
                                                <input type="text" id="distance" class="form-control p-2 bg-light border-0 text-primary-custom fw-bold" readonly="">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark fs-6">Estimated Time</label>
                                                <input type="text" class="form-control p-2 bg-light border-0 text-success fw-bold" id="travelTime" readonly="">
                                            </div>
                                        </div>
                                    </form>

                                    <div id="map" class="rounded-2 mt-3" style="height: 400px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features & Amenities -->
                    <div class="bg-white p-4 rounded-2 shadow-sm border mb-4">
                        <h3 class="section-title">Features & Amenities</h3>
                        <div class="features-grid text-muted" style="font-size: 15px;">
                            <?php 
                            $hasAmenities = !empty($DynamicFeaturesList);
                            ?>
                            <?php if ($hasAmenities): ?>
                                <?php foreach($DynamicFeaturesList as $name => $val): ?>
                                    <?php if ($val === true): ?>
                                        <div class="feature-item"><i class="far fa-check-circle"></i> <?= htmlspecialchars($name) ?></div>
                                    <?php else: ?>
                                        <div class="feature-item"><i class="far fa-check-circle"></i> <?= htmlspecialchars($name) ?>: <strong class="text-dark"><?= htmlspecialchars($val) ?></strong></div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12">No additional features specified.</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if(!empty($PropertyVideos)): ?>
                    <!-- Video -->
                    <div class="bg-white p-4 rounded-2 shadow-sm border mb-4">
                        <h3 class="section-title">Property Video</h3>
                        <div class="ratio ratio-16x9">
                                <?php $vid = $PropertyVideos[0]; ?>
                                <video controls class="rounded-2 w-100 h-100" style="object-fit: cover;">
                                    <source src="<?= $vid->path ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if(!empty($PropertyDocs)): ?>
                    <!-- Documents -->
                    <div class="bg-white p-4 rounded-2 shadow-sm border mb-4">
                        <h3 class="section-title mb-4">Property Documents</h3>
                        <div class="row g-3">
                            <?php foreach ($PropertyDocs as $doc): ?>
                                <?php 
                                    $docPath = base_url('uploads/PropertyDocs/' . $PropertyId . '/' . ($doc->FilePath ?? '')); 
                                    $icon = 'fa-file-lines';
                                    $ext = pathinfo($doc->FilePath ?? '', PATHINFO_EXTENSION);
                                    if (in_array(strtolower($ext), ['pdf'])) $icon = 'fa-file-pdf text-danger';
                                    elseif (in_array(strtolower($ext), ['doc', 'docx'])) $icon = 'fa-file-word text-primary';
                                    elseif (in_array(strtolower($ext), ['xls', 'xlsx'])) $icon = 'fa-file-excel text-success';
                                    elseif (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) $icon = 'fa-file-image text-info';
                                ?>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-3 border rounded-2 bg-light shadow-sm">
                                        <i class="fa-solid <?= $icon ?> fs-2 me-3"></i>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <a href="<?= $docPath ?>" target="_blank" class="text-dark text-decoration-none fw-bold d-block text-truncate" title="<?= htmlspecialchars($doc->FilePath ?? '') ?>">
                                                <?= !empty($doc->DocumentTitle) ? htmlspecialchars($doc->DocumentTitle) : htmlspecialchars($doc->FilePath ?? 'Document') ?>
                                            </a>
                                            <div class="text-muted small"><?= strtoupper($ext) ?> Document</div>
                                        </div>
                                        <a href="<?= $docPath ?>" download class="btn btn-sm btn-outline-primary ms-2"><i class="fa-solid fa-download"></i></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize Thumbnails Swiper
            var swiper = new Swiper(".mySwiper", {
                spaceBetween: 10,
                slidesPerView: 5,
                freeMode: true,
                watchSlidesProgress: true,
            });
            
            // Initialize Main Swiper
            var swiper2 = new Swiper(".mySwiper2", {
                spaceBetween: 10,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                thumbs: {
                    swiper: swiper,
                },
            });

            // Initialize Dates Swiper
            var swiperDates = new Swiper(".mySwiperDates", {
                slidesPerView: 3.5,
                spaceBetween: 10,
                navigation: {
                    nextEl: ".date-next",
                    prevEl: ".date-prev",
                },
            });

            // Fallback for Tabs in case Bootstrap JS is not active
            var tabs = document.querySelectorAll('#sidebarTabs .nav-link');
            var panes = document.querySelectorAll('#sidebarTabsContent .tab-pane');
            
            tabs.forEach(function(tab) {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Remove active from all tabs
                    tabs.forEach(t => t.classList.remove('active'));
                    // Add active to clicked
                    this.classList.add('active');
                    
                    // Hide all panes
                    panes.forEach(p => {
                        p.classList.remove('show', 'active');
                    });
                    
                    // Show target pane
                    var targetId = this.getAttribute('data-bs-target');
                    if (targetId) {
                        var targetPane = document.querySelector(targetId);
                        if(targetPane) {
                            targetPane.classList.add('show', 'active');
                        }
                    }
                });
            });
        });
    </script>
    <script>
        let map, autocomplete, userMarker;
        let routePolyline;

        const destLat = <?= $Latitude ?>;
        const destLng = <?= $Longitude ?>;

        let currentOriginLat = null;
        let currentOriginLng = null;

        const locationInput = document.getElementById("txtSearchCurrLocation");

        if (navigator.geolocation && locationInput) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    let lat = position.coords.latitude;
                    let lng = position.coords.longitude;

                    // Reverse Geocoding using OpenStreetMap (FREE)
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.display_name) {
                                locationInput.value = data.display_name; // Fill input
                            }
                        })
                        .catch(err => console.log(err));
                },
                function (error) {
                    console.log("Location error:", error.message);
                }
            );
        }

        function initMap() {
            const destination = { lat: destLat, lng: destLng };

            map = new google.maps.Map(document.getElementById("map"), {
                center: destination,
                zoom: 12
            });

            // DESTINATION MARKER
            const destMarker = new google.maps.Marker({
                position: destination,
                map: map,
                icon: "https://maps.google.com/mapfiles/ms/icons/red-dot.png",
                title: "Destination"
            });

            const destInfo = new google.maps.InfoWindow({
                content: "<b>Destination</b><br><?= $PropertyDetails->MailingAddress ?? "" ?>"
            });

            destMarker.addListener("mouseover", () => destInfo.open(map, destMarker));
            destMarker.addListener("mouseout", () => destInfo.close());

            initAutocomplete();
            detectCurrentLocation();

            // REALTIME TRAVEL MODE CHANGE
            const travelModeEl = document.getElementById("travelMode");
            if(travelModeEl) {
                travelModeEl.addEventListener("change", function() {
                    if (currentOriginLat && currentOriginLng) {
                        calculateRoute(currentOriginLat, currentOriginLng);
                    }
                });
            }
        }

        // CURRENT LOCATION
        function detectCurrentLocation() {
            if (!navigator.geolocation) return;

            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                currentOriginLat = lat;
                currentOriginLng = lng;
                const location = new google.maps.LatLng(lat, lng);

                map.setCenter(location);
                if (userMarker) userMarker.setMap(null);

                userMarker = new google.maps.Marker({
                    position: location,
                    map: map,
                    icon: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                });

                const userInfo = new google.maps.InfoWindow({
                    content: "<b>Your Current Location</b>"
                });

                userMarker.addListener("mouseover", () => userInfo.open(map, userMarker));
                userMarker.addListener("mouseout", () => userInfo.close());

                const geocoder = new google.maps.Geocoder();
                geocoder.geocode({ location: location }, function(results, status) {
                    if (status === "OK" && results[0] && locationInput) {
                        locationInput.value = results[0].formatted_address;
                    }
                });

                calculateRoute(lat, lng);
            });
        }

        // AUTOCOMPLETE
        function initAutocomplete() {
            if(!locationInput) return;
            
            autocomplete = new google.maps.places.Autocomplete(locationInput, {
                fields: ["formatted_address", "geometry"]
            });

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                if (!place.geometry) return;

                const lat = place.geometry.location.lat();
                const lng = place.geometry.location.lng();
                currentOriginLat = lat;
                currentOriginLng = lng;
                const location = place.geometry.location;

                map.setCenter(location);
                if (userMarker) userMarker.setMap(null);

                userMarker = new google.maps.Marker({
                    position: location,
                    map: map,
                    icon: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                });

                const userInfo = new google.maps.InfoWindow({
                    content: "<b>" + place.formatted_address + "</b>"
                });

                userMarker.addListener("mouseover", () => userInfo.open(map, userMarker));
                userMarker.addListener("mouseout", () => userInfo.close());

                calculateRoute(lat, lng);
            });
        }

        // ROUTE CALCULATION
        async function calculateRoute(originLat, originLng) {
            if (!originLat || !originLng) return;

            const apiKey = "AIzaSyCv1FrfWK8d_Z28pT_XtiZW02msCfrC2Rs";
            const travelModeEl = document.getElementById("travelMode");
            const travelMode = travelModeEl ? travelModeEl.value : "DRIVE";
            const url = "https://routes.googleapis.com/directions/v2:computeRoutes";

            const body = {
                origin: { location: { latLng: { latitude: originLat, longitude: originLng } } },
                destination: { location: { latLng: { latitude: destLat, longitude: destLng } } },
                travelMode: travelMode,
                polylineEncoding: "ENCODED_POLYLINE"
            };

            if (travelMode === "DRIVE") {
                body.routingPreference = "TRAFFIC_AWARE";
            }

            try {
                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Goog-Api-Key": apiKey,
                        "X-Goog-FieldMask": "routes.distanceMeters,routes.duration,routes.polyline.encodedPolyline"
                    },
                    body: JSON.stringify(body)
                });

                const data = await response.json();
                if (!data.routes || data.routes.length == 0) return;

                const route = data.routes[0];
                const distanceKm = (route.distanceMeters / 1000).toFixed(2);
                const durationSec = parseInt(route.duration.replace("s", ""));
                const durationMin = Math.round(durationSec / 60);

                const distanceEl = document.getElementById("distance");
                const travelTimeEl = document.getElementById("travelTime");
                if(distanceEl) distanceEl.value = distanceKm + " km";
                if(travelTimeEl) travelTimeEl.value = durationMin + " mins";

                drawRoute(route.polyline.encodedPolyline);
            } catch (err) {
                console.error(err);
            }
        }

        // DRAW ROUTE
        function drawRoute(encodedPolyline) {
            if (routePolyline) routePolyline.setMap(null);

            const decodedPath = google.maps.geometry.encoding.decodePath(encodedPolyline);

            routePolyline = new google.maps.Polyline({
                path: decodedPath,
                strokeColor: "#007bff",
                strokeOpacity: 1,
                strokeWeight: 6
            });

            routePolyline.setMap(map);

            const bounds = new google.maps.LatLngBounds();
            decodedPath.forEach(p => bounds.extend(p));
            map.fitBounds(bounds);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv1FrfWK8d_Z28pT_XtiZW02msCfrC2Rs&amp;libraries=places,geometry&amp;callback=initMap" async="" defer=""></script>
<?php if (!isset($IsPreview) || !$IsPreview): ?>
    <?php $this->load->view('components/footer'); ?>
    <?php $this->load->view('components/js_links'); ?>
<?php endif; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        let isLoggedIn = <?= $this->session->userdata('user_id') ? 'true' : 'false' ?>;

        function showLoginModal() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Log in Required',
                    text: 'Log in first to do this action.',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Log In',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?= site_url('Properties/signin') ?>";
                    }
                });
            } else {
                alert("Log in first to do this action.");
                window.location.href = "<?= site_url('Properties/signin') ?>";
            }
        }

        $(document).ready(function() {
            // Initialize flatpickr for Date and Time
            flatpickr("#tour_date", {
                minDate: "today",
                dateFormat: "Y-m-d",
            });
            flatpickr("#tour_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "h:i K",
                time_24hr: false
            });

            $('button[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
                if (!isLoggedIn) {
                    e.preventDefault();
                    showLoginModal();
                }
            });

            $('#btnScheduleTour').click(function(e) {
                e.preventDefault();
                if (!isLoggedIn) { showLoginModal(); return; }
                
                let date = $('#tour_date').val().trim();
                let time = $('#tour_time').val().trim();
                let name = $('#tour_name').val().trim();
                let email = $('#tour_email').val().trim();
                let phone = $('#tour_phone').val().trim();
                let message = $('#tour_message').val().trim();
                let tourType = $('#tour_in_person').is(':checked') ? 'In Person' : 'Video Chat';

                if (!date || !time || !name || !email || !phone) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Warning', 'Please select Date and Time, and fill in your Name, Email, and Phone.', 'warning');
                    } else {
                        alert('Please select Date and Time, and fill in your Name, Email, and Phone.');
                    }
                    return;
                }

                let btn = $(this);
                let originalText = btn.html();
                btn.html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Sending...').prop('disabled', true);

                let txtRemarks = `Name: ${name}\nEmail: ${email}\nPhone: ${phone}\nAction: Schedule a Tour\nTour Type: ${tourType}\nMessage: ${message}`;
                
                let formData = {
                    PropertyId: $('#req_PropertyId').val(),
                    SellerId: $('#req_SellerId').val(),
                    RequestedBy: $('#req_RequestedBy').val(),
                    txtRemarks: txtRemarks,
                    txtMeetDate: date,
                    txtMeetTime: time,
                    chkTourType: tourType
                };

                $.ajax({
                    url: "<?= base_url('Properties/PropertyEnquiry') ?>",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(res) {
                        btn.html(originalText).prop('disabled', false);
                        if (res.Status) {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire('Success', 'Your tour request has been sent successfully.', 'success').then(() => {
                                    $('#tour_date').val('');
                                    $('#tour_time').val('');
                                    if (!isLoggedIn) {
                                        $('#tour_name').val('');
                                        $('#tour_email').val('');
                                        $('#tour_phone').val('');
                                    }
                                });
                            } else {
                                alert('Your tour request has been sent successfully.');
                            }
                        } else {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire('Error', res.Message || 'Failed to schedule tour.', 'error');
                            } else {
                                alert(res.Message || 'Failed to schedule tour.');
                            }
                        }
                    },
                    error: function() {
                        btn.html(originalText).prop('disabled', false);
                        if (typeof Swal !== 'undefined') {
                            Swal.fire('Error', 'An error occurred while communicating with the server.', 'error');
                        } else {
                            alert('An error occurred while communicating with the server.');
                        }
                    }
                });
            });

            $('#btnSendRequestInfo').click(function(e) {
                e.preventDefault();
                if (!isLoggedIn) { showLoginModal(); return; }

                let name = $('#req_name').val().trim();
                let email = $('#req_email').val().trim();
                let phone = $('#req_phone').val().trim();
                let action = $('#req_action').val();
                let message = $('#req_message').val().trim();

                if (!name || !email || !phone) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Warning', 'Please fill in your Name, Email, and Phone.', 'warning');
                    } else {
                        alert('Please fill in your Name, Email, and Phone.');
                    }
                    return;
                }

                let btn = $(this);
                let originalText = btn.html();
                btn.html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Sending...').prop('disabled', true);

                let txtRemarks = `Name: ${name}\nEmail: ${email}\nPhone: ${phone}\nAction: ${action}\nMessage: ${message}`;
                
                let formData = {
                    PropertyId: $('#req_PropertyId').val(),
                    SellerId: $('#req_SellerId').val(),
                    RequestedBy: $('#req_RequestedBy').val(),
                    txtRemarks: txtRemarks,
                    txtMeetDate: '',
                    txtMeetTime: '',
                    chkTourType: ''
                };

                $.ajax({
                    url: "<?= base_url('Properties/PropertyEnquiry') ?>",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(res) {
                        btn.html(originalText).prop('disabled', false);
                        if (res.Status) {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire('Success', 'Your request has been sent successfully.', 'success').then(() => {
                                    $('#frmRequestInfo')[0].reset();
                                });
                            } else {
                                alert('Your request has been sent successfully.');
                                $('#frmRequestInfo')[0].reset();
                            }
                        } else {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire('Error', res.Message || 'Failed to send request.', 'error');
                            } else {
                                alert(res.Message || 'Failed to send request.');
                            }
                        }
                    },
                    error: function() {
                        btn.html(originalText).prop('disabled', false);
                        if (typeof Swal !== 'undefined') {
                            Swal.fire('Error', 'An error occurred while communicating with the server.', 'error');
                        } else {
                            alert('An error occurred while communicating with the server.');
                        }
                    }
                });
            });

            $('#btnMakeOffer').click(function(e) {
                e.preventDefault();
                if (!isLoggedIn) { showLoginModal(); return; }

                let amount = $('#offer_amount').val().trim();
                let name = $('#offer_name').val().trim();
                let email = $('#offer_email').val().trim();
                let phone = $('#offer_phone').val().trim();
                let message = $('#offer_message').val().trim();

                if (!amount || !name || !email || !phone) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Warning', 'Please fill in the Offer Amount, Name, Email, and Phone.', 'warning');
                    } else {
                        alert('Please fill in the Offer Amount, Name, Email, and Phone.');
                    }
                    return;
                }

                let btn = $(this);
                let originalText = btn.html();
                btn.html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Submitting...').prop('disabled', true);

                let txtRemarks = `Name: ${name}\nEmail: ${email}\nPhone: ${phone}\nAction: Make Offer\nOffer Amount: $${amount}\nMessage: ${message}`;
                
                let formData = {
                    PropertyId: $('#offer_PropertyId').val(),
                    SellerId: $('#offer_SellerId').val(),
                    RequestedBy: $('#offer_RequestedBy').val(),
                    txtRemarks: txtRemarks,
                    txtMeetDate: '',
                    txtMeetTime: '',
                    chkTourType: ''
                };

                $.ajax({
                    url: "<?= base_url('Properties/PropertyEnquiry') ?>",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(res) {
                        btn.html(originalText).prop('disabled', false);
                        if (res.Status) {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire('Success', 'Your offer has been submitted successfully.', 'success').then(() => {
                                    $('#frmMakeOffer')[0].reset();
                                });
                            } else {
                                alert('Your offer has been submitted successfully.');
                                $('#frmMakeOffer')[0].reset();
                            }
                        } else {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire('Error', res.Message || 'Failed to submit offer.', 'error');
                            } else {
                                alert(res.Message || 'Failed to submit offer.');
                            }
                        }
                    },
                    error: function() {
                        btn.html(originalText).prop('disabled', false);
                        if (typeof Swal !== 'undefined') {
                            Swal.fire('Error', 'An error occurred while communicating with the server.', 'error');
                        } else {
                            alert('An error occurred while communicating with the server.');
                        }
                    }
                });
            });
        });
    </script>
<?php if (!isset($IsPreview) || !$IsPreview): ?>
</body>
</html>
<?php endif; ?>
