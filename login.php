<?php
session_start();
// Redirect kung naka-login na para iwas double login
if(isset($_SESSION['auth'])) {
    if($_SESSION['auth_role'] == 'Student') {
        header("Location: student_dashboard.php");
        exit(0);
    } elseif($_SESSION['auth_role'] == 'Admin') {
        header("Location: admin_dashboard.php");
        exit(0); 
    }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Pag-asa Bible Baptist Academy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-green: #2e7d32;
            --hover-green: #1b5e20;
            --glass-bg: rgba(255, 255, 255, 0.9);
        }

        body { 
            margin: 0; 
            /* CHANGE 1: Maglagay ng background image ng school */
            background-image: url('pag-asa_school.jpg'); /* Siguraduhing tama ang filename at path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            position: relative;
        }

        /* CHANGE 2: Maglagay ng dark overlay para malinaw ang text */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* 50% opacity na itim */
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
            z-index: 2; /* Para nasa ibabaw ng overlay */
        }

        .left-side { 
            text-align: center; 
            flex: 1; 
            padding-right: 50px;
        }

        /* CHANGE 3: Gawing circle ang logo */
        .left-side .logo-container {
            width: 250px; 
            height: 250px;
            margin: 0 auto 30px auto; 
            border-radius: 50%;
            overflow: hidden; /* Importante para sa circle */
            border: 8px solid #fff; /* White border para stand out */
            box-shadow: 0 15px 35px rgba(0,0,0,0.3); /* Mas matapang na anino */
            background-color: #fff; /* Background color kung transparent ang logo */
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.5s ease;
        }
        
        .left-side img { 
            width: 90%; /* Scale down kaunti para may padding sa loob ng circle */
            height: auto;
            object-fit: contain; /* Para hindi ma-stretch ang logo */
        }
        
        .left-side .logo-container:hover {
            transform: scale(1.05);
        }

        .right-side { 
            flex: 0.75; 
            background: var(--glass-bg); 
            backdrop-filter: blur(15px); /* Mas blurred na background */
            padding: 50px 45px; 
            border-radius: 24px; 
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.3);
        }

        /* Ang ibang styles ay pareho lang sa nauna */
        .right-side h4 {
            color: #333;
            font-weight: 700;
            margin-bottom: 30px;
            letter-spacing: -0.5px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .form-control { 
            padding: 25px 15px; 
            border: 2px solid #eee; 
            border-radius: 12px; 
            font-size: 15px; 
            transition: 0.3s; 
            background: #f9f9f9;
        }

        .form-control:focus { 
            border-color: var(--primary-green); 
            background: #fff;
            box-shadow: 0 0 10px rgba(46,125,50,0.1); 
        }

        .password-box { position: relative; }

        .show-hide-btn { 
            position: absolute; 
            right: 15px; 
            top: 50%; 
            transform: translateY(-50%); 
            cursor: pointer; 
            font-size: 13px; 
            font-weight: 600; 
            color: var(--primary-green); 
            text-transform: uppercase; 
            z-index: 10;
        }

        .login-btn { 
            width: 100%;
            padding: 14px; 
            background: linear-gradient(to right, #2e7d32, #43a047);
            color: white; 
            border: none; 
            border-radius: 12px; 
            font-size: 16px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: 0.4s ease; 
            box-shadow: 0 8px 20px rgba(46, 125, 50, 0.2);
        }

        .login-btn:hover { 
            background: linear-gradient(to right, #1b5e20, #2e7d32);
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(46, 125, 50, 0.3);
            color: #fff;
        }

        .links-container { 
            text-align: center; 
            margin-top: 25px; 
            font-size: 14px; 
            color: #666;
        }

        .links-container a { 
            color: var(--primary-green); 
            text-decoration: none; 
            font-weight: 600; 
            transition: 0.2s;
        }

        .links-container a:hover { 
            color: var(--hover-green);
            text-decoration: underline; 
        }

        .teacher-link {
            display: block;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px dashed var(--primary-green);
            border-radius: 10px;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .left-side { padding-right: 0; margin-bottom: 40px; }
            .left-side .logo-container { width: 200px; height: 200px; }
        }
        @media (max-width: 768px) {
            .login-wrapper { flex-direction: column; }
            .right-side { width: 100%; padding: 35px 25px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="left-side d-none d-md-block">
        <div class="logo-container">
            <img src="Academy_Logo.jpg" alt="School Logo">
        </div>
        <h1 class="font-weight-bold" style="color: #fff; font-size: 3rem; letter-spacing: -1px;">Pag-asa Academy</h1>
        <p style="color: rgba(255,255,255,0.8); font-size: 1.1rem;">A place where faith and knowledge meet</p>
    </div>

    <div class="right-side">
        <form action="login_logic.php" method="POST">
            <h4 class="text-center">Welcome Back!</h4>

            <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-danger py-2 small text-center" style="border-radius: 10px;">
                    <i class="fas fa-exclamation-circle mr-1"></i> <?= $_SESSION['message']; unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>

            <div class="input-group">
                <input type="text" name="username" placeholder="Username / Email" required class="form-control">
            </div>
            
            <div class="password-box input-group">
                <input type="password" name="password" id="passInput" placeholder="Password" required class="form-control">
                <span id="toggleText" class="show-hide-btn">Show</span>
            </div>

            <button type="submit" name="login_btn" class="login-btn mt-3">
                Login <i class="fas fa-arrow-right ml-2"></i>
            </button>
            
            <div class="links-container">
                <a href="teacher_login.php" class="teacher-link">
                    <i class="fas fa-chalkboard-teacher mr-1"></i> Are you a Teacher? Login here
                </a>
                <p>New student? <a href="register_agreement.php">Create an Account</a></p>
                <p class="small">Returning student? <a href="re_enrollment.php">Re-enrollment</a></p>
            </div>
        </form>
    </div>
</div>

<script>
    const btn = document.getElementById('toggleText');
    const input = document.getElementById('passInput');
    btn.addEventListener('click', function () {
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = 'Hide';
        } else {
            input.type = 'password';
            btn.textContent = 'Show';
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>