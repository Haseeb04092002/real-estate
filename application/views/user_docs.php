<?php
defined('BASEPATH') or exit('No direct script access allowed');
$documents = $this->getlist_model->getFieldsMultipleConditions('tbl_client_documents', '*', "WHERE DocumentId > 1", 2);
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

                        <?php echo form_open_multipart('Properties/submit_user_docs/', ' id="frmDynamicDocs" name="frmDynamicDocs" class="form-horizontal" data-parsley-validate role="form"'); ?>
                            <div class="row g-4">
                                <h5 class="text-primary mt-4"><i class="bi bi-file-earmark-text"></i> Required Verification Documents</h5>

                                <?php if (!empty($verification_rules)): ?>
                                    <?php foreach($verification_rules as $rule): ?>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold"><?= htmlspecialchars($rule->DocumentTitle) ?>
                                                <?php if(!$rule->IsMandatory): ?> <span class="text-muted fw-normal">(Optional)</span> <?php else: ?> <span class="text-danger">*</span> <?php endif; ?>
                                            </label>
                                            
                                            <?php 
                                            // Check if already uploaded
                                            $uploaded_val = '';
                                            $uploaded_file_path = '';
                                            $uploaded_status = '';
                                            $is_file_doc = false;
                                            $is_img = false;
                                            if (!empty($uploaded_docs)) {
                                                foreach ($uploaded_docs as $udoc) {
                                                    if ($udoc->Remarks == $rule->DocumentTitle) {
                                                        $uploaded_val = $udoc->FileName;
                                                        $uploaded_status = $udoc->VerificationStatus;
                                                        $ext = pathinfo($udoc->FileName, PATHINFO_EXTENSION);
                                                        $is_file_doc = !empty($ext) && in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'rtf', 'txt']);
                                                        if ($is_file_doc) {
                                                            $is_img = in_array(strtolower($ext), ['jpg','jpeg','png','gif']);
                                                            $UserId = $this->session->userdata('user_id');
                                                            $uploaded_file_path = base_url('uploads/Client/'.$UserId.'/images/'.$udoc->FileName);
                                                        }
                                                        break;
                                                    }
                                                }
                                            }

                                            $required = ($rule->IsMandatory && empty($uploaded_val)) ? 'required data-parsley-required="true"' : '';
                                            $name = "rule_" . $rule->RuleId; 
                                            ?>

                                            <?php if ($rule->InputType == 'File'): ?>
                                                <?php 
                                                    $multiple = $rule->AllowMultiple ? 'multiple="multiple"' : '';
                                                    $accept = $rule->AllowAllFileTypes ? '' : 'accept="image/*,.pdf,.doc,.docx,.ppt,.pps,.pptx,.ods,.xlr,.xls,.xlsx,.rtf"';
                                                    $inputName = $rule->AllowMultiple ? $name."[]" : $name;
                                                ?>
                                                <input class="form-control" type="file" name="<?= $inputName ?>" <?= $multiple ?> <?= $accept ?> <?= $required ?>>
                                                
                                                <?php if ($uploaded_val && $is_file_doc): ?>
                                                    <div class="mt-2 p-2 border rounded bg-light d-flex align-items-center shadow-sm">
                                                        <?php if ($is_img): ?>
                                                            <img src="<?= $uploaded_file_path ?>" style="height: 35px; width: 35px; object-fit: cover;" class="rounded me-2 border">
                                                        <?php else: ?>
                                                            <div class="bg-white rounded border d-flex align-items-center justify-content-center me-2" style="width:35px; height:35px;">
                                                                <i class="bi bi-file-earmark-text text-primary fs-5"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div>
                                                            <a href="<?= $uploaded_file_path ?>" target="_blank" class="text-decoration-none small fw-bold">View Current File</a>
                                                            <?php if ($uploaded_status): ?>
                                                                <?php 
                                                                $bclass = 'bg-secondary';
                                                                if($uploaded_status=='Approved') $bclass='bg-success';
                                                                elseif($uploaded_status=='Rejected') $bclass='bg-danger';
                                                                elseif($uploaded_status=='Pending') $bclass='bg-warning text-dark';
                                                                ?>
                                                                <span class="badge <?= $bclass ?> ms-2" style="font-size:10px;"><?= $uploaded_status ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                
                                            <?php elseif ($rule->InputType == 'Text'): ?>
                                                <input type="text" name="<?= $name ?>" class="form-control" <?= $required ?> value="<?= htmlspecialchars($uploaded_val) ?>">
                                                
                                            <?php elseif ($rule->InputType == 'Number'): ?>
                                                <input type="number" name="<?= $name ?>" class="form-control" <?= $required ?> value="<?= htmlspecialchars($uploaded_val) ?>">
                                                
                                            <?php elseif ($rule->InputType == 'TextAndNumber'): ?>
                                                <input type="text" name="<?= $name ?>" class="form-control" <?= $required ?> pattern="[a-zA-Z0-9\s]+" title="Only text and numbers allowed" value="<?= htmlspecialchars($uploaded_val) ?>">
                                                
                                            <?php elseif ($rule->InputType == 'Date'): ?>
                                                <input type="date" name="<?= $name ?>" class="form-control" <?= $required ?> value="<?= htmlspecialchars($uploaded_val) ?>">
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12 text-muted">No verification rules configured.</div>
                                <?php endif; ?>

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

            if (!$('#frmDynamicDocs').parsley().validate()) 
            {
                customAlert('Validation Failed', 'Please fill all mandatory fields correctly.', 'error');
                return false;
            }

            // Temporarily standard form submit until backend API is ready
            $('#frmDynamicDocs').submit();
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