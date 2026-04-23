<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fidak (BBMS)</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Noto Kufi Arabic', sans-serif;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #333;
            padding: 15px 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .header a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 4px;
            margin: 0 5px;
        }
        .header a.logo {
            font-size: 24px;
            font-weight: 700;
            color: #d32f2f;
        }
        .header a:hover {
            background-color: #ffcdd2;
            color: #333;
        }
        .header a.act {
            background: linear-gradient(135deg, #d32f2f, #f44336);
            color: white;
            border-radius: 4px;
        }
        .header-right {
            float: right;
        }
        @media (max-width: 768px) {
            .header a {
                padding: 10px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="header">
    <a href="home.php" class="logo <?php if (isset($active) && $active == 'home') echo 'logo2'; ?>">Fidak (BBMS)</a>
    <div class="header-right">
        <a href="about_us.php" <?php if (isset($active) && $active == 'about') echo "class='act'"; ?>>About Us</a>
        <a href="why_donate_blood.php" <?php if (isset($active) && $active == 'why') echo "class='act'"; ?>>Why Donate</a>
        <a href="donate_blood.php" <?php if (isset($active) && $active == 'donate') echo "class='act'"; ?>>Donate</a>
        <a href="need_blood.php" <?php if (isset($active) && $active == 'need') echo "class='act'"; ?>>Need Blood</a>
        <a href="contact_us.php" <?php if (isset($active) && $active == 'contact') echo "class='act'"; ?>>Contact</a>
    </div>
</div>
