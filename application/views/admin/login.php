<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Free Real Estate</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: #fff;
            padding: 30px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-admin {
            background-color: #1F509A;
            color: #fff;
            font-weight: 600;
        }
        .btn-admin:hover {
            background-color: #153A70;
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <div class="d-flex align-items-center justify-content-center mb-3">
                <img src="<?= base_url('assets/images/Fre-logo.png'); ?>" alt="Free Real Estate Logo" class="img-fluid me-2" style="max-height: 50px; object-fit: contain;">
                <div>
                    <h3 class="m-0 fw-bold" style="color: #1F509A; line-height: 1;">Free Real Estate</h3>
                    <span style="font-size: 0.85rem; color: #6c757d; font-weight: 600; display: block; text-align: left; padding-left: 2px; letter-spacing: 1px;">Australia</span>
                </div>
            </div>
            <p class="text-muted small">Enter password to access the admin portal</p>
        </div>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger text-center py-2">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <?= form_open('Admin/login'); ?>
            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fa-solid fa-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Admin Password" required autofocus>
                </div>
            </div>
            <button type="submit" class="btn btn-admin w-100 py-2">Login</button>
        <?= form_close(); ?>

        <div class="text-center mt-3">
            <a href="<?= site_url('Properties'); ?>" class="text-decoration-none text-muted small"><i class="fa-solid fa-arrow-left me-1"></i> Back to Website</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
