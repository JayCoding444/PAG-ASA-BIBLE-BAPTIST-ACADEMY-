<?php
session_start();
include('db_connect.php');

// 1. Security Check
if(!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit(0);
}

// 2. Kunin ang details ng student
if(isset($_GET['id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM students WHERE student_id='$student_id' LIMIT 1";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) > 0) {
        $student = mysqli_fetch_array($query_run);
    } else {
        echo "<h4>No Student Found</h4>";
        exit();
    }
} else {
    header("Location: manage_students.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Details - PBA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .main-content { margin-left: 250px; padding: 40px; }
        .view-card { border-radius: 15px; border: none; overflow: hidden; }
        .student-header { background: #2e7d32; color: white; padding: 30px; text-align: center; }
        .profile-img { 
            width: 150px; height: 150px; border-radius: 50%; 
            object-fit: cover; border: 5px solid white; background: #eee;
        }
        .detail-box { padding: 10px; border-bottom: 1px solid #eee; }
        .detail-label { font-weight: bold; color: #666; font-size: 0.8rem; text-transform: uppercase; }
        .detail-value { font-size: 1.1rem; color: #333; }
        @media (max-width: 768px) { .main-content { margin-left: 0; padding: 15px; } }
    </style>
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card view-card shadow-lg">
                        
                        <div class="student-header">
                            <?php 
                                $photoPath = !empty($student['student_image']) ? 'uploads/'.$student['student_image'] : 'https://via.placeholder.com/150';
                            ?>
                            <img src="<?= $photoPath; ?>" class="profile-img mb-3" alt="Student Photo">
                            <h3><?= $student['student_name']; ?></h3>
                            <span class="badge badge-light"><?= $student['application_type']; ?></span>
                        </div>

                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6 detail-box">
                                    <div class="detail-label">Roll Number</div>
                                    <div class="detail-value"><?= $student['roll_number'] ?: 'N/A'; ?></div>
                                </div>
                                <div class="col-md-6 detail-box">
                                    <div class="detail-label">Status</div>
                                    <div class="detail-value text-success font-weight-bold"><?= $student['status']; ?></div>
                                </div>
                                <div class="col-md-6 detail-box">
                                    <div class="detail-label">Grade Level</div>
                                    <div class="detail-value"><?= $student['grade_level']; ?></div>
                                </div>
                                <div class="col-md-6 detail-box">
                                    <div class="detail-label">Gender</div>
                                    <div class="detail-value"><?= $student['gender']; ?></div>
                                </div>
                                <div class="col-md-12 detail-box">
                                    <div class="detail-label">Home Address</div>
                                    <div class="detail-value"><?= $student['address']; ?></div>
                                </div>
                            </div>

                            <div class="mt-4 text-center">
                                <a href="manage_students.php" class="btn btn-secondary px-4 shadow-sm">
                                    <i class="fas fa-arrow-left mr-2"></i> Back to Masterlist
                                </a>
                                <a href="edit_student.php?id=<?= $student['student_id']; ?>" class="btn btn-warning px-4 shadow-sm">
                                    <i class="fas fa-edit mr-2"></i> Edit Student
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>