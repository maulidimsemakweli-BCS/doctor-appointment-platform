<?php 
session_start();
include('../includes/db.php');

// Hakikisha ni mgonjwa pekee
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'patient') {
    header("Location: ../login.php");
    exit;
}

$patient_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment History</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f4f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th, td {
            padding: 14px 16px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .status-approved {
            background-color: #d4edda;
            color: #155724;
            padding: 6px 10px;
            border-radius: 6px;
            display: inline-block;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            padding: 6px 10px;
            border-radius: 6px;
            display: inline-block;
            font-weight: 500;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
            padding: 6px 10px;
            border-radius: 6px;
            display: inline-block;
            font-weight: 500;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Appointment History for <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>

    <table>
        <tr>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>

        <?php
        $sql = "SELECT a.appointment_date, a.appointment_time, a.status, u.name AS doctor_name
                FROM appointments a
                JOIN users u ON a.doctor_id = u.id
                WHERE a.patient_id = ?
                ORDER BY a.appointment_date DESC, a.appointment_time DESC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo "<tr><td colspan='4'>No appointment history found.</td></tr>";
        } else {
            while ($row = $result->fetch_assoc()) {
                $status = strtolower($row['status']);
                $statusClass = "status-" . $status;
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['doctor_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['appointment_time']) . "</td>";
                echo "<td><span class='$statusClass'>" . ucfirst($status) . "</span></td>";
                echo "</tr>";
            }
        }
        ?>
    </table>

    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
</div>
</body>
</html>
