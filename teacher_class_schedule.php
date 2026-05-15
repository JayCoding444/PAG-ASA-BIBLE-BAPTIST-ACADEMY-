<?php 
session_start();
include('db_connect.php'); 

// Check kung naka-login at kung Teacher ba talaga
if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != 'Teacher'){
    header("Location: teacher_login.php"); 
    exit();
}

/* FIX: Siguraduhin na tama ang pagkuha sa user_id mula sa session mo */
$teacher_id = isset($_SESSION['auth_user']['user_id']) ? $_SESSION['auth_user']['user_id'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Schedule - Pag-asa Academy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* CSS FIX PARA SA ALIGNMENT */
      * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
    body { margin: 0; background-color: #f0f2f5; }
    
    .sidebar { 
        width: 240px; 
        background: white; 
        height: 100vh; 
        padding: 25px 15px; 
        border-right: 1px solid #e0e0e0; 
        position: fixed; 
        z-index: 100; 
    }

    /* FIX: Ito ang mag-a-align sa main content pakanan */
    .content { 
        margin-left: 240px; 
        padding: 40px; 
        width: calc(100% - 240px); 
        min-height: 100vh;
    }

    .card-custom { 
        background: white; 
        border-radius: 20px; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.05); 
        padding: 30px; 
    }
        
                .sidebar { width: 240px; background: white; height: 100vh; padding: 25px 15px; border-right: 1px solid #e0e0e0; position: fixed; z-index: 100; }
        .menu-item { padding: 12px 18px; border-radius: 12px; color: #606770; text-decoration: none; display: block; margin-bottom: 8px; font-size: 14px; transition: 0.3s; font-weight: 500; }
        .menu-item:hover { background-color: #f0f2f5; color: #1a5276; text-decoration: none; }
        .active { background-color: #1a5276 !important; color: white !important; box-shadow: 0 4px 12px rgba(26,82,118,0.2); }
        .menu-item { padding: 14px 18px; margin-bottom: 10px; border-radius: 12px; color: #65676b; text-decoration: none; display: flex; align-items: center; transition: 0.3s; font-weight: 500; }
        .menu-item:hover { background: #f2f2f2; color: #1a5cff; text-decoration: none; }
        .menu-item.active { background: #e7f1ff; color: #1a5cff; font-weight: 700; border-left: 5px solid #1a5cff; }
        .menu-item i { margin-right: 15px; font-size: 18px; width: 25px; text-align: center; }

        .card-custom { background: white; border-radius: 20px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 30px; }
        .table thead th { border: 0; background-color: #f8f9fa; color: #8e8e8e; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h5 class="mb-4 text-primary font-weight-bold pl-2">PAG-ASA Academy</h5>
        <a href="teacher_dashboard.php" class="menu-item">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="teacher_input_grades.php" class="menu-item">
            <i class="fas fa-edit"></i> Input Grades
        </a>
        <a href="teacher_class_schedule.php" class="menu-item active">
            <i class="fas fa-calendar-alt"></i> Class Schedule
        </a>
        <a href="teacher_profile.php" class="menu-item">
            <i class="fas fa-user-circle"></i> My Profile
        </a>
    </div>

    <div class="content">
        <div class="mb-4">
            <h3 class="font-weight-bold" style="color: #1c1e21;">My Class Schedule</h3>
            <p class="text-muted">Academic Year 2024-2025 | Weekly Assigned Classes</p>
        </div>

        <div class="card-custom">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Subject Name</th>
                            <th>Section</th>
                            <th>Day</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query para kunin ang schedule ng teacher base sa ID niya
                        $sched_query = "SELECT s.subject_name, sch.time_start, sch.time_end, sch.day, sch.section 
                                        FROM schedules sch 
                                        JOIN subjects s ON sch.subject_id = s.id 
                                        WHERE sch.teacher_id = '$teacher_id'
                                        ORDER BY sch.time_start ASC";
                        
                        $sched_run = mysqli_query($conn, $sched_query);

                        if(mysqli_num_rows($sched_run) > 0) {
                            while($row = mysqli_fetch_assoc($sched_run)) {
                                ?>
                                <tr>
                                    <td class="align-middle font-weight-bold">
                                        <?= date("h:i A", strtotime($row['time_start'])); ?> - <?= date("h:i A", strtotime($row['time_end'])); ?>
                                    </td>
                                    <td class="align-middle"><?= $row['subject_name']; ?></td>
                                    <td class="align-middle"><span class="badge badge-info px-3 py-2"><?= $row['section']; ?></span></td>
                                    <td class="align-middle"><?= $row['day']; ?></td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill">View Students</button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center py-4'>No assigned schedule found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>