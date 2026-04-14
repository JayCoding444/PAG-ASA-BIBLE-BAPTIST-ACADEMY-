<?php
session_start();
include('db_connect.php'); 

if(isset($_POST['register_btn'])) {
    // 1. Pagkuha at pag-sanitize ng data mula sa form
    // Pinagsama ang First, Middle, at Last Name para sa 'parent_name' column
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $full_name = trim("$first_name $middle_name $last_name");

    $grade_level = mysqli_real_escape_string($conn, $_POST['grade_to_enter']);
    $gender = mysqli_real_escape_string($conn, $_POST['sex']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $parent_contact = mysqli_real_escape_string($conn, $_POST['phone']); // Gagamitin ang phone field para sa parent_contact column
    
    // 2. Pag-generate ng Random Roll Number
    // Importante ito para maiwasan ang "Duplicate entry" error sa roll_number column
    $roll_number = "PBA-" . date("Y") . "-" . rand(1000, 9999);
    $status = "Pending";

    // 3. INSERT QUERY - Siguraduhing tugma ang column names sa DB
    // Columns: roll_number, grade_level, gender, parent_name, parent_contact, address, status
    // Sa iyong INSERT query, idagdag ang 'Registration'
$query = "INSERT INTO students (roll_number, grade_level, gender, parent_name, parent_contact, address, status, application_type) 
          VALUES ('$roll_number', '$grade_level', '$gender', '$full_name', '$parent_contact', '$address', 'Pending', 'Registration')";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        // I-save ang data sa session para sa Success Page
        $_SESSION['student_name'] = $full_name;
        $_SESSION['roll_number'] = $roll_number;
        
        // Redirect sa bagong Success Page imbes na sa registration.php lang
        header("Location: registration_success.php");
        exit(0);
    } else {
        // Kapag nag-error, ipakita ang detalye para madaling ayusin
        $_SESSION['message'] = "Registration Failed: " . mysqli_error($conn);
        header("Location: registration.php");
        exit(0);
    }
} else {
    header("Location: registration.php");
    exit(0);
}
?>