# 🚖 QuickRide – Taxi Booking System

QuickRide is a **full-stack PHP & MySQL web application** that allows users to securely register, log in, and book taxi rides with fare estimation and booking history.

This project demonstrates **authentication, session management, database interaction, and clean project structuring**, making it suitable for academic submissions, internships, and portfolio use.

---

## ✨ Features

- User Signup & Login with secure password hashing
- Session-based authentication and route protection
- Taxi booking with estimated fare calculation
- User dashboard showing recent bookings
- Logout functionality
- Clean and responsive UI
- Organized and scalable project structure

---

## 🛠️ Tech Stack

- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **Database:** MySQL  
- **Server:** XAMPP (Apache & MySQL)  

---

## 📁 Project Structure

B240038CS_3/
│
├── assets/
│ ├── css/
│ │ └── wdstyle.css
│ └── images/
│ └── car2.jpg
│
├── database/
│ └── taxiservices.sql
│
├── includes/
│ └── config.php
│
├── public/
│ ├── index.php
│ ├── dashboard.php
│ ├── book.php
│ ├── logout.php
│ │
│ └── auth/
│ ├── login.html
│ ├── signup.html
│ ├── login.php
│ └── signup.php
│
├── README.md
└── .gitignore


---

## ⚙️ How to Run the Project Locally

1. Install **XAMPP**
2. Clone this repository into: C:\xampp\htdocs\B240038CS_3
3. Start **Apache** and **MySQL** from XAMPP Control Panel
4. Open **phpMyAdmin**
5. Create a database named: taxiservices
6. Import the file: database/taxiservices.sql
7. Open your browser and visit: http://localhost/B240038CS_3/public

---

##Run Globally

Live Demo: https://quickride-3ltn.onrender.com  
GitHub Repo: https://github.com/AyushCh421/Quickride

## 🔐 Authentication Flow

- Users must sign up before logging in
- Passwords are stored securely using `password_hash()`
- Protected routes (dashboard & booking) require login
- Sessions are destroyed on logout

---

## 📊 Booking Flow

1. User logs in
2. User enters pickup and drop location
3. Selects ride type and time
4. System calculates estimated fare
5. Booking is saved to database
6. Booking appears on user dashboard

---

## 🧪 Sample Test Credentials

Create a new user using the signup page  
or insert a user manually into the database.

---

## 📌 Important Notes

- This project **cannot be deployed on Vercel** (PHP not supported)
- Recommended hosting platforms:
- Render
- Railway
- InfinityFree / 000webhost
- Designed primarily for **learning and demonstration purposes**

---

## 🚀 Future Improvements

- Payment gateway integration
- Admin dashboard
- Real-time ride tracking
- Conversion to MERN stack (MongoDB, Express, React, Node.js)

---

## 👨‍💻 Author

**Ayush Chauhan**  
B.Tech Student | Web Development Enthusiast  

---

## 📄 License

This project is for educational purposes.

