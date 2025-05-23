<?php
include 'db.php';
include 'session.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $course = trim($_POST['course']);

    if ($name && $email && $phone && $course) {
      
        $name = $conn->real_escape_string($name);
        $email = $conn->real_escape_string($email);
        $phone = $conn->real_escape_string($phone);
        $course = $conn->real_escape_string($course);

        $sql = "INSERT INTO students (name,email,phone,course) VALUES ('$name','$email','$phone','$course')";
        if ($conn->query($sql)) {
            $_SESSION['success'] = "Student added!";
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['error'] = "Error adding student.";
            header("Location: add.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "All fields are required!";
        header("Location: add.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add Student</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .form-container {
      max-width: 600px;
      margin: 60px auto;
      padding: 30px;
      background: white;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="form-container">
    <h2 class="text-center mb-4">Add New Student</h2>

    <form method="POST" novalidate>
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" placeholder="Enter phone number" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Course</label>
        <input type="text" name="course" class="form-control" placeholder="Enter course name" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Add Student</button>
      <a href="index.php" class="btn btn-secondary w-100 mt-2">Back</a>
    </form>
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
    timer: 1500,
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
    showConfirmButton: true
  });
</script>
<?php unset($_SESSION['error']); endif; ?>

</body>
</html>
