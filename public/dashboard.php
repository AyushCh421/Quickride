<?php
session_start();
include "../includes/config.php";

// Protect dashboard
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: auth/login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['name'];
$user_email = $_SESSION['email'];

// Fetch recent bookings
$stmt = $conn->prepare(
    "SELECT * FROM bookings WHERE user_id = ? ORDER BY created_at DESC LIMIT 10"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$bookings = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - QuickRide</title>

  <!-- Global styles -->
  <link rel="stylesheet" href="../assets/css/wdcstyle.css">

  <style>
    .dashboard-header {
      background: var(--card);
      padding: 24px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      margin-bottom: 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
    }

    .user-info h2 { margin: 0 0 4px; }
    .user-info p { color: var(--muted); margin: 0; }

    .logout-btn {
      background: #dc2626;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 700;
    }

    .bookings-table {
      background: var(--card);
      padding: 24px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow-x: auto;
    }

    table { width: 100%; border-collapse: collapse; }

    th, td {
      text-align: left;
      padding: 12px;
      border-bottom: 1px solid var(--border);
    }

    .status-badge {
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 600;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #dbeafe; color: #1e40af; }
    .status-completed { background: #d1fae5; color: #065f46; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    .no-bookings {
      text-align: center;
      padding: 40px;
      color: var(--muted);
    }
  </style>
</head>

<body>
  <div class="container">

    <header>
      <div class="brand">
        <div class="logo">QR</div>
        <div>
          <div style="font-weight:800">QuickRide</div>
          <div style="font-size:15px;color:var(--muted);margin-top:3px">Dashboard</div>
        </div>
      </div>

      <nav>
        <a href="index.php">Home</a>
        <a href="#bookings">My Bookings</a>
        <button class="logout-btn" onclick="logout()">Logout</button>
      </nav>
    </header>

    <div class="dashboard-header">
      <div class="user-info">
        <h2>Welcome, <?php echo htmlspecialchars($user_name); ?> 👋</h2>
        <p><?php echo htmlspecialchars($user_email); ?></p>
      </div>
      <button class="btn" onclick="window.location.href='index.php#book'">
        🚖 Book a New Ride
      </button>
    </div>

    <div class="bookings-table" id="bookings">
      <h3 style="margin-bottom:20px;">Your Recent Bookings</h3>

      <?php if ($bookings->num_rows > 0): ?>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Pickup</th>
              <th>Drop</th>
              <th>Ride</th>
              <th>Date</th>
              <th>Fare</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($booking = $bookings->fetch_assoc()): ?>
              <tr>
                <td>#<?php echo $booking['id']; ?></td>
                <td><?php echo htmlspecialchars(substr($booking['pickup_address'], 0, 30)); ?>…</td>
                <td><?php echo htmlspecialchars(substr($booking['drop_address'], 0, 30)); ?>…</td>
                <td><?php echo htmlspecialchars($booking['ride_type']); ?></td>
                <td>
                  <?php echo $booking['ride_time']
                    ? date('M d, Y H:i', strtotime($booking['ride_time']))
                    : 'ASAP'; ?>
                </td>
                <td>₹<?php echo number_format($booking['estimated_fare'], 2); ?></td>
                <td>
                  <span class="status-badge status-<?php echo $booking['status']; ?>">
                    <?php echo ucfirst($booking['status']); ?>
                  </span>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else: ?>
        <div class="no-bookings">
          <p>You haven't made any bookings yet.</p>
          <button class="btn" onclick="window.location.href='index.php#book'">
            Book Your First Ride
          </button>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script>
    function logout() {
      if (confirm('Are you sure you want to logout?')) {
        window.location.href = 'logout.php';
      }
    }
  </script>
</body>
</html>
