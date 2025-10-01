<?php 
session_start();
include('../includes/db.php');

// Hakikisha ni mgonjwa pekee
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'patient') {
    header("Location: ../login.php");
    exit;
}

$patient_id = $_SESSION['user_id'];

// Tuma feedback
if (isset($_POST['submit_feedback'])) {
    $appointment_id = $_POST['appointment_id'];
    $rating = $_POST['rating'];
    $comments = trim($_POST['comments']);

    $check = $conn->prepare("SELECT id FROM feedback WHERE appointment_id = ?");
    $check->bind_param("i", $appointment_id);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $msg = "<div class='message error'>Feedback already submitted for this appointment.</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO feedback (appointment_id, rating, comments) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $appointment_id, $rating, $comments);
        if ($stmt->execute()) {
            $msg = "<div class='message success'>Thank you for your feedback!</div>";
        } else {
            $msg = "<div class='message error'>Error: " . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment Feedback</title>
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

        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        textarea {
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 25px;
            transition: 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
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
        <h2>Appointment Feedback</h2>

        <?php if (isset($msg)) echo $msg; ?>

        <form method="POST">
            <label>Select Appointment:</label>
            <select name="appointment_id" required>
                <option value="">-- Choose Past Appointment --</option>
                <?php
                $today = date('Y-m-d');
                $sql = "SELECT a.id, a.appointment_date, u.name AS doctor_name
                        FROM appointments a
                        JOIN users u ON a.doctor_id = u.id
                        WHERE a.patient_id = ? 
                        AND a.status = 'approved' 
                        AND a.appointment_date <= ?
                        ORDER BY a.appointment_date DESC";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $patient_id, $today);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['doctor_name']) . " - " . $row['appointment_date'] . "</option>";
                }
                ?>
            </select>

            <label>Rating (1 - 5):</label>
            <input type="number" name="rating" min="1" max="5" required>

            <label>Comments:</label>
            <textarea name="comments" rows="4" placeholder="Write your feedback here..." required></textarea>

            <button type="submit" name="submit_feedback">Submit Feedback</button>
        </form>

        <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>
