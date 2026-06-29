<?php

$PropertyDetails = $this->getlist_model->getFieldsMultipleConditions('tbl_properties','*'," WHERE StationId = '$StationId'",2);
  
$PropertyTypeId = '';
if($PropertyDetails)
{
  $PropertyTypeId  = $PropertyDetails->PropertyTypeId;
}

$arrHomes    = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_types','TypeId,Title,PropertyIcon',"WHERE PropertyGroup = 'Home' ORDER BY SortOrder");

$arrLand =$this->getlist_model->getFieldsMultipleConditions('tbl_properties_types', 'TypeId, Title, PropertyIcon', "WHERE PropertyGroup='Land' ORDER BY SortOrder");

$arrCommercial    = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_types','TypeId,Title,PropertyIcon',"WHERE PropertyGroup = 'Commercial' ORDER BY SortOrder");



?>

<style>
  #FilterModal {
    margin-top: 50px;
  }

  #FilterModal .nav-tabs .nav-link{
    font-size: 20px;
    font-weight: 700;
    background-color: #fff ;
    color: #d5d8dc ;
    border:none;
    border-bottom:3px solid #d5d8dc;
  }
  #FilterModal .nav-tabs .nav-link.active {
    background-color: #fff;
    color: #1f509a;
    border-bottom: 3px solid #1f509a;
  }
  #FilterModal .nav-tabs .nav-link:hover {
    background-color: #fff;
    color: #1f509a;
    border-bottom: 3px solid #1f509a;
  }
  @media screen and (max-width:550px){
  .cust-modal-header{
    padding: 1rem 0rem !important;
  }
  .cust-modal-header ul li{
    padding-right: 0px !important;
    padding-left: 0px !important;
  }
}
</style>

<form method="POST" action="<?= base_url('Properties/filter_search'); ?>">

<!-- Modal -->
<div class="modal fade" id="FilterModal">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <!-- Adjust the max-width as needed -->
    <div class="modal-content" style="max-height: 700px; overflow: auto;">
      <div class="modal-header cust-modal-header border-bottom-0" style="position: fixed; z-index: 2; background: #ffff;">
        <ul class="w-100 d-flex justify-content-center mx-auto text-center nav nav-tabs border-bottom-0" id="myTab" role="tablist">
          <li class="px-5 nav-item w-50" role="presentation">
            <button class="px-5 nav-link" id="BuyBtnFilter" data-bs-toggle="tab" data-bs-target="#BuyContent" type="button" role="tab" aria-controls="BuyContent" aria-selected="true">Sale</button>
          </li>
          <li class="px-5 nav-item w-50" role="presentation">
            <button class="px-5 nav-link" id="RentBtnFilter" data-bs-toggle="tab" data-bs-target="#RentContent" type="button" role="tab" aria-controls="RentContent" aria-selected="false">Rent</button>
          </li>
        </ul>

        <input type="hidden" name="ListType">

        <script>
          document.getElementById("BuyBtnFilter").addEventListener("click", function () {
            document.querySelector("input[name='ListType']").value = "Sale";
          });

          document.getElementById("RentBtnFilter").addEventListener("click", function () {
            document.querySelector("input[name='ListType']").value = "Rent";
          });
        </script>


      </div>
      <div class="modal-body w-100 justify-content-center mx-auto" style="z-index: 1;">
        
        <div class="tab-content mt-4" id="myTabContent">
          
          <!-- buy tab content starts -->
          <div class="tab-pane fade" id="BuyContent" role="tabpanel" aria-labelledby="BuyBtnFilter">
            <div class="row mt-5 pt-5 text-start justify-content-center mx-auto">
              <h5 class="text-start">Property Types</h5>
              <div class="col-12">
                <?php
                  // -------- Home -----------//
                  $i = 0;
                  foreach ($arrHomes as $hKey => $hValue) {
                    $col = 'col-6';
                    $TypeId = $hValue->TypeId;
                    $Title = $hValue->Title;
                    if ($i % 2 == 0) {
                      echo '<div class="row text-start justify-content-center mx-auto">';
                    }
                    echo '<div class="' . $col . '">
                            <div class="d-flex align-items-center">
                              <input type="checkbox" name="propertyType[]" value="' . $TypeId . '" class="form-check-input">
                              <p class="text-dark my-3 ms-2">' . $Title . '</p>
                            </div>
                          </div>';
                    if ($i % 2 == 1) {
                      echo '</div>';
                    }
                    $i++;
                  }

                ?>
              </div>
            </div>
            
            <div class="row mt-4 text-start justify-content-center mx-auto">
              <h5 class="text-start">Price</h5>
              <div class="col-6">
                <input type="number" class="form-control" placeholder="Min" name="txtMinPrice">
              </div>
              <div class="col-6">
                <input type="number" class="form-control" placeholder="Max" name="txtMaxPrice">
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-6">
                <h5 class="text-start">Bedrooms</h5>
                <select class="form-select" name="txtBedrooms">
                  <option selected>select</option>
                  <option value="2">2</option>
                  <option value="5">5</option>
                  <option value="8">8</option>
                  <option value="10">10</option>
                  <option value="10">10+</option>
                </select>
              </div>
              <div class="col-6">
                <h5 class="text-start">Bathrooms</h5>
                <select class="form-select" name="txtBathrooms">
                  <option selected>select</option>
                  <option value="2">2</option>
                  <option value="5">5</option>
                  <option value="8">8</option>
                  <option value="10">10</option>
                  <option value="10">10+</option>
                </select>
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-6">
                <h5 class="text-start">Built in Date</h5>
                <input type="date" name="txtBuiltInYear" class="form-control">
              </div>
              <div class="col-6">
                <h5 class="text-start">Available from</h5>
                <input type="date" name="txtAvailableFrom" class="form-control">
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-12">
                <h5 class="text-start">Property Status</h5>
                <div class="d-flex">
                  <div class="form-check me-3">
                    <input class="form-check-input" type="checkbox" id="chkStatusOccupied" name="chkStatusOccupied">
                    <label class="form-check-label mx-1" for="chkStatusOccupied">Occupied</label>
                  </div>
                  <div class="form-check me-3">
                    <input class="form-check-input" type="checkbox" id="chkStatusRented" name="chkStatusRented">
                    <label class="form-check-label mx-1" for="chkStatusRented">Rented</label>
                  </div>
                  <div class="form-check me-3">
                    <input class="form-check-input" type="checkbox" id="chkStatusVaccant" name="chkStatusVaccant">
                    <label class="form-check-label mx-1" for="chkStatusVaccant">Vaccant</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-12">
                <h5 class="text-start">Property Title</h5>
                <input type="text" class="form-control" name="txtPropertyTitle">
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-12">
                <h5 class="text-start">Address</h5>
                <input class="form-control" type="text" name="txtAddress">
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-12">
                <h5 class="text-start">State</h5>
                <input class="form-control" type="text" name="txtState">
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-12">
                <h5 class="text-start">Suburb</h5>
                <input class="form-control" type="text" name="txtSuburb">
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-12">
                <h5 class="text-start">Covered Area (Sqft)</h5>
                <input class="form-control" type="number" name="txtCoveredArea">
              </div>
            </div>

            <div class="row text-start justify-content-center mx-auto">
              <h5 class="text-start mt-4">Main features</h5>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsDoubleGlazedWindows" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Double Glazed Windows</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsCentralAirConditioning" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Central Air Conditioning</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsCentralHeating" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Central Heating</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsWaste Disposal" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Waste Disposal</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsFurnished" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Furnished</p>
                </div>
              </div>
              <div class="col-6"></div>
            </div>

            <div class="row text-start justify-content-center mx-auto">
              <h5 class="text-start mt-4">Rooms features</h5>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsDrawingRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Drawing Room</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsDinningRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Dinning Room</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsStudyRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Study Room</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsPrayerRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Prayer Room</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsPowderRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Powder Room</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsGym" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Gym</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsSteamRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Steam Room</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsLounge" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Lounge</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsLaundryRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Laundry Room</p>
                </div>
              </div>
              <div class="col-6"></div>
            </div>

            <div class="row text-start justify-content-center mx-auto mt-4">
              <h5 class="text-start">Communication features</h5>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsInternetAccess" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Internet Access</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsCableTV" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Cable TV</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsIntercom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Intercom</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsConferenceRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Conference Room</p>
                </div>
              </div>
            </div>


            <div class="row text-start justify-content-center mx-auto mt-4">
              <h5 class="text-start">Community features</h5>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsLawn" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Lawn</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkSwimmingPool" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Swimming Pool</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsMedicalCenter" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Medical Center</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsDayCareCenter" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Day Care Center</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsKidsPlayArea" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Kids Play Area</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsBarbequeArea" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Barbeque Area</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsMosque" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Mosque</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsCommunityCentre" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Community Centre</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsSauna" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Sauna</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsJacuzzi" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Jacuzzi</p>
                </div>
              </div>
            </div>
            
          </div>
          <!-- buy tab content ends -->

          <!-- rent tab content starts -->
          <div class="tab-pane fade" id="RentContent" role="tabpanel" aria-labelledby="RentBtnFilter">

            <div class="row mt-5 pt-5 text-start justify-content-center mx-auto">
              <h5 class="text-start">Property Types</h5>
              <div class="col-12">
                <?php
                    // -------- Home -----------//
                    $i = 0;
                    foreach ($arrHomes as $hKey => $hValue) {
                    $col = 'col-6';
                    $TypeId = $hValue->TypeId;
                    $Title = $hValue->Title;
                    
                    // Corrected condition to ensure $Title is not one of the specified values
                    if ($Title != 'All Types' && $Title != 'House' && $Title != 'Townhouse' && $Title != 'Appartment' && $Title != 'Unit' && $Title != 'Villa') {
                        continue;
                    }
                    if ($i == 4) {
                      $col = 'col-12';
                    }
                    
                    if ($i % 2 == 0) {
                        echo '<div class="row text-start justify-content-center mx-auto">';
                    }
                    
                    echo '<div class="' . $col . '">
                            <div class="d-flex align-items-center text-start">
                                <input type="checkbox" name="propertyType[]" value="' . $TypeId . '" class="form-check-input">
                                <p class="text-dark text-start my-3 ms-2">' . $Title . '</p>
                            </div>
                          </div>';
                    
                    if ($i % 2 == 1) {
                        echo '</div>';
                    }
                    
                    $i++;
                  }

                ?>
              </div>
            </div>
            

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <h5 class="text-start">Price</h5>
              <div class="col-6">
                <input type="number" class="form-control" placeholder="Min" name="txtMinPrice">
              </div>
              <div class="col-6">
                <input type="number" class="form-control" placeholder="Max" name="txtMaxPrice">
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-6">
                <h5 class="text-start">Bedrooms</h5>
                <select class="form-select" aria-label="Default select example">
                  <option selected>2</option>
                  <option value="1">5</option>
                  <option value="2">8</option>
                  <option value="3">10</option>
                  <option value="3">10+</option>
                </select>
              </div>
              <div class="col-6">
                <h5 class="text-start">Bathrooms</h5>
                <select class="form-select" aria-label="Default select example">
                  <option selected>2</option>
                  <option value="1">5</option>
                  <option value="2">8</option>
                  <option value="3">10</option>
                  <option value="3">10+</option>
                </select>
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-6">
                <h5 class="text-start">Built in Date</h5>
                <input type="date" name="txtBuiltInYear" class="form-control">
              </div>
              <div class="col-6">
                <h5 class="text-start">Available from</h5>
                <input type="date" name="txtAvailableFrom" class="form-control">
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-12">
                <h5 class="text-start">Property Status</h5>
                <div class="d-flex">
                  <div class="form-check me-3">
                    <input class="form-check-input" type="checkbox" id="chkStatusOccupied" name="chkStatusOccupied">
                    <label class="form-check-label mx-1" for="chkStatusOccupied">Occupied</label>
                  </div>
                  <div class="form-check me-3">
                    <input class="form-check-input" type="checkbox" id="chkStatusRented" name="chkStatusRented">
                    <label class="form-check-label mx-1" for="chkStatusRented">Rented</label>
                  </div>
                  <div class="form-check me-3">
                    <input class="form-check-input" type="checkbox" id="chkStatusVaccant" name="chkStatusVaccant">
                    <label class="form-check-label mx-1" for="chkStatusVaccant">Vaccant</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-12">
                <h5 class="text-start">Property Title</h5>
                <input type="text" class="form-control" name="txtPropertyTitle">
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-12">
                <h5 class="text-start">Address</h5>
                <input class="form-control" type="text" name="txtAddress">
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-12">
                <h5 class="text-start">State</h5>
                <input class="form-control" type="text" name="txtState">
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-12">
                <h5 class="text-start">Suburb</h5>
                <input class="form-control" type="text" name="txtSuburb">
              </div>
            </div>

            <div class="row mt-4 text-start justify-content-center mx-auto">
              <div class="col-12">
                <h5 class="text-start">Covered Area</h5>
                <input class="form-control" type="number" name="txtCoveredArea">
              </div>
            </div>

            <div class="row text-start justify-content-center mx-auto">
              <h5 class="text-start mt-4">Main features</h5>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsDoubleGlazedWindows" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Double Glazed Windows</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsCentralAirConditioning" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Central Air Conditioning</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsCentralHeating" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Central Heating</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsWaste Disposal" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Waste Disposal</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsFurnished" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Furnished</p>
                </div>
              </div>
              <div class="col-6"></div>
            </div>

            <div class="row text-start justify-content-center mx-auto">
              <h5 class="text-start mt-4">Rooms features</h5>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsDrawingRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Drawing Room</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsDinningRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Dinning Room</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsStudyRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Study Room</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsPrayerRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Prayer Room</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsPowderRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Powder Room</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsGym" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Gym</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsSteamRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Steam Room</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsLounge" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Lounge</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsLaundryRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Laundry Room</p>
                </div>
              </div>
              <div class="col-6"></div>
            </div>

            <div class="row text-start justify-content-center mx-auto mt-4">
              <h5 class="text-start">Communication features</h5>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsInternetAccess" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Internet Access</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsCableTV" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Cable TV</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsIntercom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Intercom</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsConferenceRoom" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Conference Room</p>
                </div>
              </div>
            </div>


            <div class="row text-start justify-content-center mx-auto mt-4">
              <h5 class="text-start">Community features</h5>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsLawn" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Lawn</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkSwimmingPool" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Swimming Pool</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsMedicalCenter" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Medical Center</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsDayCareCenter" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Day Care Center</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsKidsPlayArea" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Kids Play Area</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsBarbequeArea" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Barbeque Area</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsMosque" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Mosque</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsCommunityCentre" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Community Centre</p>
                </div>
              </div>
            </div>
            <div class="row text-start justify-content-center mx-auto">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsSauna" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Sauna</p>
                </div>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <input type="checkbox" name="chkIsJacuzzi" value="1" class="form-check-input">
                  <p class="text-dark my-3 ms-2">Jacuzzi</p>
                </div>
              </div>
            </div>
            
          </div>
          <!-- rent tab content ends -->

        </div>
      </div>
      <div class="modal-footer cust-modal-footer w-100">
        <button type="button" class="btn btn-secondary z-3" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary z-3">Apply</button>
        <!-- <a target="_blank" href="<?= site_url('Properties/filter_search'); ?>" class="btn btn-primary z-3">Apply</a> -->
      </div>
    </div>
  </div>
</div>

</form>