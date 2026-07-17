<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Property Ownership Monitoring'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
    <style>
        .nav-pills .nav-link.active {
            background-color: #1F509A;
        }
        .status-select {
            min-width: 120px;
            padding: 4px 8px;
            border-radius: 4px;
        }
        .status-occupied { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .status-rented { background-color: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .status-vacant { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        
        .prop-title {
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">


            <div class="modern-card card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle w-100 init-datatable" id="propertiesTable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="fw-semibold">ID</th>
                                <th class="fw-semibold">Title</th>
                                <th class="fw-semibold">Owner</th>
                                <th class="fw-semibold">Type</th>
                                <th class="fw-semibold">Mailing Address</th>
                                <th class="fw-semibold">Price</th>
                                <!-- <th class="fw-semibold">Views</th> -->
                                <th class="fw-semibold">Docs</th>
                                <th class="fw-semibold">Sale/Rent</th>
                                <th class="fw-semibold">Created</th>
                                <th class="fw-semibold">Status</th>
                                <th class="fw-semibold text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($properties as $p): ?>
                            <tr>
                                <td><?= $p->PropertyId ?></td>
                                <td>
                                    <div class="prop-title" title="<?= htmlspecialchars($p->PropertyTitle ?? '') ?>">
                                        <?= htmlspecialchars($p->PropertyTitle ?? '') ?: 'N/A' ?>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($p->OwnerName ?? '') ?: 'No Owner' ?></td>
                                <td><?= htmlspecialchars($p->PropertyType ?? '') ?: 'N/A' ?></td>
                                <td>
                                    <div class="prop-title" title="<?= htmlspecialchars($p->MailingAddress ?? '') ?>">
                                        <?= htmlspecialchars($p->MailingAddress ?? '') ?: 'N/A' ?>
                                    </div>
                                </td>
                                <td><?= number_format((float)($p->Price ?? 0), 2) ?></td>
                                <!-- <td><span class="badge bg-secondary"><?= $p->Views ?></span></td> -->
                                <td><span class="badge bg-info text-dark"><?= $p->DocsCompletion ?> files</span></td>
                                <td>
                                    <span class="badge bg-primary"><?= $p->ListType ?></span>
                                </td>
                                <td><?= !empty($p->CreatedDate) ? date('d M Y', strtotime($p->CreatedDate)) : 'N/A' ?></td>
                                <td>
                                    <select class="form-select form-select-sm status-select status-<?= strtolower($p->PropertyStatus) ?>" data-id="<?= $p->PropertyId ?>" onchange="updateStatus(this)">
                                        <option value="vacant" <?= $p->PropertyStatus == 'vacant' ? 'selected' : '' ?>>Vacant</option>
                                        <option value="occupied" <?= $p->PropertyStatus == 'occupied' ? 'selected' : '' ?>>Occupied</option>
                                        <option value="rented" <?= $p->PropertyStatus == 'rented' ? 'selected' : '' ?>>Rented</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="<?= site_url('Admin/property_details/'.$p->PropertyId) ?>" class="btn btn-sm btn-outline-primary">View / Edit</a>
                                    <button class="btn btn-sm btn-outline-danger ms-1" onclick="confirmDeleteProperty(<?= $p->PropertyId ?>)">Delete</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deletePropertyModal" tabindex="-1" aria-labelledby="deletePropertyModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-bold text-danger" id="deletePropertyModalLabel">Confirm Delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this property? This action can be undone later by an administrator.
            <input type="hidden" id="delete_property_id">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" onclick="executeDeleteProperty()">Delete</button>
          </div>
        </div>
      </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewPropertyModal" tabindex="-1" aria-labelledby="viewPropertyModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-bold" id="viewPropertyModalLabel">Property Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p><strong>Title:</strong> <span id="m_title"></span></p>
            <p><strong>Owner:</strong> <span id="m_owner"></span></p>
            <p><strong>Type:</strong> <span id="m_type"></span></p>
            <p><strong>Address:</strong> <span id="m_address"></span></p>
            <p><strong>Price:</strong> <span id="m_price"></span></p>
            <p><strong>Created:</strong> <span id="m_date"></span></p>
            <hr>
            <div class="alert alert-info py-2">
                <em>Note: Full edit capability will be added in the property editor module.</em>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>
    <script src="<?= base_url('assets/js/custom-alerts.js'); ?>"></script>
    
    <script>
        let deleteModalInstance;

        function confirmDeleteProperty(propertyId) {
            $('#delete_property_id').val(propertyId);
            deleteModalInstance = new bootstrap.Modal(document.getElementById('deletePropertyModal'));
            deleteModalInstance.show();
        }

        function executeDeleteProperty() {
            var propertyId = $('#delete_property_id').val();
            $.ajax({
                url: '<?= site_url("Admin/api_delete_property") ?>',
                type: 'POST',
                data: { property_id: propertyId },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        if (deleteModalInstance) {
                            deleteModalInstance.hide();
                        }
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Property deleted successfully',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', 'Failed to delete property', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Server error occurred', 'error');
                }
            });
        }

        $(document).ready(function() {
            $('.view-btn').on('click', function() {
                $('#m_title').text($(this).data('title'));
                $('#m_owner').text($(this).data('owner'));
                $('#m_price').text($(this).data('price'));
                $('#m_type').text($(this).data('type'));
                $('#m_address').text($(this).data('address'));
                $('#m_date').text($(this).data('date'));
                
                var myModal = new bootstrap.Modal(document.getElementById('viewPropertyModal'));
                myModal.show();
            });
        });

        function updateStatus(selectElement) {
            const propertyId = $(selectElement).data('id');
            const newStatus = $(selectElement).val();
            
            // Remove old status class and add new one for styling
            $(selectElement).removeClass('status-vacant status-occupied status-rented');
            $(selectElement).addClass('status-' + newStatus);

            $.ajax({
                url: '<?= site_url("Admin/api_update_property_status") ?>',
                type: 'POST',
                data: {
                    property_id: propertyId,
                    status: newStatus
                },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Status updated successfully',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        Swal.fire('Error', 'Failed to update status', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Server error occurred', 'error');
                }
            });
        }
    </script>
</body>
</html>

