<?php
session_start();

$lang = $_SESSION['lang'] ?? 'en'; // Lugha ya default ni English

// Ikiwa mtumiaji amechagua lugha mpya kupitia URL (?lang=sw)
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}

// Pata tafsiri kutoka kwenye mafaili
$lang_data = include "lang/{$lang}.php";
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <title><?php echo $lang_data['title']; ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .container {
            background: white;
            margin-top: 60px;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        nav {
            text-align: center;
            margin-bottom: 30px;
        }

        select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 12px 0;
        }

        a {
            text-decoration: none;
            color: #0077cc;
            font-weight: bold;
            transition: color 0.2s;
        }

        a:hover {
            color: #005fa3;
        }

        .lang-select {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
    </style>
    <script>
        function changeLang(sel) {
            const lang = sel.value;
            window.location.href = '?lang=' + lang;
        }
    </script>
</head>
<body>
<div class="container">
    <h2><?php echo $lang_data['welcome']; ?>!</h2>

    <div class="lang-select">
        <label for="language">🌐 <?php echo $lang_data['choose_language'] ?? 'Choose Language'; ?>:</label>&nbsp;
        <select id="language" onchange="changeLang(this)">
            <option value="en" <?php if ($lang === 'en') echo 'selected'; ?>>English</option>
            <option value="sw" <?php if ($lang === 'sw') echo 'selected'; ?>>Kiswahili</option>
            <option value="fr" <?php if ($lang === 'fr') echo 'selected'; ?>>Français</option>
        </select>
    </div>

    <ul>
        <li><a href="book_appointment.php"><?php echo $lang_data['book']; ?></a></li>
        <li><a href="symptom_checker.php"><?php echo $lang_data['symptom_checker']; ?></a></li>
        <li><a href="logout.php"><?php echo $lang_data['logout']; ?></a></li>
    </ul>
</div>
</body>
</html>
