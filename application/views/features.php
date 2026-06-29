<?php

 $StationId = '9';
// $RegionId = '9';
// $PropertyId = '114';

// var_dump($PropertyId);
// die();

$CompanyData     = $this->getlist_model->getFieldsMultipleConditions('tbl_stations','CountryId,CityId',"WHERE StationId='$StationId'",2);
$CountryId       = $CompanyData->CountryId;
$CityId          = $CompanyData->CityId;
$arrCountry    = $this->getlist_model->getDropDownArray('tbl_countries','CountryName','CountryId',"CountryId > 0");
$arrCities    = $this->getlist_model->getDropDownArray('tbl_cities','CityName','CityId',"CityId > 0");
$arrRegion    = $this->getlist_model->getDropDownArray('tbl_regions','Title','RegionId',"CountryId = '24'");

$arrHomes    = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_types','TypeId,Title,PropertyIcon',"WHERE PropertyGroup = 'Home' ORDER BY SortOrder");

$arrLand =$this->getlist_model->getFieldsMultipleConditions('tbl_properties_types', 'TypeId, Title, PropertyIcon', "WHERE PropertyGroup='Land' ORDER BY SortOrder");

$arrCommercial    = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_types','TypeId,Title,PropertyIcon',"WHERE PropertyGroup = 'Commercial' ORDER BY SortOrder");
$PropertyDetails = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_features','*',"WHERE PropertyId = '$PropertyId'",2);
  
$Flooring = '';
$PowerBackup = '';
$View = '';
$OtherMainFeatures = '';
$BuiltInYear = '';
$ParkingSpaces = '';
$Floors = '';
$IsDoubleGlazedWindows = '';
$IsCentralAirConditioning = '';
$IsCentralHeating = '';
$IsWasteDisposal = '';
$IsFurnished = '';
$OtherRooms = '';
$Bedrooms = '';
$Bathrooms = '';
$ServantQuarters = '';
$Kitchens = '';
$StoreRooms = '';
$IsDrawingRoom = '';
$IsDiningRoom = '';
$IsStudyRoom = '';
$IsPrayerRoom = '';
$IsPowderRoom = '';
$IsGym = '';
$IsSteamRoom = '';
$IsLoungeRoom = '';
$IsLaundryRoom = '';
$CommunicationFacilities = '';
$IsBroadbandInternetAccess = '';
$IsTVReady = '';
$IsIntercom = '';
$IsConferenceRoom = '';
$OtherCommunityFacilities = '';
$IsCommunityLawn = '';
$IsCommunitySwimmingPool = '';
$IsCommunityGym = '';
$IsMedicalCentre = '';
$IsFirstAid = '';
$IsDayCareCenter = '';
$IsKidsPlayArea = '';
$IsBarbequeArea = '';
$IsMosque = '';
$IsCommunityCentre = '';
$OtherHealthcare = '';
$IsLawnGarden = '';
$IsSwimmingPool = '';
$IsSauna = '';
$IsJacuzzi = '';
$NearbySchools = '';
$NearbyHospitals = '';
$NearbyShoppingMalls = '';
$NearbyRestaurants = '';
$DistanceFromAirport = '';
$NearbyPublicTransportService = '';
$OtherNearbyPlaces = '';
if($PropertyDetails)
{
  $Flooring          = $PropertyDetails->Flooring;
  $PowerBackup       = $PropertyDetails->PowerBackup;
  $View              = $PropertyDetails->View;
  $OtherMainFeatures = $PropertyDetails->OtherMainFeatures;
  $BuiltInYear       = $PropertyDetails->BuiltInYear;
  $ParkingSpaces     = $PropertyDetails->ParkingSpaces;
  $Floors            = $PropertyDetails->Floors;
  $IsDoubleGlazedWindows    = $PropertyDetails->IsDoubleGlazedWindows;
  $IsCentralAirConditioning = $PropertyDetails->IsCentralAirConditioning;
  $IsCentralHeating  = $PropertyDetails->IsCentralHeating;
  $IsWasteDisposal   = $PropertyDetails->IsWasteDisposal;
  $IsFurnished       = $PropertyDetails->IsFurnished;
  $OtherRooms        = $PropertyDetails->OtherRooms;
  $Bedrooms          = $PropertyDetails->Bedrooms;
  $Bathrooms         = $PropertyDetails->Bathrooms;
  $ServantQuarters   = $PropertyDetails->ServantQuarters;
  $Kitchens          = $PropertyDetails->Kitchens;
  $StoreRooms        = $PropertyDetails->StoreRooms;
  $IsDrawingRoom     = $PropertyDetails->IsDrawingRoom;
  $IsDiningRoom      = $PropertyDetails->IsDiningRoom;
  $IsStudyRoom       = $PropertyDetails->IsStudyRoom;
  $IsPrayerRoom      = $PropertyDetails->IsPrayerRoom;
  $IsPowderRoom      = $PropertyDetails->IsPowderRoom;
  $IsGym             = $PropertyDetails->IsGym;
  $IsSteamRoom       = $PropertyDetails->IsSteamRoom;
  $IsLoungeRoom      = $PropertyDetails->IsLoungeRoom;
  $IsLaundryRoom     = $PropertyDetails->IsLaundryRoom;
  $CommunicationFacilities   = $PropertyDetails->CommunicationFacilities;
  $IsBroadbandInternetAccess = $PropertyDetails->IsBroadbandInternetAccess;
  $IsTVReady         = $PropertyDetails->IsTVReady;
  $IsIntercom        = $PropertyDetails->IsIntercom;
  $IsConferenceRoom  = $PropertyDetails->IsConferenceRoom;
  $OtherCommunityFacilities  = $PropertyDetails->OtherCommunityFacilities;
  $IsCommunityLawn           = $PropertyDetails->IsCommunityLawn;
  $IsCommunitySwimmingPool   = $PropertyDetails->IsCommunitySwimmingPool;
  $IsCommunityGym            = $PropertyDetails->IsCommunityGym;
  $IsMedicalCentre           = $PropertyDetails->IsMedicalCentre;
  $IsFirstAid                = $PropertyDetails->IsFirstAid;
  $IsDayCareCenter           = $PropertyDetails->IsDayCareCenter;
  $IsKidsPlayArea            = $PropertyDetails->IsKidsPlayArea;
  $IsBarbequeArea            = $PropertyDetails->IsBarbequeArea;
  $IsMosque                  = $PropertyDetails->IsMosque;
  $IsCommunityCentre         = $PropertyDetails->IsCommunityCentre;
  $OtherHealthcare           = $PropertyDetails->OtherHealthcare;
  $IsLawnGarden              = $PropertyDetails->IsLawnGarden;
  $IsSwimmingPool            = $PropertyDetails->IsSwimmingPool;
  $IsSauna                   = $PropertyDetails->IsSauna;
  $IsJacuzzi                 = $PropertyDetails->IsJacuzzi;
  $NearbySchools             = $PropertyDetails->NearbySchools;
  $NearbyHospitals           = $PropertyDetails->NearbyHospitals;
  $NearbyShoppingMalls       = $PropertyDetails->NearbyShoppingMalls;
  $NearbyRestaurants         = $PropertyDetails->NearbyRestaurants;
  $DistanceFromAirport       = $PropertyDetails->DistanceFromAirport;
  $NearbyPublicTransportService = $PropertyDetails->NearbyPublicTransportService;
  $OtherNearbyPlaces            = $PropertyDetails->OtherNearbyPlaces;
}

?>    

<div class="dashboard-container">
    <div class="dashboard-card">
        <!-- <div class="card-header">
            <h2 class="section-title">Property Features</h2>
        </div> -->
        <div class="card-body p-4 property-form" id="divContent">
            <form class="" id="frmAddProperty" onsubmit="return false;">
      

      <div class="form-row">
          <div class="form-group w-100">
            <style>
                .nav-modern {
                    background: white;
                    padding: 10px;
                    border-radius: 12px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
                    background-color: var(--primary);
                    color: white;
                    box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
                }
            </style>
            
            <!-- ------------------------- -->
            <ul class="nav nav-pills nav-modern d-flex flex-wrap" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="Rooms-tab" data-bs-toggle="tab" data-bs-target="#Rooms" type="button" role="tab" aria-controls="Rooms" aria-selected="false"><i class="fa fa-door-open me-2"></i>Rooms</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link " id="MainFeatures-tab" data-bs-toggle="tab" data-bs-target="#MainFeatures" type="button" role="tab" aria-controls="MainFeatures" aria-selected="true"><i class="fa fa-star me-2"></i>Main Features</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="Business-tab" data-bs-toggle="tab" data-bs-target="#Business" type="button" role="tab" aria-controls="Business" aria-selected="false"><i class="fa fa-network-wired me-2"></i>Communications</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="Community-tab" data-bs-toggle="tab" data-bs-target="#Community" type="button" role="tab" aria-controls="Community" aria-selected="false"><i class="fa fa-users me-2"></i>Community Features</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="HealthCare-tab" data-bs-toggle="tab" data-bs-target="#HealthCare" type="button" role="tab" aria-controls="HealthCare" aria-selected="false"><i class="fa fa-heartbeat me-2"></i>Healthcare</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="OtherFacilities-tab" data-bs-toggle="tab" data-bs-target="#OtherFacilities" type="button" role="tab" aria-controls="OtherFacilities" aria-selected="false"><i class="fa fa-plus-circle me-2"></i>Other Facilities</button>
              </li>
            </ul>
            <div class="tab-content mt-4 w-100" id="myTabContent">
              <!-- Main Features Tab content -->
              <div class="tab-pane fade" id="MainFeatures" role="tabpanel" aria-labelledby="MainFeatures-tab">

                <div class="row mb-3 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Flooring</p>
                  </div>
                  <div class="col-lg-2 text-left">
                    <select class="form-select" name="selFlooring">
                      <?= $Flooring; ?>
                      <option value="Tiles" <?= ($Flooring === 'Tiles') ? 'selected' : ''; ?> >Tiles</option>
                      <option value="Marble" <?= ($Flooring === 'Marble') ? 'selected' : ''; ?> >Marble</option>
                      <option value="Wooden" <?= ($Flooring === 'Wooden') ? 'selected' : ''; ?> >Wooden</option>
                      <option value="Chip" <?= ($Flooring === 'Chip') ? 'selected' : ''; ?> >Chip</option>
                      <option value="Cement" <?= ($Flooring === 'Cement') ? 'selected' : ''; ?> >Cement</option>
                      <option value="Other" <?= ($Flooring === 'Other') ? 'selected' : ''; ?> >Other</option>
                    </select>
                  </div>
                  <!-- <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Power Backup</p>
                  </div>
                  <div class="col-lg-2">
                    <select class="form-select" name="selPowerBackup">
                      <?= $PowerBackup; ?>
                      <option selected="None">None</option>
                      <option value="Generator">Generator</option>
                      <option value="Ups">Ups</option>
                      <option value="Solar">Solar</option>
                      <option value="Other">Other</option>
                    </select>
                  </div> -->
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">View</p>
                  </div>
                  <div class="col-lg-2">
                    <div class="input-group tagsinput">
                      <input type="text" value="<?= $View; ?>" class="form-control" data-role="tagsinput" name="txtView">
                    </div>
                  </div>
                </div>

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Other Main Features</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="text" value="<?= $OtherMainFeatures; ?>" name="txtOtherMainFeatures" class="form-control">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Built in Date</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="date" value="<?= $BuiltInYear; ?>" name="dateBuiltInYear" class="form-control" required data-parsley-required-message="Built-in Date is required">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Parking Spaces</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="text" value="<?= $ParkingSpaces; ?>" name="txtParkingSpaces" class="form-control">
                  </div>
                </div>

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Floor(s)</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="text" value="<?= $Floors; ?>" name="txtFloors" class="form-control">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Double Glazed Windows</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsDoubleGlazedWindows == '1')?'checked':'0'; ?> name="chkIsDoubleGlazedWindows" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Central Air Conditioning</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsCentralAirConditioning == '1')?'checked':'0'; ?> name="chkIsCentralAirConditioning" class="form-check-input">
                  </div>
                </div>

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Central Heating</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsCentralHeating == '1')?'checked':'0'; ?> name="chkIsCentralHeating" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Waste Disposal</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsWasteDisposal == '1')?'checked':'0'; ?> name="chkIsWasteDisposal" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Furnished</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsFurnished == '1')?'checked':'0'; ?> name="chkIsFurnished" class="form-check-input">
                  </div>
                </div>

              </div>

              <!-- Rooms Tab Content -->
              <div class="tab-pane fade active show" id="Rooms" role="tabpanel" aria-labelledby="Rooms-tab">

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Bathrooms</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="number" value="<?= $Bathrooms??''; ?>" name="numBathrooms" class="form-control" required data-parsley-required-message="Bathrooms count is required">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Bedrooms</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="number" value="<?= $Bedrooms; ?>" name="numBedrooms" class="form-control" required data-parsley-required-message="Bedrooms count is required">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Other Rooms</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="text" value="<?= $OtherRooms; ?>" name="txtOtherRooms" class="form-control">
                  </div>
                </div>

                <div class="row text-left mb-3 mb-sm-0">
                  
                  <div class="col-lg-2">
                    <p class="text-dark text-right FieldLabel">Servant Quarters</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="text" value="<?= $ServantQuarters; ?>" name="txtServantQuarters" class="form-control">
                  </div>
                  <!-- <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Kitchens</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="text" value="<?= $Kitchens; ?>" name="txtKitchens" class="form-control">
                  </div> -->
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Store Rooms</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="text" value="<?= $StoreRooms; ?>" name="txtStoreRooms"class="form-control">
                  </div>
                </div>

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Drawing Room</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsDrawingRoom == '1')?'checked':'0'; ?> name="chkIsDrawingRoom" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Dining Room</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsDiningRoom == '1')?'checked':'0'; ?> name="chkIsDiningRoom" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Study Room</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsStudyRoom == '1')?'checked':'0'; ?> name="chkIsStudyRoom" class="form-check-input">
                  </div>
                </div>

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Prayer Room</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsPrayerRoom == '1')?'checked':'0'; ?> name="chkIsPrayerRoom" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Powder Room</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsPowderRoom == '1')?'checked':'0'; ?> name="chkIsPowderRoom" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Gym</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsGym == '1')?'checked':'0'; ?> name="chkIsGym" class="form-check-input">
                  </div>
                </div>

                <div class="row text-left mb-3 mb-sm-0 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Steam Room</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsSteamRoom == '1')?'checked':'0'; ?> name="chkIsSteamRoom" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Lounge or Sitting Room</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsLoungeRoom == '1')?'checked':'0'; ?> name="chkIsLoungeRoom" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Laundry Room</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="checkbox" value="1" <?= ($IsLaundryRoom == '1')?'checked':'0'; ?> name="chkIsLaundryRoom" class="form-check-input">
                  </div>
                </div>

              </div>

              <!-- Business Tab Content -->
              <div class="tab-pane fade" id="Business" role="tabpanel" aria-labelledby="Business-tab">

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-10">
                    <textarea rows="3" placeholder="Enter Facilities" class="form-control" type="text" name="txtCommunicationFacilities"><?= $CommunicationFacilities; ?></textarea>
                  </div>
                </div>

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-3">
                    <p class="text-dark FieldLabel">Broadband Internet Access</p>
                  </div>
                  <div class="col-lg-1">
                    <input type="checkbox" value="1" <?= ($IsBroadbandInternetAccess == '1')?'checked':'0'; ?> name="chkIsBroadbandInternetAccess" class="form-check-input">
                  </div>
                  <div class="col-lg-3">
                    <p class="text-dark FieldLabel">Satellite or Cable TV Ready</p>
                  </div>
                  <div class="col-lg-1">
                    <input type="checkbox" value="1" <?= ($IsTVReady == '1')?'checked':'0'; ?> name="chkIsTVReady" class="form-check-input">
                  </div>
                </div>
                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-3">
                    <p class="text-dark FieldLabel">Intercom</p>
                  </div>
                  <div class="col-lg-1">
                    <input type="checkbox" value="1" <?= ($IsIntercom == '1')?'checked':'0'; ?> name="chkIsIntercom" class="form-check-input">
                  </div>
                  <div class="col-lg-3">
                    <p class="text-dark FieldLabel">Conference Room</p>
                  </div>
                  <div class="col-lg-1">
                    <input type="checkbox" value="1" <?= ($IsConferenceRoom == '1')?'checked':'0'; ?> name="chkIsConferenceRoom" class="form-check-input">
                  </div>
                </div>

              </div>

              <!-- Community Tab Content -->
              <div class="tab-pane fade" id="Community" role="tabpanel" aria-labelledby="Community-tab">

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Community Lawn</p>
                  </div>
                  <div class="col-lg-1">
                    <input type="checkbox" value="1" <?= ($IsCommunityLawn == '1')?'checked':'0'; ?> name="chkIsCommunityLawn" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Swimming Pool</p>
                  </div>
                  <div class="col-lg-1">
                    <input type="checkbox" value="1" <?= ($IsCommunitySwimmingPool == '1')?'checked':'0'; ?> name="chkIsCommunitySwimmingPool" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Community Gym</p>
                  </div>
                  <div class="col-lg-1">
                    <input type="checkbox" value="1" <?= ($IsCommunityGym == '1')?'checked':'0'; ?> name="chkIsCommunityGym" class="form-check-input">
                  </div>
                </div>

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Medical Centre</p>
                  </div>
                  <div class="col-lg-1">
                    <input type="checkbox" value="1" <?= ($IsMedicalCentre == '1')?'checked':'0'; ?> name="chkIsMedicalCentre" class="form-check-input">
                    <!-- <input type="checkbox" value="1" name="chkIsMedicalCentre" class="form-check-input"> -->
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Day Care Centre</p>
                  </div>
                  <div class="col-lg-1">
                    <input type="checkbox" value="1" <?= ($IsDayCareCenter == '1')?'checked':'0'; ?> name="chkIsDayCareCenter" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Kids Play Area</p>
                  </div>
                  <div class="col-lg-1">
                    <input type="checkbox" value="1" <?= ($IsKidsPlayArea == '1')?'checked':'0'; ?> name="chkIsKidsPlayArea" class="form-check-input">
                  </div>
                </div>

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Barbeque Area</p>
                  </div>
                  <div class="col-lg-1">
                    <input type="checkbox" value="1" <?= ($IsBarbequeArea == '1')?'checked':'0'; ?> name="chkIsBarbequeArea" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Mosque</p>
                  </div>
                  <div class="col-lg-1">
                    <input type="checkbox" value="1" <?= ($IsMosque == '1')?'checked':'0'; ?> name="chkIsMosque" class="form-check-input">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Community Centre</p>
                  </div>
                  <div class="col-lg-1">
                    <input type="checkbox" value="1" <?= ($IsCommunityCentre == '1')?'checked':'0'; ?> name="chkIsCommunityCentre" class="form-check-input">
                  </div>
                </div>

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-9">
                    <textarea rows="5" type="text" placeholder="Other Community Facilities" name="txtOtherCommunityFacilities" class="form-control"><?= $OtherCommunityFacilities; ?></textarea>
                  </div>
                </div>

              </div>

              <!-- Health Care Tab Content -->
              <div class="tab-pane fade" id="HealthCare" role="tabpanel" aria-labelledby="HealthCare-tab">


                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-2 d-flex">
                    <input type="checkbox" value="1" <?= ($IsLawnGarden == '1')?'checked':'0'; ?> name="chkIsLawnGarden" class="form-check-input FieldLabel">
                    <p class="text-dark FieldLabel mx-2">Lawn or Garden</p>
                  </div>
                  <!-- div class="col-lg-1">
                  </div> -->
                  <div class="col-lg-2 d-flex">
                    <input type="checkbox" value="1" <?= ($IsSwimmingPool == '1')?'checked':'0'; ?> name="chkIsSwimmingPool" class="form-check-input FieldLabel">
                    <p class="text-dark FieldLabel mx-2">Swimming Pool</p>
                  </div>
                  <!-- <div class="col-lg-1">
                  </div> -->
                  <div class="col-lg-2 d-flex">
                    <input type="checkbox" value="1" <?= ($IsSauna == '1')?'checked':'0'; ?> name="chkIsSauna" class="form-check-input FieldLabel">
                    <p class="text-dark FieldLabel mx-2">Sauna</p>
                  </div>
                  <!-- <div class="col-lg-1">
                  </div> -->
                  <div class="col-lg-2 d-flex">
                    <input type="checkbox" value="1" <?= ($IsJacuzzi == '1')?'checked':'0'; ?> name="chkIsJacuzzi" class="form-check-input FieldLabel">
                    <p class="text-dark FieldLabel mx-2">Jacuzzi</p>
                  </div>
                  <!-- <div class="col-lg-1">
                  </div> -->
                </div>
                
                <div class="row text-left mb-3 mt-3 mb-sm-0">
                  <!-- <div class="col-lg-1"></div> -->
                  <div class="col-lg-9">
                    <textarea rows="5" type="text" name="txtOtherHealthcare" placeholder="Other Healthcare and Recreation Facilities" class="form-control"><?= $OtherHealthcare; ?></textarea>
                  </div>
                </div>

              </div>

              <!-- Other Facilities Tab Content -->
              <div class="tab-pane fade" id="OtherFacilities" role="tabpanel" aria-labelledby="OtherFacilities-tab">

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Nearby Schools</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="text" value="<?= $NearbySchools; ?>" name="txtNearbySchools" class="form-control">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Nearby Hospitals</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="text" value="<?= $NearbyHospitals; ?>" name="txtNearbyHospitals" class="form-control">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Nearby Shopping Malls</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="text" value="<?= $NearbyShoppingMalls; ?>" name="txtNearbyShoppingMalls" class="form-control">
                  </div>
                </div>

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark text-right FieldLabel">Nearby Restaurants</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="text" value="<?= $NearbyRestaurants; ?>" name="txtNearbyRestaurants" class="form-control">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Distance From Airport (kms)</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="number" value="<?= $DistanceFromAirport; ?>" name="txtDistanceFromAirport" class="form-control">
                  </div>
                  <div class="col-lg-2">
                    <p class="text-dark text-right FieldLabel">Other Nearby Places</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="text" value="<?= $OtherNearbyPlaces; ?>" name="txtOtherNearbyPlaces" class="form-control">
                  </div>
                </div>

                <div class="row text-left mb-3 mb-sm-0">
                  <div class="col-lg-2">
                    <p class="text-dark FieldLabel">Nearby Public Transport Service</p>
                  </div>
                  <div class="col-lg-2">
                    <input type="text" value="<?= $NearbyPublicTransportService; ?>" name="txtNearbyPublicTransportService" class="form-control">
                  </div>
                </div>

              </div>

            </div>
            <!-- ------------------------- -->

          </div>
      </div>

      <div class="d-flex justify-content-center align-items-center gap-5 mt-5">
        <button type="button" class="btn btn-primary py-3 px-5 my-4 fw-bold animated fadeIn actSubmitForm" frm="frmAddProperty" ref="urlResponse" href="Properties/SaveFeatures/<?= $Case ?>/<?= $PropertyId;?>">Save & Next</button>
      </div>

    </form>
        </div>
    </div>
</div>