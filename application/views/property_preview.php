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

// Check if no video, add 1 dummy
if (empty($PropertyVideos)) {
    $PropertyVideos = [
        (object)['FileName' => 'dummy_video_1', 'is_dummy' => true, 'path' => base_url('assets/images/property-video.mp4')]
    ];
} else {
    foreach ($PropertyVideos as &$vid) {
        $vid->is_dummy = false;
        $vid->path = base_url('uploads/Properties/' . $PropertyId . '/videos/' . ($vid->FileName ?? ''));
    }
}

$urlImage = $PropertyId;

$Latitude = $PropertyDetails->Latitude ?? '-33.8674';
$Longitude = $PropertyDetails->Longitude ?? '151.213';
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
                                        <div class="col-md-4"><strong>State:</strong> <?= $PropertyDetails->State ?? "Not Provided" ?></div>
                                        <div class="col-md-4"><strong>Suburb:</strong> <?= $PropertyDetails->Suburb ?? "Not Provided" ?></div>
                                        <div class="col-md-4"><strong>Postal Code:</strong> <?= $PropertyDetails->ZipCode ?? "Not Provided" ?></div>
                                        <div class="col-md-4"><strong>Unit Number:</strong> <?= $PropertyDetails->UnitNumber ?? "Not Provided" ?></div>
                                        <div class="col-md-4"><strong>Street Number:</strong> <?= $PropertyDetails->StreetNumber ?? "Not Provided" ?></div>
                                        <div class="col-md-4"><strong>Street Name:</strong> <?= $PropertyDetails->StreetName ?? "Not Provided" ?></div>
                                        
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

                    <!-- Video -->
                    <div class="bg-white p-4 rounded-2 shadow-sm border mb-4">
                        <h3 class="section-title">Property Video</h3>
                        <div class="ratio ratio-16x9">
                            <?php if(!empty($PropertyVideos)): ?>
                                <?php $vid = $PropertyVideos[0]; ?>
                                <video controls class="rounded-2 w-100 h-100" style="object-fit: cover;">
                                    <source src="<?= $vid->path ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="bg-white p-4 rounded-2 shadow-sm border mb-4">
                        <h3 class="section-title mb-4">Property Reviews</h3>
                        
                        <!-- Other People's Reviews -->
                        <div class="mb-4">
                            <div class="d-flex mb-4">
                                <img src="https://ui-avatars.com/api/?name=Sarah+M&background=random" class="rounded-circle me-3" style="width: 50px; height: 50px;" alt="Reviewer">
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">Sarah M.</h6>
                                    <div class="text-warning small mb-2">
                                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark">Amazing Location!</h6>
                                    <p class="text-muted small mb-0">We loved the property. The house is beautiful and situated in a peaceful neighborhood. Highly recommend it to anyone looking for a quiet retreat.</p>
                                </div>
                            </div>
                            <hr class="text-muted opacity-25">
                            <div class="d-flex mb-2">
                                <img src="https://ui-avatars.com/api/?name=David+R&background=random" class="rounded-circle me-3" style="width: 50px; height: 50px;" alt="Reviewer">
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">David R.</h6>
                                    <div class="text-warning small mb-2">
                                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark">Great house, needs minor touch-ups</h6>
                                    <p class="text-muted small mb-0">Overall a fantastic experience. The backyard is enormous and perfect for barbecues. A few minor things inside could use some updating, but the price reflects the value.</p>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="text-muted opacity-25 mb-4">

                        <!-- Add Review Form -->
                        <h5 class="fw-bold mb-3 text-dark">Write a Review</h5>
                        <div class="add_review_wrapper">
                            <div class="rating mb-3">
                                <span class="fw-bold me-2 text-dark">Your Rating &amp; Review</span>
                                <span class="text-muted cursor-pointer"><i class="fa-regular fa-star"></i></span>
                                <span class="text-muted cursor-pointer"><i class="fa-regular fa-star"></i></span>
                                <span class="text-muted cursor-pointer"><i class="fa-regular fa-star"></i></span>
                                <span class="text-muted cursor-pointer"><i class="fa-regular fa-star"></i></span>
                                <span class="text-muted cursor-pointer"><i class="fa-regular fa-star"></i></span>
                            </div>
                            <form>
                                <input type="text" id="wpestate_review_title" name="wpestate_review_title" class="form-control mb-3 bg-light border-0 py-2 rounded-1" placeholder="Review Title">
                                <textarea rows="5" id="wpestare_review_content" name="wpestare_review_content" class="form-control mb-3 bg-light border-0 py-2 rounded-1" placeholder="Your Review"></textarea>
                                <button type="button" class="btn btn-primary-custom py-2 px-4 rounded-1 fw-bold border-0 shadow-sm" id="submit_review">Submit Review</button>
                            </form>
                        </div>
                    </div>

                </div>

                <!-- Sidebar Column -->
                <div class="col-lg-4 d-none">
                    <div class="bg-white rounded-2 shadow-sm border overflow-hidden position-sticky" style="top: 20px; z-index: 10;">
                        
                        <!-- Tabs -->
                        <ul class="nav nav-tabs nav-fill" id="sidebarTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold py-3 rounded-0 px-2" id="request-info-tab" data-bs-toggle="tab" data-bs-target="#request-info" type="button" role="tab" aria-controls="request-info" aria-selected="true" style="font-size:13px;">Request Info</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold py-3 rounded-0 px-2" id="schedule-tour-tab" data-bs-toggle="tab" data-bs-target="#schedule-tour" type="button" role="tab" aria-controls="schedule-tour" aria-selected="false" style="font-size:13px;">Schedule a tour</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold py-3 rounded-0 px-2" id="make-offer-tab" data-bs-toggle="tab" data-bs-target="#make-offer" type="button" role="tab" aria-controls="make-offer" aria-selected="false" style="font-size:13px;">Make Offer</button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="sidebarTabsContent">
                            
                            <!-- Request Info Tab -->
                            <div class="tab-pane fade show active p-4" id="request-info" role="tabpanel" aria-labelledby="request-info-tab">
                                <!-- Agent Info -->
                                <div class="d-flex align-items-center mb-4">
                                    <div class="rounded-circle me-3 d-flex align-items-center justify-content-center text-white fw-bold bg-primary-custom shadow-sm" style="width: 65px; height: 65px; font-size: 24px;"><?= htmlspecialchars($SellerInitials ?? 'SA') ?></div>
                                    <div>
                                        <h5 class="mb-1 fw-bold text-dark d-flex align-items-center">
                                            <?= htmlspecialchars($Seller->ClientName ?? 'System Admin') ?>
                                            <?php if (($Seller->AccountStatus ?? '') === 'Active' || ($Seller->AccountStatus ?? '') === 'Verified'): ?>
                                                <span style="border: 1px solid #1b9500c5; background-color: rgba(32, 176, 0, 0.2);" class="badge ms-2 rounded-pill text-dark">Verified</span>
                                            <?php else: ?>
                                                <span style="border: 1px solid #95840066; background-color: rgba(255, 191, 0, 0.3);" class="badge text-dark ms-2 rounded-pill">Not Verified</span>
                                            <?php endif; ?>
                                        </h5>
                                        <div class="text-muted small">Member ID: <?= htmlspecialchars($Seller->ClientId ?? '0') ?></div>
                                    </div>
                                </div>

                                <!-- Schedule Banner -->
                                <div class="bg-success text-white text-center py-2 rounded-1 mb-4 fw-semibold shadow-sm" style="font-size: 14px;">
                                    Schedule a showing?
                                </div>

                                <!-- Form -->
                                <form id="frmRequestInfo">
                                    <input type="hidden" id="req_PropertyId" value="<?= $PropertyId ?? 0 ?>">
                                    <input type="hidden" id="req_SellerId" value="<?= $Seller->ClientId ?? 0 ?>">
                                    <input type="hidden" id="req_RequestedBy" value="<?= $UserId ?? 0 ?>">

                                    <input type="text" id="req_name" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Name" value="<?= $autoName ?>" <?= $autoReadonly ?> required>
                                    <input type="email" id="req_email" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Email" value="<?= $autoEmail ?>" <?= $autoReadonly ?> required>
                                    <input type="tel" id="req_phone" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Phone" value="<?= $autoPhone ?>" <?= $autoReadonly ?> required>
                                    
                                    <select id="req_action" class="form-select mb-3 py-2 rounded-1 text-muted bg-light border-0">
                                        <option value="">What are you looking to do?</option>
                                        <option value="I want to schedule a viewing">I want to schedule a viewing</option>
                                        <option value="I want more details">I want more details</option>
                                    </select>

                                    <textarea id="req_message" class="form-control mb-4 py-2 rounded-1 text-muted bg-light border-0" rows="3">Hello,
I'm interested in [ <?= $PropertyDetails->PropertyTitle ?? "" ?> ]</textarea>
                                    
                                    <!-- Buttons -->
                                    <div class="d-flex gap-2">
                                        <button type="button" id="btnSendRequestInfo" class="btn btn-primary-custom flex-fill py-2 rounded-2" style="font-size: 14px; border: 1px solid #0066ff;">
                                            <i class="fa-solid fa-paper-plane me-1"></i> Send Request
                                        </button>
                                        <a href="tel:<?= htmlspecialchars($Seller->PhoneNumber ?? '') ?>" class="btn btn-outline-primary-custom flex-fill py-2 rounded-2 d-flex align-items-center justify-content-center text-decoration-none" style="font-size: 14px; border: 1px solid #0066ff;">
                                            <i class="fa-solid fa-phone me-1"></i> Call
                                        </a>
                                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $Seller->PhoneNumber ?? '') ?>" target="_blank" class="btn btn-outline-primary-custom flex-fill py-2 rounded-2 d-flex align-items-center justify-content-center text-decoration-none" style="font-size: 14px; border: 1px solid #0066ff;">
                                            <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp
                                        </a>
                                    </div>
                                </form>
                            </div>

                            <!-- Schedule a tour Tab -->
                            <div class="tab-pane fade p-4" id="schedule-tour" role="tabpanel" aria-labelledby="schedule-tour-tab">
                                <h5 class="fw-bold text-dark mb-4">Schedule a tour</h5>
                                
                                <!-- Dates -->
                                <div class="row g-2 mb-4">
                                    <div class="col-6">
                                        <input type="text" id="tour_date" class="form-control py-2 rounded-1 text-muted bg-light border-0 shadow-sm" placeholder="Select Date" required>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" id="tour_time" class="form-control py-2 rounded-1 text-muted bg-light border-0 shadow-sm" placeholder="Select Time" required>
                                    </div>
                                </div>

                                <div class="d-flex bg-light p-1 rounded-2 mb-4 border">
                                    <input type="radio" class="btn-check" name="tour_type" id="tour_in_person" autocomplete="off" checked>
                                    <label class="btn flex-fill rounded-2 border-0 fw-bold py-2 tour-type-btn text-muted m-0" for="tour_in_person"><i class="fa-regular fa-user me-2"></i> In Person</label>

                                    <input type="radio" class="btn-check" name="tour_type" id="tour_video" autocomplete="off">
                                    <label class="btn flex-fill rounded-2 border-0 fw-bold py-2 tour-type-btn text-muted m-0" for="tour_video"><i class="fa-solid fa-video me-2"></i> Video Chat</label>
                                </div>

                                <h6 class="fw-bold text-dark mb-3">Your information</h6>
                                
                                <form>
                                    <input type="text" id="tour_name" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Name" value="<?= $autoName ?>" <?= $autoReadonly ?>>
                                    <input type="email" id="tour_email" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Email" value="<?= $autoEmail ?>" <?= $autoReadonly ?>>
                                    <input type="tel" id="tour_phone" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Phone" value="<?= $autoPhone ?>" <?= $autoReadonly ?>>
                                    
                                    <select class="form-select mb-3 py-2 rounded-1 text-muted bg-light border-0">
                                        <option>What are you looking to do?</option>
                                    </select>

                                    <textarea id="tour_message" class="form-control mb-4 py-2 rounded-1 text-muted bg-light border-0" rows="4">I would like to schedule a tour for [ <?= $PropertyDetails->PropertyTitle ?? "" ?> ].</textarea>
                                    
                                    <button type="button" id="btnScheduleTour" class="btn btn-primary-custom w-100 py-2 rounded-2 mt-2" style="font-size: 14px; border: 1px solid #0066ff;"><i class="fa-solid fa-paper-plane me-1"></i> Send Request</button>
                                </form>
                            </div>

                            <!-- Make Offer Tab -->
                            <div class="tab-pane fade p-4" id="make-offer" role="tabpanel" aria-labelledby="make-offer-tab">
                                <h5 class="fw-bold text-dark mb-4">Make an Offer</h5>
                                <form id="frmMakeOffer">
                                    <input type="hidden" id="offer_PropertyId" value="<?= $PropertyId ?? 0 ?>">
                                    <input type="hidden" id="offer_SellerId" value="<?= $Seller->ClientId ?? 0 ?>">
                                    <input type="hidden" id="offer_RequestedBy" value="<?= $UserId ?? 0 ?>">

                                    <label class="form-label fw-bold text-dark fs-6">Offer Amount</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light border-0">$</span>
                                        <input type="number" id="offer_amount" class="form-control py-2 rounded-end-1 bg-light border-0" placeholder="e.g. 500000" required>
                                    </div>

                                    <label class="form-label fw-bold text-dark fs-6">Your Information</label>
                                    <input type="text" id="offer_name" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Name" value="<?= $autoName ?>" <?= $autoReadonly ?> required>
                                    <input type="email" id="offer_email" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Email" value="<?= $autoEmail ?>" <?= $autoReadonly ?> required>
                                    <input type="tel" id="offer_phone" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Phone" value="<?= $autoPhone ?>" <?= $autoReadonly ?> required>
                                    
                                    <textarea id="offer_message" class="form-control mb-4 py-2 rounded-1 text-muted bg-light border-0" rows="3" placeholder="Additional details or terms (optional)"></textarea>
                                    
                                    <button type="button" id="btnMakeOffer" class="btn btn-primary-custom w-100 py-2 rounded-2 mt-2" style="font-size: 14px; border: 1px solid #0066ff;"><i class="fa-solid fa-paper-plane me-1"></i> Submit Offer</button>
                                </form>
                            </div>
                        </div>

                    </div>
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
