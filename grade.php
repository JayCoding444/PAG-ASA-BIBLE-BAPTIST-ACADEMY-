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
    <title>Grades - Pag-asa Academy</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { margin: 0; background-color: #f0f2f5; display: flex; }

        /* Sidebar - Same sa Dashboard */
        .sidebar { width: 220px; background: white; height: 100vh; padding: 20px; border-right: 1px solid #ddd; position: fixed; }
        .logo-box { text-align: center; margin-bottom: 30px; }
        .logo-box img { width: 60px; border-radius: 50%; }
        .menu-item { padding: 12px; border-radius: 8px; color: #555; text-decoration: none; display: block; margin-bottom: 10px; font-size: 14px; }
        .active { background-color: #4CAF50; color: white; font-weight: bold; }

        /* Main Content Area */
        .main-content { margin-left: 220px; flex: 1; min-height: 100vh; }
        
        .top-header { background: #f8f9fa; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; }
        .user-top { display: flex; align-items: center; gap: 10px; }
        .user-top img { width: 35px; border-radius: 50%; }
        .logout-btn { background: #4CAF50; color: white; padding: 5px 15px; border-radius: 5px; text-decoration: none; font-size: 14px; }

        .content-body { padding: 30px; }

        /* Grade Card Container */
        .grade-card { 
            background: white; 
            padding: 20px; 
            border-radius: 15px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
            margin-bottom: 30px; 
            border: 1px solid #ddd;
        }

        .grade-card h3 { margin-top: 0; color: #2c3e50; font-size: 18px; margin-bottom: 15px; }

        /* Table Styling - Literal gaya ng sa pic */
        .grade-table { width: 100%; border-collapse: collapse; overflow: hidden; border-radius: 10px; border: 1px solid #4CAF50; }
        .grade-table thead { background-color: #38a169; color: white; }
        .grade-table th, .grade-table td { padding: 12px 20px; text-align: left; border: 1px solid #c6e6d5; }
        
        /* Alternating row colors gaya ng sa pic */
        .grade-table tbody tr { background-color: #e6f4ea; }
        .grade-table tbody tr:nth-child(even) { background-color: #f0f9f4; }
        
        .grade-table td:last-child, .grade-table th:last-child { text-align: center; width: 150px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo-box">
        <img src="Academy_Logo.jpg" alt="Logo">
    </div>
    <a href="dashboard.php" class="menu-item">Dashboard</a>
    <a href="#" class="menu-item">Enrolled Subject</a>
    <a href="#" class="menu-item">Schedule of Class</a>
    <a href="grade.php" class="menu-item active">Grades</a> <a href="#" class="menu-item">Announcement</a>
    <a href="#" class="menu-item">Attendance</a>
</div> 

<div class="main-content">
    <div class="top-header">
        <div>☰ Grades</div>
        <div class="user-top">
            <img src="Photo_Sample.jpg" alt="User">
            <span>Joshua Mabanglo</span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="content-body">
        
        <div class="grade-card">
            <h3>First Grading</h3>
            <table class="grade-table">
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Filipino</td><td>98</td></tr>
                    <tr><td>Math</td><td>89</td></tr>
                    <tr><td>Science</td><td>90</td></tr>
                    <tr><td>English</td><td>87</td></tr>
                </tbody>
            </table>
        </div>

        <div class="grade-card">
            <h3>Second Grading</h3>
            <table class="grade-table">
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Filipino</td><td>98</td></tr>
                    <tr><td>Math</td><td>89</td></tr>
                    <tr><td>Science</td><td>90</td></tr>
                    <tr><td>English</td><td>86</td></tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>