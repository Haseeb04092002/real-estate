<?php
// features.php (Dynamic version)
$PropertyId = $PropertyId ?? 0;
$Case = $Case ?? 'Add';
?>

<div class="dashboard-container">
    <div class="dashboard-card">
        <div class="card-body p-4 property-form" id="divContent">
            
            <?php if(empty($DynamicFeatures)): ?>
                <div class="alert alert-info text-center mt-4">
                    <i class="fa fa-info-circle me-2"></i> No features have been defined for this Property Type yet. You can proceed to the next step.
                </div>
            <?php else: ?>
                <form class="" id="frmAddFeatures" data-parsley-validate onsubmit="return false;">
                    <div class="w-100">
                        <!-- All Features in One Group -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0 text-primary"><i class="fa fa-list-check me-2"></i>Property Features</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach($DynamicFeatures as $feature): 
                                        $val = $MappedValues[$feature->FeatureId] ?? '';
                                    ?>
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <?php if($feature->InputType == 'checkbox'): ?>
                                                <div class="form-check form-switch mt-4 pt-2">
                                                    <input class="form-check-input" type="checkbox" name="feature_<?= $feature->FeatureId ?>" id="feat_<?= $feature->FeatureId ?>" value="1" <?= $val == '1' ? 'checked' : '' ?> <?= $feature->IsRequired ? 'required' : '' ?>>
                                                    <label class="form-check-label fw-bold text-dark ms-2" for="feat_<?= $feature->FeatureId ?>"><?= htmlspecialchars($feature->Title) ?> <?= $feature->IsRequired ? '<span class="text-danger">*</span>' : '' ?></label>
                                                </div>
                                            <?php elseif($feature->InputType == 'number'): ?>
                                                <label class="form-label text-dark fw-bold"><?= htmlspecialchars($feature->Title) ?> <?= $feature->IsRequired ? '<span class="text-danger">*</span>' : '' ?></label>
                                                <input type="number" step="any" name="feature_<?= $feature->FeatureId ?>" class="form-control" value="<?= htmlspecialchars($val) ?>" <?= $feature->IsRequired ? 'required' : '' ?>>
                                            <?php elseif($feature->InputType == 'year'): ?>
                                                <label class="form-label text-dark fw-bold"><?= htmlspecialchars($feature->Title) ?> <?= $feature->IsRequired ? '<span class="text-danger">*</span>' : '' ?></label>
                                                <select name="feature_<?= $feature->FeatureId ?>" class="form-select" <?= $feature->IsRequired ? 'required' : '' ?>>
                                                    <option value="">Select Year</option>
                                                    <?php for($y = date('Y') + 5; $y >= 1800; $y--): ?>
                                                        <option value="<?= $y ?>" <?= $val == $y ? 'selected' : '' ?>><?= $y ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            <?php else: ?>
                                                <label class="form-label text-dark fw-bold"><?= htmlspecialchars($feature->Title) ?> <?= $feature->IsRequired ? '<span class="text-danger">*</span>' : '' ?></label>
                                                <input type="text" name="feature_<?= $feature->FeatureId ?>" class="form-control" value="<?= htmlspecialchars($val) ?>" <?= $feature->IsRequired ? 'required' : '' ?>>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center gap-5 mt-5">
                        <button type="button" class="btn btn-primary py-3 px-5 my-4 fw-bold animated fadeIn actSubmitForm" frm="frmAddFeatures" ref="urlResponse" href="Properties/SaveFeatures/<?= $Case ?>/<?= $PropertyId;?>">Save & Next</button>
                    </div>
                </form>
            <?php endif; ?>

            <?php if(empty($DynamicFeatures)): ?>
                <div class="d-flex justify-content-center align-items-center gap-5 mt-5">
                    <button type="button" class="btn btn-primary py-3 px-5 my-4 fw-bold animated fadeIn" onclick="window.location.href='<?= site_url('Properties/AddListing/'.$PropertyId.'/'.$Case.'/images') ?>'">Next Step <i class="fa fa-arrow-right ms-2"></i></button>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>