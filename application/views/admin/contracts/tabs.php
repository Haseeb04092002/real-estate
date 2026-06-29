<style>
    .nav-modern {
        background: white;
        padding: 10px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        margin-bottom: 25px;
    }
    .nav-modern .nav-link {
        color: #6c757d;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s;
        border: none;
    }
    .nav-modern .nav-link:hover {
        background-color: #f1f3f5;
    }
    .nav-modern .nav-link.active {
        background-color: #1F509A;
        color: white;
        box-shadow: 0 4px 10px rgba(31, 80, 154, 0.3);
    }
</style>
<ul class="nav nav-pills nav-modern mb-4">
    <li class="nav-item">
        <a class="nav-link <?= (isset($active_tab) && $active_tab == 'analytics') ? 'active' : '' ?>" href="<?= site_url('Admin/contract_management') ?>"><i class="fa-solid fa-chart-pie me-2"></i> Analytics</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= (isset($active_tab) && $active_tab == 'types') ? 'active' : '' ?>" href="<?= site_url('Admin/contract_types') ?>"><i class="fa-solid fa-tags me-2"></i> Contract Types</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= (isset($active_tab) && $active_tab == 'templates') ? 'active' : '' ?>" href="<?= site_url('Admin/contract_templates') ?>"><i class="fa-solid fa-file-contract me-2"></i> Templates</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= (isset($active_tab) && $active_tab == 'clauses') ? 'active' : '' ?>" href="<?= site_url('Admin/contract_clauses') ?>"><i class="fa-solid fa-gavel me-2"></i> Legal Clauses</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= (isset($active_tab) && $active_tab == 'generated') ? 'active' : '' ?>" href="<?= site_url('Admin/generated_contracts') ?>"><i class="fa-solid fa-file-signature me-2"></i> Generated Contracts</a>
    </li>
</ul>
