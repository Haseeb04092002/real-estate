<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'User Details'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
    <style>
        body { background-color: #f8f9fa; }
        .profile-header {
            background: linear-gradient(135deg, #1F509A 0%, #153a75 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(31, 80, 154, 0.2);
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
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
        
        .info-group {
            margin-bottom: 20px;
        }
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
        
        .verif-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .verif-item-title { font-weight: 600; color: #2b3445; }
        .btn-view-doc {
            background: white;
            color: #1F509A;
            border: 1px solid #e9ecef;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-view-doc:hover {
            background: #1F509A;
            color: white;
        }
    </style>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">
            
            <div class="mb-3">
                <a href="<?= site_url('Admin/user_management') ?>" class="text-decoration-none text-muted fw-bold">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back to User List
                </a>
            </div>

            <!-- Profile Header -->
            <div class="profile-header">
                <div class="row align-items-center">
                    <div class="col-md-7 d-flex align-items-center">
                        <img src="<?= $user->ProfilePicture ? base_url('uploads/'.$user->ProfilePicture) : 'https://ui-avatars.com/api/?name='.urlencode($user->ClientName).'&background=1F509A&color=fff&size=120' ?>" class="profile-avatar me-4" alt="Avatar">
                        <div>
                            <h2 class="fw-bold mb-1"><?= $user->ClientName ?></h2>
                            <p class="mb-2 text-white-50"><i class="fa-solid fa-envelope me-2"></i><?= $user->EmailAddress ?> &nbsp; | &nbsp; <i class="fa-solid fa-phone me-2"></i><?= $user->PhoneNumber ?></p>
                            <div>
                                <?php if($user->AccountStatus == 'Active'): ?>
                                    <span class="badge bg-success rounded-pill px-3 shadow-sm">Active</span>
                                <?php elseif($user->AccountStatus == 'Blocked'): ?>
                                    <span class="badge bg-danger rounded-pill px-3 shadow-sm">Blocked</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark rounded-pill px-3 shadow-sm"><?= $user->AccountStatus ?></span>
                                <?php endif; ?>
                                
                                <?php if(isset($user->VerificationStatus) && $user->VerificationStatus == 'Verified'): ?>
                                    <span class="badge bg-info rounded-pill px-3 shadow-sm ms-2"><i class="fa-solid fa-check-circle me-1"></i> Verified User</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="d-flex justify-content-md-end justify-content-start mt-4 mt-md-0 gap-3">
                            <div class="stat-card">
                                <h3><?= $stats['total_properties'] ?></h3>
                                <small>Properties</small>
                            </div>
                            <div class="stat-card">
                                <h3><?= $stats['total_views'] ?></h3>
                                <small>Total Views</small>
                            </div>
                            <div class="stat-card">
                                <h3><?= $stats['total_inquiries'] ?></h3>
                                <small>Inquiries</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <ul class="nav nav-pills nav-modern" id="userTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab"><i class="fa-solid fa-user me-2"></i> Overview & Info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="verification-tab" data-bs-toggle="tab" data-bs-target="#verification" type="button" role="tab"><i class="fa-solid fa-shield-halved me-2"></i> Verification & Status</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="properties-tab" data-bs-toggle="tab" data-bs-target="#properties" type="button" role="tab"><i class="fa-solid fa-building me-2"></i> Listed Properties</button>
                </li>
            </ul>

            <div class="tab-content" id="userTabContent">
                
                <!-- OVERVIEW TAB -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="modern-card h-100">
                                <div class="modern-card-header">
                                    Personal Details
                                </div>
                                <div class="modern-card-body">
                                    <div class="row">
                                        <div class="col-md-6 info-group">
                                            <span class="info-label">Full Name</span>
                                            <span class="info-value"><?= $user->ClientName ?></span>
                                        </div>
                                        <div class="col-md-6 info-group">
                                            <span class="info-label">CNIC / National ID</span>
                                            <span class="info-value"><?= $user->CNIC_Number ? $user->CNIC_Number : '<span class="text-muted">Not Provided</span>' ?></span>
                                        </div>
                                        <div class="col-md-6 info-group">
                                            <span class="info-label">Email Address</span>
                                            <span class="info-value"><?= $user->EmailAddress ?></span>
                                        </div>
                                        <div class="col-md-6 info-group">
                                            <span class="info-label">Phone Number</span>
                                            <span class="info-value"><?= $user->PhoneNumber ?></span>
                                        </div>
                                        <div class="col-12 info-group">
                                            <span class="info-label">Location</span>
                                            <span class="info-value">
                                                <?php 
                                                    $loc = trim(($user->City ?? '') . ' ' . ($user->Country ?? ''));
                                                    echo $loc ? $loc : '<span class="text-muted">Not Provided</span>';
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="modern-card h-100">
                                <div class="modern-card-header">
                                    Account Timeline
                                </div>
                                <div class="modern-card-body">
                                    <div class="info-group">
                                        <span class="info-label"><i class="fa-regular fa-calendar-alt me-1"></i> Registration Date</span>
                                        <span class="info-value"><?= date('F j, Y, g:i a', strtotime($user->RegistrationDate)) ?></span>
                                    </div>
                                    <div class="info-group mt-4">
                                        <span class="info-label"><i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Last Login</span>
                                        <span class="info-value"><?= $user->LastLogin ? date('F j, Y, g:i a', strtotime($user->LastLogin)) : '<span class="text-muted">Never Logged In</span>' ?></span>
                                    </div>
                                    <div class="info-group mt-4">
                                        <span class="info-label"><i class="fa-solid fa-user-tag me-1"></i> User Type</span>
                                        <span class="info-value badge bg-light text-dark border px-3 py-2"><?= $user->UserType ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VERIFICATION TAB -->
                <div class="tab-pane fade" id="verification" role="tabpanel">
                    <div class="row g-4">
                        
                        <?php
                        $doc_license_front = null;
                        $doc_license_back = null;
                        $doc_passport = null;
                        $doc_address = null;

                        if (isset($documents)) {
                            foreach($documents as $doc) {
                                if($doc->Remarks == 'License Front') $doc_license_front = $doc;
                                if($doc->Remarks == 'License Back') $doc_license_back = $doc;
                                if($doc->Remarks == 'Passport') $doc_passport = $doc;
                                if($doc->Remarks == 'Address Details') $doc_address = $doc;
                            }
                        }

                        // Helper function to render doc
                        if (!function_exists('render_doc_item')) {
                            function render_doc_item($doc, $user) {
                                if(!$doc) return '<div class="text-muted small fst-italic mb-3">No document uploaded.</div>';
                                
                                $ext = pathinfo($doc->FileName, PATHINFO_EXTENSION);
                                $is_img = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']);
                                $path = base_url('uploads/Client/'.$user->ClientId.'/images/'.$doc->FileName);
                                
                                $statusColor = '';
                                if($doc->VerificationStatus == 'Approved') $statusColor = 'text-success border-success';
                                elseif($doc->VerificationStatus == 'Rejected') $statusColor = 'text-danger border-danger';
                                else $statusColor = 'text-warning border-warning';
                                
                                $html = '
                                <div class="border rounded p-3 mb-3 d-flex align-items-center justify-content-between bg-white shadow-sm">
                                    <div class="d-flex align-items-center">';
                                
                                if($is_img) {
                                    $html .= '<a href="'.$path.'" target="_blank">
                                                <img src="'.$path.'" style="width: 50px; height: 50px; object-fit: cover;" class="rounded me-3 border">
                                              </a>';
                                } else {
                                    $html .= '<div class="bg-light rounded d-flex align-items-center justify-content-center me-3 border" style="width: 50px; height: 50px;">
                                                <i class="fa-solid fa-file-pdf fs-3 text-secondary"></i>
                                              </div>';
                                }
                                
                                $html .= '<div>
                                            <h6 class="mb-0 fw-bold">'.$doc->Remarks.'</h6>
                                            <a href="'.$path.'" target="_blank" class="text-decoration-none small"><i class="fa-solid fa-up-right-from-square me-1"></i> Preview</a>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <select class="form-select form-select-sm doc-status-select '.$statusColor.'" data-doc-id="'.$doc->DocumentId.'" style="width: 120px; font-weight: bold;">
                                            <option value="Pending" '.($doc->VerificationStatus == 'Pending' ? 'selected' : '').' class="text-dark">Pending</option>
                                            <option value="Approved" '.($doc->VerificationStatus == 'Approved' ? 'selected' : '').' class="text-dark">Approved</option>
                                            <option value="Rejected" '.($doc->VerificationStatus == 'Rejected' ? 'selected' : '').' class="text-dark">Rejected</option>
                                        </select>
                                    </div>
                                </div>';
                                return $html;
                            }
                        }
                        ?>

                        <div class="col-lg-7">
                            <div class="modern-card h-100">
                                <div class="modern-card-header bg-light">
                                    <i class="fa-solid fa-file-shield me-2 text-primary"></i> User Authorization — Documents Upload
                                </div>
                                <div class="modern-card-body">
                                    
                                    <h6 class="text-primary fw-bold mb-3"><i class="fa-solid fa-id-badge me-2"></i> Identity Information</h6>
                                    <div class="row mb-4">
                                        <div class="col-6"><span class="info-label">Date of Birth (DOB)</span><span class="info-value"><?= $user->DOB ?: '<span class="text-muted">Not Provided</span>' ?></span></div>
                                        <div class="col-6"><span class="info-label">Card Number</span><span class="info-value"><?= $user->CardNumber ?: '<span class="text-muted">Not Provided</span>' ?></span></div>
                                        <div class="col-6 mt-3"><span class="info-label">Card Issue Date</span><span class="info-value"><?= $user->CardIssueDate ?: '<span class="text-muted">N/A</span>' ?></span></div>
                                        <div class="col-6 mt-3"><span class="info-label">Card Expiry Date</span><span class="info-value"><?= $user->CardExpiryDate ?: '<span class="text-muted">N/A</span>' ?></span></div>
                                    </div>

                                    <hr>
                                    <h6 class="text-primary fw-bold mb-3"><i class="fa-solid fa-file-contract me-2"></i> Required Verification Documents</h6>
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <?php 
                                            if(!empty($verification_rules)) {
                                                foreach($verification_rules as $rule) {
                                                    // Find if user uploaded this document
                                                    $uploaded_doc = null;
                                                    if(isset($documents)) {
                                                        foreach($documents as $doc) {
                                                            if($doc->Remarks == $rule->DocumentTitle) {
                                                                $uploaded_doc = $doc;
                                                                break;
                                                            }
                                                        }
                                                    }

                                                    echo '<div class="mb-4">';
                                                    echo '<span class="info-label mb-2">'.htmlspecialchars($rule->DocumentTitle);
                                                    if($rule->IsMandatory) {
                                                        echo ' <span class="badge bg-danger rounded-pill px-2 ms-2" style="font-size: 10px;">Mandatory</span>';
                                                    } else {
                                                        echo ' <span class="badge bg-light text-dark border rounded-pill px-2 ms-2" style="font-size: 10px;">Optional</span>';
                                                    }
                                                    echo '</span>';

                                                    if($uploaded_doc) {
                                                        if($uploaded_doc->ReferenceNumber || ($uploaded_doc->ExpiryDate && $uploaded_doc->ExpiryDate != '0000-00-00')) {
                                                            echo '<div class="d-flex gap-3 mb-2 small text-muted">';
                                                            if($uploaded_doc->ReferenceNumber) echo '<span><i class="fa-solid fa-hashtag"></i> '.$uploaded_doc->ReferenceNumber.'</span>';
                                                            if($uploaded_doc->ExpiryDate && $uploaded_doc->ExpiryDate != '0000-00-00') echo '<span><i class="fa-regular fa-calendar-xmark"></i> Exp: '.$uploaded_doc->ExpiryDate.'</span>';
                                                            echo '</div>';
                                                        }
                                                        echo render_doc_item($uploaded_doc, $user);
                                                    } else {
                                                        echo '<div class="text-muted small fst-italic mb-3 p-3 bg-light rounded border" style="border-style: dashed !important;"><i class="fa-solid fa-triangle-exclamation text-warning me-2"></i> No document uploaded.</div>';
                                                    }
                                                    echo '</div>';
                                                }
                                            } else {
                                                echo '<div class="text-muted fst-italic">No dynamic verification rules configured.</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="modern-card h-100 border-start border-primary border-4">
                                <div class="modern-card-header bg-light">
                                    <i class="fa-solid fa-user-lock me-2 text-primary"></i> Account Status Control
                                </div>
                                <div class="modern-card-body">
                                    <form id="statusForm">
                                        <input type="hidden" id="statusUserId" value="<?= $user->ClientId ?>">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-muted text-uppercase" style="font-size:12px;">Update Status</label>
                                            <select class="form-select form-select-lg shadow-sm" id="statusSelect" style="border-radius:10px;">
                                                <option value="Active" <?= $user->AccountStatus == 'Active' ? 'selected' : '' ?>>Active</option>
                                                <option value="Pending Verification" <?= $user->AccountStatus == 'Pending Verification' ? 'selected' : '' ?>>Pending Verification</option>
                                                <option value="Suspended" <?= $user->AccountStatus == 'Suspended' ? 'selected' : '' ?>>Suspended</option>
                                                <option value="Blocked" <?= $user->AccountStatus == 'Blocked' ? 'selected' : '' ?>>Blocked</option>
                                                <option value="Deleted" <?= $user->AccountStatus == 'Deleted' ? 'selected' : '' ?>>Deleted</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-muted text-uppercase" style="font-size:12px;">Reason for Action <small class="text-lowercase">(Req. for Suspend/Block)</small></label>
                                            <select class="form-select shadow-sm" id="statusReason" style="border-radius:10px;">
                                                <option value="">-- Select Reason --</option>
                                                <option value="Spam">Spam Content</option>
                                                <option value="Fake Listings">Posting Fake Listings</option>
                                                <option value="Fraud Activity">Suspected Fraud Activity</option>
                                                <option value="Duplicate Account">Duplicate Account</option>
                                                <option value="Other">Other Policy Violation</option>
                                            </select>
                                        </div>
                                        <div class="d-grid mt-5">
                                            <button type="button" class="btn btn-primary btn-lg shadow-sm" id="saveStatusBtn" style="border-radius:10px;"><i class="fa-solid fa-save me-2"></i> Apply Status Change</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PROPERTIES TAB -->
                <div class="tab-pane fade" id="properties" role="tabpanel">
                    <div class="modern-card">
                        <div class="modern-card-body text-center py-5">
                            <div style="font-size: 50px; color: #e9ecef; margin-bottom: 20px;"><i class="fa-solid fa-building"></i></div>
                            <h4 class="fw-bold">No Listed Properties Yet</h4>
                            <p class="text-muted">This user has not listed any properties, or the property module is currently being integrated.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>
    <script>
        const baseUrl = '<?= base_url() ?>';
        const siteUrl = '<?= site_url() ?>';
    </script>
    <script src="<?= base_url('assets/js/admin_users.js'); ?>"></script>
</body>
</html>
