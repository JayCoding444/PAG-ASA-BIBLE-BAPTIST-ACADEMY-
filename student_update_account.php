<?php
session_start();
include('db_connect.php');

if(isset($_POST['update_account_btn'])) {
    $user_id = $_SESSION['auth_user']['user_id'];
    
    // Kunin ang mga inputs mula sa form [cite: 22, 23]
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    
    // 1. I-verify ang Current Password at kunin ang lumang image [cite: 24, 25]
    $check_pwd_query = "SELECT password, image FROM students WHERE user_id='$user_id' LIMIT 1";
    $result = mysqli_query($conn, $check_pwd_query);
    $data = mysqli_fetch_assoc($result);
    $old_image = $data['image'];

    // 2. Check kung tama ang Current Password [cite: 27]
    if($current_password == $data['password']) {
        
        // Handle Profile Picture Upload [cite: 28, 29]
        $image = $_FILES['image']['name'];
        if($image != NULL) {
            $image_extension = pathinfo($image, PATHINFO_EXTENSION);
            $update_filename = time().'.'.$image_extension; // Rename file [cite: 29]
        } else {
            $update_filename = $old_image; // Gamitin ang luma kung walang bago [cite: 30]
        }

        // 3. Update Query (Dynamic: kasama ang password kung may bagong input) [cite: 31, 33]
        if(!empty($new_password)) {
            $update_query = "UPDATE students SET 
                email='$email', 
                contact_no='$contact_no', 
                gender='$gender', 
                address='$address', 
                password='$new_password', 
                image='$update_filename' 
                WHERE user_id='$user_id'";
        } else {
            $update_query = "UPDATE students SET 
                email='$email', 
                contact_no='$contact_no', 
                gender='$gender', 
                address='$address', 
                image='$update_filename' 
                WHERE user_id='$user_id'";
        }

        $query_run = mysqli_query($conn, $update_query);

        if($query_run) {
    // ... file move logic ...
    $_SESSION['message'] = "Account Updated Successfully";
    $_SESSION['message_type'] = "success"; // Green
    header("Location: student_account_settings.php");
    exit(0);
} else {
    $_SESSION['message'] = "Something went wrong!";
    $_SESSION['message_type'] = "danger"; // Red
    header("Location: student_account_settings.php");
    exit(0);
}
// ...
} else {
    $_SESSION['message'] = "Current Password does not match!";
    $_SESSION['message_type'] = "danger"; // Red
    header("Location: student_account_settings.php");
    exit(0);
}
} else {
    header("Location: student_account_settings.php");
    exit(0);
}
?>