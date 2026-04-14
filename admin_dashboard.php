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
    <title>PBA - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #f1f3f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .main-content { margin-left: 250px; padding: 30px; }
        .stat-card { border: none; border-radius: 15px; transition: transform 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        .bg-pba { background: linear-gradient(45deg, #198754, #28a745); color: white; }
        .welcome-box { background: white; border-radius: 15px; padding: 30px; border-left: 5px solid #198754; }
        /* Style para hindi masyadong malaki yung chart container */
        .chart-container { position: relative; height: 350px; width: 100%; }
    </style>
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <div class="welcome-box shadow-sm mb-4">
            <h2 class="fw-bold text-dark">WELCOME BACK, Admin!</h2>
            <p class="text-muted mb-0">Narito ang status ng Pag-asa Bible Baptist Academy ngayong araw.</p>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card stat-card bg-pba shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase small">Total Enrolled</h6>
                                <h2 class="mb-0 font-weight-bold">
                                    <?php 
                                        $total_res = mysqli_query($conn, "SELECT * FROM students WHERE status='Approved'");
                                        echo mysqli_num_rows($total_res);
                                    ?>
                                </h2>
                            </div>
                            <i class="fas fa-user-graduate fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card stat-card bg-warning text-white shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase small">Pending Requests</h6>
                                <h2 class="mb-0 font-weight-bold">
                                    <?php 
                                        $pending_res = mysqli_query($conn, "SELECT * FROM students WHERE status='Pending'");
                                        echo mysqli_num_rows($pending_res);
                                    ?>
                                </h2>
                            </div>
                            <i class="fas fa-clock fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card stat-card bg-info text-white shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase small">Teachers</h6>
                                <h2 class="mb-0 font-weight-bold">12</h2> 
                            </div>
                            <i class="fas fa-chalkboard-teacher fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-2">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 font-weight-bold text-dark">
                    <i class="fas fa-chart-pie mr-2 text-success"></i>Enrolled Students by Grade Level
                </h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="gradePieChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Logic para sa pagkuha ng data sa Pie Chart
    $query = "SELECT grade_level, COUNT(*) as count FROM students WHERE status='Approved' GROUP BY grade_level";
    $result = mysqli_query($conn, $query);
    
    $labels = [];
    $data = [];
    
    while($row = mysqli_fetch_assoc($result)) {
        $labels[] = $row['grade_level'];
        $data[] = $row['count'];
    }
    ?>

    <script>
    const ctx = document.getElementById('gradePieChart').getContext('2d');
    const gradePieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Number of Students',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: [
                    '#198754', // Green
                    '#ffc107', // Yellow
                    '#0dcaf0', // Cyan
                    '#0d6efd', // Blue
                    '#6610f2', // Indigo
                    '#fd7e14'  // Orange
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 14 }
                    }
                }
            }
        }
    });
    </script>

</body>
</html>