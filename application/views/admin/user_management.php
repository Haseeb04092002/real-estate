<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'User Management'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
    <style>
        .nav-pills .nav-link.active {
            background-color: #1F509A;
        }
        .user-avatar { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }
    </style>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">


            <!-- List View -->
            <div id="userListView" class="modern-card card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle init-datatable" id="usersTable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="fw-semibold">ID</th>
                                <th class="fw-semibold">Avatar</th>
                                <th class="fw-semibold">Name</th>
                                <th class="fw-semibold">Email</th>
                                <th class="fw-semibold">Verif. Status</th>
                                <th class="fw-semibold">Date</th>
                                <th class="fw-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $u): ?>
                            <tr>
                                <td><?= $u->ClientId ?></td>
                                <td><img src="<?= $u->ProfilePicture ? base_url('uploads/'.$u->ProfilePicture) : 'https://ui-avatars.com/api/?name='.urlencode($u->ClientName).'&background=1F509A&color=fff' ?>" class="user-avatar" alt="Avatar"></td>
                                <td><?= $u->ClientName ?></td>
                                <td><?= $u->EmailAddress ?><br><small><?= $u->PhoneNumber ?></small></td>
                                <td>
                                    <?php if(isset($u->VerificationStatus) && $u->VerificationStatus == 'Verified'): ?>
                                        <span class="badge bg-success">Verified</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d M Y', strtotime($u->RegistrationDate)) ?></td>
                                <td>
                                    <a href="<?= site_url('Admin/user_details/'.$u->ClientId) ?>" class="btn btn-sm btn-primary">View / Edit</a>
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

    <?php $this->load->view('admin/components/js_links'); ?>
    <script>
        const baseUrl = '<?= base_url() ?>';
        const siteUrl = '<?= site_url() ?>';
    </script>
    <script src="<?= base_url('assets/js/admin_users.js'); ?>"></script>
</body>
</html>
