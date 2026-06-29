<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Document Types'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">
            

            <?php $this->load->view('admin/property_docs/tabs'); ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Document Requirements Rules</h4>
                <button class="btn btn-primary" onclick="openTypeModal()"><i class="fa-solid fa-plus me-2"></i> Add Document Rule</button>
            </div>

            <div class="modern-card card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle init-datatable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="fw-semibold">ID</th>
                                <th class="fw-semibold">Document Category</th>
                                <th class="fw-semibold">Property Type</th>
                                <th class="fw-semibold">Requirement</th>
                                <th class="fw-semibold">Expiry Tracking</th>
                                <th class="fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($types)): ?>
                                <?php foreach($types as $t): ?>
                                <tr>
                                    <td><?= $t->DocTypeId ?></td>
                                    <td class="fw-bold text-primary"><?= htmlspecialchars($t->DocumentTitle) ?></td>
                                    <td>
                                        <?php if($t->PropertyType == 'Sale'): ?>
                                            <span class="badge bg-info text-dark"><i class="fa-solid fa-tags me-1"></i> Sale</span>
                                        <?php elseif($t->PropertyType == 'Rent'): ?>
                                            <span class="badge bg-warning text-dark"><i class="fa-solid fa-key me-1"></i> Rent</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><i class="fa-solid fa-building me-1"></i> Both</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($t->IsMandatory): ?>
                                            <span class="badge bg-danger rounded-pill px-3">Mandatory</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark border rounded-pill px-3">Optional</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($t->RequiresExpiryTracking): ?>
                                            <span class="badge bg-success rounded-pill px-3"><i class="fa-solid fa-clock-rotate-left me-1"></i> Tracked</span>
                                        <?php else: ?>
                                            <span class="text-muted small"><i class="fa-solid fa-minus"></i></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick='editType(<?= json_encode($t) ?>)'><i class="fa-solid fa-edit"></i> Edit</button>
                                        <a href="<?= site_url('Admin_Property_Docs/api_delete_type/'.$t->DocTypeId) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this rule? This may break existing property document validations.');"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center text-muted py-4">No document types configured yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="typeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= site_url('Admin_Property_Docs/api_save_type') ?>" method="POST">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold" id="modalTitle">Add Document Rule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="DocTypeId" id="DocTypeId">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Document Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="DocumentTitle" id="DocumentTitle" required placeholder="e.g. Certificate of Title, Proof of Ownership">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Applies to Property Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="PropertyType" id="PropertyType" required>
                                <option value="Sale">Sale Properties Only</option>
                                <option value="Rent">Rental Properties Only</option>
                                <option value="Both">Both Sale & Rent</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check form-switch fs-5">
                                <input class="form-check-input" type="checkbox" role="switch" name="IsMandatory" id="IsMandatory" value="1">
                                <label class="form-check-label fs-6 mt-1 ms-2" for="IsMandatory"><strong>Is Mandatory?</strong><br><small class="text-muted fw-normal">Listing cannot go live without this document.</small></label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch fs-5">
                                <input class="form-check-input" type="checkbox" role="switch" name="RequiresExpiryTracking" id="RequiresExpiryTracking" value="1">
                                <label class="form-check-label fs-6 mt-1 ms-2" for="RequiresExpiryTracking"><strong>Track Expiry Dates?</strong><br><small class="text-muted fw-normal">Enables 90/30/7 day reminders and auto-suspension.</small></label>
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
        function openTypeModal() {
            document.getElementById('modalTitle').innerText = 'Add Document Rule';
            document.getElementById('DocTypeId').value = '';
            document.getElementById('DocumentTitle').value = '';
            document.getElementById('PropertyType').value = 'Sale';
            document.getElementById('IsMandatory').checked = false;
            document.getElementById('RequiresExpiryTracking').checked = false;
            new bootstrap.Modal(document.getElementById('typeModal')).show();
        }

        function editType(t) {
            document.getElementById('modalTitle').innerText = 'Edit Document Rule';
            document.getElementById('DocTypeId').value = t.DocTypeId;
            document.getElementById('DocumentTitle').value = t.DocumentTitle;
            document.getElementById('PropertyType').value = t.PropertyType;
            document.getElementById('IsMandatory').checked = t.IsMandatory == 1;
            document.getElementById('RequiresExpiryTracking').checked = t.RequiresExpiryTracking == 1;
            new bootstrap.Modal(document.getElementById('typeModal')).show();
        }
    </script>
</body>
</html>
