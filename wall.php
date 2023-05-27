<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: linear-gradient(to right, #c31432, #240b36);
            background-repeat: no-repeat;
            background-size: cover;
        }

        h1 {
            text-align: center;
            color: #fff;
            margin-top: 50px;
        }

        .split {
            height: 100%;
            width: 50%;
            position: fixed;
            z-index: 1;
            top: 100px;
            overflow-x: hidden;
            padding-top: 20px;
        }

        .left {
            left: 0;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .right {
            right: 0;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .centered h2 {
            color: #000;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .centered p {
            color: #000;
            font-size: 16px;
        }

        .navbar {
            background-color: #fff;
        }

        .navbar-brand {
            color: #c31432;
            font-size: 24px;
            font-weight: bold;
        }

        .navbar-brand:hover {
            color: #240b36;
        }

        .navbar-toggler {
            border: none;
        }

        .nav-link {
            color: #000;
        }

        .nav-link:hover {
            color: #c31432;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#">REALITY CHECK</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="display.php">CommonWall</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="history.php">Histoy</a>
            </li>
        </ul>
    </div>
</nav>

<h1>Welcome to the Dashboard</h1>

<div class="split left">
    <div class="centered">
        <h2>Left Section</h2>
        <p>This is the left section of the dashboard.</p>
    </div>
</div>

<div class="split right">
    <div class="centered">
        <h2>Right Section</h2>
        <p>This is the right section of the dashboard.</p>
    </div>
</div>
</body>
</html>
