<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Document Review Queue'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">
            

            <?php $this->load->view('admin/property_docs/tabs'); ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Document Review Queue</h4>
            </div>

            <div class="modern-card card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle init-datatable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="fw-semibold">Property ID / Title</th>
                                <th class="fw-semibold">Seller</th>
                                <th class="fw-semibold">Document Type</th>
                                <th class="fw-semibold">Uploaded Date</th>
                                <th class="fw-semibold">Expiry</th>
                                <th class="fw-semibold">Status</th>
                                <th class="fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($queue)): ?>
                                <?php foreach($queue as $d): ?>
                                <tr>
                                    <td>
                                        <small class="text-muted d-block">ID: <?= $d->PropertyId ?></small>
                                        <span class="fw-bold text-truncate d-inline-block" style="max-width:200px;" title="<?= htmlspecialchars($d->PropertyTitle ?? '') ?>"><?= htmlspecialchars($d->PropertyTitle ?? '') ?></span>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('Admin/user_details/'.$d->SellerId) ?>" class="text-decoration-none fw-bold" target="_blank"><?= htmlspecialchars($d->SellerName ?? '') ?></a>
                                    </td>
                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($d->TypeTitle ?? '') ?></span></td>
                                    <td><?= date('d M Y, H:i', strtotime($d->UploadedDate)) ?></td>
                                    <td>
                                        <?php if($d->ExpiryDate): ?>
                                            <?php 
                                                $exp = strtotime($d->ExpiryDate);
                                                $now = time();
                                                $class = $exp < $now ? 'text-danger fw-bold' : 'text-muted';
                                            ?>
                                            <span class="<?= $class ?>"><?= date('d M Y', $exp) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $sc = 'bg-secondary';
                                            if($d->VerificationStatus == 'Approved') $sc = 'bg-success';
                                            if($d->VerificationStatus == 'Pending') $sc = 'bg-warning text-dark';
                                            if($d->VerificationStatus == 'Rejected' || $d->VerificationStatus == 'Re-upload') $sc = 'bg-danger';
                                        ?>
                                        <span class="badge <?= $sc ?>"><?= $d->VerificationStatus ?></span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('uploads/PropertyDocs/' . $d->PropertyId . '/' . $d->FilePath) ?>" target="_blank" class="btn btn-sm btn-outline-info me-1" title="View Document"><i class="fa-solid fa-eye"></i></a>
                                        <button class="btn btn-sm btn-outline-primary" onclick='reviewDoc(<?= json_encode($d) ?>)' title="Review & Action"><i class="fa-solid fa-gavel"></i></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="text-center text-muted py-4">No documents in the queue.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= site_url('Admin_Property_Docs/api_update_status') ?>" method="POST" id="reviewForm">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold" id="reviewTitle">Review Document</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="DocumentId" id="revDocId">
                        
                        <div class="mb-3 bg-light p-3 rounded border">
                            <div class="row">
                                <div class="col-6"><small class="text-muted text-uppercase d-block mb-1">Document Type</small><strong id="revDocType"></strong></div>
                                <div class="col-6"><small class="text-muted text-uppercase d-block mb-1">Current Status</small><strong id="revStatus"></strong></div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Update Status <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg" name="VerificationStatus" id="revNewStatus" required>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approve</option>
                                <option value="Rejected">Reject</option>
                                <option value="Re-upload">Request Re-upload</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Admin Notes / Reason</label>
                            <textarea class="form-control" name="AdminNotes" id="revNotes" rows="3" placeholder="Enter reason if rejecting or requesting re-upload..."></textarea>
                            <small class="text-muted">These notes will be visible to the seller if the document is rejected or needs re-uploading.</small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-save me-2"></i> Save Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>
    <script>
        function reviewDoc(d) {
            document.getElementById('revDocId').value = d.DocumentId;
            document.getElementById('revDocType').innerText = d.TypeTitle;
            document.getElementById('revStatus').innerText = d.VerificationStatus;
            document.getElementById('revNewStatus').value = d.VerificationStatus;
            document.getElementById('revNotes').value = d.AdminNotes || '';
            new bootstrap.Modal(document.getElementById('reviewModal')).show();
        }

        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData
            }).then(res => res.json()).then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    customAlert('Error', data.message || 'Error saving review', 'error');
                }
            });
        });
    </script>
</body>
</html>
