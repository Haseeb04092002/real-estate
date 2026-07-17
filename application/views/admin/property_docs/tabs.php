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
    <!-- <li class="nav-item">
        <a class="nav-link <?= (isset($active_tab) && $active_tab == 'analytics') ? 'active' : '' ?>" href="<?= site_url('Admin_Property_Docs/analytics') ?>"><i class="fa-solid fa-chart-pie me-2"></i> Analytics Dashboard</a>
    </li> -->
    <li class="nav-item">
        <a class="nav-link <?= (isset($active_tab) && $active_tab == 'types') ? 'active' : '' ?>" href="<?= site_url('Admin_Property_Docs/types') ?>"><i class="fa-solid fa-tags me-2"></i> Document Types</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= (isset($active_tab) && $active_tab == 'queue') ? 'active' : '' ?>" href="<?= site_url('Admin_Property_Docs/queue') ?>"><i class="fa-solid fa-list-check me-2"></i> Review Queue</a>
    </li>
</ul>
