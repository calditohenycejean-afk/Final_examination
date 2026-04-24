<?php
include 'db.php';

$name       = mysqli_real_escape_string($conn, $_POST['name']);
$surname    = mysqli_real_escape_string($conn, $_POST['surname']);
$middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
$address    = mysqli_real_escape_string($conn, $_POST['address']);
$contact    = mysqli_real_escape_string($conn, $_POST['contact']);

$sql = "INSERT INTO students (name, surname, middlename, address, contact_number)
        VALUES ('$name', '$surname', '$middlename', '$address', '$contact')";

if (mysqli_query($conn, $sql)) {
    header("Location: ../index.php?status=success&section=create");
} else {
    header("Location: ../index.php?status=error&section=create");
}

mysqli_close($conn);
?>
