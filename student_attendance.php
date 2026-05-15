<?php
session_start();
include('db_connect.php');

if(!isset($_SESSION['auth'])){
    header("Location: login.php");
    exit();
}

// Temporary ID para sa testing
$st_id = 31; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Attendance - Pag-asa Academy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; display: flex; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .main-content { margin-left: 240px; flex: 1; padding: 35px; min-height: 100vh; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: white; overflow: hidden; }
        .table thead th { background-color: #2e7d32; color: white; border: none; text-transform: uppercase; font-size: 12px; padding: 15px; }
        .badge-present { background-color: #e8f5e9; color: #2e7d32; border: 1px solid #2e7d32; padding: 5px 12px; border-radius: 20px; font-weight: bold; }
        .badge-late { background-color: #fff3e0; color: #ef6c00; border: 1px solid #ef6c00; padding: 5px 12px; border-radius: 20px; font-weight: bold; }
        .badge-absent { background-color: #ffebee; color: #c62828; border: 1px solid #c62828; padding: 5px 12px; border-radius: 20px; font-weight: bold; }
    </style>
</head>
<body>

<?php include('student_sidebar.php'); ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="mb-4">
            <h4 class="font-weight-bold text-dark"><i class="fas fa-calendar-check text-success mr-2"></i> My Attendance Record</h4>
            <p class="text-muted small">Monitoring your daily class attendance.</p>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Subject</th>
                            <th>Time In</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT a.*, s.subject_name 
                                  FROM attendance a 
                                  INNER JOIN subjects s ON a.subject_id = s.subject_id 
                                  WHERE a.student_id = '$st_id' 
                                  ORDER BY a.date DESC";
                        
                        $query_run = mysqli_query($conn, $query);

                        if(mysqli_num_rows($query_run) > 0) {
                            while($row = mysqli_fetch_assoc($query_run)) {
                                // Determine badge class
                                $b_class = 'badge-present';
                                if($row['status'] == 'Late') $b_class = 'badge-late';
                                if($row['status'] == 'Absent') $b_class = 'badge-absent';
                                ?>
                                <tr>
                                    <td><?= date('M d, Y', strtotime($row['date'])); ?></td>
                                    <td><span class="font-weight-bold text-dark"><?= $row['subject_name']; ?></span></td>
                                    <td><?= date('h:i A', strtotime($row['time_in'])); ?></td>
                                    <td class="text-center">
                                        <span class="<?= $b_class; ?>"><?= $row['status']; ?></span>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center p-5 text-muted'>No records found for your ID.</td></tr>";
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