<?php
session_start();
// Kung naka-login na, i-direct na agad sa dashboard para hindi na mag-login ulit
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
    <title>Login - Pag-asa Bible Baptist Academy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { margin: 0; background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-wrapper { display: flex; width: 100%; max-width: 1000px; align-items: center; justify-content: center; gap: 50px; padding: 20px; }
        .left-side { text-align: center; flex: 1; }
        .left-side img { width: 250px; margin-bottom: 20px; border-radius: 50%; border: 2px solid #ccc; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .right-side { flex: 1; display: flex; flex-direction: column; align-items: center; background: white; padding: 40px; border-radius: 20px; shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .right-side form { width: 100%; max-width: 350px; display: flex; flex-direction: column; }
        .password-box { position: relative; width: 100%; margin-bottom: 15px; }
        .right-side input { padding: 15px; width: 100%; border: 1px solid #ddd; border-radius: 10px; font-size: 16px; outline: none; transition: 0.3s; }
        .right-side input:focus { border-color: #2e7d32; box-shadow: 0 0 8px rgba(46,125,50,0.2); }
        .show-hide-btn { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 12px; font-weight: bold; color: #7f8c8d; text-transform: uppercase; user-select: none; }
        .login-btn { padding: 15px; background-color: #2e7d32; color: white; border: none; border-radius: 10px; font-size: 18px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .login-btn:hover { background-color: #1b5e20; }
        .links-container { text-align: center; margin-top: 20px; font-size: 14px; }
        .links-container a { color: #2e7d32; text-decoration: none; font-weight: bold; }
        .links-container a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="left-side d-none d-md-block">
        <img src="Academy_Logo.jpg" alt="School Logo">
        <h2 class="font-weight-bold">Pag-asa Academy</h2>
        <p class="text-muted">A place where faith and knowledge meet</p>
    </div>

    <div class="right-side shadow">
        <form action="authenticate.php" method="POST">
            <h4 class="text-center font-weight-bold mb-4">Account Login</h4>

            <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-danger py-2 small text-center"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
            <?php endif; ?>

            <input type="text" name="username" placeholder="Username / Email" required class="mb-3">
            
            <div class="password-box">
                <input type="password" name="password" id="passInput" placeholder="Password" required>
                <span id="toggleText" class="show-hide-btn">Show</span>
            </div>

            <button type="submit" name="login_btn" class="login-btn mt-2">Login</button>
            
            <div class="links-container">
                <a href="teacher_login.php">Login as Teacher?</a>
                <p class="mt-3">Want to Enroll? <a href="registration.php">Register here</a></p>
                <p class="small text-muted">Old Student? <a href="re_enrollment.php">Re-enroll here</a></p>
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

</body>
</html>