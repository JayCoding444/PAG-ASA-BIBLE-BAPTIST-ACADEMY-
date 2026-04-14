<?php 
session_start(); 
if(!isset($_SESSION['student_name'])) {
    header("Location: registration.php");
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success - PBBA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .success-card { max-width: 600px; margin: 50px auto; background: white; border-radius: 20px; border-top: 8px solid #198754; }
        .ref-number { background: #e9ecef; padding: 15px; border-radius: 10px; font-family: monospace; font-size: 1.2rem; }
        @media print { .no-print { display: none; } .success-card { border: none; shadow: none; } }
    </style>
</head>
<body>

    <div class="container">
        <div class="success-card shadow-lg p-5 text-center">
            <div class="mb-4">
                <img src="Academy_Logo.jpg" width="100" class="rounded-circle border border-success p-1">
            </div>
            
            <h2 class="text-success fw-bold">Application Submitted!</h2>
            <p class="text-muted">Thank you for choosing Pag-asa Bible Baptist Academy.</p>
            
            <hr>
            
            <div class="text-start mt-4">
                <p class="mb-1 small text-uppercase fw-bold text-muted">Student Name:</p>
                <h5><?= $_SESSION['student_name']; ?></h5>
                
                <p class="mb-1 mt-3 small text-uppercase fw-bold text-muted">Reference / Roll Number:</p>
                <div class="ref-number text-center fw-bold text-primary">
                    <?= $_SESSION['roll_number']; ?>
                </div>
            </div>

            <div class="alert alert-info mt-4 small text-start">
                <strong>What's Next?</strong>
                <ul class="mb-0 mt-2">
                    <li>Wait for <strong>Admin Approval</strong> within 1-3 business days.</li>
                    <li>You will receive an email once your application is approved.</li>
                    <li>Keep a screenshot or print this page as your reference.</li>
                </ul>
            </div>

            <div class="mt-5 no-print">
                <button onclick="window.print()" class="btn btn-outline-primary px-4 me-2">
                    <i class="fas fa-print"></i> Print Reference
                </button>
                <a href="registration.php" class="btn btn-success px-4">Done</a>
            </div>
        </div>
    </div>

</body>
</html>