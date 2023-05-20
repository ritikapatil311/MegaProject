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
        .split {
            height: 100%;
            width: 50%;
            position: fixed;
            z-index: 1;
            top: 100px;
            overflow-x: hidden;
            padding-top: 20px;
        }

        /* Control the left side */
        .left {
            left: 0;
        }

        /* Control the right side */
        .right {
            right: 0;
        }

        /* If you want the content centered horizontally and vertically */
        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        /* Style the image inside the centered container, if needed */
        .centered img {
            width: 150px;
            border-radius: 50%;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding:;
        }

        h1 {
            text-align: center;
        }

        .feed {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .post {
            width: 600px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .post img {
            width: 100%;
            height: auto;
        }

        .post p {
            margin-top: 10px;
            font-size: 14px;
        }

        .logout-btn {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
<div class="pos-f-t">
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
            <h4 class="text-white">REALTIY CHECK</h4>
            <span class="text-muted">society issues are being solved</span>
        </div>
    </div>
    <nav class="navbar navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">REALITY CHECK</a>
    <i style='font-size:24px' class='fab'>&#xf2ae;</i>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="display.php">COMMON WALL <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Post Issue</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="history.php">History</a>
            </li>
        </ul>
    </div>
</nav>

<div class="split left">
    <div class="centered"></div>
</div>

<div class="split right">
    <div class="centered">
        <h2>Jane Flex</h2>
        <p>Some text.</p>
        
    </div>
</div>
</body>
</html>
