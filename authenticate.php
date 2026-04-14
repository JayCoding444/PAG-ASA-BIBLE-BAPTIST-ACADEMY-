<?php
session_start();
include('db_connect.php');

if(isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // I-check sa database (Palitan ang 'users' ng tamang table name mo)
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) > 0) {
        $row = mysqli_fetch_array($query_run);

        // I-set ang Session Data
        $_SESSION['auth'] = true;
        $_SESSION['auth_role'] = $row['role']; // 'Student' or 'Admin'
        $_SESSION['auth_user'] = [
            'user_id' => $row['id'],
            'user_name' => $row['username'],
        ];
        $_SESSION['full_name'] = $row['full_name']; // Para lumabas sa Dashboard

        // REDIRECTION LOGIC
        if($_SESSION['auth_role'] == 'Student') {
            header("Location: student_dashboard.php"); // Dito papasok sa bago mong UI
            exit(0);
        } elseif($_SESSION['auth_role'] == 'Admin') {
            header("Location: admin_dashboard.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Invalid Username or Password";
        header("Location: login.php");
        exit(0);
    }
}
?>