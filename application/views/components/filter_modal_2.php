<?php
// echo "<br>StationId = ".$StationId;
$StationId = $StationId??'1';
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

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true" style="z-index: 9999999;">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" style="z-index: 9999999;">
    <div class="modal-content" style="z-index: 9999999;">
      <!-- Modal Header -->
      <div class="modal-header cust-modal-header border-bottom-0 p-0">
        <ul class="nav nav-tabs w-100 text-center" id="myTab" role="tablist">
          <li class="nav-item flex-fill" role="presentation">
            <button class="nav-link active w-100" id="BuyBtnFilter" data-bs-toggle="tab" data-bs-target="#BuyContent" type="button" role="tab" aria-controls="BuyContent" aria-selected="true"> Sale </button>
          </li>
          <li class="nav-item flex-fill" role="presentation">
            <button class="nav-link w-100" id="RentBtnFilter" data-bs-toggle="tab" data-bs-target="#RentContent" type="button" role="tab" aria-controls="RentContent" aria-selected="false"> Rent </button>
          </li>
        </ul>
        <input type="hidden" name="ListType">
      </div>
      <!-- Modal Body -->
      <div class="modal-body w-100 justify-content-center mx-auto">
        <div class="tab-content p-4" id="myTabContent">
          <!-- Buy Tab Content -->
          <div class="tab-pane fade active show" id="BuyContent" role="tabpanel" aria-labelledby="BuyBtnFilter">
            <!-- Property Types -->
            <div class="text-start">
              <h6 class="fw-bold mb-2">Property Types</h6>
              <div class="d-flex flex-wrap gap-4">
                <!-- <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="1" class="form-check-input me-2"> All Types </label> -->
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="10" class="form-check-input me-2"> Villa </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="29" class="form-check-input me-2"> Unit </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="6" class="form-check-input me-2"> Townhouse </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="4" class="form-check-input me-2"> House </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="9" class="form-check-input me-2"> Rural </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="7" class="form-check-input me-2"> Acreage </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="11" class="form-check-input me-2"> Block Of Units </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="3" class="form-check-input me-2"> Guest House </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="8" class="form-check-input me-2"> Apartment </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="2" class="form-check-input me-2"> Retirement Living </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="5" class="form-check-input me-2"> Land </label>
              </div>
            </div>
            <!-- Price -->
            <div class="mt-4 text-start">
              <h6 class="fw-bold mb-2">Price</h6>
              <div class="d-flex gap-3">
                <input type="number" class="form-control" placeholder="Min" name="txtMinPrice">
                <input type="number" class="form-control" placeholder="Max" name="txtMaxPrice">
              </div>
            </div>
            <!-- Bedrooms & Bathrooms -->
            <div class="mt-4 d-flex gap-3">
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Bedrooms</h6>
                <select class="form-select" name="txtBedrooms">
                  <option selected="">Select</option>
                  <option value="2">2</option>
                  <option value="5">5</option>
                  <option value="8">8</option>
                  <option value="10">10</option>
                  <option value="10+">10+</option>
                </select>
              </div>
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Bathrooms</h6>
                <select class="form-select" name="txtBathrooms">
                  <option selected="">Select</option>
                  <option value="2">2</option>
                  <option value="5">5</option>
                  <option value="8">8</option>
                  <option value="10">10</option>
                  <option value="10+">10+</option>
                </select>
              </div>
            </div>
            <!-- Built-in & Available From -->
            <div class="mt-4 d-flex gap-3">
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Built in Date</h6>
                <input type="date" name="txtBuiltInYear" class="form-control">
              </div>
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Available from</h6>
                <input type="date" name="txtAvailableFrom" class="form-control">
              </div>
            </div>
            <!-- Property Status -->
            <div class="mt-4 text-start">
              <h6 class="fw-bold mb-2">Property Status</h6>
              <div class="d-flex flex-wrap gap-4">
                <label class="form-check d-flex align-items-center">
                  <input class="form-check-input me-2" type="checkbox" id="chkStatusOccupied" name="chkStatusOccupied"> Occupied </label>
                <label class="form-check d-flex align-items-center">
                  <input class="form-check-input me-2" type="checkbox" id="chkStatusRented" name="chkStatusRented"> Rented </label>
                <label class="form-check d-flex align-items-center">
                  <input class="form-check-input me-2" type="checkbox" id="chkStatusVaccant" name="chkStatusVaccant"> Vacant </label>
              </div>
            </div>
            <!-- Property Title -->
            <div class="mt-4 text-start">
              <h6 class="fw-bold mb-2">Property Title</h6>
              <input type="text" class="form-control" name="txtPropertyTitle">
            </div>
            <!-- Address -->
            <div class="mt-4 text-start">
              <h6 class="fw-bold mb-2">Address</h6>
              <input type="text" class="form-control" name="txtAddress">
            </div>
            <!-- State -->
            <div class="mt-4 text-start d-flex gap-3">
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">State</h6>
                <input type="text" class="form-control" name="txtState">
              </div>
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Suburb</h6>
                <input type="text" class="form-control" name="txtSuburb">
              </div>
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Covered Area (Sqft)</h6>
                <input type="number" class="form-control" name="txtCoveredArea">
              </div>
            </div>
            
            <!-- More features sections can follow here... -->
          </div>
          <!-- End Buy Tab -->

          <div class="tab-pane fade" id="RentContent" role="tabpanel" aria-labelledby="RentBtnFilter">
            <!-- Property Types -->
            <div class="text-start">
              <h6 class="fw-bold mb-2">Property Types</h6>
              <div class="d-flex flex-wrap gap-4">
                <!-- <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="1" class="form-check-input me-2"> All Types </label> -->
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="10" class="form-check-input me-2"> Villa </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="29" class="form-check-input me-2"> Unit </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="6" class="form-check-input me-2"> Townhouse </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="4" class="form-check-input me-2"> House </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="9" class="form-check-input me-2"> Rural </label>
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="propertyType[]" value="7" class="form-check-input me-2"> Acreage </label>
              </div>
            </div>
            <!-- Price -->
            <div class="mt-4 text-start">
              <h6 class="fw-bold mb-2">Price</h6>
              <div class="d-flex gap-3">
                <input type="number" class="form-control" placeholder="Min" name="txtMinPrice">
                <input type="number" class="form-control" placeholder="Max" name="txtMaxPrice">
              </div>
            </div>
            <!-- Bedrooms & Bathrooms -->
            <div class="mt-4 d-flex gap-3">
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Bedrooms</h6>
                <select class="form-select" name="txtBedrooms">
                  <option selected="">Select</option>
                  <option value="2">2</option>
                  <option value="5">5</option>
                  <option value="8">8</option>
                  <option value="10">10</option>
                  <option value="10+">10+</option>
                </select>
              </div>
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Bathrooms</h6>
                <select class="form-select" name="txtBathrooms">
                  <option selected="">Select</option>
                  <option value="2">2</option>
                  <option value="5">5</option>
                  <option value="8">8</option>
                  <option value="10">10</option>
                  <option value="10+">10+</option>
                </select>
              </div>
            </div>
            <!-- Built-in & Available From -->
            <div class="mt-4 d-flex gap-3">
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Built in Date</h6>
                <input type="date" name="txtBuiltInYear" class="form-control">
              </div>
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Available from</h6>
                <input type="date" name="txtAvailableFrom" class="form-control">
              </div>
            </div>
            <!-- Property Status -->
            <div class="mt-4 text-start">
              <h6 class="fw-bold mb-2">Property Status</h6>
              <div class="d-flex flex-wrap gap-4">
                <label class="form-check d-flex align-items-center">
                  <input class="form-check-input me-2" type="checkbox" id="chkStatusOccupied" name="chkStatusOccupied"> Occupied </label>
                <label class="form-check d-flex align-items-center">
                  <input class="form-check-input me-2" type="checkbox" id="chkStatusRented" name="chkStatusRented"> Rented </label>
                <label class="form-check d-flex align-items-center">
                  <input class="form-check-input me-2" type="checkbox" id="chkStatusVaccant" name="chkStatusVaccant"> Vacant </label>
              </div>
            </div>
            <!-- Property Title -->
            <div class="mt-4 text-start">
              <h6 class="fw-bold mb-2">Property Title</h6>
              <input type="text" class="form-control" name="txtPropertyTitle">
            </div>
            <!-- Address -->
            <div class="mt-4 text-start">
              <h6 class="fw-bold mb-2">Address</h6>
              <input type="text" class="form-control" name="txtAddress">
            </div>
            <!-- State -->
            <div class="mt-4 text-start d-flex gap-3">
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">State</h6>
                <input type="text" class="form-control" name="txtState">
              </div>
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Suburb</h6>
                <input type="text" class="form-control" name="txtSuburb">
              </div>
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Covered Area (Sqft)</h6>
                <input type="number" class="form-control" name="txtCoveredArea">
              </div>
            </div>
            
          </div>
          
        </div>
      </div>
      <!-- Modal Footer -->
      <div class="modal-footer d-flex justify-content-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="applyFilters">Apply</button>
      </div>
    </div>
  </div>
</div>
<script>
  document.getElementById("BuyBtnFilter").addEventListener("click", function() {
    document.querySelector("input[name='ListType']").value = "Sale";
  });
  document.getElementById("RentBtnFilter").addEventListener("click", function() {
    document.querySelector("input[name='ListType']").value = "Rent";
  });
</script>
<!-- Map Modal -->
<div class="modal fade" id="mapModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <h4>Select Location</h4>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3313.1031492957684!2d73.0479!3d33.6844!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dfbf5d3e48ad8b%3A0x3b2b610778f7eb9e!2sIslamabad%2C%20Pakistan!5e0!3m2!1sen!2s!4v1625258123456!5m2!1sen!2s" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      <div class="text-end mt-3">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>