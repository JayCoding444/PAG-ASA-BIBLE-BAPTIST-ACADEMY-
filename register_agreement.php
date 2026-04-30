<?php
session_start();

if(isset($_POST['accept_terms_btn'])) {
    $_SESSION['agreed_to_terms'] = true;
    header("Location: registration.php");
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBA - Registration Agreement</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { 
            /* Ginaya natin ang background style ng login page mo */
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('pag-asa_school.jpg'); 
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .main-card {
            background: #ffffff;
            border-radius: 30px; /* Consistent rounded corners gaya ng login */
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 650px;
            margin: auto;
        }
        .school-logo {
            width: 120px;
            display: block;
            margin: 0 auto 20px;
        }
        .agreement-box {
            height: 250px;
            overflow-y: auto;
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            border: 1px solid #eee;
            font-size: 0.9rem;
            color: #444;
            line-height: 1.6;
        }
        /* Custom scrollbar para malinis tignan */
        .agreement-box::-webkit-scrollbar { width: 6px; }
        .agreement-box::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }

        .btn-login-style {
            background-color: #2e7d32; /* Yung Green sa login button mo */
            color: white;
            font-weight: bold;
            border-radius: 12px;
            padding: 12px;
            border: none;
            width: 100%;
            transition: 0.3s;
        }
        .btn-login-style:hover:not(:disabled) {
            background-color: #1b5e20;
            transform: translateY(-2px);
        }
        .btn-login-style:disabled {
            background-color: #a5d6a7;
            cursor: not-allowed;
        }
        .text-link {
            color: #2e7d32;
            font-weight: 600;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="main-card">
        <div class="text-center">
            <img src="Academy_Logo.jpg" class="school-logo" alt="PBA Logo">
            <h4 class="font-weight-bold mb-1">Welcome Student!</h4>
            <p class="text-muted mb-4">Please read our terms before creating an account</p>
        </div>

        <div class="agreement-box mb-4">
            <h6 class="font-weight-bold">Enrollment Terms & Conditions</h6>
            <p>By proceeding, you agree to the following:</p>
            <ul class="pl-3">
                <li>Your account will be subject to <strong>Admin Approval</strong>.</li>
                <li>All data provided must be accurate and verifiable.</li>
                <li>Information is handled under the Data Privacy Act of 2012.</li>
                <li>Unauthorized use of this portal is strictly prohibited.</li>
            </ul>
            <p class="small text-muted mt-3">This system is designed for the management of enrollment and student information at Pag-asa Bible Baptist Academy.</p>
        </div>

        <form action="" method="POST">
            <div class="custom-control custom-checkbox mb-4 text-center">
                <input type="checkbox" class="custom-control-input" id="checkAgree" onclick="document.getElementById('nextBtn').disabled = !this.checked">
                <label class="custom-control-label small" for="checkAgree">
                    I agree to the <span class="text-link">Terms and Conditions</span>
                </label>
            </div>

            <button type="submit" name="accept_terms_btn" id="nextBtn" class="btn-login-style mb-3" disabled>
                Next Step <i class="fas fa-arrow-right ml-2"></i>
            </button>
            
            <div class="text-center">
                <p class="small">Already have an account? <a href="login.php" class="text-link">Login here</a></p>
            </div>
        </form>
    </div>
</div>

</body>
</html>