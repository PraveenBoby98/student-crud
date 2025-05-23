<?php
session_start();
include 'db.php';
include 'session.php';

$id = intval($_GET['id']); // sanitize input

$sql = "DELETE FROM students WHERE id=$id";
if ($conn->query($sql)) {
    $_SESSION['swal'] = [
        'icon' => 'success',
        'title' => 'Deleted!',
        'text' => 'Student deleted successfully.'
    ];
} else {
    $_SESSION['swal'] = [
        'icon' => 'error',
        'title' => 'Error!',
        'text' => 'Failed to delete student.'
    ];
}

header("Location: index.php");

exit;
