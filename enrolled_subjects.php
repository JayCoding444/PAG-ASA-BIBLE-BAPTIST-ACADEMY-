<?php
session_start();
include('db_connect.php');

if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != 'Student'){
    $_SESSION['message'] = "Login as a student first.";
    header("Location: login.php");
    exit();
}

// Burahin ang lumang query. Kunin ang ID direkta sa session na ginawa natin sa login_logic.php
$student_id = $_SESSION['auth_user']['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrolled Subjects - PBA System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; display: flex; font-family: 'Segoe UI', sans-serif; }
        .main-content { margin-left: 240px; flex: 1; padding: 35px; min-height: 100vh; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; }
        .table thead th { background-color: #2e7d32; color: white; border: none; text-transform: uppercase; font-size: 12px; padding: 15px; }
        .table tbody td { padding: 15px; vertical-align: middle; color: #444; border-bottom: 1px solid #eee; }
        .teacher-info { display: flex; align-items: center; gap: 10px; }
        .teacher-icon { width: 30px; height: 30px; background: #e8f5e9; color: #2e7d32; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; }
        .badge-enrolled { background-color: #e8f5e9; color: #2e7d32; border-radius: 20px; padding: 5px 15px; font-size: 11px; font-weight: bold; border: 1px solid #2e7d32; }
    </style>
</head>
<body>

<?php include('student_sidebar.php'); ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="font-weight-bold text-dark mb-0"><i class="fas fa-book-open text-success mr-2"></i> My Class Schedule</h4>
            <span class="text-muted small">Academic Year: 2025-2026</span>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Instructor</th>
                            <th>Schedule / Day</th>
                            <th>Time Slot</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Complex query para makuha ang pangalan ng teacher mula sa users table
                        $query = "SELECT s.subject_name, s.grade_level, sch.day, sch.start_time, sch.end_time, u.full_name as teacher_name
                                  FROM student_subjects ss
                                  INNER JOIN subjects s ON ss.subject_id = s.subject_id
                                  LEFT JOIN schedules sch ON s.subject_id = sch.subject_id
                                  LEFT JOIN teachers t ON sch.teacher_id = t.teacher_id
                                  LEFT JOIN users u ON t.user_id = u.id
                                  WHERE ss.student_id = '$student_id'";
                        
                        $query_run = mysqli_query($conn, $query);

                        if(mysqli_num_rows($query_run) > 0) {
                            while($row = mysqli_fetch_assoc($query_run)) {
                                ?>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-dark"><?= $row['subject_name']; ?></div>
                                        <div class="small text-muted"><?= $row['grade_level']; ?></div>
                                    </td>
                                    <td>
                                        <div class="teacher-info">
                                            <div class="teacher-icon"><i class="fas fa-user-tie"></i></div>
                                            <div><?= $row['teacher_name'] ?? '<i class="text-muted">Not Assigned</i>'; ?></div>
                                        </div>
                                    </td>
                                    <td><i class="far fa-calendar-alt mr-1 text-success"></i> <?= $row['day'] ?? 'TBA'; ?></td>
                                    <td class="font-weight-bold text-primary">
                                        <?php 
                                        if($row['start_time']) {
                                            echo date("h:i A", strtotime($row['start_time'])) . " - " . date("h:i A", strtotime($row['end_time']));
                                        } else {
                                            echo '<span class="text-muted">TBA</span>';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><span class="badge-enrolled">Enrolled</span></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center p-5 text-muted'>No enrolled subjects found for this semester.</td></tr>";
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