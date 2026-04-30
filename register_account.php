<?php
session_start();
include('db_connect.php'); // Siguraduhin na tama ang database connection file mo

// Security Check: Dapat galing sila sa Step 2
if(!isset($_SESSION['reg_student_name'])) {
    header("Location: registration.php");
    exit();
}

if(isset($_POST['submit_registration'])) {
    // Kunin ang account details mula sa form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); 
    // Note: Mas mainam kung gagamit ka ng password_hash() para sa security

    // Kunin ang personal details mula sa session (Step 2)
    $name = $_SESSION['reg_student_name'];
    $roll = $_SESSION['reg_roll_number'];
    $grade = $_SESSION['reg_grade_level'];
    $gender = $_SESSION['reg_gender'];
    $address = $_SESSION['reg_address'];
    $app_type = $_SESSION['reg_application_type'];
    $image = isset($_SESSION['reg_image']) ? $_SESSION['reg_image'] : '';

    // SQL Insert query base sa structure ng table mo
    // Dapat mag-match ang column count
$query = "INSERT INTO students (
            roll_number, 
            grade_level, 
            gender, 
            student_name, 
            address, 
            status, 
            application_type, 
            password, 
            email, 
            username, 
            image, 
            contact_no
          ) 
          VALUES (
            '$roll', 
            '$grade', 
            '$gender', 
            '$name', 
            '$address', 
            'Pending', 
            '$app_type', 
            '$password', 
            '$email', 
            '$username', 
            '$image', 
            ''
          )";
    if(mysqli_query($conn, $query)) {
        // Clear sessions pagkatapos ng successful registration
        session_unset();
        session_destroy();
        echo "<script>alert('Application Submitted! Please wait for Admin Approval.'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBA - Account Setup</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('pag-asa_school.jpg'); 
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .account-card {
            background: #ffffff;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
            margin: auto;
        }
        .school-logo-circle {
            width: 90px; height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #2e7d32;
            margin-bottom: 15px;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px;
            height: 50px;
        }
        .btn-submit {
            background-color: #2e7d32;
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 12px;
            width: 100%;
            border: none;
            transition: 0.3s;
        }
        .btn-submit:hover {
            background-color: #1b5e20;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="account-card text-center">
        <img src="Academy_Logo.jpg" class="school-logo-circle" alt="Logo">
        <h4 class="font-weight-bold">Account Setup</h4>
        <p class="text-muted small mb-4">Step 3 of 3: Create your portal credentials</p>

        <form action="" method="POST">
            <div class="form-group text-left">
                <label class="small font-weight-bold">Username</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light border-right-0 rounded-left"><i class="fas fa-user text-muted"></i></span>
                    </div>
                    <input type="text" name="username" class="form-control border-left-0" placeholder="Enter username" required>
                </div>
            </div>

            <div class="form-group text-left">
                <label class="small font-weight-bold">Email Address</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light border-right-0 rounded-left"><i class="fas fa-envelope text-muted"></i></span>
                    </div>
                    <input type="email" name="email" class="form-control border-left-0" placeholder="example@email.com" required>
                </div>
            </div>

            <div class="form-group text-left">
                <label class="small font-weight-bold">Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light border-right-0 rounded-left"><i class="fas fa-lock text-muted"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control border-left-0" placeholder="Enter secure password" required>
                </div>
            </div>

            <button type="submit" name="submit_registration" class="btn btn-submit mt-3">
                SUBMIT APPLICATION <i class="fas fa-paper-plane ml-2"></i>
            </button>
            
            <div class="mt-4">
                <a href="registration.php" class="text-muted small"><i class="fas fa-arrow-left mr-1"></i> Back to Personal Details</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>