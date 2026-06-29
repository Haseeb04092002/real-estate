<?php
defined('BASEPATH') or exit('No direct script access allowed');

$UserId = $this->session->userdata('user_id');
$UserName = $this->session->userdata('user_name');

$UserDocStatus = $this->getlist_model->getFieldsMultipleConditions('tbl_documents', '*', "WHERE ReferenceId = '$UserId' AND Reference = 'Client'", 2);

// --------- all favourites properties ------//
$arrFavProperties = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_favourites', '*', "WHERE UserId = '$UserId' AND IsFavourite = 1");

// --------- all requests ------//
$arrOutRequests = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_inspection', '*', "WHERE InspectionStatus = 'Pending' AND RequestedBy = '$UserId'");
$NumOutPendingRequests = ($arrOutRequests) ? count($arrOutRequests) : 0;

$arrInRequests = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_inspection', '*', "WHERE InspectionStatus = 'Pending' AND SellerId = '$UserId'");
$NumInPendingRequests = ($arrInRequests) ? count($arrInRequests) : 0;

$arrActiveRequests = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_inspection', '*', "WHERE InspectionStatus = 'Accepted' AND RequestedBy = '$UserId'");
$NumActiveRequests = ($arrActiveRequests) ? count($arrActiveRequests) : 0;

// --------- all properties ------//
$arrProperties = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', '*', "WHERE ClientId = '$UserId' ORDER BY PropertyId DESC LIMIT 0,9");

// --------- counting all properties ------//
$all_listings = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'COUNT(*)', "WHERE ClientId = '$UserId'", 1);
$all_listings = $all_listings ?? '0';

// --------- counting all acive properties ------//
$active_listings = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'COUNT(*)', "WHERE ClientId = '$UserId' AND IsDeleted = '0'", 1);
$active_listings = $active_listings ?? '0';

// --------- counting all inactive properties ------//
$inactive_listings = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'COUNT(*)', "WHERE ClientId = '$UserId' AND IsDeleted = '1'", 1);
$inactive_listings = $inactive_listings ?? '0';

// --------- counting all rent types properties ------//
$all_Rent_listings = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'COUNT(*)', "WHERE ClientId = '$UserId' AND ListType = 'Rent' AND IsDeleted = '0'", 1);
$all_Rent_listings = $all_Rent_listings ?? '0';

// --------- counting all sale types properties ------//
$all_Sale_listings = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'COUNT(*)', "WHERE ClientId = '$UserId' AND ListType = 'Sale' AND IsDeleted = '0'", 1);
$all_Sale_listings = $all_Sale_listings ?? '0';

$Message_Box = 'd-none';
if (empty($arrProperties)) {
    $Message_Box = 'd-block';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $this->load->view('components/header_meta');
    $this->load->view('components/css_links');
    ?>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0d6efd;
            --secondary: #6c757d;
            --success: #198754;
            --danger: #dc3545;
            --warning: #ffc107;
            --light-bg: #f5f7fb;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--light-bg);
        }

        .dashboard-container {
            padding: 30px;
        }

        /* Alert Banner */
        .verification-banner {
            background: linear-gradient(135deg, #fff3cd, #ffe69c);
            border: none;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,.06);
        }

        /* Section Title */
        .section-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #212529;
        }

        /* Stats Cards */
        .stat-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            transition: .3s;
            box-shadow: 0 5px 20px rgba(0,0,0,.06);
            background: white;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .bg-soft-primary { background: rgba(13, 110, 253, .15); color: var(--primary); }
        .bg-soft-success { background: rgba(25, 135, 84, .15); color: var(--success); }
        .bg-soft-danger { background: rgba(220, 53, 69, .15); color: var(--danger); }
        .bg-soft-warning { background: rgba(255, 193, 7, .15); color: #b78103; }

        .stat-number {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--secondary);
            font-size: 14px;
        }

        /* Main Cards */
        .dashboard-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,.06);
            overflow: hidden;
        }

        .dashboard-card .card-header {
            background: white;
            border-bottom: 1px solid #edf0f5;
            padding: 18px 25px;
            font-weight: 700;
        }

        /* Inquiry */
        .nav-pills .nav-link {
            border-radius: 12px;
            font-weight: 600;
            color: #555;
            margin-right: 10px;
        }

        .nav-pills .nav-link.active {
            background: var(--primary);
        }

        .inquiry-item {
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 12px;
            margin-bottom: 12px;
        }

        /* Property Cards */
        .property-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,.06);
            transition: .3s;
            height: 100%;
        }

        .property-card:hover {
            transform: translateY(-6px);
        }

        .property-image {
            height: 220px;
            object-fit: cover;
            width: 100%;
        }

        .property-content {
            padding: 18px;
        }

        .property-price {
            color: var(--primary);
            font-size: 22px;
            font-weight: 800;
        }

        .property-location {
            color: var(--secondary);
            font-size: 14px;
        }

        .property-badge {
            position: absolute;
            top: 15px;
            right: 15px;
        }

        .saved-property-card {
            border: 1px solid #ececec;
            border-radius: 15px;
            overflow: hidden;
            background: white;
        }

        .saved-property-card img {
            height: 180px;
            object-fit: cover;
        }

        .saved-property-content {
            padding: 15px;
        }

        .saved-price {
            color: var(--primary);
            font-weight: 700;
            font-size: 18px;
        }

        .view-all-btn {
            font-weight: 600;
            text-decoration: none;
        }

        .card-footer-custom {
            background: white;
            border-top: 1px solid #eee;
            padding: 15px;
        }

        @media(max-width:768px) {
            .dashboard-container { padding: 15px; }
            .stat-number { font-size: 24px; }
        }

        .verification-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }

        .verification-item:last-child { border-bottom: none; }
        .verification-item span:first-child { font-weight: 500; }
        .badge { padding: 7px 12px; border-radius: 20px; }
    </style>
</head>
<body>
    <div class="container-fluid bg-white p-0">
        <?php $this->load->view('components/header', ['ListingPages' => 'no']); ?>
    </div>

    <!-- <div class="container-fluid dashboard-container"> -->
    <div class="w-75 mx-auto dashboard-container">

        <!-- Alert -->
        <div class="verification-banner mb-4">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <h5 class="fw-bold mb-2">
                        <i class="bi bi-shield-check me-2"></i>
                        Build trust and attract more buyers!
                    </h5>
                    <p class="mb-0">Verify your profile by sharing a few quick details about yourself.</p>
                </div>
                <div class="col-lg-3 text-lg-end mt-3 mt-lg-0">
                    <?php if(!empty($UserDocStatus)){ ?>
                        <a href="<?= site_url('Properties/property_user_docs'); ?>" class="btn btn-secondary btn-lg">View All Documents</a>
                    <?php } else { ?>
                        <a href="<?= site_url('Properties/property_user_docs'); ?>" class="btn btn-primary btn-lg">Verify Profile</a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <h4 class="section-title">Dashboard Overview</h4>
        <div class="row g-4 mb-5">
            <div class="col-xl col-md-4 col-sm-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="stat-icon bg-soft-primary"><i class="bi bi-building"></i></div>
                        <div class="stat-number"><?= $all_listings; ?></div>
                        <div class="stat-label">Total Listings</div>
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-4 col-sm-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="stat-icon bg-soft-success"><i class="bi bi-check-circle"></i></div>
                        <div class="stat-number"><?= $active_listings; ?></div>
                        <div class="stat-label">Active Listings</div>
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-4 col-sm-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="stat-icon bg-soft-danger"><i class="bi bi-x-circle"></i></div>
                        <div class="stat-number"><?= $inactive_listings; ?></div>
                        <div class="stat-label">Inactive Listings</div>
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-4 col-sm-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="stat-icon bg-soft-primary"><i class="bi bi-cash-stack"></i></div>
                        <div class="stat-number"><?= $all_Sale_listings; ?></div>
                        <div class="stat-label">For Sale</div>
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-4 col-sm-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="stat-icon bg-soft-warning"><i class="bi bi-key"></i></div>
                        <div class="stat-number"><?= $all_Rent_listings; ?></div>
                        <div class="stat-label">For Rent</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row g-4 mb-5">
            <!-- Inquiry Requests -->
            <div class="col-lg-7">
                <div class="card dashboard-card h-100">
                    <div class="card-header">Inquiry Requests</div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        <ul class="nav nav-pills mb-4">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#activeInquiry">Active (<?= $NumActiveRequests ?>)</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pendingSeller">Pending To Seller (<?= $NumInPendingRequests ?>)</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pendingBuyer">Pending From Buyer (<?= $NumOutPendingRequests ?>)</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="activeInquiry">
                                <?php if(empty($arrActiveRequests)): ?>
                                    <div class="text-muted text-center p-3">No active inquiries found.</div>
                                <?php else: ?>
                                    <?php foreach($arrActiveRequests as $req): ?>
                                        <div class="inquiry-item">
                                            <strong>Inquiry #<?= $req->InspectionId ?></strong>
                                            <div class="text-muted">Status: <?= $req->InspectionStatus ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="tab-pane fade" id="pendingSeller">
                                <?php if(empty($arrInRequests)): ?>
                                    <div class="text-muted text-center p-3">No pending inquiries to you.</div>
                                <?php else: ?>
                                    <?php foreach($arrInRequests as $req): ?>
                                        <div class="inquiry-item">
                                            <strong>Inquiry #<?= $req->InspectionId ?></strong>
                                            <div class="text-muted">Requested viewing for property.</div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="tab-pane fade" id="pendingBuyer">
                                <?php if(empty($arrOutRequests)): ?>
                                    <div class="text-muted text-center p-3">No pending inquiries from you.</div>
                                <?php else: ?>
                                    <?php foreach($arrOutRequests as $req): ?>
                                        <div class="inquiry-item">
                                            <strong>Inquiry #<?= $req->InspectionId ?></strong>
                                            <div class="text-muted">Awaiting response from seller.</div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Verification Status -->
            <div class="col-lg-5">
                <div class="card dashboard-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Profile Verification</span>
                        <a href="<?= site_url('Properties/property_user_docs'); ?>" class="btn btn-primary btn-sm">Complete Verification</a>
                    </div>
                    <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                        <div class="accordion accordion-flush" id="verificationAccordion">
                            <?php if (empty($UserDocStatus)): ?>
                                <div class="text-muted text-center p-4">No documents uploaded yet.</div>
                            <?php else: ?>
                                <?php foreach ($UserDocStatus as $index => $doc): 
                                    $docTitle = $doc->DocumentTitle ?? 'Document';
                                    $status = $doc->VerificationStatus ?? 'Pending';
                                    if ($status == 'Approved') {
                                        $badgeClass = 'bg-success';
                                    } else if ($status == 'Rejected') {
                                        $badgeClass = 'bg-danger';
                                    } else {
                                        $badgeClass = 'bg-warning text-dark';
                                        $status = 'Pending';
                                    }
                                    $collapseId = "collapseDoc" . $index;
                                    $headingId = "headingDoc" . $index;
                                ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="<?= $headingId ?>">
                                        <button class="accordion-button collapsed px-4" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>">
                                            <div class="d-flex justify-content-between align-items-center w-100 pe-3">
                                                <span class="fw-medium"><?= $docTitle ?></span>
                                                <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="<?= $collapseId ?>" class="accordion-collapse collapse" data-bs-parent="#verificationAccordion">
                                        <div class="accordion-body px-4 pb-4 pt-2">
                                            <?php if (!empty($doc->FileName)): ?>
                                                <div class="mb-3 text-center bg-light rounded p-2">
                                                    <?php 
                                                    $ext = pathinfo($doc->FileName, PATHINFO_EXTENSION);
                                                    if (in_array(strtolower($ext), ['jpg','jpeg','png','gif'])): ?>
                                                        <img src="<?= base_url('uploads/Client/'.$UserId.'/'.$doc->FileName) ?>" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                                                    <?php else: ?>
                                                        <a href="<?= base_url('uploads/Client/'.$UserId.'/'.$doc->FileName) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                                            <i class="bi bi-file-earmark-text"></i> View Document
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="small text-muted mb-3">
                                                <?php if (!empty($doc->ReferenceNumber)): ?>
                                                    <div class="mb-1"><strong class="text-dark">Ref Number:</strong> <?= $doc->ReferenceNumber ?></div>
                                                <?php endif; ?>
                                                <?php if (!empty($doc->ExpiryDate)): ?>
                                                    <div class="mb-1"><strong class="text-dark">Expires:</strong> <?= $doc->ExpiryDate ?></div>
                                                <?php endif; ?>
                                                <?php if (!empty($doc->Remarks)): ?>
                                                    <div class="mb-1"><strong class="text-dark">Remarks:</strong> <?= $doc->Remarks ?></div>
                                                <?php endif; ?>
                                                <div class="mb-1"><strong class="text-dark">Uploaded:</strong> <?= date('d M Y', strtotime($doc->AddedOn ?? date('Y-m-d'))) ?></div>
                                            </div>
                                            
                                            <?php if ($status != 'Approved'): ?>
                                                <div class="d-flex gap-2 border-top pt-3 mt-3">
                                                    <a href="<?= site_url('Properties/property_user_docs') ?>" class="btn btn-sm btn-outline-primary flex-fill"><i class="bi bi-pencil"></i> Edit</a>
                                                    <a href="javascript:void(0)" onclick="customAlert('Notice', 'Document deletion to be handled by backend.', 'info')" class="btn btn-sm btn-outline-danger flex-fill"><i class="bi bi-trash"></i> Delete</a>
                                                </div>
                                            <?php endif; ?>
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

        <!-- Saved Properties -->
        <div class="card dashboard-card mb-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Saved Properties</span>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <?php if (empty($arrFavProperties)): ?>
                        <div class="col-12"><div class="text-muted text-center">No Saved Properties</div></div>
                    <?php else: ?>
                        <?php foreach ($arrFavProperties as $key => $fav):
                            $favPropertyId = $fav->PropertyId;
                            $favProp = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', '*', "WHERE PropertyId = '$favPropertyId'", 2);
                            if($favProp) {
                                $favTitle = $favProp->PropertyTitle ? $favProp->PropertyTitle : "Property Title";
                                $favPrice = $favProp->TotalPrice ? $favProp->TotalPrice : "0";
                                $favAddress = $favProp->MailingAddress ? $favProp->MailingAddress : "Mailing Address";
                                $favImage = $this->getlist_model->getFieldsMultipleConditions('tbl_documents', 'FileName', "WHERE Reference = 'Properties' AND ReferenceId = '$favPropertyId'", 1);
                                $favImgSrc = (!empty($favImage) && is_string($favImage)) ? base_url('uploads/Properties/'.$favPropertyId.'/images/'.$favImage) : base_url('assets/images/property-1.jpg');
                        ?>
                        <div class="col-lg-4">
                            <div class="saved-property-card h-100">
                                <img src="<?= $favImgSrc ?>" class="img-fluid w-100">
                                <div class="saved-property-content">
                                    <h6><?= $favTitle ?></h6>
                                    <div class="saved-price">$<?= number_format($favPrice) ?></div>
                                    <small class="text-muted"><i class="bi bi-geo-alt me-1"></i><?= $favAddress ?></small>
                                </div>
                            </div>
                        </div>
                        <?php } endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- My Listings -->
        <div class="card dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>My Recent Listings</span>
                <a href="<?= site_url('Properties/AddListing'); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Add Property
                </a>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <?php if(empty($arrProperties)): ?>
                        <div class="col-12"><div class="text-muted text-center">No Recent Listings</div></div>
                    <?php else: ?>
                        <?php foreach ($arrProperties as $key => $value): 
                              $this->load->view('components/property_card', ['value' => $value, 'UserId' => $UserId]);
                        endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if (!empty($arrProperties)): ?>
                <div class="text-center mt-4">
                    <a href="<?= site_url('Properties/AllListings') ?>" class="btn btn-outline-primary px-4">View All My Properties</a>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <?php $this->load->view('components/footer.php'); ?>
    <?php $this->load->view('components/js_links.php'); ?>
</body>
</html>
