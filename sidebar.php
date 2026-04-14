<div class="sidebar shadow-sm" style="width: 250px; background: #ffffff; height: 100vh; position: fixed; padding: 20px; border-right: 1px solid #dee2e6; z-index: 1000;">
    
    <div class="text-center mb-4">
        <img src="Academy_Logo.jpg" alt="PBA Logo" style="width: 70px; border-radius: 50%; border: 2px solid #198754;">
        <h6 class="mt-2 fw-bold text-success" style="font-size: 0.8rem;">PAG-ASA BIBLE<br>BAPTIST ACADEMY</h6>
    </div>
    
    <hr>

    <ul class="nav flex-column mt-3">
        <li class="nav-item mb-2">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php' ? 'active bg-success text-white rounded' : 'text-dark' ?>" href="admin_dashboard.php">
                <i class="fas fa-th-large mr-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'manage_students.php' ? 'active bg-success text-white rounded' : 'text-dark' ?>" href="manage_students.php">
                <i class="fas fa-user-graduate mr-2"></i> Students
            </a>
        </li>
           <li class="nav-item mb-2">
            <a class="nav-link text-dark" href="manage_teachers.php"><i class="fas fa-chalkboard-teacher mr-2"></i> Teachers</a>
        </li>

        <li class="nav-item mb-2">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'admin_approval.php' ? 'active bg-success text-white rounded' : 'text-dark' ?>" href="admin_approval.php">
                <i class="fas fa-clock mr-2"></i> Pending Approvals
                <?php
                    // Display Badge kung may pending (Optional logic)
                    $pending_count_query = "SELECT * FROM students WHERE status='Pending'";
                    $pending_count_res = mysqli_query($conn, $pending_count_query);
                    if(mysqli_num_rows($pending_count_res) > 0) {
                        echo '<span class="badge badge-danger float-right mt-1">'.mysqli_num_rows($pending_count_res).'</span>';
                    }
                ?>
            </a>
        </li>


        <li class="nav-item mb-2">
    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'manage_announcements.php' ? 'active bg-success text-white rounded' : 'text-dark' ?>" href="manage_announcements.php">
        <i class="fas fa-bullhorn mr-2"></i> Announcement
    </a>
</li>


        <hr>

        <li class="nav-item mt-3">
            <a class="nav-link text-danger fw-bold" href="logout.php">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </li>
    </ul>
</div>

<style>
    .nav-link:hover {
        background-color: #f8f9fa;
        color: #198754 !important;
        border-radius: 5px;
    }
    .nav-link.active {
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
</style>