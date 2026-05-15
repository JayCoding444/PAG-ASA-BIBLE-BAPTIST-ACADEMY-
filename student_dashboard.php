<?php
session_start();
include('db_connect.php'); 

// 1. Check Authentication (Dapat ito lang ang nasa loob nito)
if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != 'Student'){
    header("Location: login.php");  
    exit(); 
}

$user_id = $_SESSION['auth_user']['user_id'];

// 2. Kunin ang Student Data (Dapat nasa labas ito ng auth check)
$query = "SELECT u.*, s.* FROM users u 
          LEFT JOIN students s ON u.id = s.user_id 
          WHERE u.id = '$user_id' LIMIT 1";
$query_run = mysqli_query($conn, $query);

if($query_run && mysqli_num_rows($query_run) > 0) { 
    $student = mysqli_fetch_array($query_run);
    
    // Kunin ang stats para sa Graph
    $gen_ave = $student['general_average'] ?? 0;
    $attendance_percentage = 92; // Temporary sample value
    $enrolled_count = 8;        // Temporary sample value
    
    $full_name = $student['full_name'] ?? $_SESSION['auth_user']['user_name'];
}

// 3. Greeting at Date Logic (Dapat laging active ito)
date_default_timezone_set('Asia/Manila');
$hour = date('H');
if ($hour < 12) {
    $greeting = "Good Morning";
} elseif ($hour < 18) {
    $greeting = "Good Afternoon";
} else {
    $greeting = "Good Evening";
}
$current_date = date('l, F j, Y');


$user_id = $_SESSION['auth_user']['user_id'];

// Dapat u.* (users) at s.* (students) para makuha lahat ng columns
$query = "SELECT u.*, s.* FROM users u 
          LEFT JOIN students s ON u.id = s.user_id 
          WHERE u.id = '$user_id' LIMIT 1";

$query_run = mysqli_query($conn, $query);

if($query_run) { 
    $student = mysqli_fetch_array($query_run);
    
    // Fallback values: Kung wala pang data sa 'students' table, kukunin muna sa 'users' o session
    $full_name = $student['full_name'] ?? $_SESSION['auth_user']['user_name'];
    $email = $student['email'] ?? $_SESSION['auth_user']['user_email'];
    
    // Accurate Details (Ito yung nanggagaling sa registration/admin update)
    $student_id = !empty($student['student_id']) ? $student['student_id'] : "Not Assigned";
    $level = !empty($student['grade_level']) ? $student['grade_level'] : "N/A";
    $section = !empty($student['section']) ? $student['section'] : "N/A";
    $gender = !empty($student['gender']) ? $student['gender'] : "N/A";
    $address = !empty($student['address']) ? $student['address'] : "No Address Provided";
    
    // Image handling (One step at a time, hindi muna natin gagalawin ang logic nito gaya ng request mo)
    $image = !empty($student['image']) ? $student['image'] : 'default-avatar.png';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="UTF-8">
    <title>Student Dashboard - PBA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; display: flex; font-family: 'Segoe UI', sans-serif; }
        .main-content { margin-left: 240px; width: 100%; min-height: 100vh; }
        .top-header { background: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; }
        .user-top img { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #2e7d32; }
        .dashboard-body { padding: 30px; }
        .announcement-banner { background: white; border-left: 5px solid #2e7d32; border-radius: 15px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .stat-card { background: white; padding: 20px; border-radius: 15px; display: flex; align-items: center; gap: 15px; height: 100%; }
        .stat-icon { width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; background: #f1f3f5; }
        .profile-img { width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 4px solid #f8f9fa; }
        .top-avatar-initials { 
    width: 35px; 
    height: 35px; 
    border-radius: 50%; 
    background: #2e7d32; 
    color: white; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-weight: bold; 
    font-size: 14px; 
    border: 2px solid #1b5e20; 
}
.progress {
    height: 6px;
    background-color: #e9ecef;
    border-radius: 10px;
    margin-top: 10px;
}

.progress-bar {
    border-radius: 10px;
}
    </style>
</head>
<body>

<?php include('student_sidebar.php'); ?>

<div class="main-content">
    <div class="top-header">
        <div class="font-weight-bold text-muted small">STUDENT PORTAL</div>
        <div class="user-top d-flex align-items-center">
    <span class="mr-2 small font-weight-bold"><?= $full_name; ?></span>
    
    <?php if(!empty($image) && file_exists("uploads/".$image)): ?>
        <img src="uploads/<?= $image; ?>" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #2e7d32;">
    <?php else: ?>
        <div class="top-avatar-initials"><?= strtoupper(substr($full_name, 0, 1)); ?></div>
    <?php endif; ?>
</div>
    </div>

    <div class="dashboard-body">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="announcement-banner">
                    <?php
                        $ann_query = "SELECT * FROM announcements WHERE target_audience IN ('All', 'Students') ORDER BY id DESC LIMIT 1";
                        $ann_run = mysqli_query($conn, $ann_query);
                        if(mysqli_num_rows($ann_run) > 0) {
                            $ann = mysqli_fetch_array($ann_run);
                    ?>
                            <h6 class="text-success font-weight-bold small mb-1">LATEST ANNOUNCEMENT</h6>
                            <h3 class="font-weight-bold"><?= $ann['title']; ?></h3>
                            <p class="text-muted"><?= substr($ann['description'], 0, 150); ?>...</p>
                            <button type="button" class="btn btn-success btn-sm px-4 rounded-pill shadow-sm" data-toggle="modal" data-target="#viewAnnouncement">
                                View Full Details
                            </button>

                            <div class="modal fade" id="viewAnnouncement" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content" style="border-radius: 15px;">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title font-weight-bold text-success"><?= $ann['title']; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-dark" style="white-space: pre-wrap;"><?= $ann['description']; ?></p>
                                            <hr>
                                            <div class="small text-muted">
                                                <i class="fas fa-user-edit mr-1"></i> Posted by: <strong><?= $ann['posted_by']; ?></strong><br>
                                                <i class="fas fa-calendar-alt mr-1"></i> Date: <?= date('F d, Y', strtotime($ann['date_created'])); ?>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php 
                        } else {
                            echo '<h3 class="font-weight-bold text-muted">No announcement yet.</h3>';
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="mb-4">
    <h4 class="font-weight-bold text-dark mb-1">
    <?= $greeting; ?>, <?= explode(' ', $full_name)[0]; ?>! 👋
</h4>
<p class="text-muted small mb-4">Today is <?= $current_date; ?></p>
</div>

        <div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="stat-card shadow-sm p-3">
            <div class="stat-icon text-success"><i class="fas fa-chart-line"></i></div>
            <div>
                <div class="text-muted small">General Average</div>
                <div class="h5 font-weight-bold mb-0">88.50</div>
                <div class="progress mt-2" style="height: 5px;">
                    <div class="progress-bar bg-success" style="width: 88%;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card shadow-sm p-3">
            <div class="stat-icon text-primary"><i class="fas fa-calendar-check"></i></div>
            <div>
                <div class="text-muted small">Attendance</div>
                <div class="h5 font-weight-bold mb-0">92%</div>
                <div class="progress mt-2" style="height: 5px;">
                    <div class="progress-bar bg-primary" style="width: 92%;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card shadow-sm p-3">
            <div class="stat-icon text-warning"><i class="fas fa-book"></i></div>
            <div>
                <div class="text-muted small">Enrolled Subjects</div>
                <div class="h5 font-weight-bold mb-0">8</div>
                <div class="progress mt-2" style="height: 5px;">
                    <div class="progress-bar bg-warning" style="width: 80%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card p-4 shadow-sm">
            <h6 class="font-weight-bold text-muted mb-4 small">ACADEMIC PERFORMANCE OVERVIEW</h6>
            <div style="position: relative; height: 350px; width: 100%;">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('performanceChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['General Average', 'Attendance (%)', 'Enrolled Subjects'],
            datasets: [{
                data: [88.50, 92, 8], // Nilagay natin ang actual data values mo
                backgroundColor: [
                    'rgba(46, 125, 50, 0.5)', 
                    'rgba(0, 123, 255, 0.5)', 
                    'rgba(255, 193, 7, 0.5)'
                ],
                borderColor: ['#2e7d32', '#007bff', '#ffc107'],
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, max: 100, grid: { display: false } },
                x: { grid: { display: false } }
            },
            plugins: { legend: { display: false } }
        }
    });
});
</script>



            

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('performanceChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['General Average', 'Attendance (%)', 'Enrolled Subjects'],
            datasets: [{
                data: [88.50, 92, 80], // Sample data
                backgroundColor: [
                    'rgba(46, 125, 50, 0.5)', 
                    'rgba(0, 123, 255, 0.5)', 
                    'rgba(255, 193, 7, 0.5)'
                ],
                borderColor: ['#2e7d32', '#007bff', '#ffc107'],
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, max: 100, grid: { display: false } },
                x: { grid: { display: false } }
            },
            plugins: { legend: { display: false } }
        }
    });
});
</script>


</body>
</html>