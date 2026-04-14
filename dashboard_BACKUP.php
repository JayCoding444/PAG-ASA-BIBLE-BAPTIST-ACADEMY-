<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Pag-asa Academy</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { margin: 0; background-color: #f0f2f5; display: flex; }

        /* Sidebar */
        .sidebar { width: 220px; background: white; height: 100vh; padding: 20px; border-right: 1px solid #ddd; position: fixed; }
        .logo-box { text-align: center; margin-bottom: 30px; }
        .logo-box img { width: 60px; border-radius: 50%; }
        
        .menu-item { padding: 12px; border-radius: 8px; color: #555; text-decoration: none; display: block; margin-bottom: 10px; font-size: 14px; }
        .active { background-color: #4CAF50; color: white; font-weight: bold; }

        /* Main Content */
        .main-content { margin-left: 220px; flex: 1; display: flex; flex-direction: column; }
        
        /* Top Header */
        .top-header { background: #f8f9fa; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; }
        .user-top { display: flex; align-items: center; gap: 10px; }
        .user-top img { width: 35px; border-radius: 50%; }
        .logout-btn { background: #4CAF50; color: white; padding: 5px 15px; border-radius: 5px; text-decoration: none; font-size: 14px; }

        .dashboard-body { padding: 30px; }
        .welcome-text { font-size: 18px; font-weight: bold; color: #2c3e50; margin-bottom: 20px; }

        /* Stats Cards (Yung tatlo sa taas) */
        .stats-grid { display: flex; gap: 20px; margin-bottom: 25px; }
        .stat-card { background: white; flex: 1; padding: 20px; border-radius: 15px; border: 1px solid #48c9b0; display: flex; align-items: center; gap: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .stat-card .icon { font-size: 24px; color: #555; }
        .stat-card .info { text-align: right; flex: 1; }
        .stat-card .label { font-size: 13px; color: #7f8c8d; }
        .stat-card .value { font-size: 18px; font-weight: bold; }

        /* Profile Sections */
        .profile-grid { display: flex; gap: 20px; }
        .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .profile-card { flex: 1; text-align: center; }
        .details-card { flex: 2; }

        .profile-img { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 3px solid #eee; }
        
        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px; }
        .detail-item { font-size: 14px; }
        .detail-label { color: #7f8c8d; margin-bottom: 3px; }
        .detail-value { font-weight: 600; color: #2c3e50; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo-box">
        <img src="Academy_Logo.jpg" alt="Logo">
    </div>
    <a href="dashboard.php" class="menu-item active">Dashboard</a>
    <a href="#" class="menu-item">Enrolled Subject</a>
    <a href="#" class="menu-item">Schedule of Class</a>
    <a href="grade.php" class="menu-item">Grades</a> <a href="#" class="menu-item">Announcement</a>
    <a href="#" class="menu-item">Attendance</a>
</div>

<div class="main-content">
    <div class="top-header">
        <div>☰ Dashboard</div>
        <div class="user-top">
            <img src="Photo_Sample.jpg" alt="User">
            <span><?php echo $_SESSION['full_name']; ?></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="dashboard-body">
        <div class="welcome-text">Welcome <?php echo $_SESSION['full_name']; ?></div>

        <div class="stats-grid">
            <div class="stat-card">
                <span class="icon">🎓</span>
                <div class="info">
                    <div class="label">G.A</div>
                    <div class="value">95.05</div>
                </div>
            </div>
            <div class="stat-card">
                <span class="icon">👤</span>
                <div class="info">
                    <div class="label">Attendance</div>
                    <div class="value">85%</div>
                </div>
            </div>
            <div class="stat-card">
                <span class="icon">📚</span>
                <div class="info">
                    <div class="label">Subject Enrolled</div>
                    <div class="value">6</div>
                </div>
            </div>
        </div>

        <div class="profile-grid">
            <div class="card profile-card">
                <h3>Your Profile</h3>
                <img src="Photo_Sample.jpg" class="profile-img" alt="Student">
                <div style="font-weight: bold;"><?php echo $_SESSION['full_name']; ?></div>
                <div style="color: #7f8c8d; font-size: 13px;">202110777</div>
            </div>

            <div class="card details-card">
                <h3>Personal Details</h3>
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">Name:</div>
                        <div class="detail-value"><?php echo $_SESSION['full_name']; ?></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Email:</div>
                        <div class="detail-value">Joshua.academy@gmail.com</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Gender:</div>
                        <div class="detail-value">Male</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Section:</div>
                        <div class="detail-value">A</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Grade:</div>
                        <div class="detail-value">12 SHS</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Address:</div>
                        <div class="detail-value">Imus, Cavite</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>