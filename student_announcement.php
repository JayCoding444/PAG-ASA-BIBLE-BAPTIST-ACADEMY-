<?php
session_start();
include('db_connect.php');

if(!isset($_SESSION['auth'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - Pag-asa Academy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; display: flex; font-family: 'Segoe UI', sans-serif; margin: 0; }
        .main-content { margin-left: 240px; flex: 1; padding: 35px; min-height: 100vh; }
        .announcement-card { border: none; border-left: 5px solid #2e7d32; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); background: white; margin-bottom: 20px; }
        .date-badge { font-size: 11px; color: #666; background: #eee; padding: 3px 10px; border-radius: 20px; }
    </style>
</head>
<body>

<?php include('student_sidebar.php'); ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="mb-4">
            <h4 class="font-weight-bold text-dark"><i class="fas fa-bullhorn text-success mr-2"></i> School Announcements</h4>
            <p class="text-muted small">Stay updated with the latest news from Pag-asa Academy.</p>
        </div>

        <div class="row">
            <div class="col-md-10">
                <?php
                // FIX: Binago ang table name sa 'announcements'
                $query = "SELECT * FROM announcements ORDER BY id DESC";
                $query_run = mysqli_query($conn, $query);

                if(mysqli_num_rows($query_run) > 0) {
                    while($row = mysqli_fetch_assoc($query_run)) {
                        ?>
                        <div class="card announcement-card p-4">
    <div class="d-flex justify-content-between align-items-start mb-2">
        <h5 class="font-weight-bold text-success mb-0"><?= $row['title']; ?></h5>
        <span class="date-badge">
            <i class="far fa-calendar-alt mr-1"></i> 
            <?= date('M d, Y', strtotime($row['date_created'])); ?>
        </span>
    </div>
    <hr>
    
    <div class="announcement-body text-dark">
        <?php if(!empty($row['description'])): ?>
            <p class="font-weight-bold mb-1">Details:</p>
            <p style="white-space: pre-line;"><?= $row['description']; ?></p>
        <?php endif; ?>

        <?php if(!empty($row['message'])): ?>
            <p style="white-space: pre-line;"><?= $row['message']; ?></p>
        <?php endif; ?>
    </div>
</div>
                        <?php
                    }
                } else {
                    echo "<div class='text-center p-5 bg-white rounded shadow-sm'>
                            <p class='text-muted'>No announcements posted yet.</p>
                          </div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>