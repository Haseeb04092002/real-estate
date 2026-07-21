<?php
defined('BASEPATH') or exit('No direct script access allowed');

$UserId = $this->session->userdata('user_id');
$UserName = $this->session->userdata('user_name');

$UserInfo = $this->getlist_model->getFieldsMultipleConditions('tbl_clients', 'AccountStatus', "WHERE ClientId = '$UserId'", 1);
$isVerified = ($UserInfo === 'Active');

$UserDocStatus = $this->getlist_model->getFieldsMultipleConditions('tbl_client_documents', '*', "WHERE ClientId = '$UserId'", 2);

// --------- all favourites properties ------//
$arrFavProperties = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_favourites', '*', "WHERE UserId = '$UserId' AND IsFavourite = 1");

// --------- all requests ------//
$arrOutRequests = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_inspection', '*', "WHERE InspectionStatus = 'Pending' AND RequestedBy = '$UserId'");
$NumOutPendingRequests = ($arrOutRequests) ? count($arrOutRequests) : 0;

$arrInRequests = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_inspection', '*', "WHERE InspectionStatus = 'Pending' AND SellerId = '$UserId'");
$NumInPendingRequests = ($arrInRequests) ? count($arrInRequests) : 0;

$arrActiveRequests = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_inspection', '*', "WHERE InspectionStatus = 'Accepted' AND RequestedBy = '$UserId'");
$NumActiveRequests = ($arrActiveRequests) ? count($arrActiveRequests) : 0;

$arrChats = [];
$arrOffers = [];

$allRequests = array_merge(
    is_array($arrActiveRequests) ? $arrActiveRequests : [], 
    is_array($arrInRequests) ? $arrInRequests : [], 
    is_array($arrOutRequests) ? $arrOutRequests : []
);

$processedIds = [];
foreach($allRequests as $req) {
    if (in_array($req->InspectionId, $processedIds)) continue;
    $processedIds[] = $req->InspectionId;

    if (strpos($req->Remarks ?? '', 'Action: Make Offer') !== false) {
        $arrOffers[] = $req;
    } else {
        $arrChats[] = $req;
    }
}
$NumChats = count($arrChats);
$NumOffers = count($arrOffers);

// --------- all properties ------//
$arrProperties = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', '*', "WHERE AddedBy = '$UserId' AND IsDeleted = 0 ORDER BY PropertyId DESC LIMIT 0,9");

// --------- counting all properties ------//
$all_listings = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'COUNT(*)', "WHERE AddedBy = '$UserId'", 1);
$all_listings = $all_listings ?? '0';

// --------- counting all acive properties ------//
$active_listings = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'COUNT(*)', "WHERE AddedBy = '$UserId' AND IsDeleted = '0'", 1);
$active_listings = $active_listings ?? '0';

// --------- counting all inactive properties ------//
$inactive_listings = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'COUNT(*)', "WHERE AddedBy = '$UserId' AND IsDeleted = '1'", 1);
$inactive_listings = $inactive_listings ?? '0';

// --------- counting all rent types properties ------//
$all_Rent_listings = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'COUNT(*)', "WHERE AddedBy = '$UserId' AND ListType = 'Rent' AND IsDeleted = '0'", 1);
$all_Rent_listings = $all_Rent_listings ?? '0';

// --------- counting all sale types properties ------//
$all_Sale_listings = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'COUNT(*)', "WHERE AddedBy = '$UserId' AND ListType = 'Sale' AND IsDeleted = '0'", 1);
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
        <?php if(isset($isVerified) && $isVerified): ?>
        <div class="verification-banner mb-4 bg-success border-0 shadow-sm" style="background: linear-gradient(135deg, #d1e7dd, #a3cfbb);">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <h5 class="fw-bold mb-2 text-dark">
                        <i class="bi bi-patch-check-fill text-success me-2"></i>
                        Profile Fully Verified
                    </h5>
                    <p class="mb-0 text-dark">Your profile is verified and active. You can now build trust with buyers and sellers seamlessly.</p>
                </div>
                <div class="col-lg-3 text-lg-end mt-3 mt-lg-0">
                    <a href="<?= site_url('Properties/property_user_docs'); ?>" class="btn btn-success btn-lg shadow-sm">View Docs</a>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="verification-banner mb-4">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <h5 class="fw-bold mb-2">
                        <i class="bi bi-shield-check me-2"></i>
                        Build trust and attract more buyers!
                        <?php if(!empty($UserDocStatus)): ?>
                            <span class="badge bg-warning text-dark ms-2 align-middle fs-6">Submitted - Approval Awaited</span>
                        <?php endif; ?>
                    </h5>
                    <p class="mb-0">Verify your profile by sharing a few quick details about yourself.</p>
                </div>
                <div class="col-lg-3 text-lg-end mt-3 mt-lg-0">
                    <?php if(!empty($UserDocStatus)){ ?>
                        <a href="<?= site_url('Properties/property_user_docs'); ?>" class="btn btn-secondary btn-lg">View Docs</a>
                    <?php } else { ?>
                        <a href="<?= site_url('Properties/property_user_docs'); ?>" class="btn btn-primary btn-lg">Verify Profile</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

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
            <div class="col-lg-6">
                <div class="card dashboard-card h-100">
                    <div class="card-header">Inquiry Requests</div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        <ul class="nav nav-pills mb-4">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#chatsTab">Chats (<?= $NumChats ?>)</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#offersTab">Offers (<?= $NumOffers ?>)</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- Chats Tab -->
                            <div class="tab-pane fade show active" id="chatsTab">
                                <?php if(empty($arrChats)): ?>
                                    <div class="text-muted text-center p-3">No chats found.</div>
                                <?php else: ?>
                                    <div class="chat-list">
                                    <?php foreach($arrChats as $req): 
                                        $parsedName = 'Buyer';
                                        $parsedEmail = '';
                                        $parsedPhone = '';
                                        $parsedMessage = $req->Remarks;
                                        
                                        if (preg_match('/Name:\s*([^\n]+)/', $req->Remarks ?? '', $m)) $parsedName = trim($m[1]);
                                        if (preg_match('/Email:\s*([^\n]+)/', $req->Remarks ?? '', $m)) $parsedEmail = trim($m[1]);
                                        if (preg_match('/Phone:\s*([^\n]+)/', $req->Remarks ?? '', $m)) $parsedPhone = trim($m[1]);
                                        if (preg_match('/Message:\s*(.+)/s', $req->Remarks ?? '', $m)) $parsedMessage = trim($m[1]);
                                        
                                        $initials = strtoupper(substr($parsedName, 0, 1));

                                        $propDetails = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'PropertyTitle, TotalPrice', "WHERE PropertyId = '{$req->PropertyId}'", 2);
                                        $propTitle = $propDetails ? $propDetails->PropertyTitle : 'Unknown Property';
                                        $propPrice = $propDetails ? number_format($propDetails->TotalPrice) : '0';

                                        $propImage = $this->getlist_model->getFieldsMultipleConditions('tbl_property_media', 'FileName', "WHERE PropertyId = '{$req->PropertyId}'", 1);
                                        $propImgSrc = (!empty($propImage) && is_string($propImage)) ? base_url('uploads/Properties/'.$req->PropertyId.'/images/'.$propImage) : base_url('assets/images/property-1.jpg');
                                    ?>
                                        <?php
                                            $isTour = (strpos($req->Remarks ?? '', 'Action: Schedule a Tour') !== false);
                                            $badgeType = $isTour ? 'Tour' : 'Inquiry';
                                            $badgeClass = $isTour ? 'bg-success' : 'bg-primary';
                                        ?>
                                        <!-- Chat Card -->
                                        <div class="inquiry-item d-flex align-items-center cursor-pointer transition-all" data-bs-toggle="modal" data-bs-target="#chatModal_<?= $req->InspectionId ?>" style="cursor: pointer; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 text-white shadow-sm" style="width: 50px; height: 50px; font-size: 20px; font-weight: bold; background: linear-gradient(135deg, #0d6efd, #0dcaf0);">
                                                <?= $initials ?>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="mb-0 fw-bold text-dark text-truncate" style="font-size: 15px;"><?= htmlspecialchars($parsedName) ?></h6>
                                                    <span class="small text-muted" style="font-size: 12px;">#<?= $req->InspectionId ?></span>
                                                </div>
                                                <p class="mb-0 text-muted small text-truncate" style="max-width: 95%;"><?= htmlspecialchars($parsedMessage) ?></p>
                                            </div>
                                            <div class="ms-3 text-end d-flex flex-column align-items-end">
                                                <span class="badge <?= $badgeClass ?> text-white rounded-pill mb-1" style="font-size: 10px;"><?= $badgeType ?></span>
                                                <i class="fa-solid fa-chevron-right text-muted" style="font-size: 12px; opacity: 0.5;"></i>
                                            </div>
                                        </div>

                                        <!-- Chat Modal -->
                                        <div class="modal fade" id="chatModal_<?= $req->InspectionId ?>" tabindex="-1" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content shadow-lg border-0" style="border-radius: 0; overflow: hidden; background: #f8f9fa;">
                                              
                                              <!-- Header -->
                                              <div class="modal-header text-white rounded-0 d-flex flex-column align-items-start" style="background-color: #26a4ff; border-bottom: none; padding: 15px 20px; position: relative;">
                                                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="font-size: 14px; opacity: 1;"></button>
                                                
                                                <div class="d-flex align-items-center mb-1 flex-wrap">
                                                    <h5 class="modal-title fs-6 fw-bold m-0 text-white" style="font-family: 'Heebo', sans-serif;">
                                                        <i class="fa-solid fa-user me-1"></i> <?= htmlspecialchars($parsedName) ?>
                                                    </h5>
                                                    <div style="font-family: 'Heebo', sans-serif; font-size: 12px; opacity: 0.9; margin-left: 10px;" class="d-flex align-items-center flex-wrap">
                                                        <?php if(!empty($parsedEmail)): ?>
                                                            | <i class="fa-solid fa-envelope ms-2 me-1"></i> <?= htmlspecialchars($parsedEmail) ?>
                                                        <?php endif; ?>
                                                        <?php if(!empty($parsedPhone)): ?>
                                                            | <i class="fa-solid fa-phone ms-2 me-1"></i> <?= htmlspecialchars($parsedPhone) ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div style="font-family: 'Heebo', sans-serif; font-size: 13px; opacity: 0.95;">
                                                    <i class="fa-solid fa-house-chimney me-1"></i> <?= htmlspecialchars($propTitle) ?> 
                                                    <span class="mx-1">|</span> 
                                                    <i class="fa-solid fa-tag me-1"></i> $<?= $propPrice ?>
                                                    <span class="mx-1">|</span>
                                                    ID: <?= $req->PropertyId ?>
                                                </div>
                                                <?php if($isTour): 
                                                    $tourTypeParsed = 'Unknown';
                                                    if (preg_match('/Tour Type:\s*([^\n]+)/', $req->Remarks ?? '', $m)) $tourTypeParsed = trim($m[1]);
                                                    $tourDate = ($req->MeetDate && $req->MeetDate != '0000-00-00') ? date('M d, Y', strtotime($req->MeetDate)) : 'N/A';
                                                    $tourTime = ($req->MeetTime && $req->MeetTime != '00:00:00') ? date('h:i A', strtotime($req->MeetTime)) : 'N/A';
                                                ?>
                                                <div class="mt-2 p-2 rounded w-100" style="background-color: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); font-family: 'Heebo', sans-serif; font-size: 13px;">
                                                    <strong>Tour Details:</strong> 
                                                    <span class="ms-2"><i class="fa-regular fa-calendar me-1"></i> <?= $tourDate ?></span>
                                                    <span class="mx-2">|</span>
                                                    <span><i class="fa-regular fa-clock me-1"></i> <?= $tourTime ?></span>
                                                    <span class="mx-2">|</span>
                                                    <span><i class="fa-solid fa-video me-1"></i> <?= htmlspecialchars($tourTypeParsed) ?></span>
                                                </div>
                                                <?php endif; ?>
                                              </div>
                                              
                                              <!-- Body -->
                                              <div class="modal-body p-4 d-flex flex-column" style="height: 500px; background-color: #ffffff;">
                                                  
                                                  <!-- Property Info Box in Chat -->
                                                  <div class="bg-light p-3 rounded-2 mb-4 border d-flex align-items-center shadow-sm flex-shrink-0" style="font-family: 'Heebo', sans-serif; font-size: 13px;">
                                                      <img src="<?= $propImgSrc ?>" alt="Property" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                      <div>
                                                          <h6 class="fw-bold mb-1 text-dark" style="font-size: 15px;"><?= htmlspecialchars($propTitle) ?></h6>
                                                          <div class="text-muted">
                                                              <strong>Price:</strong> $<?= $propPrice ?> <span class="mx-2">•</span> <strong>ID:</strong> <?= $req->PropertyId ?>
                                                          </div>
                                                      </div>
                                                  </div>

                                                  <div id="chatMessagesBody_<?= $req->InspectionId ?>" class="chat-messages-container flex-grow-1" style="overflow-y: auto; padding-right: 5px;">
                                                      <!-- Left/Incoming Message (Initial Inquiry) -->
                                                      <div class="d-flex mb-4">
                                                          <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3 mt-1" style="width: 35px; height: 35px; font-size: 16px; background-color: #26a4ff; flex-shrink: 0;">
                                                              <i class="fa-regular fa-user"></i>
                                                          </div>
                                                          <div class="p-3 shadow-sm text-dark" style="background-color: #e5e5ea; max-width: 80%; font-size: 14px; font-family: 'Heebo', sans-serif; line-height: 1.5; border-radius: 4px;">
                                                              <?= nl2br(htmlspecialchars($parsedMessage)) ?>
                                                          </div>
                                                      </div>

                                                      <?php 
                                                      $chatMsgs = $this->db->where('InspectionId', $req->InspectionId)->order_by('AddedOn', 'ASC')->get('tbl_properties_messages')->result();
                                                      foreach($chatMsgs as $msg): 
                                                          $isMe = ($msg->SenderId == $UserId);
                                                      ?>
                                                          <div class="d-flex mb-4 <?= $isMe ? 'justify-content-end' : '' ?>">
                                                              <?php if(!$isMe): ?>
                                                              <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3 mt-1" style="width: 35px; height: 35px; font-size: 16px; background-color: #26a4ff; flex-shrink: 0;">
                                                                  <i class="fa-regular fa-user"></i>
                                                              </div>
                                                              <?php endif; ?>
                                                              
                                                              <div class="p-3 shadow-sm text-dark" style="background-color: <?= $isMe ? '#7dc3f4' : '#e5e5ea' ?>; max-width: 80%; font-size: 14px; font-family: 'Heebo', sans-serif; line-height: 1.5; border-radius: 4px;">
                                                                  <?= nl2br(htmlspecialchars($msg->Message)) ?>
                                                              </div>

                                                              <?php if($isMe): ?>
                                                              <div class="rounded-circle text-muted d-flex align-items-center justify-content-center ms-3 mt-1" style="width: 35px; height: 35px; font-size: 16px; background-color: #cfd4d9; flex-shrink: 0;">
                                                                  <i class="fa-regular fa-user"></i>
                                                              </div>
                                                              <?php endif; ?>
                                                          </div>
                                                      <?php endforeach; ?>
                                                  </div>
                                                  
                                              </div>
                                              
                                              <!-- Footer / Input -->
                                              <div class="modal-footer p-2 bg-light d-flex flex-nowrap align-items-center" style="border-top: 1px solid #dee2e6; margin:0;">
                                                <input type="text" id="chatInput_<?= $req->InspectionId ?>" class="form-control flex-grow-1 border-0" placeholder="Type a message..." style="border-radius: 0; font-family: 'Heebo', sans-serif; font-size: 14px; padding: 12px; box-shadow: none; background: #fff;" onkeypress="if(event.keyCode==13) sendChatMessage(<?= $req->InspectionId ?>, <?= $req->SellerId ?>, <?= $req->RequestedBy ?>)">
                                                <button type="button" class="btn text-white ms-1 px-3" style="background-color: #26a4ff; border-radius: 0; padding: 12px 20px;" onclick="sendChatMessage(<?= $req->InspectionId ?>, <?= $req->SellerId ?>, <?= $req->RequestedBy ?>)">
                                                    <i class="fa-solid fa-paper-plane"></i>
                                                </button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Offers Tab -->
                            <div class="tab-pane fade" id="offersTab">
                                <?php if(empty($arrOffers)): ?>
                                    <div class="text-muted text-center p-3">No offers found.</div>
                                <?php else: ?>
                                    <div class="offer-list">
                                    <?php foreach($arrOffers as $req): 
                                        $parsedName = 'Buyer';
                                        $parsedEmail = '';
                                        $parsedPhone = '';
                                        $parsedAmount = '';
                                        $parsedMessage = '';
                                        
                                        if (preg_match('/Name:\s*([^\n]+)/', $req->Remarks ?? '', $m)) $parsedName = trim($m[1]);
                                        if (preg_match('/Email:\s*([^\n]+)/', $req->Remarks ?? '', $m)) $parsedEmail = trim($m[1]);
                                        if (preg_match('/Phone:\s*([^\n]+)/', $req->Remarks ?? '', $m)) $parsedPhone = trim($m[1]);
                                        if (preg_match('/Offer Amount:\s*([^\n]+)/', $req->Remarks ?? '', $m)) $parsedAmount = trim($m[1]);
                                        if (preg_match('/Message:\s*(.+)/s', $req->Remarks ?? '', $m)) $parsedMessage = trim($m[1]);
                                        
                                        $initials = strtoupper(substr($parsedName, 0, 1));

                                        $propDetails = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', 'PropertyTitle, TotalPrice', "WHERE PropertyId = '{$req->PropertyId}'", 2);
                                        $propTitle = $propDetails ? $propDetails->PropertyTitle : 'Unknown Property';
                                        $propPrice = $propDetails ? number_format($propDetails->TotalPrice) : '0';

                                        // Badge color based on status
                                        $statusColor = 'bg-secondary';
                                        if ($req->InspectionStatus == 'Pending') $statusColor = 'bg-warning text-dark';
                                        elseif ($req->InspectionStatus == 'Accepted') $statusColor = 'bg-success';
                                        elseif ($req->InspectionStatus == 'Rejected') $statusColor = 'bg-danger';
                                    ?>
                                        <!-- Offer Card -->
                                        <div class="inquiry-item d-flex align-items-center cursor-pointer transition-all mb-3" data-bs-toggle="modal" data-bs-target="#offerModal_<?= $req->InspectionId ?>" style="cursor: pointer; transition: background 0.2s; border: 1px solid #eee; border-radius: 8px; padding: 15px;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 text-white shadow-sm" style="width: 50px; height: 50px; font-size: 20px; font-weight: bold; background: linear-gradient(135deg, #f2994a, #f2c94c);">
                                                <?= $initials ?>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="mb-0 fw-bold text-dark text-truncate" style="font-size: 15px;"><?= htmlspecialchars($parsedName) ?></h6>
                                                    <span class="small text-muted" style="font-size: 12px;">#<?= $req->InspectionId ?></span>
                                                </div>
                                                <div class="mb-0 text-muted small text-truncate" style="max-width: 95%;">
                                                    <span class="fw-bold text-success me-2"><?= htmlspecialchars($parsedAmount) ?></span> 
                                                    <?= htmlspecialchars($parsedMessage) ?>
                                                </div>
                                            </div>
                                            <div class="ms-3 text-end d-flex flex-column align-items-end">
                                                <span class="badge <?= $statusColor ?> rounded-pill mb-1" style="font-size: 10px;"><?= $req->InspectionStatus ?></span>
                                                <i class="fa-solid fa-chevron-right text-muted" style="font-size: 12px; opacity: 0.5;"></i>
                                            </div>
                                        </div>

                                        <!-- Offer Modal -->
                                        <div class="modal fade" id="offerModal_<?= $req->InspectionId ?>" tabindex="-1" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow-lg border-0" style="border-radius: 0; overflow: hidden; background: #f8f9fa;">
                                              
                                              <!-- Header -->
                                              <div class="modal-header text-white rounded-0 d-flex flex-column align-items-start" style="background-color: #f2994a; border-bottom: none; padding: 15px 20px; position: relative;">
                                                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="font-size: 14px; opacity: 1;"></button>
                                                
                                                <div class="d-flex align-items-center mb-1 flex-wrap">
                                                    <h5 class="modal-title fs-6 fw-bold m-0 text-white" style="font-family: 'Heebo', sans-serif;">
                                                        <i class="fa-solid fa-user me-1"></i> <?= htmlspecialchars($parsedName) ?>
                                                    </h5>
                                                    <div style="font-family: 'Heebo', sans-serif; font-size: 12px; opacity: 0.9; margin-left: 10px;" class="d-flex align-items-center flex-wrap">
                                                        <?php if(!empty($parsedEmail)): ?>
                                                            | <i class="fa-solid fa-envelope ms-2 me-1"></i> <?= htmlspecialchars($parsedEmail) ?>
                                                        <?php endif; ?>
                                                        <?php if(!empty($parsedPhone)): ?>
                                                            | <i class="fa-solid fa-phone ms-2 me-1"></i> <?= htmlspecialchars($parsedPhone) ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div style="font-family: 'Heebo', sans-serif; font-size: 13px; opacity: 0.95;">
                                                    <i class="fa-solid fa-house-chimney me-1"></i> <?= htmlspecialchars($propTitle) ?> 
                                                    <span class="mx-1">|</span> 
                                                    <i class="fa-solid fa-tag me-1"></i> $<?= $propPrice ?>
                                                    <span class="mx-1">|</span>
                                                    ID: <?= $req->PropertyId ?>
                                                </div>
                                              </div>
                                              
                                              <!-- Body -->
                                              <div class="modal-body p-4" style="background: white;">
                                                <div class="text-center mb-4">
                                                    <div class="text-muted small text-uppercase fw-bold mb-1">Offer Amount</div>
                                                    <h2 class="text-success fw-bold m-0"><?= htmlspecialchars($parsedAmount) ?></h2>
                                                </div>
                                                
                                                <?php if(!empty($parsedMessage)): ?>
                                                <div class="bg-light p-3 rounded text-muted mb-4" style="font-size: 14px; font-family: 'Heebo', sans-serif; line-height: 1.5; border-left: 4px solid #f2994a;">
                                                    <strong>Message:</strong><br>
                                                    <?= nl2br(htmlspecialchars($parsedMessage)) ?>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <!-- Action Buttons -->
                                                <?php if($req->InspectionStatus == 'Pending' && $req->SellerId == $UserId): ?>
                                                <div class="d-flex flex-column gap-2 mt-4">
                                                    <div class="d-flex gap-2">
                                                        <a href="<?= site_url('Properties/UpdateRequestStatus/'.$req->InspectionId) ?>" class="btn btn-success flex-fill py-2 fw-bold" style="border-radius: 4px;"><i class="fa-solid fa-check me-2"></i>Accept Offer</a>
                                                        <a href="#" class="btn btn-danger flex-fill py-2 fw-bold" style="border-radius: 4px;" onclick="event.preventDefault(); Swal.fire('Info', 'Rejecting offers requires backend status mapping', 'info');"><i class="fa-solid fa-times me-2"></i>Reject</a>
                                                    </div>
                                                    <div class="input-group mt-1">
                                                        <span class="input-group-text bg-light border-primary text-primary fw-bold">AUS</span>
                                                        <input type="number" id="counter_amount_<?= $req->InspectionId ?>" class="form-control border-primary shadow-none" style="border-radius: 0;">
                                                        <button type="button" class="btn btn-primary fw-bold px-4" style="border-radius: 0 4px 4px 0;" onclick="Swal.fire('Info', 'Counter-offer logic to be implemented', 'info');"><i class="fa-solid fa-paper-plane me-2"></i>Send Offer</button>
                                                    </div>
                                                </div>
                                                <?php else: ?>
                                                <div class="text-center mt-3">
                                                    <span class="badge <?= $statusColor ?> fs-6 py-2 px-4 rounded-pill">Status: <?= $req->InspectionStatus ?></span>
                                                </div>
                                                <?php endif; ?>
                                              </div>
                                              
                                            </div>
                                          </div>
                                        </div>
                                    <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saved Properties -->
            <div class="col-lg-6">
                <div class="card dashboard-card h-100 mb-0">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Saved Properties</span>
                    </div>
                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                        <div class="row g-4">
                            <?php if (empty($arrFavProperties)): ?>
                                <div class="col-12"><div class="text-muted text-center p-3">No Saved Properties</div></div>
                            <?php else: ?>
                                <?php foreach ($arrFavProperties as $key => $fav):
                                    $favPropertyId = $fav->PropertyId;
                                    $favProp = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', '*', "WHERE PropertyId = '$favPropertyId'", 2);
                                    if($favProp) {
                                        $favTitle = $favProp->PropertyTitle ? $favProp->PropertyTitle : "Property Title";
                                        $favPrice = $favProp->TotalPrice ? $favProp->TotalPrice : "0";
                                        $favAddress = $favProp->MailingAddress ? $favProp->MailingAddress : "Mailing Address";
                                        $favImage = $this->getlist_model->getFieldsMultipleConditions('tbl_property_media', 'FileName', "WHERE PropertyId = '$favPropertyId'", 1);
                                        $favImgSrc = (!empty($favImage) && is_string($favImage)) ? base_url('uploads/Properties/'.$favPropertyId.'/images/'.$favImage) : base_url('assets/images/property-1.jpg');
                                ?>
                                <div class="col-md-6">
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
            </div>

        </div>



        <!-- My Listings -->
        <div class="card dashboard-card mt-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>My Recent Listings</span>
                <a href="<?= site_url('Properties/AddListing'); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Add Property
                </a>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <?php if(empty($arrProperties)): ?>
                        <div class="col-12"><div class="text-muted text-center p-4">No Recent Listings Found. Start adding some properties!</div></div>
                    <?php else: ?>
                        <?php foreach ($arrProperties as $key => $value): 
                              $this->load->view('components/property_card', ['value' => $value, 'UserId' => $UserId, 'ShowStatusBadge' => true]);
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

    <script>
    function sendChatMessage(InspectionId, SellerId, BuyerId) {
        let input = $('#chatInput_' + InspectionId);
        let message = input.val().trim();
        if(message === '') return;
        
        // Add to UI immediately
        let myMsgHtml = `
            <div class="d-flex mb-4 justify-content-end">
                <div class="p-3 shadow-sm text-dark" style="background-color: #7dc3f4; max-width: 80%; font-size: 14px; font-family: 'Heebo', sans-serif; line-height: 1.5; border-radius: 4px;">
                    ${message.replace(/\n/g, '<br>')}
                </div>
                <div class="rounded-circle text-muted d-flex align-items-center justify-content-center ms-3 mt-1" style="width: 35px; height: 35px; font-size: 16px; background-color: #cfd4d9; flex-shrink: 0;">
                    <i class="fa-regular fa-user"></i>
                </div>
            </div>
        `;
        $('#chatMessagesBody_' + InspectionId).append(myMsgHtml);
        
        // Scroll to bottom
        let chatBody = document.getElementById('chatMessagesBody_' + InspectionId);
        chatBody.scrollTop = chatBody.scrollHeight;
        
        input.val('');
        
        $.ajax({
            url: '<?= site_url('Properties/send_message') ?>',
            type: 'POST',
            data: {
                InspectionId: InspectionId,
                SellerId: SellerId,
                BuyerId: BuyerId,
                message: message
            },
            dataType: 'json',
            success: function(res) {
                if(!res.Status) {
                    Swal.fire('Error', 'Failed to send message.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'An error occurred while sending message.', 'error');
            }
        });
    }

    // Scroll to bottom when modal is opened
    $('.modal').on('shown.bs.modal', function () {
        let chatBody = $(this).find('.chat-messages-container')[0];
        if (chatBody) {
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    });
    </script>
</body>
</html>
