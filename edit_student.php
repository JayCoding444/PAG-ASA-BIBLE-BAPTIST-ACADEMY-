<?php
session_start();
include('db_connect.php');

// 1. SECURITY CHECK - Admin lang ang may power mag-edit
if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != 'Admin') {
    header("Location: login.php");
    exit(0);
}

// 2. FETCH DATA - Kunin ang details ng student base sa ID na pinindot mo
if(isset($_GET['id'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM students WHERE student_id='$student_id' LIMIT 1";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) > 0) {
        $student = mysqli_fetch_array($query_run);
    } else {
        echo "<script>alert('Student record not found!'); window.location='manage_students.php';</script>";
        exit();
    }
} else {
    header("Location: manage_students.php");
    exit();
}

// 3. UPDATE LOGIC - Ito ang tatakbo kapag clinick mo yung 'Save Changes'
if(isset($_POST['update_student'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $roll_num = mysqli_real_escape_string($conn, $_POST['roll_number']);
    $name = mysqli_real_escape_string($conn, $_POST['parent_name']);
    $grade = mysqli_real_escape_string($conn, $_POST['grade_level']);
    $type = mysqli_real_escape_string($conn, $_POST['application_type']);

    $update_query = "UPDATE students SET 
                        roll_number='$roll_num', 
                        parent_name='$name', 
                        grade_level='$grade', 
                        application_type='$type' 
                    WHERE student_id='$student_id'";

    if(mysqli_query($conn, $update_query)) {
        // Redirect pabalik sa listahan kapag success
        header("Location: manage_students.php?msg=Updated Successfully");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - PBA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f1f3f6; font-family: 'Segoe UI', sans-serif; }
        .main-content { margin-left: 250px; padding: 40px; transition: 0.3s; }
        .card { border-radius: 15px; border: none; box-shadow: 0 8px 30px rgba(0,0,0,0.1); }
        .card-header { background-color: #343a40; color: white; border-radius: 15px 15px 0 0 !important; }
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #ddd; }
        .btn-update { background-color: #ffc107; border: none; font-weight: bold; border-radius: 10px; padding: 12px 30px; }
        .btn-update:hover { background-color: #e0a800; }
        @media (max-width: 768px) { .main-content { margin-left: 0; padding: 20px; } }
    </style>
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header py-3">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-user-edit mr-2"></i> EDIT STUDENT DETAILS</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST">
                            <input type="hidden" name="student_id" value="<?= $student['student_id']; ?>">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold text-muted small uppercase">Roll Number</label>
                                    <input type="text" name="roll_number" value="<?= $student['roll_number']; ?>" class="form-control" placeholder="e.g. PBA-2026-1218" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold text-muted small uppercase">Application Type</label>
                                    <select name="application_type" class="form-control">
                                        <option value="New Enrollment" <?= $student['application_type'] == 'New Enrollment' ? 'selected' : ''; ?>>New Enrollment</option>
                                        <option value="Re-enrollment" <?= $student['application_type'] == 'Re-enrollment' ? 'selected' : ''; ?>>Re-enrollment</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-muted small uppercase">Student Name</label>
                                <input type="text" name="parent_name" value="<?= $student['parent_name']; ?>" class="form-control" required>
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-muted small uppercase">Grade Level</label>
                                <select name="grade_level" class="form-control">
                                    <?php 
                                        $grades = ['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12 - SHS'];
                                        foreach($grades as $g) {
                                            $selected = ($student['grade_level'] == $g) ? 'selected' : '';
                                            echo "<option value='$g' $selected>$g</option>";
                                        }
                                    ?>
                                </select>
                            </div>

                            <hr>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="manage_students.php" class="text-muted"><i class="fas fa-arrow-left mr-1"></i> Cancel and Go Back</a>
                                <button type="submit" name="update_student" class="btn btn-update shadow-sm">
                                    <i class="fas fa-save mr-2"></i> SAVE CHANGES
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>