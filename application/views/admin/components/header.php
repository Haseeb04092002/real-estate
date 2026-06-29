<?php 
$current_segment = $this->uri->segment(2) ?? '';
if($this->uri->segment(1) == 'Admin_Property_Docs') {
    $current_segment = 'Property Documents';
} elseif($this->uri->segment(1) == 'Admin_User_Verifications') {
    $current_segment = 'User Verifications';
}

$display_title = ucwords(str_replace('_', ' ', $current_segment));
if(empty($display_title) || $display_title == 'Dashboard') {
    $display_title = 'Dashboard and Analytics';
}
?>
<div class="admin-navbar">
    <div class="d-flex align-items-center">
        <button id="sidebarToggle" class="toggle-btn">
            <i class="fa-solid fa-bars"></i>
        </button>
        <h4 class="mb-0 ms-3 fw-bold text-primary"><?= $display_title ?></h4>
    </div>
    
    <div class="d-flex align-items-center">
        <a href="<?= site_url('Properties'); ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-3" target="_blank">
            <i class="fa-solid fa-globe me-1"></i> Go back to website
        </a>
        <span class="me-3 fw-semibold text-dark"><i class="fa-solid fa-user-shield me-2 text-primary"></i> Administrator</span>
        <a href="<?= site_url('Admin/logout'); ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3">
            <i class="fa-solid fa-sign-out-alt me-1"></i> Logout
        </a>
    </div>
</div>
