<?php
defined('BASEPATH') or exit('No direct script access allowed');
// $documents = $this->getlist_model->getFieldsMultipleConditions('tbl_client_documents', '*', "WHERE DocumentId > 1", 2);
// $clients = $this->getlist_model->getFieldsMultipleConditions('tbl_clients', '*', "WHERE ClientId > 1", 2);
// echo "<pre>";
// print_r($documents);

$UserId = $this->session->userdata('user_id');
$documents = $this->getlist_model->getFieldsMultipleConditions('tbl_client_documents', '*', "WHERE ClientId = $UserId", 2);
$clients = $this->getlist_model->getFieldsMultipleConditions('tbl_clients', '*', "WHERE ClientId = $UserId", 2);

$dob                 = $clients->DOB??'';
$license_number      = $documents->ReferenceNumber??'';
$license_expiry      = $documents->ExpiryDate??'';
$card_number         = $clients->CardNumber??'';
$card_issue          = $clients->CardIssueDate??'';
$card_expiry         = $clients->CardExpiryDate??'';
$passport_number     = $clients->passport_number??'';
$residential_address = $clients->residential_address??'';

?>
<!DOCTYPE html>
<html lang="en">

    <?php $this->load->view('components/header_meta'); ?>
    <?php $this->load->view('components/css_links'); ?>

</head>

<body>

    <?php $this->load->view('components/header', ['ListingPages' => 'no']); ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-building me-2"></i>
                Your documents have been uploaded successfully. They are now under review by our admin team, and your account will be verified once the review is complete.
            </a>
        </div>
    </nav>

    <div class="container py-5">

        <h3 class="text-primary mb-4"><i class="bi bi-files"></i> Uploaded Documents & Details</h3>

        <!-- ===================== -->
        <!-- Identity Information -->
        <!-- ===================== -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-badge"></i> Identity Information</h5>
            </div>
            <div class="card-body row g-3">

                <div class="col-md-4">
                    <label class="form-label fw-bold">Date of Birth</label>
                    <p class="form-control bg-light"><?= $dob; ?></p>
                </div>

            </div>
        </div>

        <!-- ===================== -->
        <!-- License Details -->
        <!-- ===================== -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-credit-card-2-front"></i> License Details</h5>
            </div>

            <div class="card-body row g-4">

                <div class="col-md-4">
                    <label class="form-label fw-bold">License Number</label>
                    <p class="form-control bg-light"><?= $license_number; ?></p>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">License Expiry</label>
                    <p class="form-control bg-light"><?= $license_expiry; ?></p>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">License Front</label><br>
                    <a href="<?= base_url($user->license_front); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                        View File
                    </a>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">License Back</label><br>
                    <a href="<?= base_url($user->license_back); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                        View File
                    </a>
                </div>

            </div>
        </div>

        <!-- ===================== -->
        <!-- ID Card Information -->
        <!-- ===================== -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-credit-card"></i> ID Card Information</h5>
            </div>

            <div class="card-body row g-3">

                <div class="col-md-4">
                    <label class="form-label fw-bold">Card Number</label>
                    <p class="form-control bg-light"><?= $card_number; ?></p>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Issue Date</label>
                    <p class="form-control bg-light"><?= $card_issue; ?></p>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold">Expiry Date</label>
                    <p class="form-control bg-light"><?= $card_expiry; ?></p>
                </div>

            </div>
        </div>

        <!-- ===================== -->
        <!-- Passport Information -->
        <!-- ===================== -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-passport"></i> Passport Details</h5>
            </div>

            <div class="card-body row g-3">

                <div class="col-md-4">
                    <label class="form-label fw-bold">Passport Number</label>
                    <p class="form-control bg-light">
                        <?= $passport_number; ?>
                    </p>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Passport File</label><br>
                    <?php if ($user->passport_file): ?>
                        <a href="<?= base_url($user->passport_file); ?>" target="_blank" class="btn btn-outline-primary btn-sm">View File</a>
                    <?php else: ?>
                        <span class="text-muted">No File Uploaded</span>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <!-- ===================== -->
        <!-- Address & Authorization -->
        <!-- ===================== -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-geo-alt"></i> Address & Authorization</h5>
            </div>

            <div class="card-body row g-4">

                <div class="col-12">
                    <label class="form-label fw-bold">Residential Address</label>
                    <p class="form-control bg-light"><?= $residential_address; ?></p>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Proof of Address</label><br>
                    <a href="<?= base_url($user->proof_address); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                        View File
                    </a>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Profile Photo</label><br>
                    <img src="<?= base_url($user->profile_photo); ?>" class="img-thumbnail" width="150">
                </div>
            </div>
        </div>

    </div>


    <?php
    $this->load->view('components/footer');
    $this->load->view('components/js_links');
    ?>

</body>

</html>