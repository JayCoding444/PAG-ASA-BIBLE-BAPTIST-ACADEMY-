<?php
session_start();
include('db_connect.php');

// Security Check
if(!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit(0);
}

// Fetch user data
$user_id = $_SESSION['auth_user']['user_id'];
$query = "SELECT * FROM students WHERE user_id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PBA - My Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .main-content { margin-left: 250px; padding: 40px; }
        .profile-card { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .profile-img { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 5px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <?php include('student_sidebar.php'); ?>

    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card profile-card">
                        <div class="card-body text-center py-5">
                            <img src="uploads/<?= !empty($user['image']) ? $user['image'] : 'default-user.png' ?>" class="profile-img mb-4">
                            
                            <h3 class="font-weight-bold"><?= $user['parent_name'] ?? 'Joshua Mabanglo' ?></h3>
                            <p class="text-muted">Roll Number: <?= $user['roll_number'] ?? 'Not Assigned' ?></p>
                            <hr>
                            
                            <div class="row text-left mt-4">
                                <div class="col-md-6 mb-3">
                                    <label class="small text-uppercase font-weight-bold text-muted">Email Address</label>
                                    <p class="h6"><?= $user['email'] ?? 'No Email' ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small text-uppercase font-weight-bold text-muted">Grade Level</label>
                                    <p class="h6"><?= $user['grade_level'] ?? 'N/A' ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small text-uppercase font-weight-bold text-muted">Gender</label>
                                    <p class="h6"><?= $user['gender'] ?? 'N/A' ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small text-uppercase font-weight-bold text-muted">Section</label>
                                    <p class="h6"><?= $user['section'] ?? 'N/A' ?></p>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <a href="account_settings.php" class="btn btn-success px-5 rounded-pill">Manage Account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>