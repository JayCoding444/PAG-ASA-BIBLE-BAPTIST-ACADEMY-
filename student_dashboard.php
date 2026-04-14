<?php
session_start();
include('db_connect.php'); 

// 1. SECURITY CHECK - Siguraduhin na student ang naka-login
if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != 'Student'){
    $_SESSION['message'] = "Login as a student first.";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['auth_user']['user_id']; 

// 2. QUERY PARA SA STUDENT DETAILS (Pangalan at Info)
// Gagamit tayo ng INNER JOIN dahil ang 'full_name' ay nasa users table
$student_query = "SELECT st.*, u.full_name, u.email as user_email 
                  FROM students st 
                  INNER JOIN users u ON st.user_id = u.id 
                  WHERE st.user_id = '$user_id' LIMIT 1";

$student_result = mysqli_query($conn, $student_query);

if(mysqli_num_rows($student_result) > 0) {
    $student_data = mysqli_fetch_array($student_result);
    
    // Variables para sa malinis na HTML
    $display_name = $student_data['full_name']; 
    $display_email = $student_data['user_email'];
    $display_level = $student_data['grade_level']; // Base sa image_4e2682.jpg
    $display_section = $student_data['section'];
    $display_id = $student_data['student_id'];
    $display_gender = $student_data['gender'];
    $display_address = $student_data['address'];
    $display_image = $student_data['image'] ?? 'default-avatar.png';
} else {
    // Default values kung sakaling may error sa data
    $display_name = $_SESSION['auth_user']['user_name'];
    $display_email = "Not set";
    $display_level = "N/A";
    $display_section = "N/A";
    $display_id = "0";
    $display_gender = "N/A";
    $display_address = "Not set";
    $display_image = "default-avatar.png";
}

// 3. QUERY PARA SA ENROLLED SUBJECTS COUNT
$count_query = "SELECT COUNT(*) as total_subjects FROM student_subjects 
                WHERE student_id = '$display_id'";
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$total_subjects = $count_data['total_subjects'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Pag-asa Academy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { margin: 0; background-color: #f8f9fa; display: flex; }
        .main-content { margin-left: 240px; flex: 1; display: flex; flex-direction: column; width: calc(100% - 240px); min-height: 100vh; }
        .top-header { background: white; padding: 15px 35px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e0e0e0; }
        .user-top { display: flex; align-items: center; gap: 12px; }
        .user-top img { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #eee; }
        .dashboard-body { padding: 35px; }
        .announcement-banner { background: white; border: none; border-left: 5px solid #2e7d32; border-radius: 15px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .stat-card { background: white; padding: 22px; border-radius: 15px; display: flex; align-items: center; gap: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: none; height: 100%; }
        .stat-icon { width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: none; }
        .profile-img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 4px solid #f8f9fa; }
        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 10px; }
        .detail-label { color: #95a5a6; font-size: 10px; text-transform: uppercase; font-weight: bold; }
        .detail-value { font-weight: 600; color: #2c3e50; font-size: 14px; }
    </style>
</head>
<body>

<?php include('student_sidebar.php'); ?>

<div class="main-content">
    <div class="top-header">
        <div class="font-weight-bold text-muted small"><i class="fas fa-bars mr-2"></i> STUDENT PORTAL</div>
        <div class="user-top">
            <span class="font-weight-bold text-dark small"><?= $display_name; ?></span>
            <img src="Academy_Logo.jpg" alt="User">
        </div>
    </div>

    <div class="dashboard-body">
        <div class="row mb-4">
            <div class="col-md-12">
                <?php
                $ann_query = "SELECT * FROM announcements WHERE target_audience IN ('All', 'Students') ORDER BY id DESC LIMIT 1";
                $ann_run = mysqli_query($conn, $ann_query);
                if(mysqli_num_rows($ann_run) > 0) {
                    $ann = mysqli_fetch_array($ann_run);
                ?>
                    <div class="announcement-banner">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="text-success font-weight-bold mb-1 small"><i class="fas fa-star mr-1"></i> LATEST ANNOUNCEMENT</h6>
                                <h3 class="font-weight-bold text-dark"><?= $ann['title']; ?></h3>
                                <p class="text-muted mb-3"><?= substr($ann['description'], 0, 100); ?>...</p>
                                <button class="btn btn-success btn-sm rounded-pill px-4 shadow-sm">View Full Details</button>
                            </div>
                            <div class="col-md-4 text-right d-none d-md-block">
                                <div class="small text-muted mb-1">Posted by: <strong><?= $ann['posted_by']; ?></strong></div>
                                <div class="small text-muted"><i class="far fa-calendar-alt mr-1"></i> <?= date('M d, Y', strtotime($ann['date_created'])); ?></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <h4 class="font-weight-bold text-dark mb-4">Mabuhay, <?= explode(' ', $display_name)[0]; ?>! 👋</h4>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon bg-light text-success"><i class="fas fa-chart-line"></i></div>
                    <div><div class="text-muted small">General Average</div><div class="h5 font-weight-bold mb-0">95.05</div></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon bg-light text-primary"><i class="fas fa-calendar-check"></i></div>
                    <div><div class="text-muted small">Attendance</div><div class="h5 font-weight-bold mb-0">85%</div></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon bg-light text-warning"><i class="fas fa-book"></i></div>
                    <div><div class="text-muted small">Enrolled Subjects</div><div class="h5 font-weight-bold mb-0"><?= $total_subjects; ?></div></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-center h-100">
                    <h6 class="font-weight-bold text-left mb-4 text-muted">MY PROFILE</h6>
                    <img src="uploads/student/<?= $display_image; ?>" class="profile-img mx-auto" alt="Student">
                    <h5 class="font-weight-bold mb-0"><?= $display_name; ?></h5>
                    <p class="text-muted small mb-2">ID: <?= $display_id; ?></p>
                    <div class="badge badge-success px-3 py-1 rounded-pill mx-auto" style="width: fit-content;">Active</div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card h-100">
                    <h6 class="font-weight-bold mb-4 text-muted">INFORMATION DETAILS</h6>
                    <div class="details-grid">
                        <div class="detail-item"><div class="detail-label">Full Name</div><div class="detail-value"><?= $display_name; ?></div></div>
                        <div class="detail-item"><div class="detail-label">Email</div><div class="detail-value text-lowercase"><?= $display_email; ?></div></div>
                        <div class="detail-item"><div class="detail-label">Gender</div><div class="detail-value"><?= $display_gender; ?></div></div>
                        <div class="detail-item"><div class="detail-label">Section</div><div class="detail-value"><?= $display_section; ?></div></div>
                        <div class="detail-item"><div class="detail-label">Level</div><div class="detail-value"><?= $display_level; ?></div></div>
                        <div class="detail-item"><div class="detail-label">Address</div><div class="detail-value"><?= $display_address; ?></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>