<?php
session_start();
include "../../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address'); window.location='login.html';</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;

            header("Location: ../index.php");
            exit;

        } else {
            echo "<script>alert('Incorrect password'); window.location='login.html';</script>";
        }

    } else {
        echo "<script>alert('User not found'); window.location='login.html';</script>";
    }
}
?>
