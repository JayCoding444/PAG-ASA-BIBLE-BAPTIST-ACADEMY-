<?php
session_start();
include('db_connect.php');

if(isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // --- STEP A: I-CHECK KUNG ADMIN ---
    // Ginagamit nito ang 'users' table mo para sa Admin accounts
    $admin_query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='Admin' LIMIT 1";
    $admin_run = mysqli_query($conn, $admin_query);

    if(mysqli_num_rows($admin_run) > 0) {
        $row = mysqli_fetch_array($admin_run);
        
        $_SESSION['auth'] = true;
        $_SESSION['auth_role'] = "Admin";
        $_SESSION['auth_user'] = [
            'user_id' => $row['user_id'],
            'user_name' => $row['username']
        ];

        $_SESSION['message'] = "Welcome to Admin Dashboard!";
        header("Location: admin_dashboard.php");
        exit(0);
    }

    // --- STEP B: KUNG HINDI ADMIN, I-CHECK KUNG STUDENT ---
    // Ginagamit nito ang 'students' table para sa mga nag-register
    $student_query = "SELECT * FROM students WHERE username='$username' AND password='$password' LIMIT 1";
    $student_run = mysqli_query($conn, $student_query);

    if(mysqli_num_rows($student_run) > 0) {
        $row = mysqli_fetch_array($student_run);

        // Check kung Pending pa ang status 
        if($row['status'] == 'Pending') {
            $_SESSION['message'] = "Your account is still pending for approval.";
            header("Location: login.php");
            exit(0);
        }

        $_SESSION['auth'] = true;
        $_SESSION['auth_role'] = "Student";
        $_SESSION['auth_user'] = [
            'user_id' => $row['student_id'],
            'user_name' => $row['student_name'],
            'user_email' => $row['email']
        ];

        $_SESSION['message'] = "Welcome to Student Dashboard!";
        header("Location: student_dashboard.php");
        exit(0);
    }

    // --- STEP C: KUNG PAREHONG MALI ---
    $_SESSION['message'] = "Invalid Username or Password";
    header("Location: login.php");
    exit(0);
}
?>