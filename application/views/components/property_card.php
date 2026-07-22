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

<?php $GridClass = $GridClass ?? 'col-lg-4 col-md-6'; ?>
<div class="<?= $GridClass ?> wow fadeInUp property-item-box <?= htmlspecialchars($ListType); ?>" 
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
          
          <div class="prop-badge-top-right d-flex flex-column align-items-end" style="gap: 5px;">
              <span>For <?= $ListType; ?></span>
              <?php if(isset($ShowStatusBadge) && $ShowStatusBadge): ?>
                  <?php if(isset($value->Status) && strtolower($value->Status) == 'published'): ?>
                      <span style="background-color: #198754;"><i class="fa fa-check-circle me-1"></i> Published</span>
                  <?php else: ?>
                      <span style="background-color: #ffc107; color: #000;"><i class="fa fa-clock me-1"></i> Not Published</span>
                  <?php endif; ?>
              <?php endif; ?>
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
          
          <?php if(isset($DashboardLayout) && $DashboardLayout): ?>
          <div class="d-flex flex-column mt-auto mb-3">
              <div class="prop-features mb-3 mt-0">
                  <div><i class="fa fa-bed"></i> <?= is_numeric($Bedrooms) && $Bedrooms > 0 ? $Bedrooms : '0'; ?></div>
                  <div><i class="fa fa-bath"></i> <?= is_numeric($Bathrooms) && $Bathrooms > 0 ? $Bathrooms : '0'; ?></div>
                  <div class="tooltipBtn" data-unit="<?= $AreaUnit; ?>" value="<?= $CoveredArea; ?>">
                      <i class="fa fa-vector-square"></i> <?= $CoveredArea . ' ' . $AreaUnit; ?>
                  </div>
              </div>
              <div class="d-flex gap-2 justify-content-start flex-wrap">
                  <?php if(isset($UserId) && isset($value->AddedBy) && $UserId == $value->AddedBy): ?>
                  <a href="<?= site_url('Properties/AddListing/' . $PropertyId . '/Edit'); ?>" class="btn btn-outline-primary btn-sm px-4 rounded-pill" style="font-weight: 500;" onclick="event.stopPropagation();">Edit</a>
                  <button type="button" class="btn btn-outline-secondary btn-sm px-4 rounded-pill" style="font-weight: 500;" data-bs-toggle="modal" data-bs-target="#statusModal_<?= $PropertyId ?>" onclick="event.stopPropagation();">Change Status</button>
                  <?php endif; ?>
                  <span class="btn btn-primary btn-sm px-4 rounded-pill" style="font-weight: 500;">Details</span>
              </div>
          </div>
          
          <?php if(isset($UserId) && isset($value->AddedBy) && $UserId == $value->AddedBy): ?>
          <!-- Status Modal -->
          <div class="modal fade" id="statusModal_<?= $PropertyId ?>" tabindex="-1" aria-hidden="true" onclick="event.stopPropagation();">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                <div class="modal-header bg-light border-bottom-0">
                  <h5 class="modal-title fw-bold">Change Status</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="statusForm_<?= $PropertyId ?>">
                        <input type="hidden" name="PropertyId" value="<?= $PropertyId ?>">
                        
                        <div class="mb-4 d-flex align-items-start">
                          <input type="radio" name="Status_<?= $PropertyId ?>" id="status_pub_<?= $PropertyId ?>" value="Published" <?= (isset($value->Status) && strtolower($value->Status) == 'published') ? 'checked' : '' ?> style="margin-top: 4px; margin-right: 12px; transform: scale(1.2); appearance: radio !important; opacity: 1 !important; position: static !important; cursor: pointer; display: block !important; visibility: visible !important;">
                          <div>
                              <label class="fw-bold text-success mb-1" for="status_pub_<?= $PropertyId ?>" style="cursor: pointer;">
                                <i class="fa fa-check-circle me-1"></i> Published
                              </label>
                              <div class="text-muted small">Visible to everyone in public search results.</div>
                          </div>
                        </div>
                        
                        <div class="mb-4 d-flex align-items-start">
                          <input type="radio" name="Status_<?= $PropertyId ?>" id="status_unpub_<?= $PropertyId ?>" value="Not Published" <?= (!isset($value->Status) || empty(trim($value->Status)) || in_array(strtolower($value->Status), ['not published', 'draft', 'pending'])) ? 'checked' : '' ?> style="margin-top: 4px; margin-right: 12px; transform: scale(1.2); appearance: radio !important; opacity: 1 !important; position: static !important; cursor: pointer; display: block !important; visibility: visible !important;">
                          <div>
                              <label class="fw-bold text-warning mb-1" style="color: #d39e00 !important; cursor: pointer;" for="status_unpub_<?= $PropertyId ?>">
                                <i class="fa fa-clock me-1"></i> Not Published
                              </label>
                              <div class="text-muted small">Hidden from public listings, visible only to you.</div>
                          </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0 bg-light rounded-bottom">
                  <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary px-4 rounded-pill fw-bold" onclick="savePropertyStatus(<?= $PropertyId ?>)">Save Status</button>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
          
          <?php else: ?>
          <div class="d-flex justify-content-between align-items-center mt-auto mb-3">
              <div class="prop-features mb-0 mt-0">
                  <div><i class="fa fa-bed"></i> <?= is_numeric($Bedrooms) && $Bedrooms > 0 ? $Bedrooms : '0'; ?></div>
                  <div><i class="fa fa-bath"></i> <?= is_numeric($Bathrooms) && $Bathrooms > 0 ? $Bathrooms : '0'; ?></div>
                  <div class="tooltipBtn" data-unit="<?= $AreaUnit; ?>" value="<?= $CoveredArea; ?>">
                      <i class="fa fa-vector-square"></i> <?= $CoveredArea . ' ' . $AreaUnit; ?>
                  </div>
              </div>
              <div class="d-flex gap-2">
                  <span class="btn btn-primary btn-sm px-3 rounded-pill" style="font-weight: 500;">Details</span>
              </div>
          </div>
          <?php endif; ?>
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

<?php if (!defined('PROP_CARD_STATUS_SCRIPT')): define('PROP_CARD_STATUS_SCRIPT', 1); ?>
<script>
function savePropertyStatus(PropertyId) {
    if (typeof $ === 'undefined' || typeof Swal === 'undefined') {
        alert('Required libraries not loaded.');
        return;
    }
    
    var form = $('#statusForm_' + PropertyId);
    var status = form.find('input[name="Status_' + PropertyId + '"]:checked').val();
    
    $.ajax({
        url: '<?= site_url("Properties/UpdateStatus") ?>',
        type: 'POST',
        data: { PropertyId: PropertyId, Status: status },
        dataType: 'json',
        success: function(response) {
            if (response.Status) {
                Swal.fire('Success', response.Message, 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', response.Message, 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'An error occurred while updating the status.', 'error');
        }
    });
}
</script>
<?php endif; ?>
