<?php
session_start();
// Security Check: Dapat nag-agree muna sa Step 1
if(!isset($_SESSION['agreed_to_terms'])) {
    header("Location: register_agreement.php");
    exit();
}

// I-save ang details sa session kapag clinick ang Next
if(isset($_POST['next_to_account'])) {
    $_SESSION['reg_student_name'] = $_POST['student_name'];
    $_SESSION['reg_roll_number'] = $_POST['roll_number'];
    $_SESSION['reg_grade_level'] = $_POST['grade_level'];
    $_SESSION['reg_application_type'] = $_POST['application_type'];
    $_SESSION['reg_gender'] = $_POST['gender'];
    $_SESSION['reg_address'] = $_POST['address'];

if(isset($_FILES['student_image'])) {
        $img_name = $_FILES['student_image']['name'];
        $tmp_name = $_FILES['student_image']['tmp_name'];
        $upload_dir = "uploads/"; // Siguraduhin na may folder ka na 'uploads'
        
        move_uploaded_file($tmp_name, $upload_dir . $img_name);
        $_SESSION['reg_image'] = $img_name;
    }
    
    header("Location: register_account.php"); // Lilipat sa Step 3
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBA - Student Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('pag-asa_school.jpg'); 
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            padding: 40px 0;
            font-family: 'Segoe UI', sans-serif;
        }
        .registration-card {
            background: #ffffff;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            max-width: 800px;
            margin: auto;
        }
        .form-header {
            background: #0056b3; /* Blue header gaya ng dati mo pero rounded */
            color: white;
            padding: 30px;
            text-align: center;
        }
        .form-section-title {
            color: #0056b3;
            border-left: 5px solid #2e7d32;
            padding-left: 15px;
            margin: 25px 0;
            font-weight: bold;
        }
       /* Dagdag ito para sa dropdown consistency */
select.form-control {
    height: auto !important; /* Para hindi siya pilit na liliit */
    padding: 10px 12px !important;
    line-height: 1.5 !important;
}

.form-control {
    border-radius: 10px;
    padding: 12px;
    border: 1px solid #ddd;
    height: 50px; /* Ginawa nating standard ang height para sa lahat */
}
        .btn-next {
            background-color: #2e7d32;
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 12px 40px;
            border: none;
            transition: 0.3s;
        }
        .btn-next:hover {
            background-color: #1b5e20;
            transform: translateY(-2px);
        }
        .important-notice {
            background-color: #f1f8ff;
            border-left: 4px solid #0056b3;
            border-radius: 10px;
            padding: 15px;
        }

        @media print {
    .btn-next, .btn-outline-secondary, .form-header, .text-muted, a[href="register_agreement.php"] {
        display: none !important;
    }
    body { background: white !important; }
    .registration-card { box-shadow: none !important; border: none !important; }
}
    </style>
</head>
<body>

<div class="container">
    <div class="registration-card">
        <div class="form-header">
           <img src="Academy_Logo.jpg" width="100" class="mb-2" style="border-radius: 50%; object-fit: cover; aspect-ratio: 1/1; border: 2px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <h3 class="font-weight-bold">PAG-ASA BIBLE BAPTIST ACADEMY</h3>
            <p class="mb-0">Step 2 of 3: Student Personal Information</p>
        </div>

        <div class="card-body p-4 p-md-5">
            <div class="important-notice mb-4">
                <h6 class="font-weight-bold text-primary"><i class="fas fa-bullhorn mr-2"></i> IMPORTANT NOTICE:</h6>
                <ul class="small mb-0 text-muted">
                    <li><strong>Admin Approval:</strong> Subject to review before account activation.</li>
                    <li><strong>Accuracy:</strong> Double-check your details to avoid delays.</li>
                </ul>
            </div>

            <form action="" method="POST">
                <h5 class="form-section-title">I. STUDENT PERSONAL INFORMATION</h5>

                
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold">Full Name</label>
                        <input type="text" name="student_name" class="form-control" placeholder="Last Name, First Name, M.I." required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small font-weight-bold">Roll Number / LRN</label>
                        <input type="text" name="roll_number" class="form-control" placeholder="PBA-0000-0000" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold">Grade Level</label>
                        <select name="grade_level" class="form-control" required>
                            <option value="">-- Select Grade --</option>
                            <option value="Grade 7">Grade 7</option>
                            <option value="Grade 8">Grade 8</option>
                            <option value="Grade 9">Grade 9</option>
                            <option value="Grade 10">Grade 10</option>
                            <option value="Grade 11">Grade 11</option>
                            <option value="Grade 12">Grade 12</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold">Gender</label>
                        <select name="gender" class="form-control" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold">Application Type</label>
                        <select name="application_type" class="form-control" required>
                            <option value="Registration">New Registration</option>
                            <option value="Re-enrollment">Re-enrollment</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="small font-weight-bold">Home Address</label>
                    <textarea name="address" class="form-control" rows="2" placeholder="Unit/Blk, Street, Barangay, City" required></textarea>
                </div>
                <div class="form-group mb-4">
        <label class="small font-weight-bold">Student Profile Picture</label>
        <input type="file" name="student_image" class="form-control-file border p-2 w-100 rounded" accept="image/*" required>
        <small class="text-muted">Please upload a formal 2x2 ID picture.</small>
    </div>
        <div>
            <button type="button" onclick="window.print();" class="btn btn-outline-secondary mr-2">
                <i class="fas fa-print mr-1"></i> PRINT FORM
            </button>

                <hr>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="register_agreement.php" class="text-muted"><i class="fas fa-arrow-left mr-1"></i> Back</a>
                    <button type="submit" name="next_to_account" class="btn btn-next">
                        NEXT: ACCOUNT SETUP <i class="fas fa-chevron-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>