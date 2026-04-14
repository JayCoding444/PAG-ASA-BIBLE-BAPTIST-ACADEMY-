<?php 
session_start();
include('db_connect.php'); 

// Ito ang titingin kung legit na Teacher ang pumasok
if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != 'Teacher'){
    header("Location: teacher_login.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Pag-asa Academy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { margin: 0; background-color: #f0f2f5; display: flex; }
        
        /* Sidebar Navigation */
        .sidebar { width: 240px; background: white; height: 100vh; padding: 25px 15px; border-right: 1px solid #e0e0e0; position: fixed; z-index: 100; }
        .menu-item { padding: 12px 18px; border-radius: 12px; color: #606770; text-decoration: none; display: block; margin-bottom: 8px; font-size: 14px; transition: 0.3s; font-weight: 500; }
        .menu-item:hover { background-color: #f0f2f5; color: #1a5276; text-decoration: none; }
        .active { background-color: #1a5276 !important; color: white !important; box-shadow: 0 4px 12px rgba(26,82,118,0.2); }

        /* Main Content Layout */
        .main-content { margin-left: 240px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; width: calc(100% - 240px); }
        .top-header { background: white; padding: 15px 35px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e0e0e0; }
        
        .content-body { padding: 35px; }

        /* Announcement Banner Style */
        .announcement-banner { 
            background: linear-gradient(135deg, #e3f2fd 0%, #ffffff 100%); 
            border: none; border-left: 5px solid #1a5276; border-radius: 15px; 
            padding: 25px; position: relative; overflow: hidden;
        }
        .announcement-banner::after {
            content: "\f0a1"; font-family: "Font Awesome 5 Free"; font-weight: 900;
            position: absolute; right: 20px; top: 10px; font-size: 80px; color: rgba(26, 82, 118, 0.05);
        }

        /* Overview Cards */
        .stat-card { background: white; padding: 25px; border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        
        .table-container { background: white; padding: 25px; border-radius: 15px; margin-top: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: none; }
    </style>
</head>
<body>

<div class="sidebar">
    <div style="text-align:center; margin-bottom:30px;">
        <img src="Academy_Logo.jpg" style="width:65px; border-radius:50%; border: 2px solid #eee;">
        <h6 class="mt-3 font-weight-bold" style="color: #1a5276; font-size: 13px; letter-spacing: 1px;">TEACHER PORTAL</h6>
    </div>
    <a href="teacher_dashboard.php" class="menu-item active"><i class="fas fa-th-large mr-2"></i> Dashboard</a>
    <a href="teacher_grades.php" class="menu-item"><i class="fas fa-edit mr-2"></i> Input Grades</a>
    <a href="#" class="menu-item"><i class="fas fa-calendar-alt mr-2"></i> Class Schedule</a>
    <hr>
    <a href="logout.php" class="menu-item text-danger"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
</div>

<div class="main-content">
    <div class="top-header">
        <span class="font-weight-bold text-muted small"><i class="fas fa-bars mr-2"></i> TEACHER MANAGEMENT SYSTEM</span>
        <span class="small font-weight-bold">Welcome, <span style="color: #1a5276;"><?php echo $_SESSION['full_name']; ?></span> 👋</span>
    </div>

    <div class="content-body">
        
        <div class="row mb-4">
            <div class="col-12">
                <?php
                // Kukunin ang latest announcement para sa Teachers o para sa Lahat
                $query = "SELECT * FROM announcements WHERE target_audience IN ('All', 'Teachers') ORDER BY id DESC LIMIT 1";
                $query_run = mysqli_query($conn, $query);

                if($query_run && mysqli_num_rows($query_run) > 0) {
                    $row = mysqli_fetch_array($query_run);
                ?>
                    <div class="announcement-banner shadow-sm border">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="text-primary font-weight-bold mb-1 small"><i class="fas fa-star mr-1"></i> LATEST UPDATE</h6>
                                <h3 class="font-weight-bold text-dark"><?php echo $row['title']; ?></h3>
                                <p class="text-muted mb-3"><?php echo substr($row['description'], 0, 120); ?>...</p>
                                
                                <button class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm" data-toggle="modal" data-target="#viewAnnouncement">
                                    Read Full Announcement
                                </button>
                            </div>
                            <div class="col-md-4 text-right d-none d-md-block">
                                <div class="small text-muted mb-1">Posted by: <strong><?php echo $row['posted_by']; ?></strong></div>
                                <div class="small text-muted"><i class="far fa-calendar-alt mr-1"></i> <?php echo date('M d, Y', strtotime($row['date_created'])); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="viewAnnouncement" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                <div class="modal-header bg-primary text-white border-0" style="border-radius: 20px 20px 0 0;">
                                    <h5 class="modal-title font-weight-bold"><i class="fas fa-bullhorn mr-2"></i> Announcement Details</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body p-4">
                                    <h4 class="font-weight-bold mb-1"><?php echo $row['title']; ?></h4>
                                    <div class="small text-muted mb-3">
                                        <i class="fas fa-clock mr-1"></i> <?php echo date('F d, Y - h:i A', strtotime($row['date_created'])); ?>
                                    </div>
                                    <hr>
                                    <p style="white-space: pre-line; line-height: 1.6;" class="text-secondary">
                                        <?php echo $row['description']; ?>
                                    </p>
                                </div>
                                <div class="modal-footer border-0 p-3">
                                    <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <h4 class="font-weight-bold text-dark mb-4">Overview</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="stat-card">
                    <h3 class="font-weight-bold" style="color: #1a5276;">45</h3>
                    <p class="text-muted mb-0 font-weight-bold small">TOTAL STUDENTS ENROLLED</p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="stat-card">
                    <h3 class="font-weight-bold" style="color: #1a5276;">4</h3>
                    <p class="text-muted mb-0 font-weight-bold small">HANDLING SUBJECTS</p>
                </div>
            </div>
        </div>

        <div class="table-container">
            <h5 class="font-weight-bold mb-4 text-dark"><i class="fas fa-clock mr-2 text-primary"></i> Today's Classes</h5>
            <table class="table table-hover border-0">
                <thead style="background-color: #f8f9fa;">
                    <tr>
                        <th class="border-0">Time</th>
                        <th class="border-0">Subject</th>
                        <th class="border-0">Section</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="transition: 0.3s;">
                        <td class="align-middle">8:00 AM</td>
                        <td class="align-middle font-weight-bold">Filipino</td>
                        <td class="align-middle"><span class="badge badge-info px-3 py-2">Grade 11 - A</span></td>
                    </tr>
                    <tr style="transition: 0.3s;">
                        <td class="align-middle">10:00 AM</td>
                        <td class="align-middle font-weight-bold">English</td>
                        <td class="align-middle"><span class="badge badge-info px-3 py-2">Grade 12 - B</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>