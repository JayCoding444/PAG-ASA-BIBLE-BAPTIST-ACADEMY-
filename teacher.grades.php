<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Grades - Pag-asa Academy</title>
    <style>
        /* I-copy ang CSS mula sa dashboard sa taas para pareho ang sidebar */
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { margin: 0; background-color: #f0f2f5; display: flex; }
        .sidebar { width: 230px; background: white; height: 100vh; padding: 20px; border-right: 1px solid #ddd; position: fixed; }
        .main-content { margin-left: 230px; flex: 1; padding: 30px; }
        .menu-item { padding: 12px; border-radius: 8px; color: #555; text-decoration: none; display: block; margin-bottom: 10px; }
        .active { background-color: #1a5276; color: white; }
        table { width: 100%; background: white; border-collapse: collapse; border-radius: 10px; overflow: hidden; }
        th, td { padding: 15px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #1a5276; color: white; }
        input[type="number"] { width: 60px; padding: 5px; }
        .save-btn { background: #2e7d32; color: white; border: none; padding: 5px 15px; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>

<div class="sidebar">
    <div style="text-align:center; margin-bottom:20px;">
        <img src="img/logo.png" style="width:60px; border-radius:50%;">
    </div>
    <a href="teacher_dashboard.php" class="menu-item">Dashboard</a>
    <a href="teacher_grades.php" class="menu-item active">Input Grades</a>
    <a href="login.php" class="menu-item" style="color:red;">Logout</a>
</div>

<div class="main-content">
    <h2>Input Student Grades</h2>
    <p>Subject: <strong>Filipino</strong> | Section: <strong>Grade 11-A</strong></p>
    
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>1st Grad</th>
                <th>2nd Grad</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>202110777</td>
                <td>Sairra Mae Lagarto</td>
                <td><input type="number" value="98"></td>
                <td><input type="number" value="98"></td>
                <td><button class="save-btn">Save</button></td>
            </tr>
            <tr>
                <td>202110888</td>
                <td>Joshua Mabanglo</td>
                <td><input type="number" value="85"></td>
                <td><input type="number" value="87"></td>
                <td><button class="save-btn">Save</button></td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>