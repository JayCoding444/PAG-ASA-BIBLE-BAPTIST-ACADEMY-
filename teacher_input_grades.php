<?php 
session_start();
include('db_connect.php'); 

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
    <title>Input Grades - Pag-asa Academy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Exact Dashboard UI Replication */
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { margin: 0; background-color: #f0f2f5; }
        /* I-paste ito sa loob ng <style> tags mo */

body { 
    margin: 0; 
    background-color: #f0f2f5; 
}

/* 1. Siguraduhin na ang sidebar ay fixed sa kaliwa */
.sidebar { 
    width: 240px; 
    background: white; 
    height: 100vh; 
    position: fixed; 
    left: 0; 
    top: 0; 
    z-index: 100;
    border-right: 1px solid #e0e0e0;
}

/* 2. Eto ang mag-a-align sa content mo sa gitna/kanan */
.content { 
    margin-left: 240px; /* Pantay dapat sa width ng sidebar */
    padding: 40px; 
    min-height: 100vh;
    width: calc(100% - 240px); /* Para sakop ang buong screen space */
}

/* 3. Ang Active "Mark" para sa Input Grades link */
.menu-item.active { 
    background-color: #e7f1ff !important; 
    color: #1a5cff !important; 
    font-weight: 700;
    border-left: 5px solid #1a5cff; /* Ito yung kulay na mark sa gilid */
    border-radius: 4px 12px 12px 4px;
}

/* 4. Center alignment para sa card-container mo */
.card-container, .card-custom {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}
        
        .sidebar { width: 240px; background: white; height: 100vh; padding: 25px 15px; border-right: 1px solid #e0e0e0; position: fixed; z-index: 100; }
        .menu-item { padding: 12px 18px; border-radius: 12px; color: #606770; text-decoration: none; display: block; margin-bottom: 8px; font-size: 14px; transition: 0.3s; font-weight: 500; }
        .menu-item:hover { background-color: #f0f2f5; color: #1a5276; text-decoration: none; }
        .active { background-color: #1a5276 !important; color: white !important; box-shadow: 0 4px 12px rgba(26,82,118,0.2); }
        
        .menu-item { padding: 14px 18px; margin-bottom: 10px; border-radius: 12px; color: #65676b; text-decoration: none; display: flex; align-items: center; transition: 0.3s; font-weight: 500; }
        .menu-item:hover { background: #f2f2f2; color: #1a5cff; text-decoration: none; }
        .menu-item.active { background: #e7f1ff; color: #1a5cff; font-weight: 700; }
        .menu-item i { margin-right: 15px; font-size: 18px; width: 25px; text-align: center; }

        .card-custom { background: white; border-radius: 20px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 30px; }
        .table-container { background: white; border-radius: 20px; padding: 25px; margin-top: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        
        .btn-filter { background: #1a5cff; color: white; border-radius: 10px; padding: 12px 25px; border: none; font-weight: 600; transition: 0.3s; }
        .btn-filter:hover { background: #003ccb; transform: translateY(-2px); }
        
        .form-select { border-radius: 12px; height: 50px !important; border: 1px solid #e0e0e0; background-color: #f8f9fa; }
        .grade-input { width: 85px; border-radius: 8px; border: 1px solid #ddd; text-align: center; font-weight: 600; padding: 8px; }
        
        .status-badge { padding: 6px 15px; border-radius: 50px; font-size: 12px; font-weight: 700; text-transform: uppercase; }
    </style>
</head>
<body>

    <div class="sidebar">
    <div style="text-align:center; margin-bottom:30px;">
        <img src="Academy_Logo.jpg" style="width:65px; border-radius:50%; border: 2px solid #eee;">
        <h6 class="mt-3 font-weight-bold" style="color: #1a5276; font-size: 13px; letter-spacing: 1px;">TEACHER PORTAL</h6>
    </div>
    <a href="teacher_dashboard.php" class="menu-item active"><i class="fas fa-th-large mr-2"></i> Dashboard</a>
    <a href="teacher_input_grades.php" class="menu-item"><i class="fas fa-edit mr-2"></i> Input Grades</a>
    <a href="teacher_class_schedule.php" class="menu-item"><i class="fas fa-calendar-alt mr-2"></i> Class Schedule</a>
     <a href="teacher_profile.php" class="menu-item">
            <i class="fas fa-user-circle"></i> My Profile
        </a>
    <hr>
    <a href="logout.php" class="menu-item text-danger"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
</div>
    </div>

    <div class="content">
        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="font-weight-bold" style="color: #1c1e21;">Student Grades</h3>
                    <p class="text-muted">Academic Year 2024-2025 | Teacher's Encoding Portal</p>
                </div>
            </div>
        </div>

        <div class="card-custom">
            <form action="teacher_input_grades.php" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-8">
                        <label class="small font-weight-bold text-uppercase text-muted mb-2">Subject Selection</label>
                        <select name="subject_id" class="form-control form-select" required>
                            <option value="">-- Click to select subject --</option>
                            <?php
                            $query = "SELECT * FROM subjects"; 
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                                $selected = (isset($_GET['subject_id']) && $_GET['subject_id'] == $row['id']) ? 'selected' : '';
                                echo "<option value='".$row['id']."' $selected>".$row['subject_name']." - Section A</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn-filter btn-block shadow-sm">
                            <i class="fas fa-search mr-2"></i> Show Students
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <?php if(isset($_GET['subject_id'])): ?>
            <div class="table-container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="font-weight-bold m-0"><i class="fas fa-list mr-2 text-primary"></i> Class List</h5>
                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3">Export to Excel</button>
                </div>
                
                <table class="table table-hover">
                    <thead style="background-color: #f8f9fa;">
                        <tr class="text-muted small text-uppercase">
                            <th class="border-0">Student Name</th>
                            <th class="border-0 text-center">Prelim</th>
                            <th class="border-0 text-center">Midterm</th>
                            <th class="border-0 text-center">Finals</th>
                            <th class="border-0 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td class="align-middle font-weight-bold">Dela Cruz, Juan A.</td>
                            <td class="text-center"><input type="number" class="grade-input" placeholder="0"></td>
                            <td class="text-center"><input type="number" class="grade-input" placeholder="0"></td>
                            <td class="text-center"><input type="number" class="grade-input" placeholder="0"></td>
                            <td class="text-center align-middle">
                                <span class="status-badge badge-warning text-dark">Pending</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="mt-4 text-right">
                    <button class="btn btn-success px-5 py-3 shadow-sm" style="border-radius: 12px; font-weight: 700;">
                        <i class="fas fa-save mr-2"></i> POST ALL GRADES
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center mt-5 py-5 card-custom">
                <img src="https://cdn-icons-png.flaticon.com/512/2997/2997300.png" style="width: 100px; opacity: 0.5;" alt="no data">
                <h5 class="mt-4 text-muted">No subject selected. Please choose a subject to load the students.</h5>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>