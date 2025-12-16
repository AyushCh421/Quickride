<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$userName = $isLoggedIn ? $_SESSION['name'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>QuickRide — Taxi & Cab Service</title>
  <meta name="description" content="QuickRide — fast, reliable taxi booking. Airport transfers, hourly rentals, and city rides." />
  <link rel="stylesheet" href="../assets/css/wdcstyle.css">
</head>
<body>
  <div class="container">
    <header>
      <div class="brand">
        <div class="logo">QR</div>
        <div>
          <div style="font-weight:800">QuickRide</div>
          <div style="font-size:15px;color:var(--muted);margin-top:3px">Taxi • Airport • Corporate</div>
        </div>
      </div>

      <nav>
        <a href="#services">Services</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
        <?php if ($isLoggedIn): ?>
          <a href="dashboard.php" class="btn">Dashboard</a>
          <a href="logout.php" class="btn" style="background: #dc2626;">Logout</a>
          <span style="color: var(--muted); font-weight: 600;">Hi, <?php echo htmlspecialchars($userName); ?>!</span>
        <?php else: ?>
          <a href="auth/login.html" class="btn">Login</a>
          <a href="auth/signup.html" class="btn">Sign Up</a>
        <?php endif; ?>
        <button class="btn" onclick="document.getElementById('book').scrollIntoView({behavior:'smooth'})">Book Now</button>
      </nav>
    </header>

    <section class="hero">
      <div>
        <div class="hero-card">
          <h1>Fast, safe taxi rides — whenever you need one we are here</h1>
          <p class="lead">Airport transfers, on-demand city taxis, and hourly rentals. Transparent fares — no surge surprises.</p>

          <div class="features" id="services">
            <div class="feature">
              <div class="flex"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 13l2-6h13l2 6" stroke="#111" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg><div style="margin-left:10px;font-weight:700">City Rides</div></div>
              <h3>Quick pickups across the city</h3>
            </div>
            <div class="feature">
              <div class="flex"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 7h18M12 7v10" stroke="#111" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg><div style="margin-left:10px;font-weight:700">Airport Transfers</div></div>
              <h3>On-time pickups & flight tracking</h3>
            </div>
            <div class="feature">
              <div class="flex"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v18" stroke="#111" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg><div style="margin-left:10px;font-weight:700">Hourly Hire</div></div>
              <h3>Flexible hourly bookings for errands & events</h3>
            </div>
          </div>

          <div class="space"></div>
          <div class="muted">Why QuickRide?</div>
          <ul style="margin:8px 0 0 18px;color:var(--muted)">
            <li>Easy booking with fixed fares</li>
            <li>Verified drivers & clean cars</li>
            <li>24/7 customer support</li>
          </ul>
        </div>
      </div>

      <aside id="book" class="hero-card">
        <h2 style="margin-top:0">Book a ride</h2>
        <?php if (!$isLoggedIn): ?>
          <div style="background: #fef3c7; padding: 12px; border-radius: 10px; margin-bottom: 16px; font-size: 14px; color: #92400e;">
            ℹ️ Please <a href="login.html" style="color: #92400e; font-weight: 700; text-decoration: underline;">login</a> to book a ride
          </div>
        <?php endif; ?>
        <form id="bookingForm" action="book.php" method="POST" <?php if (!$isLoggedIn) echo 'onsubmit="return redirectToLogin()"'; ?>>
          <div>
            <label for="pickup">Pickup address</label>
            <input id="pickup" name="pickup" type="text" placeholder="e.g., 123 MG Road, City" required />
          </div>
          <div>
            <label for="drop">Drop address</label>
            <input id="drop" name="drop" type="text" placeholder="e.g., Airport, Terminal 2" required />
          </div>
          <div class="form-row">
            <div style="flex:1">
              <label for="rideType">Ride type</label>
              <select id="rideType" name="ride_type">
                <option>Standard</option>
                <option>Premium</option>
                <option>Minivan</option>
              </select>
            </div>
            <div style="width:120px">
              <label for="when">When</label>
              <input id="when" name="ride_time" type="datetime-local" />
            </div>
          </div>

          <div style="display:flex;gap:10px;align-items:center;margin-top:8px">
            <button class="btn" type="submit"><?php echo $isLoggedIn ? 'Estimate & Book' : 'Login to Book'; ?></button>
            <button type="button" onclick="quickEstimate()" style="padding:10px 12px;border-radius:10px;border:1px solid #e6e9ef;background:transparent;font-weight:700">Estimate</button>
          </div>

          <div id="estimate" style="margin-top:12px;color:var(--muted)"></div>
        </form>

        <hr style="margin:14px 0;border:none;border-top:1px solid #f0f0f3" />
        <div style="font-size:13px;color:var(--muted)">Need help? Call <strong>+91 98765 43210</strong></div>
      </aside>
    </section>

    <section class="split">
      <div>
        <h3>Where we operate</h3>
        <div style="border-radius:10px;overflow:hidden">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d32674837.240263276!2d68.17664512276587!3d23.020497770228277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30635ff1f2f6ed93%3A0xd78c4fa444ef3b5a!2sIndia!5e0!3m2!1sen!2sin!4v1631122222222!5m2!1sen!2sin" 
            width="100%" 
            height="260" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy">
          </iframe>
        </div>
      </div>
      <div>
        <h3 id="about">About QuickRide</h3>
        <p class="muted">QuickRide started with a simple idea — reliable rides with transparent pricing. We partner with local drivers and run frequent quality checks so you get a safe and pleasant journey every time.</p>

        <ul style="margin-top:12px;color:var(--muted)">
          <li>Insured vehicles and trained drivers</li>
          <li>Cashless payments available</li>
          <li>Special corporate plans</li>
        </ul>
      </div>
    </section>

    <section id="contact" style="margin-top:18px">
      <div class="hero-card">
        <h3>Contact us</h3>
        <div style="display:grid;grid-template-columns:1fr 320px;gap:18px;margin-top:12px">
          <div>
            <p class="muted">Questions about bookings, corporate accounts, or partnership? Drop us a message below.</p>
            <form id="contactForm" onsubmit="return submitContact(event)">
              <label for="name">Name</label>
              <input id="name" type="text" required />
              <label for="email">Email</label>
              <input id="email" type="email" required />
              <label for="msg">Message</label>
              <textarea id="msg" rows="4" style="width:100%;padding:10px;border-radius:10px;border:1px solid #e6e9ef"></textarea>
              <div style="margin-top:10px"><button class="btn">Send message</button></div>
            </form>
          </div>
          <div style="padding:12px;background:linear-gradient(180deg,#fff,#fbfbff);border-radius:12px;box-shadow:var(--shadow)">
            <div style="font-weight:700">Customer care</div>
            <div class="muted" style="margin-top:8px">support@quickride.example</div>
            <div class="muted" style="margin-top:6px">+91 98765 43210</div>

            <div style="margin-top:12px">
              <div style="font-weight:700">Fleet</div>
              <div class="muted">Sedan • SUV • Minivan</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer style="margin-top:20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap">
      <div style="color:var(--muted)">© <span id="year"></span> QuickRide — All rights reserved.</div>
      <div style="color:var(--muted);font-size:13px">Made with ❤️ • Privacy • Terms</div>
    </footer>
  </div>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();

    function redirectToLogin() {
      alert('Please login first to book a ride');
      window.location.href = 'login.html';
      return false;
    }

    function quickEstimate(){
      const pickup = document.getElementById('pickup').value.trim();
      const drop = document.getElementById('drop').value.trim();
      const type = document.getElementById('rideType').value;
      const el = document.getElementById('estimate');
      
      if(!pickup || !drop){ 
        el.textContent = 'Enter pickup and drop to get estimate.'; 
        return; 
      }
      
      // Placeholder estimate logic
      const base = type === 'Premium' ? 180 : type === 'Minivan' ? 160 : 100;
      const km = Math.floor(Math.random()*15)+3;
      const fare = base + km*12;
      el.textContent = `Approx. ₹${fare} — ${km} km (${type})`;
    }

    function submitContact(e){
      e.preventDefault();
      alert('Message sent — we will reply to your email shortly.');
      document.getElementById('contactForm').reset();
      return false;
    }
  </script>
</body>
</html>
