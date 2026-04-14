<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBA - Official Re-enrollment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .registration-card { background: white; border-top: 6px solid #198754; border-radius: 15px; overflow: hidden; max-width: 700px; margin: auto; }
        .header-banner { background-color: #0056b3; color: white; padding: 30px; text-align: center; border-bottom: 5px solid #198754; }
        .school-logo-container { background: white; width: 100px; height: 100px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px; border: 4px solid #dc3545; }
        .school-logo-container img { width: 100%; border-radius: 50%; }
        .memo-card { border: 1px solid #198754; border-left: 5px solid #198754; background-color: #fafffa; }
        .submit-btn { background-color: #198754; color: white; font-weight: bold; padding: 15px; border-radius: 10px; transition: 0.3s; text-transform: uppercase; border: none; width: 100%; }
        .submit-btn:hover { background-color: #146c43; transform: translateY(-2px); }
    </style> 
</head>
<body class="py-5">
    <div class="container">
        <div class="registration-card shadow-lg">
            <div class="header-banner">
                <div class="school-logo-container">
                    <img src="Academy_Logo.jpg" alt="PBA Official Logo">
                </div>
                <h2 class="fw-bold mb-0 text-white">PAG-ASA BIBLE BAPTIST ACADEMY</h2>
                <p class="mb-0 opacity-75 text-white">Application for Re-enrollment</p>
            </div>

            <div class="card-body p-4 p-md-5">
                
                <?php if(isset($_SESSION['message'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> <?= $_SESSION['message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php unset($_SESSION['message']); endif; ?>

                <div class="card memo-card mb-4 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-success fw-bold"><i class="fas fa-id-card me-2"></i> FOR RETURNING STUDENTS:</h6>
                        <p class="card-text text-muted mb-0" style="font-size: 0.85rem;">
                            This application is for students presently enrolled who desire to return for the next academic year. 
                            Please provide your <strong>Roll Number</strong> to update your records.
                        </p>
                    </div>
                </div>

                <form action="process_reenrollment.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Student Roll Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fas fa-hashtag"></i></span>
                                <input type="text" name="roll_number" class="form-control bg-light" placeholder="e.g. PBA-2026-XXXX" required>
                            </div>
                            <div class="form-text mt-1" style="font-size: 0.75rem;">Enter your official roll number found in your previous registration slip.</div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label class="form-label small fw-bold">Grade Level to Enter</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="fas fa-graduation-cap"></i></span>
                                <select name="new_grade" class="form-select bg-light" required>
                                    <option value="" selected disabled>Select Next Grade Level</option>
                                    <option value="Grade 8">Grade 8</option>
                                    <option value="Grade 9">Grade 9</option>
                                    <option value="Grade 10">Grade 10</option>
                                    <option value="Grade 11">Grade 11</option>
                                    <option value="Grade 12">Grade 12</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-3 border rounded bg-light">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label small" for="terms">
                                I confirm that I want to continue my studies at PBA and will follow all school policies.
                            </label>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" name="reenroll_btn" class="submit-btn shadow-sm">
                            Submit Re-enrollment
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <a href="login.php" class="text-decoration-none small text-muted">
                            <i class="fas fa-arrow-left me-1"></i> Back to Login Page
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center text-muted mt-4 small">&copy; 2026 Pag-asa Bible Baptist Academy.</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>