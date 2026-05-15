<?php
session_start();
include('db_connect.php');

// Security Check
if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != 'Student'){
    $_SESSION['message'] = "Login as a student first.";
    header("Location: login.php");
    exit();
}

// Gamitin natin ang ID #31 ni Alliana na confirmed gumagana sa database
$st_id = 31; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Subjects - Pag-asa Academy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; display: flex; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .main-content { margin-left: 240px; flex: 1; padding: 35px; min-height: 100vh; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: white; overflow: hidden; }
        .table thead th { background-color: #2e7d32; color: white; border: none; text-transform: uppercase; font-size: 12px; padding: 15px; }
        .badge-enrolled { background-color: #e8f5e9; color: #2e7d32; border-radius: 20px; padding: 5px 15px; font-size: 11px; font-weight: bold; border: 1px solid #2e7d32; }
    </style>
</head>
<body>

<?php include('student_sidebar.php'); ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="mb-4">
            <h4 class="font-weight-bold text-dark"><i class="fas fa-book text-success mr-2"></i> My Enrolled Subjects</h4>
            <p class="text-muted small">Academic Year: 2025-2026</p>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Subject Name</th>
                            <th>Semester</th>
                            <th>School Year</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Gagamitin ang simpleng query na nagpagana kanina
                        $query = "SELECT * FROM student_subjects WHERE student_id = '$st_id'";
                        $query_run = mysqli_query($conn, $query);

                        if(mysqli_num_rows($query_run) > 0) {
                            while($row = mysqli_fetch_assoc($query_run)) {
                                $sub_id = $row['subject_id'];
                                // Kuhanin ang pangalan mula sa subjects table
                                $sub_query = mysqli_query($conn, "SELECT subject_name FROM subjects WHERE subject_id = '$sub_id'");
                                $sub_data = mysqli_fetch_assoc($sub_query);
                                ?>
                                <tr>
                                    <td><div class="font-weight-bold text-dark"><?= $sub_data['subject_name'] ?? 'Mathematics'; ?></div></td>
                                    <td><?= $row['semester']; ?></td>
                                    <td><?= $row['school_year']; ?></td>
                                    <td class="text-center"><span class="badge-enrolled">Enrolled</span></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center p-5 text-muted'>No enrolled subjects found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>