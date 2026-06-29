<?php
$UserId = $this->session->userdata('user_id');
?>

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
                                // Check if already uploaded
                                $uploaded = false;
                                $status = '';
                                $fileName = '';
                                foreach($UploadedDocs as $doc) {
                                    if (isset($doc->DocTypeId) && $doc->DocTypeId == $type->DocTypeId) {
                                        $uploaded = true;
                                        $status = $doc->VerificationStatus;
                                        $fileName = $doc->DocumentFile;
                                        break;
                                    }
                                }
                            ?>
                            <div class="col-md-6">
                                <div class="card shadow-sm h-100 border-0 rounded-4" style="background: #f8f9fa;">
                                    <div class="card-body p-4">
                                        <h5 class="card-title fw-bold mb-3"><?= $type->DocumentTitle ?>
                                            <?php if($type->IsMandatory == 1): ?>
                                                <span class="text-danger">*</span>
                                            <?php endif; ?>
                                        </h5>
                                        
                                        <?php if($uploaded): ?>
                                            <div class="mb-3 p-3 bg-white rounded-3 shadow-sm">
                                                <span class="badge bg-<?= ($status=='Approved')?'success':(($status=='Pending')?'warning':'danger') ?> px-3 py-2 rounded-pill">
                                                    Status: <?= $status ?>
                                                </span>
                                                <div class="mt-2 small text-muted text-truncate" title="<?= $fileName ?>"><i class="fa fa-file-alt me-2"></i><?= $fileName ?></div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="mt-3">
                                            <label class="form-label text-muted small fw-bold">Upload New File</label>
                                            <input type="file" name="doc_<?= $type->DocTypeId ?>" accept=".pdf,.jpg,.jpeg,.png" class="form-control" <?= ($type->IsMandatory == 1 && !$uploaded) ? 'required' : '' ?>>
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
