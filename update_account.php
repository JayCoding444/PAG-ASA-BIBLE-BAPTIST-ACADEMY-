<?php
session_start();
include('db_connect.php');

if(isset($_POST['update_account'])) {
    $user_id = $_SESSION['auth_user']['user_id'];
    
    // Kunin ang mga inputs mula sa form
    $parent_name = mysqli_real_escape_string($conn, $_POST['parent_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_no = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    
    // 1. I-verify muna kung tama ang Current Password
    $check_pwd_query = "SELECT password, image FROM students WHERE user_id='$user_id' LIMIT 1";
    $result = mysqli_query($conn, $check_pwd_query);
    $data = mysqli_fetch_assoc($result);
    $old_image = $data['image'];

    // Note: Kung ang password mo ay plain text, gamitin ang direct comparison. 
    // Kung hashed (password_hash), gamitin ang password_verify().
    if($current_password == $data['password']) {
        
        // 2. Handle Profile Picture Upload
        $image = $_FILES['image']['name'];
        if($image != NULL) {
            $image_extension = pathinfo($image, PATHINFO_EXTENSION);
            $filename = time().'.'.$image_extension; // Rename para walang duplicate
            $update_filename = $filename;
        } else {
            $update_filename = $old_image; // Gamitin ang luma kung walang bagong upload
        }

        // 3. Update Query (Kasama ang password kung may bagong input)
        if(!empty($new_password)) {
            $update_query = "UPDATE students SET 
                parent_name='$parent_name', 
                email='$email', 
                contact_no='$contact_no', 
                gender='$gender', 
                address='$address', 
                password='$new_password', 
                image='$update_filename' 
                WHERE user_id='$user_id'";
        } else {
            $update_query = "UPDATE students SET 
                parent_name='$parent_name', 
                email='$email', 
                contact_no='$contact_no', 
                gender='$gender', 
                address='$address', 
                image='$update_filename' 
                WHERE user_id='$user_id'";
        }

        $query_run = mysqli_query($conn, $update_query);

        if($query_run) {
            // I-move ang file sa folder kung nag-upload
            if($image != NULL) {
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/'.$update_filename);
            }
            
            $_SESSION['message'] = "Account Updated Successfully";
            header("Location: account_settings.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Something went wrong!";
            header("Location: account_settings.php");
            exit(0);
        }

    } else {
        $_SESSION['message'] = "Current Password does not match!";
        header("Location: account_settings.php");
        exit(0);
    }
}
?>