<?php
session_start();
include('db_connect.php');

if(isset($_POST['teacher_login_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Hahanapin natin ang user kung saan ang role ay 'Teacher'
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='Teacher' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        $_SESSION['auth'] = true;
        $_SESSION['auth_role'] = 'Teacher'; 
        $_SESSION['full_name'] = $row['full_name']; // Binago ko ito base sa screenshot mo

        header("Location: teacher_dashboard.php");
        exit();
    } else {
        header("Location: teacher_login.php?error=Account Not Found or Not a Teacher");
        exit();
    }
}
?>