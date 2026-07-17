<?php $this->load->view('admin/components/css_links'); ?>
<body class="bg-light">
    <?php $this->load->view('admin/components/sidebar'); ?>
    
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="admin-content p-4">
            <!-- <h2 class="mb-4">Property Settings</h2> -->

            <!-- Navigation Tabs -->
            <ul class="nav nav-pills nav-modern mb-4" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="types-tab" data-bs-toggle="tab" data-bs-target="#types" type="button" role="tab">Property Types</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab">Property Features</button>
                </li>
            </ul>

            <div class="tab-content" id="settingsTabsContent">
                <!-- Tab 1: Property Types -->
                <div class="tab-pane fade show active" id="types" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <!-- <h4 class="fw-bold mb-0">Manage Property Types</h4> -->
                        <button class="btn btn-primary btn-sm" onclick="openTypeModal()"><i class="fa fa-plus me-1"></i> Add Type</button>
                    </div>
                    <div class="modern-card card-body p-4 bg-white">
                        <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 init-datatable" id="typesTable">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th>Icon</th>
                                            <th>Title</th>
                                            <th>Remarks</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($property_types as $type): ?>
                                            <tr>
                                                <td>
                                                    <?php if($type->PropertyIcon): ?>
                                                        <i class="<?= $type->PropertyIcon ?>"></i>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <td class="fw-bold"><?= $type->Title ?></td>
                                                <td><span class="text-muted"><?= $type->Remarks ?? '-' ?></span></td>
                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-outline-primary me-1" onclick='editType(<?= json_encode($type) ?>)'><i class="fa fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteType(<?= $type->TypeId ?>)"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if(empty($property_types)): ?>
                                            <tr><td colspan="5" class="text-center text-muted py-4">No property types found.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>

                <!-- Tab 2: Property Features -->
                <div class="tab-pane fade" id="features" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <!-- <h4 class="fw-bold mb-0">Manage Property Features</h4> -->
                        <button class="btn btn-primary btn-sm" onclick="openFeatureModal()"><i class="fa fa-plus me-1"></i> Add Feature</button>
                    </div>
                    <div class="modern-card card-body p-4 bg-white">
                        <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 init-datatable" id="featuresTable">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th>Feature Name</th>
                                            <th>Linked Property Type</th>
                                            <th>Input Type</th>
                                            <th>Requirement</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($features as $f): ?>
                                            <tr>
                                                <td class="fw-bold"><?= $f->Title ?></td>
                                                <td>
                                                    <?php if($f->PropertyTypeId == 0): ?>
                                                        <span class="badge bg-secondary">All Types (System)</span>
                                                    <?php else: ?>
                                                        <?= $f->TypeTitle ?? '<span class="text-danger">Not Linked</span>' ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td><span class="badge bg-info text-dark"><?= ucfirst($f->InputType) ?></span></td>
                                                <td>
                                                    <?php if($f->IsRequired): ?>
                                                        <span class="badge bg-danger rounded-pill px-3">Mandatory</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-light text-dark border rounded-pill px-3">Optional</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end">
                                                    <?php if($f->IsSystem): ?>
                                                        <span class="badge bg-secondary"><i class="fa fa-lock"></i> Fixed</span>
                                                    <?php else: ?>
                                                        <button class="btn btn-sm btn-outline-primary me-1" onclick='editFeature(<?= json_encode($f) ?>)'><i class="fa fa-edit"></i></button>
                                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteFeature(<?= $f->FeatureId ?>)"><i class="fa fa-trash"></i></button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if(empty($features)): ?>
                                            <tr><td colspan="4" class="text-center text-muted py-4">No features found.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <!-- Modals -->
    <!-- Property Type Modal -->
    <div class="modal fade" id="typeModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="frmType" class="modal-content">
                <input type="hidden" name="TypeId" id="TypeId">
                <div class="modal-header">
                    <h5 class="modal-title" id="typeModalTitle">Add Property Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="Title" id="TypeTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <textarea name="Remarks" id="Remarks" class="form-control" rows="2" placeholder="Optional remarks"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon Class (FontAwesome)</label>
                        <input type="text" name="PropertyIcon" id="PropertyIcon" class="form-control" placeholder="e.g. fa fa-home">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Property Feature Modal -->
    <div class="modal fade" id="featureModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="frmFeature" class="modal-content">
                <input type="hidden" name="FeatureId" id="FeatureId">
                <div class="modal-header">
                    <h5 class="modal-title" id="featureModalTitle">Add Feature</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Feature Name</label>
                        <input type="text" name="Title" id="FeatureTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link to Property Type</label>
                        <select name="PropertyTypeId" id="FeaturePropertyTypeId" class="form-select" required>
                            <option value="">Select Type</option>
                            <?php foreach($property_types as $type): ?>
                                <option value="<?= $type->TypeId ?>"><?= $type->Title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Input Type</label>
                        <select name="InputType" id="InputType" class="form-select" required>
                            <option value="checkbox">Checkbox (Yes/No)</option>
                            <option value="number">Number</option>
                            <option value="text">Text / String</option>
                        </select>
                    </div>
                    <div class="mb-4 mt-4">
                        <div class="form-check form-switch fs-5">
                            <input class="form-check-input" type="checkbox" role="switch" name="IsRequired" id="IsRequired" value="1">
                            <label class="form-check-label fs-6 mt-1 ms-2" for="IsRequired"><strong>Is Mandatory?</strong><br><small class="text-muted fw-normal">User must fill this field when posting.</small></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const typeModal = new bootstrap.Modal(document.getElementById('typeModal'));
        const featureModal = new bootstrap.Modal(document.getElementById('featureModal'));

        function openTypeModal() {
            $('#frmType')[0].reset();
            $('#TypeId').val('');
            $('#typeModalTitle').text('Add Property Type');
            typeModal.show();
        }

        function editType(type) {
            $('#frmType')[0].reset();
            $('#TypeId').val(type.TypeId);
            $('#TypeTitle').val(type.Title);
            $('#Remarks').val(type.Remarks);
            $('#PropertyIcon').val(type.PropertyIcon);
            $('#typeModalTitle').text('Edit Property Type');
            typeModal.show();
        }

        function deleteType(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('<?= site_url("Admin/api_delete_property_type/") ?>' + id, function(res) {
                        location.reload();
                    });
                }
            })
        }

        $('#frmType').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= site_url("Admin/api_save_property_type") ?>',
                type: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    location.reload();
                }
            });
        });

        // Feature functions
        function openFeatureModal() {
            $('#frmFeature')[0].reset();
            $('#FeatureId').val('');
            $('#IsRequired').prop('checked', false);
            $('#featureModalTitle').text('Add Feature');
            featureModal.show();
        }

        function editFeature(feature) {
            $('#frmFeature')[0].reset();
            $('#FeatureId').val(feature.FeatureId);
            $('#FeatureTitle').val(feature.Title);
            $('#FeaturePropertyTypeId').val(feature.PropertyTypeId);
            $('#InputType').val(feature.InputType);
            $('#IsRequired').prop('checked', feature.IsRequired == 1);
            $('#featureModalTitle').text('Edit Feature');
            featureModal.show();
        }

        function deleteFeature(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('<?= site_url("Admin/api_delete_property_feature/") ?>' + id, function(res) {
                        location.reload();
                    });
                }
            })
        }

        $('#frmFeature').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= site_url("Admin/api_save_property_feature") ?>',
                type: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    location.reload();
                }
            });
        });
    </script>
</body>
</html>
