<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Generated Contracts'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
    <style>
        .dropdown-menu { font-size: 14px; }
    </style>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">
            

            <?php $this->load->view('admin/contracts/tabs'); ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Generated Contracts</h4>
            </div>

            <div class="modern-card card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle init-datatable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="fw-semibold">Contract #</th>
                                <th class="fw-semibold">Type</th>
                                <th class="fw-semibold">Parties (Buyer & Seller)</th>
                                <th class="fw-semibold">Property</th>
                                <th class="fw-semibold">Amount</th>
                                <th class="fw-semibold">Status</th>
                                <th class="fw-semibold">Date</th>
                                <th class="fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($contracts)): ?>
                                <?php foreach($contracts as $c): ?>
                                <tr>
                                    <td class="fw-bold">CTR-<?= str_pad($c->ContractId, 5, '0', STR_PAD_LEFT) ?></td>
                                    <td><span class="badge bg-secondary"><?= $c->TypeTitle ?></span></td>
                                    <td>
                                        <small class="d-block text-primary"><i class="fa-solid fa-user me-1"></i> B: <?= $c->BuyerName ?: 'N/A' ?></small>
                                        <small class="d-block text-success"><i class="fa-solid fa-user-tie me-1"></i> S: <?= $c->SellerName ?: 'N/A' ?></small>
                                    </td>
                                    <td><small class="text-truncate d-inline-block" style="max-width: 150px;" title="<?= htmlspecialchars($c->PropertyTitle) ?>"><?= $c->PropertyTitle ?: 'N/A' ?></small></td>
                                    <td class="fw-bold">$<?= number_format($c->TotalAmount, 2) ?></td>
                                    <td>
                                        <?php 
                                            $sc = 'bg-secondary';
                                            if($c->ContractStatus == 'Completed' || $c->ContractStatus == 'Approved' || $c->ContractStatus == 'Signed') $sc = 'bg-success';
                                            if($c->ContractStatus == 'Pending' || $c->ContractStatus == 'Draft') $sc = 'bg-warning text-dark';
                                            if($c->ContractStatus == 'Cancelled' || $c->ContractStatus == 'Rejected' || $c->ContractStatus == 'Terminated') $sc = 'bg-danger';
                                        ?>
                                        <span class="badge <?= $sc ?> status-badge" id="badge-<?= $c->ContractId ?>"><?= $c->ContractStatus ?></span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($c->AddedOn)) ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="<?= site_url('Admin/contract_pdf/'.$c->ContractId) ?>" target="_blank"><i class="fa-solid fa-file-pdf me-2 text-danger"></i> Download PDF</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><h6 class="dropdown-header">Update Status</h6></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus(<?= $c->ContractId ?>, 'Approved')"><i class="fa-solid fa-check me-2 text-success"></i> Mark Approved</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus(<?= $c->ContractId ?>, 'Completed')"><i class="fa-solid fa-check-double me-2 text-success"></i> Mark Completed</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus(<?= $c->ContractId ?>, 'Cancelled')"><i class="fa-solid fa-ban me-2 text-warning"></i> Cancel</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus(<?= $c->ContractId ?>, 'Terminated')"><i class="fa-solid fa-times-circle me-2 text-danger"></i> Terminate</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="8" class="text-center text-muted">No contracts generated yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>
    <script>
        const baseUrl = '<?= base_url() ?>';
        const siteUrl = '<?= site_url() ?>';

        function updateStatus(id, status) {
            if(confirm("Are you sure you want to mark this contract as " + status + "?")) {
                $.ajax({
                    url: siteUrl + 'Admin/api_update_contract_status',
                    type: 'POST',
                    data: { ContractId: id, Status: status },
                    dataType: 'json',
                    success: function(res) {
                        if(res.success) {
                            location.reload();
                        } else {
                            alert("Failed to update status.");
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>
