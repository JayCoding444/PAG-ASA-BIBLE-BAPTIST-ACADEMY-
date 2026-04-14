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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBA - Student Masterlist</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f1f3f6; }
        .main-content { margin-left: 250px; padding: 30px; transition: 0.3s; }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .thead-dark th { background-color: #343a40; color: white; border: none; }
        .search-box { border-radius: 20px; padding-left: 40px; }
        .search-icon { position: absolute; left: 15px; top: 10px; color: #aaa; }
        @media print { .sidebar, .btn, .search-container, .filters-container { display: none; } .main-content { margin-left: 0; padding: 0; } }
    </style>
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark"><i class="fas fa-user-graduate text-success mr-2"></i>Approved Student Masterlist</h4>
            <button class="btn btn-dark btn-sm shadow-sm px-4" onclick="window.print()">
                <i class="fas fa-print mr-1"></i> Generate Report
            </button>
        </div>

        <div class="card mb-4 search-container">
            <div class="card-body">
                <form action="" method="GET">
                    <div class="row">
                        <div class="col-md-5 position-relative mb-2">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="search" class="form-control search-box" 
                                   placeholder="Search by Name or Roll Number..." 
                                   value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>">
                        </div>
                        
                        <div class="col-md-3 mb-2">
                            <select name="filter_level" class="form-control rounded-pill" onchange="this.form.submit()">
                                <option value="">-- All Levels --</option>
                                <?php
                                $levels = ["Grade 7", "Grade 8", "Grade 9", "Grade 10", "Grade 11", "Grade 12 - SHS"];
                                foreach($levels as $lvl) {
                                    $selected = (isset($_GET['filter_level']) && $_GET['filter_level'] == $lvl) ? 'selected' : '';
                                    echo "<option value='$lvl' $selected>$lvl</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-2 mb-2">
                            <select name="sort_name" class="form-control rounded-pill" onchange="this.form.submit()">
                                <option value="ASC" <?= (isset($_GET['sort_name']) && $_GET['sort_name'] == 'ASC') ? 'selected' : '' ?>>A-Z</option>
                                <option value="DESC" <?= (isset($_GET['sort_name']) && $_GET['sort_name'] == 'DESC') ? 'selected' : '' ?>>Z-A</option>
                            </select>
                        </div>

                        <div class="col-md-2 mb-2">
                            <button type="submit" class="btn btn-success btn-block rounded-pill">Apply</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th class="py-3">Roll Number</th>
                                <th class="py-3">Student Name</th>
                                <th class="py-3">Grade Level</th>
                                <th class="py-3">Type</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Base Query
                            $query = "SELECT * FROM students WHERE status='Approved'";

                            // Filter: Search
                            if(isset($_GET['search']) && !empty($_GET['search'])) {
                                $filtervalues = mysqli_real_escape_string($conn, $_GET['search']);
                                $query .= " AND (parent_name LIKE '%$filtervalues%' OR roll_number LIKE '%$filtervalues%')";
                            }

                            // Filter: Grade Level
                            if(isset($_GET['filter_level']) && !empty($_GET['filter_level'])) {
                                $level = mysqli_real_escape_string($conn, $_GET['filter_level']);
                                $query .= " AND grade_level = '$level'";
                            }

                            // Sorting: Name
                            $sort = (isset($_GET['sort_name']) && $_GET['sort_name'] == 'DESC') ? 'DESC' : 'ASC';
                            $query .= " ORDER BY parent_name $sort";
                            
                            $query_run = mysqli_query($conn, $query);

                            if($query_run && mysqli_num_rows($query_run) > 0) {
                                foreach($query_run as $student) {
                                    ?>
                                    <tr>
                                        <td class="align-middle font-weight-bold"><?= $student['roll_number']; ?></td>
                                        <td class="align-middle text-left pl-4"><?= $student['parent_name']; ?></td>
                                        <td class="align-middle"><?= $student['grade_level']; ?></td>
                                        <td class="align-middle">
                                            <span class="badge badge-light border px-2 py-1"><?= $student['application_type']; ?></span>
                                        </td>
                                        <td class="align-middle"><span class="badge badge-success px-3">Enrolled</span></td>
                                        <td class="align-middle">
                                            <a href="view_student.php?id=<?= $student['student_id']; ?>" class="btn btn-outline-info btn-sm rounded-circle"><i class="fas fa-eye"></i></a>
                                            <a href="edit_student.php?id=<?= $student['student_id']; ?>" class="btn btn-outline-warning btn-sm rounded-circle ml-1"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='6' class='py-5 text-muted'>No enrolled students found matching your criteria.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>