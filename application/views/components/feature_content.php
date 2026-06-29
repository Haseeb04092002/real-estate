<?php
defined('BASEPATH') OR exit('No direct script access allowed');



// $this->db->select('*');
// $this->db->where('PropertyTypeId > ','0');
// $Query = $this->db->get('tbl_properties_features');
// $PropertyFeatures = $Query->result();

//     $Flooring                     = $PropertyFeatures->Flooring;
//     $PowerBackup                  = $PropertyFeatures->PowerBackup;
//     $View                         = $PropertyFeatures->View;
//     $OtherMainFeatures            = $PropertyFeatures->OtherMainFeatures;
//     $BuiltInYear                  = $PropertyFeatures->BuiltInYear;
//     $ParkingSpaces                = $PropertyFeatures->ParkingSpaces;
//     $Floors                       = $PropertyFeatures->Floors;
//     $IsDoubleGlazedWindows        = $PropertyFeatures->IsDoubleGlazedWindows;
//     $IsCentralAirConditioning     = $PropertyFeatures->IsCentralAirConditioning;
//     $IsCentralHeating             = $PropertyFeatures->IsCentralHeating;
//     $IsWasteDisposal              = $PropertyFeatures->IsWasteDisposal;
//     $IsFurnished                  = $PropertyFeatures->IsFurnished;



?>

<ul class="nav nav-pills my-3 bg-primary p-3" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="MainFeatures-tab" data-bs-toggle="tab" data-bs-target="#MainFeatures" type="button" role="tab" aria-controls="MainFeatures" aria-selected="true">Main Features</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="Rooms-tab" data-bs-toggle="tab" data-bs-target="#Rooms" type="button" role="tab" aria-controls="Rooms" aria-selected="false">Rooms</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="Business-tab" data-bs-toggle="tab" data-bs-target="#Business" type="button" role="tab" aria-controls="Business" aria-selected="false">Communications</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="Community-tab" data-bs-toggle="tab" data-bs-target="#Community" type="button" role="tab" aria-controls="Community" aria-selected="false">Community Features</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="HealthCare-tab" data-bs-toggle="tab" data-bs-target="#HealthCare" type="button" role="tab" aria-controls="HealthCare" aria-selected="false">Healthcare Recreational</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="OtherFacilities-tab" data-bs-toggle="tab" data-bs-target="#OtherFacilities" type="button" role="tab" aria-controls="OtherFacilities" aria-selected="false">Other Facilities</button>
  </li>
</ul>
<div class="tab-content w-75 mt-3" id="myTabContent">
  <!-- Main Features Tab content -->
  <div class="tab-pane fade show active" id="MainFeatures" role="tabpanel" aria-labelledby="MainFeatures-tab">

    <div class="row mb-3">
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Flooring</p>
      </div>
      <div class="col-lg-2 text-left">
        <select class="form-select" name="Flooring" >
          <option selected="Tiles">Tiles</option>
          <option value="Marble">Marble</option>
          <option value="Wooden">Wooden</option>
          <option value="Chip">Chip</option>
          <option value="Cement">Cement</option>
          <option value="Other">Other</option>
        </select>
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Electricity Backup</p>
      </div>
      <div class="col-lg-2">
        <select class="form-select" name="PowerBackup">
          <option selected="None">None</option>
          <option value="Generator">Generator</option>
          <option value="Ups">Ups</option>
          <option value="Solar">Solar</option>
          <option value="Other">Other</option>
        </select>
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">View</p>
      </div>
      <div class="col-lg-2">
        <div class="input-group tagsinput">
          <input type="text" class="form-control" data-role="tagsinput" name="txtView" value="">
        </div>
      </div>
    </div>

    <div class="row text-left mb-3">
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Other Main Features</p>
      </div>
      <div class="col-lg-2">
        <input type="text" name="txtOtherMainFeatures" value="" class="form-control">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Built in year</p>
      </div>
      <div class="col-lg-2">
        <input type="date" name="txtBuiltInYear" value="" class="form-control">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Parking Spaces</p>
      </div>
      <div class="col-lg-2">
        <input type="text" name="txtParkingSpaces" value="" class="form-control">
      </div>
    </div>

    <div class="row text-left mb-3">
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Floors</p>
      </div>
      <div class="col-lg-2">
        <input type="text" name="txtFloors" value="" class="form-control">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Double Glazed Windows</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkIsDoubleGlazedWindows" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Central Air Conditioning</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkIsCentralAirConditioning" value="1" class="form-check-input">
      </div>
    </div>

    <div class="row text-left mb-3">
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Central Heating</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkIsCentralHeating" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Waste Disposal</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkIsWasteDisposal" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Furnished</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkIsFurnished" value="1" class="form-check-input">
      </div>
    </div>

  </div>

  <!-- Rooms Tab Content -->
  <div class="tab-pane fade" id="Rooms" role="tabpanel" aria-labelledby="Rooms-tab">

    <div class="row text-left mb-3">
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Bathrooms</p>
      </div>
      <div class="col-lg-2">
        <input type="number" name="txtBathrooms" value="2" class="form-control">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Bedrooms</p>
      </div>
      <div class="col-lg-2">
        <input type="number" name="txtBedrooms" value="5" class="form-control">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Other Rooms</p>
      </div>
      <div class="col-lg-2">
        <input type="text" name="txtOtherRooms" value="" class="form-control">
      </div>
    </div>

    <div class="row text-left mb-3">
      
      <div class="col-lg-2">
        <p class="text-dark text-right FieldLabel">Servant Quarters</p>
      </div>
      <div class="col-lg-2">
        <input type="text" name="txtServantQuarters" value="" class="form-control">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Kitchens</p>
      </div>
      <div class="col-lg-2">
        <input type="text" name="txtKitchens" value="" class="form-control">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Store Rooms</p>
      </div>
      <div class="col-lg-2">
        <input type="text" name="txtStoreRooms" value="" class="form-control">
      </div>
    </div>

    <div class="row text-left mb-3">
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Drawing Room</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkIsDrawingRoom" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Dining Room</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkDiningRoom" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Study Room</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkIsStudyRoom" value="1" class="form-check-input">
      </div>
    </div>

    <div class="row text-left mb-3">
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Prayer Room</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkIsPrayerRoom" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Powder Room</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkIsPowderRoom" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Gym</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkIsGym" value="1" class="form-check-input">
      </div>
    </div>

    <div class="row text-left mb-3">
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Steam Room</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkIsSteamRoom" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Lounge or Sitting Room</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkIsLoungeRoom" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Laundry Room</p>
      </div>
      <div class="col-lg-2">
        <input type="checkbox" name="chkIsLaundryRoom" value="1" class="form-check-input">
      </div>
    </div>

  </div>

  <!-- Business Tab Content -->
  <div class="tab-pane fade" id="Business" role="tabpanel" aria-labelledby="Business-tab">

    <div class="row text-left mb-3">
      <div class="col-lg-10">
        <textarea rows="3" placeholder="Enter Facilities" class="form-control" type="text" name="txtCommunicationFacilities"></textarea>
      </div>
    </div>

    <div class="row text-left mb-3">
      <div class="col-lg-3">
        <p class="text-dark FieldLabel">Broadband Internet Access</p>
      </div>
      <div class="col-lg-1">
        <input type="checkbox" name="chkIsBroadbandInternetAccess" value="1" class="form-check-input">
      </div>
      <div class="col-lg-3">
        <p class="text-dark FieldLabel">Satellite or Cable TV Ready</p>
      </div>
      <div class="col-lg-1">
        <input type="checkbox" name="chkIsTVReady" value="1" class="form-check-input">
      </div>
    </div>
    <div class="row text-left mb-3">
      <div class="col-lg-3">
        <p class="text-dark FieldLabel">Intercom</p>
      </div>
      <div class="col-lg-1">
        <input type="checkbox" name="chkIsIntercom" value="1" class="form-check-input">
      </div>
      <div class="col-lg-3">
        <p class="text-dark FieldLabel">Conference Room</p>
      </div>
      <div class="col-lg-1">
        <input type="checkbox" name="chkIsConferenceRoom" value="1" class="form-check-input">
      </div>
    </div>

  </div>

  <!-- Community Tab Content -->
  <div class="tab-pane fade" id="Community" role="tabpanel" aria-labelledby="Community-tab">

    <div class="row text-left mb-3">
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Community Lawn</p>
      </div>
      <div class="col-lg-1">
        <input type="checkbox" name="chkIsCommunityLawn" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Swimming Pool</p>
      </div>
      <div class="col-lg-1">
        <input type="checkbox" name="chkIsCommunitySwimmingPool" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Community Gym</p>
      </div>
      <div class="col-lg-1">
        <input type="checkbox" name="chkIsCommunityGym" value="1" class="form-check-input">
      </div>
    </div>

    <div class="row text-left mb-3">
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Medical Centre</p>
      </div>
      <div class="col-lg-1">
        <input type="checkbox" name="chkIsMedicalCentre" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Day Care Centre</p>
      </div>
      <div class="col-lg-1">
        <input type="checkbox" name="chkIsDayCareCenter" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Kids Play Area</p>
      </div>
      <div class="col-lg-1">
        <input type="checkbox" name="chkIsKidsPlayArea" value="1" class="form-check-input">
      </div>
    </div>

    <div class="row text-left mb-3">
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Barbeque Area</p>
      </div>
      <div class="col-lg-1">
        <input type="checkbox" name="chkIsBarbequeArea" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Mosque</p>
      </div>
      <div class="col-lg-1">
        <input type="checkbox" name="chkIsMosque" value="1" class="form-check-input">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Community Centre</p>
      </div>
      <div class="col-lg-1">
        <input type="checkbox" name="chkIsCommunityCentre" value="1" class="form-check-input">
      </div>
    </div>

    <div class="row text-left mb-3">
      <div class="col-lg-9">
        <textarea rows="5" type="text" placeholder="Other Community Facilities" name="txtOtherCommunityFacilities" class="form-control"></textarea>
      </div>
    </div>

  </div>

  <!-- Health Care Tab Content -->
  <div class="tab-pane fade" id="HealthCare" role="tabpanel" aria-labelledby="HealthCare-tab">


    <div class="row text-left mb-3">
      <div class="col-lg-2 d-flex">
        <input type="checkbox" name="chkIsLawnGarden" value="1" class="form-check-input">
        <p class="text-dark FieldLabel mx-2">Lawn or Garden</p>
      </div>
      <!-- div class="col-lg-1">
      </div> -->
      <div class="col-lg-2 d-flex">
        <input type="checkbox" name="chkIsSwimmingPool" value="1" class="form-check-input">
        <p class="text-dark FieldLabel mx-2">Swimming Pool</p>
      </div>
      <!-- <div class="col-lg-1">
      </div> -->
      <div class="col-lg-2 d-flex">
        <input type="checkbox" name="chkIsSwimmingPool" value="1" class="form-check-input">
        <p class="text-dark FieldLabel mx-2">Sauna</p>
      </div>
      <!-- <div class="col-lg-1">
      </div> -->
      <div class="col-lg-2 d-flex">
        <input type="checkbox" name="chkIsSauna" value="1" class="form-check-input">
        <p class="text-dark FieldLabel mx-2">Jacuzzi</p>
      </div>
      <!-- <div class="col-lg-1">
      </div> -->
    </div>
    
    <div class="row text-left mb-3">
      <!-- <div class="col-lg-1"></div> -->
      <div class="col-lg-9">
        <textarea rows="5" type="text" name="txtOtherHealthcare" value="" placeholder="Other Healthcare and Recreation Facilities" class="form-control"></textarea>
      </div>
    </div>

  </div>

  <!-- Other Facilities Tab Content -->
  <div class="tab-pane fade" id="OtherFacilities" role="tabpanel" aria-labelledby="OtherFacilities-tab">

    <div class="row text-left mb-3">
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Nearby Schools</p>
      </div>
      <div class="col-lg-2">
        <input type="text" name="txtNearbySchools" value="" class="form-control">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Nearby Hospitals</p>
      </div>
      <div class="col-lg-2">
        <input type="text" name="txtNearbyHospitals" value="" class="form-control">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Nearby Shopping Malls</p>
      </div>
      <div class="col-lg-2">
        <input type="text" name="txtNearbyShoppingMalls" value="" class="form-control">
      </div>
    </div>

    <div class="row text-left mb-3">
      <div class="col-lg-2">
        <p class="text-dark text-right FieldLabel">Nearby Restaurants</p>
      </div>
      <div class="col-lg-2">
        <input type="text" name="txtNearbyRestaurants" value="" class="form-control">
      </div>
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Distance From Airport (kms)</p>
      </div>
      <div class="col-lg-2">
        <input type="number" name="txtDistanceFromAirport" value="" class="form-control">
      </div>
      <div class="col-lg-2">
        <p class="text-dark text-right FieldLabel">Other Nearby Places</p>
      </div>
      <div class="col-lg-2">
        <input type="text" name="txtOtherNearbyPlaces" value="" class="form-control">
      </div>
    </div>

    <div class="row text-left mb-3">
      <div class="col-lg-2">
        <p class="text-dark FieldLabel">Nearby Public Transport Service</p>
      </div>
      <div class="col-lg-2">
        <input type="text" name="txtNearbyPublicTransportService" value="" class="form-control">
      </div>
    </div>

  </div>

</div>