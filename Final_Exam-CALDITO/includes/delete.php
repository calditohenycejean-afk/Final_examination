<?php
include 'db.php';

$id = (int) $_POST['id'];

$sql = "DELETE FROM students WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    header("Location: ../index.php?status=deleted&section=delete");
} else {
    header("Location: ../index.php?status=error&section=delete");
}

mysqli_close($conn);
?>
