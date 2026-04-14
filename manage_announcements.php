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
    <title>PBA - Manage Announcements</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f1f3f6; font-family: 'Segoe UI', sans-serif; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card { border-radius: 15px; border: none; }
        .announcement-card { border-left: 5px solid #198754; margin-bottom: 20px; }
        .badge-pba { background-color: #e8f5e9; color: #198754; border: 1px solid #c8e6c9; }
    </style>
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-0"><i class="fas fa-bullhorn text-success mr-2"></i>Manage Announcements</h4>
                <p class="text-muted small">Create and Post Announcement</p>
            </div>
            <button class="btn btn-success shadow-sm px-4 rounded-pill" data-toggle="modal" data-target="#postAnnouncement">
                <i class="fas fa-plus-circle mr-1"></i> Create Post
            </button>
        </div>

        <div class="row">
            <div class="col-lg-9 mx-auto">
                <?php
                // INAYOS NA QUERY: Ginamit ang 'id' at 'date_created' base sa DB mo
                $query = "SELECT * FROM announcements ORDER BY id DESC"; 
                $query_run = mysqli_query($conn, $query);

                if($query_run && mysqli_num_rows($query_run) > 0) {
                    foreach($query_run as $row) {
                        ?>
                        <div class="card announcement-card shadow-sm mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="font-weight-bold text-dark mb-0"><?= $row['title']; ?></h5>
                                    <span class="badge badge-pba px-3 py-2 rounded-pill"><?= $row['target_audience']; ?></span>
                                </div>
                                <p class="text-secondary" style="white-space: pre-line;"><?= $row['description']; ?></p>
                                <hr class="my-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="small text-muted">
                                        <i class="fas fa-clock mr-1"></i> 
                                        Posted on: <?= date('M d, Y', strtotime($row['date_created'])); ?>
                                    </div>
                                    <form action="announcement_logic.php" method="POST" onsubmit="return confirm('Burahin ito?');">
                                        <input type="hidden" name="announcement_id" value="<?= $row['id']; ?>">
                                        <button type="submit" name="delete_announcement" class="btn btn-sm btn-outline-danger border-0">
                                            <i class="fas fa-trash-alt mr-1"></i> Remove Post
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<div class='card shadow-sm text-center py-5'><h5 class='text-muted'>No announcements found.</h5></div>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="postAnnouncement" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold">New School Update</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="announcement_logic.php" method="POST">
                    <div class="modal-body pt-3">
                        <div class="form-group">
                            <label class="small font-weight-bold">Headline / Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold">Message Details</label>
                            <textarea name="description" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold">Who can see this?</label>
                            <select name="target_audience" class="form-control">
                                <option value="All">Everyone</option>
                                <option value="Students">Students</option>
                                <option value="Teachers">Teachers</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" name="save_announcement" class="btn btn-success btn-block rounded-pill">Post Announcement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>