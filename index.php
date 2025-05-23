<?php
include 'db.php';
include 'session.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student Management System</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      margin-top: 50px;
    }
    .table-container {
      background: white;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
    .action-links a {
      margin-right: 10px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="table-container">
    <h2 class="text-center mb-4">Student Management System</h2>

    <!-- Search Form -->
    <form method="GET" class="row g-3 mb-4">
      <div class="col-md-8">
        <input type="text" name="search" class="form-control" placeholder="Search by name or course" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Search</button>
      </div>
      <div class="col-md-2">
        <a href="add.php" class="btn btn-success w-100">+ Add Student</a>
      </div>
    </form>

    <!-- Student Table -->
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Course</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $search = $conn->real_escape_string($_GET['search'] ?? '');
        $sql = "SELECT * FROM students WHERE name LIKE '%$search%' OR course LIKE '%$search%' ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['id']}</td>
              <td>".htmlspecialchars($row['name'])."</td>
              <td>".htmlspecialchars($row['email'])."</td>
              <td>".htmlspecialchars($row['phone'])."</td>
              <td>".htmlspecialchars($row['course'])."</td>
              <td class='action-links'>
                <a href='edit.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                <a href='delete.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this student?')\">Delete</a>
              </td>
            </tr>";
          }
        } else {
          echo "<tr><td colspan='6' class='text-center'>No students found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_SESSION['success'])): ?>
<script>
  Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: <?= json_encode($_SESSION['success']) ?>,
    timer: 2500,
    timerProgressBar: true,
    showConfirmButton: false
  });
</script>
<?php unset($_SESSION['success']); endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<script>
  Swal.fire({
    icon: 'error',
    title: 'Error!',
    text: <?= json_encode($_SESSION['error']) ?>,
    timer: 2500,
    timerProgressBar: true,
    showConfirmButton: false
  });
</script>
<?php unset($_SESSION['error']); endif; ?>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_SESSION['swal'])): ?>
<script>
  Swal.fire({
    icon: <?= json_encode($_SESSION['swal']['icon']) ?>,
    title: <?= json_encode($_SESSION['swal']['title']) ?>,
    text: <?= json_encode($_SESSION['swal']['text']) ?>,
    timer: 2500,
    timerProgressBar: true,
    showConfirmButton: false
  });
</script>
<?php unset($_SESSION['swal']); endif; ?>


</body>
</html>
