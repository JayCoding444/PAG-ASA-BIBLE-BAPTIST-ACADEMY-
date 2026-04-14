<?php
session_start();
include('db_connect.php');

if(isset($_POST['add_teacher']))
{
    // Pagkuha ng inputs mula sa Modal
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
    // Image Upload Logic
    $image = $_FILES['image']['name'];
    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_extension; // Binibigyan ng unique name ang file

    // SQL Query para sa pag-insert
    // Siguraduhin na tumutugma ito sa columns na ginawa natin sa ALTER TABLE
    $query = "INSERT INTO teachers (employee_id, name, specialization, phone, image) 
              VALUES ('$employee_id', '$name', '$specialization', '$phone', '$filename')";
    
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        // Kapag success ang DB, i-save ang file sa 'uploads' folder
        if($image != NULL) {
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/'.$filename);
        }
        
        $_SESSION['status'] = "Teacher Added Successfully!";
        header("Location: manage_teachers.php");
        exit(0);
    }
    else
    {
        $_SESSION['status'] = "Something went wrong. Please try again.";
        header("Location: manage_teachers.php");
        exit(0);
    }
}
?>