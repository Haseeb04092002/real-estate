<?php
defined('BASEPATH') or exit('No direct script access allowed');
$documents = $this->getlist_model->getFieldsMultipleConditions('tbl_documents', '*', "WHERE DocumentId > 1", 2);
// $clients = $this->getlist_model->getFieldsMultipleConditions('tbl_clients', '*', "WHERE ClientId > 1", 2);
// echo "<pre>";
// print_r($documents);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php $this->load->view('components/header_meta'); ?>
    <?php $this->load->view('components/css_links'); ?>

</head>

<body>

    <?php $this->load->view('components/header', ['ListingPages' => 'no']); ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-building me-2"></i>
                Real Estate Verification
            </a>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-file-earmark-text-fill me-2"></i>
                            <h4 class="mb-0 text-light">User Authorization — Documents Upload</h4>
                        </div>
                        <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#infoModal">
                            <i class="bi bi-info-circle"></i> Why Required?
                        </button>
                    </div>
                    <!-- Info Modal -->
                    <div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title"><i class="bi bi-info-circle-fill me-2"></i>Why We Need Your Authorization</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    To maintain trust and transparency in the real estate market, we require users to upload valid identification and authorization documents before posting property ads. This process helps:
                                    <ul class="mt-2">
                                        <li> Verify property ownership or authorized representation</li>
                                        <li> Prevent fraudulent or misleading listings</li>
                                        <li> Ensure secure and trusted communication between buyers and sellers</li>
                                    </ul>
                                    Your information is kept secure and used only for verification purposes.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">

                        <?php echo form_open_multipart('Properties/ImageUpload/Identity/', ' id="frmDocIdentity" name="frmDocIdentity" class="form-horizontal" data-parsley-validate role="form"'); ?>
                            <div class="row g-4">

                                <h5 class="text-primary mt-4"><i class="bi bi-person-badge"></i> Identity Information</h5>

                                <div class="col-md-6">
                                    <label class="form-label">Date of Birth (DOB)</label>
                                    <input type="date" name="txtDOB" class="form-control" required data-parsley-required="true">
                                </div>
                                
                                <hr>
                                <h5 class="text-primary mt-4"><i class="bi bi-credit-card-2-front"></i> License Details</h5>

                                <div class="col-md-6">
                                    <label class="form-label">License Number</label>
                                    <input type="text" name="txtLicenseNumber" class="form-control" required data-parsley-required="true">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">License Expiry Date</label>
                                    <input type="date" name="txtLicenseExpiryDate" class="form-control" required data-parsley-required="true">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">License Front – Upload</label>
                                    <input class="form-control" id="my-file-selector" multiple="" type="file" name="images[]" accept="image/*,.pdf,.doc,.docx,.ppt.,.pps,.pptx,.ods,.xlr,.xls,.xlsx,.rtf" size="3000000" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">License Back – Upload</label>
                                    <input class="form-control" id="my-file-selector" multiple="" type="file" name="images[]" accept="image/*,.pdf,.doc,.docx,.ppt.,.pps,.pptx,.ods,.xlr,.xls,.xlsx,.rtf" size="3000000" required>
                                </div>

                                <hr>
                                <h5 class="text-primary mt-4"><i class="bi bi-credit-card"></i> ID Card Information</h5>

                                <div class="col-md-12">
                                    <label class="form-label">Card Number</label>
                                    <input type="text" name="txtCardNumber" class="form-control" required data-parsley-required="true">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Card Issue Date</label>
                                    <input type="date" name="txtCardIssueDate" class="form-control" required data-parsley-required="true">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Card Expiry Date</label>
                                    <input type="date" name="txtCardExpiryDate" class="form-control" required data-parsley-required="true">
                                </div>
                            </div>

                        </form>

                        <?php echo form_open_multipart('Properties/ImageUpload/Passport/', ' id="frmDocPassport" name="frmDocPassport" class="form-horizontal" data-parsley-validate role="form"'); ?>
                            <div class="row g-4">

                                <hr>
                                <h5 class="text-primary mt-4"><i class="bi bi-passport"></i> Passport (Optional)</h5>

                                <div class="col-md-6">
                                    <label class="form-label">Passport Number</label>
                                    <input type="text" name="txtPassportNumber" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Passport – Upload</label>
                                    <input class="form-control" name="imgPassport" type="file">
                                </div>
                            </div>
                        </form>

                        <?php echo form_open_multipart('Properties/ImageUpload/Address/', ' id="frmDocAddress" name="frmDocAddress" class="form-horizontal" data-parsley-validate role="form"'); ?>
                            <div class="row g-4">
                                <hr>
                                <h5 class="text-primary mt-4"><i class="bi bi-geo-alt"></i> Address & Authorization</h5>

                                <div class="col-12">
                                    <label class="form-label">Residential Address</label>
                                    <input type="text" class="form-control" id="txtResidentialAddress" required data-parsley-required="true">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Proof of Address <span class="fw-normal text-muted">(Utility Bill, Property Documents ...)</span></label>
                                    <input class="form-control" type="file" name="fileProofOfAddress" required data-parsley-required="true">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Profile Photo</label>
                                    <input class="form-control" type="file" name="imgProfilePhoto" required data-parsley-required="true">
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="consent" required data-parsley-required="true">
                                        <label class="form-check-label ps-2 pt-1" for="consent">
                                            I confirm all uploaded documents are authentic and authorize verification.
                                        </label>
                                        <div class="invalid-feedback">You must give consent before submitting.</div>
                                    </div>
                                </div>
                            </div>

                        </form>

                        <div class="col-12 text-end mt-3">
                            <button class="btn btn-outline-secondary me-2" type="reset">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </button>
                            <button type="button" class="btn btn-primary" id="btnSubmit">
                                <i class="bi bi-cloud-upload"></i> Submit
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    $this->load->view('components/footer');
    $this->load->view('components/js_links');
    ?>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv1FrfWK8d_Z28pT_XtiZW02msCfrC2Rs&libraries=places&callback=initAutocomplete" async defer></script>

    <script type="text/javascript">
        window.Parsley.addValidator('fileextension', {
            validateString: function(value, requirement, parsleyInstance) {
                var file = parsleyInstance.$element[0].files[0];
                if (!file) return true;

                var allowed = requirement.split(',');
                var extension = file.name.split('.').pop().toLowerCase();

                return allowed.includes(extension);
            },
            requirementType: 'string',
            messages: {
                en: 'Invalid file type.'
            }
        });


        $(document).on('click', '#btnSubmit', function(e) {
            e.preventDefault();

            var IsProcessed = 0;
            if (!$('#frmDocIdentity').parsley().validate()) 
            {
                console.log("Form 1 Validation Failed");
                return false;
            }

            $.ajax({
                  url: "<?= site_url('Properties/ImageUpload/Identity') ?>",
                  type: "POST",
                  dataType: "json",
                  success: function(response) {
                      if (response.status === true) 
                      {
                          IsProcessed = 1;
                      } 
                  }
            });
            
            $.ajax({
                  url: "<?= site_url('Properties/ImageUpload/Passport') ?>",
                  type: "POST",
                  dataType: "json",
                  success: function(response) {
                      if (response.status === true) 
                      {
                          IsProcessed = 1;
                      } 
                  }
            });

            $.ajax({
                  url: "<?= site_url('Properties/ImageUpload/Address') ?>",
                  type: "POST",
                  dataType: "json",
                  success: function(response) {
                      if (response.status === true) 
                      {
                          IsProcessed = 1;
                      } 
                  }
            });
        });


        function initAutocomplete() {
            const input = document.getElementById('txtResidentialAddress');
            const autocomplete = new google.maps.places.Autocomplete(input, {
                componentRestrictions: {
                    country: "au"
                }, // restrict to Australia
                fields: ["address_components", "formatted_address", "geometry"]
            });

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                if (!place.geometry) {
                    customAlert('Warning', "Please select a valid address from the list.", 'warning');
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

                console.log("Full Address:", place.formatted_address);
                console.log("Latitude:", lat);
                console.log("Longitude:", lng);
                console.log("State:", document.getElementById("txtState").value);
                console.log("Suburb:", document.getElementById("txtSuburb").value);
                console.log("Street:", document.getElementById("txtStreetName").value);
                console.log("Street Number:", document.getElementById("txtStreetNumber").value);
                console.log("Postal Code:", document.getElementById("txtPostalCode").value);
                console.log("Unit Number:", document.getElementById("txtUnitNumber").value);
            });
        }
    </script>

</body>

</html>