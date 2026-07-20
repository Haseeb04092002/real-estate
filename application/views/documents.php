<?php
$UserId = $this->session->userdata('user_id');
?>

<style>
    .upload-box {
        border: 2px dashed #a5b4fc;
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        background-color: #f8fafc;
        cursor: pointer;
        transition: all 0.3s;
    }
    .upload-box:hover, .upload-box.dragover {
        background-color: #eef2ff;
        border-color: #4f46e5;
    }
    .upload-icon {
        font-size: 40px;
        color: #818cf8;
        margin-bottom: 10px;
    }
    .upload-text {
        font-size: 16px;
        font-weight: 600;
        color: #475569;
    }
    .upload-subtext {
        font-size: 13px;
        color: #94a3b8;
        margin-top: 5px;
    }
    .hidden-file-input {
        display: none;
    }
    .file-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .file-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        transition: all 0.2s;
    }
    .file-item:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .file-item-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .file-icon {
        width: 40px;
        height: 40px;
        background: #eef2ff;
        color: #4f46e5;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .file-info {
        display: flex;
        flex-direction: column;
    }
    .file-name {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .file-meta {
        font-size: 12px;
        color: #64748b;
        display: flex;
        gap: 10px;
        margin-top: 2px;
    }
</style>

<div class="dashboard-container pt-4">
    <div class="dashboard-card">
        <div class="card-header">
            <h2 class="section-title">Upload Required Documents</h2>
        </div>
        <div class="card-body p-4 property-form" id="divContent">
            <?php if (empty($DocTypes)): ?>
                <div class="alert alert-info border-0 shadow-sm rounded-4">No specific documents are required for this property type at this time.</div>
            <?php else: ?>
                <?= form_open_multipart('Properties/SavePropertyDocuments/'.$PropertyId, ['id' => 'frmUploadDocuments']) ?>
                    
                    <div class="row g-4">
                        <?php foreach($DocTypes as $type): ?>
                            <?php 
                                $uploaded = false;
                                $status = '';
                                $fileName = '';
                                $docId = 0;
                                foreach($UploadedDocs as $doc) {
                                    if (isset($doc->DocTypeId) && $doc->DocTypeId == $type->DocTypeId) {
                                        $uploaded = true;
                                        $status = $doc->VerificationStatus;
                                        $fileName = $doc->FilePath;
                                        $docId = $doc->DocumentId;
                                        break;
                                    }
                                }
                                $reqStr = ($type->IsMandatory == 1 && !$uploaded) ? 'required data-parsley-required-message="This document is required"' : '';
                            ?>
                            <div class="col-md-6">
                                <div class="card shadow-sm h-100 border-0 rounded-4" style="background: #f8f9fa;">
                                    <div class="card-body p-4">
                                        <h5 class="card-title fw-bold mb-3"><?= $type->DocumentTitle ?>
                                            <?php if($type->IsMandatory == 1): ?>
                                                <span class="text-danger">*</span>
                                            <?php endif; ?>
                                        </h5>
                                        
                                        <div class="upload-box dropzone-doc <?= $uploaded ? 'd-none' : '' ?>" id="dropzone_<?= $type->DocTypeId ?>" data-id="<?= $type->DocTypeId ?>">
                                            <div class="upload-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                                            <div class="upload-text">Browse files to upload</div>
                                            <div class="upload-subtext">Drag and drop document here (.pdf, .jpg, .png)</div>
                                        </div>
                                        
                                        <input type="file" id="input_<?= $type->DocTypeId ?>" name="doc_<?= $type->DocTypeId ?>" accept=".pdf,.jpg,.jpeg,.png" class="hidden-file-input doc-input" data-id="<?= $type->DocTypeId ?>" <?= $reqStr ?>>
                                        
                                        <div id="preview_<?= $type->DocTypeId ?>" class="file-list mt-3">
                                            <?php if($uploaded): ?>
                                                <div class="file-item" id="doc_item_<?= $docId ?>">
                                                    <div class="file-item-left">
                                                        <div class="file-icon">
                                                            <?php if(in_array(strtolower(pathinfo($fileName, PATHINFO_EXTENSION)), ['jpg','jpeg','png'])): ?>
                                                                <i class="fa-regular fa-image"></i>
                                                            <?php else: ?>
                                                                <i class="fa-solid fa-file-pdf"></i>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="file-info">
                                                            <div class="file-name" title="<?= $fileName ?>"><?= $fileName ?></div>
                                                            <div class="file-meta">
                                                                <!-- Status badge removed -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="file-item-right">
                                                        <button type="button" class="btn btn-sm btn-light text-danger remove-existing-doc" data-id="<?= $docId ?>" data-type-id="<?= $type->DocTypeId ?>" <?= ($type->IsMandatory == 1) ? 'data-mandatory="1"' : 'data-mandatory="0"' ?>><i class="fa-solid fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="d-flex justify-content-center align-items-center gap-5 mt-5 border-top pt-4">
                        <button type="button" class="btn btn-primary py-3 px-5 fw-bold animated fadeIn actSubmitForm" frm="frmUploadDocuments" ref="urlResponse" href="Properties/SavePropertyDocuments/<?= $PropertyId;?>">Save Documents & Finish</button>
                    </div>
                    
                <?= form_close() ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.dropzone-doc').forEach(dropzone => {
        var typeId = dropzone.dataset.id;
        var input = document.getElementById('input_' + typeId);

        dropzone.addEventListener('click', () => input.click());

        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
            if (e.dataTransfer.files.length > 0) {
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
            }
        });
    });

    document.querySelectorAll('.doc-input').forEach(input => {
        input.addEventListener('change', function(e) {
            var typeId = this.dataset.id;
            var dropzone = document.getElementById('dropzone_' + typeId);
            var previewContainer = document.getElementById('preview_' + typeId);
            var files = e.target.files;

            if (files.length > 0) {
                var file = files[0];
                var ext = file.name.split('.').pop().toLowerCase();
                var iconHtml = ['jpg','jpeg','png'].includes(ext) ? '<i class="fa-regular fa-image"></i>' : '<i class="fa-solid fa-file-pdf"></i>';

                previewContainer.innerHTML = `
                    <div class="file-item">
                        <div class="file-item-left">
                            <div class="file-icon">${iconHtml}</div>
                            <div class="file-info">
                                <div class="file-name" title="${file.name}">${file.name}</div>
                                <div class="file-meta">
                                    <span>${(file.size / 1024).toFixed(2)} KB</span>
                                    <span class="text-primary"><i class="fa-solid fa-spinner fa-spin me-1"></i> Ready to save</span>
                                </div>
                            </div>
                        </div>
                        <div class="file-item-right">
                            <button type="button" class="btn btn-sm btn-light text-danger remove-new-doc" data-type-id="${typeId}"><i class="fa-solid fa-times"></i></button>
                        </div>
                    </div>
                `;

                dropzone.classList.add('d-none');
                
                // Clear Parsley validation for this input since it has a file
                if ($(this).parsley()) {
                    $(this).parsley().destroy();
                }
                $(this).removeAttr('required');
                $(this).removeAttr('data-parsley-required-message');

                var removeBtn = previewContainer.querySelector('.remove-new-doc');
                removeBtn.addEventListener('click', function() {
                    input.value = '';
                    previewContainer.innerHTML = '';
                    dropzone.classList.remove('d-none');
                    
                    var isMandatory = dropzone.closest('.card-body').querySelector('.text-danger') !== null;
                    if(isMandatory) {
                        $(input).attr('required', 'required');
                        $(input).attr('data-parsley-required-message', 'This document is required');
                    }
                });
            }
        });
    });

    document.querySelectorAll('.remove-existing-doc').forEach(btn => {
        btn.addEventListener('click', function () {
            if(!confirm("Are you sure you want to delete this document?")) return;
            var docId = this.dataset.id;
            var typeId = this.dataset.typeId;
            var isMandatory = this.dataset.mandatory == '1';
            
            fetch('<?= base_url("Properties/DeletePropertyDocument/") ?>' + docId, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if(data.Status) {
                    var item = document.getElementById('doc_item_' + docId);
                    if(item) {
                        item.remove();
                        document.getElementById('dropzone_' + typeId).classList.remove('d-none');
                        
                        if(isMandatory) {
                            var input = $('#input_' + typeId);
                            input.attr('required', 'required');
                            input.attr('data-parsley-required-message', 'This document is required');
                            if(input.parsley()) {
                                input.parsley().destroy();
                            }
                        }
                    }
                } else {
                    alert('Error deleting document');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error deleting document');
            });
        });
    });
</script>
