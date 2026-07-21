<?php
$PropertyId     = $value->PropertyId ?? '';
$PropertyTitle  = $value->PropertyTitle ?? 'Property Title';
$PropertyTypeId = $value->PropertyTypeId;
$PropertyType   = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_types','Title',"WHERE TypeId = '$PropertyTypeId'", 1);
$PropertyTypeName = is_object($PropertyType) ? ($PropertyType->Title ?? '') : (is_array($PropertyType) ? ($PropertyType['Title'] ?? '') : (is_string($PropertyType) ? $PropertyType : 'Property'));
$ListType       = $value->ListType ?? 'Sale';
$TotalPrice     = $value->TotalPrice ?? 0;
$MailingAddress = $value->MailingAddress ?? '';
$CoveredArea    = $value->CoveredArea ?? '0';
$AreaUnitId     = $value->AreaUnitId ?? '1';

$PropertyDescription = $value->PropertyDescription ?? 'No description available for this property.';
if (strlen($PropertyDescription) > 90) {
    $PropertyDescription = substr($PropertyDescription, 0, 90) . '...';
}

$PropertyFeatures = $this->getlist_model->getFieldsMultipleConditions(
  'tbl_properties_features',
  'Bedrooms, Bathrooms',
  "WHERE PropertyId = '$PropertyId'",
  2
);

$Bedrooms = $PropertyFeatures->Bedrooms ?? '0';
$Bathrooms = $PropertyFeatures->Bathrooms ?? '0';

switch ($AreaUnitId) {
  case '1': $AreaUnit = 'Sqft'; break;
  case '2': $AreaUnit = 'Sqyd'; break;
  case '3': $AreaUnit = 'Kanal'; break;
  case '4': $AreaUnit = 'Marla'; break;
  default:  $AreaUnit = 'Sqft'; break;
}

$IsFavourite = false;
if (isset($UserId) && $UserId > 0) {
    $IsFavourite = $this->getlist_model->getFieldsMultipleConditions(
      'tbl_properties_favourites',
      'IsFavourite',
      "WHERE PropertyId = '$PropertyId' AND UserId = '$UserId'",
      1
    );
}

// Check how many images exist
$ImagesCount = $this->db->where('PropertyId', $PropertyId)->count_all_results('tbl_property_media');

$ImageName = $this->getlist_model->getFieldsMultipleConditions(
  'tbl_property_media',
  'FileName',
  "WHERE PropertyId = '$PropertyId'",
  1
);

$imageSrc = (!empty($ImageName) && is_string($ImageName)) 
            ? base_url('uploads/Properties/'.$PropertyId.'/images/'.$ImageName) 
            : base_url('assets/images/property-1.jpg');

$ClientId = $value->ClientId ?? 0;
$agentName = "Unknown User";
$agentInitials = "UU";
$isVerified = false;

if ($ClientId > 0) {
    // tbl_clients has ClientName
    $Client = $this->getlist_model->getFieldsMultipleConditions('tbl_clients', 'ClientName', "WHERE ClientId = '$ClientId'", 2);
    if ($Client) {
        $agentName = $Client->ClientName ?? '';
        $agentName = trim($agentName);
        if (!empty($agentName)) {
            $nameParts = explode(' ', $agentName);
            $firstInitial = isset($nameParts[0][0]) ? $nameParts[0][0] : '';
            $lastInitial = isset($nameParts[1][0]) ? $nameParts[1][0] : '';
            if (empty($lastInitial) && strlen($agentName) > 1) {
                $lastInitial = $agentName[1];
            }
            $agentInitials = strtoupper($firstInitial . $lastInitial);
        } else {
            $agentName = "Unknown User";
            $agentInitials = "UU";
        }
    }

    // Check Verification Status
    if ($this->db->table_exists('tbl_user_verification_rules')) {
        $mandatoryRulesCount = $this->db->where('IsMandatory', 1)->count_all_results('tbl_user_verification_rules');
        $approvedDocsCount = $this->db->where('ClientId', $ClientId)
                                      ->where('VerificationStatus', 'Approved')
                                      ->count_all_results('tbl_client_documents');
        $notApprovedCount = $this->db->where('ClientId', $ClientId)
                                     ->where('VerificationStatus !=', 'Approved')
                                     ->count_all_results('tbl_client_documents');
                                     
        if ($mandatoryRulesCount > 0) {
            if ($approvedDocsCount >= $mandatoryRulesCount && $notApprovedCount == 0) {
                $isVerified = true;
            }
        } else {
            if ($approvedDocsCount > 0 && $notApprovedCount == 0) {
                $isVerified = true;
            }
        }
    }
}

// Format address
$dispAddr = [];
if (!empty($MailingAddress)) {
    $dispAddr[] = $MailingAddress;
} else {
    if (!empty($value->UnitNumber)) $dispAddr[] = "Unit " . $value->UnitNumber;
    if (!empty($value->StreetNumber) && !empty($value->StreetName)) {
        $dispAddr[] = $value->StreetNumber . ' ' . $value->StreetName;
    }
    if (!empty($value->Suburb)) $dispAddr[] = $value->Suburb;
    if (!empty($value->State)) $dispAddr[] = $value->State;
    if (!empty($value->ZipCode)) $dispAddr[] = $value->ZipCode;
}
$fAddr = implode(', ', array_filter($dispAddr));
$words = explode(' ', $fAddr);
if (count($words) > 5) {
    $displayAddress = implode(' ', array_slice($words, 0, 5)) . "...";
} else {
    $displayAddress = $fAddr;
}
if (empty(trim($displayAddress))) $displayAddress = "Address not provided";
?>

<div class="col-lg-4 col-md-6 wow fadeInUp property-item-box <?= htmlspecialchars($ListType); ?>" 
     data-wow-delay="0.1s"
     data-search="<?= strtolower(
        $PropertyTitle . ' ' . 
        $MailingAddress . ' ' . 
        $PropertyTypeName . ' ' . 
        ($value->State ?? '') . ' ' . 
        ($value->Suburb ?? '') . ' ' . 
        ($value->Postcode ?? '')
     ); ?>"
     data-price="<?= $TotalPrice; ?>"
     data-bedrooms="<?= is_numeric($Bedrooms) ? $Bedrooms : 0; ?>"
     data-bathrooms="<?= is_numeric($Bathrooms) ? $Bathrooms : 0; ?>"
     data-type="<?= $PropertyTypeId; ?>"
     data-state="<?= strtolower($value->State ?? ''); ?>"
     data-suburb="<?= strtolower($value->Suburb ?? ''); ?>"
     data-coveredarea="<?= $CoveredArea; ?>"
>
  <style>
    .prop-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: 0.3s;
        border: 1px solid #f0f0f0;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .prop-card:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .prop-card-img-wrap {
        position: relative;
        height: 240px;
        overflow: hidden;
    }
    .prop-card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .prop-card:hover .prop-card-img-wrap img {
        transform: scale(1.1);
    }
    .prop-badge-top-left {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #6cba70;
        color: white;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .prop-badge-top-right {
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
        gap: 8px;
    }
    .prop-badge-top-right span {
        background: #0d6efd;
        color: white;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .prop-badge-bottom-left {
        position: absolute;
        bottom: 15px;
        left: 15px;
        color: white;
        font-size: 0.9rem;
        font-weight: 500;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
    }
    .prop-badge-bottom-right {
        position: absolute;
        bottom: 15px;
        right: 15px;
        color: white;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
    }
    .prop-card-body {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .prop-title {
        font-size: 1.15rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .prop-price {
        font-size: 1.15rem;
        color: #0d6efd;
        font-weight: 600;
        margin-bottom: 0;
        white-space: nowrap;
    }
    .prop-desc {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 20px;
        line-height: 1.5;
    }
    .prop-features {
        display: flex;
        gap: 20px;
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 20px;
        margin-top: auto;
    }
    .prop-features i {
        margin-right: 5px;
        font-size: 1.1rem;
    }
    .prop-divider {
        border-top: 1px solid #eaeaea;
        margin: 0;
    }
    .prop-footer {
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
    }
    .prop-agent {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .prop-agent .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #0d6efd;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
        letter-spacing: 1px;
    }
    .prop-agent-name {
        font-weight: 600;
        color: #212529;
        font-size: 0.95rem;
    }
    .prop-actions {
        display: flex;
        gap: 8px;
    }
    .prop-btn {
        width: 35px;
        height: 35px;
        border: 1px solid #eaeaea;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        background: white;
        transition: 0.2s;
        text-decoration: none;
    }
    .prop-btn:hover {
        background: #f8f9fa;
        color: #0d6efd;
    }
    .prop-btn.favourited {
        color: #dc3545;
    }
  </style>

  <div class="prop-card" onclick="window.location='<?= site_url('Properties/PropertyDetails/' . $PropertyId); ?>'">
      
      <div class="prop-card-img-wrap">
          <img src="<?= $imageSrc; ?>" alt="Property Image">
          
          <div class="prop-badge-top-left"><?= $PropertyTypeName; ?></div>
          
          <div class="prop-badge-top-right">
              <span>For <?= $ListType; ?></span>
          </div>

          <div class="prop-badge-bottom-left">
              <i class="fa fa-map-marker-alt"></i> <?= $displayAddress; ?>
          </div>
      </div>

      <!-- Body Section -->
      <div class="prop-card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="prop-title" style="max-width: 65%;" title="<?= $PropertyTitle; ?>"><?= $PropertyTitle; ?></div>
              <div class="prop-price">$<?= number_format($TotalPrice); ?><?= (strtolower($ListType) == 'rent') ? '/week' : '' ?></div>
          </div>

          <div class="prop-desc"><?= $PropertyDescription; ?></div>
          
          <div class="d-flex justify-content-between align-items-center mt-auto mb-3">
              <div class="prop-features mb-0 mt-0">
                  <div><i class="fa fa-bed"></i> <?= is_numeric($Bedrooms) && $Bedrooms > 0 ? $Bedrooms : '0'; ?></div>
                  <div><i class="fa fa-bath"></i> <?= is_numeric($Bathrooms) && $Bathrooms > 0 ? $Bathrooms : '0'; ?></div>
                  <div class="tooltipBtn" data-unit="<?= $AreaUnit; ?>" value="<?= $CoveredArea; ?>">
                      <i class="fa fa-vector-square"></i> <?= $CoveredArea . ' ' . $AreaUnit; ?>
                  </div>
              </div>
              <span class="btn btn-primary btn-sm px-3 rounded-pill" style="font-weight: 500;">Details</span>
          </div>
      </div>

      <div class="prop-divider"></div>

      <!-- Footer Section -->
      <div class="prop-footer" onclick="event.stopPropagation();">
          <div class="prop-agent">
              <div class="avatar-circle"><?= $agentInitials; ?></div>
              <div class="d-flex flex-column justify-content-center">
                  <span class="prop-agent-name d-flex align-items-center">
                      <?= $agentName; ?>
                      <?php if ($isVerified): ?>
                          <span style="border: 1px solid #1b9500c5; background-color: rgba(32, 176, 0, 0.2);" class="badge ms-2 rounded-pill text-dark">Verified</span>
                      <?php else: ?>
                          <span style="border: 1px solid #95840066; background-color: rgba(255, 191, 0, 0.3);" class="badge text-dark ms-2 rounded-pill">Not Verified</span>
                      <?php endif; ?>
                  </span>
              </div>
          </div>
      </div>

  </div>
</div>
