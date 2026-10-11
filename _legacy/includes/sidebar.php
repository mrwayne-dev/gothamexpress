<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /admin/auth.login');
    exit;
}
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' | TruePath Admin' : 'TruePath Admin'; ?></title>

    <link rel="icon" type="image/png" href="/assets/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="shortcut icon" href="/assets/favicon/favicon.ico">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="/assets/css/admin/styles.css">

    <!-- Phosphor Icons -->
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/bold/style.css">
</head>
<body>
    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="preloader-spinner"></div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <div class="admin-layout">
        <!-- Sidebar Overlay (mobile) -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-logo">
                <a href="/admin.dashboard">
                    <img src="/assets/images/logo/3.png" alt="TruePath Express">
                </a>
                <button class="sidebar-close" id="sidebarClose">
                    <i class="ph-bold ph-x"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                <div class="sidebar-heading">Navigation</div>
                <ul>
                    <li>
                        <a href="/admin.dashboard" class="sidebar-link <?php echo $currentPage === 'dashboard' ? 'active' : ''; ?>">
                            <i class="ph-bold ph-squares-four"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin.packages" class="sidebar-link <?php echo $currentPage === 'packages' ? 'active' : ''; ?>">
                            <i class="ph-bold ph-package"></i>
                            <span>Packages</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin.transactions" class="sidebar-link <?php echo $currentPage === 'transaction' ? 'active' : ''; ?>">
                            <i class="ph-bold ph-credit-card"></i>
                            <span>Transactions</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <button class="sidebar-logout" id="logoutBtn">
                    <i class="ph-bold ph-sign-out"></i>
                    <span>Log Out</span>
                </button>
            </div>
        </aside>

        <!-- Main -->
        <div class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="mobile-menu-btn" id="mobileMenuBtn">
                        <i class="ph-bold ph-list"></i>
                    </button>
                    <h1><?php echo isset($pageTitle) ? $pageTitle : 'Dashboard'; ?></h1>
                </div>
                <div class="header-right">
                    <div class="header-user">
                        <button class="header-user-btn" id="userDropdownBtn">
                            <span class="header-avatar">
                                <i class="ph-bold ph-user"></i>
                            </span>
                            <span class="header-user-info">
                                <span class="header-user-name"><?php echo htmlspecialchars($_SESSION['email'] ?? 'Admin'); ?></span>
                                <span class="header-user-role">Admin</span>
                            </span>
                        </button>
                        <div class="header-dropdown" id="userDropdown">
                            <a href="/admin.dashboard">Dashboard</a>
                            <a href="/admin.packages">Packages</a>
                            <a href="/admin.transactions">Transactions</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="text-danger" id="dropdownLogout">Log out</a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="admin-content">
