<div class="col-md-3 col-lg-2 sidebar-offcanvas pl-0" id="sidebar" role="navigation" style="background-color: #fff; min-height: 100vh; border-right: 1px solid #e9ecef;">
    <div class="sidebar-header text-center py-4">
        <img src="assets/img/logo.png" alt="Logo" style="width: 80px; margin-bottom: 10px;">
        <h6 class="font-weight-bold" style="color: #004d26; font-size: 14px;">PAG-ASA BIBLE BAPTIST ACADEMY</h6>
        <p class="text-uppercase mb-0" style="font-size: 11px; letter-spacing: 1px; color: #1a5cff; font-weight: 700;">Teacher Portal</p>
    </div>

    <ul class="nav flex-column sticky-top pl-0 pt-2 mt-3">
        <li class="nav-item mb-2">
            <a class="nav-link py-3 px-4 d-flex align-items-center <?= basename($_SERVER['PHP_SELF']) == 'teacher_dashboard.php' ? 'active-link' : ''; ?>" href="teacher_dashboard.php" style="color: #495057; font-weight: 500; transition: 0.3s;">
                <i class="fas fa-th-large mr-3" style="width: 20px;"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item mb-2">
    <a class="nav-link py-3 px-4 d-flex align-items-center" href="teacher_input_grades.php">
        <i class="fas fa-edit mr-3"></i>
        <span>Input Grades</span>
    </a>
</li>

        <li class="nav-item mb-2">
            <a class="nav-link py-3 px-4 d-flex align-items-center <?= basename($_SERVER['PHP_SELF']) == 'teacher_class_schedule.php' ? 'active-link' : ''; ?>" href="teacher_class_schedule.php" style="color: #495057; font-weight: 500; transition: 0.3s;">
                <i class="fas fa-calendar-alt mr-3" style="width: 20px;"></i>
                <span>Class Schedule</span>
            </a>
        </li>

        <hr class="mx-4 my-4" style="border-top: 1px solid #e9ecef;">

        <li class="nav-item mt-auto">
            <a class="nav-link py-3 px-4 d-flex align-items-center text-danger" href="logout.php" style="font-weight: 600;">
                <i class="fas fa-sign-out-alt mr-3" style="width: 20px;"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>

<style>
    /* Design consistency para sa active page */
    .active-link {
        background: #1a5cff !important;
        color: #fff !important;
        border-radius: 0 50px 50px 0;
        box-shadow: 0 4px 12px rgba(26, 92, 255, 0.2);
    }
    
    .nav-link:hover:not(.active-link) {
        background-color: #f8f9fa;
        color: #1a5cff !important;
        border-radius: 0 50px 50px 0;
    }
</style>