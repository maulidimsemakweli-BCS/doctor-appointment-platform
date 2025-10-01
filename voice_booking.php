<?php
session_start();

$doctor_suggestion = "";
$symptoms = $_POST['symptoms'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $symptom_map = [
        "kichwa" => "Neurologist",
        "maumivu ya kifua" => "Cardiologist",
        "homa" => "General Physician",
        "vidonda vya tumbo" => "Gastroenterologist",
        "msongo wa mawazo" => "Psychiatrist",
        "ngozi" => "Dermatologist",
    ];

    foreach ($symptom_map as $keyword => $specialist) {
        if (strpos(strtolower($symptoms), $keyword) !== false) {
            $doctor_suggestion = $specialist;
            break;
        }
    }

    if (!$doctor_suggestion) {
        $doctor_suggestion = "General Physician";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Voice Booking</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #74ebd5, #acb6e5);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .container {
            background: #ffffff;
            margin: 40px auto;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 100%;
        }
        h2 {
            text-align: center;
            color: #007a99;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        textarea, input[type="text"], input[type="date"], input[type="time"] {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }
        button {
            padding: 12px 20px;
            margin-top: 15px;
            margin-right: 10px;
            border: none;
            border-radius: 8px;
            background-color: #007a99;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #005f73;
        }
        .note {
            background-color: #e0f7fa;
            padding: 10px;
            margin-top: 20px;
            border-left: 4px solid #00acc1;
            border-radius: 6px;
        }
        a {
            color: #007a99;
            text-decoration: none;
            font-weight: bold;
        }
        hr {
            margin: 20px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Voice Appointment Booking</h2>
    <a href="dashboard.php">← Back to Dashboard</a>
    <hr>

    <form method="POST">
        <label>Say your symptoms:</label>
        <textarea id="symptoms" name="symptoms" rows="4" placeholder="Say here..." required><?php echo htmlspecialchars($symptoms); ?></textarea>

        <button type="button" onclick="startListening()">🎤 Say your symptoms</button>
        <button type="submit">Send</button>
    </form>

    <script>
    function startListening() {
        if (!('webkitSpeechRecognition' in window)) {
            alert("Your browser not support voice recognition.");
            return;
        }

        const recognition = new webkitSpeechRecognition();
        recognition.lang = "sw-TZ";
        recognition.continuous = false;
        recognition.interimResults = false;

        recognition.onresult = function(event) {
            const result = event.results[0][0].transcript;
            document.getElementById("symptoms").value = result;
        };

        recognition.onerror = function(event) {
            alert("mistake of hear sound: " + event.error);
        };

        recognition.start();
    }
    </script>

    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <div class="note">
            <h3>Suggestions:</h3>
            <p>you are adeviced to see: <strong><?php echo htmlspecialchars($doctor_suggestion); ?></strong></p>
        </div>

        <h3>make Appointment</h3>
        <form method="POST" action="book_appointment.php">
            <input type="hidden" name="symptoms" value="<?php echo htmlspecialchars($symptoms); ?>">
            <label>choose Date:</label>
            <input type="date" name="date" required>

            <label>time:</label>
            <input type="time" name="time" required>

            <label>Doctor (suggestion):</label>
            <input type="text" name="doctor_specialty" value="<?php echo htmlspecialchars($doctor_suggestion); ?>" required>

            <button type="submit">make appointment</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
