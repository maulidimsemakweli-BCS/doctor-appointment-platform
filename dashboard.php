<?php 
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'patient') {
    header("Location: ../login.php");
    exit;
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '<span class="scroll-text">WELCOME TO PHYSICIAN SCHEDULING PLATFORM OUR SERVICES AVAILABLE ANY TIME</span>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Patient Dashboard</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background: #f0f0f0;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #007BFF;
      padding: 10px 20px;
      color: white;
    }

    .welcome {
      font-size: 18px;
    }

    .scroll-text {
      display: inline-block;
      white-space: nowrap;
      overflow: hidden;
      animation: scroll-left 10s linear infinite;
      color: yellow;
    }

    @keyframes scroll-left {
      0% { transform: translateX(100%); }
      100% { transform: translateX(-100%); }
    }

    .menu-icon {
      width: 30px;
      height: 25px;
      cursor: pointer;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .menu-icon div {
      height: 4px;
      background: white;
      border-radius: 2px;
    }

    .dropdown {
      display: none;
      position: absolute;
      right: 20px;
      top: 60px;
      background-color: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      border-radius: 6px;
      overflow: hidden;
      z-index: 1000;
    }

    .dropdown a {
      display: block;
      padding: 12px 20px;
      text-decoration: none;
      color: #333;
      border-bottom: 1px solid #eee;
    }

    .dropdown a:hover {
      background-color: #f2f2f2;
    }

    .slideshow {
      width: 100%;
      height: 600px;
      overflow: hidden;
      position: relative;
      margin-top: 10px;
    }

    .slideshow img {
      width: 100%;
      height: 600px;
      object-fit: cover;
      position: absolute;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .slideshow img.active {
      opacity: 1;
    }
  </style>
</head>
<body>

<div class="navbar">
  <div class="welcome">👋 Welcome, <?php echo $username; ?></div>
  <div class="menu-icon" onclick="toggleMenu()">
    <div></div><div></div><div></div>
  </div>
</div>

<div class="dropdown" id="userMenu">
  <a href="symptom_checker.php">🩺 Symptom Checker</a>
  <a href="voice_booking.php">🎤 Voice Booking</a>
  <a href="video_consult.php">📹 Video Consult</a>
  <a href="book_appointment.php">📅 Book Appointment</a>
  <a href="history.php">📖 View History</a>
  <a href="view_prescription.php">💊 View Prescription</a>
  <a href="feedback.php">✍️ Send Feedback</a>
    <a href="payment.php">💰 make payment</a>
  <a href="logout.php">🚪 Logout</a>
</div>

<div class="slideshow">
  <img src="ye.jpeg" class="active">
  <img src="lolo.jpeg">
  <img src="shika.jpeg">
  <img src="holo.jpeg">
</div>

<script>
  function toggleMenu() {
    const menu = document.getElementById('userMenu');
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
  }

  document.addEventListener('click', function(e) {
    const menu = document.getElementById('userMenu');
    const icon = document.querySelector('.menu-icon');
    if (!menu.contains(e.target) && !icon.contains(e.target)) {
      menu.style.display = 'none';
    }
  });

  // Slide show logic
  const slides = document.querySelectorAll('.slideshow img');
  let current = 0;

  setInterval(() => {
    slides[current].classList.remove('active');
    current = (current + 1) % slides.length;
    slides[current].classList.add('active');
  }, 5000); // Change image every 5 seconds
</script>
</body>
</html>
