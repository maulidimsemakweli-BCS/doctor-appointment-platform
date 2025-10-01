<?php
session_start();
include('../includes/db.php');

// Hakikisha ni mgonjwa tu
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'patient') {
    header("Location: ../login.php");
    exit;
}

$patient_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Prescriptions</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f8fb;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #0077cc;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 14px;
            text-align: left;
        }

        th {
            background-color: #0077cc;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f0f4f8;
        }

        tr:hover {
            background-color: #e2e8f0;
        }

        .back-link {
            display: inline-block;
            margin-top: 25px;
            color: #0077cc;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #005fa3;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #555;
            padding: 20px;
            background: #fefefe;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>My Prescriptions</h2>

        <table>
            <tr>
                <th>Doctor</th>
                <th>Date</th>
                <th>Prescription</th>
                <th>Issued On</th>
            </tr>

            <?php
            $sql = "SELECT p.content, p.created_at, a.appointment_date, u.name AS doctor_name
                    FROM prescriptions p
                    JOIN appointments a ON p.appointment_id = a.id
                    JOIN users u ON a.doctor_id = u.id
                    WHERE a.patient_id = ?
                    ORDER BY p.created_at DESC";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $patient_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                echo "<tr><td colspan='4' class='no-data'>No prescriptions available yet.</td></tr>";
            } else {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['doctor_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
                    echo "<td>" . nl2br(htmlspecialchars($row['content'])) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>

        <a class="back-link" href="dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
