<?php
session_start();
include('db_connect.php');

// Security Check
if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != 'Admin') {
    header("Location: login.php"); 
    exit(0);
}
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head>
    <meta charset="UTF-8">  
    <title>PBA - Manage Teachers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f1f3f6; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .thead-dark th { background-color: #343a40; color: white; border: none; }
        
        /* ID-CARD STYLE FOR PROFILE PHOTOS */
        .teacher-photo-container {
            width: 55px; 
            height: 65px; 
            overflow: hidden;
            border-radius: 6px; 
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            display: inline-block;
            background-color: #e9ecef;  
        }
        .teacher-img {
            width: 100%;
            height: 100%;
            object-fit: cover;  
        }

        .table td { vertical-align: middle !important; }
        .btn-circle { width: 32px; height: 32px; padding: 0; line-height: 32px; text-align: center; }
    </style>
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark"><i class="fas fa-chalkboard-teacher text-success mr-2"></i>Faculty Members</h4>
            <button class="btn btn-success btn-sm px-4 shadow-sm" data-toggle="modal" data-target="#addTeacherModal">
                <i class="fas fa-plus-circle mr-1"></i> Add New Teacher
            </button> 
        </div>

        <!-- Alert Message Para sa Success/Error -->
        <?php if(isset($_GET['msg'])): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?= $_GET['msg']; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-md-6"> 
                <form action="" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search Teacher Name or ID...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success px-4">Search</button>
                        </div> 
                    </div> 
                </form>
            </div>
            <div class="col-md-6">
                <form action="" method="GET" class="d-flex justify-content-end">
                    <select name="sort_name" class="form-control mr-2" style="width: 180px;" onchange="this.form.submit()">
                        <option value="">-- Sort Name --</option>
                        <option value="ASC" <?= isset($_GET['sort_name']) && $_GET['sort_name'] == 'ASC' ? 'selected' : '' ?>>A-Z (Ascending)</option>
                        <option value="DESC" <?= isset($_GET['sort_name']) && $_GET['sort_name'] == 'DESC' ? 'selected' : '' ?>>Z-A (Descending)</option>
                    </select>
                    <a href="manage_teachers.php" class="btn btn-light border">Reset</a>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>Photo</th>
                                <th>Employee ID</th>
                                <th>Full Name</th>
                                <th>Specialization</th>
                                <th>Contact No.</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM teachers WHERE 1=1";

                            if(isset($_GET['search']) && !empty($_GET['search'])) {
                                $search = mysqli_real_escape_string($conn, $_GET['search']);
                                $query .= " AND (name LIKE '%$search%' OR employee_id LIKE '%$search%')";
                            }

                            if(isset($_GET['sort_name']) && !empty($_GET['sort_name'])) {
                                $sort = mysqli_real_escape_string($conn, $_GET['sort_name']);
                                $query .= " ORDER BY name $sort";
                            } else {
                                $query .= " ORDER BY teacher_id DESC";
                            }

                            $query_run = mysqli_query($conn, $query);

                            if($query_run && mysqli_num_rows($query_run) > 0) {
                                foreach($query_run as $teacher) {
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="teacher-photo-container">
                                                <img src="uploads/<?= !empty($teacher['image']) ? $teacher['image'] : 'default-avatar.png'; ?>" 
                                                     class="teacher-img" alt="Profile">
                                            </div>
                                        </td>
                                        <td class="font-weight-bold"><?= $teacher['employee_id']; ?></td>
                                        <td><?= $teacher['name'] ?? 'Not Set'; ?></td>
                                        <td><span class="badge badge-light border px-3"><?= $teacher['specialization']; ?></span></td>
                                        <td class="text-muted small"><?= $teacher['phone'] ?? 'N/A'; ?></td>
                                        <td>
                                            <a href="edit_teacher.php?id=<?= $teacher['teacher_id']; ?>" 
                                               class="btn btn-outline-primary btn-sm rounded-circle btn-circle shadow-sm" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <!-- UPDATED DELETE BUTTON: Gumagamit na ng Form para sa POST -->
                                            <form action="teacher_logic.php" method="POST" class="d-inline">
                                                <input type="hidden" name="teacher_id" value="<?= $teacher['employee_id']; ?>">
                                                <button type="submit" name="delete_teacher" 
                                                        class="btn btn-outline-danger btn-sm rounded-circle btn-circle ml-1 shadow-sm" 
                                                        onclick="return confirm('Are you sure you want to delete this teacher?')"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='6' class='py-5 text-muted'>No teacher records found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
    </div> 

    <!-- Add Teacher Modal Code remains the same... -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog">
        <!-- ... (Keeping your original modal code here) ... -->
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title font-weight-bold">Register New Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="teacher_logic.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="small font-weight-bold">Employee ID</label>
                            <input type="text" name="employee_id" class="form-control" required placeholder="PBA-202X-XXXX">
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Maria Clara">
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold">Specialization</label>
                            <input type="text" name="specialization" class="form-control" required placeholder="e.g. Mathematics">
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="09xxxxxxxxx">
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold">Profile Picture</label>
                            <input type="file" name="image" class="form-control-file">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_teacher" class="btn btn-success px-4">Save Teacher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>