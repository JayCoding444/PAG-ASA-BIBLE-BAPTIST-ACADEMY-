<?php
session_start();
// Redirect kung naka-login na ang teacher
if(isset($_SESSION['auth']) && $_SESSION['auth_role'] == 'Teacher') {
    header("Location: teacher_dashboard.php");
    exit(0);
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal | Pag-asa Academy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --teacher-blue: #2c3e50; /* Mas dark blue para maiba sa student green */
            --glass-bg: rgba(255, 255, 255, 0.9);
        }

        body { 
            margin: 0; 
            background-image: url('pag-asa_school.jpg'); /* Consistent background image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6); /* Slightly darker overlay */
            z-index: 1;
        }

        .login-wrapper { 
            display: flex; 
            width: 100%; 
            max-width: 1100px; 
            align-items: center; 
            justify-content: center; 
            padding: 20px; 
            position: relative;
            z-index: 2;
        }

        .left-side { 
            text-align: center; 
            flex: 1; 
            padding-right: 50px;
        }

        /* Circular Logo Style */
        .left-side .logo-container {
            width: 250px; 
            height: 250px;
            margin: 0 auto 30px auto; 
            border-radius: 50%;
            overflow: hidden;
            border: 8px solid #fff;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .left-side img { 
            width: 90%; 
            height: auto;
            object-fit: contain;
        }

        .right-side { 
            flex: 0.75; 
            background: var(--glass-bg); 
            backdrop-filter: blur(15px);
            padding: 50px 45px; 
            border-radius: 24px; 
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .right-side h4 {
            color: var(--teacher-blue);
            font-weight: 700;
            margin-bottom: 5px;
        }

        .form-control { 
            padding: 25px 15px; 
            border: 2px solid #eee; 
            border-radius: 12px; 
            transition: 0.3s; 
            background: #f9f9f9;
        }

        .form-control:focus { 
            border-color: var(--teacher-blue); 
            box-shadow: 0 0 10px rgba(44, 62, 80, 0.1); 
        }

        .login-btn { 
            width: 100%;
            padding: 14px; 
            background: linear-gradient(to right, #2c3e50, #34495e);
            color: white; 
            border: none; 
            border-radius: 12px; 
            font-weight: 600; 
            transition: 0.4s ease; 
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .login-btn:hover { 
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
            color: #fff;
        }

        .links-container { 
            text-align: center; 
            margin-top: 25px; 
            font-size: 14px;
        }

        .student-link {
            display: block;
            margin-top: 15px;
            padding: 10px;
            border: 1px dashed var(--teacher-blue);
            border-radius: 10px;
            color: var(--teacher-blue);
            text-decoration: none;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .left-side { padding-right: 0; margin-bottom: 40px; }
            .left-side .logo-container { width: 200px; height: 200px; }
        }
        @media (max-width: 768px) {
            .login-wrapper { flex-direction: column; }
            .right-side { width: 100%; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="left-side d-none d-md-block">
        <div class="logo-container">
            <img src="Academy_Logo.jpg" alt="School Logo">
        </div>
        <h1 class="font-weight-bold" style="color: #fff; font-size: 3rem;">Teacher Portal</h1>
        <p style="color: rgba(255,255,255,0.8);">Access your dashboard to manage student records</p>
    </div>

    <div class="right-side">
        <form action="teacher_authenticate.php" method="POST">
            <h4 class="text-center">Welcome Back, Teacher!</h4>
            <p class="text-center text-muted small mb-4">Please enter your credentials</p>

            <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-danger py-2 small text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
            <?php endif; ?>

            <div class="form-group mb-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0" style="border-radius: 12px 0 0 12px;"><i class="fas fa-user-tie text-muted"></i></span>
                    </div>
                    <input type="text" name="username" placeholder="Teacher Username" required class="form-control border-left-0" style="border-radius: 0 12px 12px 0;">
                </div>
            </div>
            
            <div class="form-group mb-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0" style="border-radius: 12px 0 0 12px;"><i class="fas fa-lock text-muted"></i></span>
                    </div>
                    <input type="password" name="password" id="passInput" placeholder="Password" required class="form-control border-left-0" style="border-radius: 0 12px 12px 0;">
                </div>
            </div>

            <button type="submit" name="teacher_login_btn" class="login-btn">
                LOGIN AS TEACHER <i class="fas fa-sign-in-alt ml-2"></i>
            </button>
            
            <div class="links-container">
                <a href="login.php" class="student-link">
                    <i class="fas fa-user-graduate mr-1"></i> Not a teacher? Student Login here
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>