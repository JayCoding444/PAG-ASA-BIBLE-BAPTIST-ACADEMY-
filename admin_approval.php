<?php
session_start();
include('db_connect.php');

// Security Check
if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != 'Admin') {
    header("Location: login.php");
    exit(0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Enrollment Requests - PBA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .main-content { margin-left: 250px; padding: 30px; transition: 0.3s; }
        .table thead { background-color: #343a40; color: white; }
        .badge-registration { background-color: #17a2b8; color: white; } /* Cyan for New */
        .badge-reenrollment { background-color: #007bff; color: white; } /* Blue for Old */
        .card { border-radius: 15px; }
    </style>
</head>
<body style="background-color: #f1f3f6;">

    <?php include('sidebar.php'); ?>

    <div class="main-content">
        
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle mr-2"></i> <?= $_SESSION['message']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php unset($_SESSION['message']); endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark">Student Enrollment Requests</h4>
            <a href="admin_dashboard.php" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-center mb-0">
                        <thead>
                            <tr>
                                <th class="py-3">Student Name</th>
                                <th class="py-3">Grade Level</th>
                                <th class="py-3">Gender</th>
                                <th class="py-3">Type</th> <th class="py-3">Address</th>
                                <th class="py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Kinukuha ang lahat ng Pending requests
                            $query = "SELECT * FROM students WHERE status = 'Pending' ORDER BY student_id DESC";
                            $query_run = mysqli_query($conn, $query);

                            if(mysqli_num_rows($query_run) > 0) {
                                foreach($query_run as $row) {
                                    ?>
                                    <tr>
                                        <td class="align-middle font-weight-bold"><?= $row['parent_name']; ?></td> 
                                        <td class="align-middle"><?= $row['grade_level']; ?></td>
                                        <td class="align-middle"><?= $row['gender']; ?></td>
                                        <td class="align-middle">
                                            <?php if($row['application_type'] == 'Registration'): ?>
                                                <span class="badge badge-registration px-3 py-2">Registration</span>
                                            <?php else: ?>
                                                <span class="badge badge-reenrollment px-3 py-2">Re-enrollment</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle small text-muted text-left" style="max-width: 200px;">
                                            <?= $row['address']; ?>
                                        </td>
                                        <td class="align-middle">
                                            <div class="btn-group">
                                                <a href="approve_logic.php?id=<?= $row['student_id']; ?>&status=Approved" 
                                                   class="btn btn-success btn-sm px-3 mr-1 shadow-sm">
                                                   <i class="fas fa-check mr-1"></i> Approve
                                                </a>
                                                <a href="approve_logic.php?reject_id=<?= $row['student_id']; ?>&status=Rejected" 
                                                   class="btn btn-danger btn-sm px-3 shadow-sm">
                                                   <i class="fas fa-times mr-1"></i> Reject
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='6' class='py-5 text-muted'>No pending applications found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>