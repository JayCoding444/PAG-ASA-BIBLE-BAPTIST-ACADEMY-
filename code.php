<?php
session_start();
include('dbconfig.php');

// ARCHIVE LOGIC (Soft Delete)
if(isset($_POST['archive_grade_btn'])) {
    $grade_id = $_POST['grade_id'];

    // Imbes na burahin, papalitan lang natin ang status sa 'Archived'
    $query = "UPDATE grades SET status='Archived' WHERE id='$grade_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        header("Location: manage_grading.php?msg=Archived Successfully");
    }
}

// DELETE LOGIC (Permanent Delete)
if(isset($_POST['delete_grade_btn'])) {
    $grade_id = $_POST['grade_id'];

    $query = "DELETE FROM grades WHERE id='$grade_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        header("Location: manage_grading.php?msg=Deleted Permanently");
    }
}
if(isset($_POST['post_announcement'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $admin_name = $_SESSION['full_name']; // Kinukuha ang name ng naka-login

    $query = "INSERT INTO announcements (title, message, posted_by) VALUES ('$title', '$message', '$admin_name')";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        $_SESSION['message'] = "Announcement Posted!";
        header("Location: manage_announcements.php");
        exit(0);
    }
}
?>