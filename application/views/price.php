<?php
$PropertyId = $PropertyId ?? '0';

if($PropertyId > 0) {
    $PropertyDetails = $this->getlist_model->getFieldsMultipleConditions('tbl_properties', '*', "WHERE PropertyId = '$PropertyId'", 2);
} else {
    $PropertyDetails = false;
}

$ListType = '';
$TotalPrice = '';
$SecurityBond = '';
$PossessionDate = '';

if ($PropertyDetails) {
    $ListType = $PropertyDetails->ListType;
    $TotalPrice = $PropertyDetails->TotalPrice;
    $SecurityBond = $PropertyDetails->SecurityBond;
    $PossessionDate = $PropertyDetails->PossessionDate;
}

if (empty($ListType)) {
    $ListType = 'Sale'; // Default
}

if (empty($PossessionDate)) {
    $PossessionDate = date('Y-m-d', strtotime('+1 day'));
}
?>

<div class="dashboard-container pt-4">
    <form class="" id="frmAddPrice" data-parsley-validate onsubmit="return false;">
        <div class="dashboard-card">
            <!-- <div class="card-header">
                <h2 class="section-title">Pricing Details</h2>
            </div> -->
            <div class="card-body p-4 property-form" id="divContent">
                
                <div class="form-row">
                    <div class="form-group w-100">
                        <label class="d-block mb-3 fw-bold fs-5">Is this property for Sale or for Rent?</label>
                        <div class="property-type d-flex flex-wrap gap-2">
                            <input type="radio" class="btn-check" name="selListType" id="listTypeSale" value="Sale" <?= (strtolower($ListType) === 'sale') ? 'checked' : ''; ?> autocomplete="off">
                            <label class="property-btn" for="listTypeSale">
                                <i class="fa fa-tag" aria-hidden="true"></i> 
                                For Sale
                            </label>

                            <input type="radio" class="btn-check" name="selListType" id="listTypeRent" value="Rent" <?= (strtolower($ListType) === 'rent') ? 'checked' : ''; ?> autocomplete="off">
                            <label class="property-btn" for="listTypeRent">
                                <i class="fa fa-key" aria-hidden="true"></i> 
                                For Rent
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-row mt-4">
                    <div class="form-group <?= (strtolower($ListType) === 'rent') ? 'd-none' : '' ?>" id="divSalePrice">
                        <label class="fw-bold">Total Price <span class="text-danger">*</span></label>
                        <input value="<?= (strtolower($ListType) === 'sale') ? $TotalPrice : ''; ?>" type="number" name="numTotalPriceSale" placeholder="e.g. 45000" <?= (strtolower($ListType) === 'sale') ? 'required' : '' ?> data-parsley-required-message="Total Price is required">
                    </div>
                    
                    <div class="form-group <?= (strtolower($ListType) === 'sale') ? 'd-none' : '' ?>" id="divRentPrice">
                        <label class="fw-bold">Rent per week <span class="text-danger">*</span></label>
                        <input value="<?= (strtolower($ListType) === 'rent') ? $TotalPrice : ''; ?>" type="number" name="numTotalPriceRent" placeholder="e.g. 4500" <?= (strtolower($ListType) === 'rent') ? 'required' : '' ?> data-parsley-required-message="Rent per week is required">
                    </div>
                    
                    <div class="form-group <?= (strtolower($ListType) === 'sale') ? 'd-none' : '' ?>" id="divSecurityBond">
                        <label class="fw-bold">Security Bond</label>
                        <input value="<?= $SecurityBond; ?>" type="number" name="numSecurityBond" placeholder="e.g. 3000" <?= (strtolower($ListType) === 'rent') ? 'required' : '' ?> data-parsley-required-message="Security Bond is required">
                    </div>

                    <div class="form-group">
                        <label class="fw-bold">Available From</label>
                        <input value="<?= $PossessionDate; ?>" type="date" name="dateAvailableFrom" required data-parsley-required-message="Available From date is required">
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center gap-5 mt-5">
                    <button type="button" class="btn btn-primary py-3 px-5 my-4 fw-bold animated fadeIn actSubmitForm" frm="frmAddPrice" ref="urlResponse" href="Properties/SavePropertyPrice/<?= $Case ?>/<?= $PropertyId;?>">Save & Next</button>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    $(document).off('change', 'input[name="selListType"]');
    $(document).on('change', 'input[name="selListType"]', function(e) {
        var ListType = $(this).val().toLowerCase();
        if (ListType == 'sale') {
            $('#divSalePrice').removeClass('d-none');
            $('input[name="numTotalPriceSale"]').attr('required', 'required');
            $('#divRentPrice').addClass('d-none');
            $('input[name="numTotalPriceRent"]').removeAttr('required').val('');
            
            $('#divSecurityBond').addClass('d-none');
            $('input[name="numSecurityBond"]').removeAttr('required').val('');
        } else if (ListType == 'rent') {
            $('#divRentPrice').removeClass('d-none');
            $('input[name="numTotalPriceRent"]').attr('required', 'required');
            $('#divSalePrice').addClass('d-none');
            $('input[name="numTotalPriceSale"]').removeAttr('required').val('');
            
            $('#divSecurityBond').removeClass('d-none');
            $('input[name="numSecurityBond"]').attr('required', 'required');
        }
    });
</script>
