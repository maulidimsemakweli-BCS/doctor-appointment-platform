<?php 
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'patient') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f7f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }

        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: 500;
        }

        input[type="date"],
        input[type="time"],
        select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 25px;
            transition: 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        .message {
            text-align: center;
            margin-top: 15px;
            padding: 12px;
            border-radius: 6px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        a.back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }

        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book an Appointment</h2>

        <form method="POST">
            <label>Select Doctor:</label>
            <select name="doctor_id" required>
                <option value="">-- Choose Doctor --</option>
                <?php
                $sql = "SELECT id, name FROM users WHERE role = 'doctor'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                }
                ?>
            </select>

            <label>Date:</label>
            <input type="date" name="appointment_date" required>

            <label>Time:</label>
            <input type="time" name="appointment_time" required>

            <button type="submit" name="book">Book Appointment</button>
        </form>

        <?php
        if (isset($_POST['book'])) {
            $patient_id = $_SESSION['user_id'];
            $doctor_id = $_POST['doctor_id'];
            $date = $_POST['appointment_date'];
            $time = $_POST['appointment_time'];

            $check = $conn->prepare("SELECT * FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ?");
            $check->bind_param("iss", $doctor_id, $date, $time);
            $check->execute();
            $check_result = $check->get_result();

            if ($check_result->num_rows > 0) {
                echo "<div class='message error'>This slot is already booked! Please choose another time.</div>";
            } else {
                $stmt = $conn->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiss", $patient_id, $doctor_id, $date, $time);
                if ($stmt->execute()) {
                    echo "<div class='message success'>Appointment booked successfully!</div>";
                } else {
                    echo "<div class='message error'>Error: " . $conn->error . "</div>";
                }
            }
        }
        ?>

        <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>
