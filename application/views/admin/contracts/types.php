<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Contract Types'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">
            

            <?php $this->load->view('admin/contracts/tabs'); ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Contract Types</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#typeModal" onclick="openTypeModal()"><i class="fa-solid fa-plus me-2"></i> Create Type</button>
            </div>

            <div class="modern-card card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle init-datatable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="fw-semibold">ID</th>
                                <th class="fw-semibold">Title</th>
                                <th class="fw-semibold">Status</th>
                                <th class="fw-semibold">Created</th>
                                <th class="fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($types)): ?>
                                <?php foreach($types as $t): ?>
                                <tr>
                                    <td><?= $t->TypeId ?></td>
                                    <td class="fw-bold"><?= $t->Title ?></td>
                                    <td>
                                        <?php if($t->IsActive == 1): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d M Y', strtotime($t->AddedOn)) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick="editType(<?= $t->TypeId ?>, '<?= addslashes($t->Title) ?>', <?= $t->IsActive ?>)">Edit</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center text-muted">No contract types found.</td></tr>
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
                <form action="<?= site_url('Admin/api_save_contract_type') ?>" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Create Contract Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="TypeId" id="TypeId">
                        <div class="mb-3">
                            <label class="form-label">Type Title</label>
                            <input type="text" class="form-control" name="Title" id="TypeTitle" required placeholder="e.g. Property Sale Agreement">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="IsActive" id="TypeStatus">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>
    <script>
        function openTypeModal() {
            document.getElementById('modalTitle').innerText = 'Create Contract Type';
            document.getElementById('TypeId').value = '';
            document.getElementById('TypeTitle').value = '';
            document.getElementById('TypeStatus').value = '1';
        }

        function editType(id, title, status) {
            document.getElementById('modalTitle').innerText = 'Edit Contract Type';
            document.getElementById('TypeId').value = id;
            document.getElementById('TypeTitle').value = title;
            document.getElementById('TypeStatus').value = status;
            var myModal = new bootstrap.Modal(document.getElementById('typeModal'));
            myModal.show();
        }
    </script>
</body>
</html>
