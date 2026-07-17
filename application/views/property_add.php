<?php

$StationId      = $this->session->userdata('user_station');
$CompanyId      = $this->session->userdata('user_company');
$varNow         = date('Y-m-d H:i:s');

$PropertyId = $PropertyId??'0';

$CompanyData    = $this->getlist_model->getFieldsMultipleConditions('tbl_stations','CountryId,CityId',"WHERE StationId='$StationId'",2);
$CountryId      = $CompanyData->CountryId;
$CityId         = $CompanyData->CityId;
$RegionId = $StationId;
// $RegionId       = $CompanyData->RegionId;
$arrCountry     = $this->getlist_model->getDropDownArray('tbl_countries','CountryName','CountryId',"CountryId = '28'");
$arrCities      = $this->getlist_model->getDropDownArray('tbl_cities','CityName','CityId',"CityId > 0 AND CountryCode = '28'");
$arrRegion      = $this->getlist_model->getDropDownArray('tbl_regions','Title','RegionId',"CountryId = '28'");

$arrTypes = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_types','TypeId,Title,PropertyIcon',"ORDER BY SortOrder");
if(!is_array($arrTypes)) $arrTypes = [];

$PropertyDetails = $this->getlist_model->getFieldsMultipleConditions('tbl_properties','*',"WHERE PropertyId = '$PropertyId'",2);

$PropertyTypeId = '1';

$PropertyTitle = '';
$ListType = '';
$OwnershipId = '';
$CoveredArea = '';
$PropertyStatus = '';
$PropertyDescription = '';
$MailingAddress = '';
$CountryId = '';
$ZipCode = '';
$Suburb = '';
$State = '';
$UnitNumber = '';
$BuildingNumber = '';
$StreetNumber = '';
$StreetName = '';
$TotalPrice = '';
$SecurityBond = '';
$Installments = '';
$InstallmentAmount = '';
$PossessionDate = '';
$Longitude = '';
$Latitude = '';

if($PropertyDetails)
{

    $PropertyTitle = $PropertyDetails->PropertyTitle;
    $ListType = $PropertyDetails->ListType;
    $PropertyTypeId = $PropertyDetails->PropertyTypeId;
    $OwnershipId = $PropertyDetails->OwnershipId;
    $CoveredArea = $PropertyDetails->CoveredArea;
    $PropertyStatus = $PropertyDetails->PropertyStatus;
    $PropertyDescription = $PropertyDetails->PropertyDescription;
    $MailingAddress = $PropertyDetails->MailingAddress;
    $Country = $PropertyDetails->Country;
    $ZipCode = $PropertyDetails->ZipCode;
    $Suburb = $PropertyDetails->Suburb;
    $State = $PropertyDetails->State;
    $UnitNumber = $PropertyDetails->UnitNumber;
    $BuildingNumber = $PropertyDetails->BuildingNumber;
    $StreetNumber = $PropertyDetails->StreetNumber;
    $StreetName = $PropertyDetails->StreetName;
    $TotalPrice = $PropertyDetails->TotalPrice;
    $SecurityBond = $PropertyDetails->SecurityBond;
    $Installments = $PropertyDetails->Installments;
    $InstallmentAmount = $PropertyDetails->InstallmentAmount;
    $PossessionDate = $PropertyDetails->PossessionDate;
    $Longitude = $PropertyDetails->Longitude;
    $Latitude = $PropertyDetails->Latitude;
}

$CountryId = 28;
?>
        

<div class="dashboard-container pt-4">
    <form class="" id="frmAddProperty" data-parsley-validate onsubmit="return false;">
        <input type="hidden" name="txtAddedOn" value="<?=$varNow;?>">
        
        <div class="dashboard-card">
            <!-- <div class="card-header">
                <h2 class="section-title">Basic Information</h2>
            </div> -->
            <div class="card-body p-4 property-form" id="divContent">

        <div class="form-row">
            <div class="form-group">
                <div class="d-block">
                    <label class="mb-2">Property Type <span class="text-danger">*</span></label>
                    <div class="property-type d-flex flex-wrap gap-2">

                        <?php
                        $i = 0;
                        $isChecked = '';
                        foreach ($arrTypes as $hKey => $hValue) {
                            $TypeId = $hValue->TypeId;
                            $isChecked = ($TypeId == $PropertyTypeId) ? 'checked' : '';
                        ?>
                            <input value="<?= $TypeId;?>" type="radio" class="btn-check" id="chkPropertyType<?= $i;?>" name="chkPropertyType" autocomplete="off" <?= $isChecked;?> required>
                            <label class="property-btn" for="chkPropertyType<?= $i;?>">
                                <?php if(!empty($hValue->PropertyIcon)): ?>
                                <i class="<?= $hValue->PropertyIcon;?>" aria-hidden="true"></i> 
                                <?php endif; ?>
                                <?= $hValue->Title;?>
                            </label>
                        <?php
                            $i++;
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- <h2 class="section-title my-4">Information</h2> -->
        <div class="form-row">
            <div class="form-group">
                <label>Property Title <span class="text-danger">*</span></label>
                <input type="text" name="txtPropertyTitle" value="<?= $PropertyTitle;?>" required data-parsley-required-message="Property Title is required" placeholder="Best house in the city">
            </div>

            <div class="form-group">
                <label>Covered Area <span class="text-danger">*</span> <span style="font-size: 14px;" class="fw-normal">(in square-foot)</span></label>
                <input type="text" value="<?= $CoveredArea; ?>" name="txtCoveredArea" placeholder="10 Sqft" required data-parsley-required-message="Covered Area is required">
            </div>
            <div class="form-group">
                <label>Property Status <span class="text-danger">*</span></label>
                <select class="form-select" name="selPropertyStatus" id="selPropertyStatus" required data-parsley-required-message="Property Status is required">
                    <?=$PropertyStatus;?>
                    <option value="occupied" <?= ($PropertyStatus === 'occupied') ? 'selected' : ''; ?> >Occupied</option>
                    <option value="rented" <?= ($PropertyStatus === 'rented') ? 'selected' : ''; ?> >Rented</option>
                    <option value="vacant" <?= ($PropertyStatus === 'vacant') ? 'selected' : ''; ?> >Vacant</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group full-width">
                <label>Description <span class="text-danger">*</span></label>
                <textarea name="txtPropertyDescription" required data-parsley-required-message="Description is required" placeholder="Enter property description here..."><?= $PropertyDescription; ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label>Mailing Address <span class="text-danger">*</span></label>
            <div class="d-flex">
                <div class="input-group w-100">
                  <input value="<?= $MailingAddress; ?>" type="text" id="txtPropertyAddress" name="txtPropertyAddress" class="form-control" placeholder="Search by Address" required data-parsley-required-message="Address is required" data-parsley-errors-container="#address-errors" />
                  <span class="input-group-text">
                    <i class="fas fa-search"></i>
                  </span>
                </div>

                <!-- Hidden Fields -->
                <input type="hidden" name="txtLongitude" id="txtLongitude" value="<?= $Longitude ?>">
                <input type="hidden" name="txtLatitude" id="txtLatitude" value="<?= $Latitude ?>">

            </div>
            <div id="address-errors" class="mt-1"></div>

            <div class="row my-3">
                <div class="col-md-3">
                    <label>Country</label>
                    <input type="text" name="selCountry" id="selCountry" value="<?= $Country ?? 'Australia' ?>" class="form-control" readonly required>
                </div>
                <div class="col-md-3">
                    <label for="state">State:</label>
                    <input type="text" class="form-control" name="state" value="<?= $State ?? '' ?>" id="txtState">
                </div>
                <div class="col-md-3">
                    <label for="suburb">Suburb:</label>
                    <input type="text"class="form-control" name="suburb" value="<?= $Suburb ?? '' ?>" id="txtSuburb">
                </div>
                <div class="col-md-3">
                    <label for="numZipCode">Postal Code</label>
                    <input value="<?= $ZipCode; ?>" type="number" name="numZipCode" class="form-control" id="txtPostalCode">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="txtBuildingNumber">Unit Number:</label>
                    <input value="<?= $UnitNumber; ?>" type="text" id="txtUnitNumber" name="txtUnitNumber" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="txtStreetNumber">Street Number:</label>
                    <input value="<?= $StreetNumber; ?>" type="text" name="txtStreetNumber" class="form-control" id="txtStreetNumber">
                </div>
                <div class="col-md-3">
                    <label for="txtStreetName">Street Name:</label>
                    <input value="<?= $StreetName; ?>" type="text" id="txtStreetName" name="txtStreetName" class="form-control">
                </div>
            </div>

            <!-- <div id="addressFields" style="display:none;">

            </div> -->
        </div>
    </div>

        <div class="d-flex justify-content-center align-items-center gap-5 mt-4">
            <button type="button" class="btn btn-primary py-3 px-5 my-4 fw-bold animated fadeIn actSubmitForm" frm="frmAddProperty" ref="urlResponse" href="Properties/SavePropertyInformation/<?= ($PropertyId > 0) ? 'Edit' : $Case ?>/<?= $PropertyId;?>">Save & Next</button>
        </div>

        </div>
    </div>
</form>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv1FrfWK8d_Z28pT_XtiZW02msCfrC2Rs&libraries=places&callback=initAutocomplete" async defer></script>
<script>

    let placeSelected = false;
    let autocompleteInitialized = false;

function initAutocomplete() {
  if (autocompleteInitialized) return;
  const input = document.getElementById('txtPropertyAddress');
  if (!input) return;
  autocompleteInitialized = true;
  
  const autocomplete = new google.maps.places.Autocomplete(input, {
    componentRestrictions: { country: "au" },
    fields: ["address_components", "formatted_address", "geometry"]
  });

  autocomplete.addListener('place_changed', function () {
    const place = autocomplete.getPlace();
    placeSelected = true;

    if (!place.geometry) {
      customAlert('Warning', "Please select a valid address from the list.", 'warning');
      input.value = "";
      return;
    }

    const lat = place.geometry.location.lat();
    const lng = place.geometry.location.lng();

    document.getElementById("txtLatitude").value = lat;
    document.getElementById("txtLongitude").value = lng;

    // Reset fields
    document.getElementById("txtState").value = "";
    document.getElementById("txtSuburb").value = "";
    document.getElementById("txtStreetName").value = "";
    document.getElementById("txtStreetNumber").value = "";
    document.getElementById("txtPostalCode").value = "";
    document.getElementById("txtUnitNumber").value = "";

    // Extract components
    place.address_components.forEach(component => {
      const types = component.types;

      if (types.includes("street_number")) {
        document.getElementById("txtStreetNumber").value = component.long_name;
      }
      if (types.includes("route")) {
        document.getElementById("txtStreetName").value = component.long_name;
      }
      if (types.includes("locality")) {
        document.getElementById("txtSuburb").value = component.long_name;
      }
      if (types.includes("administrative_area_level_1")) {
        document.getElementById("txtState").value = component.short_name;
      }
      if (types.includes("postal_code")) {
        document.getElementById("txtPostalCode").value = component.long_name;
      }
      if (types.includes("subpremise")) {
        document.getElementById("txtUnitNumber").value = component.long_name;
      }
    });
  });

  // Allow manual entry: removed the blur event that clears input if placeSelected is false.
  
  // Reset flag if user types again
  input.addEventListener("input", function () {
    placeSelected = false;
  });
}


    

var manualBtn = document.getElementById('manualAddressBtn');
if (manualBtn) {
  manualBtn.addEventListener('click', function() {
    var addressFields = document.getElementById('addressFields');
    if (addressFields.style.display === 'none' || addressFields.style.display === '') {
      addressFields.style.display = 'block';
    } else {
      addressFields.style.display = 'none';
    }
  });
}







</script>
