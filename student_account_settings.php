<?php
session_start();
include('db_connect.php');

// Security: Siguraduhin na naka-login ang student
if(!isset($_SESSION['auth'])) {
    header("Location: login.php");
    exit(0);
}

// Kunin ang dynamic user_id mula sa session
$user_id = $_SESSION['auth_user']['user_id'];

// Query para makuha ang data ng student. Ginagamit natin ang user_id para makuha ang tamang profile
$query = "SELECT * FROM students WHERE user_id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Pag-iwas sa "array offset on null" error
    $user = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Settings - PBA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .main-content { margin-left: 250px; padding: 40px; }
        .card { border-radius: 15px; border: none; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        label { font-weight: 600; color: #555; font-size: 13px; text-transform: uppercase; }
        .form-control { border-radius: 8px; padding: 12px; height: auto; background: #fcfcfc; }
        .user-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #eee; }
    </style>
</head>
<body>
    <?php include('student_sidebar.php'); ?>

    <div class="main-content">
        <h3 class="font-weight-bold mb-4">Account Settings</h3>
        
      <?php if(isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['message_type']; ?> alert-dismissible fade show">
        <?= $_SESSION['message']; ?>
        <?php 
            unset($_SESSION['message']); 
            unset($_SESSION['message_type']); 
        ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php endif; ?>

        <form action="student_update_account.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <h5 class="text-success mb-4"><i class="fas fa-user-edit mr-2"></i>Personal Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" value="<?= $user['name'] ?? '' ?>" readonly>
                                    <small class="text-muted">Contact admin to change name.</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Email Address</label>
                                    <input type="email" name="email" class="form-control" value="<?= $user['email'] ?? '' ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Contact Number</label>
                                    <input type="text" name="contact_no" class="form-control" value="<?= $user['contact_no'] ?? '' ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control">
                                        <option value="Male" <?= (isset($user['gender']) && $user['gender'] == 'Male') ? 'selected':''; ?>>Male</option>
                                        <option value="Female" <?= (isset($user['gender']) && $user['gender'] == 'Female') ? 'selected':''; ?>>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Complete Address</label>
                                    <textarea name="address" class="form-control" rows="2"><?= $user['address'] ?? '' ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="text-primary mb-3"><i class="fas fa-camera mr-2"></i>Profile Picture</h5>
                            <div class="text-center mb-3">
                                <img src="uploads/<?= !empty($user['image']) ? $user['image'] : 'default-user.png' ?>" class="user-img">
                            </div>
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose photo</label>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-danger mb-3"><i class="fas fa-shield-alt mr-2"></i>Security</h5>
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" name="current_password" class="form-control" placeholder="Enter current pw" required>
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_password" class="form-control" placeholder="Leave blank if no change">
                            </div>
                        </div>
                    </div>

                    <button type="submit" name="update_account_btn" class="btn btn-success btn-block btn-lg mt-4 shadow-sm" style="border-radius: 12px;">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Preview name of uploaded file
        document.querySelector('.custom-file-input').addEventListener('change', function(e){
            var fileName = document.getElementById("customFile").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
</body>
</html>