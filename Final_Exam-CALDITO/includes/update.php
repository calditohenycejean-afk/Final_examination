<?php
include 'db.php';

$id         = (int) $_POST['id'];
$name       = mysqli_real_escape_string($conn, $_POST['name']);
$surname    = mysqli_real_escape_string($conn, $_POST['surname']);
$middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
$address    = mysqli_real_escape_string($conn, $_POST['address']);
$contact    = mysqli_real_escape_string($conn, $_POST['contact']);

$sql = "UPDATE students
        SET name='$name', surname='$surname', middlename='$middlename',
            address='$address', contact_number='$contact'
        WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    header("Location: ../index.php?status=updated&section=update");
} else {
    header("Location: ../index.php?status=error&section=update");
}

mysqli_close($conn);
?>
