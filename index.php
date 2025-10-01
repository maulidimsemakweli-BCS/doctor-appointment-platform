<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Appointment Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            max-width: 700px;
            margin: 100px auto;
            padding: 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .btn {
            display: inline-block;
            margin: 10px;
            padding: 14px 28px;
            font-size: 16px;
            text-decoration: none;
            color: white;
            border-radius: 8px;
            background-color: #007BFF;
            transition: 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .footer {
            margin-top: 50px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome to Doctor Appointment Management System</h1>
    
    <a href="login.php" class="btn">Login as Patient</a>
    <a href="login.php" class="btn">Login as Doctor</a>
    <a href="login.php" class="btn">Login as Admin</a>
    <a href="register.php" class="btn">Register</a>


    <div class="footer">
        &copy; <?php echo date("Y"); ?> All Rights Reserved. | Developed in PHP & MySQL
    </div>
</div>

</body>
</html>
