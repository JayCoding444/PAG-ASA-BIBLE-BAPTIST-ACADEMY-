<?php
session_start();
include('db_connect.php');

// SAVE ACTION
if(isset($_POST['save_announcement'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $target = mysqli_real_escape_string($conn, $_POST['target_audience']);

    $query = "INSERT INTO announcements (title, description, target_audience) VALUES ('$title', '$description', '$target')";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        $_SESSION['status'] = "Announcement Posted!";
        header("Location: manage_announcements.php");
        exit(0);
    }
}

// DELETE ACTION
if(isset($_POST['delete_announcement'])) {
    $id = $_POST['announcement_id'];
    // Ginamit ang 'id' column base sa database screenshot
    $query = "DELETE FROM announcements WHERE id = '$id'";
    $query_run = mysqli_query($conn, $query);
    header("Location: manage_announcements.php");
    exit(0);
}
if(isset($_POST['save_announcement'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $target = mysqli_real_escape_string($conn, $_POST['target_audience']);
    
    // Kinukuha ang pangalan ng Admin mula sa session
    $admin_name = $_SESSION['auth_user']['user_name'] ?? 'School Admin';

    // Update query para kasama ang message at posted_by
    $query = "INSERT INTO announcements (title, description, target_audience, message, posted_by) 
              VALUES ('$title', '$description', '$target', '$description', '$admin_name')";
    $query_run = mysqli_query($conn, $query);

    header("Location: manage_announcements.php");
    exit(0);
}
?>