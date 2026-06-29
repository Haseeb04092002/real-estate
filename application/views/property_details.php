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
$PropertyFeatures = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_features','*',"WHERE PropertyId = '$PropertyId'",2);
if (!is_object($PropertyFeatures)) { $PropertyFeatures = new stdClass(); }
$arrProperties = $this->getlist_model->getFieldsMultipleConditions('tbl_properties','*',"WHERE PropertyTypeId > 0 ORDER BY PropertyId DESC LIMIT 0,6");

$Message_Box = 'd-none';

$UserId = $this->session->userdata('user_id');

$IsFavourite = $this->getlist_model->getFieldsMultipleConditions(
  'tbl_properties_favourites',
  'IsFavourite',
  "WHERE PropertyId = '$PropertyId' AND UserId = '$UserId'",
  1
);

?>



<?php
$ImageNames = $this->getlist_model->getFieldsMultipleConditions(
    'tbl_documents',
    'FileName',
    "WHERE Reference = 'Properties' AND ReferenceId = '$PropertyId'"
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
        }
        .btn-outline-primary-custom {
            color: #0066ff;
            border-color: #0066ff;
            background-color: #fff;
        }
        .btn-outline-primary-custom:hover {
            background-color: #f0f7ff;
            color: #0066ff;
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
                                        Swal.fire({
                                            title: 'Incomplete Details',
                                            html: res.Message,
                                            icon: 'warning'
                                        });
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
                        <span class="badge badge-custom rounded-1 me-1">Sales</span>
                        <span class="badge badge-custom rounded-1">Houses</span>
                    </div>
                    <h1 class="property-title mb-1"><?= $PropertyDetails->PropertyTitle ?? "" ?></h1>
                    <div class="text-muted small">
                        <i class="fa-solid fa-location-dot me-1"></i> <?= $PropertyDetails->MailingAddress ?? "" ?>
                    </div>
                </div>
                <div class="text-md-end">
                    <div class="text-primary-custom fw-bold" style="font-size: 15px;">
                        $<?= number_format(($PropertyDetails->TotalPrice ?? 0) / (($PropertyDetails->CoveredArea ?? 1) == 0 ? 1 : $PropertyDetails->CoveredArea), 2); ?> <span class="text-muted fw-normal">/<?= $AreaUnit ?></span>
                    </div>
                    <div class="text-primary-custom fw-bold" style="font-size: 34px; line-height: 1;">
                        $<?= number_format($PropertyDetails->TotalPrice ?? 0); ?>
                    </div>
                    <div class="mt-3 d-flex justify-content-md-end gap-2">
                        <button class="action-btn"><i class="fa-solid fa-share-nodes"></i> Share</button>
                        <button class="action-btn"><i class="fa-regular fa-heart"></i> Favorite</button>
                        <button class="action-btn"><i class="fa-solid fa-print"></i> Print</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Main Content Column -->
                <div class="col-lg-8">
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
                    <div class="swiper mySwiper mb-4" style="height: 90px; cursor: pointer;">
                        <div class="swiper-wrapper">
                            <?php foreach($PropertyImages as $value): ?>
                            <div class="swiper-slide"><img src="<?= $value->path ?>" class="w-100 h-100 rounded-1" style="object-fit: cover;" alt="Thumb"></div>
                            <?php endforeach; ?>
                        </div>
                    </div>

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
                                        <div class="col-md-4"><strong>Address:</strong> <?= $PropertyDetails->MailingAddress ?? "" ?></div>
                                        <div class="col-md-4"><strong>City:</strong> <a href="#" class="text-decoration-none text-primary-custom"><?= $PropertyDetails->City ?? "" ?></a></div>
                                        <div class="col-md-4"><strong>Area:</strong> <a href="#" class="text-decoration-none text-primary-custom"><?= $PropertyDetails->Area ?? "" ?></a></div>
                                        <div class="col-md-4"><strong>State/County:</strong> <a href="#" class="text-decoration-none text-primary-custom"><?= $PropertyDetails->State ?? "" ?></a></div>
                                        <div class="col-md-4"><strong>Zip:</strong> <?= $PropertyDetails->ZipCode ?? "" ?></div>
                                        <div class="col-md-4"><strong>Country:</strong> United States</div>
                                        <div class="col-md-12 mt-2">
                                            <a href="https://maps.google.com/?q=<?= urlencode($PropertyDetails->MailingAddress ?? "") ?>" target="_blank" rel="noopener" class="text-primary-custom text-decoration-none fw-bold"><i class="fa-solid fa-map-location-dot me-2"></i>Open In Google Maps</a>
                                        </div>
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
                            <div class="feature-item"><i class="far fa-check-circle"></i> Air Conditioning</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> Barbeque</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> Dryer</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> Gym</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> Laundry</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> Lawn</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> Microwave</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> Outdoor Shower</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> Refrigerator</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> Sauna</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> Swimming Pool</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> TV Cable</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> Washer</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> WiFi</div>
                            <div class="feature-item"><i class="far fa-check-circle"></i> Window Coverings</div>
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
                <div class="col-lg-4">
                    <div class="bg-white rounded-2 shadow-sm border overflow-hidden position-sticky" style="top: 20px; z-index: 10;">
                        
                        <!-- Tabs -->
                        <ul class="nav nav-tabs nav-fill" id="sidebarTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold py-3 rounded-0" id="request-info-tab" data-bs-toggle="tab" data-bs-target="#request-info" type="button" role="tab" aria-controls="request-info" aria-selected="true">Request Info</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold py-3 rounded-0" id="schedule-tour-tab" data-bs-toggle="tab" data-bs-target="#schedule-tour" type="button" role="tab" aria-controls="schedule-tour" aria-selected="false">Schedule a tour</button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="sidebarTabsContent">
                            
                            <!-- Request Info Tab -->
                            <div class="tab-pane fade show active p-4" id="request-info" role="tabpanel" aria-labelledby="request-info-tab">
                                <!-- Agent Info -->
                                <div class="d-flex align-items-center mb-4">
                                    <div class="rounded-circle me-3 d-flex align-items-center justify-content-center text-white fw-bold bg-primary-custom shadow-sm" style="width: 65px; height: 65px; font-size: 24px;">JC</div>
                                    <div>
                                        <h5 class="mb-1 fw-bold text-dark">John Collins</h5>
                                        <div class="text-muted small">Member ID: 987654321</div>
                                    </div>
                                </div>

                                <!-- Schedule Banner -->
                                <div class="bg-success text-white text-center py-2 rounded-1 mb-4 fw-semibold shadow-sm" style="font-size: 14px;">
                                    Schedule a showing?
                                </div>

                                <!-- Form -->
                                <form>
                                    <input type="text" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Name">
                                    <input type="email" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Email">
                                    <input type="tel" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Phone">
                                    
                                    <select class="form-select mb-3 py-2 rounded-1 text-muted bg-light border-0">
                                        <option>What are you looking to do?</option>
                                        <option>I want to schedule a viewing</option>
                                        <option>I want more details</option>
                                    </select>

                                    <textarea class="form-control mb-4 py-2 rounded-1 text-muted bg-light border-0" rows="3">Hello,
I'm interested in [ <?= $PropertyDetails->PropertyTitle ?? "" ?> ]</textarea>
                                    
                                    <!-- Buttons -->
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-primary-custom flex-fill py-2 rounded-1 fw-bold border-0 shadow-sm">Send</button>
                                        <button type="button" class="btn btn-light flex-fill py-2 rounded-1 fw-bold px-1 border shadow-sm text-primary-custom" style="font-size: 14px;">
                                            <i class="fa-solid fa-phone me-1"></i> Call
                                        </button>
                                        <button type="button" class="btn btn-light flex-fill py-2 rounded-1 fw-bold px-1 border shadow-sm text-success" style="font-size: 14px;">
                                            <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Schedule a tour Tab -->
                            <div class="tab-pane fade p-4" id="schedule-tour" role="tabpanel" aria-labelledby="schedule-tour-tab">
                                <h5 class="fw-bold text-dark mb-4">Schedule a tour</h5>
                                
                                <!-- Dates -->
                                <div class="d-flex justify-content-between align-items-center mb-4 position-relative">
                                    <button class="btn btn-sm btn-light text-primary-custom bg-white border shadow-sm position-absolute start-0 z-1 translate-middle-x rounded-circle date-prev" style="width:30px; height:30px; display:flex; align-items:center; justify-content:center; left:-10px;"><i class="fa-solid fa-arrow-left"></i></button>
                                    
                                    <div class="swiper mySwiperDates w-100 px-1 mx-3">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide text-center border rounded-2 py-2 bg-white cursor-pointer">
                                                <div class="small text-muted" style="font-size:13px;">Wed</div>
                                                <div class="fw-bold fs-5 text-dark" style="line-height:1.2;">17</div>
                                                <div class="small text-muted" style="font-size:13px;">Jun</div>
                                            </div>
                                            <div class="swiper-slide text-center border border-primary rounded-2 py-2 bg-white cursor-pointer" style="border-color:#0066ff !important; box-shadow: 0 0 5px rgba(0,102,255,0.2);">
                                                <div class="small text-primary-custom" style="font-size:13px;">Thu</div>
                                                <div class="fw-bold fs-5 text-primary-custom" style="line-height:1.2;">18</div>
                                                <div class="small text-primary-custom" style="font-size:13px;">Jun</div>
                                            </div>
                                            <div class="swiper-slide text-center border rounded-2 py-2 bg-white cursor-pointer">
                                                <div class="small text-muted" style="font-size:13px;">Fri</div>
                                                <div class="fw-bold fs-5 text-dark" style="line-height:1.2;">19</div>
                                                <div class="small text-muted" style="font-size:13px;">Jun</div>
                                            </div>
                                            <div class="swiper-slide text-center border rounded-2 py-2 bg-white cursor-pointer">
                                                <div class="small text-muted" style="font-size:13px;">Sat</div>
                                                <div class="fw-bold fs-5 text-dark" style="line-height:1.2;">20</div>
                                                <div class="small text-muted" style="font-size:13px;">Jun</div>
                                            </div>
                                            <div class="swiper-slide text-center border rounded-2 py-2 bg-white cursor-pointer">
                                                <div class="small text-muted" style="font-size:13px;">Sun</div>
                                                <div class="fw-bold fs-5 text-dark" style="line-height:1.2;">21</div>
                                                <div class="small text-muted" style="font-size:13px;">Jun</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button class="btn btn-sm btn-light text-primary-custom bg-white border shadow-sm position-absolute end-0 z-1 translate-middle-x rounded-circle date-next" style="width:30px; height:30px; display:flex; align-items:center; justify-content:center; right:-10px;"><i class="fa-solid fa-arrow-right"></i></button>
                                </div>

                                <select class="form-select mb-4 py-2 rounded-1 text-muted bg-light border-0 shadow-sm">
                                    <option>Please select the time</option>
                                    <option>09:00 AM</option>
                                    <option>10:00 AM</option>
                                </select>

                                <div class="d-flex bg-light p-1 rounded-2 mb-4 border">
                                    <input type="radio" class="btn-check" name="tour_type" id="tour_in_person" autocomplete="off" checked>
                                    <label class="btn flex-fill rounded-2 border-0 fw-bold py-2 tour-type-btn text-muted m-0" for="tour_in_person"><i class="fa-regular fa-user me-2"></i> In Person</label>

                                    <input type="radio" class="btn-check" name="tour_type" id="tour_video" autocomplete="off">
                                    <label class="btn flex-fill rounded-2 border-0 fw-bold py-2 tour-type-btn text-muted m-0" for="tour_video"><i class="fa-solid fa-video me-2"></i> Video Chat</label>
                                </div>

                                <h6 class="fw-bold text-dark mb-3">Your information</h6>
                                
                                <form>
                                    <input type="text" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Name">
                                    <input type="email" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Email">
                                    <input type="tel" class="form-control mb-3 py-2 rounded-1 bg-light border-0" placeholder="Phone">
                                    
                                    <select class="form-select mb-3 py-2 rounded-1 text-muted bg-light border-0">
                                        <option>What are you looking to do?</option>
                                    </select>

                                    <textarea class="form-control mb-4 py-2 rounded-1 text-muted bg-light border-0" rows="4">I would like to schedule a tour for [ <?= $PropertyDetails->PropertyTitle ?? "" ?> ].</textarea>
                                    
                                    <button type="button" class="btn btn-primary-custom w-100 py-3 rounded-1 fw-bold fs-6 border-0 shadow-sm mt-2">Send Request</button>
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
</body>
</html>
<?php endif; ?>
