<?php 
$current_page = $this->uri->segment(2) ?? '';
$docs_page = $this->uri->segment(1) == 'Admin_Property_Docs' ? 'analytics' : '';
$verify_page = $this->uri->segment(1) == 'Admin_User_Verifications' ? 'rules' : '';

$is_user_mgmt = in_array($current_page, ['user_management', 'user_details']);
$is_prop_mgmt = in_array($current_page, ['property_management', 'property_details']);
$is_contract_mgmt = in_array($current_page, ['contract_management', 'contract_types', 'contract_templates', 'contract_clauses', 'generated_contracts']);
?>
<style>
    .sidebar-link.active,
    .sidebar-link:hover {
        background-color: #c7e2fb !important;
        color: #000 !important;
        border-radius: 8px;
    }
    .sidebar-link.active i,
    .sidebar-link:hover i {
        color: #000 !important;
    }
</style>
<div class="admin-sidebar shadow-sm">
    <div class="sidebar-header d-flex align-items-center justify-content-center" style="padding: 15px;">
        <img src="<?= base_url('assets/images/Fre-logo.png'); ?>" alt="Free Real Estate Admin" class="img-fluid me-2" style="max-height: 40px; object-fit: contain;">
        <div>
            <h5 class="m-0 fw-bold" style="color: #1F509A; white-space: nowrap; line-height: 1;">Free Real Estate</h5>
            <span style="font-size: 0.75rem; color: #6c757d; font-weight: 600; display: block; text-align: left; padding-left: 1px; letter-spacing: 1px;">Australia</span>
        </div>
    </div>
    
    <div class="sidebar-menu">
        <!-- 1. Dashboard and Analytics -->
        <a href="<?= site_url('Admin/dashboard'); ?>" class="sidebar-link <?= ($current_page == 'dashboard') ? 'active' : '' ?>">
            <i class="fa-solid fa-gauge icon-left"></i> 
            <span>Dashboard</span>
        </a>

        <!-- 2. User Management -->
        <a href="<?= site_url('Admin/user_management'); ?>" class="sidebar-link <?= $is_user_mgmt ? 'active' : '' ?>">
            <i class="fa-solid fa-user-group icon-left"></i>
            <span>User Management</span>
        </a>

        <!-- User Verifications -->
        <li class="sidebar-item" style="list-style: none;">
            <a href="<?= site_url('Admin_User_Verifications/rules') ?>" class="sidebar-link <?= ($verify_page == 'rules') ? 'active' : '' ?>">
                <i class="fa-solid fa-user-check icon-left"></i>
                <span>User Verifications</span>
            </a>
        </li>

        <a href="<?= site_url('Admin/property_management'); ?>" class="sidebar-link <?= $is_prop_mgmt ? 'active' : '' ?>">
            <i class="fa-solid fa-building icon-left"></i>
            <span>Property Management</span>
        </a>

        <!-- Property Settings -->
        <a href="<?= site_url('Admin/property_settings'); ?>" class="sidebar-link <?= ($current_page == 'property_settings') ? 'active' : '' ?>">
            <i class="fa-solid fa-cogs icon-left"></i>
            <span>Property Settings</span>
        </a>

        <!-- Property Documents -->
        <li class="sidebar-item" style="list-style: none;">
            <a href="<?= site_url('Admin_Property_Docs/types') ?>" class="sidebar-link <?= ($docs_page == 'analytics') ? 'active' : '' ?>">
                <i class="fa-solid fa-folder-open icon-left"></i>
                <span>Property Documents</span>
            </a>
        </li>

        <!-- Contract Management -->
        <li class="sidebar-item" style="list-style: none;">
            <a href="<?= site_url('Admin/contract_types') ?>" class="sidebar-link <?= $is_contract_mgmt ? 'active' : '' ?>">
                <i class="fa-solid fa-file-signature icon-left"></i>
                <span>Contract Management</span>
            </a>
        </li>

        <!-- 4. Payment and Billing -->
        <a href="<?= site_url('Admin/payment_billing') ?>" class="sidebar-link <?= ($current_page == 'payment_billing') ? 'active' : '' ?>">
            <i class="fa-solid fa-file-invoice-dollar icon-left"></i>
            <span>Payment and Billing</span>
        </a>

        <!-- 7. Review Rating -->
        <a href="<?= site_url('Admin/review_rating') ?>" class="sidebar-link <?= ($current_page == 'review_rating') ? 'active' : '' ?>">
            <i class="fa-solid fa-star icon-left"></i>
            <span>Review Rating</span>
        </a>

        <!-- 8. Support Ticket -->
        <a href="<?= site_url('Admin/support_ticket') ?>" class="sidebar-link <?= ($current_page == 'support_ticket') ? 'active' : '' ?>">
            <i class="fa-solid fa-headset icon-left"></i>
            <span>Support Ticket</span>
        </a>

        <!-- 5. Ads Management -->
        <a href="<?= site_url('Admin/ads_management'); ?>" class="sidebar-link <?= ($current_page == 'ads_management') ? 'active' : '' ?>">
            <i class="fa-solid fa-bullhorn icon-left"></i>
            <span>Ads Management</span>
        </a>

        <!-- 6. Blogs Management -->
        <a href="<?= site_url('Admin/blogs_management'); ?>" class="sidebar-link <?= ($current_page == 'blogs_management') ? 'active' : '' ?>">
            <i class="fa-solid fa-blog icon-left"></i>
            <span>Blogs Management</span>
        </a>

        
    </div>
</div>
