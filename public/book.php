<?php
session_start();
include "../includes/config.php";

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "<script>
            alert('Please login to book a ride.');
            window.location='auth/login.html';
          </script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_SESSION['user_id'];
    $pickup  = trim($_POST['pickup']);
    $drop    = trim($_POST['drop']);
    $ride_type = $_POST['ride_type'];
    $ride_time = !empty($_POST['ride_time']) ? $_POST['ride_time'] : NULL;

    // Validation
    if (empty($pickup) || empty($drop)) {
        echo "<script>alert('Please provide pickup and drop addresses.'); window.history.back();</script>";
        exit;
    }

    // Fare calculation
    $base_fare = 100;
    if ($ride_type === 'Premium') {
        $base_fare = 180;
    } elseif ($ride_type === 'Minivan') {
        $base_fare = 160;
    }

    $km = rand(3, 18);
    $estimated_fare = $base_fare + ($km * 12);

    // Insert booking
    $stmt = $conn->prepare(
        "INSERT INTO bookings 
        (user_id, pickup_address, drop_address, ride_type, ride_time, estimated_fare, status)
        VALUES (?, ?, ?, ?, ?, ?, 'pending')"
    );

    $stmt->bind_param(
        "issssd",
        $user_id,
        $pickup,
        $drop,
        $ride_type,
        $ride_time,
        $estimated_fare
    );

    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;

        echo "<script>
            alert(
                'Booking confirmed!\\n' +
                'Booking ID: #$booking_id\\n' +
                'Estimated Fare: ₹$estimated_fare\\n\\n' +
                'Your ride will be confirmed shortly.'
            );
            window.location='dashboard.php';
        </script>";
    } else {
        echo "<script>alert('Booking failed. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
