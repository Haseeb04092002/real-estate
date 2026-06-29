<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- FontAwesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/Fre-logo.png'); ?>">
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f4f7fa;
        overflow-x: hidden;
    }

    .modern-card {
        background: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        margin-bottom: 25px;
        overflow: hidden;
    }
    
    .nav-modern {
        background: white;
        padding: 10px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }
    .nav-modern .nav-items-wrapper {
        display: flex;
        gap: 5px;
    }
    .nav-modern .nav-link {
        color: #6c757d;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s;
        border: none;
        background: transparent;
    }
    .nav-modern .nav-link:hover {
        background-color: #f1f3f5;
        color: #1F509A;
    }
    .nav-modern .nav-link.active {
        background-color: #1F509A;
        color: white;
        box-shadow: 0 4px 10px rgba(31, 80, 154, 0.3);
    }

    /* Sidebar Styles */
    .admin-sidebar {
        min-height: 100vh;
        width: 280px;
        background: #f4f9fd; /* Light blue background */
        color: #1a2b4c;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        transition: all 0.3s;
        box-shadow: 2px 0 15px rgba(0,0,0,0.03);
    }
    
    .admin-sidebar .sidebar-header {
        padding: 25px 20px 15px 20px;
        text-align: left;
        background: transparent;
        border-bottom: none;
    }
    
    .admin-sidebar .sidebar-menu {
        padding: 0 15px 20px 15px;
        height: calc(100vh - 85px);
        overflow-y: auto;
    }

    /* Custom Scrollbar for Sidebar */
    .admin-sidebar .sidebar-menu::-webkit-scrollbar {
        width: 6px;
    }
    .admin-sidebar .sidebar-menu::-webkit-scrollbar-track {
        background: transparent; 
    }
    .admin-sidebar .sidebar-menu::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.1); 
        border-radius: 10px;
    }
    
    .sidebar-link {
        color: #1a2b4c;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 14px 15px;
        font-size: 15px;
        font-weight: 500;
        transition: 0.2s;
        border-radius: 8px;
        border-bottom: 1px solid rgba(0,0,0,0.04);
        margin-bottom: 2px;
    }
    
    .sidebar-link:hover {
        background: rgba(0,0,0,0.03);
        color: #1a2b4c;
    }

    .sidebar-link.active {
        background: linear-gradient(135deg, #dcecfe 0%, #c1dffa 100%);
        color: #1a2b4c;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05), inset 0 1px 0 rgba(255,255,255,0.5);
        border-bottom: none;
        margin-bottom: 6px;
    }
    
    .sidebar-link .icon-left {
        width: 25px;
        text-align: center;
        margin-right: 15px;
        font-size: 18px;
        color: #3b4e68;
    }

    .sidebar-link.active .icon-left {
        color: #1a2b4c;
    }

    .sidebar-link .icon-right {
        font-size: 12px;
        color: #8c9bb0;
        margin-left: auto;
        transition: transform 0.3s;
    }

    .submenu {
        background: rgba(0,0,0,0.15);
        padding: 0;
        list-style: none;
        display: none;
    }

    .sidebar-link[aria-expanded="true"] + .submenu {
        display: block;
    }

    .submenu .sidebar-link {
        padding: 10px 20px 10px 50px;
        font-size: 14px;
        border-left: none;
    }

    .submenu .sidebar-link:hover {
        background: rgba(255,255,255,0.05);
    }
    
    /* Main Content Wrapper */
    .admin-wrapper {
        margin-left: 280px;
        width: calc(100% - 280px);
        min-height: 100vh;
        transition: all 0.3s;
    }
    
    /* Top Navbar */
    .admin-navbar {
        background: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 999;
    }
    
    .admin-navbar .toggle-btn {
        background: none;
        border: none;
        font-size: 20px;
        color: #1F509A;
        cursor: pointer;
    }

    /* Cards & Widgets */
    .dashboard-card {
        background: #fff;
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.03);
        margin-bottom: 20px;
    }
    
    .dashboard-card .card-body {
        padding: 20px;
    }
    
    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    
    /* Desktop Sidebar Toggled (Mini Sidebar) */
    @media (min-width: 769px) {
        .sidebar-toggled .admin-sidebar {
            width: 80px;
            left: 0;
        }
        .sidebar-toggled .sidebar-header {
            text-align: center;
            padding: 25px 10px 15px 10px;
        }
        .sidebar-toggled .sidebar-header img {
            display: none;
        }
        .sidebar-toggled .sidebar-header::after {
            content: '\f015'; /* Home icon as a placeholder for mini logo */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 24px;
            color: #1F509A;
        }
        .sidebar-toggled .sidebar-link span {
            display: none;
        }
        .sidebar-toggled .sidebar-link .icon-left {
            margin-right: 0;
            font-size: 20px;
        }
        .sidebar-toggled .sidebar-link {
            justify-content: center;
            padding: 14px 0;
        }
        .sidebar-toggled .admin-wrapper {
            margin-left: 80px;
            width: calc(100% - 80px);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-sidebar {
            left: -280px;
        }
        .admin-wrapper {
            margin-left: 0;
            width: 100%;
        }
        .sidebar-toggled .admin-sidebar {
            left: 0;
        }
        .sidebar-toggled .admin-wrapper {
            margin-left: 280px; /* Or you can leave it full width depending on layout preference */
        }
    }
</style>
