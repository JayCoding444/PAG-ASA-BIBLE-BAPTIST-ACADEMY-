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
    <title>PBA - Student Masterlist</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f1f3f6; }
        .main-content { margin-left: 260px; padding: 30px; transition: 0.3s; }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .thead-dark th { background-color: #343a40; color: white; border: none; }
        .profile-img { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; border: 1px solid #eee; }
        .placeholder-icon { width: 40px; height: 40px; border-radius: 50%; background: #f0f0f0; display: inline-flex; align-items: center; justify-content: center; }
        
        @media (max-width: 768px) {
            .main-content { margin-left: 0; } 
        }
    </style>
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="font-weight-bold mb-0">Student Masterlist</h3>
                <p class="text-muted small">Manage all enrolled and approved students</p>
            </div>
            <div class="btn-group">
                <button type="button" onclick="window.print()" class="btn btn-outline-secondary btn-sm mr-2">
                    <i class="fas fa-print mr-1"></i> Print List
                </button>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover text-center mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th class="py-3">Photo</th>
                                <th class="py-3">Student Name</th>
                                <th class="py-3">Roll Number</th>
                                <th class="py-3">Grade Level</th>
                                <th class="py-3">Type</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query para sa mga APPROVED na students
                            $query = "SELECT * FROM students WHERE status = 'Approved' ORDER BY student_id DESC";
                            $query_run = mysqli_query($conn, $query);

                            if(mysqli_num_rows($query_run) > 0) {
                                while($student = mysqli_fetch_assoc($query_run)) {
                                    ?>
                                    <tr>
                                        <td class="align-middle">
                                            <?php if(!empty($student['image'])): ?>
                                                <img src="uploads/<?= $student['image']; ?>" alt="Profile" class="profile-img">
                                            <?php else: ?>
                                                <div class="placeholder-icon">
                                                    <i class="fas fa-user text-muted small"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>

                                        <td class="align-middle font-weight-bold text-left">
                                            <?= $student['student_name']; ?>
                                        </td>

                                        <td class="align-middle"><?= $student['roll_number']; ?></td>

                                        <td class="align-middle">Grade <?= $student['grade_level']; ?></td>

                                        <td class="align-middle">
                                            <span class="badge badge-light border px-2 py-1"><?= $student['application_type']; ?></span>
                                        </td>

                                        <td class="align-middle">
                                            <span class="badge badge-success px-3 py-2 shadow-sm">Enrolled</span>
                                        </td>

                                        <td class="align-middle">
                                            <div class="btn-group">
                                                <a href="view_student.php?id=<?= $student['student_id']; ?>" class="btn btn-outline-info btn-sm rounded-circle mr-1" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="edit_student.php?id=<?= $student['student_id']; ?>" class="btn btn-outline-warning btn-sm rounded-circle" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='7' class='py-5 text-muted'>No approved students found.</td></tr>";
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