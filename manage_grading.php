<?php
session_start();
include('db_connect.php');

if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != 'Admin') {
    header("Location: login.php");
    exit(0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Grading - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f1f3f6;">

    <?php include('sidebar.php'); ?>

    <div class="main-content" style="margin-left: 250px; padding: 30px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Manage Student Grades</h4>
            <span class="badge bg-primary">Admin View</span>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Subject</th>
                            <th>Grade</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Kukunin lang natin ang mga 'Active' na grades
                        $query = "SELECT * FROM grades WHERE status='Active'";
                        $query_run = mysqli_query($conn, $query);

                        if(mysqli_num_rows($query_run) > 0) {
                            foreach($query_run as $grade) {
                                ?>
                                <tr>
                                    <td><?= $grade['student_name']; ?></td>
                                    <td><?= $grade['subject']; ?></td>
                                    <td><?= $grade['final_grade']; ?></td>
                                    <td><span class="badge bg-success"><?= $grade['status']; ?></span></td>
                                    <td>
                                        <form action="code.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="grade_id" value="<?= $grade['id']; ?>">
                                            <button type="submit" name="archive_grade_btn" class="btn btn-warning btn-sm">Archive</button>
                                        </form>

                                        <form action="code.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="grade_id" value="<?= $grade['id']; ?>">
                                            <button type="submit" name="delete_grade_btn" class="btn btn-danger btn-sm" onclick="return confirm('Sigurado ka ba na gusto mong i-delete ito?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>No Active Records Found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>