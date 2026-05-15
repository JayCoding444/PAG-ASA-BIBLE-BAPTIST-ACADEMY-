<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<style>
    .sidebar { 
        width: 240px; 
        background: white; 
        height: 100vh; 
        padding: 25px 15px; 
        border-right: 1px solid #e0e0e0; 
        position: fixed; 
        z-index: 100; 
    }
    .logo-section { text-align: center; margin-bottom: 30px; }
    .logo-section img { width: 70px; margin-bottom: 10px; }
    .logo-section h6 { color: #2e7d32; font-weight: bold; font-size: 11px; line-height: 1.3; }

    .menu-item { 
        padding: 12px 18px; 
        border-radius: 12px; 
        color: #606770; 
        text-decoration: none !important; 
        display: flex; 
        align-items: center; 
        margin-bottom: 8px; 
        font-size: 14px; 
        transition: 0.3s; 
        font-weight: 500; 
    }
    .menu-item i { width: 25px; font-size: 16px; }
    .menu-item:hover { background-color: #f0f2f5; color: #2e7d32; }
    
    /* Green active indicator */
    .menu-item.active { 
        background-color: #2e7d32 !important; 
        color: white !important; 
        box-shadow: 0 4px 12px rgba(46,125,50,0.2); 
    }

    /* Spacer para sa logout sa ilalim */
    .sidebar-content {
        height: calc(100% - 150px);
        overflow-y: auto;
    }

    .sidebar-logout {
        position: absolute;
        bottom: 25px;
        left: 15px;
        right: 15px;
    }
    .btn-logout-outline {
        display: block;
        width: 100%;
        padding: 8px;
        text-align: center;
        border: 1px solid #e74c3c;
        color: #e74c3c;
        border-radius: 10px;
        text-decoration: none !important;
        font-weight: 600;
        font-size: 13px;
        transition: 0.3s;
    }
    .btn-logout-outline:hover { background: #e74c3c; color: white; }
</style>

<div class="sidebar">
    <div class="logo-section">
        <img src="Academy_Logo.jpg" alt="Logo"> 
        <h6>PAG-ASA BIBLE<br>BAPTIST ACADEMY</h6>
    </div>

    <div class="sidebar-content">
        <a href="student_dashboard.php" class="menu-item <?= ($current_page == 'student_dashboard.php') ? 'active' : ''; ?>">
            <i class="fas fa-th-large mr-2"></i> Dashboard
        </a>

        <a href="my_profile.php" class="menu-item <?= ($current_page == 'my_profile.php') ? 'active' : ''; ?>">
            <i class="fas fa-user-circle mr-2"></i> My Profile
        </a>

        <a href="enrolled_subjects.php" class="menu-item <?= ($current_page == 'enrolled_subjects.php') ? 'active' : ''; ?>">
            <i class="fas fa-book mr-2"></i> Subjects
        </a>

        <a href="student_announcement.php" class="menu-item <?= ($current_page == 'student_announcements.php') ? 'active' : ''; ?>">
            <i class="fas fa-bullhorn mr-2"></i> Announcement
        </a>

        <a href="student_attendance.php" class="menu-item <?= ($current_page == 'student_attendance.php') ? 'active' : ''; ?>">
            <i class="fas fa-user-check mr-2"></i> Attendance
        </a>

        <a href="student_account_settings.php" class="menu-item <?= ($current_page == 'student_account_settings.php') ? 'active' : ''; ?>">
            <i class="fas fa-cog mr-2"></i> Settings
        </a>
    </div>

    <div class="sidebar-logout">
        <a href="logout.php" class="btn-logout-outline">
            <i class="fas fa-sign-out-alt mr-1"></i> Logout
        </a>
    </div>
</div>