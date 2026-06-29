<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Ads Management'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
    <style>
        .page-header {
            background: linear-gradient(135deg, #1F509A 0%, #153a75 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(31, 80, 154, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .stat-card h3 { margin: 0; font-weight: 700; font-size: 28px; }
        .stat-card small { opacity: 0.8; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; }
        
        .table > :not(caption) > * > * { padding: 1rem 1rem; }
        
        .ad-thumbnail {
            width: 80px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }
    </style>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">
            
            <!-- Header & Stats -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-flex justify-content-start gap-3">
                            <div class="stat-card text-center">
                                <h3><?= $stats['total_active'] ?></h3>
                                <small>Active Ads</small>
                            </div>
                            <div class="stat-card text-center">
                                <h3><?= number_format($stats['total_impressions']) ?></h3>
                                <small>Total Impressions</small>
                            </div>
                            <div class="stat-card text-center">
                                <h3><?= number_format($stats['total_clicks']) ?></h3>
                                <small>Total Clicks</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs & Actions -->
            <div class="nav-modern justify-content-between">
                <ul class="nav nav-pills nav-items-wrapper m-0 p-0" id="adTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-status="all" type="button"><i class="fa-solid fa-list me-2"></i> All Ads</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-status="Active" type="button"><i class="fa-solid fa-circle-check me-2"></i> Active</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-status="Paused" type="button"><i class="fa-solid fa-pause-circle me-2"></i> Paused</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-status="Expired" type="button"><i class="fa-solid fa-clock me-2"></i> Expired</button>
                    </li>
                </ul>
                <button class="btn btn-primary px-4 py-2" onclick="openAdModal()"><i class="fa-solid fa-plus me-2"></i> Create New Ad</button>
            </div>

            <!-- Main Content -->
            <div class="modern-card">
                
                <div class="p-4">
                    <table id="adsTable" class="table table-hover align-middle w-100">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="fw-semibold">ID</th>
                                <th class="fw-semibold">Banner</th>
                                <th class="fw-semibold">Ad Details</th>
                                <th class="fw-semibold">Timeline</th>
                                <th class="fw-semibold">Performance</th>
                                <th class="fw-semibold">Status</th>
                                <th class="fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <!-- Add/Edit Ad Modal -->
    <div class="modal fade" id="adModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius:15px;">
                <div class="modal-header bg-light border-0 py-3 px-4">
                    <h5 class="modal-title fw-bold" id="adModalTitle"><i class="fa-solid fa-bullhorn text-primary me-2"></i> Create Advertisement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="adForm" enctype="multipart/form-data">
                        <input type="hidden" name="AdId" id="ad_id">
                        
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold small text-uppercase text-muted">Campaign Title</label>
                                <input type="text" class="form-control" name="Title" id="ad_title" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">Ad Type</label>
                                <select class="form-select" name="AdType" id="ad_type" required>
                                    <option value="Banner">Banner Image</option>
                                    <option value="Sidebar">Sidebar Image</option>
                                    <option value="Featured Property">Featured Property</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Start Date</label>
                                <input type="date" class="form-control" name="StartDate" id="ad_start" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">End Date</label>
                                <input type="date" class="form-control" name="EndDate" id="ad_end" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-uppercase text-muted">Target URL</label>
                                <input type="url" class="form-control" name="TargetUrl" id="ad_url" placeholder="https://example.com" required>
                            </div>
                        </div>

                        <div class="row mb-3" id="referenceIdGroup" style="display:none;">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-uppercase text-muted">Property ID (For Featured Properties)</label>
                                <input type="number" class="form-control" name="ReferenceId" id="ad_ref_id" placeholder="Enter Property ID">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label fw-bold small text-uppercase text-muted">Banner Image</label>
                                <input type="file" class="form-control" name="ImageFile" id="ad_image" accept="image/*">
                                <small class="text-muted">Recommended: 1200x300 for Banners, 300x600 for Sidebar.</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-uppercase text-muted">Status</label>
                                <select class="form-select" name="Status" id="ad_status">
                                    <option value="Active">Active</option>
                                    <option value="Paused">Paused</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end border-top pt-3 mt-2">
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary px-4" id="saveAdBtn">Save Advertisement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>
    <script src="<?= base_url('assets/js/custom-alerts.js'); ?>"></script>

    <script>
        let adsTable;
        let currentStatus = 'all';

        $(document).ready(function() {
            initTable();

            // Handle Tab Clicks
            $('.nav-modern .nav-link').on('click', function() {
                $('.nav-modern .nav-link').removeClass('active');
                $(this).addClass('active');
                currentStatus = $(this).data('status');
                loadAds();
            });

            // Handle Ad Type Change
            $('#ad_type').on('change', function() {
                if($(this).val() === 'Featured Property') {
                    $('#referenceIdGroup').slideDown();
                    $('#ad_image').removeAttr('required');
                } else {
                    $('#referenceIdGroup').slideUp();
                    if(!$('#ad_id').val()) {
                        $('#ad_image').attr('required', 'required');
                    }
                }
            });

            // Handle Form Submit
            $('#adForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let btn = $('#saveAdBtn');
                let originalText = btn.html();
                
                btn.html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Saving...').prop('disabled', true);
                
                $.ajax({
                    url: '<?= site_url("Admin/api_save_ad") ?>',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        btn.html(originalText).prop('disabled', false);
                        if(response.success) {
                            $('#adModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Saved',
                                text: 'Advertisement saved successfully.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loadAds();
                        } else {
                            Swal.fire('Error', response.message || 'Failed to save.', 'error');
                        }
                    },
                    error: function() {
                        btn.html(originalText).prop('disabled', false);
                        Swal.fire('Error', 'Server error.', 'error');
                    }
                });
            });
        });

        function initTable() {
            adsTable = $('#adsTable').DataTable({
                "pageLength": 10,
                "ordering": false,
                "responsive": true,
                "language": {
                    "emptyTable": "No advertisements found."
                }
            });
            loadAds();
        }

        function loadAds() {
            $.ajax({
                url: '<?= site_url("Admin/api_get_ads") ?>',
                type: 'GET',
                data: { status: currentStatus },
                dataType: 'json',
                success: function(response) {
                    adsTable.clear();
                    if(response.data && response.data.length > 0) {
                        response.data.forEach(function(ad) {
                            
                            let imageHtml = ad.ImagePath 
                                ? `<img src="<?= base_url('uploads/') ?>${ad.ImagePath}" class="ad-thumbnail">` 
                                : `<div class="ad-thumbnail bg-light d-flex align-items-center justify-content-center text-muted"><i class="fa-solid fa-image"></i></div>`;

                            let detailsHtml = `
                                <strong>${ad.Title}</strong><br>
                                <span class="badge bg-light text-dark border mt-1">${ad.AdType}</span>
                                ${ad.ReferenceId ? `<br><small class="text-muted">Prop ID: ${ad.ReferenceId}</small>` : ''}
                            `;

                            let timelineHtml = `
                                <small class="text-muted d-block"><i class="fa-regular fa-calendar me-1"></i> Start: <strong class="text-dark">${ad.StartDate}</strong></small>
                                <small class="text-muted d-block"><i class="fa-regular fa-calendar-xmark me-1"></i> End: <strong class="text-dark">${ad.EndDate}</strong></small>
                            `;

                            let perfHtml = `
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa-solid fa-eye text-primary me-2" style="width:15px;"></i> 
                                    <strong>${ad.Impressions}</strong> <span class="text-muted small ms-1">Views</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-hand-pointer text-success me-2" style="width:15px;"></i> 
                                    <strong>${ad.Clicks}</strong> <span class="text-muted small ms-1">Clicks</span>
                                </div>
                            `;

                            let isChecked = ad.Status === 'Active' ? 'checked' : '';
                            let disabled = ad.Status === 'Expired' ? 'disabled' : '';
                            
                            let statusHtml = `
                                <div class="form-check form-switch d-flex justify-content-start p-0">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" onchange="toggleStatus(${ad.AdId}, this)" ${isChecked} ${disabled} style="width:2.5em; height:1.25em; cursor:pointer;">
                                    <span class="badge ${ad.Status === 'Active' ? 'bg-success' : (ad.Status === 'Paused' ? 'bg-warning text-dark' : 'bg-danger')}">${ad.Status}</span>
                                </div>
                            `;

                            let actionsHtml = `
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-light border text-primary" onclick='editAd(${JSON.stringify(ad)})' title="Edit"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn btn-sm btn-light border text-danger" onclick="deleteAd(${ad.AdId})" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            `;

                            adsTable.row.add([
                                `#${ad.AdId}`,
                                imageHtml,
                                detailsHtml,
                                timelineHtml,
                                perfHtml,
                                statusHtml,
                                actionsHtml
                            ]);
                        });
                    }
                    adsTable.draw();
                }
            });
        }

        function openAdModal() {
            $('#adForm')[0].reset();
            $('#ad_id').val('');
            $('#adModalTitle').html('<i class="fa-solid fa-bullhorn text-primary me-2"></i> Create Advertisement');
            $('#referenceIdGroup').hide();
            $('#ad_image').attr('required', 'required');
            $('#adModal').modal('show');
        }

        function editAd(ad) {
            $('#adForm')[0].reset();
            $('#adModalTitle').html('<i class="fa-solid fa-pen text-primary me-2"></i> Edit Advertisement');
            
            $('#ad_id').val(ad.AdId);
            $('#ad_title').val(ad.Title);
            $('#ad_type').val(ad.AdType).trigger('change');
            $('#ad_ref_id').val(ad.ReferenceId);
            $('#ad_url').val(ad.TargetUrl);
            $('#ad_start').val(ad.StartDate);
            $('#ad_end').val(ad.EndDate);
            $('#ad_status').val(ad.Status);
            
            $('#ad_image').removeAttr('required');
            
            $('#adModal').modal('show');
        }

        function toggleStatus(id, checkbox) {
            let newStatus = checkbox.checked ? 'Active' : 'Paused';
            $.post('<?= site_url("Admin/api_update_ad_status") ?>', { AdId: id, Status: newStatus }, function(res) {
                let response = JSON.parse(res);
                if(response.success) {
                    loadAds(); // Refresh to update badges and table correctly
                } else {
                    checkbox.checked = !checkbox.checked; // Revert
                    Swal.fire('Error', 'Failed to update status', 'error');
                }
            });
        }

        function deleteAd(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This advertisement will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('<?= site_url("Admin/api_delete_ad") ?>', { AdId: id }, function(res) {
                        let response = JSON.parse(res);
                        if(response.success) {
                            Swal.fire('Deleted!', 'Advertisement has been deleted.', 'success');
                            loadAds();
                        } else {
                            Swal.fire('Error', 'Failed to delete advertisement.', 'error');
                        }
                    });
                }
            })
        }
    </script>
</body>
</html>

