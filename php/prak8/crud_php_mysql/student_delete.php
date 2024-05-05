<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit(); // Stop further execution
}

include("connection.php");

if (isset($_GET["nim"])) {
    $nim = $_GET["nim"];

    // Query untuk menghapus mahasiswa dengan NIM tertentu
    $delete_query = "DELETE FROM student WHERE nim = '$nim'";
    $delete_result = mysqli_query($connection, $delete_query);

    if ($delete_result) {
        // Jika penghapusan berhasil
        $message = "Mahasiswa dengan NIM $nim berhasil dihapus.";
        header("Location: student_view.php?message=$message");
    } else {
        // Jika terjadi kesalahan saat menghapus
        $error_message = "Gagal menghapus mahasiswa dengan NIM $nim: " . mysqli_error($connection);
        header("Location: student_view.php?message=$error_message");
    }
} else {
    // Jika tidak ada NIM yang diberikan
    $error_message = "NIM tidak diberikan.";
    header("Location: student_view.php?message=$error_message");
}

mysqli_close($connection);
?>
