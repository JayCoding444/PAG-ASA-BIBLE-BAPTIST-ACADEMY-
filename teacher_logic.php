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
// DELETE TEACHER LOGIC
if(isset($_POST['delete_teacher'])) {
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);

    // 1. Palitan ang 'photo' ng 'image' dito dahil 'image' ang nasa database mo
    $check_img_query = "SELECT image FROM teachers WHERE employee_id='$teacher_id' LIMIT 1";
    $res = mysqli_query($conn, $check_img_query);
    $data = mysqli_fetch_array($res);
    $image = $data['image']; 

    // 2. Burahin ang record sa database
    $query = "DELETE FROM teachers WHERE employee_id='$teacher_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        // 3. Burahin ang file sa folder kung exist
        if($image != '' && file_exists("uploads/".$image)) {
            unlink("uploads/".$image);
        }
        
        header("Location: manage_teachers.php?msg=Teacher Deleted Successfully");
        exit(0);
    } else {
        header("Location: manage_teachers.php?msg=Something went wrong!");
        exit(0);
    }
}
?>