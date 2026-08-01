<?php
// echo "<br>StationId = ".$StationId;
$StationId = $StationId??'1';
$PropertyDetails = $this->getlist_model->getFieldsMultipleConditions('tbl_properties','*'," WHERE StationId = '$StationId'",2);
  
$PropertyTypeId = '';
if($PropertyDetails)
{
  $PropertyTypeId  = $PropertyDetails->PropertyTypeId;
}

$arrAllTypes = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_types','TypeId,Title,PropertyIcon',"ORDER BY SortOrder");
$arrAllFeatures = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_features_lists', 'FeatureId, Title', "ORDER BY FeatureId ASC");



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
            <div class="card bg-light border-0 mb-4">
              <div class="card-body">
                <div class="text-start">
                  <h6 class="fw-bold mb-3">Property Types</h6>
                  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                    <?php if(is_array($arrAllTypes)) { foreach($arrAllTypes as $type) { ?>
                    <div class="col">
                      <label class="d-flex align-items-center m-0 w-100">
                        <input type="checkbox" name="propertyType[]" value="<?= $type->TypeId ?>" class="form-check-input me-2 mt-0"> <span class="text-truncate" title="<?= htmlspecialchars($type->Title) ?>"><?= htmlspecialchars($type->Title) ?></span>
                      </label>
                    </div>
                    <?php } } ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- Property Features -->
            <div class="card bg-light border-0 mb-2">
              <div class="card-body">
                <div class="text-start">
                  <h6 class="fw-bold mb-3">Property Features</h6>
                  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                    <?php if(is_array($arrAllFeatures)) { foreach($arrAllFeatures as $feature) { ?>
                    <div class="col">
                      <label class="d-flex align-items-center m-0 w-100">
                        <input type="checkbox" name="propertyFeature[]" value="<?= $feature->FeatureId ?>" class="form-check-input me-2 mt-0"> <span class="text-truncate" title="<?= htmlspecialchars($feature->Title) ?>"><?= htmlspecialchars($feature->Title) ?></span>
                      </label>
                    </div>
                    <?php } } ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- Price -->
            <div class="mt-4 text-start">
              <style>
                .dual-slider-container {
                  position: relative;
                  height: 40px;
                  display: flex;
                  align-items: center;
                }
                .dual-slider-container input[type=range] {
                  position: absolute;
                  width: 100%;
                  -webkit-appearance: none;
                  background: transparent;
                  pointer-events: none;
                  z-index: 2;
                }
                .dual-slider-container .slider-track {
                  position: absolute;
                  width: 100%;
                  height: 6px;
                  background: #e9ecef;
                  border-radius: 3px;
                  z-index: 1;
                }
                .dual-slider-container input[type=range]::-webkit-slider-thumb {
                  -webkit-appearance: none;
                  pointer-events: auto;
                  width: 20px;
                  height: 20px;
                  background: #0d6efd;
                  border-radius: 50%;
                  cursor: pointer;
                  margin-top: 0px;
                  box-shadow: 0 1px 3px rgba(0,0,0,0.3);
                }
                .dual-slider-container input[type=range]::-moz-range-thumb {
                  pointer-events: auto;
                  width: 20px;
                  height: 20px;
                  background: #0d6efd;
                  border-radius: 50%;
                  cursor: pointer;
                  border: none;
                  box-shadow: 0 1px 3px rgba(0,0,0,0.3);
                }
              </style>
              <h6 class="fw-bold mb-2">Price: <span class="price-display-buy text-primary">AUS 0 - AUS 100,000</span></h6>
              <div class="dual-slider-container">
                <div class="slider-track"></div>
                <input type="range" class="form-range" name="txtMinPrice" min="0" max="100000" step="1000" value="0" oninput="updatePriceDisplay(this, 'min', 'price-display-buy')">
                <input type="range" class="form-range" name="txtMaxPrice" min="0" max="100000" step="1000" value="100000" oninput="updatePriceDisplay(this, 'max', 'price-display-buy')">
              </div>
            </div>
            <!-- Bedrooms & Bathrooms -->
            <div class="mt-4 d-flex gap-3">
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Bedrooms</h6>
                <input type="number" class="form-control" name="txtBedrooms" placeholder="e.g. 2" min="0">
              </div>
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Bathrooms</h6>
                <input type="number" class="form-control" name="txtBathrooms" placeholder="e.g. 2" min="0">
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
            <div class="card bg-light border-0 mb-4">
              <div class="card-body">
                <div class="text-start">
                  <h6 class="fw-bold mb-3">Property Types</h6>
                  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                    <?php if(is_array($arrAllTypes)) { foreach($arrAllTypes as $type) { ?>
                    <div class="col">
                      <label class="d-flex align-items-center m-0 w-100">
                        <input type="checkbox" name="propertyType[]" value="<?= $type->TypeId ?>" class="form-check-input me-2 mt-0"> <span class="text-truncate" title="<?= htmlspecialchars($type->Title) ?>"><?= htmlspecialchars($type->Title) ?></span>
                      </label>
                    </div>
                    <?php } } ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- Property Features -->
            <div class="card bg-light border-0 mb-2">
              <div class="card-body">
                <div class="text-start">
                  <h6 class="fw-bold mb-3">Property Features</h6>
                  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                    <?php if(is_array($arrAllFeatures)) { foreach($arrAllFeatures as $feature) { ?>
                    <div class="col">
                      <label class="d-flex align-items-center m-0 w-100">
                        <input type="checkbox" name="propertyFeature[]" value="<?= $feature->FeatureId ?>" class="form-check-input me-2 mt-0"> <span class="text-truncate" title="<?= htmlspecialchars($feature->Title) ?>"><?= htmlspecialchars($feature->Title) ?></span>
                      </label>
                    </div>
                    <?php } } ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- Price -->
            <div class="mt-4 text-start">
              <h6 class="fw-bold mb-2">Price: <span class="price-display-rent text-primary">AUS 0 - AUS 100,000</span></h6>
              <div class="dual-slider-container">
                <div class="slider-track"></div>
                <input type="range" class="form-range" name="txtMinPrice" min="0" max="100000" step="1000" value="0" oninput="updatePriceDisplay(this, 'min', 'price-display-rent')">
                <input type="range" class="form-range" name="txtMaxPrice" min="0" max="100000" step="1000" value="100000" oninput="updatePriceDisplay(this, 'max', 'price-display-rent')">
              </div>
            </div>
            <!-- Bedrooms & Bathrooms -->
            <div class="mt-4 d-flex gap-3">
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Bedrooms</h6>
                <input type="number" class="form-control" name="txtBedrooms" placeholder="e.g. 2" min="0">
              </div>
              <div class="flex-fill">
                <h6 class="fw-bold mb-2">Bathrooms</h6>
                <input type="number" class="form-control" name="txtBathrooms" placeholder="e.g. 2" min="0">
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

  function updatePriceDisplay(el, type, displayClass) {
      let container = el.parentElement;
      let minEl = container.querySelector('input[name="txtMinPrice"]');
      let maxEl = container.querySelector('input[name="txtMaxPrice"]');
      let minVal = parseInt(minEl.value);
      let maxVal = parseInt(maxEl.value);

      if (type === 'min' && minVal > maxVal) {
          minEl.value = maxVal;
          minVal = maxVal;
      }
      if (type === 'max' && maxVal < minVal) {
          maxEl.value = minVal;
          maxVal = minVal;
      }

      let display = container.parentElement.querySelector('.' + displayClass);
      if (display) {
          display.innerHTML = `AUS ${minVal.toLocaleString()} - AUS ${maxVal.toLocaleString()}`;
      }
  }
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