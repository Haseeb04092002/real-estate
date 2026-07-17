<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Contract Templates'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable_inline {
            min-height: 600px;
            border-radius: 0 0 10px 10px !important;
            border-color: #f1f3f5 !important;
        }
        .ck-toolbar {
            border-radius: 10px 10px 0 0 !important;
            border-color: #f1f3f5 !important;
            background: #f8f9fa !important;
        }
        .var-btn {
            margin: 2px;
            font-size: 12px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">
            

            <?php $this->load->view('admin/contracts/tabs'); ?>

            <div id="listHeader" class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Contract Templates</h4>
                <button class="btn btn-primary" onclick="openTemplateForm()"><i class="fa-solid fa-plus me-2"></i> Create Template</button>
            </div>

            <!-- List View -->
            <div id="listView" class="modern-card card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle init-datatable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="fw-semibold">ID</th>
                                <th class="fw-semibold">Title</th>
                                <th class="fw-semibold">Contract Type</th>
                                <th class="fw-semibold">Version</th>
                                <th class="fw-semibold">Status</th>
                                <th class="fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($templates)): ?>
                                <?php foreach($templates as $t): ?>
                                <tr>
                                    <td><?= $t->TemplateId ?></td>
                                    <td class="fw-bold"><?= $t->TemplateTitle ?></td>
                                    <td><span class="badge bg-secondary"><?= $t->TypeTitle ?></span></td>
                                    <td>v<?= $t->Version ?></td>
                                    <td>
                                        <?php if($t->Status == 'Active'): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php elseif($t->Status == 'Draft'): ?>
                                            <span class="badge bg-warning text-dark">Draft</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Archived</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary me-1" onclick='previewTemplate(<?= json_encode($t->TemplateTitle) ?>, <?= json_encode($t->TemplateContent) ?>)'><i class="fa-solid fa-eye"></i> Preview</button>
                                        <button class="btn btn-sm btn-outline-primary" onclick='editTemplate(<?= json_encode($t) ?>)'><i class="fa-solid fa-edit"></i> Edit</button>
                                        <button class="btn btn-sm btn-outline-info" onclick='duplicateTemplate(<?= json_encode($t) ?>)'><i class="fa-solid fa-copy"></i> Duplicate</button>
                                        <button class="btn btn-sm btn-outline-danger ms-1" onclick="deleteContractItem(<?= $t->TemplateId ?>, 'template')"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center text-muted">No templates found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Editor View -->
            <div id="editorView" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0 text-dark">
                        <i class="fa-solid fa-arrow-left me-3 text-secondary" style="cursor:pointer; transition: 0.2s;" onmouseover="this.classList.replace('text-secondary','text-primary')" onmouseout="this.classList.replace('text-primary','text-secondary')" onclick="closeTemplateForm()"></i> 
                        <span id="formTitle">Create Template</span>
                    </h4>
                    <div>
                        <button type="button" class="btn btn-light shadow-sm me-2 fw-semibold rounded-pill px-4" onclick="closeTemplateForm()">Cancel</button>
                        <button type="submit" form="templateForm" class="btn btn-primary shadow-sm fw-semibold rounded-pill px-4"><i class="fa-solid fa-save me-2"></i> Save Template</button>
                    </div>
                </div>
                
                <form action="<?= site_url('Admin/api_save_template') ?>" method="POST" id="templateForm">
                    <input type="hidden" name="TemplateId" id="TemplateId">
                    
                    <!-- Settings Card -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-sliders me-2"></i>Template Configuration</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small text-uppercase">Template Title</label>
                                    <input type="text" class="form-control form-control-lg bg-light border-0" name="TemplateTitle" id="TemplateTitle" placeholder="e.g. Standard Sale Agreement" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-muted small text-uppercase">Contract Type</label>
                                    <select class="form-select form-select-lg bg-light border-0" name="ContractTypeId" id="ContractTypeId" required>
                                        <option value="">-- Select Type --</option>
                                        <?php foreach($types as $type): if($type->IsActive == 1): ?>
                                            <option value="<?= $type->TypeId ?>"><?= $type->Title ?></option>
                                        <?php endif; endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-muted small text-uppercase">Status</label>
                                    <select class="form-select form-select-lg bg-light border-0" name="Status" id="Status">
                                        <option value="Draft">Draft</option>
                                        <option value="Active">Active</option>
                                        <option value="Archived">Archived</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Editor & Tools Row -->
                    <div class="row">
                        <!-- Left Col: Editor -->
                        <div class="col-xl-9 col-lg-8 mb-4">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                                    <h6 class="fw-bold text-primary"><i class="fa-solid fa-pen-nib me-2"></i>Document Editor</h6>
                                </div>
                                <div class="card-body p-4">
                                    <textarea name="TemplateContent" id="editor"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Col: Tools Sidebar -->
                        <div class="col-xl-3 col-lg-4 mb-4">
                            
                            <!-- Variables Widget -->
                            <div class="card border-0 shadow-sm rounded-4 mb-4">
                                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-primary bg-opacity-10 text-primary me-3" style="width: 40px; height: 40px; font-size: 18px;">
                                            <i class="fa-solid fa-code"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-0">Smart Variables</h6>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#addVariableModal" title="Add Variable">
                                        <i class="fa-solid fa-plus text-primary"></i>
                                    </button>
                                </div>
                                <div class="card-body px-4 pb-4 pt-2">
                                    <p class="small text-muted mb-3">Click a chip to insert dynamic data fields into your document.</p>
                                    <div class="d-flex flex-wrap gap-2" style="max-height: 250px; overflow-y: auto;">
                                        <?php if(!empty($variables)): foreach($variables as $v): ?>
                                            <span class="badge bg-light text-dark border p-2 cursor-pointer var-badge" 
                                                  style="font-size: 13px; font-weight: 500; cursor: pointer; transition: 0.2s;"
                                                  onmouseover="this.classList.replace('bg-light','bg-primary'); this.classList.replace('text-dark','text-white');"
                                                  onmouseout="this.classList.replace('bg-primary','bg-light'); this.classList.replace('text-white','text-dark');"
                                                  onclick="insertText('{{<?= $v->VarKey ?>}}')">
                                                <i class="fa-solid fa-tag text-muted me-1"></i> {{<?= $v->VarKey ?>}}
                                            </span>
                                        <?php endforeach; else: ?>
                                            <div class="alert alert-light text-center small text-muted border-dashed py-3 w-100">No variables added yet.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Clauses Widget -->
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-info bg-opacity-10 text-info me-3" style="width: 40px; height: 40px; font-size: 18px;">
                                            <i class="fa-solid fa-scale-balanced"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-0">Legal Clauses</h6>
                                    </div>
                                    <a href="<?= site_url('Admin/contract_clauses') ?>" class="btn btn-sm btn-light border" title="Manage Clauses">
                                        <i class="fa-solid fa-up-right-from-square text-info"></i>
                                    </a>
                                </div>
                                <div class="card-body px-4 pb-4 pt-2">
                                    <p class="small text-muted mb-3">Insert pre-approved legal blocks.</p>
                                    <div class="d-flex flex-column gap-2" style="max-height: 250px; overflow-y: auto;">
                                        <?php if(!empty($clauses)): foreach($clauses as $c): ?>
                                            <div class="p-2 bg-light border rounded-3 cursor-pointer text-truncate var-clause" 
                                                 style="font-size: 13px; font-weight: 600; cursor: pointer; transition: 0.2s;"
                                                 onmouseover="this.classList.replace('bg-light','bg-info'); this.classList.add('text-white');"
                                                 onmouseout="this.classList.replace('bg-info','bg-light'); this.classList.remove('text-white');"
                                                 onclick='insertHtml(<?= json_encode($c->ClauseContent) ?>)' 
                                                 title="<?= htmlspecialchars($c->ClauseTitle) ?>">
                                                <i class="fa-solid fa-gavel text-secondary me-2 icon-clause"></i><?= htmlspecialchars($c->ClauseTitle) ?>
                                            </div>
                                        <?php endforeach; else: ?>
                                            <div class="alert alert-light text-center small text-muted border-dashed py-3">No clauses added yet.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <!-- Add Variable Modal -->
            <div class="modal fade" id="addVariableModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content border-0 shadow rounded-4">
                        <div class="modal-header border-bottom-0 pb-0">
                            <h5 class="fw-bold mb-0">Add Variable</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= site_url('Admin/api_save_contract_variable') ?>" method="POST">
                            <div class="modal-body">
                                <p class="small text-muted mb-3">Enter the variable key without curly braces (e.g., <code>buyer_name</code>).</p>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small text-uppercase">Variable Key</label>
                                    <input type="text" class="form-control bg-light" name="VarKey" required placeholder="e.g. buyer_name">
                                </div>
                            </div>
                            <div class="modal-footer border-top-0 pt-0">
                                <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary rounded-pill px-3">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Preview Offcanvas -->
            <div class="offcanvas offcanvas-end shadow" tabindex="-1" id="previewOffcanvas" style="width: 800px; max-width: 100%; border-left: 1px solid #dee2e6;">
                <div class="offcanvas-header bg-light border-bottom py-3 px-4">
                    <h5 class="offcanvas-title fw-bold" id="previewOffcanvasTitle">Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-4 bg-white" id="previewOffcanvasBody" style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                    <!-- Content goes here -->
                </div>
            </div>

        </div>
        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>
    <script>
        let theEditor;

        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .then( editor => {
                theEditor = editor;
            } )
            .catch( error => {
                console.error( error );
            } );

        function previewTemplate(title, content) {
            document.getElementById('previewOffcanvasTitle').innerText = title;
            document.getElementById('previewOffcanvasBody').innerHTML = content;
            var myOffcanvas = new bootstrap.Offcanvas(document.getElementById('previewOffcanvas'));
            myOffcanvas.show();
        }

        function insertText(text) {
            theEditor.model.change( writer => {
                const insertPosition = theEditor.model.document.selection.getFirstPosition();
                writer.insertText( text, insertPosition );
            });
            theEditor.editing.view.focus();
        }

        function insertHtml(html) {
            const viewFragment = theEditor.data.processor.toView( html );
            const modelFragment = theEditor.data.toModel( viewFragment );
            theEditor.model.insertContent( modelFragment );
            theEditor.editing.view.focus();
        }

        function openTemplateForm() {
            document.getElementById('listHeader').classList.add('d-none');
            document.getElementById('listHeader').classList.remove('d-flex');
            document.getElementById('listView').style.display = 'none';
            document.getElementById('editorView').style.display = 'block';
            document.getElementById('formTitle').innerText = 'Create Template';
            
            document.getElementById('TemplateId').value = '';
            document.getElementById('TemplateTitle').value = '';
            document.getElementById('ContractTypeId').value = '';
            document.getElementById('Status').value = 'Draft';
            if(theEditor) theEditor.setData('');
        }

        function closeTemplateForm() {
            document.getElementById('editorView').style.display = 'none';
            document.getElementById('listView').style.display = 'block';
            document.getElementById('listHeader').classList.remove('d-none');
            document.getElementById('listHeader').classList.add('d-flex');
        }

        function editTemplate(t) {
            openTemplateForm();
            document.getElementById('formTitle').innerText = 'Edit Template (v' + t.Version + ')';
            document.getElementById('TemplateId').value = t.TemplateId;
            document.getElementById('TemplateTitle').value = t.TemplateTitle;
            document.getElementById('ContractTypeId').value = t.ContractTypeId;
            document.getElementById('Status').value = t.Status;
            if(theEditor) theEditor.setData(t.TemplateContent || '');
        }

        function duplicateTemplate(t) {
            openTemplateForm();
            document.getElementById('formTitle').innerText = 'Duplicate Template';
            document.getElementById('TemplateId').value = '';
            document.getElementById('TemplateTitle').value = t.TemplateTitle + ' (Copy)';
            document.getElementById('ContractTypeId').value = t.ContractTypeId;
            document.getElementById('Status').value = 'Draft';
            if(theEditor) theEditor.setData(t.TemplateContent || '');
        }

        function deleteContractItem(id, type) {
            customConfirm('Delete Confirmation', 'Are you sure you want to delete this template?', 'warning', function(confirmed) {
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
