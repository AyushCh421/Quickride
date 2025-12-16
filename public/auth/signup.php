<?php
session_start();
include "../../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize inputs
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $pass  = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    $errors = [];

    // Validation
    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address";
    }

    if (empty($phone)) {
        $errors[] = "Phone number is required";
    }

    if (strlen($pass) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }

    if ($pass !== $confirm_pass) {
        $errors[] = "Passwords do not match";
    }

    // Check if email already exists
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors[] = "Email already registered";
        }
        $stmt->close();
    }

    // Insert user if no errors
    if (empty($errors)) {

        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Account created successfully! Please login.');
                    window.location='login.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Registration failed. Please try again.');
                    window.location='signup.html';
                  </script>";
        }
        $stmt->close();

    } else {
        $error_msg = implode("\\n", $errors);
        echo "<script>
                alert('$error_msg');
                window.location='signup.html';
              </script>";
    }
}

$conn->close();
?>
