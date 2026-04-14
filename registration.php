<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBA - Official Enrollment Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .registration-card { background: white; border-top: 6px solid #dc3545; border-radius: 15px; overflow: hidden; }
        .header-banner { background-color: #0056b3; color: white; padding: 30px; text-align: center; border-bottom: 5px solid #198754; }
        .school-logo-container { background: white; width: 110px; height: 110px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px; border: 4px solid #dc3545; }
        .school-logo-container img { width: 100%; border-radius: 50%; }
        .form-section-title { color: #0056b3; border-left: 5px solid #dc3545; padding-left: 15px; margin-top: 35px; font-weight: bold; text-transform: uppercase; }
        .memo-card { border: 1px solid #0056b3; border-left: 5px solid #0056b3; background-color: #f0f7ff; }
        .submit-btn { background-color: #198754; color: white; font-weight: bold; padding: 18px; border-radius: 10px; transition: 0.3s; text-transform: uppercase; cursor: pointer; }
        .submit-btn:hover { background-color: #146c43; transform: translateY(-2px); }
        
        /* New Style para sa Image Preview */
        .image-preview-wrapper {
            width: 150px;
            height: 150px;
            border: 2px dashed #0056b3;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #fff;
        }
        .image-preview-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
    </style> 
</head> 
<body class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <?php if(isset($_SESSION['message'])): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2"></i> <?= $_SESSION['message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php unset($_SESSION['message']); endif; ?>

                <div class="registration-card shadow-lg">
                    <div class="header-banner">
                        <div class="school-logo-container">
                            <img src="Academy_Logo.jpg" alt="PBA Official Logo">
                        </div>
                        <h2 class="fw-bold mb-0">PAG-ASA BIBLE BAPTIST ACADEMY</h2>
                        <p class="mb-0 opacity-75">Online Enrollment Application Form</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        
                        <div class="card memo-card mb-5 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-primary fw-bold"><i class="fas fa-bullhorn me-2"></i> IMPORTANT NOTICE:</h5>
                                <p class="card-text text-muted small">
                                    Welcome to the PBA Online Enrollment System. Please be advised of the following:
                                </p>
                                <ul class="small text-secondary">
                                    <li><strong>Admin Approval:</strong> All submissions are subject to review. Please wait for the "Approved" status before proceeding with payment.</li>
                                    <li><strong>Requirements:</strong> New students must submit physical copies of PSA Birth Certificate and Report Card to the office once approved.</li>
                                    <li><strong>Accuracy:</strong> Double-check your <strong>LRN</strong> and <strong>Contact Number</strong> to avoid delays.</li>
                                </ul>
                            </div>
                        </div>

                        <form action="process_registration.php" method="POST" enctype="multipart/form-data">
                            
                            <div class="form-section-title mb-4">I. Student Personal Information</div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Surname</label>
                                    <input type="text" name="last_name" class="form-control bg-light" placeholder="e.g. Dela Cruz" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">First Name</label>
                                    <input type="text" name="first_name" class="form-control bg-light" placeholder="e.g. Juan" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Middle Name</label>
                                    <input type="text" name="middle_name" class="form-control bg-light" placeholder="Optional">
                                </div>
                            </div>
                            
                            <div class="row g-3 mt-2">
                                <div class="col-md-2">
                                    <label class="form-label small fw-bold">Age</label>
                                    <input type="number" name="age" class="form-control bg-light" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold">Sex</label>
                                    <select name="sex" class="form-select bg-light" required>
                                        <option value="" selected disabled>Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Grade to Enter</label>
                                    <select name="grade_to_enter" class="form-select bg-light" required>
                                        <option value="" selected disabled>Select Grade Level</option>
                                        <option value="Grade 7">Grade 7</option>
                                        <option value="Grade 8">Grade 8</option>
                                        <option value="Grade 9">Grade 9</option>
                                        <option value="Grade 10">Grade 10</option>
                                        <option value="Grade 11">Grade 11</option>
                                        <option value="Grade 12">Grade 12</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold">LRN</label>
                                    <input type="text" name="lrn" class="form-control bg-light" placeholder="12-digit number">
                                </div>
                            </div>

                            <div class="form-section-title mb-4 mt-5">II. Contact & Residential Details</div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Complete Home Address</label>
                                <textarea name="address" class="form-control bg-light" rows="2" placeholder="House No., Street, Brgy, City" required></textarea>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Guardian Email Address</label>
                                    <input type="email" name="email" class="form-control bg-light" placeholder="email@example.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Parent/Guardian Phone Number</label>
                                    <input type="text" name="phone" class="form-control bg-light" placeholder="09XXXXXXXXX" required>
                                </div>
                            </div>

                            <div class="form-section-title mb-4 mt-5">III. Student Photo Identification</div>
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="image-preview-wrapper mx-auto" id="previewContainer">
                                        <i class="fas fa-user-circle fa-5x text-light-emphasis" id="placeholderIcon"></i>
                                        <img src="" id="imagePreview" alt="Student Photo">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-label small fw-bold">Upload Student Picture (2x2 or 3x3 Preferred)</label>
                                    <input type="file" name="student_image" class="form-control bg-light" accept="image/*" required onchange="previewFile()">
                                    <p class="text-muted small mt-2">
                                        <i class="fas fa-info-circle me-1"></i> Please ensure the face is clear. This photo will be used for your official student records and enrollment form.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4 p-3 border rounded bg-light">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label small" for="terms">
                                        I hereby certify that the above information is true and correct. I understand that the application is subject to <strong>Admin Approval</strong>.
                                    </label>
                                </div>
                            </div>

                            <div class="mt-5">
                                <button type="submit" name="register_btn" class="submit-btn w-100 shadow-sm border-0">
                                    Submit Application for Approval
                                </button>
                                <div class="mt-3 text-center">
                                    <span class="text-muted small">Already have an account?</span> 
                                    <a href="login.php" class="text-primary small fw-bold text-decoration-none">
                                        <i class="fas fa-arrow-left me-1"></i> Back to Login Page
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <p class="text-center text-muted mt-4 small">&copy; 2026 Pag-asa Bible Baptist Academy. All Rights Reserved.</p>
            </div>
        </div>
    </div>

    <script>
        function previewFile() {
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('placeholderIcon');
            const file = document.querySelector('input[name=student_image]').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
                preview.style.display = "block";
                placeholder.style.display = "none";
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>