<?php
session_start();
include('db_connect.php');

// Security Check
if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != 'Admin') {
    header("Location: login.php");
    exit(0);
}

// FETCH DATA - Kunin ang info ng teacher base sa ID
if(isset($_GET['id'])) {
    $teacher_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM teachers WHERE teacher_id='$teacher_id' LIMIT 1";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) > 0) {
        $teacher = mysqli_fetch_array($query_run);
    } else {
        echo "<script>alert('Teacher Record Not Found'); window.location='manage_teachers.php';</script>";
        exit();
    }
}

// UPDATE LOGIC - Ito ang tatakbo kapag clinick ang Save Changes
if(isset($_POST['update_teacher'])) {
    $t_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $emp_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $spec = mysqli_real_escape_string($conn, $_POST['specialization']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $update_query = "UPDATE teachers SET 
                        employee_id='$emp_id', 
                        name='$name', 
                        specialization='$spec', 
                        phone='$phone' 
                    WHERE teacher_id='$t_id'";

    if(mysqli_query($conn, $update_query)) {
        header("Location: manage_teachers.php?msg=Teacher Updated Successfully");
        exit(0);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Teacher - PBA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f1f3f6; }
        .main-content { margin-left: 250px; padding: 40px; }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .card-header { background-color: #28a745; color: white; border-radius: 15px 15px 0 0 !important; }
        .btn-update { background-color: #28a745; color: white; font-weight: bold; border-radius: 8px; }
    </style>
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header py-3">
                        <h5 class="mb-0 font-weight-bold">EDIT TEACHER DETAILS</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST">
                            <input type="hidden" name="teacher_id" value="<?= $teacher['teacher_id']; ?>">

                            <div class="form-group mb-3">
                                <label class="small font-weight-bold">Employee ID</label>
                                <input type="text" name="employee_id" value="<?= $teacher['employee_id']; ?>" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label class="small font-weight-bold">Full Name</label>
                                <input type="text" name="name" value="<?= $teacher['name']; ?>" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="small font-weight-bold">Specialization</label>
                                    <input type="text" name="specialization" value="<?= $teacher['specialization']; ?>" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="small font-weight-bold">Phone Number</label>
                                    <input type="text" name="phone" value="<?= $teacher['phone']; ?>" class="form-control">
                                </div>
                            </div>

                            <hr>
                            <div class="d-flex justify-content-between">
                                <a href="manage_teachers.php" class="btn btn-light">Cancel</a>
                                <button type="submit" name="update_teacher" class="btn btn-update px-5">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>