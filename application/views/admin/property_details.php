<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Edit Property'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
    <style>
        body { background-color: #f8f9fa; }
        
        /* New Modern UI Styles */
        .property-header {
            background: linear-gradient(135deg, #1F509A 0%, #153a75 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(31, 80, 154, 0.2);
        }
        .property-image {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            object-fit: cover;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px 20px;
            text-align: center;
            backdrop-filter: blur(10px);
        }
        .stat-card h3 { margin: 0; font-weight: 700; font-size: 24px; }
        .stat-card small { opacity: 0.8; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; }
        
        .nav-modern {
            background: white;
            padding: 10px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            margin-bottom: 25px;
        }
        .nav-modern .nav-link {
            color: #6c757d;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 20px;
            transition: all 0.3s;
            border: none;
        }
        .nav-modern .nav-link:hover {
            background-color: #f1f3f5;
        }
        .nav-modern .nav-link.active {
            background-color: #1F509A;
            color: white;
            box-shadow: 0 4px 10px rgba(31, 80, 154, 0.3);
        }
        
        .modern-card {
            background: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            margin-bottom: 25px;
            overflow: hidden;
        }
        .modern-card-header {
            background: transparent;
            border-bottom: 1px solid #f1f3f5;
            padding: 20px 25px;
            font-weight: 700;
            font-size: 16px;
            color: #2b3445;
        }
        .modern-card-body {
            padding: 25px;
        }

        .info-group { margin-bottom: 20px; }
        .info-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #8c98a4;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: block;
        }
        .info-value {
            font-size: 15px;
            color: #2b3445;
            font-weight: 500;
        }

        .form-label { font-weight: 600; color: #495057; font-size: 14px; }
        .form-control, .form-select { border-radius: 8px; }
        .feature-checkbox { margin-bottom: 0.5rem; }
    </style>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">
            
            <div class="mb-3">
                <a href="<?= site_url('Admin/property_management') ?>" class="text-decoration-none text-muted fw-bold">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to Properties
                </a>
            </div>

            <!-- Property Header -->
            <div class="property-header">
                <div class="row align-items-center">
                    <div class="col-md-7 d-flex align-items-center">
                        <?php 
                        $headerImage = base_url('assets/images/placeholder.jpg');
                        if (!empty($media)) {
                            foreach($media as $m) {
                                $ext = strtolower(pathinfo($m->FileName, PATHINFO_EXTENSION));
                                if(in_array($ext, ['jpg','jpeg','png','webp'])) {
                                    $headerImage = base_url("uploads/Properties/{$property->PropertyId}/images/{$m->FileName}");
                                    break;
                                }
                            }
                        }
                        ?>
                        <img src="<?= $headerImage ?>" class="property-image me-4" alt="Property Image">
                        <div>
                            <h2 class="fw-bold mb-1"><?= htmlspecialchars($property->PropertyTitle ?? 'Untitled Property') ?></h2>
                            <p class="mb-2 text-white-50"><i class="fa-solid fa-location-dot me-2"></i><?= htmlspecialchars($property->MailingAddress ?? 'Location Not Specified') ?></p>
                            <div>
                                <span class="badge bg-light text-dark rounded-pill px-3 shadow-sm fs-6 me-2">ID: <?= $property->PropertyId ?></span>
                                <span class="badge bg-primary rounded-pill px-3 shadow-sm fs-6 me-2"><?= $property->ListType ?></span>
                                <?php if($property->PropertyStatus == 'vacant'): ?>
                                    <span class="badge bg-success rounded-pill px-3 shadow-sm fs-6">Vacant</span>
                                <?php elseif($property->PropertyStatus == 'occupied'): ?>
                                    <span class="badge bg-warning text-dark rounded-pill px-3 shadow-sm fs-6">Occupied</span>
                                <?php else: ?>
                                    <span class="badge bg-info text-dark rounded-pill px-3 shadow-sm fs-6"><?= ucfirst($property->PropertyStatus ?? '') ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="d-flex justify-content-md-end justify-content-start mt-4 mt-md-0 gap-3">
                            <div class="stat-card">
                                <h3>$<?= number_format($property->TotalPrice) ?></h3>
                                <small>Total Price</small>
                            </div>
                            <div class="stat-card">
                                <h3><?= $property->Views ?></h3>
                                <small>Views</small>
                            </div>
                            <div class="stat-card">
                                <h3><?= $property->DocsCompletion ?></h3>
                                <small>Docs</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <ul class="nav nav-pills nav-modern" id="propertyTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab"><i class="fa-solid fa-circle-info me-2"></i> Basic Info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="location-tab" data-bs-toggle="tab" data-bs-target="#location" type="button" role="tab"><i class="fa-solid fa-map-location-dot me-2"></i> Location</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab"><i class="fa-solid fa-list-check me-2"></i> Features</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media" type="button" role="tab"><i class="fa-solid fa-images me-2"></i> Media Gallery</button>
                </li>
            </ul>

            <form id="editPropertyForm">
                <input type="hidden" name="PropertyId" value="<?= $property->PropertyId ?>">
                
                <div class="tab-content" id="propertyTabsContent">
                    
                    <!-- Tab 1: Basic Info -->
                    <div class="tab-pane fade show active" id="basic" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="modern-card h-100">
                                    <div class="modern-card-header">
                                        Primary Details
                                    </div>
                                    <div class="modern-card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label class="form-label">Property Title</label>
                                                <input type="text" class="form-control" name="PropertyTitle" value="<?= htmlspecialchars($property->PropertyTitle ?? '') ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" name="PropertyDescription" rows="5"><?= htmlspecialchars($property->PropertyDescription ?? '') ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Price (Total)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" class="form-control" name="TotalPrice" value="<?= $property->TotalPrice ?>" step="0.01">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Property Type</label>
                                                <select class="form-select" name="PropertyTypeId">
                                                    <option value="">Select Type</option>
                                                    <?php foreach($property_types as $pt): ?>
                                                        <option value="<?= $pt->TypeId ?>" <?= $property->PropertyTypeId == $pt->TypeId ? 'selected' : '' ?>><?= $pt->Title ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Status</label>
                                                <select class="form-select" name="PropertyStatus">
                                                    <option value="vacant" <?= $property->PropertyStatus == 'vacant' ? 'selected' : '' ?>>Vacant</option>
                                                    <option value="occupied" <?= $property->PropertyStatus == 'occupied' ? 'selected' : '' ?>>Occupied</option>
                                                    <option value="rented" <?= $property->PropertyStatus == 'rented' ? 'selected' : '' ?>>Rented</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">List Type</label>
                                                <select class="form-select" name="ListType">
                                                    <option value="Sale" <?= $property->ListType == 'Sale' ? 'selected' : '' ?>>Sale</option>
                                                    <option value="Rent" <?= $property->ListType == 'Rent' ? 'selected' : '' ?>>Rent</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Covered Area (sqft)</label>
                                                <input type="number" class="form-control" name="CoveredArea" value="<?= $property->CoveredArea ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="modern-card h-100">
                                    <div class="modern-card-header">
                                        Owner Information
                                    </div>
                                    <div class="modern-card-body">
                                        <?php if($property->OwnerName): ?>
                                            <div class="info-group">
                                                <span class="info-label"><i class="fa-solid fa-user me-1"></i> Owner Name</span>
                                                <span class="info-value"><?= htmlspecialchars($property->OwnerName ?? '') ?></span>
                                            </div>
                                            <div class="info-group">
                                                <span class="info-label"><i class="fa-solid fa-envelope me-1"></i> Email Address</span>
                                                <span class="info-value"><a href="mailto:<?= htmlspecialchars($property->OwnerEmail ?? '') ?>"><?= htmlspecialchars($property->OwnerEmail ?? '') ?></a></span>
                                            </div>
                                            <div class="info-group">
                                                <span class="info-label"><i class="fa-solid fa-phone me-1"></i> Phone Number</span>
                                                <span class="info-value"><?= htmlspecialchars($property->OwnerPhone ?? '') ?></span>
                                            </div>
                                            <div class="mt-4">
                                                <a href="<?= site_url('Admin/user_details/'.$property->ClientId) ?>" class="btn btn-outline-primary w-100"><i class="fa-solid fa-external-link-alt me-2"></i> View Profile</a>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-muted text-center py-5">No owner assigned to this property.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab 2: Location -->
                    <div class="tab-pane fade" id="location" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="modern-card h-100">
                                    <div class="modern-card-header">
                                        Physical Address
                                    </div>
                                    <div class="modern-card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label class="form-label">Full Mailing Address</label>
                                                <input type="text" class="form-control" name="MailingAddress" value="<?= htmlspecialchars($property->MailingAddress ?? '') ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Street Name</label>
                                                <input type="text" class="form-control" name="StreetName" value="<?= htmlspecialchars($property->StreetName ?? '') ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Street Number</label>
                                                <input type="text" class="form-control" name="StreetNumber" value="<?= htmlspecialchars($property->StreetNumber ?? '') ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Building Number</label>
                                                <input type="text" class="form-control" name="BuildingNumber" value="<?= htmlspecialchars($property->BuildingNumber ?? '') ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Zip Code</label>
                                                <input type="text" class="form-control" name="ZipCode" value="<?= htmlspecialchars($property->ZipCode ?? '') ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label class="form-label">City</label>
                                                <select class="form-select" name="CityId">
                                                    <option value="">Select City</option>
                                                    <?php foreach($cities as $ct): ?>
                                                        <option value="<?= $ct->CityId ?>" <?= $property->CityId == $ct->CityId ? 'selected' : '' ?>><?= htmlspecialchars($ct->CityName ?? '') ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="modern-card h-100 border-start border-danger border-4">
                                    <div class="modern-card-header bg-light text-danger">
                                        <i class="fa-solid fa-map-location me-2"></i> Location Snapshot
                                    </div>
                                    <div class="modern-card-body">
                                        <div class="info-group">
                                            <span class="info-label">Street Name</span>
                                            <span class="info-value" id="snap_StreetName"><?= htmlspecialchars($property->StreetName ?? 'N/A') ?></span>
                                        </div>
                                        <div class="info-group">
                                            <span class="info-label">Street Number</span>
                                            <span class="info-value" id="snap_StreetNumber"><?= htmlspecialchars($property->StreetNumber ?? 'N/A') ?></span>
                                        </div>
                                        <div class="info-group">
                                            <span class="info-label">Building Number</span>
                                            <span class="info-value" id="snap_BuildingNumber"><?= htmlspecialchars($property->BuildingNumber ?? 'N/A') ?></span>
                                        </div>
                                        <div class="info-group">
                                            <span class="info-label">Zip Code</span>
                                            <span class="info-value" id="snap_ZipCode"><?= htmlspecialchars($property->ZipCode ?? 'N/A') ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Features -->
                    <div class="tab-pane fade" id="features" role="tabpanel">
                        <div class="modern-card">
                            <div class="modern-card-header">
                                Structural Specifications
                            </div>
                            <div class="modern-card-body bg-light">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Year Built</label>
                                        <input type="date" class="form-control bg-white" name="BuiltInYear" value="<?= $features->BuiltInYear ?? '' ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Bedrooms</label>
                                        <input type="number" class="form-control bg-white" name="Bedrooms" value="<?= $features->Bedrooms ?? '' ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Bathrooms</label>
                                        <input type="number" class="form-control bg-white" name="Bathrooms_feature" value="<?= $features->Bathrooms ?? '' ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Parking Spaces</label>
                                        <input type="number" class="form-control bg-white" name="ParkingSpaces" value="<?= $features->ParkingSpaces ?? '' ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Floors</label>
                                        <input type="number" class="form-control bg-white" name="Floors" value="<?= $features->Floors ?? '' ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Kitchens</label>
                                        <input type="number" class="form-control bg-white" name="Kitchens" value="<?= $features->Kitchens ?? '' ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Store Rooms</label>
                                        <input type="number" class="form-control bg-white" name="StoreRooms" value="<?= $features->StoreRooms ?? '' ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Servant Quarters</label>
                                        <input type="number" class="form-control bg-white" name="ServantQuarters" value="<?= $features->ServantQuarters ?? '' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modern-card">
                            <div class="modern-card-header">
                                Amenities & Extra Features
                            </div>
                            <div class="modern-card-body">
                                <div class="row">
                                    <?php 
                                    $bool_features = [
                                        'IsDoubleGlazedWindows' => 'Double Glazed Windows',
                                        'IsCentralAirConditioning' => 'Central Air Conditioning',
                                        'IsCentralHeating' => 'Central Heating',
                                        'IsWasteDisposal' => 'Waste Disposal',
                                        'IsFurnished' => 'Furnished',
                                        'IsDrawingRoom' => 'Drawing Room',
                                        'IsDiningRoom' => 'Dining Room',
                                        'IsStudyRoom' => 'Study Room',
                                        'IsPrayerRoom' => 'Prayer Room',
                                        'IsPowderRoom' => 'Powder Room',
                                        'IsGym' => 'Gym',
                                        'IsSteamRoom' => 'Steam Room',
                                        'IsLoungeRoom' => 'Lounge Room',
                                        'IsLaundryRoom' => 'Laundry Room',
                                        'IsBroadbandInternetAccess' => 'Broadband Internet',
                                        'IsTVReady' => 'TV Ready',
                                        'IsIntercom' => 'Intercom',
                                        'IsConferenceRoom' => 'Conference Room',
                                        'IsCommunityLawn' => 'Community Lawn',
                                        'IsCommunitySwimmingPool' => 'Community Swimming Pool',
                                        'IsCommunityGym' => 'Community Gym',
                                        'IsFirstAid' => 'First Aid',
                                        'IsDayCareCenter' => 'Day Care Center',
                                        'IsKidsPlayArea' => 'Kids Play Area',
                                        'IsBarbequeArea' => 'Barbeque Area',
                                        'IsMosque' => 'Mosque',
                                        'IsCommunityCentre' => 'Community Centre',
                                        'IsLawnGarden' => 'Lawn/Garden',
                                        'IsSwimmingPool' => 'Swimming Pool',
                                        'IsSauna' => 'Sauna',
                                        'IsJacuzzi' => 'Jacuzzi'
                                    ];

                                    foreach($bool_features as $field => $label):
                                        $checked = (!empty($features->$field) && $features->$field == 1) ? 'checked' : '';
                                    ?>
                                        <div class="col-md-3 feature-checkbox mb-3">
                                            <div class="form-check form-switch p-0 d-flex align-items-center">
                                                <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" name="<?= $field ?>" id="<?= $field ?>" value="1" <?= $checked ?> style="width:2.5em; height:1.25em;">
                                                <label class="form-check-label ms-2 text-muted" for="<?= $field ?>"><?= $label ?></label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Media -->
                    <div class="tab-pane fade" id="media" role="tabpanel">
                        <div class="modern-card">
                            <div class="modern-card-header d-flex justify-content-between align-items-center">
                                <span>Uploaded Media</span>
                                <span class="badge bg-primary rounded-pill"><?= count($media ?? []) ?> Files</span>
                            </div>
                            <div class="modern-card-body bg-light">
                                <div class="row g-4">
                                    <?php if(empty($media)): ?>
                                        <div class="col-12 text-center py-5">
                                            <i class="fa-solid fa-photo-film text-muted" style="font-size: 40px; opacity:0.5;"></i>
                                            <p class="text-muted mt-3 mb-0">No media found for this property.</p>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach($media as $m): 
                                            // rudimentary check for video extensions
                                            $ext = strtolower(pathinfo($m->FileName, PATHINFO_EXTENSION));
                                            $isVideo = in_array($ext, ['mp4','webm','ogg','mov']);
                                            $folder = $isVideo ? 'videos' : 'images';
                                            $path = base_url("uploads/Properties/{$property->PropertyId}/{$folder}/{$m->FileName}");
                                        ?>
                                            <div class="col-md-4 col-lg-3">
                                                <div class="card shadow-sm h-100 border-0 rounded-3 overflow-hidden">
                                                    <?php if($isVideo): ?>
                                                        <div class="ratio ratio-16x9">
                                                            <video controls src="<?= $path ?>" class="card-img-top object-fit-cover"></video>
                                                        </div>
                                                    <?php else: ?>
                                                        <a href="<?= $path ?>" target="_blank">
                                                            <img src="<?= $path ?>" class="card-img-top object-fit-cover" style="height:150px; transition: transform 0.3s;" alt="Property Media" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                                        </a>
                                                    <?php endif; ?>
                                                    <div class="card-footer bg-white border-top-0 py-3">
                                                        <p class="text-muted text-break mb-0" style="font-size:12px;"><i class="<?= $isVideo ? 'fa-solid fa-video' : 'fa-solid fa-image' ?> me-1"></i> <?= $m->FileName ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modern-card mt-4">
                    <div class="modern-card-body d-flex justify-content-between align-items-center">
                        <span class="text-muted small"><i class="fa-solid fa-circle-info me-1"></i> Click save to apply your changes across all tabs.</span>
                        <button type="submit" class="btn btn-primary btn-lg px-5" style="border-radius:10px;"><i class="fa-solid fa-save me-2"></i> Save Property</button>
                    </div>
                </div>
            </form>

        </div>
        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>
    <script src="<?= base_url('assets/js/custom-alerts.js'); ?>"></script>
    <script>
        $(document).ready(function() {
            // Update Location Snapshot in real-time when inputs change
            $('input[name="StreetName"]').on('input', function() { $('#snap_StreetName').text($(this).val() || 'N/A'); });
            $('input[name="StreetNumber"]').on('input', function() { $('#snap_StreetNumber').text($(this).val() || 'N/A'); });
            $('input[name="BuildingNumber"]').on('input', function() { $('#snap_BuildingNumber').text($(this).val() || 'N/A'); });
            $('input[name="ZipCode"]').on('input', function() { $('#snap_ZipCode').text($(this).val() || 'N/A'); });

            $('#editPropertyForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = $(this).serialize();
                const btn = $(this).find('button[type="submit"]');
                const originalText = btn.html();
                
                btn.html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Saving...').prop('disabled', true);
                
                $.ajax({
                    url: '<?= site_url("Admin/api_save_property_details") ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        btn.html(originalText).prop('disabled', false);
                        if(response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Saved Successfully!',
                                text: 'Property details have been updated.',
                                timer: 2000,
                                showConfirmButton: false,
                                background: '#fff',
                                confirmButtonColor: '#1F509A'
                            });
                        } else {
                            Swal.fire('Error', response.message || 'Failed to update property.', 'error');
                        }
                    },
                    error: function() {
                        btn.html(originalText).prop('disabled', false);
                        Swal.fire('Error', 'Server error occurred while saving.', 'error');
                    }
                });
            });
        });
    </script>
</body>
</html>

