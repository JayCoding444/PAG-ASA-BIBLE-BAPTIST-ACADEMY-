<?php
session_start();
include('db_connect.php');

// Security Check: Siguraduhin na Admin lang ang pwedeng mag-approve/reject
if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != 'Admin') {
    header("Location: login.php");
    exit(0);
}

// 1. APPROVE LOGIC
if(isset($_GET['id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['id']);

    // UPDATE query para gawing 'Approved' ang status
    $query = "UPDATE students SET status = 'Approved' WHERE student_id = '$student_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        $_SESSION['message'] = "Student application has been APPROVED successfully!";
        header("Location: admin_approval.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error during approval: " . mysqli_error($conn);
        header("Location: admin_approval.php");
        exit(0);
    }
}

// 2. REJECT LOGIC
if(isset($_GET['reject_id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['reject_id']);

    // UPDATE query para gawing 'Rejected' ang status
    $query = "UPDATE students SET status = 'Rejected' WHERE student_id = '$student_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        $_SESSION['message'] = "Student application has been REJECTED.";
        header("Location: admin_approval.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error during rejection: " . mysqli_error($conn);
        header("Location: admin_approval.php");
        exit(0);
    }
}

// Safety fallback: Kapag walang valid na ID, balik sa dashboard
header("Location: admin_approval.php");
exit(0);
?>