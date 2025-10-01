<?php 
session_start();

$suggestion = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $symptoms = strtolower(trim($_POST['symptoms']));

    //known symptoms
    $symptom_map = [
        "head" => "general Practitioner",
        "chestpain" => "general Practitioner",
        "fever" => "General Physician",
        "ulcers" => "Gastroenterologist",
        "mental problems" => "Psychiatrist",
        "skin" => "Dermatologist",
        "eyes" => "Ophthalmologist"
    ];

    foreach ($symptom_map as $keyword => $specialist) {
        if (strpos($symptoms, $keyword) !== false) {
            $suggestion = $specialist;
            break;
        }
    }

    if (!$suggestion) {
        $suggestion = "Please see General Physician for more consultation.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Symptom Checker</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #74ebd5, #ACB6E5);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 600px;
        }
        h2 {
            color: #0083b0;
            text-align: center;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }
        textarea {
            width: 100%;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            resize: vertical;
        }
        button {
            background-color: #0083b0;
            color: white;
            padding: 14px;
            width: 100%;
            margin-top: 20px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background-color: #005f6b;
        }
        .result {
            margin-top: 30px;
            background-color: #f0f8ff;
            padding: 20px;
            border-left: 5px solid #0083b0;
            border-radius: 8px;
        }
        a {
            text-decoration: none;
            color: #0083b0;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 20px;
        }
        hr {
            border: none;
            height: 1px;
            background-color: #ccc;
            margin: 20px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Symptom Checker</h2>
     <form method="POST">
        <label>Briefly describe your symptoms:</label>
        <textarea name="symptoms" rows="4" placeholder="Example i have headache..." required></textarea>
        <button type="submit">Get Devices</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <div class="result">
            <h3>SUGGESTIONS:</h3>
            <p><strong><?php echo htmlspecialchars($suggestion); ?></strong></p>
        </div>
    <?php endif; ?>
    <a href="dashboard.php">← Back to Dashboard</a>
    <hr>

</div>
</body>
</html>
