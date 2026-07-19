<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Under Development'; ?> - Free Real Estate</title>
    <?php $this->load->view('admin/components/css_links'); ?>
</head>
<body>

    <?php $this->load->view('admin/components/sidebar'); ?>

    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4 d-flex align-items-center justify-content-center" style="min-height: 80vh;">
            <div class="card shadow border-0 rounded-4 text-center" style="max-width: 500px; width: 100%;">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="fa-solid fa-person-digging text-primary" style="font-size: 5rem;"></i>
                    </div>
                    <h3 class="fw-bold mb-3 text-dark">Feature Under Development</h3>
                    <p class="text-muted mb-4">
                        We are working hard to bring you the <strong><?= $page_title ?? 'requested feature' ?></strong>. This module will be available in an upcoming update.
                    </p>
                    <a href="<?= site_url('Admin/dashboard') ?>" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                        <i class="fa-solid fa-arrow-left me-2"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>
</body>
</html>
