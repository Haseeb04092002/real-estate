<?php
// echo "<br>StationId = ".$StationId;
$StationId = $StationId ?? '1';
$PropertyDetails = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', '*', " WHERE StationId = '$StationId'", 2);

$PropertyTypeId = '';
if ($PropertyDetails) {
  $PropertyTypeId = $PropertyDetails->PropertyTypeId;
}

$arrAllTypes = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_types', 'TypeId,Title,PropertyIcon', "ORDER BY SortOrder");
$arrAllFeatures = $this->getlist_model->getFieldsMultipleConditions('tbl_properties_features_lists', 'FeatureId, Title', "ORDER BY FeatureId ASC");



?>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true"
  style="z-index: 9999999;">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" style="z-index: 9999999;">
    <div class="modal-content" style="z-index: 9999999;">
      <!-- Modal Header -->
      <div class="modal-header cust-modal-header border-bottom-0 p-0">
        <ul class="nav nav-tabs w-100 text-center" id="myTab" role="tablist">
          <li class="nav-item flex-fill" role="presentation">
            <button class="nav-link active w-100" id="BuyBtnFilter" data-bs-toggle="tab" data-bs-target="#BuyContent"
              type="button" role="tab" aria-controls="BuyContent" aria-selected="true"> Sale </button>
          </li>
          <li class="nav-item flex-fill" role="presentation">
            <button class="nav-link w-100" id="RentBtnFilter" data-bs-toggle="tab" data-bs-target="#RentContent"
              type="button" role="tab" aria-controls="RentContent" aria-selected="false"> Rent </button>
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
                    <?php if (is_array($arrAllTypes)) {
                      foreach ($arrAllTypes as $type) { ?>
                        <div class="col">
                          <label class="d-flex align-items-center m-0 w-100">
                            <input type="checkbox" name="propertyType[]" value="<?= $type->TypeId ?>"
                              class="form-check-input me-2 mt-0"> <span class="text-truncate"
                              title="<?= htmlspecialchars($type->Title) ?>"><?= htmlspecialchars($type->Title) ?></span>
                          </label>
                        </div>
                      <?php }
                    } ?>
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
                    <?php if (is_array($arrAllFeatures)) {
                      foreach ($arrAllFeatures as $feature) { ?>
                        <div class="col">
                          <label class="d-flex align-items-center m-0 w-100">
                            <input type="checkbox" name="propertyFeature[]" value="<?= $feature->FeatureId ?>"
                              class="form-check-input me-2 mt-0"> <span class="text-truncate"
                              title="<?= htmlspecialchars($feature->Title) ?>"><?= htmlspecialchars($feature->Title) ?></span>
                          </label>
                        </div>
                      <?php }
                    } ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- Price -->
            <style>
              .price-card {
                background: #fff;
                border: 1px solid #e9ecef;
                border-radius: 15px;
                padding: 22px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
              }

              .price-card .form-control {
                height: 46px;
                border-radius: 10px;
                text-align: center;
                font-weight: 600;
              }

              .price-card .input-group-text {
                border-radius: 10px 0 0 10px;
                background: #f8f9fa;
                font-weight: 600;
              }

              .slider {
                position: relative;
                height: 6px;
                background: #dee2e6;
                border-radius: 50px;
                margin-top: 10px;
              }

              .slider .progress {
                position: absolute;
                height: 100%;
                left: 25%;
                right: 25%;
                border-radius: 50px;
                /* background: linear-gradient(90deg, #0d6efd, #17c1e8); */
                background-color: #1f509a;
              }

              .range-input {
                position: relative;
                margin-top: -6px;
              }

              .range-input input {
                position: absolute;
                width: 100%;
                height: 6px;
                background: none;
                pointer-events: none;
                appearance: none;
                -webkit-appearance: none;
              }

              .range-input input::-webkit-slider-thumb {
                appearance: none;
                pointer-events: auto;
                width: 20px;
                height: 20px;
                border-radius: 50%;
                border: 3px solid #fff;
                background: #0d6efd;
                box-shadow: 0 3px 10px rgba(13, 110, 253, .35);
                cursor: pointer;
              }

              .range-input input::-moz-range-thumb {
                pointer-events: auto;
                width: 20px;
                height: 20px;
                border: none;
                border-radius: 50%;
                background: #0d6efd;
                cursor: pointer;
              }

              @media(max-width:576px) {

                .price-card {
                  padding: 18px;
                }

              }
            </style>
            <div class="mt-4 price-wrapper">
              <h6 class="fw-bold mb-3">
                <i class="bi bi-cash-stack me-2 text-primary"></i>Price Range
              </h6>

              <div class="">

                <div class="row g-3 mb-4 text-center">
                  <div class="col-6 border-end">
                    <div class="d-flex align-items-center text-start justify-content-start">
                      <label class="form-label small text-muted mb-1">Minimum</label>
                      <h5 class="fw-bold text-primary mb-0">$<span class="price-min-label">0</span></h5>
                    </div>
                    <input type="hidden" class="input-min" name="txtMinPrice" value="0">
                  </div>

                  <div class="col-6">
                    <div class="d-flex align-items-center text-start justify-content-start">
                      <label class="form-label small text-muted mb-1">Maximum</label>
                      <h5 class="fw-bold text-primary mb-0">$<span class="price-max-label">100000</span></h5>
                    </div>
                    <input type="hidden" class="input-max" name="txtMaxPrice" value="100000">
                  </div>
                </div>

                <div class="slider">
                  <div class="progress"></div>
                </div>

                <div class="range-input border-none">
                  <input type="range" class="border-none range-min" min="0" max="100000" value="0" step="1000">
                  <input type="range" class="border-none range-max" min="0" max="100000" value="100000" step="1000">
                </div>

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
                  <input class="form-check-input me-2" type="checkbox" id="chkStatusOccupied" name="chkStatusOccupied">
                  Occupied </label>
                <label class="form-check d-flex align-items-center">
                  <input class="form-check-input me-2" type="checkbox" id="chkStatusRented" name="chkStatusRented">
                  Rented </label>
                <label class="form-check d-flex align-items-center">
                  <input class="form-check-input me-2" type="checkbox" id="chkStatusVaccant" name="chkStatusVaccant">
                  Vacant </label>
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
                    <?php if (is_array($arrAllTypes)) {
                      foreach ($arrAllTypes as $type) { ?>
                        <div class="col">
                          <label class="d-flex align-items-center m-0 w-100">
                            <input type="checkbox" name="propertyType[]" value="<?= $type->TypeId ?>"
                              class="form-check-input me-2 mt-0"> <span class="text-truncate"
                              title="<?= htmlspecialchars($type->Title) ?>"><?= htmlspecialchars($type->Title) ?></span>
                          </label>
                        </div>
                      <?php }
                    } ?>
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
                    <?php if (is_array($arrAllFeatures)) {
                      foreach ($arrAllFeatures as $feature) { ?>
                        <div class="col">
                          <label class="d-flex align-items-center m-0 w-100">
                            <input type="checkbox" name="propertyFeature[]" value="<?= $feature->FeatureId ?>"
                              class="form-check-input me-2 mt-0"> <span class="text-truncate"
                              title="<?= htmlspecialchars($feature->Title) ?>"><?= htmlspecialchars($feature->Title) ?></span>
                          </label>
                        </div>
                      <?php }
                    } ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- Price -->
            <div class="mt-4 price-wrapper">
              <h6 class="fw-bold mb-3">
                <i class="bi bi-cash-stack me-2 text-primary"></i>Price Range
              </h6>

              <div class="price-card">

                <div class="row g-3 mb-4 text-center">
                  <div class="col-6 border-end">
                    <label class="form-label small text-muted mb-1">Minimum</label>
                    <h5 class="fw-bold text-primary mb-0">$<span class="price-min-label">0</span></h5>
                    <input type="hidden" class="input-min" name="txtMinPrice" value="0">
                  </div>

                  <div class="col-6">
                    <label class="form-label small text-muted mb-1">Maximum</label>
                    <h5 class="fw-bold text-primary mb-0">$<span class="price-max-label">100000</span></h5>
                    <input type="hidden" class="input-max" name="txtMaxPrice" value="100000">
                  </div>
                </div>

                <div class="slider">
                  <div class="progress"></div>
                </div>

                <div class="range-input">
                  <input type="range" class="range-min" min="0" max="100000" value="0" step="1000">
                  <input type="range" class="range-max" min="0" max="100000" value="100000" step="1000">
                </div>

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
                  <input class="form-check-input me-2" type="checkbox" id="chkStatusOccupied" name="chkStatusOccupied">
                  Occupied </label>
                <label class="form-check d-flex align-items-center">
                  <input class="form-check-input me-2" type="checkbox" id="chkStatusRented" name="chkStatusRented">
                  Rented </label>
                <label class="form-check d-flex align-items-center">
                  <input class="form-check-input me-2" type="checkbox" id="chkStatusVaccant" name="chkStatusVaccant">
                  Vacant </label>
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
  document.getElementById("BuyBtnFilter").addEventListener("click", function () {
    document.querySelector("input[name='ListType']").value = "Sale";
  });
  document.getElementById("RentBtnFilter").addEventListener("click", function () {
    document.querySelector("input[name='ListType']").value = "Rent";
  });

  document.querySelectorAll('.price-wrapper').forEach(wrapper => {
    const rangeInput = wrapper.querySelectorAll(".range-input input");
    const priceInput = wrapper.querySelectorAll("input[type='hidden'].input-min, input[type='hidden'].input-max");
    const priceLabelMin = wrapper.querySelector(".price-min-label");
    const priceLabelMax = wrapper.querySelector(".price-max-label");
    const range = wrapper.querySelector(".slider .progress");
    let priceGap = 1000;

    // Initialize UI on load
    if (rangeInput.length === 2 && priceInput.length === 2) {
      let minVal = parseInt(rangeInput[0].value);
      let maxVal = parseInt(rangeInput[1].value);
      range.style.left = (minVal / parseInt(rangeInput[0].max)) * 100 + "%";
      range.style.right = 100 - (maxVal / parseInt(rangeInput[1].max)) * 100 + "%";
      if (priceLabelMin) priceLabelMin.innerText = minVal;
      if (priceLabelMax) priceLabelMax.innerText = maxVal;
    }

    rangeInput.forEach((input) => {
      input.addEventListener("input", (e) => {
        let minVal = parseInt(rangeInput[0].value),
          maxVal = parseInt(rangeInput[1].value);

        if (maxVal - minVal < priceGap) {
          if (e.target.className.includes("range-min")) {
            rangeInput[0].value = maxVal - priceGap;
          } else {
            rangeInput[1].value = minVal + priceGap;
          }
        } else {
          if (priceInput.length === 2) {
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
          }
          if (priceLabelMin && priceLabelMax) {
            priceLabelMin.innerText = minVal;
            priceLabelMax.innerText = maxVal;
          }
          range.style.left = (minVal / parseInt(rangeInput[0].max)) * 100 + "%";
          range.style.right = 100 - (maxVal / parseInt(rangeInput[1].max)) * 100 + "%";
        }
      });
    });
  });
</script>
<!-- Map Modal -->
<div class="modal fade" id="mapModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content p-4">
      <h4>Select Location</h4>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3313.1031492957684!2d73.0479!3d33.6844!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dfbf5d3e48ad8b%3A0x3b2b610778f7eb9e!2sIslamabad%2C%20Pakistan!5e0!3m2!1sen!2s!4v1625258123456!5m2!1sen!2s"
        width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      <div class="text-end mt-3">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>