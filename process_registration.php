<?php
session_start();
include('db_connect.php'); 

if(isset($_POST['register_btn'])) {
    // Pagkuha ng data mula sa Session (Step 2)
    $full_name = mysqli_real_escape_string($conn, $_SESSION['reg_student_name']);
    $roll_number = mysqli_real_escape_string($conn, $_SESSION['reg_roll_number']);
    $grade_level = mysqli_real_escape_string($conn, $_SESSION['reg_grade_level']);
    $gender = mysqli_real_escape_string($conn, $_SESSION['reg_gender']);
    $address = mysqli_real_escape_string($conn, $_SESSION['reg_address']);
    $app_type = mysqli_real_escape_string($conn, $_SESSION['reg_application_type']);
    $image = $_SESSION['reg_image'] ?? 'default.png';

    // Pagkuha ng account details (Step 3)
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); 
    
    // STEP 1: INSERT sa users table
    $query_user = "INSERT INTO users (full_name, email, password, role) 
                   VALUES ('$full_name', '$email', '$password', 'Student')";
    
    if(mysqli_query($conn, $query_user)) {
        // MAHALAGA: Kunin ang bagong ID
        $new_user_id = mysqli_insert_id($conn); 

        // STEP 2: INSERT sa students table gamit ang $new_user_id
        $query_student = "INSERT INTO students (user_id, student_name, roll_number, grade_level, gender, address, status, application_type, image) 
                          VALUES ('$new_user_id', '$full_name', '$roll_number', '$grade_level', '$gender', '$address', 'Pending', '$app_type', '$image')";
        
        if(mysqli_query($conn, $query_student)) {
            // SUCCESS! Linisin ang sessions para fresh start
            unset($_SESSION['reg_student_name']);
            unset($_SESSION['reg_roll_number']);
            unset($_SESSION['reg_grade_level']);
            unset($_SESSION['reg_gender']);
            unset($_SESSION['reg_address']);
            unset($_SESSION['reg_application_type']);
            unset($_SESSION['reg_image']);
            
            header("Location: login.php?msg=Registration Success");
            exit();
        } else {
            echo "Error sa Students Table: " . mysqli_error($conn);
        }
    } else {
        echo "Error sa Users Table: " . mysqli_error($conn);
    }
}
?>