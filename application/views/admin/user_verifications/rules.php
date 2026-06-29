<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'User Verification Rules'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">
            

            
            <!-- <ul class="nav nav-pills nav-modern mb-4">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= site_url('Admin_User_Verifications/rules') ?>"><i class="fa-solid fa-list-check me-2"></i> Verification Rules</a>
                </li>
            </ul> -->

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Dynamic Document Rules</h4>
                <button class="btn btn-primary" onclick="openRuleModal()"><i class="fa-solid fa-plus me-2"></i> Add Verification Rule</button>
            </div>

            <div class="modern-card card-body p-4 bg-white">
                <div class="table-responsive">
                    <table class="table table-hover align-middle init-datatable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="fw-semibold">ID</th>
                                <th class="fw-semibold">Document Title</th>
                                <th class="fw-semibold">Input Type</th>
                                <th class="fw-semibold">Requirement</th>
                                <th class="fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($rules)): ?>
                                <?php foreach($rules as $r): ?>
                                <tr>
                                    <td><?= $r->RuleId ?></td>
                                    <td class="fw-bold text-primary"><?= htmlspecialchars($r->DocumentTitle) ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($r->InputType ?? 'File') ?></span>
                                    </td>
                                    <td>
                                        <?php if($r->IsMandatory): ?>
                                            <span class="badge bg-danger rounded-pill px-3">Mandatory</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark border rounded-pill px-3">Optional</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick="editRule(<?= htmlspecialchars(json_encode($r), ENT_QUOTES, 'UTF-8') ?>)"><i class="fa-solid fa-edit"></i> Edit</button>
                                        <a href="<?= site_url('Admin_User_Verifications/api_delete_rule/'.$r->RuleId) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this rule? It may break existing user validations.');"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center text-muted py-4">No verification rules configured yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ruleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= site_url('Admin_User_Verifications/api_save_rule') ?>" method="POST">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold" id="modalTitle">Add Verification Rule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="RuleId" id="RuleId">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Document Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="DocumentTitle" id="DocumentTitle" required placeholder="e.g. Passport, License Front, Selfie">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Input Type <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-3 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="InputType" id="InputTypeFile" value="File" checked required onchange="toggleFileSettings()">
                                    <label class="form-check-label" for="InputTypeFile">File Upload</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="InputType" id="InputTypeText" value="Text" required onchange="toggleFileSettings()">
                                    <label class="form-check-label" for="InputTypeText">Text Input</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="InputType" id="InputTypeNumber" value="Number" required onchange="toggleFileSettings()">
                                    <label class="form-check-label" for="InputTypeNumber">Number Input</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="InputType" id="InputTypeTextAndNumber" value="TextAndNumber" required onchange="toggleFileSettings()">
                                    <label class="form-check-label" for="InputTypeTextAndNumber">Text and Numbers</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="InputType" id="InputTypeDate" value="Date" required onchange="toggleFileSettings()">
                                    <label class="form-check-label" for="InputTypeDate">Date Input</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4" id="fileSettingsBlock">
                            <label class="form-label fw-bold">File Upload Settings</label>
                            <div class="d-flex flex-column gap-2 mt-2">
                                <div class="form-check form-switch fs-6">
                                    <input class="form-check-input" type="checkbox" role="switch" name="AllowAllFileTypes" id="AllowAllFileTypes" value="1">
                                    <label class="form-check-label ms-2" for="AllowAllFileTypes">Allow All File Types</label>
                                </div>
                                <div class="form-check form-switch fs-6">
                                    <input class="form-check-input" type="checkbox" role="switch" name="AllowMultiple" id="AllowMultiple" value="1">
                                    <label class="form-check-label ms-2" for="AllowMultiple">Allow Multiple Files</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check form-switch fs-5">
                                <input class="form-check-input" type="checkbox" role="switch" name="IsMandatory" id="IsMandatory" value="1">
                                <label class="form-check-label fs-6 mt-1 ms-2" for="IsMandatory"><strong>Is Mandatory?</strong><br><small class="text-muted fw-normal">User must provide this to be verified.</small></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-save me-2"></i> Save Rule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>
    <script>
        function toggleFileSettings() {
            if(document.getElementById('InputTypeFile').checked) {
                document.getElementById('fileSettingsBlock').style.display = 'block';
            } else {
                document.getElementById('fileSettingsBlock').style.display = 'none';
            }
        }

        function openRuleModal() {
            document.getElementById('modalTitle').innerText = 'Add Verification Rule';
            document.getElementById('RuleId').value = '';
            document.getElementById('DocumentTitle').value = '';
            document.getElementById('InputTypeFile').checked = true;
            document.getElementById('AllowAllFileTypes').checked = false;
            document.getElementById('AllowMultiple').checked = false;
            document.getElementById('IsMandatory').checked = false;
            toggleFileSettings();
            new bootstrap.Modal(document.getElementById('ruleModal')).show();
        }

        function editRule(r) {
            document.getElementById('modalTitle').innerText = 'Edit Verification Rule';
            document.getElementById('RuleId').value = r.RuleId;
            document.getElementById('DocumentTitle').value = r.DocumentTitle;
            
            let inputType = r.InputType || 'File';
            let radio = document.querySelector('input[name="InputType"][value="' + inputType + '"]');
            if(radio) radio.checked = true;

            document.getElementById('AllowAllFileTypes').checked = r.AllowAllFileTypes == 1;
            document.getElementById('AllowMultiple').checked = r.AllowMultiple == 1;
            document.getElementById('IsMandatory').checked = r.IsMandatory == 1;
            
            toggleFileSettings();
            new bootstrap.Modal(document.getElementById('ruleModal')).show();
        }
    </script>
</body>
</html>
