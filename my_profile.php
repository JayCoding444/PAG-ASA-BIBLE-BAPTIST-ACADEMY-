<?php
session_start();
include('db_connect.php');

// Security Check
if(!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit(0);
}

$user_id = $_SESSION['auth_user']['user_id'];

// 1. SQL QUERY: Kumukuha sa users table (para sa name/email) at students table (para sa details) 
$query = "SELECT u.full_name, u.email as user_email, s.* FROM users u 
          LEFT JOIN students s ON u.id = s.user_id 
          WHERE u.id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);

// Check kung may nahanap na data para iwas "null" error
if($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Fallback data para hindi mag-error ang page
    $user = [
        'full_name' => $_SESSION['auth_user']['user_name'] ?? 'Student',
        'user_email' => $_SESSION['auth_user']['user_email'] ?? 'No Email',
        'image' => null,
        'student_id' => 'N/A',
        'grade_level' => 'Not Assigned',
        'section' => 'Not Assigned',
        'phone' => 'N/A',
        'gender' => 'N/A',
        'dob' => 'N/A',
        'address' => 'No Address Provided'
    ];
}

// Greeting Logic para sa consistency
date_default_timezone_set('Asia/Manila');
$hour = date('H');
$greeting = ($hour < 12) ? "Good Morning" : (($hour < 18) ? "Good Afternoon" : "Good Evening");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PBA - My Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .main-content { margin-left: 250px; padding: 40px; transition: 0.3s; }
        .profile-card { border-radius: 15px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.05); background: #fff; }
        .profile-header-bg { background: linear-gradient(135deg, #2e7d32, #43a047); height: 100px; border-radius: 15px 15px 0 0; }
        .profile-img-wrapper { margin-top: -55px; position: relative; }
        .profile-img { width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 5px solid #fff; box-shadow: 0 5px 10px rgba(0,0,0,0.1); background-color: #eee; }
        .info-label { font-size: 11px; text-transform: uppercase; font-weight: 700; color: #6c757d; letter-spacing: 1px; margin-bottom: 2px; }
        .info-value { font-size: 15px; font-weight: 600; color: #333; margin-bottom: 15px; }
    </style>
</head>
<body>
    <?php include('student_sidebar.php'); ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <h4 class="font-weight-bold text-dark mb-1"><?= $greeting; ?>, <?= explode(' ', $user['full_name'])[0]; ?>! 👋</h4>
                    <p class="text-muted small">Manage your personal and academic information here.</p>
                </div>
                
                <div class="col-md-4">
                    <div class="card profile-card text-center pb-4">
                        <div class="profile-header-bg"></div>
                        <div class="profile-img-wrapper">
                            <img src="uploads/<?= (!empty($user['image'])) ? $user['image'] : 'default-user.png'; ?>" class="profile-img mb-3" onerror="this.src='assets/images/default-user.png'">
                        </div>
                        <h5 class="font-weight-bold mb-1"><?= $user['full_name']; ?></h5>
                        <p class="text-muted small mb-3">Student LRN: <?= $user['student_id'] ?? 'N/A'; ?></p>
                        <div><span class="badge badge-success px-3 py-2 rounded-pill">Enrolled</span></div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card profile-card p-4">
                        <h6 class="font-weight-bold text-success mb-4"><i class="fas fa-user-graduate mr-2"></i>ACADEMIC DETAILS</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="info-label">Grade Level</p>
                                <p class="info-value"><?= $user['grade_level'] ?: 'Not Assigned'; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="info-label">Section</p>
                                <p class="info-value"><?= $user['section'] ?: 'Not Assigned'; ?></p>
                            </div>
                        </div>

                        <hr class="my-3">

                        <h6 class="font-weight-bold text-success mb-4"><i class="fas fa-id-card mr-2"></i>PERSONAL INFORMATION</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="info-label">Email Address</p>
                                <p class="info-value"><?= $user['user_email']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="info-label">Contact Number</p>
                                <p class="info-value"><?= $user['phone'] ?: 'N/A'; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="info-label">Gender</p>
                                <p class="info-value"><?= $user['gender'] ?: 'N/A'; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="info-label">Date of Birth</p>
                                <p class="info-value"><?= $user['dob'] ?: 'N/A'; ?></p>
                            </div>
                            <div class="col-md-12">
                                <p class="info-label">Home Address</p>
                                <p class="info-value"><?= $user['address'] ?: 'No Address Provided'; ?></p>
                            </div>
                        </div>

                        <div class="mt-3">
                            <a href="account_settings.php" class="btn btn-outline-success btn-sm px-4 rounded-pill">
                                <i class="fas fa-edit mr-2"></i>Update Info
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>