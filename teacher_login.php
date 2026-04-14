<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login - Pag-asa Bible Baptist Academy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* Blue gradient para sa Teacher Theme */
            background: linear-gradient(135deg, #1a5276 0%, #2980b9 100%);
        }

        .login-container {
            background: white;
            width: 900px;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        /* Left Side: Branding */
        .left-panel {
            background-color: #f8f9fa;
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-right: 1px solid #eee;
        }

        .left-panel img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .left-panel h2 {
            color: #1a5276;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .left-panel p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        /* Right Side: Form */
        .right-panel {
            flex: 1.2;
            padding: 50px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-panel h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #1a5276;
        }

        .form-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #f0f0f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s;
            outline: none;
        }

        .form-group input:focus {
            border-color: #1a5276;
            background-color: #fff;
            box-shadow: 0 0 8px rgba(26, 82, 118, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
            font-size: 14px;
            font-weight: 600;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background-color: #1a5276;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .login-btn:hover {
            background-color: #154360;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 82, 118, 0.3);
        }

        .switch-portal {
            text-align: center;
            margin-top: 25px;
        }

        .switch-portal a {
            color: #1a5276;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .switch-portal a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 90%;
                margin: 20px;
            }
            .left-panel {
                padding: 30px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="left-panel">
        <img src="Academy_Logo.jpg" alt="PBA Logo">
        <h2>Teacher Portal</h2>
        <p>Access your dashboard to manage student grades, schedules, and class announcements.</p>
    </div>

    <div class="right-panel">
        <h1>Welcome Back!</h1>
        
        <form action="authenticate_teacher.php" method="POST">
            <div class="form-group">
                <i class="fas fa-user-tie"></i>
                <input type="text" name="username" placeholder="Teacher Username" required>
            </div>
            
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="teachPassInput" placeholder="Password" required>
                <span id="teachToggleText" class="password-toggle">SHOW</span>
            </div>

            <button type="submit" name="teacher_login_btn" class="login-btn">
                LOGIN AS TEACHER
            </button>
            
            <div class="switch-portal">
                <a href="login.php">
                    <i class="fas fa-user-graduate mr-1"></i> Not a teacher? <strong>Student Login here</strong>
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const teachBtn = document.getElementById('teachToggleText');
    const teachInput = document.getElementById('teachPassInput');

    teachBtn.addEventListener('click', function () {
        if (teachInput.type === 'password') {
            teachInput.type = 'text';
            teachBtn.textContent = 'HIDE';
        } else {
            teachInput.type = 'password';
            teachBtn.textContent = 'SHOW';
        }
    });
</script>

</body>
</html> 