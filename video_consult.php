<?php 
session_start();

// Hakikisha user kaingia
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$appointment_id = $_GET['id'] ?? null;
$room_name = "ConsultRoom_" . ($appointment_id ?? "default");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Video Consultation</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }
        .container {
            background: white;
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 95%;
            max-width: 1000px;
        }
        h2 {
            color: #0083b0;
            text-align: center;
        }
        a {
            display: inline-block;
            margin-bottom: 20px;
            color: #0083b0;
            font-weight: bold;
            text-decoration: none;
        }
        iframe {
            width: 100%;
            height: 600px;
            border: none;
            border-radius: 10px;
            margin-top: 20px;
        }
        p {
            margin-top: 20px;
            font-size: 16px;
        }
        .note {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 5px solid #0083b0;
            border-radius: 6px;
        }
        .link {
            background-color: #e0f7fa;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
        .link a {
            color: #006064;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Video Consultation</h2>
    <a href="dashboard.php">← Back to Dashboard</a>
    <hr>

    <iframe 
        src="https://meet.jit.si/<?php echo htmlspecialchars($room_name); ?>" 
        allow="camera; microphone; fullscreen; display-capture"
        allowfullscreen>
    </iframe>

    <div class="note">
        <strong>Note:</strong> PLease make sure camera and sound turned on.
    </div>

    <div class="link">
        Meeting link: 
        <a href="https://meet.jit.si/<?php echo htmlspecialchars($room_name); ?>" target="_blank">
            https://meet.jit.si/<?php echo htmlspecialchars($room_name); ?>
        </a>
    </div>
</div>
</body>
</html>
