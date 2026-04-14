<?php
session_start();
include('db_connect.php');

if(isset($_POST['reenroll_btn'])) {
    $roll_num = mysqli_real_escape_string($conn, $_POST['roll_number']);
    $new_grade = mysqli_real_escape_string($conn, $_POST['new_grade']);

    // Check muna kung valid ang roll number
    $check_student = "SELECT * FROM students WHERE roll_number='$roll_num' LIMIT 1";
    $result = mysqli_query($conn, $check_student);

    if(mysqli_num_rows($result) > 0) {
        $student_data = mysqli_fetch_array($result);
        $full_name = $student_data['parent_name']; 

        // FIXED QUERY: Nilagyan ng comma (,) pagkatapos ng 'Pending'
        $update_query = "UPDATE students SET 
                         grade_level = '$new_grade', 
                         status = 'Pending', 
                         application_type = 'Re-enrollment' 
                         WHERE roll_number = '$roll_num'";

        $query_run = mysqli_query($conn, $update_query);

        if($query_run) {
            $_SESSION['student_name'] = $full_name;
            $_SESSION['roll_number'] = $roll_num;
            $_SESSION['message'] = "Re-enrollment application submitted successfully!";
            header("Location: registration_success.php");
            exit(0);
        } else {
            die("Database Error: " . mysqli_error($conn));
        }
    } else {
        $_SESSION['message'] = "Roll Number not found. Please check and try again.";
        header("Location: re_enrollment.php");
        exit(0);
    }
}