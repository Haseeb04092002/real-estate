<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Legal Clauses'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable_inline { min-height: 200px; }
    </style>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">
            

            <?php $this->load->view('admin/contracts/tabs'); ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Legal Clauses</h4>
                <button class="btn btn-primary" onclick="openClauseForm()"><i class="fa-solid fa-plus me-2"></i> Add Clause</button>
            </div>

            <!-- List View -->
            <div id="listView" class="modern-card card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle init-datatable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="fw-semibold" style="width: 10%;">ID</th>
                                <th class="fw-semibold" style="width: 30%;">Title</th>
                                <th class="fw-semibold" style="width: 40%;">Preview</th>
                                <th class="fw-semibold" style="width: 20%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($clauses)): ?>
                                <?php foreach($clauses as $c): ?>
                                <tr>
                                    <td><?= $c->ClauseId ?></td>
                                    <td class="fw-bold"><?= $c->ClauseTitle ?></td>
                                    <td class="text-muted"><small><?= mb_strimwidth(strip_tags($c->ClauseContent), 0, 80, '...') ?></small></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary me-1" onclick='previewClause(<?= json_encode($c->ClauseTitle) ?>, <?= json_encode($c->ClauseContent) ?>)'><i class="fa-solid fa-eye"></i> Preview</button>
                                        <button class="btn btn-sm btn-outline-primary" onclick='editClause(<?= json_encode($c) ?>)'><i class="fa-solid fa-edit"></i> Edit</button>
                                        <button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteContractItem(<?= $c->ClauseId ?>, 'clause')"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center text-muted">No clauses found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Editor View -->
            <div id="editorView" class="dashboard-card card-body" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0"><i class="fa-solid fa-arrow-left me-2 text-primary" style="cursor:pointer;" onclick="closeClauseForm()"></i> <span id="formTitle">Create Clause</span></h4>
                </div>
                
                <form action="<?= site_url('Admin/api_save_clause') ?>" method="POST">
                    <input type="hidden" name="ClauseId" id="ClauseId">
                    <div class="mb-3">
                        <label class="form-label">Clause Title (e.g. Payment Clause, Force Majeure)</label>
                        <input type="text" class="form-control" name="ClauseTitle" id="ClauseTitle" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Clause Content</label>
                        <textarea name="ClauseContent" id="editor"></textarea>
                    </div>
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary me-2" onclick="closeClauseForm()">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i> Save Clause</button>
                    </div>
                </form>
            </div>

            <!-- Preview Modal -->
            <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <div class="modal-content border-0 shadow rounded-4">
                        <div class="modal-header bg-light border-bottom-0 pb-3 pt-3 px-4">
                            <h5 class="fw-bold mb-0" id="previewModalTitle">Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4" id="previewModalBody">
                            <!-- Content goes here -->
                        </div>
                        <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>
    <script>
        let theEditor;

        ClassicEditor
            .create( document.querySelector( '#editor' ) , {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ]
            })
            .then( editor => {
                theEditor = editor;
            } )
            .catch( error => {
                console.error( error );
            } );

        function previewClause(title, content) {
            document.getElementById('previewModalTitle').innerText = title;
            document.getElementById('previewModalBody').innerHTML = content;
            var myModal = new bootstrap.Modal(document.getElementById('previewModal'));
            myModal.show();
        }

        function openClauseForm() {
            document.getElementById('listView').style.display = 'none';
            document.getElementById('editorView').style.display = 'block';
            document.getElementById('formTitle').innerText = 'Create Clause';
            
            document.getElementById('ClauseId').value = '';
            document.getElementById('ClauseTitle').value = '';
            if(theEditor) theEditor.setData('');
        }

        function closeClauseForm() {
            document.getElementById('editorView').style.display = 'none';
            document.getElementById('listView').style.display = 'block';
        }

        function editClause(c) {
            openClauseForm();
            document.getElementById('formTitle').innerText = 'Edit Clause';
            document.getElementById('ClauseId').value = c.ClauseId;
            document.getElementById('ClauseTitle').value = c.ClauseTitle;
            if(theEditor) theEditor.setData(c.ClauseContent || '');
        }

        function deleteContractItem(id, type) {
            customConfirm('Delete Confirmation', 'Are you sure you want to delete this clause?', 'warning', function(confirmed) {
                if(confirmed) {
                    $.ajax({
                        url: '<?= site_url('Admin/api_soft_delete_contract_item') ?>',
                        type: 'POST',
                        data: { id: id, type: type },
                        dataType: 'json',
                        success: function(res) {
                            if(res.success) {
                                location.reload();
                            } else {
                                customAlert('Error', 'Failed to delete.', 'error');
                            }
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>
